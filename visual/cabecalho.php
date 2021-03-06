<?php
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos
session_start();

if(!isset ($_SESSION['login']) == true) //verifica se há uma sessão, se não, volta para área de login
{
	unset($_SESSION['login']);
	header('location:../index.php');
}
else
{
	$logado = $_SESSION['login'];
}
?>

<html>
	<head>
		<title>IGSIS-CAPAC - <?= date("Y") ?> - v1.0 - Secretaria Municipal de Cultural - São Paulo</title>
		<meta charset="utf-8" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- css -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">
		<link href="color/default.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
		<?php include "../include/script.php"; ?>
    </head>
	<body>
        <div id="bar">
                <div class="col-xs-2" style="padding: 10px">
                    <img src="images/logo_cultura_h.png">
                </div>
                <div class="col-md-2" style="padding: 13px">
                    <span style="color: #fff">IGSIS-CAPAC</span>
                </div>

                <div class="col-md-offset-4 col-md-4" style="padding: 5px">
                    <span style="color: #fff">Dúvidas? Acesse o <a href="http://smcsistemas.prefeitura.sp.gov.br/manual/igsiscapac/" target="_blank">manual</a> ou entre em<br> contato com o seu programador</span>
                </div>
<!--                <div class="col-md-offset-4 col-md-4" style="padding: 5px">-->
<!--                    <span style="color: #fff">Suporte de T.I. via WhatsApp:<br><a href="https://wa.me/5511942430570" target="_blank"><i class="fab fa-whatsapp"></i> 94243-0570</a> | Seg-Sex, 10h-16h</span>-->
<!--                </div>-->

        </div>
		<!--<div id="bar">
			<p id="p-bar"><img src="images/logo_cultura_h.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IGSIS-CAPAC
			</p>
		</div>-->

<?php
	# Menu progresso
	include_once '../visual/smart_wizard.php';
?>