<?php
	/*
	*  PROTOCOLOS-EDITAR.PHP
	*  VIEW - EDIÇÃO DE PROTOCOLO
	*/

	use controllers\ProtocoloController;
	use controllers\CidadeController;
	use controllers\MaquinaController;

	require_once("autoload.php");
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();

    // tratamento de erro - caso nao exista id retorna para lista    	
	if (!isset($_SESSION["protocolo_editar_msg_success"]) && !isset($_SESSION["protocolo_editar_msg_error"]))
	{				
		if (!isset($_POST["id"]))
		{
			header("Location: index.php");
			die();
		}	
	}

	// caso exista a sessoes
	if (!isset($_SESSION["protocolo_editar_msg_success"]) && !isset($_SESSION["protocolo_editar_msg_error"]))
	{			

		$id = $_POST['id'];	
		$protocoloController = new ProtocoloController();	
		$resultado = $protocoloController->BuscaId($id);

		$cidadeController = new CidadeController();	
		$cidades = $cidadeController->listaCidades();

		$maquinaController = new MaquinaController();	
		$maquinas = $maquinaController->listaMaquinas();

	}

	//var_dump($resultado);

	require_once("template/html-head.php"); 

?>  
	<main>

		<div class="row">		            
            <div class="col-md-12">
				<?php PageHeader("Protocolos") ?>
				<?php PageTitle("fa-pencil", "Editando Protocolo") ?>
      		</div>
     	</div>
  			
		<?php
			// caso exista a sessoes
			if (!isset($_SESSION["protocolo_editar_msg_success"]) && !isset($_SESSION["protocolo_editar_msg_error"])) 
			{
		?>
				<form class="form-horizontal" method="post" id="form" action="DAO/protocolo-sql-edita.php">
							
					<!-- Titulo -->
					<div class="row">						
						<h4><i class="fa fa-file-o"></i> Informações do Protocolo</h4>						
					</div>

					<!-- Id e Data -->
					<div class="row">																			
						<div class="col-sm-4">
							<div class="control-group">											 
								 <label class="" for="data">Data da Chancela <span class="vermelho">*</span></label>
								 <div class="input-group">							 	
								 	<span class="input-group-addon">									
										<i class="fa fa-calendar"></i>
									</span>												
									<input class="form-control" 
											id="data"
											name="data"
											type="text" 											
											pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" 
											title="dd/mm/aaaa" 											
											value= <?= $resultado->getData() ?>
											autofocus 
											required >
								</div>
								<div class="help-block vermelho"></div>
								<input type="hidden" name="id" value=<?= $id ?>>
							</div>
						</div>
					</div>
					
					<!-- Comarca e Vara -->
					<div class="row">							
						<!-- Comarca -->
						<div class="col-sm-4">									
							<div class="control-group">
								<label for="cidade">Comarca (Destino do Processo) <span class="vermelho">*</span></label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-map-marker"></i>
									</span>												
						    		<select class="form-control" 
						    				id="cidade" 
						    				name="cidade" 						    				
						    				required>									
											<?php
												foreach ($cidades as $cidade)
												{									  			
									  				if ($resultado->getCidadeId() == $cidade->getId())
									  				{
									  					echo '<option value='.$cidade->getId().' selected>'.$cidade->getNome().'</option>';
									  				}
									  				else
									  				{
									  					echo '<option value='.$cidade->getId().'>'.$cidade->getNome().'</option>';
									  				}
										  		}
										  	?>								  	
									</select>
								</div>
								<input type="hidden" id="cidade_bco" value= <?= $resultado->getCidadeId() ?>>
							</div>
						</div>
						<!-- Vara -->
						<div class="control-group">
							<div class="col-sm-4">
								<label class="" for="vara">Vara <span class="vermelho">*</span></label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-check"></i>
									</span>
									<input type="hidden" id="vara_bco" value= <?= $resultado->getVara() ?>>
									<select class="form-control" 
											name="vara" 
											id="vara" 											
											required>
				    				</select>	 								    			
									<select name="vara_qtd" 
											id="vara_qtd"
											disabled>
											<?php
												foreach ($cidades as $cidade)
												{
											  		if ($resultado->getVara()==$cidade->getVaras())
											  		{
											  			echo '<option selected>'.$cidade->getVaras().'</option>';
											  		}
											  		else
											  		{
											  			echo '<option>'.$cidade->getVaras().'</option>';
											  		}						  	
											  	}
										  	?>																												
									</select>												
								</div>
							</div>
						</div>
					</div>
					
					<!-- Processo, Chancela e Maquina -->
					<div class="row">
						<!-- Processo -->
						<div class="col-sm-4">
							<div class="control-group">
								<label class="" for="processo">Número do Processo <span class="vermelho">*</span></label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-file-text-o"></i>
									</span>									
									<input class="form-control" 
											id="processo" 
											name="processo"
											type="text" 
											placeholder="00000000000005020000"
											onkeydown="processoEnter(event)" 											
											pattern="\d{20}|(\d{4}\/\d{4})"										
											title="0000/0000 ou 00000000000005020000" 
											value= <?= $resultado->getProcesso() ?>
											required>
								</div>
							</div>
						</div>
						<!-- Chancela / Disabled -->
						<div class="col-sm-4">
							<label for="chancela">Chancela</label>								
							<div class="input-group">						
								<span class="input-group-addon">
									<i class="fa fa-tags"></i>
								</span>
								<input class="form-control"
										id="chancela" 
										name="chancela" 
										type="number" 
										placeholder="000000" 
										min=1
										max=999999										
										title="A chancela deve conter no max. 6 digitos númericos"
										size=6
										value= <?= $resultado->getChancela() ?>										
										readonly="readonly">
							</div>
						</div>
						<!-- Maquina / Disabled -->
						<div class="col-sm-4">
							<div class="control-group">									
								<label for="maquina">Maquina do Protocolo</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-barcode"></i>
									</span>												
									<select class="form-control" 
											name="maquina" 
											id="maquina" 										
											disabled>
											<?php
												foreach ($maquinas as $maquina)
												{
													if($resultado->getMaquinaId()==$maquina->getId())
													{
														echo '<option value='.$maquina->getId().' selected>'.$maquina->getNome().'</option>';
													}
													else
													{
														echo '<option value='.$maquina->getId().'>'.$maquina->getNome().'</option>';
													}
												}
											?>  	
									</select>
								</div>
								<input type="hidden" id="maquina_bco" value= <?= $resultado->getMaquinaId() ?>>
							</div>
						</div>
					</div>

					<!-- Titulo -->
					<div class="row">
						<h4><i class="fa fa-wrench"></i> Opções</h4>
					</div>

					<!-- Adicionais -->						
					<div class="row">
						<!-- Duplicar / 2ª impressao -->
						<div class="col-sm-4">
							<div class="control-group">										
								<label>Chancela</label>
								<div class="input-group">
									<span class="input-group-addon">
										<input type="checkbox" id="duplicar" name="duplicar">
									</span>
									<label class="form-control" for="duplicar">
										Duplicar Chancela
									</label>												
								</div>
								<input type="hidden" id="duplicado_bco" value= <?= $resultado->getDuplicado() ?>>
							</div>
						</div>
						<div class="col-sm-4">
							<label>Impressão</label>
								<div class="input-group">
									<span class="input-group-addon">									
										<input type="checkbox" id="impressao" name="impressao">
									</span>
									<label class="form-control" for="impressao">
										2ª Malote
									</label>												
								</div>
								<input type="hidden" id="impressao_bco" value= <?= $resultado->getImpressao() ?>>								
						</div>
					</div>

				    <!-- Botao Submit -->							    
				    <div class="row">
					    <div class="pager">
					    	<button type="submit" id="enviar" class="btn btn-success">
					    		<i class="fa fa-save"></i>
					    		Salvar Alterações
					    	</button>
							<a class="btn btn-danger" href="protocolos-lista.php">
								<i class="fa fa-arrow-left"></i>
								Cancelar
							</a>						    		
						</div>
					</div>														

				</form>  			

		<?php    		
			}
			else
			{						

				MensagenSucesso("protocolo_editar_msg_success");
				MensagenErro("protocolo_editar_msg_error");  

				echo '
					<div class="pager">
						<a href="protocolos-lista.php" class="btn btn-success">
							<i class="fa fa-arrow-left"></i>
							Voltar
						</a>
					</div>
					';
			}
		?>	    	

	</main>

