<?php
include "funcoes/funcoesConecta.php";
include "funcoes/funcoesGerais.php";
$con = bancoMysqli();

$linkValido = false;

if (isset($_GET['token']))
{
    $token = $_GET['token'];
    $sqlConsultaToken = "SELECT `email` FROM `reset_senhas` WHERE token = '$token' LIMIT 1";

    if ($con->query($sqlConsultaToken)->num_rows <= 0)
    {

        $mensagem = "<span style='color: #ff0000; '><strong>Link Inválido! Tente recuperar sua senha novamente. Redirecionando a tela de login.</strong></span>";
        echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=index.php'>";
    }
    else
    {
        $linkValido = true;
    }
}
else
{
    header('location: ./index.php');
}

if (isset($_POST['reset'])) {
    $token = $_POST['token'];
    $novaSenha = $_POST['novaSenha'];
    $confirmaSenha = $_POST['confirmaSenha'];

    if ($novaSenha == $confirmaSenha)
    {
        $sqlConsultaToken = "SELECT `email` FROM `reset_senhas` WHERE token = '$token' LIMIT 1";
        $queryToken = $con->query($sqlConsultaToken);

        if ($queryToken)
        {
            $email = $queryToken->fetch_assoc()['email'];
            $senha = md5($novaSenha);
            $sqlNovaSenha = "UPDATE usuario SET senha = '$senha' WHERE email = '$email'";

            if ($con->query($sqlNovaSenha))
            {
                gravarLog($sqlNovaSenha);
                $mensagem = "<span style='color: #00a201; '>Senha atualizada com sucesso! Redirecionando a página de login!</span>";
                $con->query("DELETE FROM `reset_senhas` WHERE `token` = '$token'");
                echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=index.php'>";
            }
            else
            {
                $mensagem = "<span style='color: #ff0000; '><strong>Erro ao atualizar! Tente novamente</strong></span>";
            }
        }
        else
        {
            $mensagem = "<span style='color: #ff0000; '><strong>Link Inválido! Tente recuperar sua senha novamente</strong></span>";
        }
    }
    else
    {
        $mensagem = "<span style='color: #ff0000; '><strong>Senhas não conferem</strong></span>";
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
                    </div>
                </div>

                <?php if ($linkValido){ ?>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <form action="reset.php?token=<?= $_GET['token'] ?>" method="post">
                                <div class="form-group has-feedback">
                                    <label for="novaSenha">Nova senha: </label>
                                    <input type="password" class="form-control" id="novaSenha" name="novaSenha"
                                           required>
                                </div>
                                <div class="form-group has-feedback" id="divConfirmaSenha">
                                    <label for="confirmaSenha">Confirmar Senha: </label>
                                    <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha"
                                           onblur="comparaSenhas()" onkeypress="comparaSenhas()" required>
                                    <span class="help-block" id="spanHelp"></span>
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-12">
                                        <input type="hidden" name="reset">
                                        <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
                                        <button type="submit" id="atualizar" class="btn btn-primary btn-block btn-flat">
                                            Atualizar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <a href="./index.php" class="btn btn-theme btn-md btn-block form-control">Voltar a Tela de Login</a>
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

        <script language="JavaScript">
            function comparaSenhas() {
                let senha = document.getElementById("novaSenha");
                let confirmaSenha = document.getElementById("confirmaSenha");
                let divConfirmaSenha = document.getElementById("divConfirmaSenha");
                document.getElementById("atualizar").disabled = true;
                divConfirmaSenha.classList.add("has-error");
                document.getElementById("spanHelp").innerHTML = "Senha não confere";

                if (senha.value == confirmaSenha.value) {
                    document.getElementById("atualizar").disabled = false;
                    divConfirmaSenha.classList.remove("has-error");
                    document.getElementById("spanHelp").innerHTML = "";

                } else {
                }
            }
        </script>
    </body>
</html>