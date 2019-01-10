<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$tipoPessoa = "3";


if(isset($_POST['insere']) || isset($_POST['atualizar']))
{
    $nomeEvento = addslashes($_POST['nomeEvento']);
    $integrantes = addslashes($_POST['integrantes']);
    $idFaixaEtaria = $_POST['idFaixaEtaria'];
    $sinopse = addslashes($_POST['sinopse']);
    $link = addslashes($_POST['link']);
    $dataCadastro = date('YmdHis');
}

if(isset($_POST['insere']))
{
    $sql_insere = "INSERT INTO `evento`(`idTipoEvento`, `nomeEvento`, `integrantes`, `idFaixaEtaria`, `sinopse`, `link`, `dataCadastro`, `publicado`, `contratacao`, `idUsuario`) VALUES ('4', '$nomeEvento', '$integrantes', '$idFaixaEtaria', '$sinopse', '$link', '$dataCadastro', '1', '1', '$idUser')";
    if(mysqli_query($con,$sql_insere))
    {
        $mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso!</strong></font>";
        gravarLog($sql_insere);
        $sql_ultimo = "SELECT id FROM evento WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
        $query_ultimo = mysqli_query($con,$sql_ultimo);
        $ultimoEvento = mysqli_fetch_array($query_ultimo);
        $_SESSION['idEvento'] = $ultimoEvento['id'];
        $idEvento = $_SESSION['idEvento'];
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['atualizar']))
{
    $idEvento = $_SESSION['idEvento'];
    $sql_atualizar = "UPDATE evento SET
		nomeEvento = '$nomeEvento',
		idTipoEvento = 4,
		integrantes = '$integrantes',
		idFaixaEtaria = '$idFaixaEtaria',
		sinopse = '$sinopse',
		link = '$link',
		dataCadastro = '$dataCadastro',
		idUsuario = '$idUser'
		WHERE id = '$idEvento'";
    if(mysqli_query($con,$sql_atualizar))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_atualizar);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['carregar']))
{
    $_SESSION['idEvento'] = $_POST['carregar'];
    $idEvento = $_SESSION['idEvento'];
}

if(isset($_SESSION['idEvento']))
{
    $idEvento = $_SESSION['idEvento'];
}

$evento = recuperaDados("evento","id", $idEvento);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h4>Informações Gerais da Oficina</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=oficinas/oficina_edicao" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Nome da Oficina *</label>
                            <input type="text" name="nomeEvento" maxlength="240" class="form-control" value="<?php echo $evento['nomeEvento'] ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><strong>Integrantes do grupo:</strong><br/>
                            <label>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo <font color='#FF0000'>incluindo o líder do grupo</font>.<br/>Apenas o <font color='#FF0000'>nome civil, RG e CPF</font> de quem irá se apresentar, excluindo técnicos.</i></strong></label>
                            <p align="justify"><font color="gray"><strong><i>Elenco de exemplo:</strong><br/>Ana Cañas RG 00000000-0 CPF 000.000.000-00<br/>Lúcio Maia RG 00000000-0 CPF 000.000.000-00<br/>Fabá Jimenez RG 00000000-0 CPF 000.000.000-00</br>Fabio Sá RG 00000000-0 CPF 000.000.000-00</br>Marco da Costa RG 00000000-0 CPF 000.000.000-00</font></i></p>
                            <textarea name="integrantes" class='form-control' cols="40" rows="5" required><?php echo $evento['integrantes'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Classificação indicativa *</label> <a href="?perfil=classificacaoIndicativa" target="_blank"><i>(Confira aqui como classificar)</i></a>
                            <select class="form-control" name="idFaixaEtaria" id="inputSubject" >
                                <option>Selecione...</option>
                                <?php echo geraOpcao("faixa_etaria",$evento['idFaixaEtaria']) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Sinopse *</label>
                            <label>Esse campo deve conter uma breve descrição do que será apresentado no espetáculo.</i></strong></label>
                            <p align="justify"><font color="gray"><strong><i>Texto de exemplo:</strong><br/>Ana Cañas faz o show de lançamento do seu quarto disco, “Tô na Vida” (Som Livre/Guela Records). Produzido por Lúcio Maia (Nação Zumbi) em parceria com Ana e mixado por Mario Caldato Jr, é o primeiro disco totalmente autoral da carreira da cantora e traz parcerias com Arnaldo Antunes e Dadi entre outros.</font></i></p>
                            <textarea name="sinopse" class="form-control" rows="10"><?php echo $evento['sinopse'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Links </label>
                            <label>Esse campo deve conter os links relacionados ao espetáculo, ao artista/grupo que auxiliem na divulgação do evento.</i></strong></label>
                            <p align="justify"><font color="gray"><strong><i>Links de exemplo:</i></strong></strong><br/> https://www.facebook.com/anacanasoficial/<br/></strong>https://www.youtube.com/user/anacanasoficial</font></i></p>
                            <textarea name="link" class="form-control" rows="5"><?php echo $evento['link'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="atualizar" />
                            <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-offset-2 col-md-8">
            <hr/>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <div class="col-md-offset-1 col-md-2">
                    <form class="form-horizontal" role="form" action="?perfil=oficinas/oficinas" method="post">
                        <input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                    </form>
                </div>
                <div class="col-md-offset-6 col-md-2">
                    <form class="form-horizontal" role="form" action="?perfil=oficinas/arquivos_oficina" method="post">
                        <input type="submit" value="Avançar" class="btn btn-theme btn-md btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>