<?php require_once("template/footer-custom-start.php"); ?>
<!-- Custom -->
<!--script src="config/js/protocolo-novo.js"></script--> 	

<script type="text/javascript">	

	/* Funcoes */
	function MaquinaPosicao()
	{
		$("#maquina_posicao").val($("#maquina").prop("selectedIndex"));		
	};

	function carrega_varas()
	{
		// Armazena a posicao da cidade selecinada		
		let item_cidade = $("#cidade").prop("selectedIndex");
		
		// Setando a na vara_qtd o total de varas
		$("#vara_qtd").prop("selectedIndex", item_cidade);

		// Zerando as Varas
		$("#vara").empty();

		// Adicionando as varas na qtd correta
		let varas = $("#vara_qtd").val();		
		if(varas==0)
		{	
			// Caso do TRT, Precatoria etc...
			$("#vara").append("<option>0</option>");			
			//$("#processo").focus();
		}
		else
		{
			for (i = 0; i < varas; i++)
			{
				$("#vara").append("<option>"+(i+1)+"</option>");
			}			
		}
	};
				
/* Eventos */

	// Data
	$( "#data" ).on( "keydown", function( event ) {
  		if(event.which == 13)
  		{			
			$("#msg").css("display","none");
			$("#cidade").focus();
  		}
	});

	// Cidade
	$( "#cidade" ).on( "keydown", function( event ) {
		if(event.which == 13)
		{
			carrega_varas();        
			$("#vara").focus();				
		}
	});
	
	$("#cidade").click(function() {
		carrega_varas();        
	});

	// Vara
	$( "#vara" ).on( "keydown", function( event ) {
		if(event.which == 13)
		{
			$("#processo").focus();				
			$("#processo").select();				
		}
	});

	// Processo
	$( "#processo" ).on( "keydown", function( event ) {
		if(event.which == 13) $("#maquina").focus();						
	});

	// Maquina
	$( "#maquina" ).on( "keydown", function( event ) {
		if(event.which == 13)
		{
			MaquinaPosicao();
			$("#chancela").select();	
			$("#chancela").focus();
		}
	});
	
	// Chancela
	$( "#chancela" ).on( "keydown", function( event ) {	
		if(event.which == 13) $("#enviar").focus();					
	});

	/* 2ª Parte */

	$(function() {    
	    
	    $("#form input,#form textarea").jqBootstrapValidation({
	        preventSubmit: true,
	        submitError: function($form, event, errors) {
	            // additional error messages or events            
	        },
	        submitSuccess: function($form, event) {            
	        },
	        filter: function() {            
	            return $(this).is(":visible");
	        },
	    });	    

	    $("a[data-toggle=\"tab\"]").click(function(e) {
	        
	        e.preventDefault();
	        $(this).tab("show");
	    });
	});

	// Preparando Formulario	
	$("#vara_qtd").css("display","none");
	carrega_varas();

	// Apontando para a cidade correta
	//var cidadeBco = document.getElementById("cidade_bco").value;
	//var cidade = document.getElementById("cidade");		
	//cidade.value = cidadeBco;

	// Apontando para a VARA
	$("#vara").prop("selectedIndex", $("#vara_bco").val()-1);

	// Apontamento para a MAQUINA
	$("#maquina").val($("#maquina_bco").val());

	// CHECK - Chancela duplicada
	if ($("#duplicado_bco").val()==1)
	{		
		$("#duplicar").prop("checked",true);
	}
	else
	{			
		$("#duplicar").prop("checked",false);
	}

	// CHECK - 2ª Malote		
	if ($("#impressao_bco").val()==1)
	{
		$("#impressao").prop("checked", true);
	}
	else
	{
		$("#impressao").prop("checked", false);
	}

    </script>

</script>

<?php require_once("template/footer-custom-end.php"); ?>
	