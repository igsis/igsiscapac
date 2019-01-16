<?php
/**
 * Pagina exclusiva para transpor os dados da tabela oficina_dados para tabela evento.
 * User: Diego
 */

$con = bancoMysqli();

if(isset($_POST['executar']))
{
    $linhasDados = $con->query("SELECT * FROM `oficina_dados` WHERE `nomeOficina` IS NOT NULL AND `publicado` = '1'");

    foreach ($linhasDados as $dado)
    {
        $tipoEvento = 4;
        $idDado = $dado['id'];
        $tipoPessoa = $dado['tipoPessoa'];
        $idPessoa = $dado['idPessoa'];
        $nomeEvento = addslashes($dado['nomeOficina']);
        $sinopse = addslashes($dado['sinopseOficina']);
        $dataCadastro = date('YmdHis');

        if ($tipoPessoa == 4)
        {
            $pf = recuperaDados('pessoa_fisica', 'id', $idPessoa);
            $idUser = $pf['idUsuario'];
            $idPf = $idPessoa;
            $idPj = 0;
        }
        else
        {
            $pj = recuperaDados('pessoa_juridica', 'id', $idPessoa);
            $idUser = $pj['idUsuario'];
            $idPj = $idPessoa;
            $idPf = 0;
        }

        $sql_insere = "INSERT INTO `evento`(`idTipoEvento`, `nomeEvento`, `sinopse`, `idTipoPessoa`, `idPj`, `idPf`, `dataCadastro`, `publicado`, `contratacao`, `idUsuario`) VALUES ('$tipoEvento', '$nomeEvento', '$sinopse', '$tipoPessoa', '$idPj', '$idPf', '$dataCadastro', '1', '1', '$idUser')";

        $evento = $con->query($sql_insere);
        if ($evento)
        {
            $idOficina = $con->insert_id;

            $sql_dados = "UPDATE `oficina_dados` SET `idOficina` = '$idOficina' WHERE `id` = '$idDado'";
            $query = $con->query($sql_dados);
            if ($query)
            {
                gravarLog($sql_dados);
                $mensagem = "FUNÇÃO EXECUTADA COM SUCESSO";
            }
        }
    }

}
?>

<section id="list_items" class="home-section bg-white">
    <div class="container">
        <div class="form-group">
            <h4>Função Transpor Dados</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=importar_dados_para_evento" class="form-horizontal" role="form">
                    <hr/>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="executar" class="btn btn-theme btn-lg btn-block" value="Executar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
