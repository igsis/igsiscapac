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
	$integrantes = addslashes($_POST['integrantes']);
	$idFaixaEtaria = $_POST['idFaixaEtaria'];
	$sinopse = addslashes($_POST['sinopse']);
	$release = addslashes($_POST['release']);
	$link = addslashes($_POST['link']);
	$dataCadastro = date('YmdHis');
}

if(isset($_POST['insere']))
{
	$sql_insere = "INSERT INTO `evento`(`idTipoEvento`, `nomeEvento`, `nomeGrupo`, `fichaTecnica`, `integrantes`, `idFaixaEtaria`, `sinopse`, `releaseCom`, `link`, `dataCadastro`, `publicado`, `idUsuario`) VALUES ('$idTipoEvento', '$nomeEvento', '$nomeGrupo', '$fichaTecnica', '$integrantes', '$idFaixaEtaria', '$sinopse', '$release', '$link', '$dataCadastro', '1', '$idUser')";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso!</strong></font>";
		gravarLog($sql_insere);
		$sql_ultimo = "SELECT id FROM evento WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoEvento = mysqli_fetch_array($query_ultimo);
		$_SESSION['idEvento'] = $ultimoEvento['id'];
		$idEvento = $_SESSION['idEvento'];
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
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
		integrantes = '$integrantes',
		idFaixaEtaria = '$idFaixaEtaria',
		sinopse = '$sinopse',
		releaseCom = '$release',
		link = '$link',
		dataCadastro = '$dataCadastro',
		idUsuario = '$idUser'
		WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_atualizar))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualizar);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
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



$evento = recuperaDados("evento","id",$idEvento);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>PASSSO 1: Informações Gerais do Evento</h4>
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
							<label>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo, como elenco, técnicos, e outros profissionais envolvidos na realização do mesmo.</i></strong></label>
							<p align="justify"><font color="gray"><strong><i>Elenco de exemplo:</strong><br/>Ana Cañas (voz e guitarra)<br/>Lúcio Maia (guitarra solo)<br/>Fabá Jimenez (guitarra base)</br> Fabio Sá (baixo) </br> Marco da Costa (bateria)</font></i></p>
							<textarea name="fichaTecnica" class="form-control" rows="10"><?php echo $evento['fichaTecnica'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Integrantes do grupo:</strong><br/>
							<label>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo, apenas o nome civil de quem irá se apresentar, excluindo técnicos.</i></strong></label>
							<p align="justify"><font color="gray"><strong><i>Elenco de exemplo:</strong><br/>José Carlos da Silva<br/>João Gonçalves<br/>Maria Eduarda de Oliveira</br>Fabio Silva Santos</font></i></p>
							<textarea name="integrantes" class='form-control' cols="40" rows="5"><?php echo $evento['integrantes'] ?></textarea>
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
							<label>Esse campo deve conter uma breve descrição do que será apresentado no espetáculo.</i></strong></label>
							<p align="justify"><font color="gray"><strong><i>Texto de exemplo:</strong><br/>Ana Cañas faz o show de lançamento do seu quarto disco, “Tô na Vida” (Som Livre/Guela Records). Produzido por Lúcio Maia (Nação Zumbi) em parceria com Ana e mixado por Mario Caldato Jr, é o primeiro disco totalmente autoral da carreira da cantora e traz parcerias com Arnaldo Antunes e Dadi entre outros.</font></i></p>
							<textarea name="sinopse" class="form-control" rows="10"><?php echo $evento['sinopse'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Release *</label>
							<label>Esse campo deve abordar informações relacionadas ao artista, abordando breves marcos na carreira e ações realizadas anteriormente. </i></strong></label>
							<p align="justify"><font color="gray"><strong><i>Texto de exemplo:</strong><br/>A cantora e compositora paulistana lançou, em 2007, o seu primeiro disco, "Amor e Caos". Dois anos depois, lançou "Hein?", disco produzido por Liminha e que contou com "Esconderijo", canção composta por Ana, eleita entre as melhores do ano pela revista Rolling Stone e que alcançou repercussão nacional por integrar a trilha sonora da novela "Viver a Vida" de Manoel Carlos, na Rede Globo.
							Ainda em 2009, grava, a convite do cantor e compositor Nando Reis, a bela canção "Pra Você Guardei o Amor". Em 2012, Ana lança o terceiro disco de inéditas, "Volta", com versões para Led Zeppelin ("Rock'n'Roll") e Edith Piaf ("La Vie en Rose"), além das inéditas autorais "Urubu Rei" (que ganhou clipe dirigido por Vera Egito) e "Será Que Você Me Ama?". Em 2013, veio o primeiro DVD, "Coração Inevitável", registrando o show que contou com a direção e iluminação de Ney Matogrosso.</font></i></p>
							<textarea name="release" class="form-control" rows="10"><?php echo $evento['releaseCom'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Links </label>
							<label>Esse campo deve conter os links relacionados ao espetáculo, ao artista/grupo que auxiliem na divulgação do evento.</i></strong></label>
							<p align="justify"><font color="gray"><strong><i>Links de exemplo:</i></strong></strong><br/> https://www.facebook.com/anacanasoficial/<br/></strong>https://www.youtube.com/user/anacanasoficial</font></i></p>
							<textarea name="link" class="form-control" rows="5"><?php echo $evento['link'] ?></textarea>
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