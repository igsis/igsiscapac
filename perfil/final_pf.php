<?php

$con = bancoMysqli();
$idPf = $_SESSION['idPf'];
$pf = recuperaDados("pessoa_fisica","id",$idPf);
$tipoPessoa = ($pf['oficineiro'] == 1) ? 4 : 1;
$contador = 0;

function recuperaBanco($campoY)
{
	$banco = recuperaDados("banco","id",$campoY);
	$nomeBanco = $banco['banco'];
	return $nomeBanco;
}

function listaArquivoCamposMultiplos1($idPessoa,$pf, $tipoPessoa = '1')
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
				AND arq.idTipoPessoa = '2'
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
				AND arq.idTipoPessoa = '2'
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
        <?php
        if ($pf['oficineiro'] == 1)
        {
            include 'includes/menu_oficinas.php';
        }
        else
        {
            include 'includes/menu_evento.php';
        }
        ?>
		<div class="form-group">
			<h4>Finalizar</h4>
	<p><strong><font color="green">Todos os campos obrigatórios foram preenchidos corretamente.<br/> Seu cadastro de Pessoa Física foi concluído com sucesso!</font></strong></p><br>
	<div class="container">
		 <div class = "page-header"> <h5>Informações Pessoais </h5><br></div>
		 <div class="well">
			<p align="justify"><strong>Nome:</strong> <?php echo $pf['nome']; ?></p>
			<p align="justify"><strong>Nome artístico:</strong> <?php echo $pf['nomeArtistico']; ?></p>
			<p align="justify"><strong>Data de Nascimento:</strong> <?php echo date_format(date_create($pf['dataNascimento']), 'd/m/Y'); ?></p>
			<p align="justify"><strong>RG:</strong> <?php echo $pf['rg']; ?><p>
			<p align="justify"><strong>CPF:</strong> <?php echo $pf['cpf']; ?><p>
			<p align="justify"><strong>PIS/PASEP/NIT:</strong> <?php echo $pf['pis']; ?><p>
			<p align="justify"><strong>Email:</strong> <?php echo $pf['email']; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo $pf['telefone1']; ?><p>
	</div>
	</div>

	<div class="table-responsive list_inf">
		<div class = "page-header"><h5>Endereço: </h5><br></div>
		<div class="well">
			<p align="justify"><strong>CEP:</strong> <?php echo $pf['cep']; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo $pf['logradouro']; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo $pf['numero']; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo $pf['complemento']; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo $pf['bairro']; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo $pf['cidade']; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo $pf['estado']; ?></p>
	</div>
	</div>

	<div class="table-responsive list_inf">
		<div class = "page-header"><h5>Informações Complementares: </h5><br></div>
		<div class="well">
			<p align="justify"><strong>DRT:</strong> <?php echo $pf['drt']; ?></p>
			<p align="justify"><strong>Banco:</strong> <?php echo recuperaBanco ($pf['codigoBanco']); ?></p>
			<p align="justify"><strong>Agência:</strong> <?php echo $pf['agencia']; ?></p>
			<p align="justify"><strong>Conta:</strong> <?php echo $pf['conta']; ?></p>
	</div>
	</div>

	<div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Física</h6>
		<?php listaArquivoCamposMultiplos1($pf['id'],1, $tipoPessoa); ?>
	</div>
</section>