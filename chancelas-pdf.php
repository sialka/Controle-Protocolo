<?php
	/*
	*	CHANCELAS-PRINT.PHP
	*	VIEW - PREVIEW DE RELATÓRIO 
	*/
	
	
	use controllers\MaquinaController;
	use controllers\ChancelaController;
	use model\ChancelaModel;
	
	require_once("autoload.php");
	require_once("lib-v1.php");
	
    # Verifica se o usuario está logado
    Esta_logado();    

	if (!isset($_POST['mes'])) 
	{
		header("Location: chancelas-lista.php");
		die();
    }

	$linha = '';

	$chancela = new ChancelaModel();
	$chancela->setMes($_POST["mes"]);
	$chancela->setAno($_POST["ano"]);
	$chancela->setMaquinaId($_POST["maquina"]);		

	$chancelaController = new ChancelaController();
	$chancelas = $chancelaController->listaChancelas($chancela);

	$totalgeral = 0;
	foreach ($chancelas as $chancela)
	{
		
		$data = $chancela->getData();
		$nome = $chancela->getMaquinaId();
		$inicio = number_format($chancela->getInicio(),0,".",".");
		$final = number_format($chancela->getFinal(),0,".",".");
		$total = number_format(($chancela->getFinal() - $chancela->getInicio()+1),0,".",".");
		$totalgeral = $totalgeral+(($chancela->getFinal() - $chancela->getInicio())+1);

		/*
		$linha = $linha.
				$data.str_repeat(" ", 5).
				$nome.str_repeat(" ", 8-strlen($nome)).
				str_repeat(" ", 10-strlen($inicio)).$inicio.
				str_repeat(" ", 10-strlen($final)).$final.
				str_repeat(" ", 10-strlen($total)).$total."; \n";				
		*/

		$linha = $linha.
				$data.';'.
				$nome.';'.
				$inicio.';'.
				$final.';'.
				$total."\n";
		
		
	}		
	
	if (file_exists("pdf.txt")) {
		unlink("pdf.txt");		
	}	
	
	$fp = fopen("pdf.txt", "w");
	$escreve = fwrite($fp, $linha);
	fclose($fp);

	header("Location: pdf.php");
	die();	
		
?>
