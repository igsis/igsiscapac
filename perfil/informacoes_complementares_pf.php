﻿<?php
$con = bancoMysqli();
$idPf = $_SESSION['idPf'];
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;

$idCampo = 60;
$pf = recuperaDados("pessoa_fisica","id",$idPf);
$tipoPessoa = ($pf['oficineiro'] == 1) ? 4 : 1;

if(isset($_POST['cadastrarFisica']))
{
	$idPf = $_POST['cadastrarFisica'];
	$Drt = $_POST['drt'];

	$sql_atualiza_complementares = "UPDATE pessoa_fisica SET
	`drt` = '$Drt'
	WHERE `id` = '$idPf'";

	if (mysqli_query($con,$sql_atualiza_complementares))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_complementares);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
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

				if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas/
				{
					if(move_uploaded_file($nome_temporario, $dir.$new_name))
					{
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$idCampo', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);
							echo '<script>window.location = "?perfil=informacoes_complementares_pf"</script>';
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco!</strong></font>";
						}
					}
					else
					{
						$mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
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



$pf = recuperaDados("pessoa_fisica","id",$idPf);
$evento_pf = recuperaDados("evento","id",$evento);
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
			<h3>Informações Complementares</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPf; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
        <?php
        if ($pf['oficineiro'] == 1)
        {
        ?>
            <div class="row col-md-offset-4 col-md-6">
                <div class="alert alert-danger">
                    <h5 style="color: #802420">ATENÇÃO OFICINEIRO!</h5>
                    <p>DRT não obrigatório</p>
                    <p>Utilize o menu para avançar ao próximo passo</p>
                </div>
            </div>
        <?php
        }
        ?>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=informacoes_complementares_pf" method="post">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>DRT:</strong> <font size="1"><i>(Somente para artes cênicas)</i></font><br/>
							<input type="text" class="form-control" name="drt" placeholder="DRT caso for teatro, dança ou circo" maxlength="15" value="<?php echo $pf['drt']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastrarFisica" value="<?php echo $idPf ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPf,$tipoPessoa,$idCampo,"informacoes_complementares_pf",3); ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=informacoes_complementares_pf" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="45%"><td>
								</tr>
								<?php
									if(verificaArquivosExistentesPF($idPf,'60')){
										echo '<div class="alert alert-success">O arquivo DRT foi enviado.</div> ';
									}
									else{
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td>
											<td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php
									}
								}
								?>
							</table><br>
							<input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"  />
							<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
							<input type="hidden" name="enviar" value="1"  />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar'>
						</form>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
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

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
					<?php
					if ($evento_pf['contratacao'] == 2)
					{
					?>	
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=anexos_pf" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
					<?php
					}
					else
					{
					?>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pf" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
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