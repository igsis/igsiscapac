<?php
$idEvento = $_SESSION['idEvento'];
$evento = recuperaDados("evento","id",$idEvento);
$tipoEvento = recuperaDados("tipo_evento","id",$evento['idTipoEvento']);
$faixaEtaria = recuperaDados("faixa_etaria","id",$evento['idFaixaEtaria']);
$bool = false;
$mensagem = "";

function listaArquivosComProd($idEvento)
{
	//lista arquivos de determinado evento
	$con = bancoMysqli();
	$sql = "SELECT * FROM upload_arquivo_com_prod WHERE idEvento = '$idEvento' AND publicado = '1'";
	$query = mysqli_query($con,$sql);
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
	while($campo = mysqli_fetch_array($query))
	{
		echo "<tr>";
		echo "<td class='list_description'><a href='../uploads/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
		echo "</tr>";
	}
	echo "
		</tbody>
		</table>";
}
$i = 0;
if($evento['nomeEvento'] == NULL)
{
	$mensagem = "<a href='index.php?perfil=evento_edicao'>Nome do evento</a><br/>";
	$i = 1;
}
if($evento['idTipoEvento'] == NULL)
{
	$mensagem = $mensagem."<a href='index.php?perfil=evento_edicao'>Tipo de evento</a><br/>";
	$i = 1;
}
if($evento['fichaTecnica'] == NULL)
{
	$mensagem = $mensagem."<a href='index.php?perfil=evento_edicao'>Ficha técnica</a><br/>";
	$i = 1;
}
if($evento['idFaixaEtaria'] == NULL OR $evento['idFaixaEtaria'] == 0)
{
	$mensagem = $mensagem."<a href='index.php?perfil=evento_edicao'>Faixa Etária</a><br/>";
	$i = 1;
}
if($evento['sinopse'] == NULL)
{
	$mensagem = $mensagem."<a href='index.php?perfil=evento_edicao'>Sinopse</a><br/>";
	$i = 1;
}
if($evento['releaseCom'] == NULL)
{
	$mensagem = $mensagem."<a href='index.php?perfil=evento_edicao'>Realease</a><br/>";
	$i = 1;
}
$produtor = recuperaDados("produtor","id",$evento['idProdutor']);
if($produtor['nome'] == NULL)
{
	$mensagem = $mensagem."<center><a href='index.php?perfil=produtor_edicao'> Nome do produtor</a><br/>";
	$i = 1;
}
if($produtor['email'] == NULL)
{
	$mensagem = $mensagem."<a href='index.php?perfil=produtor_edicao'>E-mail do produtor</a><br/>";
	$i = 1;
}
if($produtor['telefone1'] == NULL)
{
	$mensagem = $mensagem."<a href='index.php?perfil=produtor_edicao'>Celular do produtor</a><br/></center>";
	$i = 1;
}

if(isset($_POST['enviar']))
{
	$sql_envia = "UPDATE `evento` SET `publicado`= 2 WHERE `id` = '$idEvento'";
	$con = bancoMysqli();
	if(mysqli_query($con,$sql_envia))
	{
		$mensagem = "<h4><font color='#01DF3A'>Enviado com sucesso! Entre em contato com o programador do seu evento e informe o código do CAPAC: </font><font color='#FF0000'>".$idEvento."</font></h4>";
		gravarLog($sql_envia);
		$bool = true;
	}
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>Finalizar</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<?php
						if($i == 0)
						{
						?>
							<p><strong><font color='#01DF3A'>Não há pendências de preenchimento de campos.</font></strong></p>
						<?php
						}
						else
						{
						?>
							<p><strong><font color="red">O(s) seguinte(s) campo(s) obrigatório(s) não foram preenchidos:</font></strong></p>
						<?php
						}
						?>
						<p align="center">
							<?php 
							if(isset($mensagem)){
								echo $mensagem;
							};
							?></p>
					</div>
				</div>

				<!-- Início de Detalhes -->
				<div class="left">
					<p align="justify"><br><br><br><br><br><br><strong>Tipo de evento:</strong> <?php echo $tipoEvento['tipoEvento'] ?></p>
					<p align="justify"><strong>Nome de Grupo:</strong> <?php echo $evento['nomeGrupo'] ?></p>
					<p align="justify"><strong>Ficha Técnica:</strong> <?php echo $evento['fichaTecnica'] ?></p>
					<p align="justify"><strong>Faixa Etária:</strong> <?php echo $faixaEtaria['faixaEtaria'] ?></p>
					<p align="justify"><strong>Sinopse:</strong> <?php echo $evento['sinopse'] ?></p>
					<p align="justify"><strong>Release:</strong> <?php echo $evento['releaseCom'] ?></p>
					<p align="justify"><strong>Links:</strong> <?php echo $evento['link'] ?></p>
					<p align="justify"><strong>Data Cadastro:</strong> <?php echo exibirDataHoraBr($evento['dataCadastro']) ?></p>
					<br/>
					<h5>Informações de Produção</h5>
					<p align="justify"><strong>Nome do Produtor:</strong> <?php echo $produtor['nome'] ?></p>
					<p align="justify"><strong>E-mail:</strong> <?php echo $produtor['email'] ?></p>
					<p align="justify"><strong>Telefone:</strong> <?php echo $produtor['telefone1']." | ".$produtor['telefone2'] ?></p>
					<br/>
					
					<div class="table-responsive list_info"><h6>Arquivo(s) para Comunicação/Produção</h6>
						<?php listaArquivosComProd($idEvento); ?>
					</div>

				</div>
				<!-- Fim detalhes do evento -->
				<!-- Botão para Voltar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
							<form class="form-horizontal" role="form" action="?perfil=arquivos_com_prod" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>
					</div>
				<!-- Botão para Voltar -->
					<div class="form-group">
					<!-- FIM Botão para Voltar -->
						<div class="col-md-offset-4 col-md-2">
							<?php
							if($i == 0)
							{
								if($bool == false){
							?>
								<form class="form-horizontal" role="form" action="?perfil=finalizar_evento" method="post">
									<input type="submit" name="enviar" value="ENVIAR" class="btn btn-theme btn-lg btn-block">
								</form>
							<?php
							} else {} }
							else
							{
							?>
								<br/><br/>
								<h6><font color='#FF0000'>Para habilitar o botão de envio, preencha todos os campos obrigatórios.</font></h6>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>