<?php

$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$idEvento = $_SESSION['idEvento'];

$evento = recuperaDados("evento","id",$idEvento);
$idPf = $evento['idPf'];
$idPj = $evento['idPj'];

if(isset($_POST['apagarPj']))
{
	$idPj = $_POST['apagarPj'];
	$sql_apaga = "UPDATE evento SET idPj = NULL AND idTipoPessoa = NULL WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "Apagado com sucesso!<br/>Carregando...";
		echo "<script type=\"text/javascript\">
				 window.setTimeout(\"location.href='?perfil=proponente';\", 4000);
			</script>";
	}
	else
	{
		$mensagem = "Erro ao apagar! Tente novamente.";
	}
}

if(isset($_POST['inserePj']))
{
	$idPj = $_POST['inserePj'];
	$sql_inserePj = "UPDATE evento SET idPj = '$idPj' AND idTipoPessoa = '2' WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_inserePj))
	{
		$mensagem = "Inserido com sucesso!<br/>Carregando...";
		/*echo "<script type=\"text/javascript\">
				 window.setTimeout(\"location.href='?perfil=proponente';\", 4000);
			</script>";*/
	}
	else
	{
		$mensagem = "Erro ao inserir! Tente novamente.";
	}
}

if($idPf == NULL && $idPj == NULL)
{
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
			<div class="form-group">
				<h3>CADASTRO DE PROPONENTE</h3>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<h6><br/>Haverá representação jurídica?</h6>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<form class="form-horizontal" role="form" action="?perfil=proponente_pj" method="post">
								<input type="submit" value="Sim" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
						<div class="col-md-6">
							<form class="form-horizontal" role="form" action="?perfil=proponente_pf" method="post">
								<input type="submit" value="Não" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php
}
else
{
	if($idPj == NULL)
	{
?>
		<section id="list_items" class="home-section bg-white">
			<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
				<div class="form-group">
					<h3>CADASTRO DE PROPONENTE</h3>
					<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
				</div>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<form class="form-horizontal" role="form" action="?perfil=proponente_pj" method="post">
									<input type="submit" value="Deseja cadastrar uma empresa?" class="btn btn-theme btn-lg btn-block">
								</form>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br></div>
					</div>
					<div class="col-md-offset-1 col-md-10">
						<div class="table-responsive list_info">
						<?php
							$sql = "SELECT * FROM pessoa_fisica
									WHERE id ='$idPf'
									ORDER BY nome";
							$query = mysqli_query($con,$sql);
							$num = mysqli_num_rows($query);
							if($num > 0)
							{
								echo "
									<table class='table table-condensed'>
										<thead>
											<tr class='list_menu'>
												<td>Nome</td>
												<td>Nome Artístico</td>
												<td>RG</td>
												<td>CPF</td>
												<td width='10%'></td>
												<td width='10%'></td>
											</tr>
										</thead>
										<tbody>";
										while($campo = mysqli_fetch_array($query))
										{
											echo "<tr>";
											echo "<td class='list_description'>".$campo['nome']."</td>";
											echo "<td class='list_description'>".$campo['nomeArtistico']."</td>";
											echo "<td class='list_description'>".$campo['rg']."</td>";
											echo "<td class='list_description'>".$campo['cpf']."</td>";
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=proponente_pf'>
														<input type='hidden' name='carregar' value='".$campo['id']."' />
														<input type ='submit' class='btn btn-theme btn-block' value='carregar'></td></form>";
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=evento'>
														<input type='hidden' name='apagar' value='".$campo['id']."' />
														<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
											echo "</tr>";
										}
										echo "
									</tbody>
									</table>
								";
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php
	}
	else
	{
?>
		<section id="list_items" class="home-section bg-white">
			<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
				<div class="form-group">
					<h3>CADASTRO DE PROPONENTE</h3>
					<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
				</div>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<div class="table-responsive list_info">
						<?php
							$sql = "SELECT * FROM evento AS eve
									INNER JOIN pessoa_juridica AS pj ON pj.id = eve.idPj
									WHERE idPj ='$idPj'
									ORDER BY razaoSocial";
							$query = mysqli_query($con,$sql);
							$num = mysqli_num_rows($query);
							if($num > 0)
							{
								echo "
									<table class='table table-condensed'>
										<thead>
											<tr class='list_menu'>
												<td>Razão Social</td>
												<td>CNPJ</td>
												<td>Telefone</td>
												<td>E-mail</td>
												<td width='10%'></td>
												<td width='10%'></td>
											</tr>
										</thead>
										<tbody>";
										while($campo = mysqli_fetch_array($query))
										{
											echo "<tr>";
											echo "<td class='list_description'>".$campo['razaoSocial']."</td>";
											echo "<td class='list_description'>".$campo['cnpj']."</td>";
											echo "<td class='list_description'>".$campo['telefone1']."</td>";
											echo "<td class='list_description'>".$campo['email']."</td>";
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=informacoes_iniciais_pj'>
														<input type='hidden' name='carregar' value='".$campo['id']."' />
														<input type ='submit' class='btn btn-theme btn-block' value='carregar'></td></form>";
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=proponente'>
														<input type='hidden' name='apagarPj' value='".$campo['id']."' />
														<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
											echo "</tr>";
										}
										echo "
									</tbody>
									</table>
								";
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php
	}
}
?>