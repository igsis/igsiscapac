<?php
	$con = bancoMysqli();
	$idUser= $_SESSION['idUser'];

	$nomeEvento = addslashes($_POST['nomeEvento']);
	$idTipoEvento = $_POST['idTipoEvento'];
	$nomeGrupo = addslashes($_POST['nomeGrupo']);
	$fichaTecnica = addslashes($_POST['fichaTecnica']);
	$idFaixaEtaria = $_POST['idFaixaEtaria'];
	$sinopse = addslashes($_POST['sinopse']);
	$release = addslashes($_POST['release']);
	$link = addslashes($_POST['link']);

	if(isset($_POST['insere']))
	{
		/* criar o sql para inserir aqui */
	}

	$idEvento = $_SESSION['idEvento'];
	if(isset($_POST['atualizar']))
	{
		$sql_atualizar = "UPDATE evento SET
			nomeEvento = '$nomeEvento',
			idTipoEvento = '$idTipoEvento',
			nomeGrupo = '$nomeGrupo',
			fichaTecnica = '$fichaTecnica',
			idFaixaEtaria = '$idFaixaEtaria',
			sinopse = '$sinopse',
			releaseC = '$release',
			linksCom = '$link'
			WHERE id = '$idEvento'";
			$con = bancoMysqli();
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

	$evento = recuperaDados("evento","id",$idEvento);
?>
<section id="inserir" class="home-section bg-white">
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
								<option value="1"></option>
								<<?php echo geraOpcao("tipo_evento",$campo['id'],"") ?>
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
							<label>Ficha técnica completa*</label>
							<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php echo $evento['fichaTecnica'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Classificação/indicação etária*</label>
							<select class="form-control" name="idFaixaEtaria" id="inputSubject" >
								<option value="0"></option>
								<?php echo geraOpcao("faixa_etaria",$campo['id'],"") ?>
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
							<textarea name="release" class="form-control" rows="10" placeholder="Texto auxiliar para as ações de comunicação. Releases do trabalho, pequenas biografias, currículos, etc"><?php echo $evento['release'] ?></textarea>
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
			</div>
		</div>
	</div>
</section>