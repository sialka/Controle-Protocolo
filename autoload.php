<?php 
	/*
	*	AUTOLOAD.PHP	
	*	RESPONSAVEL POR CARREGAR AS CLASSES DO SISTEMA.
	*/

	define('WWW_ROOT', dirname(__FILE__));
	define('DS', DIRECTORY_SEPARATOR);

	function __autoload($class){

		$class = dirname(__FILE__) . DS . str_replace('\\',DS,$class).'.php';

		IF (!file_exists($class)){
			throw new Exception("Nao encontrei o arquivo '{$class}' no caminho indicado.");
		}

		require_once($class);
	}

?>	