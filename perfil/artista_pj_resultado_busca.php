<?php
$con = bancoMysqli();

if(isset($_POST['busca']))
{
	//validação
	$validacao = validaCPF($_POST['busca']);
	if($validacao == false)
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=erros&p=erro_artista_pj'>";
	}
	else
	{
		$busca = $_POST['busca'];
		$sql_busca = "SELECT * FROM pessoa_fisica WHERE cpf = '$busca' ORDER BY nome";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);
	}
}

if($num_busca > 0)
{ // Se exisitr, lista a resposta.
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
            <?php
            if (isset($_SESSION['emenda'])) {
                include '../perfil/includes/menu_emenda.php';
            } else {
                include '../perfil/includes/menu_evento.php';
            }
            ?>
			<div class="form-group">
				<h3>ARTISTA - Líder do Grupo ou Artista Solo</h3>
				<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="table-responsive list_info">
						<table class="table table-condensed">
							<thead>
								<tr class="list_menu">
									<td>Nome</td>
									<td>CPF</td>
									<td width="15%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
								while($descricao = mysqli_fetch_array($query_busca))
								{
									echo "
										<tr>
											<td class='list_description'><b>".$descricao['nome']."</b></td>
											<td class='list_description'>".$descricao['cpf']."</td><td class='list_description'>
											<form method='POST' action='?perfil=artista_pj_cadastro'>
												<input type='hidden' name='insereArtista' value='".$descricao['id']."'>
												<input type ='submit' class='btn btn-theme btn-md btn-block' value='escolher'>
											</form>
											</td>
										</tr>
									";
								}
							?>
							</tbody>
						</table>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<a href="?perfil=artista_pj"><input type="submit" value="Inserir outro artista" class="btn btn-theme btn-block"></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

<?php
}
else
{ // se não existir o cpf, imprime um formulário.
?>
	<section id="contact" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="form-group">
				<h3>ARTISTA - Líder do Grupo</h3>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=artista_pj_cadastro" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
							<input type="text" class="form-control" name="nomeArtistico" placeholder="Nome Artístico">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG">
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" value="<?php echo $busca ?>" placeholder="CPF">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
							<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321">
						</div>
						<div class="col-md-6"><strong>Telefone #2:</strong><br/>
							<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
							<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321">
						</div>
						<div class="col-md-6"><strong>DRT:</strong> <font size="1"><i>(Somente para artes cênicas)</i></font><br/>
							<input type="text" class="form-control" name="drt" placeholder="DRT caso for teatro, dança ou circo">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastraArtista">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				</div>
			</div>
		</div>
	</section>
<?php
}
?>
