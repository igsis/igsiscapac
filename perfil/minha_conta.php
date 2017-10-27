<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];

if(isset($_POST['atualizarUsuario']))
{		
	$Email = $_POST['email'];
	$Telefone1 = addslashes($_POST['telefone1']);
	if($Email == '' OR $Telefone1 == '')
	{
		$mensagem = "Por favor, preencha todos os campos.";
	}
	else
	{	
	$idUser = $_POST['atualizarUsuario'];
	$Nome = addslashes($_POST['nome']);
	$Telefone = $_POST['telefone'];
	$Email = $_POST['email'];
	$dataAtualizacao = date("Y-m-d");
		
	
	$sql_atualiza_usuario = "UPDATE usuario SET
	`nome` = '$Nome',
	`telefone` = '$Telefone', 
	`email` = '$Email',
	`dataAtualizacao` = '$dataAtualizacao'
	WHERE `id` = '$idUser'";	
	
	if(mysqli_query($con,$sql_atualiza_usuario))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
	}
}

$usuario = recuperaDados("usuario","id",$idUser);

?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_minhaconta.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idUser; ?> | <b>Nome:</b> <?php echo $usuario['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?minha_conta.php" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
						<input type="text" class="form-control" name="nome" placeholder="Insira seu nome completo" value="<?php echo $usuario['nome']; ?>" >
					</div>
				</div>

				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $usuario['telefone']; ?>">
					</div>
					<div class="col-md-6"><strong>E-mail *:</strong><br/>
						<input type="text" readonly class="form-control" name="email" placeholder="E-mail" value="<?php echo $usuario['email']; ?>" >
					</div>
				</div>
						  
				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="atualizarUsuario value="<?php echo $idUser ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
			<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
			</div>
				
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=senha" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idUser ?>">
						</div>
					</form>
				</div>	
		
			</div>
		</div>
	</div>
</section>  