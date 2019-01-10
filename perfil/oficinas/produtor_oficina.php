<?php

$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$idEvento= $_SESSION['idEvento'];

$evento = recuperaDados("evento","id",$idEvento);

if($evento['idProdutor'] == NULL)
{
    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=oficinas/oficina_produtor_novo'>";
}
else
{
    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=oficinas/oficina_produtor_edicao'>";
}
