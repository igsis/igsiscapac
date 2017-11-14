<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			| <a href="?secao=perfil">Voltar ao início</a>
			| <a href="?perfil=evento">Carregar Eventos</a>
			<?php
			if(isset($_SESSION['idEvento']))
			{
			?>
				| <a href="?perfil=evento_edicao">Informações Gerais</a>
				| <a href="?perfil=produtor">Produtor</a>
				| <a href="?perfil=arquivos_com_prod">Arquivos Comunicação-Produção</a>
				| <a href="?perfil=proponente">Informações do Proponente</a>
			<?php
			}
			?>
			| <a href="../manual" target="_blank">Ajuda</a>
			| <a href="../include/logoff.php">Sair</a> |</strong><br/>
		</div>
	</div>
</div>
<br/>