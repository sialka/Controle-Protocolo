<?php
	/*
	*	USUARIOS-SQL-EXCLUIR.PHP
	*	Remover usuario.
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
	$usuario->setNome($_POST["nome"]);
		
	$UsuarioController = new UsuarioController();
	$resultado = $UsuarioController->excluirUsuario($usuario);

	$msg_success = null;
	$msg_error = null;

	switch ($resultado) {
		case 0:
			$msg_success = "<strong>{$usuario->getNome()}</strong> foi excluido com sucesso.";
			break;		
		case 1:
			$msg_error = "O usuário <strong>{$usuario->getNome()}</strong> não pode deletar a si mesmo.";		
			break;		
		case 2:
			$msg_error = "O usuário <strong>{$usuario->getNome()}</strong> não pode ser deletado.";
			break;		
	}

	if (!isset($_SESSION)) session_start();

	$_SESSION["usuario_excluir_msg_success"] = $msg_success;
	$_SESSION["usuario_excluir_msg_error"] = $msg_error;

	header("Location: ../usuarios-lista.php");
	die();

?>
