<?php
	$con = bancoMysqli();
	$idUser= $_SESSION['idUser'];

	$usuario = recuperaDados("usuario","id",$idUser);
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>EVENTOS</h3>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=evento_novo" method="post">
							<input type="submit" value="Inserir novo evento" class="btn btn-theme btn-lg btn-block">
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
					$sql = "SELECT * FROM evento
							WHERE publicado = 1 AND idusuario ='$idUser'
							ORDER BY id DESC";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td width='20%'>ID evento</td>
										<td>Nome do evento</td>
										<td>Tipo de evento</td>
										<td>Data cadastro</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['id']."</td>";
									echo "<td class='list_description'>".$campo['nomeEvento']."</td>";
									echo "<td class='list_description'>".retornaTipo($campo['idTipoEvento'])."</td>";
									echo "<td class='list_description'>".$campo['dataCadastro']."</td>";
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=evento&p=basica'>
												<input type='hidden' name='carregar' value='".$campo['idEvento']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'></td></form>";
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=evento&p=carregar'>
												<input type='hidden' name='apagar' value='".$campo['idEvento']."' />
												<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
									echo "</tr>";
								}
								echo "
							</tbody>
							</table>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section> <!--/#list_items-->