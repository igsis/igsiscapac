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
                            <form class="form-horizontal" role="form" action="?perfil=evento_novo" method="post">
                                <input type="submit" value="Inserir novo evento com cachê" class="btn btn-theme btn-lg btn-block">
                            </form>
                        </div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <form class="form-horizontal" role="form" action="?perfil=evento_semcache_novo" method="post">
                                <input type="submit" value="Inserir novo evento sem cachê" class="btn btn-theme btn-lg btn-block">
                            </form>
                        </div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <form class="form-horizontal" role="form" action="?perfil=evento_semcontratacao_novo" method="post">
                                <input type="submit" value="Inserir novo evento sem contratação" class="btn btn-theme btn-lg btn-block">
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
					$sql = "SELECT * FROM evento
							WHERE publicado > 0 AND idUsuario ='$idUser'
							ORDER BY id DESC";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Id do evento</td>
										<td>Nome do evento</td>
										<td>Tipo de evento</td>
										<td>Data cadastro</td>
										<td>Modalidade</td>
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
									echo "<td class='list_description'>".retornaTipo($campo['idTipoEvento'])."</td>";
									echo "<td class='list_description'>".exibirDataHoraBr($campo['dataCadastro'])."</td>";
									if($campo['contratacao'] == 1)
									{
										echo "<td class='list_description'>Com cachê</td>";
									}
									elseif($campo['contratacao'] == 2)
									{
										echo "<td class='list_description'>Sem cachê</td>";
									}
									elseif($campo['contratacao'] == 3)
									{
										echo "<td class='list_description'>Sem contratação</td>";
									}
									else
									{
										echo "<td class='list_description'>Não informada</td>";

									}
									if($campo['publicado'] == 2)
									{
										echo "<td class='list_description'>Sim</td>";
									}
									else
									{
										echo "<td class='list_description'>Não</td>";
									}
									if($campo['contratacao'] == 1)
									{	
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=evento_edicao'>
												<input type='hidden' name='carregar' value='".$campo['id']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";
									}
									elseif($campo['contratacao'] == 2)
									{
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=evento_semcache_edicao'>
												<input type='hidden' name='carregar' value='".$campo['id']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";
									}
									elseif($campo['contratacao'] == 3)
									{
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=evento_semcontratacao_edicao'>
												<input type='hidden' name='carregar' value='".$campo['id']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";
									}
									else
									{	
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=evento_edicao'>
												<input type='hidden' name='carregar' value='".$campo['id']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";	
									}

									if($campo['publicado'] == 1)
									{
										echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=evento'>
													<input type='hidden' name='apagar' value='".$campo['id']."' />
													<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar'>Apagar</button>
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
                                            <p>&nbsp;</p>
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
