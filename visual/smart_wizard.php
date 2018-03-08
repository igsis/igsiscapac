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
                <!-- <option value="default">default</option> -->
                <!-- <option value="circles">circles</option> -->
                <!-- <option value="arrows">arrows</option> -->
          </select>
        </div>           
        
        <div class="btn-group navbar-btn hidden" role="group">
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
            '/igsiscapac/visual/index.php?perfil=anexos_pf',
            '/igsiscapac/visual/index.php?perfil=final_pf'
        );
        # passo 7 ao 10 Pessoa Juridica
        $urlPj = array(
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
        // $ativ_1 = 'clickable';
        for ($i = 0; $i < count($urlMenuEvento); $i++) {
            if ($uri == $urlMenuEvento[$i]) { 
                if ($i == 0 || $i == 1){
                    $ativ_1 = 'done loading';
                }elseif ($i == 2) {                
                    $ativ_2 = 'done loading';
                }elseif ($i == 3 || $i == 4) {    
                    $ativ_3 = 'done loading';
                }elseif ($i == 5) {                
                    $ativ_4 = 'done loading';
                }elseif ($i == 6) {                
                    $ativ_5 = 'done loading';
                }
    ?>   
        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li class="<?php echo $ativ_1 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=evento_edicao'" href=""><br /> Informações Gerais do Evento</a>
                </li> 
                <li class="<?php echo $ativ_2 ?? 'clickable'; ?>">
                   <a onclick="location.href='index.php?perfil=arquivos_evento'" href=""><br />Arquivos do Evento</a>
                </li>
                <li class="<?php echo $ativ_3 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=produtor_edicao'" href=""><br />Dados do Produtor</a>
                </li>
                <li class="<?php echo $ativ_4 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=arquivos_com_prod'" href=""><br />Arquivos Para Comunicação e Produção</a>
                </li>
                <li class="<?php echo $ativ_5 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=proponente'" href=""><br />Cadastro do Proponente</a>
                </li>               
                <!-- <li class=""><a href="#step-6"><br /><small>Informações Iniciais</small></a></li>    -->                                  
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
                <li><a href=""><br /><small>Arquivos do Evento</small></a></li>
                <li><a href=""><br /><small>Informações Complementares</small></a></li>
                <li><a href=""><br /><small>Dados Bancários</small></a></li>
                <li><a href=""><br /><small>Demais Anexos</small></a></li>          
                <li><a href=""><br /><small>Finalizar</small></a></li>          
            </ul> 
        </div>
    <?php 
            continue;
            }
        }
        # Verifica se a pagina contem o endereço correspondente ao de pessoa Física
        for ($i = 0; $i < count($urlPj); $i++) {
            if ($uri == $urlPj[$i]) {

    ?>
        <!-- Pessoa Jurídica -->
        <div id="smartwizard">
            <ul>
                <li><a href=""><br /><small>Informações Iniciais</small></a></li> 
                <li>
                    <a href=""><br /><small>Arquivos da Empresa</small></a>
                </li>
                <li>
                    <a href=""><br /><small>Endereço</small></a>
                </li>
                <li>
                    <a href=""><br /><small>Representante Legal</small></a>
                </li>
                <li>
                    <a href=""><br /><small>Arquivos Representante Legal</small></a>
                </li>               
                <li>
                    <a href=""><br /><small>Dados Bancários</small></a>
                </li>
                <li>
                    <a href=""><br /><small>Arquivos Bancários</small></a>
                </li>
                <li>
                    <a href=""><br /><small>Líder do Grupo/Artista</small></a>
                </li> 
                <li>
                    <a href=""><br /><small>Arquivos Líder do Grupo/Artista</small></a>
                </li> 
                <li>
                    <a href=""><br /><small>Demais Anexos</small></a>
                </li> 
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
<script type="text/javascript" src="../visual/dist/js/jquery.smartWizard.js"></script>
<!-- Javascript - funções botões -->
<script type="text/javascript" src="../visual/dist/js/js-smartWizard.js"></script>  

