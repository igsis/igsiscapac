<?php
$con = bancoMysqli();

$url = 'http://'.$_SERVER['HTTP_HOST'].'/igsiscapac/funcoes/api_linguagens.php';

$idPj = $_SESSION['idPj'];
$evento = isset($_SESSION['idEvento']) ? $_SESSION['idEvento'] : null;

$idCampo = 160;
$pf = recuperaDados("pessoa_juridica","id",$idPj);
$tipoPessoa = 5;

$consulta = "SELECT * FROM `oficina_dados` WHERE `tipoPessoa` = '$tipoPessoa' AND `idPessoa` = '$idPj' AND `publicado` = '1'";
$queryDados = $con->query($consulta);
$cadastra = $queryDados->num_rows;

if ($cadastra)
{
    $dados = $queryDados->fetch_assoc();
    $idDados = $dados['id'];
}

$post = ($cadastra) ? "atualizaDados" : "cadastraDados";

if(isset($_POST['cadastraDados']))
{
    $idPj = $_POST['cadastraDados'];
    $nivel = $_POST['nivel'];
    $linguagem = $_POST['linguagem'];
    $sublinguagem = $_POST['sublinguagem'];

    $sql_insere_dados = "INSERT INTO `oficina_dados` (`tipoPessoa`, `idPessoa`, `oficina_linguagem_id`, `oficina_sublinguagem_id`, `oficina_nivel_id`)
                          VALUES ('$tipoPessoa', '$idPj', '$linguagem', '$sublinguagem', '$nivel')";

    if (mysqli_query($con,$sql_insere_dados))
    {
        $mensagem = "<font color='#01DF3A'><strong>Cadastrado com sucesso!</strong></font>";
        gravarLog($sql_insere_dados);
        $idDados = $con->insert_id;
        $dados = recuperaDados('oficina_dados', 'id', $idDados);
        $post = "atualizaDados";
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao Cadastrar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST["atualizaDados"]))
{
    $idPj = $_POST['atualizaDados'];
    $nivel = $_POST['nivel'];
    $linguagem = $_POST['linguagem'];

    $sql_atualiza_dados = "UPDATE `oficina_dados` SET
                           `oficina_linguagem_id` = '$linguagem',
                           `oficina_nivel_id` = '$nivel'
                           WHERE `id` = '$idDados'";

    if (mysqli_query($con,$sql_atualiza_dados))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_atualiza_dados);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao Atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST["enviar"]))
{
    $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
    $query_arquivos = mysqli_query($con,$sql_arquivos);
    while($arq = mysqli_fetch_array($query_arquivos))
    {
        $y = $arq['id'];
        $x = $arq['sigla'];
        $nome_arquivo = $_FILES['arquivo']['name'][$x];
        $f_size = $_FILES['arquivo']['size'][$x];
        $ext = array("PDF","pdf"); //Extensões permitidas

        if($f_size > 5242880) // 5MB em bytes
        {
            $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
        }
        else
        {
            if($nome_arquivo != "")
            {
                $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                $hoje = date("Y-m-d H:i:s");
                $dir = '../uploadsdocs/'; //Diretório para uploads
                $allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
                $ext = strtolower(substr($nome_arquivo,-4));

                if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas/
                {
                    if(move_uploaded_file($nome_temporario, $dir.$new_name))
                    {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPj', '$idCampo', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con,$sql_insere_arquivo);
                        if($query)
                        {
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                            gravarLog($sql_insere_arquivo);
                            echo '<script>window.location = "?perfil=oficineiro_pj_informacoes_complementares"</script>';
                        }
                        else
                        {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco!</strong></font>";
                        }
                    }
                    else
                    {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
                    }
                }
                else
                {
                    $mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
                }
            }
        }
    }
}

if(isset($_POST['apagar']))
{
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE id = '$idArquivo'";
    if(mysqli_query($con,$sql_apagar_arquivo))
    {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo! Tente novamente.</strong></font>";
    }
}

$pj = recuperaDados("pessoa_juridica","id",$idPj);
$evento_pj = recuperaDados("evento","id",$evento);

if ($cadastra)
{
    $dados = recuperaDados('oficina_dados', 'id', $idDados);
}else{
  $dados['oficina_sublinguagem_id'] = 0;
}
?>

