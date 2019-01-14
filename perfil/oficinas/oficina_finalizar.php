<?php
$idEvento = $_SESSION['idEvento'];
$evento = recuperaDados("evento","id",$idEvento);
$tipoEvento = recuperaDados("tipo_evento","id",$evento['idTipoEvento']);
$faixaEtaria = recuperaDados("faixa_etaria","id",$evento['idFaixaEtaria']);
$tipoPessoa = recuperaDados("tipo_pessoa","id",$evento['idTipoPessoa']);
$pessoaJuridica = recuperaDados("pessoa_juridica","id",$evento['idPj']);
$representante1 = recuperaDados("representante_legal","id",$pessoaJuridica['idRepresentanteLegal1']);
$pessoaFisica = recuperaDados("pessoa_fisica","id",$evento['idPf']);
$bool = false;
$mensagem = "";
function recuperaBanco($campoY)
{
    $banco = recuperaDados("banco","id",$campoY);
    $nomeBanco = $banco['banco'];
    return $nomeBanco;
}
function listaArquivoCamposMultiplos1($idPessoa,$pf)
{
    $con = bancoMysqli();
    switch ($pf) {
        case 1: //todos os arquivos de pf
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '1'
				AND arq.publicado = '1'
				ORDER BY documento";
            break;
        case 2: //todos os arquivos de pj
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '2'
				AND arq.publicado = '1'
				AND list.id NOT IN (20,21,103,104)
				ORDER BY documento";
            break;
        case 3: //representante_legal1
            $arq1 = "AND (list.id = '20' OR ";
            $arq2 = "list.id = '21'OR ";
            $arq3 = "list.id = '103' OR ";
            $arq4 = "list.id = '104')";
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '2'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
            break;
        case 4: //grupo
            $arq1 = "AND (list.id = '99' OR ";
            $arq2 = "list.id = '100' OR";
            $arq3 = "list.id = '101' OR";
            $arq4 = "list.id = '102')";
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '3'
				$arq1 $arq2 $arq3 $arq4
				AND arq.publicado = '1'";
            break;
        case 5: //evento
            $arq1 = "AND (list.id = '23' OR ";
            $arq2 = "list.id = '65' OR";
            $arq3 = "list.id = '78' OR";
            $arq4 = "list.id = '96' OR";
            $arq5 = "list.id = '97' OR";
            $arq6 = "list.id = '98' OR";
            $arq7 = "list.id = '105' OR";
            $arq8 = "list.id = '108')";
            $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '3'
				$arq1 $arq2 $arq3 $arq4 $arq5 $arq6 $arq7 $arq8
				AND arq.publicado = '1'";
            break;
        default:
            break;
    }
    $query = mysqli_query($con,$sql);
    $linhas = mysqli_num_rows($query);
    if ($linhas > 0)
    {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
        while($arquivo = mysqli_fetch_array($query))
        {
            echo "<tr>";
            echo "<td class='list_description' width='5%'>".$arquivo['documento']."</td>";
            echo "<td class='list_description'><a href='../../igsiscapac/uploadsdocs/".$arquivo['arquivo']."' target='_blank'>".$arquivo['arquivo']."</td>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    }
    else
    {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}
function listaArquivosComProd($idEvento)
{
    //lista arquivos de determinado evento
    $con = bancoMysqli();
    $sql = "SELECT * FROM upload_arquivo_com_prod WHERE idEvento = '$idEvento' AND publicado = '1'";
    $query = mysqli_query($con,$sql);
    echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
    while($campo = mysqli_fetch_array($query))
    {
        echo "<tr>";
        echo "<td class='list_description'><a href='../uploads/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
        echo "</tr>";
    }
    echo "
		</tbody>
		</table>";
}
$i = 0;
if($evento['nomeEvento'] == NULL)
{
    $mensagem = "<a href='index.php?perfil=oficina_edicao'>Nome do evento</a><br/>";
    $i = 1;
}
if($evento['idTipoEvento'] == NULL)
{
    $mensagem = $mensagem."<a href='index.php?perfil=oficina_edicao'>Tipo de evento</a><br/>";
    $i = 1;
}
if($evento['idFaixaEtaria'] == NULL OR $evento['idFaixaEtaria'] == 0)
{
    $mensagem = $mensagem."<a href='index.php?perfil=oficina_edicao'>Faixa Etária</a><br/>";
    $i = 1;
}
if($evento['sinopse'] == NULL)
{
    $mensagem = $mensagem."<a href='index.php?perfil=oficina_edicao'>Sinopse</a><br/>";
    $i = 1;
}

$idTipoPessoa = $evento['idTipoPessoa'];

if($evento['contratacao'] != 3)
{

    if($idTipoPessoa == 5)
    {
        $pj = recuperaDados("pessoa_juridica","id",$evento['idPj']);
        if($pj['razaoSocial'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pj_informacoes_iniciais'>Razão Social</a><br/>";
            $i = 1;
        }
        if($pj['cnpj'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pj_informacoes_iniciais'>CNPJ</a><br/>";
            $i = 1;
        }
        if($pj['telefone1'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pj_informacoes_iniciais'>Celular da empresa</a><br/>";
            $i = 1;
        }
        if($pj['email'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pj_informacoes_iniciais'>E-mail da empresa</a><br/>";
            $i = 1;
        }
        if($pj['cep'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pj_endereco'>CEP da empresa</a><br/>";
            $i = 1;
        }
        if($pj['numero'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pj_endereco'>Número do endereço da empresa</a><br/>";
            $i = 1;
        }
        if($pj['idRepresentanteLegal1'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pj_representante'>Representante legal</a><br/>";
            $i = 1;
        }

    }
    elseif ($tipoPessoa = 4)
    {
        # Pessoa física
        $pf = recuperaDados("pessoa_fisica","id",$evento['idPf']);
        if($pf['nome'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_informacoes_iniciais'>Nome do artista</a><br/>";
            $i = 1;
        }
        if($pf['nomeArtistico'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_informacoes_iniciais'>Nome Artístico</a><br/>";
            $i = 1;
        }
        if($pf['rg'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_informacoes_iniciais'>RG do artista</a><br/>";
            $i = 1;
        }
        if($pf['cpf'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_informacoes_iniciais'>CPF do artista</a><br/>";
            $i = 1;
        }
        if($pf['telefone1'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_informacoes_iniciais'>Telefone do artista</a><br/>";
            $i = 1;
        }
        if($pf['email'] == NULL)
        {
            $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_informacoes_iniciais'>E-mail do artista</a><br/>";
            $i = 1;
        }
        if($tipoPessoa == 4)
        {
            if($pf['cep'] == NULL)
            {
                $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_endereco'>CEP do artista</a><br/>";
                $i = 1;
            }
            if($pf['numero'] == NULL)
            {
                $mensagem = $mensagem."<a href='index.php?perfil=oficineiro_pf_endereco'>Número do endereço do artista</a><br/>";
                $i = 1;
            }
        }
    }
}
if(isset($_POST['enviar']))
{
    $sql_envia = "UPDATE `evento` SET `publicado`= 2 WHERE `id` = '$idEvento'";
    $con = bancoMysqli();
    if(mysqli_query($con,$sql_envia))
    {
        $mensagem = "<h4><font color='#01DF3A'>Enviado com sucesso! Entre em contato com o programador de sua oficina e informe o código do CAPAC: </font><font color='#FF0000'>".$idEvento."</font></h4>";
        gravarLog($sql_envia);
        $bool = true;
    }
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/oficina_menu_evento.php'; ?>
        <div class="form-group">
            <h4>Finalizar</h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <?php
                        if($i == 0)
                        {
                            ?>
                            <p><strong><font color='#01DF3A'>Não há pendências de preenchimento de campos.</font></strong></p>
                            <?php
                        }
                        else
                        {
                            ?>
                            <p><strong><font color="red">O(s) seguinte(s) campo(s) obrigatório(s) não foram preenchidos:</font></strong></p>
                            <?php
                        }
                        ?>
                        <p align="center">
                            <?php
                            if(isset($mensagem)){
                                echo $mensagem;
                            };
                            ?></p>
                    </div>
                </div>

                <!-- Início de Detalhes -->
                <div class="left">
                    <p align="justify"><br><br><br><br><br><br><strong>Tipo de evento:</strong> <?php echo $tipoEvento['tipoEvento'] ?></p>
                    <p align="justify"><strong>Nome da Oficina:</strong> <?php echo $evento['nomeEvento'] ?></p>
                    <p align="justify"><strong>Faixa Etária:</strong> <?php echo $faixaEtaria['faixaEtaria'] ?></p>
                    <p align="justify"><strong>Sinopse:</strong> <?php echo $evento['sinopse'] ?></p>
                    <p align="justify"><strong>Links:</strong> <?php echo $evento['link'] ?></p>
                    <p align="justify"><strong>Data Cadastro:</strong> <?php echo exibirDataHoraBr($evento['dataCadastro']) ?></p>
                    <br/>

                    <?php
                    if ($evento['contratacao'] != 3)
                    {
                        ?>
                        <h5>Informações de Contratação</h5>
                        <p align="justify"><strong>Tipo:</strong> <?php echo $tipoPessoa['tipoPessoa'] ?></p>
                        <br/>
                        <?php
                        if($evento['idTipoPessoa'] == 5)
                        {
                            ?>
                            <p align="justify"><strong>Razão Social:</strong> <?php echo $pessoaJuridica['razaoSocial'] ?></p>
                            <p align="justify"><strong>CNPJ:</strong> <?php echo $pessoaJuridica['cnpj'] ?></p>
                            <p align="justify"><strong>CCM:</strong> <?php echo $pessoaJuridica['ccm'] ?></p>
                            <p align="justify"><strong>CEP:</strong> <?php echo $pessoaJuridica['cep'] ?></p>
                            <p align="justify"><strong>Número:</strong> <?php echo $pessoaJuridica['numero'] ?></p>
                            <p align="justify"><strong>Complemento:</strong> <?php echo $pessoaJuridica['complemento'] ?></p>
                            <p align="justify"><strong>Telefone:</strong> <?php echo $pessoaJuridica['telefone1']." | ".$pessoaJuridica['telefone2']." | ".$pessoaJuridica['telefone3'] ?></p>
                            <p align="justify"><strong>E-mail:</strong> <?php echo $pessoaJuridica['email'] ?></p>
                            <br/>
                            <p align="justify"><strong>REPRESENTANTE LEGAL #1</strong></p>
                            <p align="justify"><strong>Nome:</strong> <?php echo $representante1['nome'] ?></p>
                            <p align="justify"><strong>RG/RNE/PASSAPORTE:</strong> <?php echo $representante1['rg'] ?></p>
                            <p align="justify"><strong>CPF:</strong> <?php echo $representante1['cpf'] ?></p>
                            <br/>

                            <p align="justify"><strong>Banco:</strong> <?php echo recuperaBanco($pessoaJuridica['codigoBanco']) ?></p>
                            <p align="justify"><strong>Agência:</strong> <?php echo $pessoaJuridica['agencia'] ?></p>
                            <p align="justify"><strong>Conta:</strong> <?php echo $pessoaJuridica['conta'] ?></p>
                            <p align="justify"><strong>Data da última atualização do cadastro:</strong> <?php echo exibirDataHoraBr($pessoaJuridica['dataAtualizacao']) ?></p>
                            <br/>
                            <?php
                        }
                        ?>

                        <p align="justify"><strong>OFICINEIRO</strong></p>
                        <p align="justify"><strong>Nome:</strong> <?php echo $pessoaFisica['nome'] ?></p>
                        <p align="justify"><strong>Nome Artístico:</strong> <?php echo $pessoaFisica['nomeArtistico'] ?></p>
                        <p align="justify"><strong>RG/RNE/PASSAPORTE:</strong> <?php echo $pessoaFisica['rg'] ?></p>
                        <p align="justify"><strong>CPF:</strong> <?php echo $pessoaFisica['cpf'] ?></p>
                        <p align="justify"><strong>Telefone:</strong> <?php echo $pessoaFisica['telefone1']." | ".$pessoaFisica['telefone2']." | ".$pessoaFisica['telefone3'] ?></p>
                        <p align="justify"><strong>E-mail:</strong> <?php echo $pessoaFisica['email'] ?></p>
                        <p align="justify"><strong>DRT:</strong> <?php echo $pessoaFisica['drt'] ?></p>
                        <?php
                        if($evento['idTipoPessoa'] == 4)
                        {
                            ?>
                            <p align="justify"><strong>Data de Nascimento:</strong> <?php echo exibirDataBr($pessoaFisica['dataNascimento']) ?></p>
                            <p align="justify"><strong>Nacionalidade:</strong> <?php echo $pessoaFisica['nacionalidade'] ?></p>
                            <p align="justify"><strong>PIS / PASEP / NIT:</strong> <?php echo $pessoaFisica['pis'] ?></p>
                            <p align="justify"><strong>CEP:</strong> <?php echo $pessoaFisica['cep'] ?></p>
                            <p align="justify"><strong>Número:</strong> <?php echo $pessoaFisica['numero'] ?></p>
                            <p align="justify"><strong>Complemento:</strong> <?php echo $pessoaFisica['complemento'] ?></p>
                            <p align="justify"><strong>Banco:</strong> <?php echo recuperaBanco($pessoaFisica['codigoBanco']) ?></p>
                            <p align="justify"><strong>Agência:</strong> <?php echo $pessoaFisica['agencia'] ?></p>
                            <p align="justify"><strong>Conta:</strong> <?php echo $pessoaFisica['conta'] ?></p>
                            <p align="justify"><strong>Data da última atualização do cadastro:</strong> <?php echo exibirDataHoraBr($pessoaFisica['dataAtualizacao']) ?></p>
                            <?php
                        }
                        ?>
                        <br/>

                        <?php
                    }
                    ?>

                    <div class="table-responsive list_info"><h6>Arquivo(s) para Comunicação/Produção</h6>
                        <?php listaArquivosComProd($idEvento); ?>
                    </div>
                </div>
                <!-- Fim detalhes do evento -->
                <!-- Botão para Voltar -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_arquivos_com_prod" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block">
                        </form>
                    </div>
                    <!-- FIM Botão para Voltar -->
                    <div class="col-md-offset-4 col-md-2">
                        <?php
                        if($i == 0)
                        {
                            if($bool == false){
                                ?>
                                <form class="form-horizontal" role="form" action="?perfil=oficinas/oficina_finalizar" method="post">
                                    <input type="submit" name="enviar" value="ENVIAR" class="btn btn-theme btn-lg btn-block">
                                </form>
                                <?php
                            } else {} }
                        else
                        {
                            ?>
                            <br/><br/>
                            <h6><font color='#FF0000'>Para habilitar o botão de envio, preencha todos os campos obrigatórios.</font></h6>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>