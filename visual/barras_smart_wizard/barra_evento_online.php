<?php

$urlPf = array(
    '/igsiscapac/visual/index.php?perfil=evento_culturaonline_edicao',
    '/igsiscapac/visual/index.php?perfil=arquivos_pf', // 02 arquivo Evento
    '/igsiscapac/visual/index.php?perfil=endereco_pf', // 03 endereço
    '/igsiscapac/visual/index.php?perfil=informacoes_complementares_pf', // 04 info complem
    '/igsiscapac/visual/index.php?perfil=dados_bancarios_pf', // 05 dados bancarios
    '/igsiscapac/visual/index.php?perfil=anexos_pf', // 06 demais anexos
    '/igsiscapac/visual/index.php?perfil=final_pf', // 07 final pf
    '/igsiscapac/visual/index.php?perfil=arquivos_dados_bancarios_pf'
);
for ($i = 0; $i < count($urlPf); $i++) {
    if ($uri == $urlPf[$i]) {
        if ($i == 0){
            $active1 = 'active loading';
        }elseif ($i == 1){
            $active2 = 'active loading';
        }
        if(!(isset($_SESSION['idEvento']))){


            ?>
            <!-- Pessoa Física      -->
            <div id="smartwizard">
                <ul>
                    <li class="hidden">
                        <a href=""><br /></a>
                    </li>
                    <li class="<?php echo isset($active1) ? $active1 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=evento_culturaonline_edicao'" href=""><br /><small>Informações Iniciais</small></a>
                    </li>
                    <li class="<?php echo isset($active2) ? $active2 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=arquivos_pf'" href=""><br /><small>Integrantes</small></a>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}
?>