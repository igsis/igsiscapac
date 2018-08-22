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
$idPj = $_SESSION['idPj'];
$idEvento = $_SESSION['idEvento'];

$pessoa = recuperaDados("pessoa_juridica","id",$idPj);

$rep01 = recuperaDados("representante_legal","id",$pessoa['idRepresentanteLegal1']);
$rep02 = recuperaDados("representante_legal","id",$pessoa['idRepresentanteLegal2']);
$evento = recuperaDados("evento","id",$idEvento);
$executante = recuperaDados("pessoa_fisica","id",$evento['idPf']);


//PessoaJuridica
$pjRazaoSocial = $pessoa["razaoSocial"];
$pjCNPJ = $pessoa['cnpj'];
$pjNumEndereco = $pessoa["numero"];
$pjComplemento = $pessoa["complemento"];
$pjcep = $pessoa["cep"];

// Representante01
$rep01Nome = $rep01["nome"];
$rep01RG = $rep01["rg"];
$rep01CPF = $rep01["cpf"];

//Representante02
$rep02Nome = $rep02["nome"];
$rep02RG = $rep02["rg"];
$rep02CPF = $rep02["cpf"];

//Executante
$exNome = $executante["nome"];
$exRG = $executante["rg"];
$exCPF = $executante["cpf"];

$grupo = $evento["nomeGrupo"];
$Objeto = $evento["nomeEvento"];
$integrantes = $evento["integrantes"];

$ano=date('Y');


// GERANDO O PDF:
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
       $pdf->MultiCell(170,$l,utf8_decode("Eu, "."$exNome".", RG "."$exRG".", CPF "."$exCPF".", sob penas da lei, declaro que sou representado exclusivamente pela empresa "."$pjRazaoSocial"."."));

     $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);   
     $pdf->MultiCell(170,$l,utf8_decode("Estou ciente de que o pagamento dos valores decorrentes dos serviços é de responsabilidade da minha representante, não me cabendo pleitear à Prefeitura quaisquer valores eventualmente não repassados."));

     $pdf->Ln();

   if ($rep02Nome != '')
     {
     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);   
     $pdf->MultiCell(170,$l,utf8_decode(""."$pjRazaoSocial".", representada por "."$rep01Nome".", RG "."$rep01RG".", CPF "."$rep01CPF"." e "."$rep02Nome".", RG "."$rep02RG".", CPF "."$rep02CPF".", declara sob penas da lei ser representante de "."$exNome"."."));
      } 
      else 
      {
       $pdf->SetX($x);
       $pdf->SetFont('Arial','', 11);   
       $pdf->MultiCell(170,$l,utf8_decode(""."$pjRazaoSocial".", representada por "."$rep01Nome".", RG "."$rep01RG".", CPF "."$rep01CPF"." declara sob penas da lei ser representante de "."$exNome"."."));
      }

     $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Declaro, sob as penas da lei, que não sou servidor público municipal e que não me encontro em impedimento para contratar com a Prefeitura do Município de São Paulo / Secretaria Municipal de Cultura, mediante recebimento de cachê e/ou bilheteria, quando for o caso."));

     $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(170,$l,utf8_decode("Declaro, sob as penas da lei, dentre os integrantes abaixo listados não há crianças e adolescentes.  Quando houver, estamos cientes que é de nossa responsabilidade a adoção das providências de obtenção  de  decisão judicial  junto à Vara da Infância e Juventude."));

    $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Declaro, ainda, neste ato, que autorizo, a título gratuito, por prazo indeterminado, a Municipalidade de São Paulo, através da SMC, o uso da nossa imagem, voz e performance nas suas publicações em papel e qualquer mídia digital, streaming ou internet existentes ou que venha a existir como também para os fins de arquivo e material de pesquisa e consulta."));

     $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("A empresa fica autorizada a celebrar contrato, inclusive receber cachê e/ou bilheteria quando for o caso, outorgando quitação."));


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

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("_______________________________"),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("Representante Legal 1: "."$rep01Nome".""),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("RG: "."$rep01RG".""),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("CPF: "."$rep01CPF".""),0,1,'L');

   $pdf->Ln();

   if ($rep02Nome != '')
   {

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("_______________________________"),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("Representante Legal 2: "."$rep02Nome".""),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("RG: "."$rep02RG".""),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("CPF: "."$rep02CPF".""),0,1,'L');
   }
   


$pdf->Output();


?>