<?php
$con = bancoMysqli();
$idEvento = $_SESSION['idEvento'];

if(isset($_POST['insereIntegrante']))
{
	$nome = $_POST['nome'];
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];

	$sql_insere = "INSERT INTO `grupo`(`idEvento`, `nome`, `rg`, `cpf`, `publicado`) VALUES ('$idEvento', '$nome', '$rg', '$cpf', '1')";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "Inserido com sucesso!";
	}
	else
	{
		$mensagem = "Erro ao inserir! Tente novamente.";
	}
}

if(isset($_POST['apagar']))
{
	$idIntegrante = $_POST['apagar'];
	$sql_apaga = "UPDATE `grupo` SET publicado = '0' WHERE id = '$idIntegrante'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "Removido com sucesso!";
	}
	else
	{
		$mensagem = "Erro ao remover! Tente novamente.";
	}
}


$sql_grupos = "SELECT * FROM grupo WHERE idEvento = '$idEvento' AND publicado = '1'";
$query_grupos = mysqli_query($con,$sql_grupos);
$num = mysqli_num_rows($query_grupos);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h3>Integrantes de grupos</h3>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<?php
				if($num > 0)
				{
				?>
					<div class="table-responsive list_info">
						<table class="table table-condensed">
							<thead>
								<tr class="list_menu">
									<td>Nome</td>
									<td>RG</td>
									<td>CPF</td>
									<td width="15%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
								while($grupo = mysqli_fetch_array($query_grupos))
								{
							?>
									<tr>
										<td><?php echo $grupo['nome'] ?></td>
										<td><?php echo $grupo['rg'] ?></td>
										<td><?php echo $grupo['cpf'] ?></td>
										<td class='list_description'>
											<form method='POST' action='?perfil=grupo'>
												<input type="hidden" name="apagar" value="<?php echo $grupo['id'] ?>" />
												<input type ='submit' class='btn btn-theme btn-block' value='apagar'>
											</form>
										</td>
									</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
            				<h6>Não há integrantes de grupos inseridos.</h6><br />
            			</div>
            		</div>
				<?php
				}
				?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=grupo_cadastro"  method="post">
							<input type ='submit' class='btn btn-theme btn-block' value='Inserir novo integrante'></td>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>