<?php
$idUser= $_SESSION['idUser'];
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>Informações para preenchimento do evento</h3>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div align="justify">
							<p align="justify">Inicia-se aqui um processo passo-a-passo para o  preenchimento dos dados do evento conforme descrito abaixo. Antes de começar, tenha disponível estas informações para que o cadastro possa ser concluído.</p>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success list-group-item"><b>Informações Gerais do Evento</b></li>
								<li class="list-group-item">Nome do evento</li>
								<li class="list-group-item">Tipo de evento</li>
								<li class="list-group-item">Nome do grupo (se houver)</li>
								<li class="list-group-item">Ficha técnica completa</li>
								<li class="list-group-item">Classificação indicativa</li>
								<li class="list-group-item">Sinopse</li>
								<li class="list-group-item">Release</li>
								<li class="list-group-item">Links para divulgação</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Dados do Produtor</b></li>
								<li class="list-group-item">Nome</li>
								<li class="list-group-item">E-mail</li>
								<li class="list-group-item">Celular</li>
								<li class="list-group-item">Outro telefone (se houver)</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Arquivos Para Comunicação e Produção</b></li>
								<li class="list-group-item">Nesta página você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, entre outros arquivos destinados à comunicação e produção.</li>
							</ul>
    						</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8"><hr/></div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<form class="form-horizontal" role="form" action="?perfil=evento" method="post">
						<input type="submit" value="Iniciar Evento" class="btn btn-theme btn-lg btn-block" />
					</form>
				</div>
			</div>

		</div>
	</div>
</section>