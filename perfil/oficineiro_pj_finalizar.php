<?php

$con = bancoMysqli();
$idPj = $_SESSION['idPj'];
$pj = recuperaDados("pessoa_juridica","id",$idPj);
$tipoPessoa = 5;
$contador = 0;

$idDados = recuperaIdDadosOficineiro($tipoPessoa, $idPj);
$dados = recuperaDados('oficina_dados', 'id', $idDados);
$nivel = recuperaDados('oficina_niveis', 'id', $dados['oficina_nivel_id']);
$linguagem = recuperaDados('oficina_linguagens', 'id', $dados['oficina_linguagem_id']);
$sublinguagem = recuperaDados('oficina_sublinguagens', 'id', $dados['oficina_sublinguagem_id']);
$modalidade = recuperaDados('modalidades', 'id', $dados['modalidade_id']);

function listaArquivoCamposMultiplos1($idPessoa,$pf, $tipoPessoa = '2')
{
    $con = bancoMysqli();
    switch ($pf) {
        case 1: //todos os arquivos de pf
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				AND arq.publicado = '1'
				ORDER BY documento";
            break;
        case 2: //todos os arquivos de pj
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				AND arq.publicado = '1'
				AND list.id NOT IN (20,21,103,104)
				ORDER BY documento";
            break;
        case 3: //representante_legal1
            $arq1 = "AND (list.id = '20' OR ";
            $arq2 = "list.id = '21'OR ";
            $arq3 = "list.id = '103' OR ";
            $arq4 = "list.id = '104')";
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
            break;
        case 4: //grupo
            $arq1 = "AND (list.id = '99' OR ";
            $arq2 = "list.id = '100' OR";
            $arq3 = "list.id = '101' OR";
            $arq4 = "list.id = '102')";
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '3'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
            break;
        case 5: //evento
            $arq1 = "AND (list.id = '23' OR ";
            $arq2 = "list.id = '65' OR";
            $arq3 = "list.id = '78' OR";
            $arq4 = "list.id = '96' OR";
            $arq5 = "list.id = '97' OR";
            $arq6 = "list.id = '101')";
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '3'
				$arq1 $arq2 $arq3 $arq4 $arq5 $arq6
				AND arq.publicado = '1'";
            break;
        case 6: //todos os arquivos de pj oficineiro
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				AND arq.publicado = '1'
				AND list.id NOT IN (123, 124, 125, 126)
				ORDER BY documento";
            break;
        case 7: //representante_legal1 Oficineiro
            $arq1 = "AND (list.id = '123' OR ";
            $arq2 = "list.id = '124'OR ";
            $arq3 = "list.id = '125' OR ";
            $arq4 = "list.id = '126')";
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
            break;
        default:
            break;
    }
    $query = mysqli_query($con,$sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0)
    {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
        while($arquivo = mysqli_fetch_array($query))
        {
            echo "<tr>";
            echo "<td class='list_description' width='5%'>".$arquivo['documento']."</td>";
            echo "<td class='list_description'><a href='../../igsiscapac/uploadsdocs/".$arquivo['arquivo']."' target='_blank'>".$arquivo['arquivo']."</td>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    }
    else
    {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_oficinas.php'; ?>

        <div class="form-group">
            <h4>Finalizar</h4>
            <p>
                <strong>
                    <span style="color: green;">
                        Todos os campos obrigatórios foram preenchidos corretamente.<br/>
                        Seu cadastro de Pessoa Física foi concluído com sucesso!<br>
                    </span>
                </strong>
            </p><br>
            <div class="alert alert-success ">
                Seu Código de Cadastro é <strong>5-<?= $pj['id'] ?></strong>
            </div>
            <div class="container">
                <div class = "page-header"> <h5>Informações Pessoais </h5><br></div>
                <div class="well">
                    <p align="justify"><strong>Razão Social:</strong> <?php echo $pj['razaoSocial']; ?></p>
                    <p align="justify"><strong>CNPJ:</strong> <?php echo $pj['cnpj']; ?></p>
                    <p align="justify"><strong>CCM:</strong> <?php echo $pj['ccm']; ?></p>
                    <p align="justify"><strong>Email:</strong> <?php echo $pj['email']; ?><p>
                    <p align="justify"><strong>Telefone 1:</strong> <?php echo $pj['telefone1']; ?><p>
                    <p align="justify"><strong>Telefone 2:</strong> <?php echo $pj['telefone2']; ?><p>
                    <p align="justify"><strong>Telefone 3:</strong> <?php echo $pj['telefone3']; ?><p>
                </div>
            </div>

            <div class="table-responsive list_inf">
                <div class = "page-header"><h5>Endereço: </h5><br></div>
                <div class="well">
                    <p align="justify"><strong>CEP:</strong> <?php echo $pj['cep']; ?></p>
                    <p align="justify"><strong>Logradouro:</strong> <?php echo $pj['logradouro']; ?></p>
                    <p align="justify"><strong>Número:</strong> <?php echo $pj['numero']; ?></p>
                    <p align="justify"><strong>Complemento:</strong> <?php echo $pj['complemento']; ?></p>
                    <p align="justify"><strong>Bairro:</strong> <?php echo $pj['bairro']; ?></p>
                    <p align="justify"><strong>Cidade:</strong> <?php echo $pj['cidade']; ?></p>
                    <p align="justify"><strong>Estado:</strong> <?php echo $pj['estado']; ?></p>
                </div>
            </div>

            <div class="table-responsive list_inf">
                <div class = "page-header"><h5>Informações Complementares: </h5><br></div>
                <div class="well">
                    <p align="justify"><strong>Linguagem:</strong> <?php echo $linguagem['linguagem']; ?></p>
                    <p align="justify"><strong>Sub-Linguagem:</strong> <?php echo $sublinguagem['sublinguagem']; ?></p>
                    <p align="justify"><strong>Nível:</strong> <?php echo $nivel['nivel']; ?></p>
                    <p align="justify"><strong>Banco:</strong> <?php echo $pj['codigoBanco']; ?></p>
                    <p align="justify"><strong>Agência:</strong> <?php echo $pj['agencia']; ?></p>
                    <p align="justify"><strong>Conta:</strong> <?php echo $pj['conta']; ?></p>
                </div>
            </div>

            <div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Jurídica</h6>
                <?php
                listaArquivoCamposMultiplos1($pj['id'], 6, $tipoPessoa); ?>
            </div>

            <div class="table-responsive list_info"><h6>Arquivo(s) Representante Legal</h6>
                <?php
                listaArquivoCamposMultiplos1($pj['id'], 7, $tipoPessoa); ?>
            </div>
</section>