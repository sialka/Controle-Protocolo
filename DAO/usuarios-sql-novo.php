<?php
	/*
	*	USUARIOS-SQL-NOVO.PHP
	*	Adiciona novo usuario.
	*/

	use controllers\UsuarioController;
	use model\UsuarioModel;

	require_once("../autoload.php");
	require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_DAO_Adm();
    
 	// Direciona casa não exista o Id
	if (!isset($_POST["usuario"])) {		
		header("Location: ../index.php");
		die();
	}
	
	$usuario = new UsuarioModel();
	$usuario->setUsuario($_POST["usuario"]);
	$usuario->setSenha($_POST["senha"]);
	$usuario->setNome($_POST["nome"]);
	$usuario->setEmail($_POST["email"]);
	
	$UsuarioController = new UsuarioController();
	$resultado = $UsuarioController->criarUsuario($usuario);
	
	$msg_success = null;
	$msg_error = null;

	switch ($resultado) {
	    
	    case 0: // já cadastrado
	    	//$msg_error = "Não foi possivel cadastrar o usuario";
	    	$msg_error = "Já existe um usuario cadastrado com esse nome.";
	        break;
	    case 1: // criado e-mail enviado com sucesso
	    	$msg_success = "Usuário <strong>{$usuario->getNome()}</strong> cadastrado com sucesso";
	        break;
	    case 2: // criado não conseguiu enviar e-mail	    
	    	$msg_success = "Usuário cadastrado com sucesso";
	        break;
	}
	
	if (!isset($_SESSION)) session_start();
	
	$_SESSION["usuario_cadastro_msg_success"] = $msg_success;
	$_SESSION["usuario_cadastro_msg_error"] = $msg_error;

	header("Location: ../usuarios-novo.php");
	die();

?>		    