<?php
	/*
	*  PROTOCOLOS-NOVO.PHP
	*  VIEW - ADIÇÃO DE NOVO PROTOCOLO
	*/		
	
	use controllers\CidadeController;
	use controllers\MaquinaController;
	use controllers\ProtocoloController;
	use model\ProtocoloModel;

	require_once("autoload.php");
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();	

    # Coletando Cidades.
    $cidadeController = new CidadeController();
	$cidades = $cidadeController->listaCidades();

	# Coletando Maquinas.
	$maquinaController = new MaquinaController();
	$maquinas = $maquinaController->listaMaquinas();	

	# Localizando Id da Comarca de São Paulo, p/ selecionar como 1ª
	$p=0;
	$spid = 0;
	foreach ($cidades as $cidade)
	{
		if($cidade->getNome() == "SAO PAULO")
		{
			$spid = $p;
		}
		else
		{
			$p++;
		}		
	}

	$hoje = date("d/m/Y");

	# Volta do Resquest
	if (isset($_REQUEST['enviar']))
	{
		
		isset($_POST['duplicar']) ? $duplicado = 1 : $duplicado = 0;		
		isset($_POST['impressao']) ? $impressao = 1 : $impressao = 0;		

		require_once("DAO/protocolo-sql-novo.php");

		$procData = $_POST['data'];
		$procCidade = $_POST['cidade'];
		$procVara = $_POST['vara'];

		$procMaquinaPos = $_POST['maquina_posicao'];

		$msg = true;

		// Caso o protocolo foi salvo
		if ($resultado)
		{
			$procProcesso = "0";
			$procChancela = "0";
			$duplicado = 0; 
		}
		else
		{			
			$procProcesso = $_POST['processo'];
			$procChancela = $_POST['chancela'];
			$procMaquina = $_POST['maquina'];
		}

	}
	else
	{

		# Ainda não houve post

		$msg = false;
		$procData = $hoje;
		$procCidade = 1; // id de São Paulo
		$procVara = 1; // 1 vara de São paulo
		$procProcesso = "0";
		$procChancela = "0";
		$procMaquinaPos = 0; // Posicao 0 P08
		$duplicado = 0;	
		$impressao = 0;	

	}

	#echo $procCidade.'<br>';
	#echo $procVara.'<br>';
	#echo $procMaquina.'<br>';
	#echo $procMaquinaPos.'<br>';
	require_once("template/html-head.php");
