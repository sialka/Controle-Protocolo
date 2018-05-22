    <!-- Navegador Superior -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation">    
    <!--  -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-brand">
            <p class="text-center logotipo">
                <i class="fa fa-shield fa-fw"></i>
                CP2 - TRT São Paulo<br>
                <small class="brand-subtitle">Controle de Recebimento de Protocolos</small>
            </p>
        </div>
    </div>            

    <!-- Menu Usuário -->
    <ul class="nav navbar-top-links navbar-right">
        
		<!-- menu usuario -->
        <li class="dropdown">
            <a class="dropdown-toggle dropdown-toggle-efect" data-toggle="dropdown" href="#">            
                
                <!-- Identificação do usuário -->
                <?php
                    if (!isset($_SESSION)) session_start();                                                    
                    if(isset($_SESSION["usuario_logado"]))
					{                        
                        # adiciona um icone ao lado do nome do usuários administrador.
						if ($_SESSION["usuario_nivel"]==1) echo '<i class="fa fa-thumb-tack fa-lg verde"></i> ';                           

                        echo '                                 
                            <span class="dropdown-usuario-admin-font">'
                            .strtoupper($_SESSION["usuario_nome"]).
                            '</span>';
                    } 
                ?>
                <!-- <i class="fa fa-user fa-lg"></i> -->
                <!-- <i class="fa fa-caret-down fa-lg"></i> -->
                <i class="fa fa-navicon fa-lg"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">                      
                <li>
                    <a href="usuarios-lista.php">
                        <i class="fa fa-group azul"></i>                                 
                        Usuários
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="logout.php">
                        <i class="fa fa-power-off vermelho"></i> 
                        Sair
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>

    <!-- Menu da Lateral -->
    <div class="navbar-default sidebar" role="navigation">

        <div class="icone-area-de-trabalho">
            <a href="index.php">
                <i class="fa fa-home fa-lg preto"></i>
                <span class="menu-home">ÁREA DE TRABALHO</span>
            </a>
        </div>

        <div class="sidebar-nav navbar-collapse">                
           
            <ul class="nav" id="side-menu">
                <!-- Menu Cidades -->
                <li>
                    <a href="#">
                        <i class="fa fa-tags fa-fw"></i>
                        <span class="elementos-menu-lateral">Cidades</span>
                        <span class="fa arrow fa-fw"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php
                            if ($_SESSION["usuario_nivel"]==1){
                                echo '<li>
                                        <a href="cidades-novo.php">                                           
                                            <i class="fa fa-gears vermelho"></i>
                                            <span class="elementos-submenu-lateral">Cadastro de Cidades</span>
                                        </a>
                                    </li>';
                            }
                        ?>                                
                        <li>                                    
                            <a href="cidades-lista.php">
                                <i class="fa fa-search fw"></i>
                                <span class="elementos-submenu-lateral">Todas as Cidades</span>                                        
                            </a>                                    
                        </li>
                    </ul>                            
                </li>
                <!-- Menu Maquinas -->
                <li>
                    <a href="#">                      
                        <i class="fa fa-barcode fa-fw"></i>
                        <span class="elementos-menu-lateral">Máquinas</span>
                        <span class="fa arrow fa-fw"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php
                            if ($_SESSION["usuario_nivel"]==1){
                                echo '
                                <li>
                                    <a href="maquinas-novo.php">                                            
                                        <i class="fa fa-gears vermelho"></i>
                                        <span class="elementos-submenu-lateral">Cadastrar Máquinas</span>
                                    </a>
                                </li>';
                            }
                        ?>
                        <li>
                            <a href="maquinas-lista.php">
                                <i class="fa fa-search fw"></i>                                        
                                <span class="elementos-submenu-lateral">Todas as Máquinas</span>                                        
                            </a>
                        </li>
                        <li>
                            <a href="chancelas-novo.php">
                                <i class="fa fa-file-o fw"></i>
                                <span class="elementos-submenu-lateral">Cadastrar Chancelas</span>
                            </a>
                        </li>                                
                        <li>
                            <a href="chancelas-lista.php">
                                <i class="fa fa-database fw"></i>
                                <span class="elementos-submenu-lateral">Gerar Relatório</span>
                            </a>
                        </li>                                
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <!-- Menu Protocolos -->
                <li>
                    <a href="#">
                        <i class="fa fa-file-text fa-fw"></i> 
                        <span class="elementos-menu-lateral">Protocolos</span>
                        <span class="fa arrow fa-fw"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php                                                            
                            if ($_SESSION["usuario_nivel"]==1){
                                echo '
                                <li>
                                    <!-- a href="#" -->
                                    <a href="protocolo-correcao.php">                                        
                                        <i class="fa fa-gears vermelho"></i>
                                        <span class="elementos-submenu-lateral">Correção de Protocolos</span>
                                    </a>
                                </li>';
                            }
                        ?>
                        <li>                                        
                            <a href="protocolos-novo.php">
                                <i class="fa fa-file-o"></i>
                                <span class="elementos-submenu-lateral">
                                    Recebimento
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="protocolos-lista.php">
                                <i class="fa fa-search fw"></i>
                                <span class="elementos-submenu-lateral">Pesquisar Protocolos</span>
                            </a>
                        </li>
                        <li>
                            <a href="protocolos-impressao.php">
                                <i class="fa fa-database fw"></i>
                                <span class="elementos-submenu-lateral">Gerar Relatórios</span>
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
        
        </div><!-- /.sidebar-collapse -->
    
    </div><!-- /.navbar-static-side -->

    </nav><!-- Fim do menu lateral -->
