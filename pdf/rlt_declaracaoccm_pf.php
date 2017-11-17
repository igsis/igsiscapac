<?php

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$conexao = bancoMysqli();

session_start();

//CONSULTA
$idPf = $_SESSION['idPf'];

$pessoa = recuperaDados("pessoa_fisica","id",$idPf);

$Nome = $pessoa["nome"];
$RG = $pessoa["rg"];
$CPF = $pessoa["cpf"];


header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=declaracao-ccm-$Nome.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo
	"<p align='center'><strong>DECLARAÇÃO</strong></p>".
	"<p>&nbsp;</p>".
	"<p align='justify'>Declaro, sob as penas da lei, que não sou inscrito no CCM de São Paulo, que não tenho débitos perante a Fazenda Pública Municipal de São Paulo no tocante a encargos tributários e que estou ciente de que o ISS sobre a operação será retido.</p>".
	"<p>&nbsp;</p>".
	"<p>______________________________________________________</p>".
	"<p><strong>Nome:</strong> ".$Nome."<br/>".
	"<strong>RG:</strong> ".$RG."<br/>".
	"<strong>CPF:</strong> ".$CPF."</p>";
echo "</body>";
echo "</html>";
?>