?>

        
			<div class="row">		            
	            <div class="col-md-12">
					<?php PageHeader("Protocolos") ?>
					<?php PageTitle("fa-pencil", "Cadastro de Protocolo") ?>
	      		</div>
	     	</div>	

			<?php			      		
				if ($msg)
				{			      			
					$msg = false;
					if ($resultado)
					{
						echo '
							<div id="msg" class="alert alert-success text-center">
								<i class="fa fa-check"></i>
								A chancela nº <strong>'.$_POST['chancela'].' - '. localizaNomePorId($maquinas, $_POST['maquina']).'</strong> foi cadastrada com sucesso.</p>
							</div>
						';
					}
					else
					{
						echo '
							<div id="msg" class="alert alert-danger text-center">
							<i class="fa fa-times"></i>
								A chancela nº <strong>'.$_POST['chancela'].' - '. localizaNomePorId($maquinas, $_POST['maquina']).'</strong> já está cadastrada.
							</div>
						';			      				
					}
				}
			?>
			
			<form class="form-horizontal" method="post" id="form" autocomplete="off" role="form">
			
				<!-- Titulo -->
				<div class="row">					
					<h4><i class="fa fa-file-o"></i> Informações do Protocolo</h4>					
				</div>
				
				<!-- Data -->			
				<div class="row">			
					<div class="col-md-4">	
						<div class="control-group">	
							<label for="data">Data da Chancela <span class="vermelho">*</span></label>
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
										value=<?=$procData?>
										required >
							</div>								
							<div class="help-block vermelho"></div>							
						</div>	
					</div>						
				</div><!-- row -->
						
				<!-- Comarcas - Varas -->
				<div class="row">					
					<!-- Comarca -->
					<div class="control-group">
						<div class="col-sm-4">
							<label for="cidade">Comarca (Destino do Processo) <span class="vermelho">*</span></label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-map-marker"></i>
								</span>
								<select class="form-control" 
										id="cidade" 
										name="cidade" 											
										oninput="carrega_varas()" 
										required>									
										<?php
											foreach ($cidades as $cidade)
											{														
												if ($cidade->getId()==$procCidade)
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
							<!-- Identificando São Paulo -->
							<input type="hidden" id="spid" value=<?= $procCidade ?>>
						</div>
					</div>					
					<!-- Vara -->
					<div class="control-group">
						<div class="col-sm-4">
							<label for="vara">Vara <span class="vermelho">*</span></label>
							<input type="hidden" id="vara_sel" value= <?= $procVara ?>>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-check"></i>
								</span>
								<select class="form-control" 
										name="vara" 
										id="vara" 											
										required>											
								</select>	 
								<!-- Oculto -->
								<select name="vara_qtd" 
										id="vara_qtd" 
										disabled>
									<?php
										foreach ($cidades as $cidade)
										{
											echo '<option>'.$cidade->getVaras().'</option>';											
										}
									?>  	
								</select>
							</div>												
						</div>
					</div>								
				</div><!-- row -->

				<!-- Processo, Máquina, Chancela -->
				<div class="row">
					<!-- Processo -->													
					<div class="control-group">
						<div class="col-sm-4">
							<label for="processo" >Número do Processo <span class="vermelho">*</span></label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-file-text-o"></i>
								</span>									
								<input class="form-control" 
										id="processo" 
										name="processo"
										type="processo" 
										placeholder="00000000000005020000"											
										pattern="\d{20}|(\d{4}\/\d{4})"										
										title="0000/0000 ou 00000000000005020000" 
										value=<?=$procProcesso?>
										required>
							</div>
							<div class="help-block text-error-align vermelho"></div>
						</div>
					</div>
					<!-- Maquina -->		
					<div class="control-group">				
						<div class="col-sm-4">
							<label for="maquina">Máquina <span class="vermelho">*</span></label>
							<div class="input-group col-sm-12">
								<span class="input-group-addon">
									<i class="fa fa-barcode"></i>
								</span>								
								<select class="form-control" 
										name="maquina" 
										id="maquina" 											
										oninput="MaquinaPosicao()"
										required>
										<?php
											foreach ($maquinas as $maquina)
											{
												echo '<option value='.$maquina->getId().'>'.$maquina->getNome().'</option>';
											}
										?>  	
								</select>
								<!-- Oculto -->										
								<input type="hidden" id="maquina_posicao" name="maquina_posicao" value= <?= $procMaquinaPos ?>>
							</div>
						</div>
					</div>
					<!-- Chancela -->						
					<div class="control-group">
						<div class="col-sm-4">
							<div class="control-group">
								<label for="chancela">Chancela <span class="vermelho">*</span></label>
								<div class="input-group">						
									<span class="input-group-addon">
										<i class="fa fa-tag"></i>
									</span>
									<input class="form-control"
											id="chancela" 
											name="chancela" 
											type="number" 
											placeholder="00000" 
											min=1
											max=99999
											title="A chancela deve conter no max. 6 digitos númericos"
											size=6
											value=<?=$procChancela?>
											required>								
								</div>
								<div class="help-block text-error-align vermelho"></div>
							</div>
						</div>
					</div>				
				</div><!-- row -->

				<!-- Titulo -->
				<div class="row">
					<h4><i class="fa fa-wrench"></i> Opções</h4>
				</div>

				<!-- Duplicar - 2ª Malote -->
				<div class="row">
					<div class="control-group">	
						<!-- Duplicar -->						
						<div class="col-sm-4">
							<!--label>Chancela</label-->
							<div class="input-group">
								<span class="input-group-addon">
									<?php
										if($duplicado)
										{
											echo '<input type="checkbox" id="duplicar" name="duplicar" checked>';
										}
										else
										{
											echo '<input type="checkbox" id="duplicar" name="duplicar">';
										}											
									?>
								</span>
								<label class="form-control" for="duplicar">
									Duplicar Chancela
								</label>
							</div>
						</div>
						<!-- 2ª Malote -->
						<div class="col-sm-4">							
							<!--label>Malote</label-->
							<div class="input-group">
								<span class="input-group-addon">									
									<?php
										if($impressao)
										{
											echo '<input type="checkbox" id="impressao" name="impressao" checked>';
										}
										else
										{
											echo '<input type="checkbox" id="impressao" name="impressao">';
										}
									?>
								</span>
								<label class="form-control" for="impressao">
									2ª Malote
								</label>								
							</div>
						</div>
					</div>
				</div>

			    <!-- Botao Submit -->							    
			    <div class="row">
				    <div class="pager">
				    	<button type="submit" name="enviar" id="enviar" class="btn btn-success">
				    		<i class="fa fa-save"></i>
				    		Gravar Protocolo
				    	</button>
						<a class="btn btn-danger" href="index.php">
							<i class="fa fa-arrow-left"></i>
							Cancelar
						</a>						    	
					</div>								
				</div>						

			</form>  			    		


<?php require_once("template/footer-custom-start.php"); ?>
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
			$("#processo").focus();
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

	carrega_varas();

	// Escondendo 
	$("#vara_qtd").css("display","none");

	// Seta a Vara usada no último Post
	$("#vara").prop("selectedIndex", $("#vara_sel").val()-1);

	// Seta a Máquina usada no último Post
	$("#maquina").prop("selectedIndex", $("#maquina_posicao").val());
	
	// Atualiza a última posição da Máquina de Protocolo
	MaquinaPosicao();

	// Na volta do post aponta para cidade
	if ($("#msg").css("display") == "block")
	{	
		$("#cidade").focus();				
	}
	else
	{
		$("#data").focus();		
	}
</script>

<?php require_once("template/footer-custom-end.php"); ?>