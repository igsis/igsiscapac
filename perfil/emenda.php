<?php

if (isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    echo "<script>window.location = '?secao=perfil';</script>";
}
include "emenda/" . $p . ".php";
