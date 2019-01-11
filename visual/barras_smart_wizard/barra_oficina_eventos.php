<?php

$urlOficina = array(
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_edicao',   // 00 oficina edicao
    '/igsiscapac/visual/index.php?perfil=oficinas_cronograma',   // 01 oficina cronograma
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_arquivos_com_prod', // 02 arquivos com. producao
    '/igsiscapac/visual/index.php?perfil=oficinas/oficina_finalizar', // 03 finalizar
);

for ($i = 0; $i < count($urlOficina); $i++) {
    if ($uri == $urlOficina[$i]) {
        if ($i == 0){ // oficina edicao
            $active1 = 'active loading';
        }elseif ($i == 1){ // oficina cronograma
            $active2 = 'active loading';
        }elseif ($i == 2){ // arqs. comunicao e producao
            $active4 = 'active loading';
        }elseif ($i == 3){ // finalizar
            $active5 = 'active loading';
        }
        ?>
            <div id="smartwizard">
                <ul>
                    <li class="hidden">
                        <a href=""><br /></a>
                    </li>
                    <li class="<?php echo isset($active1) ? $active1 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas/oficina_edicao'" href=""><br /><small>Informações Gerais da Oficina</small></a>
                    </li>
                    <li class="<?php echo isset($active2) ? $active2 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas/arquivos_oficina'" href=""><br /><small>Cronograma da Oficina</small></a>
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
?>