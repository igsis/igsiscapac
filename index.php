<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

if(isset($_POST['login']))
{
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	autenticalogin($login,$senha);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Cadastro de Artistas e Profissionais de Arte e Cultura</title>
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
						<p align="justify">Este sistema tem por objetivo criar um ambiente para credenciamento de artistas e profissionais de arte e cultura a fim de agilizar os processos de contratação artística em eventos realizados pela Secretaria Municipal de Cultura de São Paulo.</p>

						<p align="justify">Uma vez cadastrados, esses artistas poderão atualizar suas informações e enviar a documentação necessária para o processo de contratação. Como o sistema possui ligação direta com o sistema da programação, a medida que o cadastro do artista no IGSIS - CAPAC encontra-se atualizado, o processo de contratação consequentemente é agilizado.</p>

						<p align="justify">Podem se cadastrar artistas ou grupos artísticos, como pessoa física ou jurídica.</p>

						<p align="justify">Dúvidas entre em contato com o setor responsável por sua contratação.</p>

						<hr/>

						<form method="POST" action="login_pf.php" class="form-horizontal" role="form">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-6">
									<label>E-mail</label>
									<input type="text" name="login" class="form-control" placeholder="E-mail">
								</div>
								<div class=" col-md-6">
									<label>Senha</label>
									<input type="password" name="senha" class="form-control" placeholder="Senha">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<button type="submit" class="btn btn-theme btn-lg btn-block">Entrar</button>
								</div>
							</div>
						</form>
						<br />

						<div class="form-group">
							<div class="col-md-offset-2 col-md-6">
								<p>Não possui cadastro? <a href="verifica.php">Clique aqui.</a></p>
								<br />
							</div>
							<div class="col-md-6">
								<p>Esqueceu a senha? <a href="recuperar_senha.php">Clique aqui.</a></p>
								<br />
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