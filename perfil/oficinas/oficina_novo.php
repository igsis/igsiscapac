<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
?>
<section id="inserir" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h4>Informações Gerais da Oficina</h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=oficinas/oficina_edicao" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Nome da Oficina *</label>
                            <input type="text" name="nomeEvento" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Classificação indicativa *</label> <a href="?perfil=classificacaoIndicativa" target="_blank"><i>(Confira aqui como classificar)</i></a>
                            <select class="form-control" name="idFaixaEtaria" id="inputSubject" required>
                                <option value=""></option>
                                <?php geraOpcao("faixa_etaria","") ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Sinopse *</label>
                            <label>Esse campo deve conter uma breve descrição do que será apresentado no espetáculo.</i></strong></label>
                            <p align="justify"><font color="gray"><strong><i>Texto de exemplo:</strong><br/>Ana Cañas faz o show de lançamento do seu quarto disco, “Tô na Vida” (Som Livre/Guela Records). Produzido por Lúcio Maia (Nação Zumbi) em parceria com Ana e mixado por Mario Caldato Jr, é o primeiro disco totalmente autoral da carreira da cantora e traz parcerias com Arnaldo Antunes e Dadi entre outros.</font></i></p>
                            <textarea name="sinopse" class="form-control" rows="10" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Links </label>
                            <label>Esse campo deve conter os links relacionados ao espetáculo, ao artista/grupo que auxiliem na divulgação do evento.</i></strong></label>
                            <p align="justify"><font color="gray"><strong><i>Links de exemplo:</i></strong></strong><br/> https://www.facebook.com/anacanasoficial/<br/></strong>https://www.youtube.com/user/anacanasoficial</font></i></p>
                            <textarea name="link" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="insere" />
                            <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
