<?php
$con = bancoMysqli();

$nome = $_POST['nome'];
$email = $_POST['email'];

// Inicio Pessoa Física
if($nome != '' || $email != '')
{
	if($nome != '')
	{
		$filtro_nome = " AND nome LIKE '%$nome%'";
	}
	else
	{
		$filtro_nome = "";
	}

	if($email != '')
	{
		$filtro_email = " AND email = '$email'";
	}
	else
	{
		$filtro_email = "";
	}

	$sql = "SELECT * FROM usuario WHERE id > 1 $filtro_nome $filtro_email";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$frase = recuperaDados("frase_seguranca","id",$lista['idFraseSeguranca']);
			$x[$i]['id'] = $lista['id'];
			$x[$i]['nome'] = $lista['nome'];
			$x[$i]['email'] = $lista['email'];
			$x[$i]['telefone'] = $lista['telefone'];
			$x[$i]['frase'] = $frase['frase_seguranca'];
			$x[$i]['resposta'] = $lista['respostaFrase'];
			$i++;
		}
		$x['num'] = $i;
	}
	else
	{
		$x['num'] = 0;
	}
}

$mensagem = "Foram encontrados ".$x['num']." resultados";
?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<h4>Pesquisar Pessoas</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=busca_reset">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td>Nome</td>
								<td>Email</td>
								<td>Telefone</td>
								<td>Frase</td>
								<td>Resposta</td>
								<td width='10%'></td>
							</tr>
						</thead>
						<tbody>
							<?php
							for($h = 0; $h < $x['num']; $h++)
							{
								echo "<tr>";
								echo "<td class='list_description'>".$x[$h]['nome']."</td>";
								echo "<td class='list_description'>".$x[$h]['email']."</td>";
								echo "<td class='list_description'>".$x[$h]['telefone']."</td>";
								echo "<td class='list_description'>".$x[$h]['frase']."</td>";
								echo "<td class='list_description'>".$x[$h]['resposta']."</td>";
								echo "<td class='list_description'>
										<form method='POST' action='?perfil=texto_resete_senha'>
											<input type='hidden' name='id' value='".$x[$h]['id']."' />
											<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Reiniciar Senha de ".$x[$h]['nome']."?'>Reiniciar Senha</button>
										</form>
									</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- INICIO Modal de confirmação de resete de senha -->
		<div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Reiniciar senha</h4>
					</div>
					<div class="modal-body">
						<p>Confirma o reinício da senha para <strong>capac2018</strong>?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-success" id="confirm">Reiniciar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- FIM Modal de confirmação de resete de senha -->
	</div>
</section>