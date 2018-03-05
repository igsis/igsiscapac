<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];

$pj = recuperaDados("pessoa_juridica","id",$idPj);

// Edita os dados do representante
if(isset($_POST['apagaRepresentante']))
{
	$idPj = $_POST['apagaRepresentante'];

	$sql_apaga_rep2 = "UPDATE pessoa_juridica SET idRepresentanteLegal2 = '0'
	WHERE `id` = '$idPj'";

	if(mysqli_query($con,$sql_apaga_rep2))
	{
		$mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga_rep2);
	?>
		<script language="JavaScript">
			window.location = "?perfil=representante2_pj";
		</script>
	<?php
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

if ($pj['idRepresentanteLegal2'] == 0) // Não possui representante legal cadastrado
{
?>
	<section id="services" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h3>REPRESENTANTE LEGAL #2</h3>
						<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
						<p><strong>Você está inserindo representante legal </strong></p>
						<p></p>
					</div>
				</div>
			</div>
			<div class="row">
				<form method="POST" action="?perfil=representante2_pj_resultado_busca" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">

							<label>Insira o CPF</label>
								<input type="text" name="busca" class="form-control" id="cpf" >
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
						<form class="form-horizontal" role="form" action="?perfil=arquivos_representante1" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pj" method="post">
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
	echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=representante2_pj_cadastro&id_pj=".$idPj."'>";
}
?>