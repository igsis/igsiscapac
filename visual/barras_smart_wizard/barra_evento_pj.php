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