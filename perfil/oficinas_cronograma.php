<?php

$con = bancoMysqli();
$idOficina = $_SESSION['idEvento'];

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

if ((isset($_POST['cadastrar']) || (isset($_POST['atualizar']))))
{
    $idModalidade = $_POST['modalidade'];
    $idOficina = $_POST['idOficina'];
    $tabela = ($_POST['tipoPessoa'] == 4) ? "pessoa_fisica" : "pessoa_juridica";
    $dataInicio = exibirDataMysql($_POST['dataInicio']);
    $dataFim = exibirDataMysql($_POST['dataFim']);
    $dia1 = $_POST['dia1'];
    $dia2 = $_POST['dia2'];

    $modalidade = recuperaDados('modalidades', 'id', $idModalidade);
    $oficineiro = recuperaDados($tabela, 'id', $_POST['id']);
    $nome = ($_POST['tipoPessoa'] == 4) ? $oficineiro['nome'] : $oficineiro['razaoSocial'];

    if ($_POST['tipoPessoa'] == 4)
    {
        $documento = $oficineiro['rg'];
    }
    else
    {
        $representante = recuperaDados('representante_legal', 'id', $oficineiro['idRepresentanteLegal1']);
        $documento = $representante['rg'];
    }

    if (isset($_POST['atualizar'])) {
        $sql_dados = "UPDATE `oficina_dados_complementares` SET modalidade_id = '$idModalidade', dataInicio = '$dataInicio', dataFim = '$dataFim', dia1 = '$dia1', dia2 = '$dia2' WHERE oficina_id = '$idOficina'";
    } else {
        $sql_dados = "INSERT INTO `oficina_dados_complementares` (oficina_id, modalidade_id, dataInicio, dataFim, dia1, dia2) VALUES ('$idOficina', '$idModalidade', '$dataInicio', '$dataFim', '$dia1', '$dia2')";
    }
    $query = $con->query($sql_dados);
    if ($query)
    {
        gravarLog($sql_dados);
        $mensagem = "<span style=\"color: #01DF3A; \"><strong>Atualizado com sucesso!</strong></span>";
    }
    else
    {
        $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao gravar!</strong></span>";
    }
}

/*
INICIO DO BLOCO DE ENVIO DE CRONOGRAMA (DESATIVADO DIA 22/01
    $idCampo = ($tipoPessoa == 4) ? 134 : 135;

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
FIM DO BLOCO DE ENVIO DE CRONOGRAMA
*/

$sqlConsulta = "SELECT * FROM `oficina_dados_complementares` WHERE `oficina_id` = '$idOficina'";
$consulta = $con->query($sqlConsulta);
$acao = ($consulta->num_rows == 0) ? "cadastrar" : "atualizar";

$dadosOficineiro = recuperaDados('oficina_dados_complementares', 'oficina_id', $idOficina);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h3>Informações Complementares da Oficinas</h3>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form name="form1" class="form-horizontal" role="form" action="?perfil=oficinas_cronograma" method="post">

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
                        <div class="row">
                            <label>Período</label>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-4">
                                <label for="datepicker01">Data de Inicio *:</label>
                                <input class="form-control" type="text" name="dataInicio" id="datepicker01" value="<?= ($dadosOficineiro['dataInicio'] == null) ? "" : exibirDataBr($dadosOficineiro['dataInicio']) ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="datepicker02">Data de Fim *:</label>
                                <input class="form-control" type="text" name="dataFim" id="datepicker02" value="<?= ($dadosOficineiro['dataFim'] == null) ? "" : exibirDataBr($dadosOficineiro['dataFim']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label>Dias de Execução</label>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-4">
                                <label>Dia 1 *:</label>
                                <select class="form-control " name="dia1" id="dia1" required>
                                    <option value="">Selecione...</option>
                                    <?php geraOpcao('dia_semanas', $dadosOficineiro['dia1']) ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Dia 2:</label>
                                <select class="form-control" name="dia2" id="dia2">
                                    <option value="">Selecione...</option>
                                    <?php geraOpcao('dia_semanas', $dadosOficineiro['dia2']) ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="gerarCronograma">
                            <input type="hidden" name="idOficina" value="<?= $idOficina ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="tipoPessoa" value="<?= $tipoPessoa ?>">
                            <input type="hidden" name="idDadosOficineiro" value="<?= $dadosOficineiro['id'] ?>">
                            <input type="submit" name="<?=$acao?>" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
                        </div>
                    </div>
                </form>

                <!-- Exibir arquivos -->
<!--                <div class="form-group">-->
<!--                    <div class="col-md-offset-2 col-md-8">-->
<!--                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>-->
<!--                            --><?php //listaArquivoCamposMultiplos($id,$tipoPessoa,$idCampo,"oficinas_cronograma",3); ?>
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!-- Upload de arquivo -->
<!--                <div class="form-group">-->
<!--                    <div class="col-md-offset-2 col-md-8">-->
<!--                        <div class = "center">-->
<!--                            <form method="POST" action="?perfil=oficinas_cronograma" enctype="multipart/form-data">-->
<!--                                <table>-->
<!--                                    <tr>-->
<!--                                        <td width="50%"><td>-->
<!--                                    </tr>-->
<!--                                    --><?php
//                                    if(verificaArquivosExistentesPF($id,$idCampo, $tipoPessoa)){
//                                        echo '<div class="alert alert-success">O arquivo Cronograma de oficinas foi enviado.</div> ';
//                                    }
//                                    else{
//                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
//                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
//                                        while($arq = mysqli_fetch_array($query_arquivos))
//                                        {
//                                            ?>
<!--                                            <tr>-->
<!--                                                <td><label>--><?php //echo $arq['documento']?><!--</label></td><td><input type='file' name='arquivo[--><?php //echo $arq['sigla']; ?><!--]'></td>-->
<!--                                            </tr>-->
<!--                                            --><?php
//                                        }
//                                    }
//                                    ?>
<!--                                </table><br>-->
<!--                                <input type="hidden" name="idPessoa" value="--><?php //echo $id; ?><!--"  />-->
<!--                                <input type="hidden" name="tipoPessoa" value="--><?php //echo $tipoPessoa; ?><!--"  />-->
<!--                                <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>-->
<!--                            </form>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!-- Fim Upload de arquivo -->
                <!-- Confirmação de Exclusão -->
<!--                <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">-->
<!--                    <div class="modal-dialog">-->
<!--                        <div class="modal-content">-->
<!--                            <div class="modal-header">-->
<!--                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--                                <h4 class="modal-title">Excluir Arquivo?</h4>-->
<!--                            </div>-->
<!--                            <div class="modal-body">-->
<!--                                <p>Confirma?</p>-->
<!--                            </div>-->
<!--                            <div class="modal-footer">-->
<!--                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>-->
<!--                                <button type="button" class="btn btn-danger" id="confirm">Apagar</button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
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
                                            <td width="50%" class="text-center">1 mês a 4 meses de atividades</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Modalidade II:</strong> Oficinas Estendidas</td>
                                            <td width="50%" class="text-center">5 meses a 10 meses de atividades</td>
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
                        <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_edicao" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $id ?>">
                        </form>
                    </div>
                    <div class="col-md-offset-4 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_arquivos_com_prod" method="post">
                            <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $id ?>">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>