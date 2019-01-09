<?php

$con = bancoMysqli();

if (isset($_SESSION['idPf']))
{
    $id = $_SESSION['idPf'];
    $tabela = "pessoa_fisica";
    $tipoPessoa = 4;
}
elseif (isset($_SESSION['idPj']))
{
    $id = $_SESSION['idPj'];
    $tabela = "pessoa_juridica";
    $tipoPessoa = 5;
}
$pessoa = recuperaDados($tabela,"id",$id);
$idCampo = ($tipoPessoa == 4) ? 134 : 135;

$consulta = "SELECT * FROM `oficina_dados` WHERE `tipoPessoa` = '$tipoPessoa' AND `idPessoa` = '$id' AND `publicado` = '1'";
$dados = $con->query($consulta)->fetch_assoc();

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

                if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
                {
                    if(move_uploaded_file($nome_temporario, $dir.$new_name))
                    {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$id', '$idCampo', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con,$sql_insere_arquivo);
                        if($query)
                        {
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                            gravarLog($sql_insere_arquivo);
                        }
                        else
                        {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
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

$pessoa = recuperaDados($tabela,"id",$id);
$dadosOficineiro = recuperaDados('oficina_dados', 'id', $dados['id']);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_oficinas.php'; ?>
        <div class="form-group">
            <h3>Cronograma de Oficinas</h3>
            <p><b>Nome:</b> <?= ($tipoPessoa == 4) ? $pessoa['nome'] : $pessoa['razaoSocial']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form name="form1" class="form-horizontal" role="form" action="../pdf/rlt_cronograma_oficina.php" method="post" target="_blank">

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label for="nomeOficina">Nome da Oficina: *:</label>
                            <input type="text" class="form-control" name="nomeOficina" id="nomeOficina" maxlength="240" value="<?= $dadosOficineiro['nomeOficina'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label for="sinopseOficina">Sinopse *</label>
                            <p><label>Esse campo deve conter uma breve descrição da oficina que será apresentada.</i></strong></label></p>
                            <textarea id="sinopseOficina" name="sinopseOficina" class="form-control" rows="10" required><?= $dadosOficineiro['sinopseOficina'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label for="modalidade">Modalidade *:</label> <button class='btn btn-default btn-sm' type='button' data-toggle='modal' data-target='#infoModalidade' style="border-radius: 15px;"><i class="fa fa-question-circle"></i></button>
                            <select class="form-control" name="modalidade" id="modalidade" required>
                                <option value="">Selecione...</option>
                                <?php geraOpcao('modalidades', $dadosOficineiro['modalidade_id']) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="gerarCronograma">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="tipoPessoa" value="<?= $tipoPessoa ?>">
                            <input type="hidden" name="idDadosOficineiro" value="<?= $dadosOficineiro['id'] ?>">
                            <input type="submit" value="Gerar Cronograma para Preenchimento" class="btn btn-theme btn-lg btn-block">
                        </div>
                    </div>
                </form>

                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
                            <?php listaArquivoCamposMultiplos($id,$tipoPessoa,$idCampo,"oficinas_cronograma",3); ?>
                        </div>
                    </div>
                </div>
                <!-- Upload de arquivo -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <form method="POST" action="?perfil=oficinas_cronograma" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="50%"><td>
                                    </tr>
                                    <?php
                                    if(verificaArquivosExistentesPF($id,$idCampo, $tipoPessoa)){
                                        echo '<div class="alert alert-success">O arquivo Cronograma de Oficinas foi enviado.</div> ';
                                    }
                                    else{
                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
                                        while($arq = mysqli_fetch_array($query_arquivos))
                                        {
                                            ?>
                                            <tr>
                                                <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table><br>
                                <input type="hidden" name="idPessoa" value="<?php echo $id; ?>"  />
                                <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
                                <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fim Upload de arquivo -->
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

                <div class="modal fade" id="infoModalidade" role="dialog" aria-labelledby="infoModalidadeLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Informações para a Escolha da Modalidade</h4>
                            </div>
                            <div class="modal-body">
<!--                                style="text-align: left;"-->
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="50%"><strong>Modalidade I:</strong> Oficinas de Curta Duração</td>
                                            <td width="50%" class="text-center">1 mês de atividade</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Modalidade II:</strong> Oficinas de Média Duração I</td>
                                            <td width="50%" class="text-center">3 mês de atividade</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Modalidade III:</strong> Oficinas de Média Duração II</td>
                                            <td width="50%" class="text-center">4 mês de atividade</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Modalidade IV:</strong> Oficinas Estendida I</td>
                                            <td width="50%" class="text-center">6 mês de atividade</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Modalidade V:</strong> Oficinas Estendida II</td>
                                            <td width="50%" class="text-center">10 mês de atividade</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                </div>

                <!-- Botão para Voltar e Prosseguir -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="<?= ($tipoPessoa == 4) ? "?perfil=oficineiro_pf_arquivos_dados_bancarios" : "?perfil=oficineiro_pj_arquivos_dados_bancarios"?>" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $id ?>">
                        </form>
                    </div>
                    <div class="col-md-offset-4 col-md-2">
                        <form class="form-horizontal" role="form" action="<?= ($tipoPessoa == 4) ? "?perfil=oficineiro_pf_anexos" : "?perfil=oficineiro_pj_demais_anexos"?>" method="post">
                            <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $id ?>">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>