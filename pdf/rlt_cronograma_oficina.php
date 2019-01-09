<?php
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

session_start();

$con = bancoMysqli();

$idModalidade = $_POST['modalidade'];
$tabela = ($_POST['tipoPessoa'] == 4) ? "pessoa_fisica" : "pessoa_juridica";

$modalidade = recuperaDados('modalidades', 'id', $idModalidade);
$oficineiro = recuperaDados($tabela, 'id', $_POST['id']);
$nome = ($_POST['tipoPessoa'] == 4) ? $oficineiro['nome'] : $oficineiro['razaoSocial'];

if ($_POST['tipoPessoa'] == 4)
{
    $documento = $oficineiro['rg'];
}
else
{
    $representante = recuperaDados('representante_legal', 'id', $oficineiro['idRepresentanteLegal1']);
    $documento = $representante['rg'];
}

$nomeOficina = addslashes($_POST['nomeOficina']);
$sinopseOficina = addslashes($_POST['sinopseOficina']);

$idDados = $_POST['idDadosOficineiro'];
$sql_dados = "UPDATE `oficina_dados` SET 
                `modalidade_id` = '$idModalidade',
                `nomeOficina` = '$nomeOficina',
                `sinopseOficina` = '$sinopseOficina'
              WHERE `id` = '$idDados'";
$query = $con->query($sql_dados);
if ($query)
{
    gravarLog($sql_dados);
}

$dados = recuperaDados('oficina_dados', 'id', $idDados);
$linguagem = recuperaDados('oficina_linguagens', 'id', $dados['oficina_linguagem_id']);
$nivel = recuperaDados('oficina_niveis', 'id', $dados['oficina_nivel_id']);
$subLinguagem = recuperaDados('oficina_sublinguagens', 'id', $dados['oficina_sublinguagem_id']);

