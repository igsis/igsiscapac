<?php

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$tipoPessoa = 6;
$bool = false;

if(isset($_POST['cadastrarFormacao']))
{
    $nome = addslashes($_POST['nome']);
    $nomeArtistico = addslashes($_POST['nomeArtistico']);
    $idTipoDocumento = $_POST['idTipoDocumento'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $ccm = $_POST['ccm'];
    $telefone1 = $_POST['telefone1'];
    $telefone2 = $_POST['telefone2'];
    $telefone3 = $_POST['telefone3'];
    $email = $_POST['email'];
    $dataNascimento = exibirDataMysql($_POST['dataNascimento']);
    $pis = $_POST['pis'];
    $programa = $_POST['programa'];
    $dataAtualizacao = date("Y-m-d H:i:s");

    $sql_cadastra_pf = "INSERT INTO `pessoa_fisica`(`nome`, `nomeArtistico`, `idTipoDocumento`, `rg`, `cpf`, `ccm`, `telefone1`, `telefone2`, `telefone3`, `email`, `dataNascimento`, `pis`, `tipo_formacao_id`, `dataAtualizacao`, `idUsuario`) VALUES ('$nome', '$nomeArtistico', '$idTipoDocumento', '$rg', '$cpf', '$ccm', '$telefone1', '$telefone2', '$telefone3', '$email', '$dataNascimento', '$pis', '$programa', '$dataAtualizacao', '$idUser')";
    if(mysqli_query($con,$sql_cadastra_pf))
    {
        $mensagem = "<font color='#01DF3A'><strong>Cadastrado com sucesso!</strong></font>";
        gravarLog($sql_cadastra_pf);

        $sql_ultimo = "SELECT id FROM pessoa_fisica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
        $query_ultimo = mysqli_query($con,$sql_ultimo);
        $ultimoPf = mysqli_fetch_array($query_ultimo);
        $_SESSION['idPf'] = $ultimoPf['id'];
        $idPf = $_SESSION['idPf'];
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar!</strong></font>";
    }
}

if(isset($_POST['atualizarFormacao']))
{
    $nome = addslashes($_POST['nome']);
    $nomeArtistico = addslashes($_POST['nomeArtistico']);
    $idTipoDocumento = $_POST['idTipoDocumento'];
    $rg = $_POST['rg'];
    $ccm = $_POST['ccm'];
    $telefone1 = $_POST['telefone1'];
    $telefone2 = $_POST['telefone2'];
    $telefone3 = $_POST['telefone3'];
    $email = $_POST['email'];
    $dataNascimento = exibirDataMysql($_POST['dataNascimento']);
    $pis = $_POST['pis'];
    $programa = $_POST['programa'];
    date_default_timezone_set('America/Sao_Paulo');
    $dataAtualizacao = date("Y-m-d");
    $idPf = $_SESSION['idPf'];

    $sql_atualiza_pf = "UPDATE pessoa_fisica SET
	`nome` = '$nome',
	`nomeArtistico` = '$nomeArtistico',
	`idTipoDocumento` = '$idTipoDocumento',
	`rg` = '$rg',
	`ccm` = '$ccm',
	`telefone1` = '$telefone1',
	`telefone2` = '$telefone2',
	`telefone3` = '$telefone3',
	`email` = '$email',
	`dataNascimento` = '$dataNascimento',
	`pis` = '$pis',
	`tipo_formacao_id` = '$programa',
	`dataAtualizacao` = '$dataAtualizacao'
	WHERE `id` = '$idPf'";

    if(mysqli_query($con,$sql_atualiza_pf))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        $bool = true;
        gravarLog($sql_atualiza_pf);
    }
    else
    {
        $mensagem .= "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['carregar']))
{
    $_SESSION['idPf'] = $_POST['carregar'];
}

$idPf = $_SESSION['idPf'];

$pf = recuperaDados("pessoa_fisica","id",$idPf);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_formacao.php'; ?>
        <div class="form-group">
            <h4>INFORMAÇÕES INICIAIS</h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form name="form1" class="form-horizontal" role="form" action="?perfil=formacao_informacoes_iniciais" method="post">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
                            <input type="text" class="form-control next-step" name="nome" placeholder="Nome" maxlength="70" value="<?php echo $pf['nome']; ?>" required >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>Nome Artístico*:</strong><br/>
                            <input type="text" class="form-control" name="nomeArtistico" placeholder="Nome Artístico" maxlength="70" value="<?php echo $pf['nomeArtistico']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
                            <select class="form-control" id="idTipoDocumento" name="idTipoDocumento" >
                                <?php geraOpcao("tipo_documento",$pf['idTipoDocumento']); ?>
                            </select>
                        </div>
                        <div class="col-md-6"><strong>Nº do documento *:</strong><br/>
                            <input type="text" class="form-control" name="rg" placeholder="Número do Documento" maxlength="20" value="<?php echo $pf['rg']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
                            <input type="text" readonly class="form-control" id="cpf" name="cpf" placeholder="CPF" maxlength="14" value="<?php echo $pf['cpf']; ?>" >
                        </div>
                        <div class="col-md-6"><strong>CCM:</strong><br/>
                            <input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" maxlength="11" value="<?php echo $pf['ccm']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
                            <input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone1']; ?>" required>
                        </div>
                        <div class="col-md-6"><strong>Telefone #2:</strong><br/>
                            <input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone2']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
                            <input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone3']; ?>" >
                        </div>
                        <div class="col-md-6"><strong>E-mail *:</strong><br/>
                            <input type="text" class="form-control" name="email" placeholder="E-mail" maxlength="60" value="<?php echo $pf['email']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>Data Nascimento *:</strong><br/>
                            <input type="text" class="form-control" name="dataNascimento" id="datepicker01" onclick="alerta()" placeholder="Data de Nascimento" value = "<?php echo exibirDataBr($pf['dataNascimento']) ?>" required>
                        </div>
                        <div class="col-md-6"><strong>Estado civil:</strong><br/>
                            <select class="form-control" name="idEstadoCivil" >
                                <?php geraOpcao("estado_civil",$pf['idEstadoCivil']); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
                            <input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade" value="<?= $pf['nacionalidade'] ?>">
                        </div>
                        <div class="col-md-6"><strong>PIS/PASEP/NIT:</strong><br/>
                            <input type="text" class="form-control" name="pis" placeholder="Nº do PIS/PASEP/NIT" maxlength="50" value="<?php echo $pf['pis']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>Programa:</strong><br/>
                            <select class="form-control" name="programa" id="programa">
                                <?php geraOpcao('tipo_formacao', $pf['tipo_formacao_id']) ?>
                            </select>
                        </div>
                    </div>


                    <!-- Botão para Gravar -->
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="atualizarFormacao" value="<?php echo $idPf ?>">
                            <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
                        </div>
                    </div>
                </form>


                <!-- Botão para Prosseguir -->
                <div class="form-group">
                    <form class="form-horizontal" role="form" action="?perfil=formacao_arquivos_pf" method="post">
                        <div class="col-md-offset-8 col-md-2">
                            <?php if($bool == true)
                            { ?>
                                <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                            <?php }
                            else { ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <div class="alert alert-info">
                    Grave suas informações para prosseguir o formulário.</div>
            </div>
        </div>
    </div>
    <?php } ?>


    <div class="form-group">
        <div class="col-md-offset-2 col-md-8"></div>
    </div>

    </div>
</section>