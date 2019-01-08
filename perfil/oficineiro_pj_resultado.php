<?php
$con = bancoMysqli();

// inicia a busca por CNPJ
$validacao = validaCNPJ($_POST['busca']);
if($validacao == false)
{
    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=erros&p=erro_oficineiro_pj'>";
}
else
{
    $cnpj_busca = $_POST['busca'];//original
    //$cnpj_busca = "88.888.888/0001-88"; //teste
}

$sql = $con->query("SELECT * FROM pessoa_juridica where cnpj = '$cnpj_busca'");
$query = $sql->fetch_array(MYSQLI_ASSOC);

if($query != '')
{
    ?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="section-heading">
                        <h4>PESSOA JURÍDICA</h4>
                        <p><strong><a href="?perfil=oficineiro_pj">Pesquisar outro CNPJ</a></strong></p>
                    </div>
                    <div class="table-responsive list_info">
                        <table class="table table-condensed">
                            <thead>
                            <tr class="list_menu">
                                <td>Razão Social</td>
                                <td>CNPJ</td>
                                <td width="25%"></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class='list_description'><?php echo $query["razaoSocial"]; ?></td>
                                <td class='list_description'><?php echo $query["cnpj"] ?></td>
                                <td class='list_description'>
                                    <form method='POST' action='?perfil=oficineiro_pj_informacoes_iniciais'>
                                        <input type='hidden' name='carregar' value='<?php echo $query["id"] ?>'>
                                        <input type="hidden" name="oficineiro">
                                        <input type ='submit' class='btn btn-theme btn-md btn-block' value='Carregar'></form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
else
{
    $busca = $_POST['busca'];
    ?>
    <section id="contact" class="home-section bg-white">
        <div class="container"><div class="container"><?php include 'includes/menu_oficinas.php'; ?>
                <div class="form-group">
                    <h3>INFORMAÇÕES INICIAIS</h3>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_informacoes_iniciais" method="post">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
                                    <input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
                                    <input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $busca; ?>">
                                </div>
                                <div class="col-md-6"><strong>CCM:</strong><br/>
                                    <input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" >
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
                                    <input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" required>
                                </div>
                                <div class="col-md-6"><strong>Telefone #2:</strong><br/>
                                    <input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
                                    <input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
                                </div>
                                <div class="col-md-6"><strong>E-mail *:</strong><br/>
                                    <input type="text" class="form-control" name="email" placeholder="E-mail" required>
                                </div>
                            </div>

                            <!-- Botão para Gravar -->
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <input type="hidden" name="oficineiro">
                                    <input type="submit" name="cadastrarJuridica" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>

    <?php
}
?>