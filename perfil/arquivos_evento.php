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
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (23,65,78,96)";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];

		//Extensões permitidas
		$ext = array("PDF","pdf");

		if($f_size > 3145728) // 3MB em bytes
		{
			$mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 03 MB.</strong></font>";
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
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);
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
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>PASSO 2: Arquivos do Evento</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
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
						<form method="POST" action="?perfil=arquivos_evento" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php						
									if(verificaArquivosExistentesEvento($idEvento,'23')) //true
									{
										echo 'O arquivo repertório já foi enviado. ';
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
							</table><br>
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
										echo 'O arquivo Material de imprensa (clipping) já foi enviado.';
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
									echo 'O arquivo Autorização SBAT já foi enviado. ';
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
									echo 'O arquivo Currículo do Grupo já foi enviado. ';
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
							<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include '../perfil/includes/menu_evento_footer.php'; ?>
	</div>
</section>