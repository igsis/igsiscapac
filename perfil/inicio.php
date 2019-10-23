<?php
$con = bancoMysqli();

$formacao = $con->query('SELECT `situacao` FROM `formacao_cadastro`')->fetch_assoc();
$situacao_jm = $con->query('SELECT `situacao_atual` FROM `jm_cadastro`')->fetch_assoc();

unset($_SESSION['idEvento']);
unset($_SESSION['idPj']);
unset($_SESSION['idPf']);
unset($_SESSION['menu']);
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group"><br/>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="alert alert-danger">
							<h5><font color="red">ATENÇÃO!</font></h5>
							<p>A utilização de mais de uma aba ou janela do mesmo navegador para inserção ou edição dos dados pode causar perda de informações.</p>
						</div>
						<?php
							$usr = $_SESSION['idUser'];
							if($usr < 11)
							{
								echo "<a href='?perfil=busca_reset' class='btn btn-theme btn-lg btn-block'>Reiniciar Senha</a><br/>";
							}
						?>
                        <p>Selecione aqui o tipo de evento <strong>(teatro, dança, oficina, música, etc)</strong> que deseja cadastrar</p>
                        <button type="button" class="btn btn-theme btn-lg btn-block" data-toggle="collapse" data-target="#evento">EVENTO</button>
                        <div id="evento" class="collapse">
                            <div class="well">
                                <p>Aqui são inseridas as informações sobre o seu evento com cachê, incluindo pessoa jurídica e/ou física.</p>
                                <a href="?perfil=evento_apresentacao" class="btn btn-theme btn-lg btn-block">EVENTO COM CACHÊ</a>
                                <br />
                                <p>Aqui são inseridas as informações sobre o seu evento sem cachê, incluindo pessoa jurídica e/ou física.</p>
                                <a href="?perfil=evento_apresentacao_semcache" class="btn btn-theme btn-lg btn-block">EVENTO SEM CACHÊ</a>
                                <br />
                                <p>Aqui são inseridas as informações sobre o seu evento, que não terá contratação.</p>
                                <a href="?perfil=evento_apresentacao_semcontratacao" class="btn btn-theme btn-lg btn-block">EVENTO SEM CONTRATAÇÃO</a>
                                <br />
                            </div>
                        </div>
                        <br>
                        <p>Aqui são inseridas as informações dos oficineiros <strong>JÁ SELECIONADOS NO EDITAL n. 002/2018 SMC/GAB</strong></p>
						<a href="?perfil=evento_apresentacao_oficinas" class="btn btn-theme btn-lg btn-block">OFICINAS - EDITAL 002/2018</a>
						<br />

                        <?php if($situacao_jm['situacao_atual'] == 1) { ?>
                            <p>Aqui é realizado o cadastro de novos <strong>Jovens Monitores </strong></p>
                            <a href="?perfil=jovem_monitor/cadastro" class="btn btn-theme btn-lg btn-block">Programa
                                Jovem Monitor Cultural</a>
                            <br/>
                        <?php
                        }
                        ?>
                        <?php if($formacao['situacao'] == 1) { ?>
                            <p>Aqui são inseridas os dados para inscrição às vagas dos Editais dos Programas da Supervisão de Formação (Vocacional / PIA).</p>
                            <a href="?perfil=formacao_apresentacao" class="btn btn-theme btn-lg btn-block">FORMAÇÃO - PIÁ e VOCACIONAL</a>
                            <br />
						<?php
                        }
						if($usr < 11)
						{
						?>
							<p>Aqui você atualiza o cadastro do artista.</p>
								<a href="?perfil=proponente_pf" class="btn btn-theme btn-lg btn-block">PESSOA FÍSICA</a>
							<br />
							<p>Aqui você atualiza os dados cadastrais da empresa.</p>
							<a href="?perfil=proponente_pj" class="btn btn-theme btn-lg btn-block">PESSOA JURÍDICA</a>
							<br />
						<?php } ?>
						<p>Aqui você altera os seus dados de login e senha.</p>
						<a href="?perfil=minha_conta" class="btn btn-theme btn-lg btn-block" target="_blank" >MINHA CONTA</a>
						<br />
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6">
						<a href="http://smcsistemas.prefeitura.sp.gov.br/manual/igsiscapac/" target="_blank" class="btn btn-theme btn-lg btn-block">Ajuda</a>
					</div>
					<div  class="col-md-6">
						<a href="../include/logoff.php" class="btn btn-theme btn-lg btn-block">SAIR</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>