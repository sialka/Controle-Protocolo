<?php 
    /*
    *   INDEX.PHP
    *   VIEW - PRINCIPAL HOME DO SISTEMA
    */

    use controllers\UsuarioController;
    use controllers\CidadeController;
    use controllers\MaquinaController;
    use controllers\ChancelaController;
    use controllers\ProtocoloController;

    require_once("autoload.php");
    require_once("lib-v1.php");           

    /* Verifica se está logado */        
    Esta_logado();    

    $usuarioController = new UsuarioController();
    $contaUsuarios = $usuarioController->contaUsuarios();

    $cidadeController = new CidadeController();
    $contaCidades = $cidadeController->contaCidades();

    $maquinaController = new MaquinaController();
    $contaMaquinas = $maquinaController->contaMaquinas();

    $chancelaController = new ChancelaController();
    $ultimaChancela = $chancelaController->ultimasChancelas();

    $protocoloController = new ProtocoloController();
    $contaProtocolos = $protocoloController->contaProtocolos();

    /* Carrega os templates do HTML (cabeçario/menu) */
    require_once("template/html-head.php"); 
?>

    <!-- Sessão Principal -->
    <section>
    
        <?php pageTitle("fa-home","Área de Trabalho") ?>

      	<div class="row">
        	
            <!-- Cidades -->
        	<div class="col-md-4">
    	        <div class="panel panel-primary">
    	            <div class="panel-heading">
    	                <div class="row">
    	                    <div class="col-xs-3">
    	                        <!--i class="fa fa-comments fa-5x"></i-->
    	                        <i class="fa fa-tags fa-5x"></i>
    	                    </div>
    	                    <div class="col-xs-9 text-right">
    	                        <div class="huge">
    	                        	<?php echo $contaCidades; ?>
    	                        </div>
    	                        <div>Cidades</div>
    	                    </div>
    	                </div>
    	            </div>
    	            <a href="cidades-lista.php">
    	                <div class="panel-footer">
    	                    <span class="pull-left">Veja as Cidades</span>
    	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
    	                    <div class="clearfix"></div>
    	                </div>
    	            </a>
    	        </div>
        	</div>

        	<!-- Maquinas -->
            <div class="col-md-4">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">                                                    
                                <i class="fa fa-barcode fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                	<?php echo $contaMaquinas; ?>
                                </div>
                                <div>Maquinas</div>
                            </div>
                        </div>
                    </div>
                    <a href="maquinas-lista.php">
                        <div class="panel-footer">
                            <span class="pull-left">Veja as Máquinas</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Protocolos -->
            <div class="col-md-4">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <!--i class="fa fa-support fa-5x"></i-->
                                <i class="fa fa-file-text fa-5x"></i> 
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    <?php echo $contaProtocolos; ?>
                                </div>
                                <div>Protocolos</div>
                            </div>
                        </div>
                    </div>
                    <a href="protocolos-lista.php">
                        <div class="panel-footer">
                            <span class="pull-left">Veja os Protocolos</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
            
            <!-- Chancelas -->
            <?php
            echo '<div class="row">';                
            foreach ($ultimaChancela as $chancela)
            {
            ?>        
                <div class="col-md-4">
        	        <div class="panel panel-red">
        	            <div class="panel-heading">
        	                <div class="row">
        	                    <div class="col-xs-3">                        	                        
        	                        <i class="fa fa-barcode fa-5x"></i> 
        	                    </div>
        	                    <div class="col-xs-9 text-right">
        	                        <div class="huge">
                                        <?php echo $chancela->getChancela(); ?>
                                    </div>
        	                        <div>
                                        Maquina:       
                                        <?php echo $chancela->getNome(); ?>
                                    </div>
        	                    </div>
        	                </div>
        	            </div>
        	            <a href="chancelas-lista.php">
        	                <div class="panel-footer">
        	                    <span class="pull-left">Veja as Chancelas</span>
        	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        	                    <div class="clearfix"></div>
        	                </div>
        	            </a>
        	        </div>
        	    </div>               
            
            <?php
            }
            echo '</div>';
            ?>

            <!-- Usuarios -->
            <?php            
            if ($_SESSION["usuario_nivel"] == 1) 
            { ?>                        
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <!--i class="fa fa-shopping-cart fa-5x"></i-->
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $contaUsuarios; ?>
                                    </div>
                                    <div>Usuários</div>
                                </div>
                            </div>
                        </div>
                        
                        <a href="usuarios-lista.php">
                            <div class="panel-footer">
                                <span class="pull-left">Veja os Usuários</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </div>
            <?php
            }
            ?>                        

    	</div>
    </section>

    <!-- Sessão Logo -->
    <section class="row">                                        
        <img class="img-responsive center-block" src="template/logo.png" alt="Logo do Sistema">
    </section>

<!-- Carrega o template do rodape -->
<?php require_once("template/footer-default.php"); ?>    
