<?php
$idUser= $_SESSION['idUser'];
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_oficinas.php'; ?>
        <div class="form-group">
            <h3>Resumo das Informações para preenchimento do cadastro</h3>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div align="justify">
                            <p align="justify">Inicia-se aqui um processo passo-a-passo para o preenchimento dos dados
                                do oficineiro conforme descrito abaixo. Antes de começar, tenha disponível estas informações
                                para que o cadastro possa ser concluído.</p>

                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Cadastro do Oficineiro</b></li>
                                <li class="list-group-item">Escolha entre "Pessoa Física" ou "Pessoa Jurídica"</li>
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
                                        <li class="list-group-item list-group-item-danger text-center"><b>Somente com MEI</b></li><br>
                                        <li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
                                        <li class="lista-informacao">Razão Social</li>
                                        <li class="lista-informacao">CNPJ</li>
                                        <li class="lista-informacao">CCM</li>
                                        <li class="lista-informacao">Celular</li>
                                        <li class="lista-informacao">Telefone #2</li>
                                        <li class="lista-informacao">Telefone #3</li>
                                        <li class="lista-informacao">E-mail</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Arquivos da Empresa em PDF</b></li>
                                        <li class="lista-informacao"><a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a></li>
                                        <li class="lista-informacao"><a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></li>
                                        <li class="lista-informacao"><a href="https://www3.prefeitura.sp.gov.br/cpom2/Consulta_Tomador.aspx" target="_blank">CPOM - Cadastro de Empresas Fora do Município</a></li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Endereço</b></li>
                                        <li class="lista-informacao">CEP</li>
                                        <li class="lista-informacao">Número</li>
                                        <li class="lista-informacao">Complemento</li>
                                        <li class="lista-informacao">Prefeitura Regional</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Informações Complementares</b></li>
                                        <li class="lista-informacao">Nível</li>
                                        <li class="lista-informacao">Linguagem</li>
                                        <li class="lista-informacao">Curriculo</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Representante Legal</b></li>
                                        <li class="lista-informacao">Nome</li>
                                        <li class="lista-informacao">RG/RNE/PASSAPORTE</li>
                                        <li class="lista-informacao">CPF</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Arquivos do Representante Legal em PDF</b></li>
                                        <li class="lista-informacao">RG/RNE/PASSAPORTE</li>
                                        <li class="lista-informacao">CPF</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Dados Bancários</b></li>
                                        <li class="list-group-item list-group-item-danger"><b>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br/> Não são aceitas: conta fácil, poupança e conjunta. <br/> *A conta deve estar em nome da Pessoa Jurídica que está sendo contratada*</b></li>
                                        <li class="lista-informacao">Banco</li>
                                        <li class="lista-informacao">Agência</li>
                                        <li class="lista-informacao">Conta</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Dados e Cronograma da Oficina</b></li>
                                        <li class="lista-informacao">Nome da Oficina</li>
                                        <li class="lista-informacao">Modalidade</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Demais Anexos</b></li>
                                        <li class="lista-informacao"><a href="https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp" target="_blank">CRF do FGTS</a></li>
                                        <li class="lista-informacao"><a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais</a></li>
                                        <li class="lista-informacao"><a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">CADIN Municipal</a></li>
                                        <li class="lista-informacao"><a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/CNDConjuntaSegVia/NICertidaoSegVia.asp?Tipo=1" target="_blank">CND Federal - (Certidão Negativa de Débitos de Tributos Federais)</a></li>
                                        <li class="lista-informacao">CNDT - Certidão Negativa de Débitos de Tributos Trabalhistas</li>
                                        <li class="lista-informacao">Declaração de Aceite</li>
                                        <li class="lista-informacao">Comprovante de experiência artístico-pedagógica (no mínimo 2)</li>
                                        <li class="lista-informacao">Comprovante de experiência artística (no mínimo 2)</li>

                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Finalizar</b></li>
                                        <li class="lista-informacao">Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
                                        <li class="lista-informacao">Listará também, quando existirem, os campos pendente para preenchimento.</li>
                                    </ul>
                                </div>

                                <!-- PASSOS PESSOA FÍSICA -->
                                <div class="tab-pane fade" id="B">
                                    <br>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
                                        <li class="lista-informacao">Nome</li>
                                        <li class="lista-informacao">Nome Artístico</li>
                                        <li class="lista-informacao">Tipo de Documento</li>
                                        <li class="lista-informacao">Nº do documento</li>
                                        <li class="lista-informacao">CPF</li>
                                        <li class="lista-informacao">CCM</li>
                                        <li class="lista-informacao">Celular</li>
                                        <li class="lista-informacao">Telefone #2</li>
                                        <li class="lista-informacao">Telefone #3</li>
                                        <li class="lista-informacao">E-mail</li>
                                        <li class="lista-informacao">Data de Nascimento</li>
                                        <li class="lista-informacao">PIS/PASEP/NIT</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Arquivos da Pessoa</b></li>
                                        <li class="lista-informacao">RG/RNE/PASSAPORTE</li>
                                        <li class="lista-informacao">CPF</li>
                                        <li class="lista-informacao">PIS/PASEP/NIT</li>
                                        <li class="lista-informacao">FDC – CCM (Ficha de Dados Cadastrais de Contribuintes Mobiliários)</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Endereço</b></li>
                                        <li class="lista-informacao">CEP</li>
                                        <li class="lista-informacao">Número</li>
                                        <li class="lista-informacao">Complemento</li>
                                        <li class="lista-informacao">Prefeitura Regional</li>
                                        <li class="lista-informacao">Comprovante de Residência</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Informações Complementares</b></li>
                                        <li class="lista-informacao">Nível</li>
                                        <li class="lista-informacao">Linguagem</li>
                                        <li class="lista-informacao">Curriculo</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Dados Bancários</b></li>
                                        <li class="list-group-item list-group-item-danger"><b>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br />Não são aceitas: conta fácil, poupança e conjunta.</b></li>
                                        <li class="lista-informacao">Banco</li>
                                        <li class="lista-informacao">Agência</li>
                                        <li class="lista-informacao">Conta</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Dados e Cronograma da Oficina</b></li>
                                        <li class="lista-informacao">Nome da Oficina</li>
                                        <li class="lista-informacao">Modalidade</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Demais Anexos</b></li>
                                        <li class="lista-informacao">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais</li>
                                        <li class="lista-informacao">CADIN Municipal</li>
                                        <li class="lista-informacao">CND Federal - (Certidão Negativa de Débitos de Tributos Federais)</li>
                                        <li class="lista-informacao">CNDT - Certidão Negativa de Débitos de Tributos Trabalhistas</li>
                                        <li class="lista-informacao">Comprovante de experiência artístico-pedagógica (no mínimo 2)</li>
                                        <li class="lista-informacao">Comprovante de experiência artística (no mínimo 2)</li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><b>Finalizar</b></li>
                                        <li class="lista-informacao">Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
                                        <li class="lista-informacao">Listará também, quando existirem, os campos pendente para preenchimento.</li>
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
                    <form class="form-horizontal" role="form" action="?perfil=oficineiros_pf_pj" method="post">
                        <input type="submit" value="Iniciar Cadastro" class="btn btn-theme btn-lg btn-block" />
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>