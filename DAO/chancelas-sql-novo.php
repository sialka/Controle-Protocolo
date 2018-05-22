<?php
	/*
	*	CHANCELAS-SQL-NOVO.PHP
	*	Adiciona novas chancelas.
	*/

	use controllers\ChancelaController;
	use model\ChancelaModel;

	require_once("../autoload.php");
	require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();    

	// Caso não exista as variaveis
	// (*) criar um template para mensagens
	if (!isset($_POST["data"]) || !isset($_POST["maquinaId"]) || !isset($_POST["chancelaInicial"]) || !isset($_POST["chancelaFinal"])) {
		header("Location: ../index.php");
		die();
	} 

		$chancela = new ChancelaModel();
		$chancela->setData($_POST['data']);
		$chancela->setMaquinaId($_POST['maquinaId']);
		$chancela->setInicio($_POST['chancelaInicial']);
		$chancela->setFinal($_POST['chancelaFinal']);

		$chancelaController	= new ChancelaController();	
		$resultado = $chancelaController->adicionarChancela($chancela);	

		$msg_success = null;
		$msg_error = null;

		// Tratamento de erro
		switch($resultado){
			case 0:
				$msg_success = "As chancelas 
								inicio <strong>{$chancela->getInicio()}</strong> e 
								final <strong>{$chancela->getFinal()}</strong> do 
								dia <strong>{$chancela->getData()}</strong> foi cadastrada com sucesso.";
				break;
			case 1:
				$msg_error = "Já existem chancelas cadastradas no dia <strong>{$chancela->getData()}</strong>.";
				break;
			case 2:
				$msg_error = "Verifique a ordem das chancelas.";
				break;
			case 3:
				$msg_error = "Não foi possivel cadastrar as chancelas.";
				break;
		}

	if (!isset($_SESSION)) session_start();
	
	$_SESSION["chancela_novo_msg_success"] = $msg_success;
	$_SESSION["chancela_novo_msg_error"] = $msg_error;

	header("Location: ../chancelas-novo.php");
	die();

?>
