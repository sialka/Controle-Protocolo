<?php
	/*
	*	PROTOCOLOS-IMPRESSAO.PHP
	*	VIEW - RELATORIO DE IMPRESSÃO
	*/
	
	use controllers\ProtocoloController;

	require_once("autoload.php");
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();

	// Carrega o restante da pagina.
	require_once("template/html-head.php");
?>

	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Protocolos") ?>
			<?php PageTitle("fa-pencil", "Impressão de Relatórios") ?>
  		</div>
 	</div>

	<?php
		$mostrarBtnImprimir = 0;
		
		if (isset($_POST['enviar']))
		{

			require_once("/DAO/protocolo-sql-print.php");

			MensagenSucesso("protocolo_print_msg_success");
			MensagenErro("protocolo_print_msg_error");    

			if (file_exists("impressao.txt"))
			{												
				echo '<iframe id="textfile" src="impressao.txt"></iframe>';				
				$mostrarBtnImprimir = 1;									
			}		        			
		    
			
			# JÁ HOUVE UM POST

			# Data
			$data_formatada = $_POST['data'];
			
			# Cidade
			if($_POST["cidade"]=="true")
			{		        				
				//echo '<input type="text" id="escolha" value=0>';
				$tipo_pesquisa = 0;
			}
			else
			{
				//echo '<input type="text" id="escolha" value=1>';		        				
				$tipo_pesquisa = 1;
			}

			# Impressao
			if(isset($_POST["impressao"]))
			{
				$impressao = 'checked';
			}
			else
			{
				$impressao = 'unchecked';
			}

		}
		else
		{

			# Pega data do sistema
			$data_formatada = date("d/m/Y");					
			$tipo_pesquisa = 0;
			$impressao = 'unchecked';
		}
	?>

	<!--form class="form-horizontal" method="post" action="protocolo-print.php"-->
	<form class="form-horizontal" method="post">
		
		<div class="row">
			<h4><i class="fa fa-database"></i> Data do Recebimento</h4>
		</div>
			
		<!-- Data -->
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">								
					<label>Informe a data do protocolo <span class="vermelho">*</span></label>							
					<div class="input-group">								
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>									
						<input class="form-control c50" 
								id="data" 
								name="data" 
								type="text" 
								placeholder="00/00/0000" 
								value='<?= $data_formatada ?>'
								pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}"
								autofocus 
								required>
					</div>	
				</div>
			</div>
		</div>

		<!-- Capital -->
		<div class="row">
			<h4><i class="fa fa-map-marker"></i> Região</h4>
			<div class="col-sm-5">
				<div class="form-group">								
					<div class="input-group">
						<span class="input-group-addon">
							
							<?php
							
							if ($tipo_pesquisa ==0)
							{
								echo '<input type="radio" id="cidade1" name="cidade" value=true checked>';
							}
							else
							{
								echo '<input type="radio" id="cidade1" name="cidade" value=true>';	
							}

							?>

						</span>						
						<label for="cidade1" class="form-control">
							São Paulo (Capital)
						</label>
					</div>
				</div>
			</div>
		</div>

		<!-- Grande SPaulo -->						
		<div class="row">
			<div class="col-sm-5">
				<div class="form-group">								
					<div class="input-group">
						<span class="input-group-addon">
						<?php
	    					if ($tipo_pesquisa == 1)
	    					{
	    						echo '<input type="radio" id="cidade2" name="cidade" value=false checked>';
	    					}
	    					else
	    					{
	    						echo '<input type="radio" id="cidade2" name="cidade" value=false>';	
	    					}
	    				?>
	    				</span>
	    				<label for="cidade2" class="form-control">
	    					Grande São Paulo e Baixada Santista
	    				</label>							    		
	    			</div>	
		    	</div>
	    	</div>
	    </div>

		<!-- 2ª impressão -->   
		<div class="row">
			<h4><i class="fa fa-tags"></i> Malote</h4>
			<div class="col-sm-5">
				<div class="form-group">								
					<div class="input-group">
						<span class="input-group-addon">											
							<input type="checkbox" id="check_impressao" name="impressao" <?=$impressao?>>
						</span>
						<label for="check_impressao" class="form-control">
							2ª Malote
						</label>							    		
					</div>
	    		</div>
    		</div>
    	</div>

	    <div class="row">
		    <div class="pager">
		    	
		    	<button type="submit" name="enviar" id="enviar" class="btn btn-info" autofocus>
		    		<i class="fa fa-print"></i>
		    		Gerar Impressão
		    	</button>							
		    	
				<?php								
					if ($mostrarBtnImprimir)
					{ 									
						echo '
						<a class="btn btn-success" onclick="print()">
							<i class="fa fa-print"></i>
							Imprimir
						</a>';
					}
				?>
				<a class="btn btn-danger" href="index.php">
					<i class="fa fa-arrow-left"></i>
					Voltar
				</a>
			</div>
		</div>

	</form>			

<?php require_once("template/footer-custom-start.php"); ?>
<script type="text/javascript">	

	/* Funções */
	function print()
	{
		var iframe = document.getElementById('textfile');
		iframe.contentWindow.print();
	}

</script>
<?php require_once("template/footer-custom-end.php"); ?>