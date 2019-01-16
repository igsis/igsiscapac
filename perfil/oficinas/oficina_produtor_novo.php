<section id="inserir" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h4>Dados do Produtor</h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=oficinas/oficina_produtor_edicao" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Nome do Produtor*</label>
                            <input type="text" name="nome" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>E-mail*</label>
                            <input type="text" name="email" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6">
                            <label>Celular *:</label>
                            <input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" />
                        </div>
                        <div class="col-md-6">
                            <label>Outro telefone:</label>
                            <input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="insere" />
                            <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
                        </div>
                    </div>
                </form>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/>
                    </div>
                </div>
                <!-- Botão para Voltar e Prosseguir -->
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-12">
                        <div class="col-md-offset-1 col-md-2">
                            <form class="form-horizontal" role="form" action="?perfil=oficinas/arquivos_oficina" method="post">
                                <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                            </form>
                        </div>
                        <div class="col-md-offset-4 col-md-2">
                            <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_arquivos_com_prod" method="post">
                                <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>