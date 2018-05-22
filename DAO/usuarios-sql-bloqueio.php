<?php
	/*
	*	USUARIOS-SQL-BLOQUEIO.PHP	
	*	Bloqueia usuário.
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
	if (!isset($_POST["id"])) {		
		header("Location: ../index.php");
		die();
	}

	$UsuarioController = new UsuarioController();   

	$usuario = new UsuarioModel();
	$usuario->setId($_POST["id"]);
	$usuario->setUsuario($_POST["usuario"]);
	$usuario->setNome($_POST["nome"]);
	
	$resultado = $UsuarioController->bloquearUsuario($usuario);

	$msg_success = null;
	$msg_error = null;

	switch ($resultado) {	    
	    case 0: // Sucesso
	    	$msg_success = "O usuário <strong>{$usuario->getNome()}</strong> foi desbloqueado com sucesso.";
	        break;
	    case 1: // Erro
	    	$msg_error = "O usuário <strong>{$usuario->getNome()}</strong> foi bloqueado com sucesso.";
	        break;
	    case 2: // adm não pode se bloquear
	    	$msg_error = "O usuário <strong>{$usuario->getNome()}</strong> não pode bloquear a si mesmo.";
	    	break;
	}
	
	if (!isset($_SESSION)) session_start();
	
	$_SESSION["usuario_bloqueio_msg_success"] = $msg_success;
	$_SESSION["usuario_bloqueio_msg_error"] = $msg_error;
	
	header("Location: ../usuarios-lista.php");
	die();

?>