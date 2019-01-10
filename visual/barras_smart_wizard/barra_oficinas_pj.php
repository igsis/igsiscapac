<?php

$urlPf = array(
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_informacoes_iniciais',
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_arquivos', // 01 Arquivos PJ
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_endereco', // 02 Endereço PJ
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_informacoes_complementares', // 03 info complem
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_representante', // 04 representantes
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_representante_resultado_busca', // 05 resultado da busca representante
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_representante_cadastro', // 06 resultado cadastro
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_arquivos_representante', // 07 arqs. representantes
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_dados_bancarios', // 08 dados bancarios
    '/igsiscapac/visual/index.php?perfil=oficinas_cronograma', // 09 cronograma
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_demais_anexos', // 10 demais anexos
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_finalizar', // 11 finalizar pj
    '/igsiscapac/visual/index.php?perfil=oficineiro_pj_arquivos_dados_bancarios', // 12 oficineiro_pj_arquivos_dados_bancarios
);

for ($i = 0; $i < count($urlPf); $i++) {
    if ($uri == $urlPf[$i]) {
        if ($i == 0){      // info. iniciais
            $active1 = 'active loading';
        }elseif ($i == 1){ // arqs. PJ
            $active2 = 'active loading';
        }elseif ($i == 2){ // endereco PJ
            $active3 = 'active loading';
        }elseif ($i == 3){ // info complem
            $active4 = 'active loading';
        }elseif ($i == 4 || $i == 5 || $i == 6){ // buscar representante, resultado da busca e cadastro
            $active5 = 'active loading';
        }elseif ($i == 7){ // arqs. representante
            $active6 = 'active loading';
        }elseif ($i == 8){ // dados bancarios
            $active7 = 'active loading';
        }elseif ($i == 9){ // cronograma
            $active8 = 'active loading';
        }elseif ($i == 10){ // demais anexos
            $active9 = 'active loading';
        }elseif ($i == 11){ // finalizar
            $active10 = 'active loading';
        }elseif ($i == 12){ // oficineiro_pj_arquivos_dados_bancarios
            $active11 = 'active loading';
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
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_informacoes_iniciais'" href=""><br /><small>Informações Iniciais</small></a>
                    </li>
                    <li class="<?php echo isset($active2) ? $active2 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_arquivos'" href=""><br /><small>Arquivos da Empresa</small></a>
                    </li>
                    <li class="<?php echo isset($active3) ? $active3 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_endereco'" href=""><br /><small>Endereço</small></a>
                    </li>
                    <li class="<?php echo isset($active4) ? $active4 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_informacoes_complementares'" href=""><br /><small>Informações Complementares</small></a>
                    </li>
                    <li class="<?php echo isset($active5) ? $active5 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_representante'" href=""><br /><small>Representante</small></a>
                    </li>
                    <li class="<?php echo isset($active6) ? $active6 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_arquivos_representante'" href=""><br /><small>Arquivos Representante</small></a>
                    </li>
                    <li class="<?php echo isset($active7) ? $active7 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_dados_bancarios'" href=""><br /><small>Dados Bancários</small></a>
                    </li>
                </ul>
                <ul>
                    <li class="<?php echo isset($active11) ? $active11 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_arquivos_dados_bancarios'" href=""><br /><small>Arquivos Dados Bancários</small></a>
                    </li>
                    <li class="<?php echo isset($active8) ? $active8 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficinas_cronograma'" href=""><br /><small>Cronograma</small></a>
                    </li>
                    <li class="<?php echo isset($active9) ? $active9 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_demais_anexos'" href=""><br /><small>Demais Anexos</small></a>
                    </li>
                    <li class="<?php echo isset($active10) ? $active10 : 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=oficineiro_pj_finalizar'" href=""><br /><small>Finalizar</small></a>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}
?>