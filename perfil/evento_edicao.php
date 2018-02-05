<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$tipoPessoa = "3";

if(isset($_POST['insere']) || isset($_POST['atualizar']))
{
	$nomeEvento = addslashes($_POST['nomeEvento']);
	$idTipoEvento = $_POST['idTipoEvento'];
	$nomeGrupo = addslashes($_POST['nomeGrupo']);
	$fichaTecnica = addslashes($_POST['fichaTecnica']);
	$idFaixaEtaria = $_POST['idFaixaEtaria'];
	$sinopse = addslashes($_POST['sinopse']);
	$release = addslashes($_POST['release']);
	$link = addslashes($_POST['link']);
	$dataCadastro = date('YmdHis');
}

if(isset($_POST['insere']))
{
	$sql_insere = "INSERT INTO `evento`(`idTipoEvento`, `nomeEvento`, `nomeGrupo`, `fichaTecnica`, `idFaixaEtaria`, `sinopse`, `releaseCom`, `link`, `dataCadastro`, `publicado`, `idUsuario`) VALUES ('$idTipoEvento', '$nomeEvento', '$nomeGrupo', '$fichaTecnica', '$idFaixaEtaria', '$sinopse', '$release', '$link', '$dataCadastro', '1', '$idUser')";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "Inserido com sucesso!";
		gravarLog($sql_insere);
		$sql_ultimo = "SELECT id FROM evento WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoEvento = mysqli_fetch_array($query_ultimo);
		$_SESSION['idEvento'] = $ultimoEvento['id'];
		$idEvento = $_SESSION['idEvento'];
	}
	else
	{
		$mensagem = "Erro ao gravar... tente novamente";
	}
}

if(isset($_POST['atualizar']))
{
	$idEvento = $_SESSION['idEvento'];
	$sql_atualizar = "UPDATE evento SET
		nomeEvento = '$nomeEvento',
		idTipoEvento = '$idTipoEvento',
		nomeGrupo = '$nomeGrupo',
		fichaTecnica = '$fichaTecnica',
		idFaixaEtaria = '$idFaixaEtaria',
		sinopse = '$sinopse',
		releaseCom = '$release',
		link = '$link',
		dataCadastro = '$dataCadastro',
		idUsuario = '$idUser'
		WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_atualizar))
	{
		$mensagem = "Atualizado com sucesso!";
		gravarLog($sql_atualizar);
	}
	else
	{
		$mensagem = "Erro ao atualizar... tente novamente";
	}
}

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
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (23,65,78,96,97,98)";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];

		//Extensões permitidas
		$ext = array("PDF","pdf");

		if($f_size > 2097152) // 2MB em bytes
		{
			$mensagem = "Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 02 MB.";
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
							$mensagem = "Arquivo recebido com sucesso!";
							gravarLog($sql_insere_arquivo);
						}
						else
						{
							$mensagem = "Erro ao gravar no banco!";
						}
					}
					else
					{
						 $mensagem = "Erro no upload! Tente novamente!";
					}
				}
				else
				{
					$mensagem = "Erro no upload! Anexar documentos somente no formato PDF.";
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
		$mensagem =	"Arquivo apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}

$evento = recuperaDados("evento","id",$idEvento);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>EVENTO - Informações Gerais</h3>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=evento_edicao" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Nome do Evento *</label>
							<input type="text" name="nomeEvento" class="form-control" value="<?php echo $evento['nomeEvento'] ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Tipo de Evento *</label>
							<select class="form-control" name="idTipoEvento" id="inputSubject" >
								<option>Selecione...</option>
								<<?php echo geraOpcao("tipo_evento",$evento['idTipoEvento']) ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Nome do Grupo</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." value="<?php echo $evento['nomeGrupo'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Ficha técnica completa *</label>
							<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php echo $evento['fichaTecnica'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Classificação indicativa *</label> <a href="?perfil=classificacaoIndicativa" target="_blank"><i>(Confira aqui como classificar)</i></a>
							<select class="form-control" name="idFaixaEtaria" id="inputSubject" >
								<option>Selecione...</option>
								<?php echo geraOpcao("faixa_etaria",$evento['idFaixaEtaria']) ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Sinopse *</label>
							<textarea name="sinopse" class="form-control" rows="10" placeholder="Texto para divulgação e sob editoria da area de comunicação. Não ultrapassar 400 caracteres."><?php echo $evento['sinopse'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Release *</label>
							<textarea name="release" class="form-control" rows="10" placeholder="Texto auxiliar para as ações de comunicação. Releases do trabalho, pequenas biografias, currículos, etc"><?php echo $evento['releaseCom'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Links </label>
							<textarea name="link" class="form-control" rows="5" placeholder="Links para auxiliar a divulgação e o jurídico. Site oficinal, vídeos, clipping, artigos, etc "><?php echo $evento['link'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="atualizar" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
							<?php listaArquivoCamposMultiplos($idEvento,$tipoPessoa,"","evento_edicao",10); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 1 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=evento_edicao" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php
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
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '97'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php
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
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '98'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php
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

			</div>
		</div>
	</div>
</section>