<?php

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$tipoPessoa = 2;


if(isset($_POST['cadastrarJuridica']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
	$ccm = $_POST['ccm'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$email = $_POST['email'];
	$dataAtualizacao = date("Y-m-d H:i:s");

	$sql_cadastra_pj = "INSERT INTO `pessoa_juridica`(`razaoSocial`, `cnpj`, `ccm`, `telefone1`, `telefone2`, `telefone3`, `email`, `dataAtualizacao`, `idUsuario`) VALUES ('$razaoSocial', '$cnpj', '$ccm', '$telefone1', '$telefone2', '$telefone3', '$email', '$dataAtualizacao', '$idUser')";
	if(mysqli_query($con,$sql_cadastra_pj))
	{
		$mensagem = "Cadastrado com sucesso!";
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_ultimo = "SELECT id FROM pessoa_juridica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPj = mysqli_fetch_array($query_ultimo);
			$idPj = $ultimoPj['id'];

			$sql_atualiza_evento = "UPDATE evento SET idPj = '$idPj', idTipoPessoa = '2' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= " Empresa inserida no evento.<br/>";
				$_SESSION['idPj'] = $idPj;
			}
			else
			{
				$mensagem .= "Erro ao cadastrar no evento";
			}
		}
		else
		{
			$sql_ultimo = "SELECT id FROM pessoa_juridica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPj = mysqli_fetch_array($query_ultimo);
			$_SESSION['idPj'] = $ultimoPj['id'];
			$idPj = $_SESSION['idPj'];
		}
	}
	else
	{
		$mensagem = "Erro ao cadastrar! Tente novamente.";
	}
}

if(isset($_POST['atualizarJuridica']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
	$ccm = $_POST['ccm'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$email = $_POST['email'];
	$dataAtualizacao = date("Y-m-d H:i:s");
	$idPj = $_SESSION['idPj'];

	$sql_atualiza_pj = "UPDATE pessoa_juridica SET
	`razaoSocial` = '$razaoSocial',
	`telefone1` = '$telefone1',
	`telefone2` = '$telefone2',
	`telefone3` = '$telefone3',
	`email` = '$email',
	`dataAtualizacao` = 'dataAtualizacao'
	WHERE `id` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_pj))
	{
		$mensagem = "Atualizado com sucesso!";
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_atualiza_evento = "UPDATE evento SET idPj = '$idPj', idTipoPessoa = '2' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= " Empresa inserida no evento.<br/>";
			}
			else
			{
				$mensagem .= "Erro ao cadastrar no evento";
			}
		}
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}
}

if(isset($_POST['carregar']))
{
	$_SESSION['idPj'] = $_POST['carregar'];
}


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id IN (9,21)";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPj', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							$mensagem = "Arquivo recebido com sucesso!";
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


$idPj = $_SESSION['idPj'];

$server = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/";
$http = $server."/pdf/";
$link1 = $http."rlt_declaracaoccm_pj.php"."?id_pj=".$idPj;

$pj = recuperaDados("pessoa_juridica","id",$idPj);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPj ; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pj" method="post">
			<!-- Botão para inserir empresa no evento -->
			<?php
				if(isset($_SESSION['idEvento']))
				{
					$evento = recuperaDados("evento","id",$_SESSION['idEvento']);
					if($evento['idPj'] == NULL)
					{
			?>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<input type="hidden" name="atualizarJuridica" value="<?php echo $idPj ?>">
								<input type="submit" value="Inserir empresa no evento" class="btn btn-theme btn-md btn-block">
							</div>
						</div>
			<?php
					}
				}
			?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
						<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" value="<?php echo $pj['razaoSocial']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
						<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $pj['cnpj']; ?>" >
					</div>
					<div class="col-md-6"><strong>CCM:</strong><br/>
						<input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" value="<?php echo $pj['ccm']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone1']; ?>">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone2']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>E-mail *:</strong><br/>
						<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pj['email']; ?>" >
					</div>
				</div>

				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="atualizarJuridica" value="<?php echo $idPj ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/></div>
				</div>

				<!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
						<p align="justify">
							<a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a><br />
							<a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a><br />
							<a href='<?php echo $link1 ?>' target="_blank">Declaração CCM (Empresa Fora de São Paulo)</a>
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
							<?php listaArquivoCamposMultiplos($idPj,$tipoPessoa,"","informacoes_iniciais_pj",2); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 1 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=informacoes_iniciais_pj" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '9'";
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
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '21'";
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
							<input type="hidden" name="idPessoa" value="<?php echo $idPj ?>"  />
							<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
							<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
						</form>
						</div>
					</div>
				</div>
				<!-- Fim Upload de arquivo -->

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>