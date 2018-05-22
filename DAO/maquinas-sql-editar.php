<?php
	/*
	*	MAQUINAS-SQL-NOVO.PHP
	*	Edita maquinas existentes.
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
	if (!isset($_POST["id"]) || !isset($_POST["maquina"])){
		header("Location: ../index.php");
		die();
	}	

	// Caso existam as variaveis
	$maquina = new MaquinaModel();
	$maquina->setId($_POST["id"]);
	$maquina->setNome($_POST["maquina"]);	


	$maquinaController = new MaquinaController();
	$resultado = $maquinaController->editarMaquinas($maquina);	

	$msg_success = null;
	$msg_error = null;

	// Tratamento de erro 	
	switch ($resultado) {
		case '1':
			$msg_success = "A maquina <strong>{$maquina->getNome()}</strong> foi alterada com sucesso.";
			break;
		case '0':
			$msg_error = "Não foi possivel acessar o banco de dados.";
			break;			
		case '2':
			$msg_error = "A maquina <strong>{$maquina->getNome()}</strong> já esta cadastrada.";
			break;
	}

	if (!isset($_SESSION)) session_start();
	
	$_SESSION["maquina_editar_msg_success"] = $msg_success;
	$_SESSION["maquina_editar_msg_error"] = $msg_error;

	header("Location: ../maquinas-editar.php");
	die();


?>
