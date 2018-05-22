<?php
	/*
	*	CIDADES-SQL-NOVO.PHP
	*	Adicionada novas cidades.
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
	if (!isset($_POST["cidade"]) || !isset($_POST["vara"])){
		header("Location: ../index.php");
		die();
	}	
		
	// Criando a nova cidade
	$cidade = new CidadeModel();
	$cidade->setNome($_POST["cidade"]);
	$cidade->setVaras($_POST["vara"]);

	$controllerCidade = new CidadeController();	
	$resultado = $controllerCidade->adicionarCidades($cidade);	

	$msg_success = null;
	$msg_error = null;

	switch($resultado){
		case 0:	
			$msg_success = "A cidade <strong>{$cidade->getNome()}</strong> foi cadastrada com sucesso";
			break;
		case 1:
			$msg_error = "A cidade <strong>{$cidade->getNome()}</strong> já está cadastrada.";
			break;
		case 2:
			$msg_error = "Não foi possivel cadastrar a cidade {$cidade->getNome()}.";
			break;
	}

	if (!isset($_SESSION)) session_start();
	
	$_SESSION["cidade_cadastro_msg_success"] = $msg_success;
	$_SESSION["cidade_cadastro_msg_error"] = $msg_error;

	header("Location: ../cidades-novo.php");
	die();

?>