<?php

$idEvento = $_SESSION['idEvento'];
$evento = recuperaDados("evento","id",$idEvento);

$i = 0;

if($evento['nomeEvento'] == NULL)
{
	$mensagem = "Nome do evento<br/>";
	$i = 1;
}

if($evento['idTipoEvento'] == NULL)
{
	$mensagem = $mensagem."Tipo de evento<br/>";
	$i = 1;
}

if($evento['fichaTecnica'] == NULL)
{
	$mensagem = $mensagem."Ficha técnica<br/>";
	$i = 1;
}

if($evento['idFaixaEtaria'] == NULL OR $evento['idFaixaEtaria'] == 0)
{
	$mensagem = $mensagem."Faixa Etária<br/>";
	$i = 1;
}

if($evento['sinopse'] == NULL)
{
	$mensagem = $mensagem."Sinopse<br/>";
	$i = 1;
}

if($evento['releaseCom'] == NULL)
{
	$mensagem = $mensagem."Realease<br/>";
	$i = 1;
}

if($evento['idProdutor'] == NULL)
{
	$mensagem = $mensagem."Dados do produtor<br/>";
	$i = 1;
}

if($evento['idPf'] == NULL)
{
	$mensagem = $mensagem."Dados do artista<br/>";
	$i = 1;
}

$produtor = recuperaDados("produtor","id",$evento['idProdutor']);

if($produtor['nome'] == NULL)
{
	$mensagem = $mensagem."Nome do produtor<br/>";
	$i = 1;
}

if($produtor['email'] == NULL)
{
	$mensagem = $mensagem."E-mail do produtor<br/>";
	$i = 1;
}

if($produtor['telefone1'] == NULL)
{
	$mensagem = $mensagem."Celular do produtor<br/>";
	$i = 1;
}

$tipoPessoa = $evento['idTipoPessoa'];
if($tipoPessoa == 2)
{
	$pj = recuperaDados("pessoa_juridica","id",$evento['idPj']);

	if($pj['razaoSocial'] == NULL)
	{
		$mensagem = $mensagem."Razão Social<br/>";
		$i = 1;
	}

	if($pj['cnpj'] == NULL)
	{
		$mensagem = $mensagem."CNPJ<br/>";
		$i = 1;
	}

	if($pj['telefone1'] == NULL)
	{
		$mensagem = $mensagem."Celular da empresa<br/>";
		$i = 1;
	}

	if($pj['email'] == NULL)
	{
		$mensagem = $mensagem."E-mail da empresa<br/>";
		$i = 1;
	}

	if($pj['cep'] == NULL)
	{
		$mensagem = $mensagem."CEP da empresa<br/>";
		$i = 1;
	}

	if($pj['numero'] == NULL)
	{
		$mensagem = $mensagem."Número do endereço da empresa<br/>";
		$i = 1;
	}

	if($pj['idRepresentanteLegal1'] == NULL)
	{
		$mensagem = $mensagem."Dados do representante legal<br/>";
		$i = 1;
	}
}

$representante = recuperaDados("representante_legal","id",$pj['idRepresentanteLegal1']);
if($representante['nome'] == NULL)
{
	$mensagem = $mensagem."Nome do artista<br/>";
	$i = 1;
}

if($representante['rg'] == NULL)
{
	$mensagem = $mensagem."RG do artista<br/>";
	$i = 1;
}

if($representante['cpf'] == NULL)
{
	$mensagem = $mensagem."CPF do artista<br/>";
	$i = 1;
}


$pf = recuperaDados("pessoa_fisica","id",$evento['idPf']);
if($pf['nome'] == NULL)
{
	$mensagem = $mensagem."Nome do artista<br/>";
	$i = 1;
}

if($pf['rg'] == NULL)
{
	$mensagem = $mensagem."RG do artista<br/>";
	$i = 1;
}

if($pf['cpf'] == NULL)
{
	$mensagem = $mensagem."CPF do artista<br/>";
	$i = 1;
}

if($pf['telefone1'] == NULL)
{
	$mensagem = $mensagem."Telefone do artista<br/>";
	$i = 1;
}

if($pf['email'] == NULL)
{
	$mensagem = $mensagem."E-mail do artista<br/>";
	$i = 1;
}

if($tipoPessoa == 1)
{
	if($pf['cep'] == NULL)
	{
		$mensagem = $mensagem."CEP do artista<br/>";
		$i = 1;
	}

	if($pf['numero'] == NULL)
	{
		$mensagem = $mensagem."Número do endereço do artista<br/>";
		$i = 1;
	}
}

if(isset($_POST['enviar']))
{
	$sql_envia = "UPDATE `evento` SET `publicado`= 2 WHERE `id` = '$idEvento'";
	$con = bancoMysqli();
	if(mysqli_query($con,$sql_envia))
	{
		$mensagem = "<h4>Enviado com sucesso! Entre em contato com o programador do seu evento e informe o código do CAPAC: <font color='red'>".$idEvento."</font></h4>";
	}
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>FINALIZAR</h3><?php echo $i ?>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<?php
						if($i == 0)
						{
						?>
							<p><strong>Não há pendências de preenchimento de campos.</strong></p>
						<?php
						}
						else
						{
						?>
							<p><strong>O(s) seguinte(s) campo(s) obrigatório(s) não foram preenchidos:</strong></p>
						<?php
						}
						?>
						<p align="left"><?php if(isset($mensagem)){echo $mensagem;};?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<?php
						if($i == 0)
						{
						?>
							<form class="form-horizontal" role="form" action="?perfil=finalizar" method="post">
								<input type="submit" name="enviar" value="ENVIAR" class="btn btn-theme btn-lg btn-block">
							</form>
						<?php
						}
						else
						{
						?>
							<br/><br/>
							<h6>Para habilitar o botão de envio, preencha todos os campos obrigatórios.</h6>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>