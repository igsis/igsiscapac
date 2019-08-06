<?php
$con = bancoMysqli();
$idPf = $_SESSION['idPf'];

$idCampo = 140;
$tipoPessoa = 6;

if(isset($_POST['cadastrarFisica']))
{
    $idPf = $_POST['cadastrarFisica'];
    $Drt = $_POST['drt'];
    $etnia = $_POST['etnia'];
    $grauInstrucao = $_POST['grauInstrucao'];
    $funcaoFormacao = $_POST['funcaoFormacao'];
    $linguagem = $_POST['linguagem'];
    $regiaoPrefencial = $_POST['regiaoPreferencial'];
    $funcaoFormacao2 = $_POST['funcaoFormacao2'] ?? null;
    $funcaoFormacao3 = $_POST['funcaoFormacao3'] ?? null;

    $sql_atualiza_complementares = "UPDATE pessoa_fisica SET
	`drt` = '$Drt',
	`etnia_id` = '$etnia',
	`grau_instrucao_id` = '$grauInstrucao',
	`formacao_funcao_id` = '$funcaoFormacao',
    `formacao_linguagem_id` = '$linguagem',
    `formacao_regiao_preferencial` = '$regiaoPrefencial'
	WHERE `id` = '$idPf'";

    if (mysqli_query($con,$sql_atualiza_complementares))
    {
        $numRegistros = $con->query("SELECT id FROM formacao_dados_complementares WHERE pessoa_fisica_id = '$idPf'")->num_rows;

        if ($funcaoFormacao2 != null) {
            if ($numRegistros == 0) {
                $query = "INSERT INTO formacao_dados_complementares (pessoa_fisica_id, area_atuacao_2, area_atuacao_3)
                          VALUES ('$idPf', '$funcaoFormacao2', '$funcaoFormacao3')";
            } else {
                $query = "UPDATE formacao_dados_complementares SET
                            area_atuacao_2 = '$funcaoFormacao2',
                            area_atuacao_3 = '$funcaoFormacao3'
                          WHERE pessoa_fisica_id = '$idPf'";
            }
            if ($con->query($query)) {
                gravarLog($query);
            }
        } elseif ($numRegistros > 0) {
            $query = "DELETE FROM formacao_dados_complementares WHERE pessoa_fisica_id = '$idPf'";
            $con->query($query);

            if ($con->query($query)) {
                gravarLog($query);
            }
        }
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_atualiza_complementares);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}


if(isset($_POST["enviar"]))
{
    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
    $query_arquivos = mysqli_query($con,$sql_arquivos);
    while($arq = mysqli_fetch_array($query_arquivos))
    {
        $y = $arq['id'];
        $x = $arq['sigla'];
        $nome_arquivo = $_FILES['arquivo']['name'][$x];
        $f_size = $_FILES['arquivo']['size'][$x];
        $ext = array("PDF","pdf"); //Extensões permitidas

        if($f_size > 5242880) // 5MB em bytes
        {
            $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
        }
        else
        {
            if($nome_arquivo != "")
            {
                $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                $hoje = date("Y-m-d H:i:s");
                $dir = '../uploadsdocs/'; //Diretório para uploads
                $allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
                $ext = strtolower(substr($nome_arquivo,-4));

                if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas/
                {
                    if(move_uploaded_file($nome_temporario, $dir.$new_name))
                    {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$idCampo', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con,$sql_insere_arquivo);
                        if($query)
                        {
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                            gravarLog($sql_insere_arquivo);
                            echo '<script>window.location = "?perfil=formacao_informacoes_complementares"</script>';
                        }
                        else
                        {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco!</strong></font>";
                        }
                    }
                    else
                    {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
                    }
                }
                else
                {
                    $mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
                }
            }
        }
    }
}

if(isset($_POST['apagar']))
{
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE id = '$idArquivo'";
    if(mysqli_query($con,$sql_apagar_arquivo))
    {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo! Tente novamente.</strong></font>";
    }
}


