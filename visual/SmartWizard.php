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
            <button class="btn btn-theme" id="next-btn" type="button">Avançar</button>
            <!-- <button class="btn btn-danger" id="reset-btn" type="button">Reset Wizard</button> -->
        </div>
    </form>
    
    <!-- SmartWizard html -->
    <div id="smartwizard">
        <ul>
            <li><a href="#step-1">Passo 1<br /><small>Informações Gerais do Evento</small></a></li> 
            <li><a href="#step-2">PASSO 2<br /><small>Arquivos do Evento</small></a></li>
            <li><a href="#step-3">PASSO 3<br /><small>Dados do Produtor</small></a></li>
            <li><a href="#step-4">PASSO 4<br /><small>Arquivos Para Comunicação e Produção</small></a></li>
            <li><a href="#step-5">PASSO 5<br /><small>Cadastro do Proponente</small></a></li>               
            <li><a href="#step-5">PASSO 6<br /><small>Informações Iniciais</small></a></li>               
        </ul>
   	</div>
</div>
<!-- Include jQuery -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->

<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="../visual/dist/js/jquery.smartWizard.min.js"></script>
<!-- Javascript - funções botões -->
<script type="text/javascript" src="../visual/dist/js/js-smartWizard.js"></script>  
