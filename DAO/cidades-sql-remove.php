<?php
	/*
	*	USUARIOS-SQL-EXCLUIR.PHP	
	*	Remover usuarios existentes.
	*/

	use controllers\CidadeController;
	use model\CidadeModel;

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

	$cidade = new CidadeModel();
	$cidade->setId($_POST["id"]);
	$cidade->setNome($_POST["cidade"]);

	$controllerCidade = new CidadeController(); 
	$resultado = $controllerCidade->removerCidades($cidade);

	$msg_success = null;
	$msg_error = null;

	if ($resultado == 0) {
		$msg_success = "A cidade <strong>{$cidade->getNome()}</strong> foi removida com sucesso.";
	}else{	        		
		$msg_error = "Existem processos cadastrados com essa cidade.";		
	}

	if (!isset($_SESSION)) session_start();

	$_SESSION["cidade_excluir_msg_success"] = $msg_success;
	$_SESSION["cidade_excluir_msg_error"] = $msg_error;

	header("Location: ../cidades-lista.php");
	die();


?>
