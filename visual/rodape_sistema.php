
<footer>
	<div class="container">
		<table width="100%">
			<tr>
				<td><img src="../visual/images/logo_cultura_q.png" align="left"/></td>
				<td align="center"><font color="#ccc">2017 @ IGSIS - CAPAC<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</font></td>
				<td><img src="../visual/images/logo_igsis_azul.png" align="right"/></td>
			</tr>
		</table>
		<div class="row">
			<div class="col-md-12">
			<?php 
				//if($_SESSION['perfil'] == 1){
				echo "<strong>SESSION</strong><pre>", var_dump($_SESSION), "</pre>";
				echo "<strong>POST</strong><pre>", var_dump($_POST), "</pre>";
				echo "<strong>GET</strong><pre>", var_dump($_GET), "</pre>";
				echo "<strong>FILES</strong><pre>", var_dump($_FILES), "</pre>";
				echo ini_get('session.gc_maxlifetime')/60; // em minutos
				//} 
			?>
			</div>
		</div>
	</div>
</footer>

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.smooth-scroll.min.js"></script>
<script src="js/jquery.dlmenu.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript">
  //Script para confirmação de exclusão de arquivo
        $('#confirmApagar').on('show.bs.modal', function (e)
        {
            $message = $(e.relatedTarget).attr('data-message');
            $(this).find('.modal-body p').text($message);
             
            // Pass form reference to modal for submission on yes/ok
            var form = $('form[id=apagarArq]');
            $(this).find('.modal-footer #confirm').data('form[id=apagarArq]', form);
        });
         
        // Form confirm (yes/ok) handler, submits form
        $('#confirmApagar').find('.modal-footer #confirm').on('click', function()
        {
            $(this).data('form[id=apagarArq]').submit();
        });
    </script>
</body>
