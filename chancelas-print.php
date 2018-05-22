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

	# Gerando o preview

    if (!isset($_POST['mes']))
    {
		header("Location: chancelas-lista.php");
		die();
    }

	$linha = "";

	$chancela = new ChancelaModel();
	$chancela->setMes($_POST["mes"]);
	$chancela->setAno($_POST["ano"]);
	$chancela->setMaquinaId($_POST["maquina"]);		

	$chancelaController = new ChancelaController();
	$chancelas = $chancelaController->listaChancelas($chancela);

	$totalgeral = 0;
	foreach ($chancelas as $chancela){
		$data = $chancela->getData();
		$nome = $chancela->getMaquinaId();
		$inicio = number_format($chancela->getInicio(),0,".",".");
		$final = number_format($chancela->getFinal(),0,".",".");
		$total = number_format(($chancela->getFinal() - $chancela->getInicio()+1),0,".",".");
		$totalgeral = $totalgeral+(($chancela->getFinal() - $chancela->getInicio())+1);
		

		$linha = $linha.
				$data.str_repeat(" ", 5).
				$nome.str_repeat(" ", 8-strlen($nome)).
				str_repeat(" ", 10-strlen($inicio)).$inicio.
				str_repeat(" ", 10-strlen($final)).$final.
				str_repeat(" ", 10-strlen($total)).$total."\n";
				
	}		

	
	$cab_titulo = "POSTO AVANCADO TRT SAO PAULO - 02ª REGIAO\n";
	$cab_subtitulo = "PROTOCOLO INTEGRADO - CAPITAL\n";
	$cab_posto = "CASA DA ADVOCACIA E DA CIDADANIA - TRABALHISTA\n";
	$cab_end = "Avenida Ipiranga, 1.267 - 3ª andar - República\n\n";
	$titulo1 = "RELATORIO MENSAL - PROTOCOLO TRT 2ª REGIÃO\n\n";
	$titulo = str_repeat(" ", 40-strlen($titulo1)/2).$titulo1;	
	$tabela1 = "DATA           MAQUINA        NUMERADOR        TOTAL\n";	
	$tabela2 = "                           INICIAL   FINAL\n\n";
			  //00/00/0000   P08      000000  000000  000000
	$rodape = "TOTAL: ";
	
	$arquivo = $cab_titulo;
	$arquivo .= $cab_subtitulo;
	$arquivo .= $cab_posto;
	$arquivo .= $cab_end;
	$arquivo .= $titulo;
	$arquivo .= $tabela1;
	$arquivo .= $tabela2;

	$arquivo .= $linha;

	$arquivo .= "\n\n";
	$arquivo .= str_repeat(" ", 40).$rodape.number_format($totalgeral,0,".",".");

	if (file_exists("impressao3.txt")) {
		unlink("impressao3.txt");		
	}

	$fp = fopen("impressao3.txt", "a");
	$escreve = fwrite($fp, $arquivo);
	fclose($fp); //-> OK

	//require_once("model/conecta.php"); 
	require_once("template/html-head.php");
?>
	
	<!-- Ajuste -->
	<link href="html/css/cp2-listas.css" rel="stylesheet">
	<style type="text/css">
		iframe{	    
		    display: block;
		    border: 1px solid #c2c2a3;
		    border-radius: 4px;
		    width: 100%;
		    height: 40em;
		    background-color: #ffffe6;
		    margin: 0 auto;*/
		}
		.janela{        
		    padding: 0 4rem;
		    width: 80%;
		    margin: 0 auto;   
		}		
	</style>
</head>
<body>   	

	<?php require_once("template/html-menu.php"); ?>	

	<!-- HTML  -->
	<div id="page-wrapper">

		<main>

			<div class="row">		            
	            <div class="col-md-12">
					<?php PageHeader("Impressão") ?>
					<?php PageTitle("fa-search", "Preview - Resultado da Pesquisa de Protocolos") ?>
	      		</div>
	     	</div>			

			<div class="row">
				<div class="janela">
					<iframe class="frame" id="textfile" src="impressao3.txt"></iframe>
				</div>
			</div>

			<div class="row">
				<div class="pager">
					<button class="btn btn-primary" onclick="print()">
						<i class="fa fa-print"></i>
						Imprimir
					</button>
					<a class='btn btn-primary' href='chancelas-lista.php'>
						<i class='fa fa-arrow-left'></i>
						Voltar
					</a>
				</div>
			</div>					

    	</main>

    	<?php require_once("template/footer.php"); ?>

	</div><!-- Page-wrapper -->		

    <!-- jQuery -->
    <script src="html/js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="html/js/bootstrap.min.js"></script>    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="html/js/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="html/js/sb-admin-2.js"></script>	

	<script type="text/javascript">
		function print() {
			var iframe = document.getElementById('textfile');
			iframe.contentWindow.print();
		}
	</script>

</body>

</html>