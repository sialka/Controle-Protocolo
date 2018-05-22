 	<?php
	/*
	*	PROTOCOLOS-LISTA-IMPRESSAO.PHP
	*	VIEW - PREVIEW DE PESQUISA DE IMPRESSÃO
	*/

	
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();    

	# Gerando o preview

    /*
    if (!isset($_POST['mes'])) {
		header("Location: chancelas-lista.php");
		die();
    }
    */

	
	//require_once("model/conecta.php"); 
	require_once("template/html-head.php");
?>
<!--
iframe
{       
    display: block;
    border: 1px solid #c2c2a3;
    border-radius: 4px;
    width: 100%;
    height: 40em;
    background-color: #ffffe6;
    margin: 0 auto;
}
.janela
{        
    padding: 0 4rem;
    width: 80%;
    margin: 0 auto;   
}       
-->
<main>
	
	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Protocolos") ?>
			<?php PageTitle("fa-print", "Preview de Impressão") ?>
  		</div>
 	</div>

	<div class="row">
		<div class="janela"
			style="
		    padding: 0 4rem;
		    width: 80%;
    		margin: 0 auto;">
			<iframe style="
					display: block;
					border: 1px solid #c2c2a3;
				    border-radius: 4px;
				    width: 100%;
				    height: 40em;
				    background-color: #ffffe6;
				    margin: 0 auto;"
				    id="textfile" src="impressao-individual.txt"></iframe>
		</div>
	</div>

	<div class="row">
		<div class="pager">
			<button class="btn btn-success" onclick="print()">
				<i class="fa fa-print"></i>
				Imprimir
			</button>
			<a class='btn btn-danger' href='protocolos-lista.php'>
				<i class='fa fa-arrow-left'></i>
				Cancelar
			</a>
		</div>
	</div>	  	

</main>

<?php require_once("template/footer-custom-start.php"); ?>
<script type="text/javascript">	

/* Funcoes */
function print()
{
	var iframe = document.getElementById('textfile');
	iframe.contentWindow.print();
}

</script>
<?php require_once("template/footer-custom-end.php"); ?>