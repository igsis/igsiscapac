<?php
$con = bancoMysqli();

// inicia a busca por CNPJ
$validacao = validaCNPJ($_POST['busca']);
if($validacao == false)
{
	echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=contratados&p=erro_pj'>";
}
else
{
	$cnpj_busca = $_POST['busca'];//original
	//$cnpj_busca = "88.888.888/0001-88"; //teste
}

$sql = $con->query("SELECT * FROM pessoa_juridica where cnpj = '$cnpj_busca'");
$query = $sql->fetch_array(MYSQLI_ASSOC);

if($query != '')
{
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h4>Contratados - Pessoa Jurídica</h4>
						<p></p>
					</div>
				</div>
			</div>

			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Razão Social</td>
							<td>CNPJ</td>
							<td width="25%"></td>
							<td width="5%"></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class='list_description'><b><?php echo $query["razaoSocial"]; ?></b></td>
							<td class='list_description'><b><?php echo $query["cnpj"] ?></b></td>
							<td class='list_description'>
								<form method='POST' action='?perfil=contratados&p=lista'>
								<input type='hidden' name='insereJuridica' value='1'>
								<input type='hidden' name='Id_PessoaJuridica' value='<?php echo $query1['Id_PessoaJuridica'] ?>'>
								<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir'></form>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
<?php
}
else
{
	$busca = $_POST['busca'];
?>
	<section id="contact" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="form-group">
				<h3>INFORMAÇÕES INICIAIS</h3>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pj" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
							<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
							<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $busca; ?>">
						</div>
						<div class="col-md-6"><strong>CCM:</strong><br/>
							<input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
							<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
						</div>
						<div class="col-md-6"><strong>Telefone #2:</strong><br/>
							<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
							<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
						</div>
						<div class="col-md-6"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" >
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="cadastrarJuridica" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
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