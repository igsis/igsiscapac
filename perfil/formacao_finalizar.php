<?php

$con = bancoMysqli();
$idPf = $_SESSION['idPf'];
$pf = recuperaDados("pessoa_fisica","id",$idPf);

$obrigatorios = [
//Informacoes Iniciais
    'nome'                  =>  'Nome',
    'nomeArtistico'         =>  'Nome Artístico',
    'idTipoDocumento'       =>  'Tipo de Documento',
    'rg'                    =>  'Nº do Documento',
    'cpf'                   =>  'CPF',
    'telefone1'             =>  'Telefone',
    'email'                 =>  'E-Mail',
    'dataNascimento'        =>  'Data de Nascimento',
//Endereco
    'logradouro'            =>  'Endereço',
    'bairro'                =>  'Bairro',
    'cidade'                =>  'Cidade',
    'estado'                =>  'Estado',
    'cep'                   =>  'CEP',
    'numero'                =>  'Número',
//Informacoes Complementares
    'tipo_formacao_id'      =>  'Programa',
    'etnia_id'              =>  'Etnia',
    'grau_instrucao_id'     =>  'Grau de Instrução',
    'formacao_funcao_id'    =>  'Função',
    'codigoBanco'           =>  'Banco',
    'agencia'               =>  'Agência',
    'conta'                 =>  'Conta',
];

$erro = false;
$erroCampo = false;
$erroArquivo = false;
$campoVazio = [];

foreach ($pf as $campo => $valor)
{
    if (!(is_numeric($campo)))
    {
        if (array_key_exists($campo, $obrigatorios))
        {
            if (($valor == '') || ($valor == null) || ($valor == '0'))
            {
                array_push($campoVazio, $campo);
                $erro = true;
                $erroCampo = true;
            }
        }
    }
}

if (($pf['formacao_funcao_id'] != 3) && ($pf['formacao_funcao_id'] != 6))
{
    if ($pf['formacao_funcao_id'] != NULL) {
        $ids = ['144', '145', '146', '148', '149', '150', '152', '153', '154', '156', '157', '158'];

    } else {
        $ids = ['144', '145', '146', '148', '149', '150', '152', '153', '154', '155', '156', '157', '158'];
    }
    $coordenador = "AND `id` NOT IN (".implode(', ', $ids).")";
}
else
{
    $ids = ['144', '145', '146', '148', '149', '150', '152', '153', '154', '155', '156', '157', '158'];
    $coordenador = "AND `id` NOT IN (".implode(', ', $ids).")";
}

$sql_arquivos = "SELECT * FROM `upload_lista_documento` WHERE `idTipoUpload` = '6' $coordenador AND `publicado` = '1'";
$arquivos = mysqli_query($con, $sql_arquivos);
$arquivoVazio = [];

while ($arquivo = mysqli_fetch_assoc($arquivos))
{
    if (arquivosObrigatorios(6, $idPf, $arquivo['id']))
    {
        if ($arquivo['documento'] != "DRT") {
            array_push($arquivoVazio, $arquivo['documento']);
            $erro = true;
            $erroArquivo = true;
        }
    }
}

$estadoCivil = recuperaDados('estado_civil', 'id', $pf['idEstadoCivil']);
$etnia = recuperaDados('etnias', 'id', $pf['etnia_id']);
$grauInstrucao = recuperaDados('grau_instrucoes', 'id', $pf['grau_instrucao_id']);
$programa = recuperaDados('tipo_formacao', 'id', $pf['tipo_formacao_id']);
$documento = recuperaDados('tipo_documento', 'id', $pf['idTipoDocumento']);
$linguagem = recuperaDados('formacao_linguagem', 'id', $pf['formacao_linguagem_id']);

$sql_funcao = "SELECT ff.funcao FROM formacao_funcoes AS ff
                INNER JOIN pessoa_fisica AS pf ON ff.id = pf.formacao_funcao_id
                INNER JOIN pessoa_fisica AS p ON ff.tipo_formacao_id = p.tipo_formacao_id
                WHERE pf.id = '$idPf'";
$funcao = mysqli_fetch_array(mysqli_query($con, $sql_funcao));

function recuperaBanco($campoY)
{
    $banco = recuperaDados("banco","id",$campoY);
    $nomeBanco = $banco['banco'];
    return $nomeBanco;
}

