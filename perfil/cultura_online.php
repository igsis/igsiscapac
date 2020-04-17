<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
unset($_SESSION['idEvento']);
unset($_SESSION['idPj']);
unset($_SESSION['idPf']);

if(isset($_POST['apagar']))
{
    $idEvento = $_POST['apagar'];
    $sql_apaga = "UPDATE evento SET publicado = '0' WHERE id = '$idEvento'";
    if(mysqli_query($con,$sql_apaga))
    {
        $mensagem = "<font color='#01DF3A'><strong>Evento apagado com sucesso!</strong></font>";
        gravarLog($sql_apaga);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar evento! Tente novamente.</strong></font>";
    }
}

$usuario = recuperaDados("usuario","id",$idUser);
$evento = $con->query("SELECT eve.id, nomeEvento, chamamento, dataCadastro, publicado FROM evento AS eve INNER JOIN cultura_online AS co ON co.evento_id = eve.id INNER JOIN tipo_chamamento tc ON tc.id = co.tipo_chamamento_id WHERE eve.publicado > 0 AND eve.idUsuario ='$idUser' ORDER BY eve.id DESC");
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include '../perfil/includes/menu_evento.php'; ?>
        <div class="form-group">
            <h3>EVENTOS</h3>
            <h5>
                <?php if(isset($mensagem)){echo $mensagem;}; ?>
            </h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <form class="form-horizontal" role="form" action="?perfil=evento_culturaonline_novo" method="post">
                            <input type="hidden" name="contratacao" value="4">
                            <input type="submit" value="Novo" class="btn btn-theme btn-lg btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8"><br></div>
            </div>
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
                    if ($evento) {
                    ?>
                        <table class='table table-condensed'>
                            <thead>
                                <tr class='list_menu'>
                                    <td>Id do evento</td>
                                    <td>Nome do evento</td>
                                    <td>Chamamento</td>
                                    <td>Data cadastro</td>
                                    <td>Enviado</td>
                                    <td width='10%'></td>
                                    <td width='10%'></td>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                        while($campo = mysqli_fetch_array($evento))
                        {
                            if($campo['publicado'] ==2)
                            {
                                echo "<td class='list_description'>".$campo['id']."</td>";
                            } else{
                                echo "<td class='list_description'>"."</td>";
                            }
                            echo "<td class='list_description'>".$campo['nomeEvento']."</td>";
                            echo "<td class='list_description'>".$campo['chamamento']."</td>";
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
                                    <form method='POST' action='?perfil=evento_culturaonline_edicao'>
                                        <input type='hidden' name='carregar' value='".$campo['id']."' />
                                        <input type ='submit' class='btn btn-theme btn-block' value='carregar'>
                                    </form>
                                </td>";

                            if($campo['publicado'] == 1)
                            {
                                echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=evento'>
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
                                    <h4 class="modal-title">Deseja excluir o evento?</h4>
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
        </div>
    </div>
</section>
