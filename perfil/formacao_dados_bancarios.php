<?php
$con = bancoMysqli();
$idPf = $_SESSION['idPf'];
$tipoPessoa = 6;

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

$pf = recuperaDados("pessoa_fisica","id",$idPf);



function geraOpcaoBancos1($tabela,$select)
{
    //gera os options de um select
    $sql = "SELECT * FROM $tabela WHERE `id` = '32' ORDER BY `codigoBanco` ASC";

    $con = bancoMysqli();
    $query = mysqli_query($con,$sql);
    while($option = mysqli_fetch_row($query))
    {
        if($option[0] == $select)
        {
            echo "<option value='".$option[0]."' selected >".$option[1]."</option>";
        }
        else
        {
            echo "<option value='".$option[0]."'>".$option[1]."</option>";
        }
    }
}

?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_formacao.php'; ?>
        <div class="form-group">
            <h3>Dados Bancários</h3>
            <p><b>Nome:</b> <?php echo $pf['nome']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form class="form-horizontal" role="form" action="?perfil=formacao_dados_bancarios" method="post">

                    <span style="color: #FF0000; ">
                        <strong>
                            <p>Pagamentos serão feitos unicamente em conta corrente de Pessoa Física no
                            Banco do Brasil. <br>
                            Não são aceitas: conta fácil, poupança e conjunta. <br>
                            Candidato contratado que não possuir conta, receberá no ato da assinatura do
                            contrato, carta de apresentação para abertura da conta.</p>
                        </strong>
                    </span>

                    <br />

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
                            <select class="form-control" name="codigoBanco" id="codigoBanco">
                                <?php geraOpcaoBancos1("banco",$pf['codigoBanco']);	?>
                                <option value="0" <?= ($pf['codigoBanco'] == 0) ? "selected" : "" ?>>Não Possui</option>
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
                        <form class="form-horizontal" role="form" action="?perfil=formacao_informacoes_complementares" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                        </form>
                    </div>
                    <div class="col-md-offset-4 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=formacao_anexos" method="post">
                            <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>