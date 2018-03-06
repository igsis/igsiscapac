<?php

$con = bancoMysqli();
$campoPreenchido = $_SESSION['avisos'];
$idPf = $_SESSION['idPf'];
$pf = recuperaDados("pessoa_fisica","id",$idPf);
$contador = 0;

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>Finalizar</h4>
		</div>
		<?php for($i = 1; $i <= 5; $i++)
					if($campoPreenchido[$i] != 0 || $campoPreenchido != NULL)
						$contador++;
		$contador = 0;
		if($contador > 0){
			 ?><p><strong><font color="red">O(s) seguinte(s) campo(s) obrigatório(s) não foram preenchidos:</font></strong></p><br>
			<?php if($campoPreenchido[1] != NULL)
					echo "<a href='index.php?perfil=informacoes_iniciais_pf'> $campoPreenchido[1] </a><br>";
				  if($campoPreenchido[2] != NULL)
				  	echo "<a href='index.php?perfil=informacoes_iniciais_pf'> $campoPreenchido[2] </a><br>";
				  if($campoPreenchido[3] != NULL)
				  	echo "<a href='index.php?perfil=informacoes_iniciais_pf'> $campoPreenchido[3] </a><br>";
				  if($campoPreenchido[4] != NULL)
				  	echo "<a href='index.php?perfil=informacoes_iniciais_pf'> $campoPreenchido[4] </a><br>";
				  if($campoPreenchido[5] != NULL)
				  	echo "<a href='index.php?perfil=informacoes_iniciais_pf'> $campoPreenchido[5] </a><br>";
		}
		else{
			?><p><strong><font color="green">Todos os campos foram preenchidos corretamente.</font></strong></p><br><?php
	}?>
	<div class="container">
		 <div class = "page-header"> <h5>Informações Pessoais </h5><br></div>
			<p align="justify"><strong>Referência:</strong> <?php echo $idPf; ?></p>
			<p align="justify"><strong>Nome:</strong> <?php echo $pf['nome']; ?></p>
			<p align="justify"><strong>Nome artístico:</strong> <?php echo $pf['nomeArtistico']; ?></p>
			<p align="justify"><strong>Data de Nascimento:</strong> <?php echo $pf['dataNascimento']; ?></p>
			<p align="justify"><strong>RG:</strong> <?php echo $pf['rg']; ?><p>
			<p align="justify"><strong>CPF:</strong> <?php echo $pf['cpf']; ?><p>
			<p align="justify"><strong>PIS/PASEP/NIT:</strong> <?php echo $pf['pis']; ?><p>
			<p align="justify"><strong>Email:</strong> <?php echo $pf['email']; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo $pf['telefone1']; ?><p>
	</div>

	<div class="table-responsive list_inf">
		<div class = "page-header"><h5>Endereço: </h5><br></div>
			<p align="justify"><strong>CEP:</strong> <?php echo $pf['cep']; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo $pf['logradouro']; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo $pf['numero']; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo $pf['complemento']; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo $pf['bairro']; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo $pf['cidade']; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo $pf['estado']; ?></p>
	</div>

	<div class="table-responsive list_inf">
		<div class = "page-header"><h5>Informações Complementares: </h5><br></div>
			<p align="justify"><strong>DRT:</strong> <?php echo $pf['drt']; ?></p>
			<p align="justify"><strong>Banco:</strong> <?php echo $pf['codigoBanco']; ?></p>
			<p align="justify"><strong>Agência:</strong> <?php echo $pf['agencia']; ?></p>
			<p align="justify"><strong>Conta:</strong> <?php echo $pf['conta']; ?></p>
	</div>
</section>