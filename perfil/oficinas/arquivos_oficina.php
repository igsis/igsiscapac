<?php

$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$tipoPessoa = "3";

if(isset($_POST['carregar']))
{
    $_SESSION['idEvento'] = $_POST['carregar'];
    $idEvento = $_SESSION['idEvento'];
}

if(isset($_SESSION['idEvento']))
{
    $idEvento = $_SESSION['idEvento'];
}

if(isset($_POST["enviar"]))
{
    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (23,65,78,96,101,108)";
    $query_arquivos = mysqli_query($con,$sql_arquivos);
    while($arq = mysqli_fetch_array($query_arquivos))
    {
        $y = $arq['id'];
        $x = $arq['sigla'];
        $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
        $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

        //Extensões permitidas
        $ext = array("PDF","pdf");

        if($f_size > 5242880) // 5MB em bytes
        {
            $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></span>";
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
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idEvento', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con,$sql_insere_arquivo);
                        if($query)
                        {
                            if(file_exists($dir.$newname))
                            {
                                $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                                gravarLog($sql_insere_arquivo);
                                echo '<script>window.location = "?perfil=oficinas/arquivos_oficina"</script>';
                            }
                            else
                            {
                                $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idEvento', '$y', '$new_name', '$hoje', '1'); ";
                                $query = mysqli_query($con,$sql_insere_arquivo);

                                if($query)
                                {
                                    if(file_exists($dir.$newname))
                                    {
                                        $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                                        gravarLog($sql_insere_arquivo);
                                        echo '<script>window.location = "?perfil=oficinas/arquivos_oficina"</script>';
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
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar o arquivo. Tente novamente!</strong></font>";
    }
}
?>
<section id="list_items" class="home-section bg-white" xmlns="http://www.w3.org/1999/html">
    <div class="container"><?php include '../perfil/includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h4>Arquivos do Evento</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="alert alert-danger col-md-offset-3 col-sm-6" role="alert"><br><h2><strong>AVISO</strong></h2>Clique nos arquivos após efetuar o upload e confira a exibição do documento!<br>Tamanho máximo permitido: 05 MB.<br><br></div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
                            <?php listaArquivoCamposMultiplos($idEvento,$tipoPessoa,"","arquivos_evento",10); ?>
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 1 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <form method="POST" action="?perfil=oficinas/arquivos_oficina" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="50%"><td>
                                    </tr>
                                    <?php
                                    if(verificaArquivosExistentesEvento($idEvento,'23')) //true
                                    {
                                        echo '<div class="alert alert-success">O arquivo repertório já foi enviado.</div> ';
                                    }
                                    /*
                                        Retorna verdadeiro se encontra algum resultado.
                                        Deve ser feito uma condicional que oculta os campos, caso já tenha algo preenchido
                                    */
                                    else{
                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '23'";
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
                                if(verificaArquivosExistentesEvento($idEvento,'65')){
                                    echo '<div class="alert alert-success">O arquivo Material de imprensa (clipping) já foi enviado.</div>';
                                }
                                else{
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '65'";
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
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 3 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <table>
                                <tr>
                                    <td width="50%"><td>
                                </tr>
                                <?php
                                if(verificaArquivosExistentesEvento($idEvento,'78'))
                                {
                                    echo '<div class="alert alert-success">O arquivo Autorização SBAT já foi enviado. </div>';
                                }
                                else
                                {
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '78'";
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
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 4 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <table>
                                <tr>
                                    <td width="50%"><td>
                                </tr>
                                <?php
                                if(verificaArquivosExistentesEvento($idEvento,'96'))
                                {
                                    echo '<div class="alert alert-success">O arquivo Currículo do Grupo já foi enviado.</div> ';
                                }
                                else{
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '96'";
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
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 5 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <table>
                                <tr>
                                    <td width="50%"><td>
                                </tr>
                                <?php
                                if(verificaArquivosExistentesEvento($idEvento,'108'))
                                {
                                    echo '<div class="alert alert-success">O arquivo Documentos Comprobatórios já foi enviado.</div> ';
                                }
                                else{
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '108'";
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
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 6 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <table>
                                <tr>
                                    <td width="50%"><td>
                                </tr>
                                <?php
                                if(verificaArquivosExistentesEvento($idEvento,'101'))
                                {
                                    echo '<div class="alert alert-success">O arquivo DRT dos Integrantes já foi enviado.</div>';
                                }
                                else{
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '101'";
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
                            <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
                        </div>
                    </div>
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
            </div>
        </div>
    </form>
        <div class="col-md-offset-2 col-md-8">
            <hr/>
        </div>
        <div class="form-group">
            <div class="col-md-offset-1 col-md-12">
                <div class="col-md-offset-1 col-md-2">
                    <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_edicao" method="post">
                        <input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                    </form>
                </div>
                <div class="col-md-offset-4 col-md-2">
                    <form class="form-horizontal" role="form" action="?perfil=oficinas/produtor_oficina" method="post">
                        <input type="submit" value="Avançar" class="btn btn-theme btn-md btn-block">
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>