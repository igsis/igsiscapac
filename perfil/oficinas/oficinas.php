<?php
$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$tipoPessoa = isset($_POST['tipoPessoa']) ? $_POST['tipoPessoa'] : NULL;

if (isset($_SESSION['idPf']))
{
    $id = $_SESSION['idPf'];
    $tabela = "pessoa_fisica";
    $tipoPessoa = 4;
    $idPf = $id;
    $idPj = 0;

}
elseif (isset($_SESSION['idPj']))
{
    $id = $_SESSION['idPj'];
    $tabela = "pessoa_juridica";
    $tipoPessoa = 5;
    $idPj = $id;
    $idPf = 0;
}

unset($_SESSION['idEvento']);

if(isset($_POST['apagar']))
{
    $idEvento = $_POST['apagar'];
    $sql_apaga = "UPDATE evento SET publicado = '0' WHERE id = '$idEvento'";
    if(mysqli_query($con,$sql_apaga))
    {
        $mensagem = "<font color='#01DF3A'><strong>Oficina apagada com sucesso!</strong></font>";
        gravarLog($sql_apaga);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar oficina! Tente novamente.</strong></font>";
    }
}

$usuario = recuperaDados("usuario","id",$idUser);

$sql = "SELECT * FROM evento
							WHERE publicado > 0 AND `idTipoEvento` = '4' AND `idTipoPessoa` = '$tipoPessoa' AND `idPf` = '$idPf' AND `idPj` = '$idPj'
							ORDER BY id DESC";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);

?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include '../perfil/includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h3>OFICINAS</h3>
            <h5>
                <?php if(isset($mensagem)){echo $mensagem;}; ?>
            </h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <?php
                if ($num == 3)
                {
                ?>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="alert alert-danger ">
                                Envio máximo de 3 oficinas atingido
                            </div>
                        </div>
                    </div>
                <?php
                }
                else
                {
                ?>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_novo" method="post">
                                <input type="submit" value="Inserir nova oficina" class="btn btn-theme btn-lg btn-block">
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>

                <br/>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8"><br></div>
            </div>
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
                    $sql = "SELECT * FROM evento
							WHERE publicado > 0 AND `idTipoEvento` = '4' AND `idTipoPessoa` = '$tipoPessoa' AND `idPf` = '$idPf' AND `idPj` = '$idPj'
							ORDER BY id DESC";
                    $query = mysqli_query($con,$sql);
                    $num = mysqli_num_rows($query);
                    if($num > 0)
                    {
                        echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Id da oficina</td>
										<td>Nome da oficina</td>
										<td>Data cadastro</td>
										<td>Enviado</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            if($campo['publicado'] ==2)
                            {
                                echo "<td class='list_description'>".$campo['id']."</td>";
                            } else{
                                echo "<td class='list_description'>"."</td>";
                            }
                            echo "<td class='list_description'>".$campo['nomeEvento']."</td>";
                            echo "<td class='list_description'>".exibirDataHoraBr($campo['dataCadastro'])."</td>";

                            if($campo['publicado'] == 2)
                            {
                                echo "<td class='list_description'>Sim</td>";
                            }
                            else
                            {
                                echo "<td class='list_description'>Não</td>";
                            }

                            echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=oficinas/oficina_edicao'>
												<input type='hidden' name='carregar' value='".$campo['id']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";

                            if($campo['publicado'] == 1)
                            {
                                echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=oficinas/oficinas'>
													<input type='hidden' name='apagar' value='".$campo['id']."' />
													<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-message='".$campo['nomeEvento']."'>Apagar</button>
													<!--<input type ='submit' class='btn btn-theme  btn-block' value='apagar' data-toggle='modal' data-target='#confirmApagar'>-->
												</form>
											</td>";
                            }
                            echo "</tr>";
                        }
                        echo "
							</tbody>
							</table>";
                    }
                    ?>
                    <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Deseja excluir oficina?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="confirm">Remover</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php
            if (isset($_SESSION['idPf']))
            {
            ?>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficineiro_pf_final" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                        </form>
                    </div>
                </div>
            <?php
            }
            else
            {
            ?>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_finalizar" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
