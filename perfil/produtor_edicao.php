<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$idEvento = $_SESSION['idEvento'];

$evento = recuperaDados("evento","id",$idEvento);
$idProdutor = $evento['idProdutor'];

if(isset($_POST['insere']) || isset($_POST['atualizar']))
{
	$nome = addslashes($_POST['nome']);
	$email = addslashes($_POST['email']);
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
}

if(isset($_POST['insere']))
{
	$sql_insere = "INSERT INTO `produtor`(`nome`, `email`, `telefone1`, `telefone2`, `idUsuario`) VALUES ('$nome', '$email', '$telefone1', '$telefone2', '$idUser')";
	if(mysqli_query($con,$sql_insere))
	{
		$sql_ultimo = "SELECT id FROM produtor WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoProdutor = mysqli_fetch_array($query_ultimo);
		$idProdutor = $ultimoProdutor['id'];
		$sql_grava_evento = "UPDATE evento SET idProdutor = '$idProdutor' WHERE id = '$idEvento'";
		if(mysqli_query($con,$sql_grava_evento))
		{
			$mensagem = "<font color='#01DF3A'><strong>Produtor inserido com sucesso!</strong></font>";
			gravarLog($sql_grava_evento);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao inserir produtor no evento!</strong></font>";
		}
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente,.</strong></font>";
	}
}
if(isset($_POST['atualizar']))
{
	$sql_atualizar = "UPDATE produtor SET
		nome = '$nome',
		email = '$email',
		telefone1 = '$telefone1',
		telefone2 = '$telefone2'
		WHERE id = '$idProdutor'";
	if(mysqli_query($con,$sql_atualizar))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualizar);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar!</strong></font>";
	}
}

$produtor = recuperaDados("produtor","id",$idProdutor);
?>
<section id="inserir" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>PASSO 3: Dados do Produtor</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=produtor_edicao" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Nome do Produtor*</label>
							<input type="text" name="nome" placeholder="Nome" class="form-control" maxlength="120" value="<?php echo $produtor['nome'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>E-mail*</label>
							<input type="text" name="email" placeholder="E-mail" class="form-control" maxlength="60" value="<?php echo $produtor['email'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Celular *:</label>
							<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $produtor['telefone1']; ?>">
						</div>
						<div class="col-md-6">
							<label>Outro telefone:</label>
							<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $produtor['telefone2']; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="atualizar" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php include '../perfil/includes/menu_evento_footer.php'; ?>
	</div>
</section>