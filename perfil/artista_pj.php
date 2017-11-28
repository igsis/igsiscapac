<?php
$con = bancoMysqli();
$idEvento = $_SESSION['idEvento'];

$evento = recuperaDados("evento","id",$idEvento);

if($evento['idPf'] == NULL)
{
?>
	<section id="services" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h3>ARTISTA - Líder do Grupo ou Artista Solo</h3>
						<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
						<p><strong>Você está inserindo o líder do grupo</strong></p>
						<p></p>
					</div>
				</div>
			</div>
			<div class="row">
				<form method="POST" action="?perfil=artista_pj_resultado_busca" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Insira o CPF</label>
								<input type="text" name="busca" class="form-control" id="cpf">
						</div>
					</div>

					<br />

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=grupo" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
}
else
{
	echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=artista_pj_cadastro'>";
}
?>