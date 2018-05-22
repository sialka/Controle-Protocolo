<?php
	/*
	*	LIB-V1.PHP
	*	BIBLIOTECA DE FUNÇÕES
	*/    

    # Se não houver logado direciona para autenticação (senha)
    function Esta_logado()
    {
	  	if (!isset($_SESSION)) session_start();	    
	    if(!isset($_SESSION["usuario_logado"]))
	    {        
	        header("Location: login.php");                
	        die();
	    }           
	}

    # Se não houver logado direciona para autenticação (senha)
    function Esta_logado_DAO()
    {
	  	if (!isset($_SESSION)) session_start();	    
	    if(!isset($_SESSION["usuario_logado"]))
	    {        
	        header("Location: ../login.php");                
	        die();
	    }           
	}

    # Se o usuario não for administrador faz o direcionamento
	function So_Usuario_Adm()
	{       			    
	    # 0 - Usuario Comum.
	    # 1 - Usuario Administrador.    
	 	
	 	if (!isset($_SESSION)) session_start();
	 	if ($_SESSION["usuario_nivel"]==0)
	 	{
	        header("Location: index.php");                
	        die();
     	}
	}
	
	# Se o usuario não for administrador faz o direcionamento
	function So_Usuario_DAO_Adm()
	{       			    
	    # 0 - Usuario Comum.
	    # 1 - Usuario Administrador.	    
	 	
	 	if (!isset($_SESSION)) session_start();		
	 	if ($_SESSION["usuario_nivel"]==0) 
	 	{
	        header("Location: ../index.php");                
	        die();
     	}
	}

	# Retorna o =>getNome() de um array com essa propriedade.
	function LocalizaNomePorId($array, $id)
	{	
		foreach ($array as $registro) 
		{
			if ($registro->getId()== $id) return $registro->getNome();		
		}
		return "-";
	}

	# Retorna o =>getUsuario() de um array com essa propriedade.
	function LocalizaUsuarioPorId($array, $id)
	{	
		foreach ($array as $registro)
		{
			if ($registro->getId()== $id) return $registro->getUsuario();		
		}
		return "-";
	}

	# Titulo da Pagina
	function PageTitle($icone, $titulo)
	{
		echo '
        <div class="row">                    
            <h3 class="breadcrumb-title">
                <i class="fa '.$icone.'"></i>
                '.$titulo.'
            </h3>                                
        </div>';
	}

	# Cabeçario da Pagina
	function PageHeader($titulo)
	{
		echo '
		<div class="row">      
			<ol class="breadcrumb">
				<li><i class="fa fa-chevron-circle-right"></i> Área de Trabalho</li>			
				<li>'.$titulo.'</li>							  
			</ol>
		</div>';
	}

	function MensagenSucesso($msg)
	{
		if (isset($_SESSION[$msg]))
		{
			$texto = $_SESSION[$msg];

		    echo '
		    	<div class="row">
		    		<div id="msg" class="alert alert-success text-center">
		    		<i class="fa fa-check"></i>
		    		'.$texto.'</div>
		    	</div>';
		    
		    unset($_SESSION[$msg]);
		}
	}
	function MensagenErro($msg)
	{
		if (isset($_SESSION[$msg]))
		{
			$texto = $_SESSION[$msg];

		    echo '
		    	<div class="row">
		    		<div id="msg" class="alert alert-danger text-center">
		    		<i class="fa fa-times"></i>
		    		'.$texto.'</div>
		    	</div>';
		    
		    unset($_SESSION[$msg]);
		}
	}

?>