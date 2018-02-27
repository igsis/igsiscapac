<?php
$perfil = $_GET['perfil'];

function menuEvento($perfil,$voltar,$avancar)
{
	echo '
		<div class="col-md-offset-1 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil='.$voltar.'" method="post">
				<input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block" >
			</form>
		</div>
		<div class="col-md-offset-6 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil='.$avancar.'" method="post">
				<input type="submit" value="Avançar" class="btn btn-theme btn-md btn-block" >
			</form>
		</div>
	';
}
?>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			| <a href="?secao=perfil">Início</a>
			| <a href="?perfil=evento">Carregar Eventos</a>
			| <a href="../manual" target="_blank">Ajuda</a>
			| <a href="../include/logoff.php">Sair</a> |</strong><br/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			<?php
			if(isset($_SESSION['idEvento']))
			{
				switch ($perfil)
				{
				    case 'evento_edicao':
				        $perfil = "evento_edicao";
				        $voltar = "evento";
				        $avancar = "arquivos_evento";
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    case 'arquivos_evento':
				        $perfil = "arquivos_evento";
				        $voltar = "evento_edicao";
				        $avancar = "produtor_edicao";
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    case 'produtor_edicao':
				        $perfil = "produtor_edicao";
				        $voltar = "arquivos_proponente";
				        $avancar = "arquivos_com_prod";
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    case 'arquivos_com_prod':
				        $perfil = "arquivos_com_prod";
				        $voltar = "produtor_edicao";
				        $avancar = "proponente";
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    case 'proponente':
				        $perfil = "proponente";
				        $voltar = "arquivos_com_prod";
				        $avancar = "proponente";
				        echo "menuEvento($perfil,$voltar,$avancar)";
				    break;
				    default:
				    break;
				}
			}
			?>
		</div>
	</div>
</div>
<br/>
<!--
				| <a href="?perfil=evento_edicao">Informações Gerais</a>
				| <a href="?perfil=produtor">Produtor</a>
				| <a href="?perfil=arquivos_com_prod">Arquivos Comunicação-Produção</a>
				| <a href="?perfil=proponente">Dados do Proponente</a>
				| <a href="?perfil=finalizar">Finalizar</a> |<br/>
			-->