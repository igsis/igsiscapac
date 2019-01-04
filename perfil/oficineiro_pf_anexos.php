<?php

$con = bancoMysqli();
$idPf = $_SESSION['idPf'];
$contador = 0;
$pf = recuperaDados("pessoa_fisica","id",$idPf);
$tipoPessoa = 4;
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;

$server = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/";
$http = $server."/pdf/";

$array = array(33,41,53,67);
if(isset($_POST["enviar"]))
{
    $arquivos = "109,110,113,111,112,114";
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN ($arquivos) AND publicado = '1'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];
		$ext = array("PDF","pdf"); //Extensões permitidas

		if($f_size > 5242880) // 5MB em bytes
		{
			$mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{

							if(file_exists($dir.$new_name))
							{
								$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
								gravarLog($sql_insere_arquivo);
                                echo '<script>window.location = "?perfil=oficineiro_pf_anexos"</script>';

							}
							else
							{
								$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idEvento', '$y', '$new_name', '$hoje', '1'); ";
								$query = mysqli_query($con,$sql_insere_arquivo);

								if($query)
								{
									if(file_exists($dir.$new_name))
									{
										$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
										gravarLog($sql_insere_arquivo);
										echo '<script>window.location = "?perfil=arquivos_evento"</script>';
									}
									else{
										echo "<script>alert('Houve um erro durante o processamento do arquivo, entre em contato com os administradores do sistema')</script>";
									}
								}
							}
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco!</strong></font>";
						}
					}
					else
					{
						$mensagem = "<font color='#FF0000'><strong>Erro no upload.</strong></font>";
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
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar o arquivo! Tente novamente.</strong></font>";

	}
}


$pf = recuperaDados("pessoa_fisica","id",$idPf);
$evento_pf = recuperaDados("evento","id",$evento);

?>

<section id="list_items" class="home-section bg-white">
	<div class="container">
        <?php include 'includes/menu_oficinas.php'; ?>

        <div class="form-group">
			<?php if($evento == NULL || $evento == ""){ ?>
			<h3>Demais Anexos</h3>
			<?php } else { ?>
			<h3>Demais Anexos</h3>
			<?php } ?>
			<p><b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>

                <!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
						<p align="justify">
							<a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais de São Paulo</a><br />
							<a href="http://www.tst.jus.br/certidao" target="_blank">CNDT - Certidão Negativa de Débitos de Tributos Trabalhistas</a><br />
							<a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">CADIN Municipal</a>
                            <?php
                            if ($pf['oficineiro'] == 1)
                            {
                            ?>
                                <br /><a href="http://servicos.receita.fazenda.gov.br/Servicos/certidao/CNDConjuntaInter/InformaNICertidao.asp?tipo=2" target="_blank">CND Federal - Certidão Negativa de Débitos Relativos a Créditos Tributários Federais e à Dívida Ativa da União</a><br />
                                <?php
                                $server = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/";
                                $http = $server."/pdf/";
                                $link1 = $http."rlt_decaracaoaceite_oficineiro.php"."?idPf=".$idPf;
                                ?>
                                <a href='<?= $link1 ?>' target="_blank">Declaração de Aceite</a>
                            <?php
                            }
                            ?>
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
							<?php
                            $lista = 12;
                            listaArquivoCamposMultiplos($idPf,$tipoPessoa,"","oficineiro_pf_anexos",$lista);
                            ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo -->
				<div class="form-group">
					<div class="col-md-offset-1 col-md-10">
						<div class = "center">
						<form method="POST" action="?perfil=oficineiro_pf_anexos" enctype="multipart/form-data">
							<table class='table table-condensed'>
							<?php
                                $arquivos = "109,110,113,111,112,114,159";
								$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN ($arquivos) AND publicado = '1'";
								$query_arquivos = mysqli_query($con,$sql_arquivos);
								while($arq = mysqli_fetch_array($query_arquivos))
								{
							?>
									<tr>
										<?php
										$doc = $arq['documento'];
										$query = "SELECT id FROM upload_lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='$tipoPessoa'";
										$envio = $con->query($query);
										$row = $envio->fetch_array(MYSQLI_ASSOC);

										if(verificaArquivosExistentesPF($idPf,$row['id'], $tipoPessoa)){
											echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
										}
										else{ ?>
										<td class="list_description"><?php echo $arq['documento']?></td>
										<td valign="center"><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]' required></td>
										<?php } ?>
									</tr>
							<?php
								}
							?>
							</table><br>
							<input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"  />
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

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=oficinas_cronograma" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
				</div>
                <div class="col-md-offset-4 col-md-2">
                    <form class="form-horizontal" role="form" action="?perfil=oficineiro_pf_final" method="post">
                        <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
                    </form>
                </div>
			</div>
		</div>
		</div>
		</div>
	</div>
</section>
