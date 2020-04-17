<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$idEvento = $_SESSION['idEvento'];


if (isset($_POST['consultaIntegrante'])) {
    $cpf = $_POST['cpf'];

    $queryIntegrante = $con->query("SELECT * FROM integrante WHERE cpf = '$cpf' AND publicado = '1'");

    if ($queryIntegrante->num_rows > 0) {
        $integrante = $queryIntegrante->fetch_assoc();
    } else {
        $integrante = null;
    }
}

include '../perfil/includes/menu_culturaonline.php';
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <div class="form-group">
            <h4>Adicionar Integrante</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=evento_culturaonline_integrantes" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label for="nome">Nome *</label>
                            <input class="form-control" type="text" name="nome" id="nome" value="<?= $integrante['nome'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label for="rg">RG *</label>
                            <input class="form-control" type="text" name="rg" id="rg" value="<?= $integrante['rg'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label for="cpf">CPF *</label>
                            <input class="form-control" type="text" name="cpf" id="cpf" value="<?= $integrante['cpf'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <?php if ($integrante != null): ?>
                                <input type="hidden" name="idIntegrante" value="<?= $integrante['idIntegrante'] ?>">
                            <?php endif; ?>
                            <input type="submit" class="btn btn-theme btn-lg btn-block" name="addIntegrante" value="Gravar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>