<?php

$con = bancoMysqli();
$idPf = $_SESSION['idPf'];

$tipoPessoa = 1;
$pf = recuperaDados("pessoa_fisica","id",$idPf);

$server = "http://".$_SERVER['SERVER_NAME']."/igsiscapac/";
$http = $server."/pdf/";


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN (2,3,4,25,31,51,60) AND publicado = '1'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];
		$ext = array("PDF","pdf"); //Extensões permitidas

		if($f_size > 2097152) // 2MB em bytes
		{
			$mensagem = "Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 02 MB.";
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
							$mensagem = "Arquivo recebido com sucesso";
						}
						else
						{
							$mensagem = "Erro ao gravar no banco";
						}
					}
					else
					{
						 $mensagem = "Erro no upload";
					}
				}
				else
				{
					$mensagem = "Erro no upload! Anexar documentos somente no formato PDF.";
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
		$mensagem =	"Arquivo apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}


$pf = recuperaDados("pessoa_fisica","id",$idPf);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>ANEXOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPf; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/></div>
				</div>

				<!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
						<p align="justify">
							<a href="http://www3.prefeitura.sp.gov.br/certidaotributaria/forms/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais de São Paulo</a><br />
							<a href="http://www.tst.jus.br/certidao" target="_blank">CNDT - Certidão Negativa de Débitos de Tributos Trabalhistas</a><br />
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
							<?php listaArquivoCamposMultiplos($idPf,$tipoPessoa,"","anexos_pf",4); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo -->
				<div class="form-group">
					<div class="col-md-offset-1 col-md-10">
						<div class = "center">
						<form method="POST" action="?perfil=anexos_pf" enctype="multipart/form-data">
							<table class='table table-condensed'>
							<?php
								$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id NOT IN (2,3,4,25,31,51,60) AND publicado = '1'";
								$query_arquivos = mysqli_query($con,$sql_arquivos);
								while($arq = mysqli_fetch_array($query_arquivos))
								{
							?>
									<tr>
										<td class="list_description"><?php echo $arq['documento']?></td>
										<td valign="center"><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
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

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>