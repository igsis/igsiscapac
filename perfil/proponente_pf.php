<section id="list_items" class="home-section bg-white">
	<div class="container">
		<?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>CADASTRO DE PROPONENTE</h3>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
	            	<div class="col-md-offset-2 col-md-8">
	                    <form method="POST" action="?perfil=proponente_pf_resultado" class="form-horizontal" role="form">
							<label>Insira o CPF</label>
							<input type="text" name="busca" class="form-control" id="cpf"><br />
							<br />
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="pesquisar" />
									<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
								</div>
							</div>
						</form>
	        	    </div>
	        	</div>
			</div>
		</div>
	</div>
</section>