﻿<?php
unset($_SESSION['idEvento']);
unset($_SESSION['idPj']);
unset($_SESSION['idPf']);
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group"><br/>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<br />
						<a href="?perfil=evento" class="btn btn-theme btn-lg btn-block">EVENTO</a>
						<br />
						<a href="?perfil=proponente_pf" class="btn btn-theme btn-lg btn-block">PESSOA FÍSICA</a>
						<br />
						<a href="?perfil=proponente_pj" class="btn btn-theme btn-lg btn-block">PESSOA JURÍDICA</a>
						<br />
						<a href="?perfil=minha_conta" class="btn btn-theme btn-lg btn-block" target="_blank" >MINHA CONTA</a>
						<br />
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6">
						<a href="../manual" target="_blank" class="btn btn-theme btn-lg btn-block">Ajuda</a>
					</div>
					<div  class="col-md-6">
						<a href="../include/logoff.php" class="btn btn-theme btn-lg btn-block">SAIR</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>