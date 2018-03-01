<?php
$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$idEvento = $_SESSION['idEvento'];
$tipoPessoa = '1';

// Insere um Artista que foi pesquisado
if(isset($_POST['insereArtista']))
{
	$idPf = $_POST['insereArtista'];
	$sql_insere = "UPDATE evento SET idPf = '$idPf' WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "Artista inserido no evento com sucesso!";
		gravarLog($sql_insere);
		$evento = recuperaDados("evento","id",$idEvento);
		$artista = recuperaDados("pessoa_fisica","id",$evento['idPf']);
		$nome = $artista['nome'];
		$rg = $artista['rg'];
		$cpf = $artista['cpf'];
		$sql_grupo = "INSERT INTO `grupo`(`idEvento`, `nome`, `rg`, `cpf`, `publicado`) VALUES ('$idEvento', '$nome', '$rg', '$cpf', '1')";
		if(mysqli_query($con,$sql_grupo))
		{
			$mensagem .= "!!";
			gravarLog($sql_grupo);
		}
	}
	else
	{
		$mensagem = "Erro ao inserir artista no evento! Tente novamente.";
	}
}

// Cadastro um representante que não existe
if(isset($_POST['cadastraArtista']))
{
	$nome = addslashes($_POST['nome']);
	$nomeArtistico = addslashes($_POST['nomeArtistico']);
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
	$email = $_POST['email'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$drt = $_POST['drt'];
	$dataAtualizacao = date("Y-m-d H:m:s");

	$sql_cadastra = "INSERT INTO `pessoa_fisica`(`nome`, `nomeArtistico`, `rg`, `cpf`,  `telefone1`, `telefone2`, `telefone3`, `email`, `drt`, `idTipoDocumento`, `dataAtualizacao`, `idUsuario`)  VALUES ('$nome', '$nomeArtistico', '$rg', '$cpf', '$telefone1', '$telefone2', '$telefone3', '$email', '$drt', '1', '$dataAtualizacao', '$idUser')";
	if(mysqli_query($con,$sql_cadastra))
	{
		$mensagem = "Cadastrado com sucesso!";
		gravarLog($sql_cadastra);
		$idEvento = $_SESSION['idEvento'];
		$sql_ultimo = "SELECT id FROM pessoa_fisica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoPf = mysqli_fetch_array($query_ultimo);
		$idPf = $ultimoPf['id'];

		
		$sql_atualiza_evento = "UPDATE evento SET idPf = '$idPf' WHERE id = '$idEvento'";
		if(mysqli_query($con,$sql_atualiza_evento))
		{
			$mensagem .= " Artista inserido no evento";
			gravarLog ($sql_atualiza_evento);
			$evento = recuperaDados("evento","id",$idEvento);
			$artista = recuperaDados("pessoa_fisica","id",$evento['idPf']);
			$nome = $artista['nome'];
			$rg = $artista['rg'];
			$cpf = $artista['cpf'];
			$sql_grupo = "INSERT INTO `grupo`(`idEvento`, `nome`, `rg`, `cpf`, `publicado`) VALUES ('$idEvento', '$nome', '$rg', '$cpf', '1')";
			if(mysqli_query($con,$sql_grupo))
			{
				$mensagem .= ".";
				gravarLog ($sql_grupo);
			}
		}
		else
		{
			$mensagem .= "Erro ao cadastrar no evento";
		}
	}
	else
	{
		$mensagem = "Erro ao cadastrar! Tente novamente.";
	}
}

// Edita os dados do artista
if(isset($_POST['editaArtista']))
{
	$idArtista = $_POST['editaArtista'];
	$nome = addslashes($_POST['nome']);
	$nomeArtistico = addslashes($_POST['nomeArtistico']);
	$rg = $_POST['rg'];
	$email = $_POST['email'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$drt = $_POST['drt'];
	$dataAtualizacao = date("Y-m-d H:m:s");

	$sql_edita = "UPDATE `pessoa_fisica` SET
	nome = '$nome',
	nomeArtistico = '$nomeArtistico',
	rg = '$rg',
	telefone1 = '$telefone1',
	telefone2 = '$telefone2',
	telefone3 = '$telefone3',
	email = '$email',
	drt = '$drt'
	WHERE id = '$idArtista'";

	if(mysqli_query($con,$sql_edita))
	{
		$mensagem = "Atualizado com sucesso!";
		gravarLog ($sql_edita);
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}
}

// Remove o artista do evento e redireciona para a página de busca
if(isset($_POST['remover']))
{
	$sql_remove = "UPDATE evento SET idPF = NULL WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_remove))
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=artista_pj'>";
		gravarLog($sql_remove);
	}
}

$evento = recuperaDados("evento","id",$idEvento);
$artista = recuperaDados("pessoa_fisica","id",$evento['idPf']);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>PASSO 13: ARTISTA - Líder do Grupo ou Artista Solo</h4>
			<div class="col-md-offset-3 col-md-3">
				<form class="form-horizontal" role="form" action="?perfil=artista_pj_cadastro" method="post">
					<input type="submit" name="remover" value="Trocar o artista" class="btn btn-theme btn-md btn-block">
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
				<form class="form-horizontal" role="form" action="?perfil=artista_pj_cadastro" method="post">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<p align="justify"><i>No caso de espetáculos de teatro, dança e circo, este deve ser do elenco ou o diretor do espetáculo e deve ter DRT. No caso de espetáculo de música, este deve ser um músico do espetáculo.</i></p>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?php echo $artista['nome']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
							<input type="text" class="form-control" name="nomeArtistico" placeholder="Nome Artístico" value="<?php echo $artista['nomeArtistico']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG" value="<?php echo $artista['rg']; ?>">
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" value="<?php echo $artista['cpf']; ?>" placeholder="CPF">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $artista['email']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
							<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $artista['telefone1']; ?>">
						</div>
						<div class="col-md-6"><strong>Telefone #2:</strong><br/>
							<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $artista['telefone2']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
							<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $artista['telefone3']; ?>">
						</div>
						<div class="col-md-6"><strong>DRT: </strong><br/>
							<input type="text" class="form-control" name="drt" placeholder="DRT do ator" value="<?php echo $artista['drt']; ?>">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaArtista" value="<?php echo $artista['id'] ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_artista_pj" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>