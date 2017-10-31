<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>CADASTRO DE PROPONENTE</h3>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
	            	<div class="col-md-offset-2 col-md-8">
	                    <form method="POST" action="?perfil=proponente_pj_resultado" class="form-horizontal" role="form">
							<label>Insira o CNPJ</label>
							<input type="text" name="busca" class="form-control" id="CNPJ"><br />
							<br />
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type='hidden' name='edicaoPessoa' value='0'>
									<input type="hidden" name="pesquisar" value="1" />
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