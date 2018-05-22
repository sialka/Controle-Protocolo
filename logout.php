<?php	
	/*
	* LOGOUT.PHP
	* RESPONSAVEL POR DESLOGAR O USUARIO E RETORNAR AO INDEX.PHP
	*/

	session_destroy(); 
	session_start();

	unset($_SESSION["usuario_logado"]);
	unset($_SESSION["usuario_nivel"]);
	unset($_SESSION["usuario_logado"]);
	unset($_SESSION["usuario_id"]);
	unset($_SESSION["usuario_nivel"]);
	unset($_SESSION["usuario_reset"]);
	unset($_SESSION["usuario_nome"]);

	header("Location: index.php");
	die();

?>