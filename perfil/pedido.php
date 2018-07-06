<?php

$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$idEvento = $_SESSION['idEvento'];

$evento = recuperaDados("evento","id",$idEvento);
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
			<div class="form-group">
				<h4>Cadastro do Pedido de Contratação</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<h6><br/>Haverá pedido de contratação?</h6>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<form class="form-horizontal" role="form" action="?perfil=proponente" method="post">
								<input type="submit" value="Sim" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
						<div class="col-md-6">
							<form class="form-horizontal" role="form" action="?perfil=finalizar_evento" method="post">
								<input type="submit" value="Não" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><hr/></div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-1 col-md-2">
							<form class="form-horizontal" role="form" action="?perfil=arquivos_com_prod" method="post">
								<input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block" >
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

