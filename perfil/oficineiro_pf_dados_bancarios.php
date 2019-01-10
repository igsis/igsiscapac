<?php
$con = bancoMysqli();
$idPf = $_SESSION['idPf'];
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;
$idCampo = 114;
$pf = recuperaDados("pessoa_fisica","id",$idPf);
$tipoPessoa = 4;

if(isset($_POST['cadastrarBanco']))
{
	$idPf = $_POST['cadastrarBanco'];
	$CodigoBanco = $_POST['codigoBanco'];
	$Agencia = $_POST['agencia'];
	$Conta = $_POST['conta'];

	$sql_atualiza_pf = "UPDATE pessoa_fisica SET
	`codigoBanco` = '$CodigoBanco',
	`agencia` = '$Agencia',
	`conta` = '$Conta'
	WHERE `id` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_pf);
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

		if($f_size > 2097152) // 2MB em bytes
		{
			$mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 02 MB.</strong></font>";
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
							echo '<script>window.location = "?perfil=oficineiro_pf_dados_bancarios"</script>';
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
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo! Tente novamente!</strong></font>";

	}
}


$pf = recuperaDados("pessoa_fisica","id",$idPf);

?>

<section id="list_items" class="home-section bg-white">
	<div class="container">
        <?php include 'includes/menu_oficinas.php'; ?>
		<div class="form-group">
			<h3>Dados Bancários</h3>
			<p><b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=oficineiro_pf_dados_bancarios" method="post">

			<span style="color: #FF0000; "><strong>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br />
			Não são aceitas: conta fácil, poupança e conjunta.</strong></span><br />
			<p>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
						<select class="form-control" name="codigoBanco" id="codigoBanco">
							<option></option>
							<?php geraOpcaoBancos("banco",$pf['codigoBanco']);	?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Agência</strong><br/>
						<input type="text" class="form-control" id="agencia" name="agencia" placeholder="" maxlength="12" value="<?php echo $pf['agencia']; ?>">
					</div>
					<div class=" col-md-6"><strong>Conta:</strong><br/>
						<input type="text" class="form-control" id="conta" name="conta" placeholder="" maxlength="12" value="<?php echo $pf['conta']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarBanco" value="<?php echo $idPf ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=oficineiro_pf_informacoes_complementares" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=oficineiro_pf_arquivos_dados_bancarios" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>