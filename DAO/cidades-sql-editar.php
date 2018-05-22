<?php
	/*
	*	CIDADES-SQL-EDITAR.PHP
	*	Edita Cidades existentes.
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
	if (!isset($_POST["id"]) || !isset($_POST["cidade"]) || !isset($_POST["vara"])) {
		header("Location: ../index.php");
		die();
	}	

	$cidade = new CidadeModel();
	$cidade->setId($_POST["id"]);
	$cidade->setNome($_POST["cidade"]);
	$cidade->setVaras($_POST["vara"]);

	$cidadeController = new CidadeController();
	$resultado = $cidadeController->editarCidades($cidade);
	

	$msg_success = null;
	$msg_error = null;

	// Tratamento de erro 
	switch ($resultado) {
		case '0':
			$msg_success = "A cidade <strong> {$cidade->getNome()} </strong> foi alterada com sucesso.";
			break;
		case '1':
			$msg_error = "Não foi possivel acessar o banco de dados.";
			break;
		case '2':
			$msg_error = "A cidade <strong>{$cidade->getNome()}</strong> já está cadastrada.";
			break;
	}
	
	if (!isset($_SESSION)) session_start();
	
	$_SESSION["cidade_editar_msg_success"] = $msg_success;
	$_SESSION["cidade_editar_msg_error"] = $msg_error;

	header("Location: ../cidades-editar.php");
	die();


?>
