<?php    
	/*
	*	USUARIOS-SQL-EDITAR.PHP
	*	Edita usuário.
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

	$usuario = new UsuarioModel();
	$usuario->setId($_POST["id"]);
	$usuario->setUsuario($_POST["usuario"]);
	$usuario->setNome($_POST["nome"]);
	$usuario->setEmail($_POST["email"]);
	
	# usar if ternario
	if(isset($_POST["adm"])){
		$usuario->setNivel(1);
	}else{
		$usuario->setNivel(0);
	}
	
	$UsuarioController = new UsuarioController();
	$resultado = $UsuarioController->editarUsuario($usuario);	
	
	$msg_success = null;
	$msg_error = null;

	if ($resultado) {				
		$msg_success =  "Os dados do usuario <strong>{$usuario->getUsuario()}</strong> foi alterado com sucesso.";
	}else{		
		$msg_error = "Não foi possivel alterar o usuario <strong>{$usuario->getUsuario()}</strong>.";	
	}

	if (!isset($_SESSION)) session_start();
	
	$_SESSION["usuario_editar_msg_success"] = $msg_success;
	$_SESSION["usuario_editar_msg_error"] = $msg_error;

	header("Location: ../usuarios-editar.php");
	die();

?>

