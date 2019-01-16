<?php
$idUser= $_SESSION['idUser'];
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_formacao.php'; ?>
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
                                <li class="lista-informacao">Estado Civil</li>
                                <li class="lista-informacao">Nacionalidade</li>
                                <li class="lista-informacao">PIS/PASEP/NIT</li>
                                <li class="lista-informacao">Programa</li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Arquivos da Pessoa (Upload de arquivo em formato PDF)</b></li>
                                <li class="lista-informacao">RG/RNE/PASSAPORTE</li>
                                <li class="lista-informacao">CPF</li>
                                <li class="lista-informacao">PIS/PASEP/NIT</li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Endereço</b></li>
                                <li class="lista-informacao">CEP</li>
                                <li class="lista-informacao">Número</li>
                                <li class="lista-informacao">Complemento</li>
                                <li class="lista-informacao">Comprovante de Residência</li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Informações Complementares</b></li>
                                <li class="lista-informacao">DRT</li>
                                <li class="lista-informacao">Etnia</li>
                                <li class="lista-informacao">Grau de Instrução</li>
                                <li class="lista-informacao">Função</li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Dados Bancários</b></li>
                                <li class="list-group-item list-group-item-danger">
                                    <b>
                                        <p>
                                            Pagamentos serão feitos unicamente em conta corrente de Pessoa Física no
                                            Banco do Brasil. <br>
                                            Não são aceitas: conta fácil, poupança e conjunta. <br>
                                            Candidato contratado que não possuir conta, receberá no ato da assinatura do
                                            contrato, carta de apresentação para abertura da conta.
                                        </p>
                                    </b>
                                </li>
                                <li class="lista-informacao">Banco</li>
                                <li class="lista-informacao">Agência</li>
                                <li class="lista-informacao">Conta</li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Demais Anexos (Upload de arquivo em formato PDF)</b></li>
                                <li class="lista-informacao">Anexos de III a V</li>
                                <li class="lista-informacao">Currículo</li>
                                <?php
                                    $comprovantes = [
                                        'Comprovante de Formação',
                                        'Comprovante de Experiência Artística',
                                        'Comprovante de Experiência Artístico-pedagógica',
                                        'Comprovante de Experiência em Coordenação/Articulação'
                                    ];
                                    foreach ($comprovantes as $key => $comprovante)
                                    {
                                        for ($i=1;$i<=4;$i++)
                                        {
                                ?>
                                            <li class="lista-informacao"><?= $comprovante." ".$i ?> <?= ($key == 3) ? "*(Para algumas funções)*" : "" ?></li>
                                <?php
                                        }
                                    }
                                ?>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Finalizar</b></li>
                                <li class="lista-informacao ">Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
                                <li class="lista-informacao ">Listará também, quando existirem, os campos pendente para preenchimento.</li>
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