<?php

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$conexao = bancoMysqli();

session_start();

class PDF extends FPDF
{

// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Simple table
function Cabecalho($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data

}

// Simple table
function Tabela($header, $data)
{
    //Data
    foreach($data as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data

}



}

//CONSULTA
$idPf = $_SESSION['idPf'];
$idEvento = $_SESSION['idEvento'];

$pessoa = recuperaDados("pessoa_fisica","id",$idPf);
$evento = recuperaDados("evento","id",$idEvento);
$executante = recuperaDados("pessoa_fisica","id",$evento['idPf']);


//Executante
$exNome = $executante["nome"];
$exRG = $executante["rg"];
$exCPF = $executante["cpf"];

$grupo = $evento["nomeGrupo"];
$Objeto = $evento["nomeEvento"];
$integrantes = $evento["integrantes"];


$ano=date('Y');


//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=6; //DEFINE A ALTURA DA LINHA   
   
$pdf->SetXY( $x , 15 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

 $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 14);
   $pdf->Cell(180,5,utf8_decode("DECLARAÇÃO DE EXCLUSIVIDADE"),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Eu, "."$exNome".", RG "."$exRG".", CPF "."$exCPF".", sob penas da lei, declaro que sou líder do grupo "."$grupo".", que possui os integrantes abaixo listados, e que o mesmo é representado exclusivamente por mim. "));

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Declaro, sob as penas da Lei, que não sou servidor público municipal e que não me encontro em impedimento para contratar com a Prefeitura do Município de São Paulo / Secretaria Municipal de Cultura, mediante recebimento de cachê e/ou bilheteria, quando for o caso. "));

    $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Declaro, sob as penas da lei, dentre os integrantes abaixo listados não há crianças e adolescentes. Quando houver, estamos cientes que é de nossa responsabilidade a adoção das providências de obtenção  de  decisão judicial  junto à Vara da Infância e Juventude."));


   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Declaro, ainda, neste ato, que autorizo, a título gratuito, por prazo indeterminado, a Municipalidade de São Paulo, através da SMC, o uso da nossa imagem, voz e performance nas suas publicações em papel e qualquer mídia digital, streaming ou internet existentes ou que venha a existir como também para os fins de arquivo e material de pesquisa e consulta."));

    $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Fico autorizado a celebrar contrato, inclusive receber cachê e/ou bilheteria quando for o caso, outorgando quitação."));


    $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Estou ciente de que o pagamento dos valores decorrentes dos serviços é de minha responsabilidade, não cabendo pleitear à Prefeitura quaisquer valores eventualmente não repassados."));

    $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Integrantes do grupo: "."$integrantes".""));

   $pdf->Ln();


   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("São Paulo, _______ / _______ / " .$ano."."),0,1,'L');

   $pdf->Ln();   

    $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("_______________________________"),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("Nome do Líder do Grupo: "."$exNome".""),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("RG: "."$exRG".""),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("CPF: "."$exCPF".""),0,1,'L');

   $pdf->Ln();

$pdf->Output();


?>