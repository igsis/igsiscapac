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
		<div class="col-md-offset-2 col-md-8"><hr/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<?php
			if(isset($_SESSION['idEvento']))
			{
				switch ($perfil)
				{
				    //INICIO EVENTO
				    case 'evento_edicao':
				        $perfil = "evento_edicao";
				        $voltar = "evento";
				        $avancar = "arquivos_evento";
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    case 'arquivos_evento':
				        $perfil = "arquivos_evento";
				        $voltar = "evento_edicao";
				        $avancar = "produtor_novo";
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    case 'produtor_edicao':
				        $perfil = "produtor_edicao";
				        $voltar = "arquivos_evento";
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
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    //FIM EVENTO
				    //INICIO PJ
				    case 'informacoes_iniciais_pj':
				        $perfil = "informacoes_iniciais_pj";
				        $voltar = "proponente";
				        $avancar = "arquivos_pj";
				        $menu = menuEvento($perfil,$voltar,$avancar);
				    break;
				    //FIM PJ
				    //INICIO PF
				    //FIM PF
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