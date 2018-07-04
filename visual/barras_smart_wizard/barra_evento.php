<?php 
# Endereços das urls do menu de Eventos
$urlMenuEvento = array(
    '/igsiscapac/visual/index.php?perfil=evento_novo',
    '/igsiscapac/visual/index.php?perfil=evento_edicao',
    '/igsiscapac/visual/index.php?perfil=arquivos_evento',
    '/igsiscapac/visual/index.php?perfil=produtor_novo',
    '/igsiscapac/visual/index.php?perfil=produtor_edicao',
    '/igsiscapac/visual/index.php?perfil=arquivos_com_prod',
    '/igsiscapac/visual/index.php?perfil=pedido',
    '/igsiscapac/visual/index.php?perfil=proponente'
);
for ($i = 0; $i < count($urlMenuEvento); $i++) {
    if ($uri == $urlMenuEvento[$i]) { 
        if ($i == 0 || $i == 1){
            $acionar1 = 'active loading';
        }elseif ($i == 2) {                
            $acionar2 = 'active loading';
        }elseif ($i == 3 || $i == 4) {    
            $acionar3 = 'active loading';
        }elseif ($i == 5) {                
            $acionar4 = 'active loading';
        }elseif ($i == 6) {                
            $acionar5 = 'active loading';
        }elseif ($i == 7) {
            $acionar6 = 'active loading';
        }

?>
        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo isset($acionar1) ? $acionar1 : 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=evento_edicao'" href=""><br /> Informações Gerais do Evento</a>
                </li> 
                <li class="<?php echo isset($acionar2) ? $acionar2 : 'clickable'; ?>">
                   <a onclick="location.href='index.php?perfil=arquivos_evento'" href=""><br />Arquivos do Evento</a>
                </li>
                <li class="<?php echo isset($acionar3) ? $acionar3 : 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=produtor_edicao'" href=""><br />Dados do Produtor</a>
                </li>
                <li class="<?php echo isset($acionar4) ? $acionar4 : 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=arquivos_com_prod'" href=""><br />Arquivos Para Comunicação e Produção</a>
                </li>
                <li class="<?php echo isset($acionar5) ? $acionar5 : 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=proponente'" href=""><br />Cadastro do Pedido</a>
                </li> 
                <li class="<?php echo isset($acionar6) ? $acionar6 : 'clickable'; ?>">
                    <a onclick="location.href='index.php?perfil=proponente'" href=""><br />Cadastro do Proponente</a>
                </li>               
                <!-- <li class=""><a href="#step-6"><br /><small>Informações Iniciais</small></a></li>    -->                                  
            </ul>
       	</div>
<?php 
    }
}    
?>