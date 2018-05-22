<?php   
	/*
	*	LOGIN-MSG.PHP
	*	Autenticação de usuario.
	*/
	
	use controllers\UsuarioController;	

	require_once("../autoload.php");	

	# Tratamento de Erro - Se o usuario ou senha não vier direciona para login.php
	if (!isset($_POST['usuario']) && !isset($_POST['senha'])){		
		header("Location: ../login.php");
		die();
	}	

	$UsuarioController = new UsuarioController();
	
	$nome = $_POST['usuario'];
	$senha = $_POST['senha'];	
	$resultado = $UsuarioController->login($nome, $senha);

	if (!isset($_SESSION)) session_start();		

	switch ($resultado) {
		case 0:				
			unset($_SESSION["login_msg_error"]);
			unset($_SESSION["login_tipo_erro"]);
			header ("Location: ../index.php");
			die();
			break;
		case 1:
			$msg_erro = "O usuário não está autorizado";			
			$_SESSION["login_msg_error"] = $msg_erro;
			$_SESSION["login_tipo_erro"] = 1;
			break;
		case 2:
			$msg_erro = "Senha inválida";			
			$_SESSION["login_msg_error"] = $msg_erro;	
			$_SESSION["login_tipo_erro"] = 2;
			break;
		case 3:
			$msg_erro = "O usuário está bloqueado";			
			$_SESSION["login_msg_error"] = $msg_erro;				
			#$_SESSION["login_tipo_erro"] = 3;
			break;
		case 4: 	
			header("Location: ../usuarios-reset.php");
			die();  		      
			break;		
	}	
		
	header("Location: ../login.php");

?>