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
                    <a onclick="location.href='index.php?perfil=arquivos_pf'" href=""><br /><small>Arquivos do Evento</small></a>
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