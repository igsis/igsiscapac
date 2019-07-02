<?php
$con = bancoMysqli();
$idUser = $_SESSION['idUser'];

$cadastro_basico = recuperaDados('usuario', 'id', $idUser);

if(isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $nome = $_POST['nome'];
    $nomeSocial = $_POST['nomeSocial'] ?? NULL;
    $dataNascimento = exibirDataMysql($_POST['dataNascimento']);
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['CEP'];
    $logradouro = $_POST['Endereco'];
    $numero = $_POST['Numero'];
    $complemento = $_POST['Complemento'];
    $bairro = $_POST['Bairro'];
    $cidade = $_POST['Cidade'];
    $estado = $_POST['Estado'];
    $email = $_POST['email'];

    if(isset($_POST['cadastrar'])){
        $sql = "INSERT INTO pessoa_fisica (nome, nomeArtistico, rg, cpf, dataNascimento, bairro, cidade, estado, cep, numero, complemento, telefone1, email, jovem_monitor, idUsuario)
                VALUES ('$nome','$nomeSocial', '$rg', '$cpf', '$dataNascimento','$bairro', '$cidade', '$estado', '$cep', '$numero', '$complemento', '$telefone', '$email', 1, '$idUser')";
    }else{
        $sql = "UPDATE pessoa_fisica SET 
                nome = '$nome',
                nome_social = '$nomeSocial', 
                data_nascimento = '$dataNascimento', 
                rg = '$rg', 
                cpf = '$cpf', 
                telefone = '$telefone', 
                cep = '$cep', 
                logradouro = '$logradouro', 
                numero = '$numero', 
                complemento = '$complemento', 
                bairro = '$bairro', 
                cidade = '$cidade', 
                estado = '$estado'
                WHERE user_id = '$idUser'";
    }

    if(mysqli_query($con, $sql)){
        $mensagem = "<font color='#01DF3A'><strong>Informações salvas com sucesso!</strong></font>";
        gravarLog($sql);
    }else{
        echo $sql;
        $mensagem = "<font color='#FF0000'><strong>Erro ao salvar as informações! Tente novamente.</strong></font>";
    }
}

$jovem_monitor = recuperaDados('pessoa_fisica', 'id', $idUser);
$idJovemMonitor = $jovem_monitor['id'] ?? null;
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#cpf").mask("000.000.000-00");
    });
</script>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_jovem_monitor.php'; ?>
        <div class="form-group">
            <h3>Jovem monitor</h3>
            <h4>
                <?=
                    (isset($mensagem)) ? $mensagem : NULL
                ?>
            </h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <form method="POST" action="?perfil=jovem_monitor/cadastro" class="form-horizontal"
                              role="form">
                            <div class="form-group">
                                <label for="nome">Nome Completo </label>
                                <input type="text" name="nome" class="form-control" id="nome" readonly
                                       value="<?= $cadastro_basico['nome'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Nome Social</label>
                                <input type="text" name="nomeSocial" class="form-control" id="nomeSocial"
                                       value="<?= $jovem_monitor['nome_social'] ?>" >
                            </div>

                            <div class="form-group">
                                <label>Data Nascimento </label>
                                <input type="text" class="form-control" name="dataNascimento" id="datepicker01"
                                       placeholder="Data de Nascimento" required
                                       value="<?= ($idJovemMonitor == null) ? "" : exibirDataBr($jovem_monitor['data_nascimento']) ?>">
                            </div>

                            <div class="form-group">
                                <label>RG </label>
                                <input type="text" name="rg" class="form-control" id="rg"
                                       value="<?= $jovem_monitor['rg'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label>CPF </label>
                                <input type="text" name="cpf" class="form-control" id="cpf"
                                       value="<?= $jovem_monitor['cpf'] ?>" data-mask="000.000.000-00" required>
                            </div>

                            <div class="form-group">
                                <label>Email </label>
                                <input type="text" name="email" class="form-control" id="email"
                                       value="<?= $cadastro_basico['email'] ?>" data-mask="000.000.000-00" required
                                       readonly>
                            </div>

                            <div class="form-group">
                                <label>Telefone </label>
                                <input type="text" class="form-control" name="telefone" id="telefone"
                                       onkeyup="mascara( this, mtel );" maxlength="15"
                                       placeholder="Exemplo: (11) 98765-4321" required
                                       value="<?= $jovem_monitor['telefone'] ?>">
                            </div>

                            <div class="form-group">
                                <strong>CEP *:</strong>
                                <input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP"
                                       value="<?= $jovem_monitor['cep'] ?>">
                            </div>

                            <div class="form-group">
                                <strong>Endereço:</strong>
                                <input type="text" readonly class="form-control" id="Endereco" name="Endereco"
                                       placeholder="Endereço" value="<?= $jovem_monitor['logradouro'] ?>" required>
                            </div>

                            <div class="form-group">
                                <strong>Número *:</strong>
                                <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero"
                                       maxlength="11" value="<?= $jovem_monitor['numero'] ?>" required>
                            </div>
                            <div class="form-group">
                                <strong>Complemento:</strong>
                                <input type="text" class="form-control" id="Complemento" name="Complemento"
                                       placeholder="Complemento" maxlength="20"
                                       value="<?= $jovem_monitor['complemento'] ?>">
                            </div>

                            <div class="form-group">
                                <strong>Bairro:</strong>
                                <input type="text" readonly class="form-control" id="Bairro" name="Bairro"
                                       placeholder="Bairro" value="<?= $jovem_monitor['bairro'] ?>">
                            </div>

                            <div class="form-group">
                                <strong>Cidade:</strong>
                                <input type="text" readonly class="form-control" id="Cidade" name="Cidade"
                                       placeholder="Cidade" value="<?= $jovem_monitor['cidade'] ?>">
                            </div>
                            <div class="form-group">
                                <strong>Estado:</strong>
                                <input type="text" readonly class="form-control" id="Estado" name="Estado"
                                       placeholder="Estado" value="<?= $jovem_monitor['estado'] ?>">
                            </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" class="btn btn-theme btn-lg btn-block"
                                   name="<?= ($idJovemMonitor == null) ? "cadastrar" : "editar" ?>" value="Gravar">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

