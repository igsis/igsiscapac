<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];
$pj = recuperaDados("pessoa_juridica","id",$idPj);
$tipoPessoa = 5;

// Cadastro de um representante que não existe
if(isset($_POST['cadastraRepresentante']))
{
    $nome = addslashes($_POST['nome']);
    $rg = $_POST['rg'];
    if($rg == '' OR $nome == '')
    {
        $mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
    }
    else
    {
        $idRep1 = $_POST['cadastraRepresentante'];
        $nome = addslashes($_POST['nome']);
        $rg = $_POST['rg'];
        $cpf = $_POST['cpf'];

        $sql_insere_rep1 = "INSERT INTO `representante_legal` (`nome`, `rg`, `cpf`) VALUES ('$nome', '$rg', '$cpf')";

        if(mysqli_query($con,$sql_insere_rep1))
        {
            $mensagem = "<font color='#01DF3A'><strong>Cadastrado com sucesso!</strong></font>";
            $idrep1 = recuperaUltimo("representante_legal");
            $sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal1 = '$idrep1' WHERE id = '$idPj'";
            $query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);
            gravarLog($sql_insere_rep1);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar! Tente novamente.</strong></font>";
        }
    }
}

// Insere um Representante que foi pesquisado
if(isset($_POST['insereRepresentante']))
{
    $idrep1 = $_POST['insereRepresentante'];
    $sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal1 = '$idrep1' WHERE id = '$idPj'";
    if(mysqli_query($con,$sql_representante1_empresa))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_representante1_empresa);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao inserir represente.</strong></font>";
    }
}

// Edita os dados do representante
if(isset($_POST['editaRepresentante']))
{
    $nome = addslashes($_POST['nome']);
    $rg = $_POST['rg'];
    if($rg == '' OR $nome == '')
    {
        $mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
    }
    else
    {
        $idrep1 = $_POST['editaRepresentante'];
        $nome = addslashes($_POST['nome']);
        $rg = $_POST['rg'];
        $cpf = $_POST['cpf'];

        $sql_atualiza_rep1 = "UPDATE `representante_legal` SET
		`nome` = '$nome',
		`rg` = '$rg',
		`cpf` = '$cpf'
		WHERE `id` = '$idrep1'";

        if(mysqli_query($con,$sql_atualiza_rep1))
        {
            $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
            $sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal1 = '$idrep1' WHERE id = '$idPj'";
            $query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);
            gravarLog($sql_atualiza_rep1);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
        }
    }
}

$pj = recuperaDados("pessoa_juridica","id",$idPj);
$representante1 = recuperaDados("representante_legal","id",$pj['idRepresentanteLegal1']);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_oficinas.php'; ?>

        <div class="form-group">
            <h4>Representante Legal</h4>
            <p><b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_representante_cadastro" method="post">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
                            <input type="text" class="form-control" name="nome" placeholder="Nome completo" maxlength="100" value="<?php echo $representante1['nome']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
                            <input type="text" class="form-control" name="rg" placeholder="RG/RNE/PASSAPORTE" maxlength="15" value="<?php echo $representante1['rg']; ?>" required>
                        </div>
                        <div class="col-md-6"><strong>CPF: *</strong><br/>
                            <input type="text" readonly class="form-control" name="cpf" placeholder="CPF" maxlength="14" value="<?php echo $representante1['cpf']; ?>" required>
                        </div>
                    </div>


                    <!-- Botão para Gravar -->
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="editaRepresentante" value="<?php echo $representante1['id'] ?>">
                            <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
                        </div>
                    </div>
                </form>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                </div>

                <!-- Botão para Trocar o Representante -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <form method='POST' action='?perfil=oficineiro_pj_representante'>
                            <input type="hidden" name="apagaRepresentante" value="<?php echo $idPj ?>">
                            <input type="submit" value="Trocar o Representante" class="btn btn-theme btn-lg btn-block">
                        </form>
                    </div>
                </div>

                <br/>

                <!-- Botão para Remover o Representante -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <form method='POST' action='?perfil=oficineiro_pj_representante'>
                            <input type="hidden" name="apagaRepresentante" value="<?php echo $idPj ?>">
                            <input type="submit" value="Remover o Representante" class="btn btn-theme btn-lg btn-block">
                        </form>
                    </div>
                </div>

                <!-- Botão para Voltar e Prosseguir -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_informacoes_complementares" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                        </form>
                    </div>
                    <div class="col-md-offset-4 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_arquivos_representante" method="post">
                            <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>