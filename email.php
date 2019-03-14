<?php
include "funcoes/funcoesConecta.php";
include "funcoes/funcoesGerais.php";
$con = bancoMysqli();

if (isset($_POST['enviarEmail']))
{
    $token = bin2hex(random_bytes(50));
    $email = trim($_POST['email']);

    $sqlConsulta = "SELECT * FROM `usuario` WHERE email = '$email'";
    $queryConsulta = $con->query($sqlConsulta);
    if ($queryConsulta->num_rows > 0)
    {
        // store token in the password-reset database table against the user's email
        $sqlConsultaToken = "SELECT * FROM `reset_senhas` WHERE `email` = '$email'";
        if ($con->query($sqlConsultaToken)->num_rows > 0)
        {
            $sqlToken = "UPDATE `reset_senhas` SET `token` = '$token' WHERE `email` = '$email'";
        }
        else
        {
            $sqlToken = "INSERT INTO `reset_senhas`(email, token) VALUES ('$email', '$token')";
        }
        $results = $con->query($sqlToken);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "CAPAC - Recuperação de Senha";
        $msg = emailReset($token);

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        // Create email headers
        $headers .= "De: no.reply.smcsistemas@gmail.com\r\n";
        mail($to, $subject, $msg, $headers);

        $mensagem = "<span style='color: #00a201; '>Enviamos um email para <b>$email</b> para a reiniciarmos sua senha. <br>
                    Por favor acesse seu email e clique no link recebido para cadastrar uma nova senha! (Lembre-se de verificar o spam)</span>";
    }
    else
    {
        $mensagem = "<span style='color: #ff0000; '><strong>E-mail não encontrado em nossa base de dados. </strong></span>";
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