$pf = recuperaDados("pessoa_fisica","id",$idPf);
$pfComplementar = recuperaDados("formacao_dados_complementares","pessoa_fisica_id",$idPf);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_formacao.php'; ?>
        <div class="form-group">
            <h3>Informações Complementares</h3>
            <p><b>Nome:</b> <?php echo $pf['nome']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form class="form-horizontal" role="form" action="?perfil=formacao_informacoes_complementares" method="post">

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>DRT:</strong><br/>
                            <input type="text" class="form-control" name="drt" placeholder="DRT caso for teatro, dança ou circo" maxlength="15" value="<?php echo $pf['drt']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>Região de preferência para atuação:</strong><br/>
                            <select name="regiaoPreferencial" id="regiaoPreferencial" class="form-control" required>
                                <option value="">Selecione...</option>
                                <?php geraOpcao('regioes', $pf['formacao_regiao_preferencial']); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4"><strong>Etnia:</strong><br/>
                            <select name="etnia" id="etnia" class="form-control" required>
                                <option value="">Selecione...</option>
                                <?php geraOpcao('etnias', $pf['etnia_id']) ?>
                            </select>
                        </div>
                        <div class="col-md-4"><strong>Grau de Instrução:</strong><br/>
                            <select name="grauInstrucao" id="grauInstrucao" class="form-control" required>
                                <option value="">Selecione...</option>
                                <?php geraOpcao('grau_instrucoes', $pf['grau_instrucao_id']) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4"><strong>Linguagem:</strong><br/>
                            <select name="linguagem" id="linguagem" class="form-control" required>
                                <option value="">Selecione...</option>
                                <?php geraOpcaoFormacao($pf['formacao_linguagem_id'], $pf['tipo_formacao_id'], 'formacao_linguagem') ?>
                            </select>
                        </div>
                        <div class="col-md-4"><strong>Função (1º Opção):</strong><br/>
                            <select name="funcaoFormacao" id="funcaoFormacao" class="form-control" required onchange="funcaoPreferencial('<?=$pf['tipo_formacao_id']?>')">
                                <option value="">Selecione...</option>
                                <?php geraOpcaoFormacao($pf['formacao_funcao_id'], $pf['tipo_formacao_id']) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display: none" id="funcaoPreferencial">
                        <div class="col-md-offset-2 col-md-4"><strong>Função (2º Opção):</strong><br/>
                            <select name="funcaoFormacao2" id="funcaoFormacao2" class="form-control">
                                <option value="">Selecione...</option>
                                <?php geraOpcaoFormacao($pfComplementar['area_atuacao_2'], $pf['tipo_formacao_id']) ?>
                            </select>
                        </div>
                        <div class="col-md-4"><strong>Função (3º Opção):</strong><br/>
                            <select name="funcaoFormacao3" id="funcaoFormacao3" class="form-control">
                                <option value="">Selecione...</option>
                                <?php geraOpcaoFormacao($pfComplementar['area_atuacao_3'], $pf['tipo_formacao_id']) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="cadastrarFisica" value="<?php echo $idPf ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
                            <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
                        </div>
                    </div>
                </form>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                </div>

                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
                            <?php listaArquivoCamposMultiplos($idPf,$tipoPessoa,$idCampo,"formacao_informacoes_complementares",3); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <form method="POST" action="?perfil=formacao_informacoes_complementares" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="45%"><td>
                                    </tr>
                                    <?php
                                    if(verificaArquivosExistentesPF($idPf,$idCampo, $tipoPessoa)){
                                        echo '<div class="alert alert-success">O arquivo DRT foi enviado.</div> ';
                                    }
                                    else{
                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
                                        while($arq = mysqli_fetch_array($query_arquivos))
                                        {
                                            ?>
                                            <tr>
                                                <td><label><?php echo $arq['documento']?></label></td>
                                                <td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table><br>
                                <input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"  />
                                <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
                                <input type="hidden" name="enviar" value="1"  />
                                <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar'>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                </div>

                <!-- Confirmação de Exclusão -->
                <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Excluir Arquivo?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Confirma?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="confirm">Apagar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Confirmação de Exclusão -->

                <!-- Botão para Voltar e Prosseguir -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=formacao_endereco" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                        </form>
                    </div>
                    <div class="col-md-offset-4 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=formacao_dados_bancarios" method="post">
                            <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>


    function funcaoPreferencial(tipoFormacao) {
        let funcao = document.getElementById('funcaoFormacao').value;
        let funcaoPreferencial = document.getElementById('funcaoPreferencial');
        let selects = funcaoPreferencial.querySelectorAll('select');
        let funcoes = ["1", "2", "3", "5", "6", "7"];

        if (funcoes.includes(funcao)) {
            funcaoPreferencial.removeAttribute("style");
            funcaoPreferencial.removeAttribute("disabled");

            for (let i in selects) {
                selects[i].remove(4);
                selects[i].removeAttribute("disabled");
                selects[i].setAttribute("required", true)
            }
        } else {
            funcaoPreferencial.setAttribute("style", "display: none;");

            for (let i in selects) {
                selects[i].removeAttribute("required")
                selects[i].setAttribute("disabled", true)
            }
        }
    }
</script>

<?php echo "<script>window.onload = funcaoPreferencial('".$pf['tipo_formacao_id']."');</script>"; ?>