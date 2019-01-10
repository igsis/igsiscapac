<?php
$perfil = $_GET['perfil'];

function menuOficina($perfil,$voltar,$avancar)
{
    echo '
		<div class="col-md-offset-1 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil=/oficinas/'.$voltar.'" method="post">
				<input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block" >
			</form>
		</div>
		<div class="col-md-offset-6 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil=/oficinas/'.$avancar.'" method="post">
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
                    //INICIO OFICINA
                    case 'oficina_edicao':
                        $perfil = "oficina_edicao";
                        $voltar = "oficinas";
                        $avancar = "arquivos_oficina";
                        $menu = menuOficina($perfil,$voltar,$avancar);
                        break;
                    case 'arquivos_oficina':
                        $perfil = "arquivos_oficina";
                        $voltar = "oficina_edicao";
                        $avancar = "produtor_oficina";
                        $menu = menuOficina($perfil,$voltar,$avancar);
                        break;
                    case 'oficina_arquivos_com_prod':
                        $perfil = "oficina_arquivos_com_prod";
                        $voltar = "produtor_oficina";
                        $avancar = "oficina_finalizar";
                        $menu = menuOficina($perfil,$voltar,$avancar);
                        break;
                    //FIM EVENTO
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