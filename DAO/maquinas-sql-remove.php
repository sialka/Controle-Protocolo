<?php
	/*
	*	MAQUINAS-SQL-EXCLUIR.PHP
	*	Remove maquinas existentes.
	*/

	use controllers\MaquinaController;
	use model\MaquinaModel;

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

	// Caso a variavel exista
	$maquina = new MaquinaModel();
	$maquina->setId($_POST["id"]);
	$maquina->setNome($_POST["maquina"]);

	$maquinaController = new MaquinaController();
	$resultado = $maquinaController->removerMaquinas($maquina);
	
	$msg_success = null;
	$msg_error = null;

	if($resultado==0){
		$msg_success = "A máquina <strong>{$maquina->getNome()}</strong> foi removida com sucesso.";
	}else{
		$msg_error = "Não foi possivel remover a máquina <strong>{$maquina->getNome()}</strong>.";
	}

	if (!isset($_SESSION)) session_start();

	$_SESSION["maquina_excluir_msg_success"] = $msg_success;
	$_SESSION["maquina_excluir_msg_error"] = $msg_error;

	header("Location: ../maquinas-lista.php");
	die();


?>
