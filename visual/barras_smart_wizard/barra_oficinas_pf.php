<?php

$urlPf = array(
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_informacoes_iniciais',
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_arquivos', // 02 Arquivos PF
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_endereco', // 03 Endereço
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_informacoes_complementares', // 04 info complem
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_dados_bancarios', // 05 dados bancarios
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_anexos', // 06 demais anexos
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_final', // 07 final pf
    '/igsiscapac/visual/index.php?perfil=oficinas_cronogramaa', // 08
    '/igsiscapac/visual/index.php?perfil=oficineiro_pf_arquivos_dados_bancarios',
);

for ($i = 0; $i < count($urlPf); $i++) {
    if ($uri == $urlPf[$i]) {
        if ($i == 0){
            $active1 = 'active loading';
        }elseif ($i == 1){
            $active2 = 'active loading';
        }elseif ($i == 2){ // endereco
            $active3 = 'active loading';
        }elseif ($i == 3){ // info complem
            $active4 = 'active loading';
        }elseif ($i == 4){ // dados bancarios
            $active5 = 'active loading';
        }elseif ($i == 5){ // demais anexos
            $active6 = 'active loading';
        }elseif ($i == 6){ // Finalizar
            $active7 = 'active loading';
        }elseif ($i == 8){ // arquivos dados bancarios
            $active9 = 'active loading';
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
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_informacoes_iniciais'" href=""><br /><small>Informações Iniciais</small></a>
                    </li>
                    <li class="<?php echo isset($active2) ? $active2 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_arquivos'" href=""><br /><small>Arquivos da Pessoa</small></a>
                    </li>
                    <li class="<?php echo isset($active3) ? $active3 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_endereco'" href=""><br /><small>Endereço</small></a>
                    </li>
                    <li class="<?php echo isset($active4) ? $active4 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_informacoes_complementares'" href=""><br /><small>Informações Complementares</small></a>
                    </li>
                    <li class="<?php echo isset($active5) ? $active5 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_dados_bancarios'" href=""><br /><small>Dados Bancários</small></a>
                    </li>
                    <li class="<?php echo isset($active9) ? $active9 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_arquivos_dados_bancarios'" href=""><br /><small>Arquivos Dados Bancarios</small></a>
                    </li>
                    <li class="<?php echo isset($active6) ? $active6 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_anexos'" href=""><br /><small>Demais Anexos</small></a>
                    </li>
                    <li class="<?php echo isset($active7) ? $active7 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pf_final'" href=""><br /><small>Finalizar</small></a>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}
?>