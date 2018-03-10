<?php 
# Barra Evento Pessoa Fisica
$urlEventoPf = array(
    '/igsiscapac/visual/index.php?perfil=proponente_pf_resultado',
    '/igsiscapac/visual/index.php?perfil=informacoes_iniciais_pf',
    '/igsiscapac/visual/index.php?perfil=arquivos_pf',
    '/igsiscapac/visual/index.php?perfil=endereco_pf',
    '/igsiscapac/visual/index.php?perfil=informacoes_complementares_pf',
    '/igsiscapac/visual/index.php?perfil=dados_bancarios_pf',
    '/igsiscapac/visual/index.php?perfil=anexos_pf'
    // '/igsiscapac/visual/index.php?perfil=finalizar'
);
# Verifica se a pagina contem o endereço correspondente ao de pessoa Física
for ($i = 0; $i < count($urlEventoPf); $i++) {
    if ($uri == $urlEventoPf[$i]) {
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
            // include_once 'barras_smart_wizard/barra_evento_pf.php';
?>

 <!-- Pessoa Física      -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo $ativ_1 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=informacoes_iniciais_pf'" href=""><br /><small>Informações Iniciais</small></a>
                </li> 
                <li class="<?php echo $ativ_2 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=arquivos_pf'" href=""><br /><small>Arquivos da Pessoa</small></a>
                </li> 
                <li class="<?php echo $ativ_3 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=endereco_pf'" href=""><br /><small>Endereço</small></a>
                </li>
                <li class="<?php echo $ativ_4 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=informacoes_complementares_pf'" href=""><br /><small>Informações Complementares</small></a>
                </li>
               <li class="<?php echo $ativ_5 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=dados_bancarios_pf'" href=""><br /><small>Dados Bancários</small></a>
                </li>
                <li class="<?php echo $ativ_6 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=anexos_pf'" href=""><br /><small>Demais Anexos</small></a>
                </li>          
                <li class="<?php echo $ativ_7 ?? 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=finalizar'" href=""><br /><small>Finalizar</small></a>
                </li>          
            </ul> 
        </div>
<?php  
        }
    
    }
}
?>