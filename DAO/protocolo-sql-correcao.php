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

	//$protocolo = new ProtocoloModel();
	//$protocolo->setId($_POST["id"]);	
	//$protocolo->setChancela($_POST["chancela"]);	

 	//$resultado = $protocoloController->deletaProtocolo($protocolo);

 	$pesquisa = $_POST["pesquisa"];
 	$data = $_POST["novadata"];
 	
 	if (isset($_POST["impressao"]))
 	{
 		$impressao = 1;
 	}
 	else
 	{
 		$impressao = 0;
 	}
	
	if (isset($_POST["duplicado"]))
 	{
 		$duplicado = 1;
 	}
 	else
 	{
 		$duplicado = 0;
 	}

 	//echo 'pesquisa ->'.$pesquisa.'<br>';
 	//echo 'data ->'.$data.'<br>';
 	//echo 'impressao ->'.$impressao.'<br>';
 	//echo 'duplicado->'.$duplicado.'<br>';
 	//die();

 	$resultado = $protocoloController->alteraProtocolosCorrecao($pesquisa, $data, $impressao, $duplicado); 	
	 
	$msg_success = null;
	$msg_error = null;	 

	if ($resultado) {
		$msg_success = "Protocolo(s) alterado(s) com sucesso";
	}else{		
		$msg_error = "Não foi possivel alterar o(s) protocolo(s)";
	}	

	if (!isset($_SESSION)) session_start();

	$_SESSION["protocolo_correcao_msg_success"] = $msg_success;
	$_SESSION["protocolo_correcao_msg_error"] = $msg_error;

	header("Location: ../protocolo-correcao.php");
	die();

?>