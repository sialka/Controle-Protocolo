<?php
	/*
	*	PROTOCOLO-SQL-NOVO.PHP
	*	Insere um novo protocolo.
	*/

	$protocoloController = new \controllers\ProtocoloController();
	
	$protocolo = new \model\ProtocoloModel();
	$protocolo->setData($_POST['data']);
	$protocolo->setCidadeId($_POST['cidade']);
	$protocolo->setVara($_POST['vara']);
	$protocolo->setProcesso($_POST['processo']);
	$protocolo->setChancela($_POST['chancela']);
	$protocolo->setMaquinaId($_POST['maquina']);
	$protocolo->setDuplicado($duplicado);
	$protocolo->setImpressao($impressao);
	$protocolo->setUsuarioId($_SESSION["usuario_id"]);
	$protocolo->setDigitacao($hoje);

	$resultado = $protocoloController->insereProtocolo($protocolo);

?>