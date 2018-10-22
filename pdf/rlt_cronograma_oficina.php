<?php

require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$conexao = bancoMysqli();

session_start();

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../pdf/img/facc_pf.jpg',15,10,180);
        // Line break
        $this->Ln(20);
    }
}

/**
 * @var FPDF $pdf
 */
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();