<?php
		case "edicaoGrupo":
			if(isset($_GET['action']))
			{
				$action = $_GET['action'];	
			}
			else
			{
				$action = "listar";
			}
			switch($action)
			{
				case "listar":
					$con = bancoMysqli();
					$idPedido = $_POST['idPedido'];
					if(isset($_POST['inserir']))
					{
						$nome = addslashes($_POST['nome']);
						$rg = trim($_POST['rg']);
						$cpf = $_POST['cpf'];
						$sql_inserir = "INSERT INTO `igsis_grupos` 
							(`idGrupos`, 
							`idPedido`, 
							`nomeCompleto`, 
							`rg`, 
							`cpf`, 
							`publicado`) 
							VALUES (NULL, 
							'$idPedido', 
							'$nome', 
							'$rg', 
							'$cpf', 
							'1')";
						$query_inserir = mysqli_query($con,$sql_inserir);
						if($query_inserir)
						{
							$mensagem = "Integrante inserido com sucesso!";	
						}
						else
						{
							$mensagem = "Erro ao inserir integrante. Tente novamente.";	
						}	
					}
					if(isset($_POST['apagar']))
					{
						$id = $_POST['apagar'];
						$sql_apagar = "UPDATE igsis_grupos SET publicado = '0' WHERE idGrupos = '$id'";
						$query_apagar = mysqli_query($con,$sql_apagar);
						if($query_apagar)
						{
							$mensagem = "Integrante apagado com sucesso!";	
						}
						else
						{
							$mensagem = "Erro ao apagar integrante. Tente novamente.";	
						}
					}
					$sql_grupos = "SELECT * 
						FROM igsis_grupos 
						WHERE idPedido = '$idPedido' 
						AND publicado = '1'";
					$query_grupos = mysqli_query($con,$sql_grupos);
					$num = mysqli_num_rows($query_grupos);
	?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
					<h2>Grupos</h2>
					<h4>Integrantes de grupos</h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
				</div>
			</div>				
		</div>
				<?php
					if($num > 0)
					{ 
				?>
		<div class="table-responsive list_info">
            <table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td width='40%'>Nome Completo</td>
						<td>RG</td>
						<td>CPF</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php
						while($grupo = mysqli_fetch_array($query_grupos))
						{ 
					?>	
					<tr>
						<td><?php echo $grupo['nomeCompleto'] ?></td>
						<td><?php echo $grupo['rg'] ?></td>
						<td><?php echo $grupo['cpf'] ?></td>
						<td class='list_description'>
							<form method='POST' action='?perfil=contratados&p=edicaoGrupo'>
								<input type="hidden" name="apagar" value="<?php echo $grupo['idGrupos'] ?>" />
								<input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>" >	
								<input type ='submit' class='btn btn-theme btn-block' value='apagar'>
							</form>
						</td>
					</tr>					
					<?php
						}
					?>
				</tbody>
			</table>
				<?php 
					}
					else
					{
				?>				
            <div class="col-md-offset-2 col-md-8">
            	<h3>Não há integrantes de grupos inseridos. <br />
            </div> 
				<?php 
					}
				?>
			<div class="col-md-offset-2 col-md-8"><br/>
			</div>
            <div class="col-md-offset-2 col-md-6">
				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoGrupo&action=inserir"  method="post">
					<input type="hidden" name="idPedidoContratacao" value="<?php echo $idPedido; ?>" >
					<input type ='submit' class='btn btn-theme btn-block' value='Inserir novo integrante'></td>
				</form>	
			</div>
				<?php
					$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
				?>
			<div class="col-md-4">
				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPedido"  method="post">
					<input type="hidden" name="idPedidoContratacao" value="<?php echo $idPedido; ?>" >
					<input type ='submit' class='btn btn-theme btn-block' value='Voltar ao Pedido de Contratação'></td>
				</form>
	        </div>
		</div>		   
	</div>
</section>
			<?php
				break;