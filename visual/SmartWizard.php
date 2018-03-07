<head>
    <!-- Include SmartWizard CSS -->
    <link href="../visual/dist/css/smart_wizard.css" rel="stylesheet" type="text/css" />
    
    <!-- Optional SmartWizard theme -->
    <link href="../visual/dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
    <link href="../visual/dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
    <link href="../visual/dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
</head>
<div class="container-fluid">
        
    <form class="form-inline">
         <div class="form-group hidden">
          <label >Selecione o tema:</label>
          <select id="theme_selector" class="form-control">
                <option value="dots">dots</option>
                <!-- <option value="circles">circles</option> -->
                <!-- <option value="default">default</option> -->
                <!-- <option value="arrows">arrows</option> -->
          </select>
        </div>           
        
        <div class="btn-group navbar-btn" role="group">
            <button class="btn btn-default" id="prev-btn" type="button">Retornar</button>
            <button class="btn btn-theme" id="next-btn" type="button" >Avançar</button>
            <!-- <button class="btn btn-danger" id="reset-btn" type="button">Reset Wizard</button> -->
        </div>
    </form>
    <?php 
        #Pega a url da pagina
        $uri = $_SERVER['REQUEST_URI']; 
        // echo $uri;
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
            '/igsiscapac/visual/index.php?perfil=informacoes_iniciais_pf',
            '/igsiscapac/visual/index.php?perfil=endereco_pf',
            '/igsiscapac/visual/index.php?perfil=informacoes_complementares_pf',
            '/igsiscapac/visual/index.php?perfil=dados_bancarios_pf',
            '/igsiscapac/visual/index.php?perfil=anexos_pf'
        );

        # passo 7 ao 10 Pessoa Juridica
        $urlPj = array(
            '/igsiscapac/visual/index.php?perfil=proponente_pj_resultado',
            '/igsiscapac/visual/index.php?perfil=informacoes_iniciais_pj',
            '/igsiscapac/visual/index.php?perfil=arquivos_pj',
            '/igsiscapac/visual/index.php?perfil=endereco_pj',
            '/igsiscapac/visual/index.php?perfil=representante1_pj_cadastro',
            '/igsiscapac/visual/index.php?perfil=arquivos_representante1',
            '/igsiscapac/visual/index.php?perfil=dados_bancarios_pj',
            '/igsiscapac/visual/index.php?perfil=arquivos_dados_bancarios_pj',
            '/igsiscapac/visual/index.php?perfil=artista_pj',
            '/igsiscapac/visual/index.php?perfil=artista_pj_resultado_busca',
            '/igsiscapac/visual/index.php?perfil=arquivos_artista_pj',
            '/igsiscapac/visual/index.php?perfil=anexos_pj'
        );

        for ($i = 0; $i < count($urlMenuEvento); $i++) {
            if ($uri == $urlMenuEvento[$i]) {         
    ?>
        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li><a href=""><br /><small>Informações Gerais do Evento</small></a></li> 
                <li><a href=""><br /><small>Arquivos do Evento</small></a></li>
                <li><a href="#step-3"><br /><small>Dados do Produtor</small></a></li>
                <li><a href="#step-4"><br /><small>Arquivos Para Comunicação e Produção</small></a></li>
                <li><a href="#step-5"><br /><small>Cadastro do Proponente</small></a></li>               
                <li><a href="#step-6"><br /><small>Informações Iniciais</small></a></li>            
                <li><a href="#step-5"><br /><small>Informações Iniciais</small></a></li>               
            </ul>
       	</div>

    <?php 
            continue;
            }
        }
        # Verifica se a pagina contem o endereço correspondente ao de pessoa Física
        for ($i = 0; $i < count($urlPf); $i++) {
            if ($uri == $urlPf[$i]) {
    ?>
    
        <!-- Pessoa Física      -->
        <div id="smartwizard">
            <ul>
                <li><a href=""><br /><small>Informações Iniciais</small></a></li> 
                <li><a href="#step-7"><br /><small>Arquivos do Evento</small></a></li>
                <li><a href=""><br /><small>Informações Complementares</small></a></li>
                <li><a href=""><br /><small>Dados Bancários</small></a></li>
                <li><a href=""><br /><small>Demais Anexos</small></a></li>          
            </ul> 
        </div>
    <?php 
            continue;
            }
        }
        # Verifica se a pagina contem o endereço correspondente ao de pessoa Física
        for ($i = 0; $i < count($urlPf); $i++) {
            if ($uri == $urlPf[$i]) {

    ?>
        <!-- Pessoa Jurídica -->
        <div id="smartwizard">
            <ul>
                <li><a href=""><br /><small>Informações Iniciais</small></a></li> 
                <li><a href=""><br /><small>Arquivos da Empresa</small></a></li>
                <li><a href=""><br /><small>Endereço</small></a></li>
                <li><a href=""><br /><small>Representante Legal</small></a></li>
                <li><a href=""><br /><small>Arquivos do Representante Legal</small></a></li>               
                <li><a href=""><br /><small>Dados Bancários</small></a></li>
                <li><a href=""><br /><small>Arquivo dos Dados Bancários</small></a></li>
                <li><a href=""><br /><small>ARTISTA - Líder do Grupo ou Artista Solo</small></a></li> 
                <li><a href=""><br /><small>Arquivos do Líder do Grupo ou Artista Solo</small></a></li> 
                <li><a href=""><br /><small>Demais Anexos</small></a></li> 
            </ul>
        </div>

        <?php 
            continue;
            }
        }
        ?>
</div>
<!-- Include jQuery -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->

<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="../visual/dist/js/jquery.smartWizard.min.js"></script>
<!-- Javascript - funções botões -->
<script type="text/javascript" src="../visual/dist/js/js-smartWizard.js"></script>  
