<?php
$idUser= $_SESSION['idUser'];
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
        <div class="form-group">
            <h3>Resumo das Informações para preenchimento do Formação</h3>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div align="justify">
                            <p align="justify">Inicia-se aqui um processo passo-a-passo para o preenchimento dos dados
                                do candidato às vagas dos Editais dos Programas da Supervisão de Formação. Antes de
                                começar, tenha disponível estas informações para que o cadastro possa ser concluído.
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Informações iniciais - Pessoa Física</b></li>
                                <li class="list-group-item">Nome</li>
                                <li class="list-group-item">Nome Artístico</li>
                                <li class="list-group-item">Tipo de Documento</li>
                                <li class="list-group-item">Nº do documento</li>
                                <li class="list-group-item">CPF</li>
                                <li class="list-group-item">CCM</li>
                                <li class="list-group-item">Telefone #1</li>
                                <li class="list-group-item">Telefone #2</li>
                                <li class="list-group-item">Telefone #3</li>
                                <li class="list-group-item">E-mail</li>
                                <li class="list-group-item">Data de Nascimento</li>
                                <li class="list-group-item">PIS/PASEP/NIT</li>
                                <li class="list-group-item">Estado Civil</li>
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
                            vocacional
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Demais Anexos</b></li>
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

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8"><hr/></div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <form class="form-horizontal" role="form" action="?perfil=formacao" method="post">
                        <input type="submit" value="Iniciar Inscrição" class="btn btn-theme btn-lg btn-block" />
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>