<section id="contact" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_oficinas.php'; ?>
        <div class="form-group">
            <h3>INFORMAÇÕES COMPLEMENTARES</h3>
            <p><b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_informacoes_complementares" method="post">

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4"><strong>Nível:</strong><br/>
                            <select class="form-control" name="nivel" id="nivel" required>
                                <option value="">Selecione...</option>
                                <?php geraOpcao('oficina_niveis', $dados['oficina_nivel_id']) ?>
                            </select>
                        </div>
                        <div class="col-md-4"><strong>Linguagem:</strong><br/>
                            <select class="form-control" name="linguagem" id="linguagem" required>
                                <option value="">Selecione...</option>
                                <?php geraOpcao('oficina_linguagens', $dados['oficina_linguagem_id']) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-8"><strong>Sub Linguagem:</strong><br/>
                        <select class="form-control" name="sublinguagem" id="sublinguagem" required>
                          <!-- Populando por js -->
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="<?= $post ?>" value="<?php echo $idPj ?>">
                            <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
                        </div>
                    </div>
                </form>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                </div>

                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
                            <?php listaArquivoCamposMultiplos($idPj,$tipoPessoa,$idCampo,"oficineiro_pj_informacoes_complementares",3); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <div class = "center">
                            <form method="POST" action="?perfil=oficineiro_pj_informacoes_complementares" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td width="45%"><td>
                                    </tr>
                                    <?php
                                    if(verificaArquivosExistentesPF($idPj,'160', $tipoPessoa)){
                                        echo '<div class="alert alert-success">O arquivo Curriculo foi enviado.</div> ';
                                    }
                                    else{
                                        $sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id = '$idCampo'";
                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
                                        while($arq = mysqli_fetch_array($query_arquivos))
                                        {
                                            ?>
                                            <tr>
                                                <td><label><?php echo $arq['documento']?></label></td>
                                                <td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table><br>
                                <input type="hidden" name="idPessoa" value="<?php echo $idjf; ?>"  />
                                <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
                                <input type="hidden" name="enviar" value="1"  />
                                <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar'>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><hr/><br/></div>
                </div>

                <!-- Confirmação de Exclusão -->
                <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Excluir Arquivo?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Confirma?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="confirm">Apagar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Confirmação de Exclusão -->

                <!-- Botão para Voltar e Prosseguir -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_endereco" method="post">
                            <input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                        </form>
                    </div>
                    <div class="col-md-offset-4 col-md-2">
                        <form class="form-horizontal" role="form" action="?perfil=oficineiro_pj_representante" method="post">
                            <input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
   const url = `<?=$url?>`;

   let linguagem = document.querySelector("#linguagem");
      console.log(linguagem.value);


   if(linguagem.value != ''){

     let sublinguagem_id = <?=$dados['oficina_sublinguagem_id']?>

     getSublinguagem(linguagem.value, sublinguagem_id)
   }
    linguagem.addEventListener('change', async e => {
      let idLinguagem = $('#linguagem option:checked').val();

      fetch(`${url}?linguagem_id=${idLinguagem}`)
        .then(response => response.json())
        .then(sublinguagens => {
            $('#sublinguagem option').remove();
            $('#sublinguagem').append('<option value="">Selecione... </option>');

            for (const sublinguagem of sublinguagens) {
                $('#sublinguagem').append(`<option value='${sublinguagem.id}'>${sublinguagem.sublinguagem}</option>`).focus();;
            }
        })
    })

    function getSublinguagem(idLinguagem, selectedId){
      fetch(`${url}?linguagem_id=${idLinguagem}`)
      .then(response => response.json())
      .then(sublinguagens => {
        $('#sublinguagem option').remove();

        for (const sublinguagem of sublinguagens) {
          if(selectedId == sublinguagem.id){
            $('#sublinguagem').append(`<option value='${sublinguagem.id}' select>${sublinguagem.sublinguagem}</option>`).focus();;
          }else{
            $('#sublinguagem').append(`<option value='${sublinguagem.id}'>${sublinguagem.sublinguagem}</option>`).focus();;
          }
        }
      })
    }

 </script>
