<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];
$tipoPessoa = "2";

// Cadastro um representante que não existe
if(isset($_POST['cadastraRepresentante']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	if($rg == '' OR $nome == '')
	{
		$mensagem = "Por favor, preencha todos os campos obrigatórios!";
	}
	else
	{
		$idRep1 = $_POST['cadastraRepresentante'];
		$nome = addslashes($_POST['nome']);
		$rg = $_POST['rg'];
		$cpf = $_POST['cpf'];
		$idEstadoCivil = $_POST['idEstadoCivil'];
		$nacionalidade = $_POST['nacionalidade'];

		$sql_insere_rep1 = "INSERT INTO `representante_legal` (`nome`, `rg`, `cpf`, `nacionalidade`, `idEstadoCivil`) VALUES ('$nome', '$rg', '$cpf', '$nacionalidade', '$idEstadoCivil')";
		if(mysqli_query($con,$sql_insere_rep1))
		{
			$mensagem = "Cadastrado com sucesso!";
			$idRep1 = recuperaUltimo("representante_legal");
			$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal1 = '$idRep1' WHERE id = '$idPj'";
			$query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);
		}
		else
		{
			$mensagem = "Erro ao cadastrar! Tente novamente.";
		}
	}
}

// Insere um Representante que foi pesquisado
if(isset($_POST['insereRepresentante']))
{
	$idRep1 = $_POST['insereRepresentante'];
	$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal2 = '$idRep1' WHERE id = '$idPj'";
	if(mysqli_query($con,$sql_representante1_empresa))
	{
		$mensagem = "Atualizado com sucesso!";
	}
	else
	{
		$mensagem = "Erro ao inserir representante!";
	}
}

// Edita os dados do representante
if(isset($_POST['editaRepresentante']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	if($rg == '' OR $nome == '')
	{
		$mensagem = "Por favor, preencha todos os campos obrigatórios!";
	}
	else
	{
		$idRep1 = $_POST['editaRepresentante'];
		$nome = addslashes($_POST['nome']);
		$rg = $_POST['rg'];
		$cpf = $_POST['cpf'];
		$idEstadoCivil = $_POST['idEstadoCivil'];
		$nacionalidade = $_POST['nacionalidade'];

		$sql_atualiza_rep1 = "UPDATE `representante_legal` SET
		`nome` = '$nome',
		`rg` = '$rg',
		`cpf` = '$cpf',
		`nacionalidade` = '$nacionalidade',
		`idEstadoCivil` = '$idEstadoCivil'
		WHERE `id` = '$idRep1'";

		if(mysqli_query($con,$sql_atualiza_rep1))
		{
			$mensagem = "Atualizado com sucesso!";
			$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal1 = '$idRep1' WHERE id = '$idPj'";
			$query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);
		}
		else
		{
			$mensagem = "Erro ao atualizar! Tente novamente.";
		}
	}
}

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (20,21)";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$idPj = $_SESSION['idPj'];
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];

		//Extensões permitidas
		$ext = array("PDF","pdf");

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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPj', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							$mensagem = "Arquivo recebido com sucesso!";
						}
						else
						{
							$mensagem = "Erro ao gravar no banco!";
						}
					}
					else
					{
						 $mensagem = "Erro no upload! Tente novamente!";
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

$pj = recuperaDados("pessoa_juridica","id",$idPj);
$representante1 = recuperaDados("representante_legal","id",$pj['idRepresentanteLegal1']);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h3>REPRESENTANTE LEGAL #1</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPj; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=representante1_pj_cadastro" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?php echo $representante1['nome']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG" value="<?php echo $representante1['rg']; ?>" >
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" value="<?php echo $representante1['cpf'] ?>" placeholder="CPF">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade: </strong><br/>
							<input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade" value="<?php echo $representante1['nacionalidade']; ?>">
						</div>
						<div class="col-md-6"><strong>Estado civil:</strong><br/>
							<select class="form-control" name="idEstadoCivil" >
								<?php geraOpcao("estado_civil",$representante1['idEstadoCivil'],""); ?>
							</select>
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaRepresentante" value="<?php echo $idRep1 ?>">
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
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s) Somente em PDF</h6>
							<?php listaArquivoCamposMultiplos($idPj,$tipoPessoa,"","representante1_pj_cadastro",5); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 1 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=representante1_pj_cadastro" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '20'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
								<tr>
									<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
								</tr>
								<?php
									}
								?>
							</table><br>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 2 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '21'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php
									}
								?>
							</table><br>
							<input type="hidden" name="idPessoa" value="<?php echo $idPj ?>"  />
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

				<!-- Botão para Trocar o Representante -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form method='POST' action='?perfil=representante1_pj'>
							<input type="hidden" name="apagaRepresentante" value="<?php echo $idPj ?>">
							<input type="submit" value="Trocar o Representante" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=representante2_pj" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>