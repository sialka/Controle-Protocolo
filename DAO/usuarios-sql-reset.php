<?php
	/*
	*	USUARIOS-SQL-BLOQUEIO.PHP
	*	Altera a senha do usuario.
	*/

	use controllers\UsuarioController;

	require_once("../autoload.php");
	require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();
    
	$senha1 = $_POST["senha1"];
	$senha2 = $_POST["senha2"];

	$msg_success = null;
	$msg_error = null;

	if ($senha1 == $senha2){

		$UsuarioController = new UsuarioController();
		$trocar = $UsuarioController->alteraSenha($senha1);	
		
		if ($trocar){			
			$msg_success = "Senha alterada com sucesso";			
		}else{			
			$msg_error = "Não foi possivel alterar a senha";	
		}

	}else{
		
		$msg_error = "As senhas devem ser iguais";
	}
	
	if (!isset($_SESSION)) {
		session_start();	
	}
	$_SESSION["usuario_reset_msg_success"] = $msg_success;
	$_SESSION["usuario_reset_msg_error"] = $msg_error;				

	header("Location: ../usuarios-reset.php");

?>