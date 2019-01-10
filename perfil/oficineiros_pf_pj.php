<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include '../perfil/includes/menu_oficinas.php'; ?>
        <div class="form-group">
            <h3>OFICINEIRO</h3>
            <h5>
                <?php if(isset($mensagem)){echo $mensagem;}; ?>
            </h5>
        </div>
        <div class="row col-md-offset-4 col-md-6">
            <p>Aqui você insere ou atualiza o cadastro do artista.</p>
            <a href="?perfil=oficineiro_pf" class="btn btn-theme btn-lg btn-block">PESSOA FÍSICA</a>
            <br />
            <p>Aqui você insere ou atualiza os dados cadastrais da empresa.</p>
            <a href="?perfil=oficineiro_pj" class="btn btn-theme btn-lg btn-block">PESSOA JURÍDICA</a>
            <br />
        </div>
    </div>
</section>