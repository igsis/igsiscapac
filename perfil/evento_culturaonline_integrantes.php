<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$idEvento = $_SESSION['idEvento'];

$evento = recuperaDados("evento","id", $idEvento);

if (isset($_POST['addIntegrante'])) {
    $nome = trim($_POST['nome']);
    $rg = trim($_POST['rg']);
    $cpf = $_POST['cpf'];

    $integrante = $con->query("SELECT idIntegrante FROM integrante WHERE cpf = '$cpf' AND publicado = '1'")->num_rows;

    if ($integrante == 0) {
        $sql = "INSERT INTO integrante (nome, rg, cpf) VALUES ('$nome', '$rg', '$cpf')";
        if ($con->query($sql)) {
            $integrante_id = $con->insert_id;

            $con->query("INSERT INTO evento_integrante (evento_id, integrante_id) VALUES ('$idEvento', '$integrante_id')");

            $mensagem = "<font color='#01DF3A'><strong>Integrante inserido com sucesso!</strong></font>";
            gravarLog($sql);
        } else {
            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente. COD[2]</strong></font>";
        }
    } else {
        $mensagem = "<font color='#FF0000'><strong>! Tente novamente.</strong></font>";
    }
}

$sqlIntegrantes = "SELECT i.* FROM evento_integrante AS ei
                        INNER JOIN integrante AS i on ei.integrante_id = i.idIntegrante
                        WHERE evento_id = '$idEvento'";

$integrantes = $con->query($sqlIntegrantes)->fetch_all(MYSQLI_ASSOC);

include '../perfil/includes/menu_culturaonline.php';
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <div class="form-group">
            <h4>Integrantes</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <input type="button" class="btn btn-theme btn-lg btn-block" value="Adicionar Integrante"
                       data-toggle='modal' data-target='#addIntegrante'>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><br></div>
        </div>

        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="table-responsive list_info">
                    <table class='table table-condensed'>
                        <thead>
                            <tr class='list_menu'>
                                <td>Nome</td>
                                <td>RG</td>
                                <td>CPF</td>
                                <td width='5%'></td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($integrantes != null):
                            foreach ($integrantes as $integrante): ?>
                                <tr>
                                    <td><?=$integrante['nome']?></td>
                                    <td><?=$integrante['rg']?></td>
                                    <td><?=$integrante['cpf']?></td>
                                    <td>
                                        <form action="?perfil=evento_culturaonline_integrantes" method="post">
                                            <input type="hidden" name="idIntegrante" id="idIntegrante" value="<?=$integrante['idIntegrante']?>">
                                            <input type="hidden" name="idIntegrante" id="idEvento" value="<?=$idEvento?>">
                                            <input type="submit" name="removerIntegrante" class="btn btn-sm btn-danger" value="Remover">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Nenhum Integrante Cadastrado</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addIntegrante" role="dialog" aria-labelledby="addIntegranteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="?perfil=evento_culturaonline_integrantes" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Adicionar Integrante?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nome">Nome*</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="rg">RG*</label>
                            <input type="text" name="rg" id="rg" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF*</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success" name="addIntegrante" id="confirm" value="Adicionar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>