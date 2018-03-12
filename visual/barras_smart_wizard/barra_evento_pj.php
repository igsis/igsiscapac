<?php 
$urlEventoPj = array(
    '/igsiscapac/visual/index.php?perfil=proponente_pj_resultado', // atv 1
    '/igsiscapac/visual/index.php?perfil=informacoes_iniciais_pj', // atv 1 onclick
    '/igsiscapac/visual/index.php?perfil=arquivos_pj', 
    '/igsiscapac/visual/index.php?perfil=endereco_pj', 
    '/igsiscapac/visual/index.php?perfil=representante1_pj', // 
    '/igsiscapac/visual/index.php?perfil=representante1_pj_resultado_busca', // 5
    '/igsiscapac/visual/index.php?perfil=representante1_pj_cadastro',  // 6
    '/igsiscapac/visual/index.php?perfil=arquivos_representante1', // 7
    '/igsiscapac/visual/index.php?perfil=representante2_pj', // 8
    '/igsiscapac/visual/index.php?perfil=representante2_pj_resultado_busca',// 9
    '/igsiscapac/visual/index.php?perfil=representante2_pj_cadastro', // 10
    '/igsiscapac/visual/index.php?perfil=arquivos_representante2', // 11
    '/igsiscapac/visual/index.php?perfil=dados_bancarios_pj', // 12
    '/igsiscapac/visual/index.php?perfil=arquivos_dados_bancarios_pj', // 13
    '/igsiscapac/visual/index.php?perfil=artista_pj', // 14 
    '/igsiscapac/visual/index.php?perfil=artista_pj_resultado_busca', // 15
    '/igsiscapac/visual/index.php?perfil=artista_pj_cadastro',// 16
    '/igsiscapac/visual/index.php?perfil=arquivos_artista_pj', // 17
    '/igsiscapac/visual/index.php?perfil=anexos_pj' // 18
);

# Verifica se a pagina contem o endereço correspondente ao de pessoa Juridica
for ($i = 0; $i < count($urlEventoPj); $i++) {
    if ($uri == $urlEventoPj[$i]) {
        if ($i == 0 || $i == 1){ 
           $ativ_1 = 'active loading';
        } elseif ($i == 2) { 
            $ativ_2 = 'active loading';
        } elseif ($i == 3) { //          enderecos 
            $ativ_3 = 'active loading'; // enderecos 
        } elseif ($i == 4 || $i == 6 || $i == 8 ||$i == 9 ||$i == 10) { // representante
            $ativ_4 = 'active loading'; // representante
        } elseif ($i == 5 ||  $i == 7 || $i == 11) { // representante
            $ativ_5 = 'active loading'; // arquivo representante
        } elseif ($i == 12) { // dados bancarios
            $ativ_6 = 'active loading'; // dados bancarios
        } elseif ($i == 13) { // arquivo dados bancarios
            $ativ_7 = 'active loading';
        }elseif ($i == 14 || $i == 15 || $i == 16) { // Líder do Grupo
            $ativ_8 = 'active loading';
        } elseif ($i == 17) { 
            $ativ_9 = 'active loading'; 
        }elseif ($i == 18) { 
             $ativ_10 = 'active loading';
        }
        if(isset($_SESSION['idEvento'])){
?>
            <!-- Pessoa Jurídica id evento -->
            <div id="smartwizard">
                <ul>
                    <li class="hidden">
                        <a href=""><br /></a>
                    </li>
                    <li class="<?php echo $ativ_1 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=informacoes_iniciais_pj'" href=""><br /><small>Informações Iniciais</small></a>
                    </li> <!-- Ok -->
                    <li class="<?php echo $ativ_2 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=arquivos_pj'" href=""><br /><small>Arquivos da Empresa</small></a>
                    </li>
                    <li class="<?php echo $ativ_3 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=endereco_pj'" href=""><br /><small>Endereço</small></a>
                    </li>
                    <li class="<?php echo $ativ_4 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=representante1_pj'" href=""><br /><small>Representante Legal</small></a>
                    </li>
                    <li class="<?php echo $ativ_5 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=arquivos_representante1'" href=""><br /><small>Arquivos Representante Legal</small></a>
                    </li>                           
                    <li class="<?php echo $ativ_6 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=dados_bancarios_pj'" href=""><br />Dados Bancários</a>
                    </li>
                    <li class="<?php echo $ativ_7 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=arquivos_dados_bancarios_pj'" href=""><br /><small>Arquivos Bancários</small></a>
                    </li>
                </ul>
                <ul>
                    <li class="<?php echo $ativ_8 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=artista_pj'" href=""><br /><small>Líder do Grupo/Artista</small></a>
                    </li> 
                    <li class="<?php echo $ativ_9 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=arquivos_artista_pj'" href=""><br /><small>Arquivos Líder do Grupo/Artista</small></a>
                    </li> 
                    <li class="<?php echo $ativ_10 ?? 'clickable'; ?>">
                        <a onclick="location.href='index.php?perfil=anexos_pj'" href=""><br /><small>Demais Anexos</small></a>
                    </li> 
                </ul>
            </div>
<?php 
        }
    }
}
?>