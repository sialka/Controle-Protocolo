<?php
	/*
	*	PROTOCOLOS-SQL-EDITAR.PHP
	*	Edita protocolo existente.
	*/

	use controllers\ProtocoloController;	
	use model\ProtocoloModel;

	require_once("../autoload.php");
    require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();

    if (!isset($_POST['id'])){
		header("Location: ../index.php");
		die();
    }

	// Tratando a opcao duplicar
	if (isset($_POST['duplicar'])){
		$duplicar = 1;
	}else{
		$duplicar = 0;
	}
	// Tratando a opcao 2ª Impressao
	if (isset($_POST['impressao'])){
		$impressao = 1;
	}else{
		$impressao = 0;
	}		

	$protocolo = new ProtocoloModel();
	$protocolo->setId($_POST['id']);
	$protocolo->setData($_POST['data']);
	$protocolo->setCidadeId($_POST['cidade']);
	$protocolo->setVara($_POST['vara']);
	$protocolo->setProcesso($_POST['processo']);
	$protocolo->setChancela($_POST['chancela']);
	$protocolo->setDuplicado($duplicar);
	$protocolo->setImpressao($impressao);


	$protocoloController = new ProtocoloController();
	$resultado = $protocoloController->alteraProtocoloId($protocolo); 


	$msg_success = null;
	$msg_error = null;

	if ($resultado) {				
		$msg_success =  "A chancela nº <strong>{$protocolo->getChancela()}</strong> foi alterada com sucesso.";
	}else{		
		$msg_error = "Não foi possivel alterar a chancela <strong>{$protocolo->getChancela()}</strong>.";	
	}

	echo $msg_success;
	echo $msg_error;


	if (!isset($_SESSION)) session_start();
	
	$_SESSION["protocolo_editar_msg_success"] = $msg_success;
	$_SESSION["protocolo_editar_msg_error"] = $msg_error;

	header("Location: ../protocolos-editar.php");
	die();

?>