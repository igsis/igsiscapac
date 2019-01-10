<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include  '../perfil/includes/oficina_menu_evento.php'; ?>

        <div class="form-group">
            <h4>Finalizar</h4>
            <p>
                <strong>
                    <span style="color: green;">
                        Todos os campos obrigatórios foram preenchidos corretamente.<br/>
                        Seu cadastro de Pessoa Física foi concluído com sucesso!<br>
                    </span>
                </strong>
            </p><br>
           <!-- <div class="alert alert-success ">
                Seu Código de Cadastro é <strong>5-<?/*= $pj['id'] */?></strong>
            </div>-->

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <div class="col-md-offset-1 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_arquivos_com_prod" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>