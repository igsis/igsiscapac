<?php
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
						<?php
							$usr = $_SESSION['idUser'];
							if($usr == 18 || $usr == 19 || $usr = 54 || $usr = 55 || $usr = 204)
							{
								echo "<a href='?perfil=busca_reset' class='btn btn-theme btn-lg btn-block'>Reiniciar Senha</a><br/>";
							}
						?>
						<p>Aqui são inseridas as informações sobre o seu evento.</p>
						<a href="?perfil=evento_apresentacao" class="btn btn-theme btn-lg btn-block">EVENTO</a>
						<br />
						<p>Aqui você cadastra o artista que executará o evento.</p>
						<a href="?perfil=proponente_pf" class="btn btn-theme btn-lg btn-block">PESSOA FÍSICA</a>
						<br />
						<p>Aqui você cadastra os dados da empresa que representará o artista.</p>
						<a href="?perfil=proponente_pj" class="btn btn-theme btn-lg btn-block">PESSOA JURÍDICA</a>
						<br />
						<p>Aqui você altera os seus dados de login e senha.</p>
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