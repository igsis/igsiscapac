<?php
if(isset($_POST['apagar']))
{
    $con = bancoMysqli();
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo_com_prod SET publicado = '0' WHERE id = '$idArquivo'";
    if(mysqli_query($con,$sql_apagar_arquivo))
    {
        $arq = recuperaDados("upload_arquivo_com_prod","id",$idArquivo);
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar o arquivo. Tente novamente!</strong></font>";
    }
}

$campo = recuperaDados("evento","id",$_SESSION['idEvento']);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h4>Arquivos Para Comunicação e Produção</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
            <?php
            if( isset( $_POST['enviar'] ) )
            {
                $pathToSave = '../uploads/';
                $i = 0;
                $msg = array( );
                $arquivos = array( array( ) );
                foreach(  $_FILES as $key=>$info )
                {
                    foreach( $info as $key=>$dados )
                    {
                        for( $i = 0; $i < sizeof( $dados ); $i++ )
                        {
                            $arquivos[$i][$key] = $info[$key][$i];
                        }
                    }
                }
                $i = 1;

                foreach( $arquivos as $file )
                {
                    if( $file['name'] != '' )
                    {
                        $con = bancoMysqli();
                        $dataUnique = date('YmdHis');
                        $arquivoTmp = $file['tmp_name'];
                        $arquivo = $pathToSave.$dataUnique."_".semAcento($file['name']);
                        $arquivo_base = $dataUnique."_".semAcento($file['name']);
                        if(file_exists($arquivo))
                        {
                            echo "<font color='#01DF3A'><strong>O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente</strong></font><br />";
                        }
                        else
                        {
                            $idEvento = $_SESSION['idEvento'];
                            $sql = "INSERT INTO `upload_arquivo_com_prod`(`idEvento`, `arquivo`, `publicado`) VALUES ('$idEvento', '$arquivo_base', '1' )";
                            mysqli_query($con,$sql);
                            if( !move_uploaded_file( $arquivoTmp, $arquivo ) )
                            {
                                $msg[$i] = 'Erro no upload do arquivo '.$i;
                            }
                            else
                            {
                                $msg[$i] = sprintf('Upload do arquivo %s foi um sucesso!',$i);
                                gravarLog($sql);
                                echo '<script>window.location = "?perfil=arquivos_com_prod"</script>';
                            }
                        }
                    }
                    $i++;
                }
                // Imprimimos as mensagens geradas pelo sistema
                foreach( $msg as $e )
                {
                    echo " <div id = 'mensagem_upload'>";
                    printf('%s<br>', $e);
                    echo " </div>";
                }
            }
            ?>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="table-responsive list_info">
                    <?php listaArquivos($_SESSION['idEvento']); ?>
                </div>
                <h3>Envio de Arquivos</h3>
                <p align="justify">Nesta página você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, entre outros arquivos destinados à comunicação e produção. O tamanho máximo do arquivo deve ser 60MB.</p>
                <p>Não envie cópias de documentos nesta página.</p>
                <p>Solicitamos que envie no mínimo <font color='#FF0000'><strong>2 fotos</strong></font> para divulgação.</p>
                <p> Em caso de envio de fotografia, considerar as seguintes especificações técnicas:<br />
                    - formato: horizontal <br />
                    - tamanho: mínimo de 300dpi”</p>

                <br />
                <div class="alert alert-danger"><strong>Atenção:</strong> Os arquivos para upload devem ter nomes diferentes.</div>
                <div class = "center">
                    <form method='POST' action="?perfil=arquivos_com_prod" enctype='multipart/form-data'>
                        <?php
                        if(verificaArquivosExistentesComunicacao($_SESSION['idEvento']) >= 5){}
                        else{
                        ?>
                        <p><input type='file' name='arquivo[]'></p>
                        <p><input type='file' name='arquivo[]'></p>
                        <p><input type='file' name='arquivo[]'></p>
                        <p><input type='file' name='arquivo[]'></p>
                        <p><input type='file' name='arquivo[]'></p>
                        <br>
                        <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar' name='enviar'>
                    </form>
                    <?php } ?>
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
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><hr/>
            </div>
        </div>

        <!-- Botão para Voltar e Prosseguir -->
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <div class="col-md-offset-1 col-md-2">
                    <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_produtor_edicao" method="post">
                        <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                    </form>
                </div>
                    <div class="col-md-offset-6 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_finalizar" method="post">
                            <input type="submit" value="Finalizar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                        </form>
                    </div>
            </div>
        </div>

    </div>
</section>