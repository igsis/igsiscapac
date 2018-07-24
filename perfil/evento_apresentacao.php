<?php
$idUser= $_SESSION['idUser'];
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h3>Resumo das Informações para preenchimento do evento</h3>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div align="justify">
							<p align="justify">Inicia-se aqui um processo passo-a-passo para o  preenchimento dos dados do evento conforme descrito abaixo. Antes de começar, tenha disponível estas informações para que o cadastro possa ser concluído.</p>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success list-group-item"><b>Informações Gerais do Evento</b></li>
								<li class="list-group-item">Nome do evento</li>
								<li class="list-group-item">Tipo de evento</li>
								<li class="list-group-item">Nome do grupo (se houver)</li>
								<li class="list-group-item">Ficha técnica completa</li>
								<li class="list-group-item">Integrantes do Grupo</li>
								<li class="list-group-item">Classificação indicativa</li>
								<li class="list-group-item">Sinopse</li>
								<li class="list-group-item">Release</li>
								<li class="list-group-item">Links para divulgação</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Arquivos do Evento em PDF</b></li>
								<li class="list-group-item">Repertório</li>
								<li class="list-group-item">Material de imprensa (clipping)</li>
								<li class="list-group-item">Autorização SBAT</li>
								<li class="list-group-item">Currículo do Grupo</li>
								<li class="list-group-item">Documentos Comprobatórios de Valor</li>
								<li class="list-group-item">DRT dos Integrantes do Grupo</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Dados do Produtor</b></li>
								<li class="list-group-item">Nome</li>
								<li class="list-group-item">E-mail</li>
								<li class="list-group-item">Celular</li>
								<li class="list-group-item">Outro telefone (se houver)</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Arquivos Para Comunicação e Produção</b></li>
								<li class="list-group-item">Nesta página você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, entre outros arquivos destinados à comunicação e produção.</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Cadastro do Proponente</b></li>
								<li class="list-group-item">Informe se haverá ou não haverá representação jurídica</li>
							</ul>

							<ul class="nav nav-tabs">
        						<li class="nav active"><a href="#A" data-toggle="tab">Para Pessoa Jurídica</a></li>
        						<li class="nav"><a href="#B" data-toggle="tab">Para Pessoa Fisica</a></li>
    						</ul>

    						<div class="tab-content">
    							<!-- PASSOS PESSOA JURÍDICA -->
        						<div class="tab-pane fade in active" id="A">
        							<br>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
										<li class="list-group-item">Razão Social</li>
										<li class="list-group-item">CNPJ</li>
										<li class="list-group-item">CCM</li>
										<li class="list-group-item">Celular</li>
										<li class="list-group-item">Telefone #2</li>
										<li class="list-group-item">Telefone #3</li>
										<li class="list-group-item">E-mail</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Arquivos da Empresa em PDF</b></li>
										<li class="list-group-item"><a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a></li>
										<li class="list-group-item"><a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></li>
										<li class="list-group-item"><a href="https://www3.prefeitura.sp.gov.br/cpom2/Consulta_Tomador.aspx" target="_blank">CPOM - Cadastro de Empresas Fora do Município</a></li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Endereço</b></li>
										<li class="list-group-item">CEP</li>
										<li class="list-group-item">Número</li>
										<li class="list-group-item">Complemento</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Representante Legal</b></li>
										<li class="list-group-item">Nome</li>
										<li class="list-group-item">RG/RNE/PASSAPORTE</li>
										<li class="list-group-item">CPF</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Arquivos do Representante Legal em PDF</b></li>
										<li class="list-group-item">RG/RNE/PASSAPORTE</li>
										<li class="list-group-item">CPF</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Dados Bancários</b></li>
										<li class="list-group-item list-group-item-danger"><b>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br/> Não são aceitas: conta fácil, poupança e conjunta. <br/> *A conta deve estar em nome da Pessoa Jurídica que está sendo contratada*</b></li>
										<li class="list-group-item">Banco</li>
										<li class="list-group-item">Agência</li>
										<li class="list-group-item">Conta</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Arquivo dos Dados Bancários em PDF</b></li>
										<li class="list-group-item">Gerar FACC</li>
										<li class="list-group-item">Anexar a FACC depois de assinada</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>ARTISTA - Líder do Grupo ou Artista Solo</b></li>
										<li class="list-group-item">Nome</li>
										<li class="list-group-item">Nome Artístico</li>
										<li class="list-group-item">RG/RNE/PASSAPORTE</li>
										<li class="list-group-item">CPF</li>
										<li class="list-group-item">E-mail</li>
										<li class="list-group-item">Celular</li>
										<li class="list-group-item">Telefone #2</li>
										<li class="list-group-item">Telefone #3</li>
										<li class="list-group-item">DRT</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Arquivos do Líder do Grupo ou Artista Solo em PDF</b></li>
										<li class="list-group-item">RG/RNE/PASSAPORTE</li>
										<li class="list-group-item">CPF</li>
										<li class="list-group-item">DRT</li>
										<li class="list-group-item">Currículo Artístico do Líder do Grupo</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Declaração de Exclusividade</b></li>
										<li class="list-group-item">Gerar a Declaração de Exclusividade</li>
										<li class="list-group-item">Anexar a Declaração de Exclusividade depois de assinada</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Demais Anexos</b></li>
										<li class="list-group-item">Demais anexos necessários para a contratação</li>
										<li class="list-group-item"><a href="https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp" target="_blank">CRF do FGTS</a></li>
										<li class="list-group-item">Contrato Social</li>
										<li class="list-group-item"><a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais</a></li>
										<li class="list-group-item"><a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx">CADIN Municipal</a></li>
										<li class="list-group-item">Estatuto Social</li>
										<li class="list-group-item"><a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/CNDConjuntaSegVia/NICertidaoSegVia.asp?Tipo=1" target="_blank">CND</a></li>

									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Finalizar</b></li>
										<li class="list-group-item">Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
										<li class="list-group-item">Listará também, quando existirem, os campos pendente para preenchimento.</li>
									</ul>
        						</div>

        						<!-- PASSOS PESSOA FÍSICA -->
        						<div class="tab-pane fade" id="B">
        							<br>
        							<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
										<li class="list-group-item">Nome</li>
										<li class="list-group-item">Nome Artístico</li>
										<li class="list-group-item">Tipo de Documento</li>
										<li class="list-group-item">Nº do documento</li>
										<li class="list-group-item">CPF</li>
										<li class="list-group-item">CCM</li>
										<li class="list-group-item">Celular</li>
										<li class="list-group-item">Telefone #2</li>
										<li class="list-group-item">Telefone #3</li>
										<li class="list-group-item">E-mail</li>
										<li class="list-group-item">Data de Nascimento</li>
										<li class="list-group-item">PIS/PASEP/NIT</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Arquivos da Pessoa</b></li>
										<li class="list-group-item">RG/RNE/PASSAPORTE</li>
										<li class="list-group-item">CPF</li>
										<li class="list-group-item">PIS/PASEP/NIT</li>
										<li class="list-group-item">FDC – CCM (Ficha de Dados Cadastrais de Contribuintes Mobiliários)</li>	
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Endereço</b></li>
										<li class="list-group-item">CEP</li>
										<li class="list-group-item">Número</li>
										<li class="list-group-item">Complemento</li>
										<li class="list-group-item">Comprovante de Residência</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações Complementares</b></li>
										<li class="list-group-item">DRT (Somente para Teatro, Dança ou Circo)</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Dados Bancários</b></li>
										<li class="list-group-item list-group-item-danger"><b>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br />Não são aceitas: conta fácil, poupança e conjunta.</b></li>
										<li class="list-group-item">Banco</li>
										<li class="list-group-item">Agência</li>
										<li class="list-group-item">Conta</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Arquivo dos Dados Bancários em PDF</b></li>
										<li class="list-group-item">Gerar FACC</li>
										<li class="list-group-item">Anexar a FACC depois de assinada</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Demais Anexos</b></li>
										<li class="list-group-item">Demais anexos necessários para a contratação</li>
										<li class="list-group-item"><a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais</a></li>
										<li class="list-group-item"><a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx">CADIN Municipal</a></li>
										<li class="list-group-item">Currículo</li>
										<li class="list-group-item">CND Federal - (Certidão Negativa de Débitos de Tributos Federais)</li>
										<li class="list-group-item">Gerar a Declaração de Exclusividade</li>
										<li class="list-group-item">Anexar a Declaração de Exclusividade depois de assinada</li>
										<li class="list-group-item">Currículo Artístico do Líder do Grupo</li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Finalizar</b></li>
										<li class="list-group-item">Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
										<li class="list-group-item">Listará também, quando existirem, os campos pendente para preenchimento.</li>
									</ul>
        						</div>
    						</div>
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
						<input type="submit" value="Iniciar Evento" class="btn btn-theme btn-lg btn-block" />
					</form>
				</div>
			</div>

		</div>
	</div>
</section>