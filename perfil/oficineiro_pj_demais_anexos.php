<?php
$con = bancoMysqli();
$idPj = isset($_SESSION['idPj']) ? $_SESSION['idPj'] : null;
$contador = 0;
$pj = recuperaDados("pessoa_juridica","id",$idPj);
$tipoPessoa = 5;
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;


if(isset($_POST["enviar"]))
{
    $arquivos = "120, 121, 122, 123, 124, 125, 126, 127, 135, 160";
    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN ($arquivos) AND publicado = '1'";
    $query_arquivos = mysqli_query($con,$sql_arquivos);
    while($arq = mysqli_fetch_array($query_arquivos))
    {
        $y = isset($arq['id']) ? $arq['id'] : null;
        $x = isset($arq['sigla']) ? $arq['sigla'] : null;
        $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
        $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

        //Extensões permitidas
        $ext = array("PDF","pdf");
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
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPj', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con,$sql_insere_arquivo);
                        if($query)
                        {
                            if(file_exists($dir.$new_name))
                            {
                                $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                                gravarLog($sql_insere_arquivo);
                                echo '<script>window.location = "?perfil=oficineiro_pj_demais_anexos"</script>';
                            }
                            else
                            {
                                $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idEvento', '$y', '$new_name', '$hoje', '1'); ";
                                $query = mysqli_query($con,$sql_insere_arquivo);

                                if($query)
                                {
                                    if(file_exists($dir.$new_name))
                                    {
                                        $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                                        gravarLog($sql_insere_arquivo);
                                        echo '<script>window.location = "?perfil=arquivos_evento"</script>';
                                    }
                                    else{
                                        echo "<script>alert('Houve um erro durante o processamento do arquivo, entre em contato com os administradores do sistema')</script>";
                                    }
                                }
                            }
                            /*$mensagem = "<font color='#01DF3A'>
                                            <strong>
                                                Arquivo recebido com sucesso!<br>
                                                Seguindo ao próximo passo
                                            </strong>
                                        </font>
                                        <div class='row' style='margin-top: 15px;'>
                                            <div class='col-md-offset-4 col-md-6'>
                                                <div class='progress progress-striped active'>
                                                      <div id='dynamic' class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%'>
                                                        <span id='current-progress'></span>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>";
                            gravarLog($sql_insere_arquivo);

                            echo '<script>
                                    setTimeout(function() {
                                          window.location = "?perfil=final_pj";
                                    }, 3000)
                                </script>'; */
                        }
                        else
                        {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco!</strong></font>";
                        }
                    }
                    else
                    {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload!</strong></font>";
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


$pj = recuperaDados("pessoa_juridica","id",$idPj);
$evento_pj = recuperaDados("evento","id",$evento);
?>


<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include'includes/menu_oficinas.php'; ?>

        <div class="form-group">
            <h4>Demais Anexos</h4>
            <p><b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>

        <!-- Links emissão de documentos -->
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <h6>Gerar Arquivo(s)</h6>
                <p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
                <p align="justify">
                    <a href="https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp" target="_blank">CRF do FGTS</a><br />
                    <a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais (opção: mobiliária)</a><br />
                    <a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/CNDConjuntaSegVia/NICertidaoSegVia.asp?Tipo=1" target="_blank">CND Federal - Certidão Negativa de Débitos Relativos a Créditos Tributários Federais e à Dívida Ativa da União</a><br />
                    <a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/certaut/CndConjunta/ConfirmaAutenticCndSolicitacao.asp?ORIGEM=PJ" target="_blank">Autenticidade de CND ­ Certidão de Débitos Relativos a Créditos Tributários Federais e à Dívida Ativa da União (CND)</a><br />
                    <a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">CADIN Municipal</a>
                    <?php
                    if ($pj['oficineiro'] == 1)
                    {
                        $server = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/";
                        $http = $server."/pdf/";
                        $link1 = $http."rlt_decaracaoaceite_oficineiro.php"."?idPj=".$idPj;
                        ?>
                        <br /><a href='<?= $link1 ?>' target="_blank">Declaração de Aceite</a>
                        <?php
                    }
                    ?>
                </p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
        </div>

        <!-- Exibir arquivos -->
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
                    <?php
                    listaArquivoCamposMultiplos($idPj,$tipoPessoa,"","oficineiro_pj_demais_anexos",16); ?>
                </div>
            </div>
        </div>

        <!-- Upload de arquivo -->
        <div class="form-group">
            <div class="col-md-offset-1 col-md-10">
                <div class = "center">
                    <form method="POST" action="?perfil=oficineiro_pj_demais_anexos" enctype="multipart/form-data">
                        <table class='table table-condensed'>
                            <?php
                            $arquivos = "120, 121, 122, 123, 124, 125, 126, 127, 135, 160";
                            $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN ($arquivos) AND publicado = '1'";
                            $query_arquivos = mysqli_query($con,$sql_arquivos);
                            while($arq = mysqli_fetch_array($query_arquivos))
                            {
                                ?>
                                <tr>
                                <?php
                                $doc = $arq['documento'];
                                $query = "SELECT id FROM upload_lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='$tipoPessoa'";
                                $envio = $con->query($query);

                                $row = $envio->fetch_array(MYSQLI_ASSOC);

                                if(verificaArquivosExistentesPF($idPj,$row['id'], $tipoPessoa)){
                                    echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
                                }
                                else{ ?>
                                    <td><?php echo $arq['documento']?></td>
                                    <td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table><br>
                        <input type="hidden" name="idPessoa" value="<?php echo $idPj; ?>"  />
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

        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
        </div>

        <!-- Botão para Voltar -->
        <div class="form-group">

            <div class="col-md-offset-2 col-md-2">
                <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_arquivos_dados_bancarios" method="post">
                    <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                </form>
            </div>

            <!-- Botão para Avançar -->
            <div class="col-md-offset-4 col-md-2">
                <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_finalizar" method="post">
                    <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
