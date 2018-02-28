<?php
$idUser= $_SESSION['idUser'];
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>EVENTOS</h3>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div align="justify">
							<p align="justify">Inicia-se aqui um processo passo-a-passo para o  preenchimento dos dados do evento conforme descrito abaixo. Antes de começar, tenha disponível estas informações para que o cadastro possa ser concluído.</p>
							<p>PASSSO 1: Informações Gerais do Evento</p>
							<ul>
								<li>Nome do evento</li>
								<li>Tipo de evento</li>
								<li>Nome do grupo (se houver)</li>
								<li>Ficha técnica completa</li>
								<li>Classificação indicativa</li>
								<li>Sinopse</li>
								<li>Release</li>
								<li>Links para divulgação</li>
							</ul>
							<p>PASSSO 2: Arquivos do Evento em PDF</p>
							<ul>
								<li>Repertório</li>
								<li>Material de imprensa (clipping)</li>
								<li>Autorização SBAT</li>
								<li>Currículo do Grupo</li>
								<li>Currículo da Companhia</li>
								<li>Histórico do Grupo ou Artista</li>
							</ul>
							<p>PASSSO 3: Dados do Produtor</p>
							<ul>
								<li>Nome</li>
								<li>E-mail</li>
								<li>Celular</li>
								<li>Outro telefone (se houver)</li>
							</ul>
							<p>PASSSO 4: Arquivos Para Comunicação e Produção</p>
							<ul>
								<li>Nesta página você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, entre outros arquivos destinados à comunicação e produção.</li>
							</ul>
							<p>PASSO 5: Cadastro do Proponente</p>
							<ul>
								<li>Informe se haverá pu não haverá representação jurídica</li>
							</ul>
							<p>Se houver Pessoa Jurídica</p>
							<p>PASSO 6: Informações iniciais</p>
							<ul>
								<li>Razão Social</li>
								<li>CNPJ</li>
								<li>CCM</li>
								<li>Celular</li>
								<li>Telefone #2</li>
								<li>Telefone #3</li>
								<li>E-mail</li>
							</ul>
							<p>PASSO 7: Arquivos da Empresa em PDF</p>
							<ul>
								<li><a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a></li>
								<li><a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></li>
								<li><a href="https://www3.prefeitura.sp.gov.br/cpom2/Consulta_Tomador.aspx" target="_blank">CPOM - Cadastro de Empresas Fora do Município</a></li>
							</ul>
							<p>PASSO 8: Endereço</p>
							<ul>
								<li>CEP</li>
								<li>Número</li>
								<li>Complemento</li>
							</ul>
							<p>PASSO 9: Representante Legal</p>
							<ul>
								<li>Nome</li>
								<li>RG</li>
								<li>CPF</li>
							</ul>
							<p>PASSO 10: Arquivos do Representante Legal em PDF</p>
							<ul>
								<li>RG</li>
								<li>CPF</li>
							</ul>
							<p>PASSO 11: Dados Bancários</p>
							<p><font color="#FF0000"><strong>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br />Não são aceitas: conta fácil, poupança e conjunta.</strong></font></p>
							<ul>
								<li>Banco</li>
								<li>Agência</li>
								<li>Conta</li>
							</ul>
							<p>PASSO 12: Arquivo dos Dados Bancários em PDF</p>
							<ul>
								<li>Gerar FACC</li>
								<li>Anexar a FACC depois de assinada</li>
							</ul>

						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8"><hr/></div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<form class="form-horizontal" role="form" action="?perfil=evento" method="post">
						<input type="submit" value="Prosseguir" class="btn btn-theme btn-lg btn-block" />
					</form>
				</div>
			</div>

		</div>
	</div>
</section>