<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];
$pj = recuperaDados("pessoa_juridica","id",$idPj);
$tipoPessoa = 5;
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;

if(isset($_POST["enviar"]))
{
    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (123,124)";
    $query_arquivos = mysqli_query($con,$sql_arquivos);
    while($arq = mysqli_fetch_array($query_arquivos))
    {
        $idPj = $_SESSION['idPj'];
        $y = $arq['id'];
        $x = $arq['sigla'];
        $nome_arquivo = $_FILES['arquivo']['name'][$x];
        $f_size = $_FILES['arquivo']['size'][$x];

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
                                echo '<script>window.location = "?perfil=arquivos_representante1"</script>';
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
                                        echo '<script>window.location = "?perfil=oficineiro_pj_arquivos_representante"</script>';
                                    }
                                    else{
                                        echo "<script>alert('Houve um erro durante o processamento do arquivo, entre em contato com os administradores do sistema')</script>";
                                    }
                                }
                            }
                        }
                        else
                        {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco!</strong></font>";
                        }
                    }
                    else
                    {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload</strong></font>";
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
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar o arquivo. Tente novamente!</strong></font>";

    }
}

$pj = recuperaDados("pessoa_juridica","id",$idPj);
$evento_pj = recuperaDados("evento","id",$evento);

?>

<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_oficinas.php'; ?>

        <div class="form-group">
            <h4>Arquivos do Representante Legal</h4>
            <p><b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
                            <?php
                            $lista = ($tipoPessoa == 5) ? 14 : 5;
                            listaArquivoCamposMultiplos($idPj,$tipoPessoa,"","oficineiro_pj_arquivos_representante",$lista); ?>
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 1 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <form method="POST" action="?perfil=oficineiro_pj_arquivos_representante" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="50%"><td>
                                    </tr>
                                    <?php
                                    $arquivo1 = ($tipoPessoa == 5) ? 123 : 20;
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$arquivo1'";
                                    $query_arquivos = mysqli_query($con,$sql_arquivos);

                                    while($arq = mysqli_fetch_array($query_arquivos))
                                    {
                                        $doc = $arq['documento'];
                                        $query = "SELECT id FROM upload_lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='$tipoPessoa'";
                                        $envio = $con->query($query);
                                        $row = $envio->fetch_array(MYSQLI_ASSOC);

                                        if(verificaArquivosExistentesPF($idPj,$row['id'], $tipoPessoa)){
                                            echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
                                        }
                                        else{
                                            ?>
                                            <tr>
                                                <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 2 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <table>
                                <tr>
                                    <td width="50%"><td>
                                </tr>
                                <?php
                                $arquivo2 = ($tipoPessoa == 5) ? 124 : 21;
                                $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$arquivo2'";
                                $query_arquivos = mysqli_query($con,$sql_arquivos);
                                while($arq = mysqli_fetch_array($query_arquivos))
                                {
                                    $doc = $arq['documento'];
                                    $query = "SELECT id FROM upload_lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='$tipoPessoa'";
                                    $envio = $con->query($query);
                                    $row = $envio->fetch_array(MYSQLI_ASSOC);

                                    if(verificaArquivosExistentesPF($idPj,$row['id'], $tipoPessoa)){
                                        echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
                                    }
                                    else{
                                        ?>
                                        <tr>
                                            <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table><br>
                            <input type="hidden" name="idPessoa" value="<?php echo $idPj ?>"  />
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

                <!-- Botão -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><strong>O contrato social da empresa exige assinatura de mais um representante legal?</strong><br/><br/></div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <?php
                        if($evento_pj['contratacao'] == 2){ ?>
                            <form class="form-horizontal" role="form" action="?perfil=artista_pj" method="post">
                                <input type="submit" value="Não" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                            </form>
                            <?php
                        }else{ ?>
                            <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_dados_bancarios" method="post">
                                <input type="submit" value="Não" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                            </form>
                        <?php }
                        ?>
                    </div>
                    <div class="col-md-offset-4 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=representante2_pj" method="post">
                            <input type="submit" value="Sim" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                        </form>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                </div>

                <!-- Botão para Voltar e Prosseguir -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=representante1_pj_cadastro" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>