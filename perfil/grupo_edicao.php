<?php
$con = bancoMysqli();
$idEvento = $_SESSION['idEvento'];

if(isset($_POST['insereIntegrante']))
{
	$nome = $_POST['nome'];
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];

	$sql_insere_integrante = "INSERT INTO integrante (`nome`, `rg`, `cpf`, `publicado`) VALUES (
	'$nome', '$rg', '$cpf', '1')";
	if(mysqli_query($con,$sql_insere_integrante))
	{
		$sql_ultimo = "SELECT idIntegrante FROM integrante ORDER BY idIntegrante DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimo = mysqli_fetch_array($query_ultimo);
		$idIntegrante = $ultimo['idIntegrante'];
		$sql_insere_grupo = "INSERT INTO `grupo` (`idEvento`, `idIntegrante`, `nome`, `rg`, `cpf`, `publicado`) VALUES ('$idEvento', '$idIntegrante', '$nome', '$rg', '$cpf', '1')";
		if(mysqli_query($con,$sql_insere_grupo))
		{
			$mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso!</strong></font>";
			gravarLog($sql_insere_grupo);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao inserir no grupo! Tente novamente.</strong></font>";
		}
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao inserir! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['editaIntegrante']))
{
	$idIntegrante = $_POST['editaIntegrante'];
	$nome = $_POST['nome'];
	$rg = $_POST['rg'];
	$sql_edita_integrante = "UPDATE `integrante` SET `nome`= '$nome',`rg`= '$rg' WHERE idIntegrante = $idIntegrante";
	if(mysqli_query($con,$sql_edita_integrante))
	{
		$sql_edita_grupo = "UPDATE `grupo` SET `nome`= '$nome',`rg`= '$rg' WHERE idIntegrante = $idIntegrante";
		if(mysqli_query($con,$sql_edita_grupo))
		{
			$mensagem = "<font color='#01DF3A'><strong>Editado com sucesso!</strong></font>";
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
		}
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente!</strong></font>";
	}
}


$integrante = recuperaDados("integrante","idIntegrante",$idIntegrante);
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h4>PASSO 15: Integrantes do Elenco ou Artista Solo</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=grupo_edicao" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?php echo $integrante['nome'] ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG" value="<?php echo $integrante['rg'] ?>">
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" id="cpf" placeholder="CPF" value="<?php echo $integrante['cpf'] ?>">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaIntegrante" value="<?php echo $integrante['idIntegrante'] ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=grupo" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_grupo" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>