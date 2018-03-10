﻿<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];
$contador = 0;
$tipoPessoa = 2;
$pj = recuperaDados("pessoa_juridica","id",$idPj);
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;


$array = array(10,8,42,34,58,95);
if(isset($_POST["enviar"]))
{
	for($i = 0; $i <= 5; $i++)
		if(verificaArquivosExistentesPF($idPj,$array[$i]))
			$contador++;

	if($contador >= 6)
		echo '<script>window.location = "?perfil=final_pj"</script>';
	
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN (20,21,22,28,43,89,103,104) AND publicado = '1'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];

		//Extensões permitidas
		$ext = array("PDF","pdf");
		if($f_size > 3145728) // 3MB em bytes
		{
			$mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 03 MB.</strong></font>";

		}
		else
		{
			if($nome_arquivo != "")
			{
				$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
				$new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
				$hoje = date("Y-m-d H:i:s");
				$dir = '../uploadsdocs/'; //Diretório para uploads
				$allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
				$ext = strtolower(substr($nome_arquivo,-4));

				if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
				{
					if(move_uploaded_file($nome_temporario, $dir.$new_name))
					{
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPj', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							echo '<script>window.location = "?perfil=final_pj"</script>';
							/*$mensagem = "<font color='#01DF3A'>
											<strong>
												Arquivo recebido com sucesso!<br>
												Seguindo ao próximo passo
											</strong>
										</font>
										<div class='row' style='margin-top: 15px;'>
											<div class='col-md-offset-4 col-md-6'>
												<div class='progress progress-striped active'>
		  											<div id='dynamic' class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%'>
		    											<span id='current-progress'></span>
		  											</div>
												</div>
											</div>
										</div>";
							gravarLog($sql_insere_arquivo);
							
							echo '<script>
									setTimeout(function() {
  										window.location = "?perfil=final_pj";
									}, 3000)
								</script>'; */
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco!</strong></font>";
						}
					}
					else
					{
						$mensagem = "<font color='#FF0000'><strong>Erro no upload!</strong></font>";
					}
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
				}
			}
		}
	}
}

if(isset($_POST['apagar']))
{
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE id = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo))
	{
		$mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo! Tente novamente.</strong></font>";
	}
}


$pj = recuperaDados("pessoa_juridica","id",$idPj);

?>


<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>Demais Anexos</h4>
			<p><b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
				<?php if($evento != NULL || $evento != ""){ ?>
				<!-- Gerar DECLARAÇÃO DE EXCLUSIVIDADE -->
				<?php
					$http = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/pdf/";
					$link1 = $http."rlt_declaracao_exclusividade_pj.php";
				?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<p align="justify">A Declaração de Exclusividade é um documento necessário para sua contratação, quando se tratar de um grupo de artistas.</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-5">
						<p align="left">Após inserir os dados pessoais, clique no botão para gerar a Declaração de Exclusividade.</p>
					</div>
					<div class="col-md-3">
						<a href='<?php echo $link1; ?>' target='_blank' class="btn btn-theme btn-lg btn-block"><strong>Gerar</strong></a>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<p align="justify"><font color="red"><strong>A Declaração de Exclusividade deve ser impressa, datada e assinada nos campos indicados no documento. Logo após, deve-se digitaliza-la e então anexa-la ao sistema através do campo listado abaixo.</strong></font></p>
					</div>
				</div>
				<?php

			}
				?>
				<!--  FIM Gerar DECLARAÇÃO DE EXCLUSIVIDADE -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
						<p align="justify">
							<a href="https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp" target="_blank">CRF do FGTS</a><br />
							<a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais (opção: mobiliária)</a><br />
							<a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/CNDConjuntaSegVia/NICertidaoSegVia.asp?Tipo=1" target="_blank">CND - Certidão de regularidade perante o INSS</a><br />
							<a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/certaut/CndConjunta/ConfirmaAutenticCndSolicitacao.asp?ORIGEM=PJ" target="_blank">Autenticidade de CND ­ Certidão de Débitos Relativos a Créditos Tributários Federais e à Dívida Ativa da União (CND)</a><br />
							<a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">CADIN Municipal</a>
						</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPj,$tipoPessoa,"","anexos_pj",8); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo -->
				<div class="form-group">
					<div class="col-md-offset-1 col-md-10">
						<div class = "center">
						<form method="POST" action="?perfil=anexos_pj" enctype="multipart/form-data">
							<table class='table table-condensed'>
								<?php
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN ('20','21','22','28','43','89','103','104') AND publicado = '1'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<?php 
											$doc = $arq['documento'];
										$query = "SELECT id FROM upload_lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='2'";
										$envio = $con->query($query);

										$row = $envio->fetch_array(MYSQLI_ASSOC);

											if(verificaArquivosExistentesPF($idPj,$row['id'])){
											echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
										}
										else{ ?>
											<td><?php echo $arq['documento']?></td>
											<td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]' required></td>
										</tr>
								<?php
									}
								}
								?>
							</table><br>
							<input type="hidden" name="idPessoa" value="<?php echo $idPj; ?>"  />
							<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
							<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
						</form>
						</div>
					</div>
				</div>
				<!-- Fim Upload de arquivo -->

				<!-- Confirmação de Exclusão -->
					<div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Excluir Arquivo?</h4>
								</div>
								<div class="modal-body">
									<p>Confirma?</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-danger" id="confirm">Apagar</button>
								</div>
							</div>
						</div>
					</div>
				<!-- Fim Confirmação de Exclusão -->

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<?php
						if(isset($_SESSION['idEvento']))
						{
						?>
							<form class="form-horizontal" role="form" action="?perfil=arquivos_artista_pj" method="post">
						<?php
						}
						else
						{
						?>
							<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pj" method="post">
						<?php
						}
						?>
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>
					</div>
						<?php
						if(isset($_SESSION['idEvento']))
						{
						?>
							<div class="col-md-offset-4 col-md-2">
								<form class="form-horizontal" role="form" action="?perfil=finalizar" method="post">
									<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
								</form>
							</div>
						<?php
						} else {
						?>
						<div class="col-md-offset-4 col-md-2">
								<form class="form-horizontal" role="form" action="?perfil=final_pj" method="post">
									<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
								</form>
							</div>
						<?php
						}
						?>
				</div>
			</div>
		</div>
	</div>
</section>