function geraCronogramaOficina($idModalidade)
{
    $modalidade = recuperaDados('modalidades', 'id', $idModalidade);

    switch ($modalidade['meses_atividade'])
    {
        case 1:
            echo "<table border='1' style='font-family: sans-serif'>
                    <thead>
                        <tr align='center' bgcolor='#d3d3d3'>
                            <th width='10%'>MÊS</th>
                            <th width='10%'>DIAS</th>
                            <th width='5%'>CARGA HORÁRIA TOTAL (horas)</th>
                            <th width='5%'>VALOR TOTAL (R$) / PARCELAS</th>
                            <th width='30%'>ATIVIDADES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align='center' height='100'>1:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>Mês seguinte ao encerramento do projeto</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>Parcela 1 de 1 <br> R$ _______</td>
                            <td align='center' height='100'>----</td>
                        </tr>
                    </tbody>
                  </table>";
            break;

        case 3:
            echo "<table border='1' style='font-family: sans-serif'
                    <thead>
                        <tr align='center' bgcolor='#d3d3d3'>
                            <th width='10%'>MÊS</th>
                            <th width='10%'>DIAS</th>
                            <th width='5%'>CARGA HORÁRIA TOTAL (horas)</th>
                            <th width='5%'>VALOR TOTAL (R$) / PARCELAS</th>
                            <th width='30%'>ATIVIDADES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align='center' height='100'>1:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>2:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 1 de 2</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(1ª parcela: a partir do primeiro dia útil subsequente à comprovação da execução do primeiro mês de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>3:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>Mês seguinte ao encerramento do projeto</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 2 de 2</p>
                                <p>R$ _______</p>
                                <p><span style='font-style: italic'>(2ª parcela: a partir do primeiro dia útil subsequente à comprovação do encerramento do projeto.)</span></p>
                                </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                    </tbody>
                  </table>";
            break;

        case 4:
            echo "<table border='1' style='font-family: sans-serif'>
                    <thead>
                        <tr align='center' bgcolor='#d3d3d3'>
                            <th width='10%'>MÊS</th>
                            <th width='10%'>DIAS</th>
                            <th width='5%'>CARGA HORÁRIA TOTAL (horas)</th>
                            <th width='5%'>VALOR TOTAL (R$) / PARCELAS</th>
                            <th width='30%'>ATIVIDADES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align='center' height='100'>1:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>2:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>3:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 1 de 2</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(1ª parcela: a partir do primeiro dia útil subsequente à comprovação da execução dos 2 primeiros meses de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>4:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>Mês seguinte ao encerramento do projeto</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 2 de 2</p>
                                <p>R$ _______</p>
                                <p><span style='font-style: italic'>(2ª parcela: a partir do primeiro dia útil subsequente à comprovação do encerramento do projeto.)</span></p>
                                </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                    </tbody>
                  </table>";
            break;

        case 6:
            echo "<table border='1' style='font-family: sans-serif'
                    <thead>
                        <tr align='center' bgcolor='#d3d3d3'>
                            <th width='10%'>MÊS</th>
                            <th width='10%'>DIAS</th>
                            <th width='5%'>CARGA HORÁRIA TOTAL (horas)</th>
                            <th width='5%'>VALOR TOTAL (R$) / PARCELAS</th>
                            <th width='30%'>ATIVIDADES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align='center' height='100'>1:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>2:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>3:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 1 de 3</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(1ª parcela: a partir do primeiro dia útil subsequente à comprovação da execução dos 2 primeiros meses de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>4:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>5:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 2 de 3</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(2ª parcela: a partir do primeiro dia útil subsequente à comprovação da execução dos terceiro e quarto meses de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>6:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>Mês seguinte ao encerramento do projeto</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 3 de 3</p>
                                <p>R$ _______</p>
                                <p><span style='font-style: italic'>(3ª parcela: a partir do primeiro dia útil subsequente à comprovação do encerramento do projeto.)</span></p>
                                </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                    </tbody>
                  </table>";
            break;

        case 10:
            echo "<table border='1' style='font-family: sans-serif'>
                    <thead>
                        <tr align='center' bgcolor='#d3d3d3'>
                            <th width='10%'>MÊS</th>
                            <th width='10%'>DIAS</th>
                            <th width='5%'>CARGA HORÁRIA TOTAL (horas)</th>
                            <th width='5%'>VALOR TOTAL (R$) / PARCELAS</th>
                            <th width='30%'>ATIVIDADES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align='center' height='100'>1:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>2:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>3:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 1 de 5</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(1ª parcela: a partir do primeiro dia útil subsequente à comprovação da execução dos 2 primeiros meses de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>4:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>5:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 2 de 5</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(2ª parcela: a partir do primeiro dia útil subsequente à comprovação da execução dos terceiro e quarto meses de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>6:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>7:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 3 de 5</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(3ª parcela: a partir do primeiro dia útil subsequente à comprovação da execução dos quinto e sexto meses de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>8:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>9:</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 4 de 5</p> 
                                <p>R$ _______</p> 
                                <p><span style='font-style: italic'>(4ª parcela: partir do primeiro dia útil subsequente à comprovação da execução dos sétimo e oitavo meses de projeto.)</span></p> 
                            </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>10:</td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'></td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'></td>
                        </tr>
                        <tr>
                            <td align='center' height='100'>Mês seguinte ao encerramento do projeto</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>----</td>
                            <td align='center' height='100'>
                                <p>Parcela 5 de 5</p>
                                <p>R$ _______</p>
                                <p><span style='font-style: italic'>(5ª parcela: a partir do primeiro dia útil subsequente à comprovação do encerramento do projeto.)</span></p>
                                </td>
                            <td align='center' height='100'>----</td>
                        </tr>
                    </tbody>
                  </table>";
            break;

        default:
            return null;
            break;
    }
}

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=cronograma-oficinas.doc");
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

?>
<html lang="pt-BR">
    <meta http-equiv="Content-Type" charset="UTF-8">
    <head>
        <style>
            .sansSerif {
                font-family: sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="sansSerif">
            <p align='center'><strong>PROPOSTA E CRONOGRAMA DE REALIZAÇÃO DE OFICINAS</strong></p>
            <p align='center'><strong><?php echo $modalidade['modalidade']." - ".$modalidade['descricao'] ?></strong></p>

            <p>&nbsp;</p>

            <p style="text-align: justify">O presente projeto de Oficina foi selecionado a partir do <strong>EDITAL DE
                    CREDENCIAMENTO Nº 02 /2018 – SMC/GAB</strong>, o qual credenciou projetos de artistas e outros
                profissionais interessados em realizar oficinas em equipamentos da Secretaria Municipal de Cultura.</p>
            <p style="text-align: justify">O(a) contratado(a) executará o projeto de oficina <strong><?= $dados['nomeOficina'] ?></strong>, nos exatos
                termos de sua proposta apresentada na ocasião de sua inscrição para o referido Edital.</p>

            <p>&nbsp;</p>

            <p><strong>Nome do Oficineiro: </strong><?= $nome ?></p>
            <p><strong>Linguagem Artística e Cultural: </strong><?= $linguagem['linguagem'] ?> - <?= $subLinguagem['sublinguagem'] ?></p>
            <p><strong>Período: </strong>__/__/____ a __/__/____</p>
            <p><strong>Dias da Semana: </strong></p>
            <p><strong>Horário: </strong></p>
            <p><strong>Carga Horária Total: </strong></p>
            <p><strong>Local / Equipamento: </strong></p>
            <p><strong>Público: </strong></p>
            <p><strong>Nível: </strong><?= $nivel['nivel'] ?></p>

            <?php geraCronogramaOficina($idModalidade) ?>


            <p>&nbsp;</p>

            <p align="center"><?= strftime('São Paulo, %d de %B de %Y') ?></p>

            <p>&nbsp;</p>



            <table class="sansSerif">
                <tr>
                    <td>
                        <p align="left">_________________________</p>
                        <p align="left">
                            <strong>Oficineiro: </strong> <br/>
                            RG: <?= $documento ?>
                        </p>
                    </td>
                    <td width="100%"></td>
                    <td>
                        <p align="left">_________________________</p>
                        <p align="left">
                            <strong>Coordenador</strong> <br/>
                            RF:
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>