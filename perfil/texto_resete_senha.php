<?php
$con = bancoMysqli();

$id = $_POST['id'];
$senha = MD5('capac2018');

$sql = "UPDATE usuario SET senha = '$senha' WHERE id = '$id'";
if(mysqli_query($con,$sql))
{
	$usr = recuperaDados("usuario","id",$id);
	$mensagem = "
		<h5>Texto para o envio de email</h5>
		<p align='justify'><strong>Endereço de e-mail para resposta:</strong> ".$usr['email']."</p>
		<br/><br/>
		<p align='left'><strong>".saudacao()."!</strong></p>
		<br/>
		<p align='justify'>Sua senha foi reiniciada com sucesso! Para acessar o sistema, utilize as seguintes informações:</p>
		<p align='justify'><strong>Login:</strong> ".$usr['email']."</p>
		<p align='justify'><strong>Senha:</strong> capac2018</p>
		<p align='justify'><strong>Endereço de acesso:</strong> <a href='http://smcsistemas.prefeitura.sp.gov.br/igsiscapac/'>http://smcsistemas.prefeitura.sp.gov.br/igsiscapac</a></p>
		<br/>
		<p align='justify'><strong>Atenção: Pedimos que, para sua segurança, altere sua senha no primeiro login, através do MINHA CONTA -> Alterar senha</strong></p>
		<br/>
		<p align='justify'>Att.</p>
	";
}
else
{
	$mensagem = "<font color='#FF0000'><strong>Erro ao reiniciar a senha! Tente novamente.</strong></font>";
}


?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<?php echo isset($mensagem) ? $mensagem : ''; ?>
				<p align="justify"></p>
			</div>
		</div>
	</div>
</section>