<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];
$tipoPessoa = "2";

// Cadastro um representante que não existe
if(isset($_POST['cadastraRepresentante']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	if($rg == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
	}
	else
	{
		$idRep2 = $_POST['cadastraRepresentante'];
		$nome = addslashes($_POST['nome']);
		$rg = $_POST['rg'];
		$cpf = $_POST['cpf'];
		$idEstadoCivil = $_POST['idEstadoCivil'];
		$nacionalidade = $_POST['nacionalidade'];

		$sql_insere_rep2 = "INSERT INTO `representante_legal` (`nome`, `rg`, `cpf`, `nacionalidade`, `idEstadoCivil`) VALUES ('$nome', '$rg', '$cpf', '$nacionalidade', '$idEstadoCivil')";

		if(mysqli_query($con,$sql_insere_rep2))
		{
			$mensagem = "<font color='#01DF3A'><strong>Cadastrado com sucesso!</strong></font>";
			$idRep2 = recuperaUltimo("representante_legal");
			$sql_representante2_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal2 = '$idRep2' WHERE id = '$idPj'";
			$query_representante2_empresa = mysqli_query($con,$sql_representante2_empresa);
			gravarLog($sql_insere_rep2);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar! Tente novamente.</strong></font>";
		}
	}
}

// Insere um Representante que foi pesquisado
if(isset($_POST['insereRepresentante']))
{
	$idRep2 = $_POST['insereRepresentante'];
	$sql_representante2_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal2 = '$idRep2' WHERE id = '$idPj'";
	if(mysqli_query($con,$sql_representante2_empresa))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_representante2_empresa);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao inserir representante!</strong></font>";
	}
}

// Edita os dados do representante
if(isset($_POST['editaRepresentante']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	if($rg == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
	}
	else
	{
		$idRep2 = $_POST['editaRepresentante'];
		$nome = addslashes($_POST['nome']);
		$rg = $_POST['rg'];
		$cpf = $_POST['cpf'];
		$idEstadoCivil = $_POST['idEstadoCivil'];
		$nacionalidade = $_POST['nacionalidade'];

		$sql_atualiza_rep2 = "UPDATE `representante_legal` SET
		`nome` = '$nome',
		`rg` = '$rg',
		`cpf` = '$cpf',
		`nacionalidade` = '$nacionalidade',
		`idEstadoCivil` = '$idEstadoCivil'
		WHERE `id` = '$idRep2'";

		if(mysqli_query($con,$sql_atualiza_rep2))
		{
			$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
			$sql_representante2_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal2 = '$idRep2' WHERE id = '$idPj'";
			$query_representante2_empresa = mysqli_query($con,$sql_representante2_empresa);
			gravarLog($sql_atualiza_rep2);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
		}
	}
}

$pj = recuperaDados("pessoa_juridica","id",$idPj);
$representante2 = recuperaDados("representante_legal","id",$pj['idRepresentanteLegal2']);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>REPRESENTANTE LEGAL #2</h3>
			<p><b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=representante2_pj_cadastro" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?php echo $representante2['nome']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG" value="<?php echo $representante2['rg']; ?>" >
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" placeholder="CPF" value="<?php echo $representante2['cpf']; ?>" >
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaRepresentante" value="<?php echo $idRep2 ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Trocar o Representante -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form method='POST' action='?perfil=representante2_pj'>
								<input type="hidden" name="apagaRepresentante" value="<?php echo $idPj ?>">
								<input type="submit" value="Trocar o Representante" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_representante1" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_representante2" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>