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

                    <font color="#FF0000"><strong>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br />
                            Não são aceitas: conta fácil, poupança e conjunta.</strong></font><br />
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