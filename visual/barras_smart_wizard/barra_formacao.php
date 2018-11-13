<?php
/*TODO: Ocultar opções do menu*/
$urlPf = array(
    '/igsiscapac/visual/index.php?perfil=formacao_resultado',
    '/igsiscapac/visual/index.php?perfil=formacao_informacoes_iniciais',
    '/igsiscapac/visual/index.php?perfil=formacao_arquivos_pf', // 02 arquivo Evento
    '/igsiscapac/visual/index.php?perfil=formacao_endereco', // 03 endereço
    '/igsiscapac/visual/index.php?perfil=formacao_informacoes_complementares', // 04 info complem
    '/igsiscapac/visual/index.php?perfil=dados_bancarios_pf', // 05 dados bancarios
    '/igsiscapac/visual/index.php?perfil=anexos_pf', // 06 demais anexos
    '/igsiscapac/visual/index.php?perfil=final_pf', // 07 final pf
    '/igsiscapac/visual/index.php?perfil=arquivos_dados_bancarios_pf' // 08
);
for ($i = 0; $i < count($urlPf); $i++) {
    if ($uri == $urlPf[$i]) {
        if ($i == 0 || $i == 1){
            $active1 = 'active loading';
        }elseif ($i == 2){
            $active2 = 'active loading';
        }elseif ($i == 3){ // endereco
            $active3 = 'active loading';
        }elseif ($i == 4){ // info complem
            $active4 = 'active loading';
        }elseif ($i == 5){ // dados bancarios
            $active5 = 'active loading';
        }elseif ($i == 6){ // demais anexos
            $active6 = 'active loading';
        }elseif ($i == 7){ // Finalizar
            $active7 = 'active loading';
        }elseif ($i == 8){ // dados bancarios
            $active8 = 'active loading';
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
                        <a onclick="location.href='index.php?perfil=formacao_informacoes_iniciais'" href=""><br /><small>Informações Iniciais</small></a>
                    </li>
                    <li class="<?php echo isset($active2) ? $active2 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=formacao_arquivos_pf'" href=""><br /><small>Arquivos da Pessoa</small></a>
                    </li>
                    <li class="<?php echo isset($active3) ? $active3 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=formacao_endereco'" href=""><br /><small>Endereço</small></a>
                    </li>
                    <li class="<?php echo isset($active4) ? $active4 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=formacao_informacoes_complementares'" href=""><br /><small>Informações Complementares</small></a>
                    </li>
                    <li class="<?php echo isset($active5) ? $active5 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=dados_bancarios_pf'" href=""><br /><small>Dados Bancários</small></a>
                    </li>
                    <li class="<?php echo isset($active8) ? $active8 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=arquivos_dados_bancarios_pf'" href=""><br /><small>Arquivos Dados Bancários</small></a>
                    </li>
                    <li class="<?php echo isset($active6) ? $active6 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=anexos_pf'" href=""><br /><small>Demais Anexos</small></a>
                    </li>
                    <li class="<?php echo isset($active7) ? $active7 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=final_pf'" href=""><br /><small>Finalizar</small></a>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}
?>