<head>
    <!-- Include SmartWizard CSS -->
    <link href="../visual/dist/css/smart_wizard.css" rel="stylesheet" type="text/css" />
    <!-- Optional SmartWizard theme -->
    <link href="../visual/dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
    <link href="../visual/dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
    <link href="../visual/dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
</head>
<div class="container">      
    <form class="form-inline">
         <div class="form-group hidden">
          <label >Selecione o tema:</label>
          <select id="theme_selector" class="form-control">
                <option value="dots">dots</option>
                <!-- <option value="default">default</option> -->
                <!-- <option value="circles">circles</option> -->
                <!-- <option value="arrows">arrows</option> -->
          </select>
        </div>           
        
        <div class="btn-group navbar-btn hidden" role="group">
            <!-- <button class="btn btn-default" id="prev-btn" type="button">Retornar</button> -->
            <!-- <button class="btn btn-theme" id="next-btn" type="button" >Avançar</button> -->
            <!-- <button class="btn btn-danger" id="reset-btn" type="button">Reset Wizard</button> -->
        </div>
    </form>
    <?php 
        #Pega a url da pagina
        $uri = $_SERVER['REQUEST_URI']; 
        // echo $uri;
        /////////////////////////////
        // Links Para o Id Eventos //
        /////////////////////////////
        # Endereços das url do menu de Eventos
        $urlMenuEvento = array(
            '/igsiscapac/visual/index.php?perfil=evento_novo',
            '/igsiscapac/visual/index.php?perfil=evento_edicao',
            '/igsiscapac/visual/index.php?perfil=arquivos_evento',
            '/igsiscapac/visual/index.php?perfil=produtor_novo',
            '/igsiscapac/visual/index.php?perfil=produtor_edicao',
            '/igsiscapac/visual/index.php?perfil=arquivos_com_prod',
            '/igsiscapac/visual/index.php?perfil=proponente'
        );
        # passo 7 ao 10 Pessoa Fisica
        $urlPf = array(
             '/igsiscapac/visual/index.php?perfil=proponente_pf_resultado',
            '/igsiscapac/visual/index.php?perfil=informacoes_iniciais_pf',
            '/igsiscapac/visual/index.php?perfil=arquivos_pf',
            '/igsiscapac/visual/index.php?perfil=endereco_pf',
            '/igsiscapac/visual/index.php?perfil=informacoes_complementares_pf',
            '/igsiscapac/visual/index.php?perfil=dados_bancarios_pf',
            '/igsiscapac/visual/index.php?perfil=anexos_pf'
            // '/igsiscapac/visual/index.php?perfil=finalizar'
        );
                # passo 7 ao 10 Pessoa Juridica
        $urlPj = array(
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
        // $ativ_1 = 'clickable';
        for ($i = 0; $i < count($urlMenuEvento); $i++) {
            if ($uri == $urlMenuEvento[$i]) { 
                if ($i == 0 || $i == 1){
                    $ativ_1 = 'active loading';
                }elseif ($i == 2) {                
                    $ativ_2 = 'active loading';
                }elseif ($i == 3 || $i == 4) {    
                    $ativ_3 = 'active loading';
                }elseif ($i == 5) {                
                    $ativ_4 = 'active loading';
                }elseif ($i == 6) {                
                    $ativ_5 = 'active loading';
                }
                include_once 'barras_smart_wizard/barra_evento.php';

            continue;
            }
        }
        # Verifica se a pagina contem o endereço correspondente ao de pessoa Física
        for ($i = 0; $i < count($urlPf); $i++) {
            if ($uri == $urlPf[$i]) {
                if ($i == 0 || $i == 1){
                    $ativ_1 = 'active loading';
                }elseif ($i == 2) {                
                    $ativ_2 = 'active loading';
                }elseif ($i == 3) {    
                    $ativ_3 = 'active loading';
                }elseif ($i == 4) {                
                    $ativ_4 = 'active loading';
                }elseif ($i == 5) {                
                    $ativ_5 = 'active loading';
                }elseif ($i == 6) {                
                    $ativ_6 = 'active loading';
                }elseif ($i == 7) {                
                    $ativ_7 = 'active loading';
                }
                if(isset($_SESSION['idEvento'])){
                    // Se estiver em evento Pf Exibir barra 
                    include_once 'barras_smart_wizard/barra_evento_pf.php';
                }
            continue;
            }
        }

        # Verifica se a pagina contem o endereço correspondente ao de pessoa Juridica
        for ($i = 0; $i < count($urlPj); $i++) {
            if ($uri == $urlPj[$i]) {
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
                    include_once 'barras_smart_wizard/barra_evento_pj.php';
                }
            continue;
            }
        }
        ?>
</div>
<!-- Include jQuery -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->

<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="../visual/dist/js/jquery.smartWizard.js"></script>
<!-- Javascript - funções botões -->
<script type="text/javascript" src="../visual/dist/js/js-smartWizard.js"></script>  

