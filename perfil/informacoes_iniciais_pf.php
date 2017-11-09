<?php

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$tipoPessoa = 1;


if(isset($_POST['cadastrarFisica']))
{
	$nome = addslashes($_POST['nome']);
	$nomeArtistico = addslashes($_POST['nomeArtistico']);
	$idTipoDocumento = $_POST['idTipoDocumento'];
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
	$ccm = $_POST['ccm'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$email = $_POST['email'];
	$dataNascimento = exibirDataMysql($_POST['dataNascimento']);
	$idEstadoCivil = $_POST['idEstadoCivil'];
	$nacionalidade = $_POST['nacionalidade'];
	$pis = $_POST['pis'];
	$dataAtualizacao = date("Y-m-d H:i:s");

	$sql_cadastra_pf = "INSERT INTO `pessoa_fisica`(`nome`, `nomeArtistico`, `idTipoDocumento`, `rg`, `cpf`, `ccm`, `telefone1`, `telefone2`, `telefone3`, `email`, `dataNascimento`, `idEstadoCivil`, `nacionalidade`, `pis`, `dataAtualizacao`, `idUsuario`) VALUES ('$nome', '$nomeArtistico', '$idTipoDocumento', '$rg', '$cpf', '$ccm', '$telefone1', '$telefone2', '$telefone3', '$email', '$dataNascimento', '$idEstadoCivil', '$nacionalidade', '$pis', $dataAtualizacao', '$idUser')";
	if(mysqli_query($con,$sql_cadastra_pf))
	{
		$mensagem = "Cadastrado com sucesso!";
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_ultimo = "SELECT id FROM pessoa_fisica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPf = mysqli_fetch_array($query_ultimo);
			$idPf = $ultimoPf['id'];

			$sql_atualiza_evento = "UPDATE evento SET idPf = '$idPf', idTipoPessoa = '2' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= " Empresa inserida no evento.<br/>";
				$_SESSION['idPf'] = $idPf;
			}
			else
			{
				$mensagem .= "Erro ao cadastrar no evento";
			}
		}
		else
		{
			$sql_ultimo = "SELECT id FROM pessoa_fisica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPf = mysqli_fetch_array($query_ultimo);
			$_SESSION['idPf'] = $ultimoPf['id'];
			$idPf = $_SESSION['idPf'];
		}
	}
	else
	{
		$mensagem = "Erro ao cadastrar! Tente novamente.";
	}
}

if(isset($_POST['atualizarFisica']))
{
	$nome = addslashes($_POST['nome']);
	$nomeArtistico = addslashes($_POST['nomeArtistico']);
	$idTipoDocumento = $_POST['idTipoDocumento'];
	$rg = $_POST['rg'];
	$ccm = $_POST['ccm'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$email = $_POST['email'];
	$dataNascimento = exibirDataMysql($_POST['dataNascimento']);
	$idEstadoCivil = $_POST['idEstadoCivil'];
	$nacionalidade = $_POST['nacionalidade'];
	$pis = $_POST['pis'];
	$dataAtualizacao = date("Y-m-d H:i:s");
	$idPf = $_SESSION['idPf'];

	$sql_atualiza_pf = "UPDATE pessoa_fisica SET
	`nome` = '$nome',
	`nomeArtistico` = '$nomeArtistico',
	`idTipoDocumento` = '$idTipoDocumento',
	`rg` = '$rg',
	`ccm` = '$ccm',
	`telefone1` = '$telefone1',
	`telefone2` = '$telefone2',
	`telefone3` = '$telefone3',
	`email` = '$email',
	`dataNascimento` = '$dataNascimento',
	`idEstadoCivil` = '$idEstadoCivil',
	`nacionalidade` = '$nacionalidade',
	`pis` = '$pis',
	`dataAtualizacao` = 'dataAtualizacao'
	WHERE `id` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "Atualizado com sucesso!";
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_atualiza_evento = "UPDATE evento SET idPf = '$idPf', idTipoPessoa = '$tipoPessoa' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= " Pessoa inserida no evento.<br/>";
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
	$_SESSION['idPf'] = $_POST['carregar'];
}


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id IN (1,2,11,14)";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$y', '$new_name', '$hoje', '1'); ";
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


$idPf = $_SESSION['idPf'];

$server = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/";
$http = $server."/pdf/";
$link1 = $http."rlt_declaracaoccm_pf.php"."?id_pf=".$idPf;

$pf = recuperaDados("pessoa_fisica","id",$idPf);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPf ; ?> | <b>Razão Social:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pf" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
						<input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $pf['nome']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico*:</strong><br/>
						<input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $pf['nomeArtistico']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
						<select class="form-control" id="idTipoDocumento" name="idTipoDocumento" >
							<?php geraOpcao("tipo_documento",$pf['idTipoDocumento']); ?>
						</select>
					</div>
					<div class="col-md-offset-2 col-md-6"><strong>Nº do documento *:</strong><br/>
						<input type="text" class="form-control" name="rg" placeholder="Número do Documento" value="<?php echo $pf['rg']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
						<input type="text" readonly class="form-control" id="cpf" name="cpf" placeholder="CPF" value="<?php echo $pf['cpf']; ?>" >
					</div>
					<div class="col-md-6"><strong>CCM:</strong><br/>
						<input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" value="<?php echo $pf['ccm']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone1']; ?>">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone2']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>Data Nascimento *:</strong><br/>
						<input type="text" class="form-control" name="dataNascimento" placeholder="Data de Nascimento" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
						<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pf['email']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Estado civil:</strong><br/>
						<select class="form-control" name="idEstadoCivil" >
							<?php geraOpcao("estado_civil",$pf['idEstadoCivil']); ?>
						</select>
					</div>
					<div class="col-md-6"><strong>Nacionalidade:</strong><br/>
						<input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade" value="<?php echo $pf['nacionalidade']; ?>">
					</div>
				</div>

				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="atualizarFisica" value="<?php echo $idPf ?>">
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
						<div class="table-responsive list_info"><h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
							<div align="left">
								<a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a></i><br/><br />
								<a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></i><br/><br />
								<a href='<?php echo $link1 ?>' target="_blank">Declaração CCM (Empresa Fora de São Paulo)</a></i><br/><br />
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/></div>
				</div>

				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPf,$tipoPessoa,"","documentos_pf",1); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 1 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=informacoes_iniciais_pf" enctype="multipart/form-data">
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
							<input type="hidden" name="idPessoa" value="<?php echo $idPf ?>"  />
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
					<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>