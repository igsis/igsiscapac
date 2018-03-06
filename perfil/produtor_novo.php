<section id="inserir" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>PASSO 3: Dados do Produtor</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=produtor_edicao" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Nome do Produtor*</label>
							<input type="text" name="nome" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>E-mail*</label>
							<input type="text" name="email" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Celular *:</label>
							<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" />
						</div>
						<div class="col-md-6">
							<label>Outro telefone:</label>
							<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="insere" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>