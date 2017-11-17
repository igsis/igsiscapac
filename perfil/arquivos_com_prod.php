<?php
if(isset($_POST['apagar']))
{
	$con = bancoMysqli();
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo_com_prod SET publicado = '0' WHERE id = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo))
	{
		$arq = recuperaDados("upload_arquivo_com_prod","id",$idArquivo);
		$mensagem =	"Arquivo ".$arq['arquivo']." apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}

$campo = recuperaDados("evento","id",$_SESSION['idEvento']);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>ARQUIVOS COMUNICAÇÃO - PRODUÇÃO</h3>
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
							echo "O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente<br />";
						}
						else
						{
							$idEvento = $_SESSION['idEvento'];
							$sql = "INSERT INTO `upload_arquivo_com_prod`(`idEvento`, `arquivo`, `publicado`) VALUES ('$idEvento', '$arquivo_base', '1' )";
							mysqli_query($con,$sql);
							gravarLog($sql);
							if( !move_uploaded_file( $arquivoTmp, $arquivo ) )
							{
								$msg[$i] = 'Erro no upload do arquivo '.$i;
							}
							else
							{
								$msg[$i] = sprintf('Upload do arquivo %s foi um sucesso!',$i);
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
					<p> Em caso de envio de fotografia, considerar as seguintes especificações técnicas:<br />
					- formato: horizontal <br />
					- tamanho: mínimo de 300dpi”</p>
					
					<br />
					<div class = "center">
						<form method='POST' action="?perfil=arquivos_com_prod" enctype='multipart/form-data'>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<br>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar' name='enviar'>
						</form>
					</div>
			</div>
		</div>
	</div>
</section>