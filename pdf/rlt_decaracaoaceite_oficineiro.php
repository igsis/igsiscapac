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
header("Content-Disposition: attachment;Filename=declaracao-aceite-$Nome.doc");
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
?>
<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<body>
    <div style="font-family: sans-serif">
        <p align='center'><strong>DECLARAÇÃO DE ACEITE</strong></p>

        <p>&nbsp;</p>

        <p><strong>DECLARO,</strong> na condição de inscrito, que:</p>

        <p>&nbsp;</p>

        <p style="text-align: justify">&bull; Conheço e aceito incondicionalmente as regras do presente Edital de Credenciamento;</p>
        <p style="text-align: justify">&bull; Responsabilizo-me por todas as informações contidas no projeto;</p>
        <p style="text-align: justify">&bull; Tenho ciência de que o credenciamento da Oficina não gera automaticamente direito às
            contratações e que, mesmo credenciado, a Secretaria Municipal de Cultura não tem obrigatoriedade de efetivar
            a contratação do projeto, pois a pauta fica condicionada aos critérios de interesse público, de adequação à
            programação cultural e de disponibilidade orçamentária de cada equipamento.</p>
        <p style="text-align: justify">&bull; Em caso de seleção, responsabilizo-me pelo cumprimento da agenda acordada entre o
            equipamento municipal e o Oficineiro, no tocante ao local, data e horário, para a realização da Oficina.</p>
        <p style="text-align: justify">&bull; Declaro que não sou servidor público municipal.</p>
        <p style="text-align: justify">&bull; Estou ciente de que a contratação não gera vínculo trabalhista entre a Municipalidade
            e o Contratado.</p>

        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <p align="center"><?= strftime('São Paulo, %d/%m/%Y') ?></p>

        <p>&nbsp;</p>

        <p align="center">___________________________________________________________</p>
        <p align="center">
            Assinatura do Proponente <br/>
            <?=$Nome?><br/>
            <?=$RG?>
        </p>
    </div>
</body>
</html>