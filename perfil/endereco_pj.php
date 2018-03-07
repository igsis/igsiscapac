<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];


if(isset($_POST['cadastrarEndereco']))
{
	$idPj = $_POST['cadastrarEndereco'];
	$Endereco = $_POST['Endereco'];
	$Bairro = $_POST['Bairro'];
	$Cidade = $_POST['Cidade'];
	$Estado = $_POST['Estado'];
	$CEP = $_POST['CEP'];
	$Numero = $_POST['Numero'];
	$Complemento = $_POST['Complemento'];

	$sql_atualiza_endereco_pj = "UPDATE pessoa_juridica SET
	`logradouro` = '$Endereco',
	`bairro` = '$Bairro',
	`cidade` = '$Cidade',
	`estado` = '$Estado',
	`cep` = '$CEP',
	`numero` = '$Numero',
	`complemento` = '$Complemento'
	WHERE `id` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_endereco_pj))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_endereco_pj);

	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>".$sql_atualiza_endereco_pj;
	}
}

$pj = recuperaDados("pessoa_juridica","id",$idPj);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>PASSO 8: Endereço</h4>
			<p><b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
						<input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP" value="<?php echo $pj['cep']; ?>">
					</div>
					<div class="col-md-6" align="left"><br/><i>Pressione a tecla Tab para carregar</i>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
						<input type="text" readonly class="form-control" id="Endereco" name="Endereco" placeholder="Endereço" value="<?php echo $pj['logradouro']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
						<input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" maxlength="11" value="<?php echo $pj['numero']; ?>">
					</div>
					<div class=" col-md-6"><strong>Complemento:</strong><br/>
						<input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" maxlength="20" value="<?php echo $pj['complemento']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
						<input type="text" readonly class="form-control" id="Bairro" name="Bairro" placeholder="Bairro" value="<?php echo $pj['bairro']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
						<input type="text" readonly class="form-control" id="Cidade" name="Cidade" placeholder="Cidade" value="<?php echo $pj['cidade']; ?>">
					</div>
					<div class="col-md-6"><strong>Estado:</strong><br/>
						<input type="text" readonly class="form-control" id="Estado" name="Estado" placeholder="Estado" value="<?php echo $pj['estado']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarEndereco" value="<?php echo $idPj ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>

				<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=representante1_pj" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>