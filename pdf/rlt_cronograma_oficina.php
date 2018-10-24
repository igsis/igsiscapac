<?php

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

session_start();

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

$idModalidade = $_POST['modalidade'];

$modalidade = recuperaDados('modalidades', 'id', $idModalidade);

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=cronograma-oficinas.doc");
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
?>
<html>
    <meta http-equiv="Content-Type" charset="UTF-8">
    <body>
        <div style="font-family: sans-serif">
            <p align='center'><strong>PREFEITURA DA CIDADE DE SÃO PAULO</strong></p>
            <p align='center'><strong>PROPOSTA E CRONOGRAMA DE REALIZAÇÃO DE OFICINAS</strong></p>

            <p>&nbsp;</p>

            <p style="text-align: justify">A presente oficina foi selecionada através do Edital de Credenciamento nº 01/2017 – SMC/GAB de
                profissionais para prestação de serviços de desenvolvimento de oficinas livres para as Casas de Cultura e demais
                equipamentos da SMC.</p>
            <p style="text-align: justify">Oficina livre é um modo de educação não formal de duração variada e através desta prática os usuários
                da Casa de Cultura <strong>XXXXXXXXXXX</strong> poderão conhecer as diversas linguagens artísticas e culturais, atualizar-se,
                enriquecer sua experiência de vida e formação, participar de atividades de fruição, lazer e socialização.</p>
            <p style="text-align: justify">O(a) contratado(a) executará a Oficina de <strong>“_____________”</strong>, no período <strong>de xx
                    de xxxxxxx de 2018 a xx de XXXXXXX de 2018</strong>, em atividades semanais, <strong>as XXXXXXXXXX das XXXX
                    às XXXX horas para (IDENTIFICAR PÚBLICO)</strong> com carga horária total de <strong>XX horas</strong>,
                    distribuída na forma abaixo descrita:</p>

            <p>&nbsp;</p>

            <table border="1">
                <thead>
                    <tr align='center'>
                        <td width="10%">MÊS</td>
                        <td width="10%">DIAS</td>
                        <td width="5%">CARGA HORÁRIA</td>
                        <td width="5%">VALOR</td>
                        <td width="30%">ATIVIDADES</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for ($i = 1; $i <= $modalidade['meses_atividade']; $i++)
                        {
                    ?>
                            <tr>
                                <td align='center'><?=$i?></td>
                                <td align='center'></td>
                                <td align='center'></td>
                                <td align='center'></td>
                                <td align='center'></td>
                            </tr>
                    <?php
                        }
                    ?>
                        <tr>
                            <td></td>
                            <th>TOTAL</th>
                            <th>XX HS</th>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
            </table>

            <p>&nbsp;</p>

            <p align='justify'>Local de Realização da Oficina: Casa de Cultura <strong>XXXXXXX</strong></p>


            <p>&nbsp;</p>

            <p align="center"><?= strftime('São Paulo, %d de %B de %Y') ?></p>

            <p>&nbsp;</p>

            <p align="center">___________________________________________________________</p>
            <p align="center">
                Oficineiro <br/>
            </p>
        </div>
    </body>
</html>