function listaArquivoCamposMultiplos1($idPessoa, $tipoPessoa = 6)
{
    $con = bancoMysqli();
    $sql = "SELECT *
				FROM upload_lista_documento as list
				INNER JOIN upload_arquivo as arq ON arq.idUploadListaDocumento = list.id
				WHERE arq.idPessoa = '$idPessoa'
				AND arq.idTipoPessoa = '$tipoPessoa'
				AND arq.publicado = '1'
				ORDER BY documento";

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

?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_formacao.php'; ?>
        <div class="form-group">
            <h4>Finalizar</h4>
            <?php
            if ($erro) {
                if ($erroCampo) {
            ?>
                    <p>
                        <strong>
                                <span style="color: red;">
                                    Alguns campos obrigatórios não foram preenchidos.<br/>
                                    Por favor revise seu cadastro
                                </span>
                        </strong>
                    </p>
                    <?php
                    foreach ($campoVazio as $campo) {
                    ?>
                        <div class="alert alert-danger ">
                            Campo <strong><?= $obrigatorios[$campo] ?></strong> não preenchido
                        </div>

                <?php
                    }
                }
                if ($erroArquivo) {
                ?>
                    <p>
                        <strong>
                                <span style="color: red;">
                                    Alguns arquivos obrigatórios não foram enviados.<br/>
                                    Por favor revise seu cadastro
                                </span>
                        </strong>
                    </p>
                <?php
                    foreach ($arquivoVazio as $arquivo) {
                ?>
                    <div class="alert alert-danger ">
                        Arquivo <strong><?= $arquivo ?></strong> não enviado
                    </div>
                <?php
                    }
                }
            } else { ?>
            <p>
                <strong>
                            <span style="color: green;">
                                Todos os campos obrigatórios foram preenchidos corretamente.<br/>
                                Seu cadastro de Pessoa Física foi concluído com sucesso!<br>
                                Anote seu código de cadastro, ele é o seu comprovante de inscrição!
                            </span>
                </strong>
            </p>
            <br>

            <div class="alert alert-success ">
                Seu Código de Cadastro é <strong><?= $pf['id'] ?></strong>
            </div>
            <?php } ?>

            <div class="container">
                <div class = "page-header"> <h5>Informações Pessoais </h5><br></div>
                <div class="well">
                    <p align="justify"><strong>Nome:</strong> <?= $pf['nome']; ?></p>
                    <p align="justify"><strong>Nome artístico:</strong> <?= $pf['nomeArtistico']; ?></p>
                    <p align="justify"><strong>Data de Nascimento:</strong> <?= date_format(date_create($pf['dataNascimento']), 'd/m/Y'); ?></p>
                    <p align="justify"><strong><?= $documento['tipoDocumento'] ?>:</strong> <?= $pf['rg']; ?><p>
                    <p align="justify"><strong>CPF:</strong> <?= $pf['cpf']; ?><p>
                    <p align="justify"><strong>CCM:</strong> <?= $pf['ccm']; ?><p>
                    <p align="justify"><strong>Email:</strong> <?= $pf['email']; ?><p>
                    <p align="justify"><strong>Telefone:</strong> <?= $pf['telefone1']; ?><p>
                    <p align="justify"><strong>Estado Civil:</strong> <?= $estadoCivil['estadoCivil']; ?><p>
                    <p align="justify"><strong>Nacionalidade:</strong> <?= $pf['nacionalidade']; ?><p>
                    <p align="justify"><strong>PIS/PASEP/NIT:</strong> <?= $pf['pis']; ?><p>
                    <p align="justify"><strong>Programa Selecionado:</strong> <?= $programa['descricao']; ?><p>
                </div>


                <div class = "page-header"><h5>Endereço: </h5><br></div>
                <div class="well">
                    <p align="justify"><strong>CEP:</strong> <?php echo $pf['cep']; ?></p>
                    <p align="justify"><strong>Logradouro:</strong> <?php echo $pf['logradouro']; ?></p>
                    <p align="justify"><strong>Número:</strong> <?php echo $pf['numero']; ?></p>
                    <p align="justify"><strong>Complemento:</strong> <?php echo $pf['complemento']; ?></p>
                    <p align="justify"><strong>Bairro:</strong> <?php echo $pf['bairro']; ?></p>
                    <p align="justify"><strong>Cidade:</strong> <?php echo $pf['cidade']; ?></p>
                    <p align="justify"><strong>Estado:</strong> <?php echo $pf['estado']; ?></p>
                </div>


                <div class = "page-header"><h5>Informações Complementares: </h5><br></div>
                <div class="well">
                    <p align="justify"><strong>DRT:</strong> <?php echo $pf['drt']; ?></p>
                    <p align="justify"><strong>Etnia:</strong> <?= $etnia['etnia']; ?><p>
                    <p align="justify"><strong>Grau de Instrução:</strong> <?= $grauInstrucao['grau_instrucao']; ?><p>
                    <p align="justify"><strong>Linguagem:</strong> <?= $linguagem['linguagem']; ?><p>
                    <p align="justify"><strong>Função:</strong> <?= $funcao[0]; ?><p>
                    <p align="justify"><strong>Banco:</strong> <?php echo recuperaBanco ($pf['codigoBanco']); ?></p>
                    <p align="justify"><strong>Agência:</strong> <?php echo $pf['agencia']; ?></p>
                    <p align="justify"><strong>Conta:</strong> <?php echo $pf['conta']; ?></p>
                </div>

            <div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Física</h6>
                <?php listaArquivoCamposMultiplos1($pf['id']); ?>
            </div>
            </div>
</section>