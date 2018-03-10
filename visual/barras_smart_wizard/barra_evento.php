        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
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