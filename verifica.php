<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>IGSIS - Cadastro de Artistas e Profissionais de Arte e Cultura</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
		<script src="visual/js/modernizr.custom.js"></script>
		<script src="visual/js/jquery-1.9.1.js"></script>
		<script src="visual/js/jquery.maskedinput.js" type="text/javascript"></script>
		<script src="visual/js/jquery.maskMoney.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="bar">
			<p id="p-bar"><img src="visual/images/logo_cultura_h.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IGSIS-CAPAC<!--<img src="images/logo_pequeno.png" />-->
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="fab fa-whatsapp"><br>SUPORTE 9.6912-4884</i>
			</p>
		</div>
		<section id="services" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="section-heading">
							<h3>&nbsp;</h3>
							<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
							<p><strong>Vamos verificar se você já possui cadastro no sistema.</strong></p>
							<p></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form method="POST" action="login_resultado.php" class="form-horizontal" role="form">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>Insira seu e-mail</label>
										<input type="text" name="busca" class="form-control" placeholder="E-mail" maxlength="120">
										<br />
										<input type="hidden" name="pesquisar" value="1" />
										<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php include "visual/rodape.php" ?>
	</body>
</html>