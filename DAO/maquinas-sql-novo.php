<?php
	/*
	*	MAQUINAS-SQL-NOVO.PHP
	*	Adiciona nova maaquina.
	*/

	use controllers\MaquinaController;
	use model\MaquinaModel;

	require_once("../autoload.php");
	require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_DAO_Adm();

	// Caso a variavel não exista
	if (!isset($_POST["maquina"])){
		header("Location: ../index.php");
		die();
	}	

	// Cadastrando uma nova maquina
	$maquina = new MaquinaModel();
	$maquina->setNome($_POST['maquina']);
	
	$maquinaController = new MaquinaController();
	$resultado = $maquinaController->adicionarMaquinas($maquina);	

	$msg_success = null;
	$msg_error = null;

	switch($resultado){
		case 0:
			$msg_success = "A máquina <strong>{$maquina->getNome()}</strong> foi cadastrada com sucesso.";
			break;
		case 1:
			$msg_error = "A máquina <strong>{$maquina->getNome()}</strong> já está cadastrada.";
			break;
		case 2:
			$msg_error = "Não foi possivel cadastrar a máquina <strong>{$maquina->getNome()}</strong>.";
			break;
	}

	if (!isset($_SESSION)) session_start();
	
	$_SESSION["maquina_cadastro_msg_success"] = $msg_success;
	$_SESSION["maquina_cadastro_msg_error"] = $msg_error;

	header("Location: ../maquinas-novo.php");
	die();


?>
