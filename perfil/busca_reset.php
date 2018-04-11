<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<h4>Pesquisar Pessoas</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=reseta_senha_resultado" class="form-horizontal" role="form">
					<hr/>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><label>Nome</label>
							<input type="text" name="nome" class="form-control" placeholder="">
						</div>
						<div class="col-md-6"><label>Email</label>
							<input type="text" name="email" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisar" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>