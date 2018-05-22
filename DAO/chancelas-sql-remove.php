<?php
	/*
	*	CHANCELAS-SQL-REMOVE.PHP
	*	------------------------
	*	Remover chancelas existentes.
	*/

	use controllers\ChancelaController;
	use model\ChancelaModel;

	require_once("../autoload.php");
	require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_DAO_Adm();

	if (!isset($_POST["id"])){
		header("Location: ../index.php");
		die();
	} 
		
	$chancela = new ChancelaModel();				
	$chancela->setId($_POST["id"]);
	$chancela->setMaquinaId($_POST["chancela"]);
	$chancela->setData($_POST["data"]);		

	//$resultado = removerChancelas($conexao, $id);
	$ChancelaController = new ChancelaController();
	$resultado = $ChancelaController->removerChancelas($chancela);

	$msg_success = null;
	$msg_error = null;		

	if($resultado){
		$msg_success = "A chancela <strong>{$chancela->getMaquinaId()}</strong> do dia <strong>{$chancela->getData()}</strong> foi removida com sucesso";
	}else{
		$msg_error = "Não foi possivel remover a chancela <strong>{$chancela->getMaquinaId()}</strong> do dia <strong>{$chancela->getData()}</strong>.";
	}

	if (!isset($_SESSION)) session_start();
	
	$_SESSION["chancela_remove_msg_success"] = $msg_success;
	$_SESSION["chancela_remove_msg_error"] = $msg_error;

	header("Location: ../chancelas-lista.php");
	die();


?>

