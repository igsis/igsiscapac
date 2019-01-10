<?php

$urlPf = array(
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_edicao',
    '/igsiscapac/visual/index.php?perfil=oficinas/arquivos_oficina', // 01 Arquivos oficina
    '/igsiscapac/visual/index.php?perfil=oficinas/produtor_oficina', // 02 produtor busca
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_produtor_novo', // 03 produtor novo
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_produtor_edicao', // 04 produtor edita
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_arquivos_com_prod', // 05 arquivos com. producao
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_finalizar', // 06 finalizar
);

for ($i = 0; $i < count($urlPf); $i++) {
    if ($uri == $urlPf[$i]) {
        if ($i == 0){      // oficina edicao
            $active1 = 'active loading';
        }elseif ($i == 1){ // arqs. oficina
            $active2 = 'active loading';
        }elseif ($i == 2 || $i == 3 || $i == 4){ // produtor busca, novo e edita
            $active3 = 'active loading';
        }elseif ($i == 5){ // arqs. comunicao e producao
            $active4 = 'active loading';
        }elseif ($i == 6){ // finalizar
            $active5 = 'active loading';
        }
        if(!(isset($_SESSION['idEvento']))){

            ?>
            <!-- Pessoa Jurídica  -->
            <div id="smartwizard">
                <ul>
                    <li class="hidden">
                        <a href=""><br /></a>
                    </li>
                    <li class="<?php echo isset($active1) ? $active1 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas/oficina_edicao'" href=""><br /><small>Informações Gerais da Oficina</small></a>
                    </li>
                    <li class="<?php echo isset($active2) ? $active2 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas/arquivos_oficina'" href=""><br /><small>Arquivos da Oficina</small></a>
                    </li>
                    <li class="<?php echo isset($active3) ? $active3 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas/produtor_oficina'" href=""><br /><small>Dados do Produtor</small></a>
                    </li>
                    <li class="<?php echo isset($active4) ? $active4 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas/oficina_arquivos_com_prod'" href=""><br /><small>Arquivos Para Comunicação e Produção</small></a>
                    </li>
                    <li class="<?php echo isset($active5) ? $active5 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas/oficina_finalizar'" href=""><br /><small>Finalizar</small></a>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}
?>