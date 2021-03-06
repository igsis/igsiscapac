
<?php

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$tipoPessoa = 6;

if(isset($_POST['carregar']))
{
    $_SESSION['idPf'] = $_POST['carregar'];
}


if(isset($_POST["enviar"]))
{
    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (136,137,138)";
    $query_arquivos = mysqli_query($con,$sql_arquivos);
    while($arq = mysqli_fetch_array($query_arquivos))
    {
        $idPf = $_SESSION['idPf'];
        $y = $arq['id'];
        $x = $arq['sigla'];
        $nome_arquivo = $_FILES['arquivo']['name'][$x];
        $f_size = $_FILES['arquivo']['size'][$x];

        //Extensões permitidas
        $ext = array("PDF","pdf");

        if($f_size > 5242880) // 5MB em bytes
        {
            $mensagem = "<font color='#FF0000'>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
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
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con,$sql_insere_arquivo);
                        if($query)
                        {
                            if(file_exists($dir.$new_name))
                            {
                                $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                                gravarLog($sql_insere_arquivo);
                                echo '<script>window.location = "?perfil=formacao_arquivos_pf"</script>';
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
                                        echo '<script>window.location = "?perfil=formacao_arquivos_pf"</script>';
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
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente!</strong></font>";
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
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}


$idPf = $_SESSION['idPf'];

$pf = recuperaDados("pessoa_fisica","id",$idPf);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_formacao.php'; ?>
        <div class="form-group">
            <h4>Arquivos da Pessoa</h4>
            <p><b>Nome:</b> <?php echo $pf['nome']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
                            <?php listaArquivoCamposMultiplos($idPf,$tipoPessoa,"","formacao_arquivos_pf",17); ?>
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 1 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="center">
                            <form method="POST" action="?perfil=formacao_arquivos_pf" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="50%"><td>
                                    </tr>
                                    <?php
                                    if(verificaArquivosExistentesPF($idPf, '136', $tipoPessoa))
                                    {
                                        echo '<div class="alert alert-success">O arquivo RG/RNE/PASSAPORTE já foi enviado.</div> ';
                                    }
                                    else{
                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '136'";
                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
                                        while($arq = mysqli_fetch_array($query_arquivos))
                                        {
                                            ?>
                                            <tr>
                                                <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]' required></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table><br>
                                </td>
                        </div>
                    </div>
                </div>

                <!-- Upload de arquivo 2 -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <form method="POST" action="?perfil=formacao_arquivos_pf" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="50%"><td>
                                    </tr>
                                    <?php
                                    if(verificaArquivosExistentesPF($idPf, '137', $tipoPessoa))
                                    {
                                        echo '<div class="alert alert-success">O arquivo CPF já foi enviado.</div> ';
                                    }
                                    else{
                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '137'";
                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
                                        while($arq = mysqli_fetch_array($query_arquivos))
                                        {
                                            ?>
                                            <tr>
                                                <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]' required></td>
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
                                    <td width="50%"></td>
                                </tr>
                                <?php
                                if(verificaArquivosExistentesPF($idPf, '138', $tipoPessoa))
                                {
                                    echo '<div class="alert alert-success">O arquivo PIS/PASEP/NIT já foi enviado.</div> ';
                                }
                                else{
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '138'";
                                    $query_arquivos = mysqli_query($con,$sql_arquivos);
                                    while($arq = mysqli_fetch_array($query_arquivos))
                                    {
                                        ?>
                                        <tr>
                                            <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]' required></td>
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
                            <form method="POST" action="?perfil=formacao_arquivos_pf" enctype="multipart/form-data">
                                <!-- Fim Upload de arquivo -->
                                <input type="hidden" name="idPessoa" value="<?php echo $idPf ?>"  />
                                <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
                                <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
                            </form>
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

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                    </div>

                    <!-- Botão para Voltar e Prosseguir -->
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-2">
                            <form class="form-horizontal" role="form" action="?perfil=formacao_informacoes_iniciais" method="post">
                                <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                            </form>
                        </div>
                        <div class="col-md-offset-4 col-md-2">
                            <form class="form-horizontal" role="form" action="?perfil=formacao_endereco" method="post">
                                <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</section>