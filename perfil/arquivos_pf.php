<?php

$con = bancoMysqli();
$idPf = $_SESSION['idPf'];
$idUser = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","id",$idPf);
$tipoPessoa = ($pf['oficineiro'] == 1) ? 4 : 1;
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;

if(isset($_POST['carregar']))
{
	$_SESSION['idPf'] = $_POST['carregar'];
}


if(isset($_POST["enviar"]))
{
    if ($tipoPessoa == 1)
    {
        $arquivos = " AND id IN (2,3,25,31)";
    }
    else
    {
        $arquivos = " AND id IN (109, 110, 111, 112)";
    }
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa'$arquivos";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$idPf = $_SESSION['idPf'];
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];

		//Extensões permitidas
		$ext = array("PDF","pdf");

		if($f_size > 5242880) // 5MB em bytes
		{
			$mensagem = "<font color='#FF0000'>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
		}
		else
		{
			if(($nome_arquivo != "") || ($nome_arquivo != NULL))
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
                                echo '<script>window.location = "?perfil=arquivos_pf"</script>';
								gravarLog($sql_insere_arquivo);
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
										echo '<script>window.location = "?perfil=arquivos_pf"</script>';
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
						 $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente!</strong></font>";
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
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
	}
}




$pf = recuperaDados("pessoa_fisica","id",$idPf);
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
			<h4>Arquivos da Pessoa</h4>
			<p><b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
						<p align="justify">
							<a href="https://www.receita.fazenda.gov.br/Aplicacoes/SSL/ATCTA/cpf/ImpressaoComprovante/ConsultaImpressao.asp" target="_blank">Cartão CPF</a><br/>
							<a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a><br/>
                            <?php
                            $server = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/";
                            $http = $server."/pdf/";
                            $link1 = $http."rlt_declaracaoccm_pf.php"."?id_pf=".$idPf;
                            ?>
							<a href='<?= $link1 ?>' target="_blank">Declaração CCM (caso não possua)</a>
						</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
							<?php
                            $lista = ($tipoPessoa == 4) ? 11 : 1;
                            listaArquivoCamposMultiplos($idPf,$tipoPessoa,"","arquivos_pf",$lista); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 1 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=arquivos_pf" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
                                <?php
                                $idDocumento = ($tipoPessoa == 4) ? 109 : 2;
                                if(verificaArquivosExistentesPF($idPf, $idDocumento, $tipoPessoa))
                                {
                                    echo '<div class="alert alert-success">O arquivo RG/RNE/PASSAPORTE já foi enviado.</div> ';
                                }
                                else
                                {
                                    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idDocumento'";
                                    $query_arquivos = mysqli_query($con,$sql_arquivos);
                                    while($arq = mysqli_fetch_array($query_arquivos))
                                    {
                                ?>
                                            <tr>
                                                <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                            </tr>
                                <?php
                                    }
                                }
                                ?>
							</table><br>
						</td>	
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 2 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=informacoes_iniciais_pf" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php
                                $idDocumento = ($tipoPessoa == 4) ? 110 : 3;
								if(verificaArquivosExistentesPF($idPf, $idDocumento, $tipoPessoa))
								{
									echo '<div class="alert alert-success">O arquivo CPF já foi enviado.</div> ';
								}
								else{
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idDocumento'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
								<tr>
									<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
								</tr>
								<?php
									}
								}
								?>
							</table><br>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 3 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
							<table>
								<tr>
									<td width="50%"></td>
								</tr>
								<?php
                                $idDocumento = ($tipoPessoa == 4) ? 111 : 25;
								if(verificaArquivosExistentesPF($idPf, $idDocumento, $tipoPessoa))
								{
									echo '<div class="alert alert-success">O arquivo PIS/PASEP/NIT já foi enviado.</div> ';
								}
								else{
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idDocumento'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php
									}
								}
								?>
							</table><br>

						</div>
					</div>	
				</div>

				<!-- Upload de arquivo 4 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
							<form method="POST" action="?perfil=informacoes_iniciais_pf" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="50%"></td>
                                    </tr>
                                    <?php
                                    $idDocumento = ($tipoPessoa == 4) ? 112 : 31;
                                    if(verificaArquivosExistentesPF($idPf, $idDocumento, $tipoPessoa))
                                    {
                                        echo '<div class="alert alert-success">O arquivo FDC – CCM foi enviado.</div> ';
                                    }
                                    else{
                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idDocumento'";
                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
                                        while($arq = mysqli_fetch_array($query_arquivos))
                                        {
                                    ?>
                                    <tr>
                                        <td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </table><br>
                                <!-- Fim Upload de arquivo -->
                                <input type="hidden" name="idPessoa" value="<?php echo $idPf ?>"  />
                                <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
                                <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
                            </form>
                        </div>
                    </div>
                </div>
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
						<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>