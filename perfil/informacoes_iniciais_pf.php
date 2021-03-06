﻿<?php

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$tipoPessoa = "1";
$bool = false;
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;

function anoFormacao(){
	$conn = bancoPDO();

	$stmt = $conn->prepare("SELECT ano FROM capac.formacao_cadastro WHERE id = '1'");
	$stmt->execute();
	$res = $stmt->fetch();

	return $res['ano'];
}

if(isset($_POST['cadastrarFisica']))
{
    $oficineiro = isset($_POST['oficineiro']) ? 1 : 0;
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
	$pis = $_POST['pis'];
	$dataAtualizacao = date("Y-m-d H:i:s");
	$formacaoAno = anoFormacao();

	$sql_cadastra_pf = "INSERT INTO `pessoa_fisica`(`nome`, `nomeArtistico`, `idTipoDocumento`, `rg`, `cpf`, `ccm`, `telefone1`, `telefone2`, `telefone3`, `email`, `dataNascimento`, `pis`, `dataAtualizacao`, `oficineiro`, `idUsuario`, `formacao_ano` ) VALUES ('$nome', '$nomeArtistico', '$idTipoDocumento', '$rg', '$cpf', '$ccm', '$telefone1', '$telefone2', '$telefone3', '$email', '$dataNascimento', '$pis', '$dataAtualizacao', '$oficineiro', '$idUser', '$formacaoAno')";
	if(mysqli_query($con,$sql_cadastra_pf))
	{
		$mensagem = "<font color='#01DF3A'><strong>Cadastrado com sucesso!</strong></font>";
		gravarLog($sql_cadastra_pf);
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_ultimo = "SELECT id FROM pessoa_fisica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPf = mysqli_fetch_array($query_ultimo);
			$idPf = $ultimoPf['id'];

			$sql_atualiza_evento = "UPDATE evento SET idPf = '$idPf', idTipoPessoa = '$tipoPessoa' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= "<font color='#01DF3A'><strong>Pessoa inserida no evento.</strong></font><br/>";
				$_SESSION['idPf'] = $idPf;
				gravarLog($sql_atualiza_evento);
			}
			else
			{
				$mensagem .= "<font color='#FF0000'><strong>Erro ao cadastrar evento!</strong></font>";
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
		$mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar!</strong></font>";
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
	$pis = $_POST['pis'];
	date_default_timezone_set('America/Sao_Paulo');
	$dataAtualizacao = date("Y-m-d");
	$idPf = $_SESSION['idPf'];
	$formacaoAno = anoFormacao();

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
	`pis` = '$pis',
	`dataAtualizacao` = '$dataAtualizacao',
	`formacao_ano`	= '$formacaoAno'
	WHERE `id` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		$bool = true;
		gravarLog($sql_atualiza_pf);
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_atualiza_evento = "UPDATE evento SET idPf = '$idPf', idTipoPessoa = '$tipoPessoa' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= "<font color='#01DF3A'><strong>Pessoa inserida no evento.</strong></font>";
				gravarLog($sql_atualiza_evento);

			}
			else
			{
				$mensagem .= "<font color='#01DF3A'><strong>Erro ao cadastrar evento.</strong></font>";
			}
		}
	}
	else
	{
		$mensagem .= "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['carregar']))
{
	$_SESSION['idPf'] = $_POST['carregar'];
}


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (2,3,25,31)";
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
			$mensagem = "<font color='#01DF3A'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
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
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);
							echo '<script>window.location = "?perfil=informacoes_iniciais_pf"</script>';
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
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
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
	}
}


$idPf = $_SESSION['idPf'];

$pf = recuperaDados("pessoa_fisica","id",$idPf);
?>
<!-- Chamamento Alert-->
<thead>
	<script src="js/sweetalert.min.js"></script>
    <link href="css/sweetalert.css" rel="stylesheet" type="text/css"/>
<script>
	function alerta()
	{
    swal({   title: "Atenção!", 
	text: "Para maiores informações sobre contratação de artistas com idade inferior a 18 anos, entrar em contato com o programador do seu evento.",
	timer: 10000,   
	confirmButtonColor:	"#20B2AA",
	showConfirmButton: true });}
</script>
  </thead>

<section id="list_items" class="home-section bg-white">
	<div class="container">
        <?php
            if (isset($_POST['oficineiro']) || ($pf['oficineiro'] == 1))
            {
                include 'includes/menu_oficinas.php';
            }
            else
            {
                include 'includes/menu_evento.php';
            }
        ?>
		<div class="form-group">
			<h4>Informações Iniciais</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form name="form1" class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pf" method="post">
			<!-- Botão para inserir pessoa no evento -->
			<?php
				if(isset($_SESSION['idEvento']))
				{
					$evento = recuperaDados("evento","id",$_SESSION['idEvento']);
					if($evento['idPf'] == NULL)
					{
			?>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<input type="hidden" name="atualizarFisica" value="<?php echo $idPf ?>">
								<input type="submit" value="Inserir pessoa no evento" class="btn btn-theme btn-md btn-block">
							</div>
						</div>
			<?php
					}
				}
			?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
						<input type="text" class="form-control next-step" name="nome" placeholder="Nome" maxlength="70" value="<?php echo $pf['nome']; ?>" required >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico*:</strong><br/>
						<input type="text" class="form-control" name="nomeArtistico" placeholder="Nome Artístico" maxlength="70" value="<?php echo $pf['nomeArtistico']; ?>" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
						<select class="form-control" id="idTipoDocumento" name="idTipoDocumento" >
							<?php geraOpcao("tipo_documento",$pf['idTipoDocumento']); ?>
						</select>
					</div>
					<div class="col-md-6"><strong>Nº do documento *:</strong><br/>
						<input type="text" class="form-control" name="rg" placeholder="Número do Documento" maxlength="20" value="<?php echo $pf['rg']; ?>" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
						<input type="text" readonly class="form-control" id="cpf" name="cpf" placeholder="CPF" maxlength="14" value="<?php echo $pf['cpf']; ?>" >
					</div>
					<div class="col-md-6"><strong>CCM:</strong><br/>
						<input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" maxlength="11" value="<?php echo $pf['ccm']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone1']; ?>" required>
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone2']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" maxlength="60" value="<?php echo $pf['email']; ?>" required>
						</div>
				</div>

				<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Data Nascimento *:</strong><br/>
							<input type="text" class="form-control" name="dataNascimento" id="datepicker01" onclick="alerta()" placeholder="Data de Nascimento" value = "<?php echo exibirDataBr($pf['dataNascimento']) ?>" required>
						</div>
					<div class="col-md-6"><strong>PIS/PASEP/NIT:</strong><br/>
						<input type="text" class="form-control" name="pis" placeholder="Nº do PIS/PASEP/NIT" maxlength="50" value="<?php echo $pf['pis']; ?>">
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


				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=arquivos_pf" method="post">
						<div class="col-md-offset-8 col-md-2">
							<?php if($bool == true)
							{ ?>
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
							<?php } 
							else { ?>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
			<div class="alert alert-info">
    	Grave suas informações para prosseguir o formulário.</div>
		</div>
		</div>
		</div>
		<?php } ?>


				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"></div>
				</div>

	</div>
</section>