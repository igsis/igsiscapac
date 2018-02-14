<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			<?php
			if(isset($_SESSION['idEvento']))
			{
			?>
				| <a href="?perfil=evento_edicao">Informações Gerais</a>
				| <a href="?perfil=produtor">Produtor</a>
				| <a href="?perfil=arquivos_com_prod">Arquivos Comunicação-Produção</a>
				| <a href="?perfil=proponente">Dados do Proponente</a>
				| <a href="?perfil=finalizar">Finalizar</a> |<br/>
			<?php
			}
			?>
			| <a href="?secao=perfil">Início</a>
			| <a href="?perfil=evento">Carregar Eventos</a>
			| <a href="../manual" target="_blank">Ajuda</a>
			| <a href="../include/logoff.php">Sair</a> |</strong><br/>
		</div>
	</div>
</div>
<br/>