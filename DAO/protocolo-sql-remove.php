<?php
	/*
	*	PROTOCOLOS-SQL-REMOVE.PHP
	*	Remove protocolo existente.
	*/
	
	use controllers\ProtocoloController;
	use model\ProtocoloModel;
	
	require_once("../autoload.php");
	require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();

    $protocoloController = new ProtocoloController();

	$protocolo = new ProtocoloModel();
	$protocolo->setId($_POST["id"]);	
	$protocolo->setChancela($_POST["chancela"]);	

 	$resultado = $protocoloController->deletaProtocolo($protocolo);
	 
	$msg_success = null;
	$msg_error = null;	 

	if ($resultado) {
		$msg_success = "A chancela nº <strong>".$protocolo->getChancela()."</strong> foi excluida com sucesso.";
	}else{		
		$msg_error = "Não foi possivel excluir a chancela.";
	}	

	if (!isset($_SESSION)) session_start();

	$_SESSION["protocolo_excluir_msg_success"] = $msg_success;
	$_SESSION["protocolo_excluir_msg_error"] = $msg_error;

	header("Location: ../protocolos-lista.php");
	die();

?>