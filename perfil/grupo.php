<?php
$con = bancoMysqli();
$idEvento = $_SESSION['idEvento'];
$tipoPessoa = '3';


if(isset($_POST['apagarIntegrante']))
{
	$idIntegrante = $_POST['apagarIntegrante'];
	$sql_apaga = "UPDATE `grupo` SET publicado = '0' WHERE id = '$idIntegrante'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "<font color='#01DF3A'><strong>Removido com sucesso!</strong></font>";
		gravarLog($sql_apaga);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao remover! Tente novamente.</strong></font>";
	}
}

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
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>Integrantes do Elenco ou Artista Solo</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<p align="justify"><i>No caso de espetáculos de teatro, dança e circo, os integrantes a serem cadastrados são os componentes do elenco e o diretor do espetáculo. Caso o espetáculo tenha música ao vivo, os músicos também devem ser cadastrados. No caso de espetáculo de música, os integrantes a serem cadastrados são os músicos do espetáculo.</i></p>
				<?php
				if($num > 0)
				{
				?>
					<div class="table-responsive list_info">
						<table class="table table-condensed">
							<thead>
								<tr class="list_menu">
									<td>Nome</td>
									<td>RG</td>
									<td>CPF</td>
									<td width="15%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
								while($grupo = mysqli_fetch_array($query_grupos))
								{
							?>
									<tr>
										<td><?php echo $grupo['nome'] ?></td>
										<td><?php echo $grupo['rg'] ?></td>
										<td><?php echo $grupo['cpf'] ?></td>
										<td class='list_description'>
											<form method='POST' action='?perfil=grupo'>
												<input type="hidden" name="apagarIntegrante" value="<?php echo $grupo['id'] ?>" />
												<input type ='submit' class='btn btn-theme btn-block' value='apagar Integrante'>
											</form>
										</td>
									</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
            				<h6>Não há integrantes de grupos inseridos.</h6><br />
            			</div>
            		</div>
				<?php
				}
				?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=grupo_cadastro"  method="post">
							<input type ='submit' class='btn btn-theme btn-block' value='Inserir novo integrante'>
						</form>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-1 col-md-10"><hr/><br/></div>
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