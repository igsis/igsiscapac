<?php

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];


if(isset($_POST['cadastrarJuridica']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
	$ccm = $_POST['ccm'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$email = $_POST['email'];

	$sql_cadastra_pj = "INSERT INTO `pessoa_juridica`(`razaoSocial`, `cnpj`, `ccm`, `telefone1`, `telefone2`, `telefone3`, `email`, `idUsuario`) VALUES ('$razaoSocial', '$cnpj', '$ccm', '$telefone1', '$telefone2', '$telefone3', '$email', '$idUser')";
	if(mysqli_query($con,$sql_cadastra_pj))
	{
		$mensagem = "Cadastrado com sucesso!";
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_ultimo = "SELECT id FROM pessoa_juridica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPj = mysqli_fetch_array($query_ultimo);
			$_SESSION['idPj'] = $ultimoPj['id'];
			$idPj = $_SESSION['idPj'];

			$sql_atualiza_evento = "UPDATE evento SET idPj = '$idPj' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= " Empresa inserida no evento.";
				$_SESSION['idPj'] = $idPj;
			}
			else
			{
				$mensagem .= "Erro ao cadastrar no evento";
			}
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
	$idPj = $_SESSION['idPj'];

	$sql_atualiza_pj = "UPDATE pessoa_juridica SET
	`razaoSocial` = '$razaoSocial',
	`telefone1` = '$telefone1',
	`telefone2` = '$telefone2',
	`telefone3` = '$telefone3',
	`email` = '$email'
	WHERE `id` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_pj))
	{
		$mensagem = "Atualizado com sucesso!";
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


$idPj = $_SESSION['idPj'];
$pj = recuperaDados("pessoa_juridica","id",$idPj);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPj ; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pj" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
						<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" value="<?php echo $pj['razaoSocial']; ?>" >
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
						<input type="hidden" name="atualizarJuridica" value="<?php echo $idPessoaJuridica ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>

			<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
			</div>
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=documentos_pj" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>