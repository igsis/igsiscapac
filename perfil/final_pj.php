<?php

$con = bancoMysqli();
$idPj = $_SESSION['idPj'];
$pj = recuperaDados("pessoa_juridica","id",$idPj);
$contador = 0;

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>Finalizar</h4>
	<p><strong><font color="green">Todos os campos obrigatórios foram preenchidos corretamente.</font></strong></p><br>
	<div class="container">
		 <div class = "page-header"> <h5>Informações Pessoais </h5><br></div>
		 <div class="well">
			<p align="justify"><strong>Referência:</strong> <?php echo $pj['id']; ?></p>
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
			<p align="justify"><strong>Banco:</strong> <?php echo $pj['codigoBanco']; ?></p>
			<p align="justify"><strong>Agência:</strong> <?php echo $pj['agencia']; ?></p>
			<p align="justify"><strong>Conta:</strong> <?php echo $pj['conta']; ?></p>
	</div>
	</div>
</section>