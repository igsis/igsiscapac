<?php
	include "funcoes/funcoesConecta.php";
	include "funcoes/funcoesGerais.php";
	$con = bancoMysqli();

	if(isset($_POST['enviarEmail']))
	{	
		$email = $_POST['email'];
		$sql = "SELECT email FROM usuario WHERE email = '$email'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			$etapa = 2;
			$tentativa = 0;
			$usuario = recuperaDados("usuario","email",$email);
		}
		else
		{
			$mensagem = "<font color='#ff0000'><strong>E-mail não encontrado em nossa base de dados. </strong></font>";
		}
	}

	if (isset($_POST['enviarResposta']))
	{	
		$email = $_POST['email'];
		$frase = $_POST['frase'];
		$resposta = $_POST['resposta'];

		$sql = "SELECT email, idFraseSeguranca, respostaFrase FROM usuario WHERE email = '$email' AND idFraseSeguranca = '$frase' AND respostaFrase = '$resposta'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			$etapa = 3;
			$tentativa = 0;
			$usuario = recuperaDados("usuario","email",$email);
		}
		else
		{
			$etapa = 2;
			$usuario = recuperaDados("usuario","email",$email);
			$mensagem = "<font color='#ff0000'><strong>Pergunta secreta ou Resposta não confere com a cadastrada em nossa base de dados.</strong></font>";
			$tentativa++;
		}
	}

	if (isset($_POST['enviarSenha']))
	{
		$email = $_POST['email'];
		$idUsuario = $_POST['id'];

		if(($_POST['senha01'] != "") AND (strlen($_POST['senha01']) >= 5))
		{
			if($_POST['senha01'] == $_POST['senha02'])
			{
				$senha01 = md5($_POST['senha01']);
				$sql_senha = "UPDATE `usuario` SET `senha` = '$senha01' WHERE `id` = '$idUsuario'";
				$query_senha = mysqli_query($con,$sql_senha);
				
				if($query_senha)
				{
					$mensagem = "<font color='#33cc33'><strong>Senha alterada com sucesso! Aguarde que você será redirecionado para a página de login</strong></font>";
					gravarLogSenha($sql_senha, $idUsuario);
					echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='index.php';\", 3000);
						</script>";
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Não foi possível mudar a senha! Tente novamente.</strong></font>";
					echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='recuperar_senha.php';\", 3000);
						</script>";
				}
			}
			else
			{
				$etapa = 3;
				$mensagem = "<font color='#FF0000'><strong>Senhas não conferem! Tente novamente.</strong></font>";
				$usuario = recuperaDados("usuario","email",$email);
			}
		}
		else
		{	
			$etapa = 3;
			$mensagem = "<font color='#FF0000'><strong>Senha de conter um minímo de 5 dígitos</strong></font>";
			$usuario = recuperaDados("usuario","email",$email);
		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Mapeamento e Cadastro de Artistas e Profissionais de Arte e Cultura</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<script src="visual/js/modernizr.custom.js"></script>
	</head>
	<body>
		<section id="spacer1" class="home-section spacer">
           <div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="color-light">
							<h1 class="wow bounceInDown" data-wow-delay="1s">IGSIS - CADASTRO DE ARTISTAS E PROFISSIONAIS DE ARTE E CULTURA</h1>
						</div>
					</div>
				</div>
            </div>
		</section>
		<section id="contact" class="home-section bg-white">
			<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<h6>ESQUECEU SUA SENHA?</h6>
				<h5><?php if(isset($mensagem)){echo $mensagem;}?></h5>
				<hr>
                <form method="POST" action="./email.php">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            <label>Digite Seu E-mail:</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="enviarEmail" value="Enviar" class="btn btn-theme btn-md btn-block form-control" required>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <a href="./index.php" class="btn btn-theme btn-md btn-block form-control">Voltar a Tela de Login</a>
                    </div>
                </div>
			</div>
		</div>
	</div>
		</section>
		<footer>
			<div class="container">
				<table width="100%">
					<tr>
						<td><img src="visual/images/logo_cultura_q.png" align="left"/></td>
						<td align="center"><font color="#ccc">2017 @ IGSIS - Cadastro de Artistas e Profissionais de Arte e Cultura<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</font></td>
						<td><img src="visual/images/logo_igsis_azul.png" align="right"/></td>
					</tr>
				</table>
			</div>
		</footer>
    </body>
</html>