<?php
$con = bancoMysqli();
$idEvento = $_SESSION['idEvento'];
$tipoPessoa = '3';


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (99,100,101,102)";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idEvento', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							if(file_exists($dir.$newname))
							{
								$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
								gravarLog($sql_insere_arquivo);
								echo '<script>window.location = "?perfil=arquivos_grupo"</script>';
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
										echo '<script>window.location = "?perfil=arquivos_grupo"</script>';
									}
									else{
										echo "<script>alert('Houve um erro durante o processamento do arquivo, entre em contato com os administradores do sistema')</script>";
									}
								}
							}
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
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

$sql_grupos = "SELECT * FROM grupo WHERE idEvento = '$idEvento' AND publicado = '1'";
$query_grupos = mysqli_query($con,$sql_grupos);
$num = mysqli_num_rows($query_grupos);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h4>Arquivos dos Integrantes do Elenco ou Artista Solo</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
							<?php listaArquivoCamposMultiplos($idEvento,$tipoPessoa,"","arquivos_grupo",9); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 1 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=arquivos_grupo" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php
									if(verificaArquivosExistentesEvento($idEvento,'99')) //true
									{
										echo '<div class="alert alert-success">O arquivo RG do Integrante já foi enviado.</div> ';
									}
									/*
										Retorna verdadeiro se encontra algum resultado.
										Deve ser feito uma condicional que oculta os campos, caso já tenha algo preenchido
									*/
									else{
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '99'";
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
									if(verificaArquivosExistentesEvento($idEvento,'100')) //true
									{
										echo '<div class="alert alert-success">O arquivo CPF do Integrante já foi enviado.</div> ';
									}
									/*
										Retorna verdadeiro se encontra algum resultado.
										Deve ser feito uma condicional que oculta os campos, caso já tenha algo preenchido
									*/
									else{
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '100'";
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
									if(verificaArquivosExistentesEvento($idEvento,'101')) //true
									{
										echo '<div class="alert alert-success">O arquivo DRT do Integrante já foi enviado.</div> ';
									}
									/*
										Retorna verdadeiro se encontra algum resultado.
										Deve ser feito uma condicional que oculta os campos, caso já tenha algo preenchido
									*/
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
									if(verificaArquivosExistentesEvento($idEvento,'102')) //true
									{
										echo '<div class="alert alert-success">O arquivo Currículo do Integrante já foi enviado.</div> ';
									}
									/*
										Retorna verdadeiro se encontra algum resultado.
										Deve ser feito uma condicional que oculta os campos, caso já tenha algo preenchido
									*/
									else{
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '102'";
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
							<input type="hidden" name="idPessoa" value="<?php echo $idEvento; ?>"  />
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

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=artista_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=anexos_pj" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>