<?php
$con = bancoMysqli();
$idEvento = $_SESSION['idEvento'];
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
        <?php include '../perfil/includes/menu_evento.php'; ?>
        <div class="form-group">
			<h4>Integrantes do Elenco ou Artista Solo</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=grupo" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG">
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" class="form-control" name="cpf" id="cpf" placeholder="CPF">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insereIntegrante" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<!-- Botão para Voltar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=grupo" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>