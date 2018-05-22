<?php
	/*
	*	CHANCELAS-NOVO.PHP
	*	VIEW - ADICIONA NOVAS CHANCELAS
	*/
	
	use controllers\MaquinaController;
	use controllers\ChancelaController;
	
	require_once("autoload.php");
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();	
	
	// Carregando os nomes das Máquinas do Protocolo
	$maquinaController = new MaquinaController();
	$maquinas = $maquinaController->listaMaquinas();	

	$chancelaController = new ChancelaController();
	
	// Carregando as ultimas chancelas do banco
	$ultima_chancela = array();	
	$i=0;			
	
	while($i < count($maquinas))
	{		
		// Buscando do banco o array com a ultima chancela		
		$uchancela = $chancelaController->ultimaChancela($maquinas[$i]->getId());

		array_push($ultima_chancela, $uchancela);
		$i++;
	}

	require_once("template/html-head.php");

?>

	<div class="row">		            
	    <div class="col-md-12">
			<?php PageHeader("Chancelas") ?>
			<?php PageTitle("fa-bar-chart-o", "Estatística de Chancelas") ?>			
		</div>
	</div>			

	<?php				
		MensagenSucesso("chancela_novo_msg_success");
		MensagenErro("chancela_novo_msg_error");    
	?>

	<form method="POST" action="DAO/chancelas-sql-novo.php" id="form" autocomplete="off">
					
		<!-- Data -->
		<div class="row">
			<h4><i class="fa fa-tags"></i> Seleção de Chancela</h4>
		</div>

		<div class="row">
			<div class="col-md-6">
				<label for="data">Data da Chancela <span class="vermelho">*</span></label>	
				<div class="form-group input-group">
					<span class="input-group-addon">
						<i class="fa fa-calendar-o"></i>
					</span>
					<input class="form-control" id="data"
						name="data"
						type="date"
						id="data"
						pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" 
						title="dd/mm/aaaa"
						placeholder="Digite a data"						
						autofocus
						required >
				</div>
			</div>
		</div>

		<!-- Maquina -->
		<div class="row">
			<div class="col-md-6">
				<label for="maquinaId">Máquina <span class="vermelho">*</span></label>
				<div class="form-group input-group">
				 	<span class="input-group-addon">									
						<i class="fa fa-barcode"></i>
					</span>										
					<select class="form-control"
							name="maquinaId"
							id="maquinaId" 							
							oninput="buscaUtimaChancela()"
							required>
						<?php foreach ($maquinas as $maquina) : ?>
							<option value=<?= $maquina->getId() ?>><?= $maquina->getNome() ?></option>
						<?php endforeach ?>  	
					</select>
					
					<!-- ultimas chancelas / oculto -->
					<select class="form-control"
							name="ultimaChancela"
							id="ultimaChancela">												
						<?php 
							foreach ($ultima_chancela as $maquina)
							{ 
						?>
							<option value=<?= $maquina ?>><?= $maquina ?></option>
						
						<?php
							}
						?>  	
					</select>								
				</div>
			</div>
		</div>
					
		<div class="row">
			<h4><i class="fa fa-edit"></i> Cadastro de Chancelas</h4>
			<div class="col-md-4">

				<!-- Chancela Inicial -->
				<label for="chancelaInicial">Chancela Inicial</label>
				<div class="form-group input-group">
					<span class="input-group-addon">
						<i class="fa fa-check-circle"></i>
					</span>
					<input class="form-control"
							type="text" 
							name="chancelaInicial"
							id="chancelaInicial" 
							value="-"
							readonly="readonly">
				</div>								
			</div>
			<div class="col-md-4">

				<!-- Chancela Final -->
				<label for="chancelaFinal">Chancela Final <span class="vermelho">*</span></label>
				<div class="form-group input-group">
					<span class="input-group-addon">
						<i class="fa fa-check-circle"></i>
					</span>
					<input class="form-control"
							type="text"
							name="chancelaFinal" 
							id="chancelaFinal" 
							placeholder="Digite o chancela final" 							
							onchange="Total()"
							required>									
				</div>
				<div id="erroChancelaFinal" class="help-block text-error-align vermelho">chancela inválida</div>
			</div>
			<div class="col-md-4">

				<!-- Chancela Total -->
				<label for="total">Total</span></label>
				<div class="form-group input-group">
					<span class="input-group-addon">
						<i class="fa fa-check-circle"></i>
					</span>
					<input class="form-control"
							type="text" 
							name="total"
							id="total" 
							value="0"
							readonly="readonly">
				</div>
			</div>
		</div>

		<!-- Botão Salvar -->
		<div class="row">
			<div class="pager">
				<button class="btn btn-success"
						type="submit" 
						id="submit" disabled>
					<i class="fa fa-save"></i>
					Gravar Chancela
				</button>
				<a class="btn btn-danger" href="index.php">
					<i class="fa fa-arrow-left"></i>
					Cancelar
				</a>
			</div>
		</div>

	</form>

<!-- Carregando o rodape -->
<?php require_once("template/footer-custom-start.php"); ?>

<script type="text/javascript">	
	
	// Formatando a Data
	let data = new Date();
	let dataFormatada = ("0" + data.getDate()).substr(-2) + "/" + ("0" + (data.getMonth() + 1)).substr(-2) + "/" + data.getFullYear();
	
	$("#data").val(dataFormatada);
	
	buscaUtimaChancela();
	
	$("#data").focus();		

	// Desativo mensagem de erro e combo com os ultimos valores
	$("#erroChancelaFinal").css("display","none");
	$("#ultimaChancela").css("display","none");


	//Teclar Enter no input chancela_Inicial
	function Total()
	{	
			limpaMensagem();		

			//verificação de dados
			if (isNaN(parseInt($("#chancelaFinal").val())))
			{			
				$("#chancelaFinal").val("0");
				totalDia = "0";
				$("$chancelaFinal").focus();
				return;
			}
			else
			{

				let total = (parseInt($("#chancelaFinal").val()) - parseInt($("#chancelaInicial").val()))+1;
				
				if (total > 0)
				{	
					$("#erroChancelaFinal").css("display","none");					
					$("#total").val(total);					
					$("#submit").prop("disabled",false);
				}
				else
				{
					$("#erroChancelaFinal").css("display","inline");
					
					$("#chancelaFinal").val("0");
					$("#total").val("0");
					$("#chancelaFinal").focus();
					$("#submit").prop("disabled",true);					
				}
			}			
			
	};
	
	function buscaUtimaChancela()
	{		
		/*
		* Seleciona a última cancela do combo e soma + 1
		*/
		
		let MaquinaSelecionada = $("#maquinaId").prop("selectedIndex");
		$("#ultimaChancela").prop("selectedIndex", MaquinaSelecionada);

		let valor = Number($("#ultimaChancela").val()) + 1;
		$("#chancelaInicial").val(valor);			
		
		$("#chancelaFinal").focus();

	};

	function limpaMensagem()
	{                       
	    if (document.getElementById("msg")!=null)
	    {               
	        $("#msg").css("display","none");
	    }    
	};

</script>
<?php require_once("template/footer-custom-end.php"); ?>