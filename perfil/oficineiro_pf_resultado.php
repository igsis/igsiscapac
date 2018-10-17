<?php
$con = bancoMysqli();

// inicia a busca por CPF
$validacao = validaCPF($_POST['busca']);
if($validacao == false)
{
    if (isset($_POST['oficineiro']))
    {
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=erros&p=erro_oficineiro_pf'>";
    }
    else
    {
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=erros&p=erro_pf'>";
    }
}
else
{
	$cpf_busca = $_POST['busca'];
}

$sql = $con->query("SELECT * FROM pessoa_fisica where cpf = '$cpf_busca'");
$query = $sql->fetch_array(MYSQLI_ASSOC);

if($query != '')
{
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h4>PESSOA FÍSICA</h4>
						<p><strong><a href="?perfil=oficineiro_pf">Pesquisar outro CPF</a></strong></p>
					</div>
					<div class="table-responsive list_info">
						<table class="table table-condensed">
							<thead>
								<tr class="list_menu">
									<td>Nome</td>
									<td>CPF</td>
									<td width="25%"></td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class='list_description'><?php echo $query["nome"]; ?></td>
									<td class='list_description'><?php echo $query["cpf"] ?></td>
									<td class='list_description'>
										<form method='POST' action='?perfil=informacoes_iniciais_pf'>
										<input type='hidden' name='carregar' value='<?php echo $query["id"] ?>'>
                                        <input type="hidden" name="oficineiro">
                                        <input type ='submit' class='btn btn-theme btn-md btn-block' value='Carregar'></form>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
}
else
{
	$busca = $_POST['busca'];
?>

<thead>
	<script src="js/sweetalert.min.js"></script>
    <link href="css/sweetalert.css" rel="stylesheet" type="text/css"/>
<script>
	function alerta()
	{
    swal({   title: "Atenção!", 
	text: "Para maiores informações sobre contratação de artistas com idade inferior a 18 anos, entrar em contato com o programador do seu evento.",
	timer: 10000,   
	confirmButtonColor:	"#20B2AA",
	showConfirmButton: true });}
</script>
  </thead>

	<section id="contact" class="home-section bg-white">
		<div class="container"><div class="container"><?php include 'includes/menu_oficinas.php'; ?>
			<div class="form-group">
				<h3>INFORMAÇÕES INICIAIS</h3>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pf" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome Completo" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico*:</strong><br/>
							<input type="text" class="form-control" name="nomeArtistico" placeholder="Nome Artístico" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
							<select class="form-control" id="idTipoDocumento" name="idTipoDocumento" >
								<?php geraOpcao("tipo_documento",""); ?>
							</select>
						</div>
						<div class="col-md-6"><strong>Nº do documento *:</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="Número">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
							<input type="text" readonly class="form-control" id="cpf" name="cpf" placeholder="CPF" value="<?php echo $busca; ?>">
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

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Data Nascimento *:</strong><br/>
							<input type="text" class="form-control" name="dataNascimento" id="datepicker01" placeholder="Data de Nascimento" onclick="alerta()" >
						</div>
						<div class="col-md-6"><strong>Estado civil:</strong><br/>
							<select class="form-control" name="idEstadoCivil" >
								<?php geraOpcao("estado_civil",""); ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
							<input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade" >
						</div>
						<div class="col-md-6"><strong>PIS/PASEP/NIT:</strong><br/>
							<input type="text" class="form-control" name="pis" placeholder="Nº do PIS/PASEP/NIT">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="oficineiro">
							<input type="submit" name="cadastrarFisica" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
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