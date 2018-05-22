<?php
	/*
	*	CHANCELAS-LISTA.PHP
	*	VIEW - LISTA AS CHANCELAS
	*/

	use controllers\MaquinaController;
	use controllers\ChancelaController;
	use model\ChancelaModel;
	
	require_once("autoload.php");
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();        

	# Carregando os nomes das Máquinas do Protocolo
	$maquinasController = new MaquinaController();
	$maquinas = $maquinasController->listaMaquinas();

    require_once("template/html-head.php");

?>

	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Chancelas") ?>
			<?php PageTitle("fa-search", "Relatório Mensal") ?>
  		</div>
 	</div>	

	<?php				
		// Mensagens da ação de Excluir cidades
		MensagenSucesso("chancela_remove_msg_success");
		MensagenErro("chancela_remove_msg_error");    
	?>		        		

	<form method="post" action="chancelas-lista.php">					
		
		
		<div class="row">
			<h4><i class="fa fa-tags"></i> Filtro para Gerar o Relatório</h4>
		</div>
		
		
		<div class="row">
			
			<!-- Mes -->	
			<div class="col-md-4">

				<label for="mes">Mês <span class="vermelho">*</span></label>
			
				<div class="form-group input-group">				
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>									
					<select class="form-control"
							name="mes"
							id="mes"							
							autofocus>
						<option value=1>Janeiro</option>
						<option value=2>Fevereiro</option>
						<option value=3>Março</option>
						<option value=4>Abril</option>
						<option value=5>Maio</option>
						<option value=6>Junho</option>
						<option value=7>Julho</option>
						<option value=8>Agosto</option>
						<option value=9>Setembro</option>
						<option value=10>Outubro</option>
						<option value=11>Novembro</option>
						<option value=12>Dezembro</option>
					</select>									
				</div>
				<?php
					# Reposicionando a escolha na volta do submit
					if (isset($_POST['mes']))
					{
						$mes = $_POST['mes'];										
						echo
						'
							<input type="hidden" id="mes_selecionado" value='.$mes.'>
						';
					}
				?>
			</div>
		
			<!-- Ano -->
			<div class="col-md-4">
				<label for="ano">Ano <span class="vermelho">*</span></label>
				<div class="form-group input-group">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input class="form-control"
							id="ano"
							name="ano" 
							type="number"							
							requered>
				</div>
				<?php
					# Reposicionando a escolha na volta do submit
					if (isset($_POST['ano']))
					{
						$ano = $_POST['ano'];										
						echo
						'
						<input type="hidden" id="ano_selecionado" value='.$ano.'>
						';
					}
				?>								
			</div>

			<!-- Maquina -->
			<div class="col-md-4">
				<label for="maquina">Máquina <span class="vermelho">*</span></label>
				<div class="form-group input-group">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<select class="form-control"
							name="maquina"
							id="maquina"											
							required>
						<?php
							foreach ($maquinas as $maquina)
							{ 
								echo '
									<option value='.$maquina->getId().'>'.
									$maquina->getNome().
									'</option>';
							}
						?>  	
					</select>
				</div>						
				<?php
					# Reposicionando a escolha na volta do submit
					if (isset($_POST['maquina']))
					{
						$maquina = $_POST['maquina'];										
						echo '
						<input type="hidden" id="maquina_selecionada" value='.$maquina.'>
						';
					}
				?>
			</div>

		</div>					

	    <div class="row">
		    <div class="pager">
		    	<button type="submit" name="submit" id="enviar" class="btn btn-info" autofocus>
		    		<i class="fa fa-search"></i>
		    		Gerar Relatório
		    	</button>
			</div>
		</div>

	</form>

	<!-- parte 2 -->
	<div class="row">
		
		<h4><i class="fa fa-database"></i> Resultado da Pesquisa</h4>
		<div class="col-md-12">

    		<div class="row">
        		<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<!-- Cabeçario da Tabela -->
						<thead>
							<tr>
								<th>										
									<i class="fa fa-list-ul fa-fw"></i> 
								</th>
								<th class="azul">Data</th>
								<th class="azul">Maquina</th>
								<th class="azul">Inicial</th>
								<th class="azul">Final</th>
								<th class="azul">Total</th>												
								<th></th>
							</tr>
						</thead>
						<!-- Corpo da Tabela -->
						<tbody>
						<?php																		
							if (isset($_POST['submit']))
							{

								$chancela = new ChancelaModel();
								$chancela->setMaquinaId($_POST['maquina']);
								$chancela->setMes($_POST['mes']);
								$chancela->setAno($_POST['ano']);

								$chancelaController = new ChancelaController();
								$chancelas = $chancelaController->listaChancelas($chancela);
								$i=0;
								$qdt_protocolos = 0;
								
								foreach ($chancelas as $chancela) {
									$i++;	
									$id = $chancela->getId();												
									$data = $chancela->getData();
									$maquina = $chancela->getMaquinaId();
									$inicio = $chancela->getInicio();
									$final = $chancela->getFinal();

									$total = ($chancela->getFinal() - $chancela->getInicio())+1;
									$qdt_protocolos += $total;
									
									echo '
									<tr>
										<td>
											'.$id.'
										</td>
										<td>
											'.$data.'
										</td>
										<td>											
											'.$maquina.'
										</td>
										<td>
											'.$inicio.'
										</td>
										<td>
											'.$final.'
										</td>
										<td>
											'.$total.'
										</td>
										<td>';												
											if ($i == count($chancelas))
											{
												$id = $chancela->getId();
												$data =  $chancela->getData();
												$maquina = $chancela->getMaquinaId(); 
												echo '													
													<form method="post" action="DAO/chancelas-sql-remove.php">
														<input type="hidden" name="id" value='.$id.'>
														<input type="hidden" name="data" value='.$data.'>														
														<input type="hidden" name="chancela" value='.$maquina.'>
														<button type="submit" class="btn btn-link">
															<i class="fa fa-trash-o vermelho"></i>
														</button>
													</form>';
											}
										echo '												
										</td>																		
									</tr>';														
								}										
							}
							else
							{
								echo '
								<tr></tr>';
							}
						?>
						</tbody>
					</table>
					<div class="pager">
						<?php									
							if (isset($_POST['submit']))
							{
								if (count($chancelas)>0)
								{											
									echo '
										<p id="msg" class="alert-info text-center"> Foram recebidos um total de '.$qdt_protocolos.' protocolos.</p>
										';
										
										#<form method="post" action="chancelas-print.php">
									echo '
										<form method="post" action="chancelas-pdf.php">
											<input type="hidden" name="mes" value='.$_POST['mes'].'>
											<input type="hidden" name="ano" value='.$_POST['ano'].'>
											<input type="hidden" name="maquina" value='.$_POST['maquina'].'>
											
											<button type="submit" class="btn btn-success">
												<i class="fa fa-print"></i>
												Imprimir Relatório
											</button>
											<a class="btn btn-danger" href="index.php">
												<i class="fa fa-arrow-left "></i>
												Cancelar
											</a>

										</form>												
										';
								}
								else
								{
									echo '
										<a class="btn btn-success" href="#" disabled>
											<i class="fa fa-print"></i>
											Imprimir Relatório
										</a>
										<a class="btn btn-danger" href="index.php">
											<i class="fa fa-arrow-left "></i>
											Cancelar
										</a>
									';
								}
							}
							else
							{
								echo '
									<a class="btn btn-success" href="#" disabled>
										<i class="fa fa-print"></i>
										Imprimir Relatório
									</a>
									<a class="btn btn-danger" href="index.php">
										<i class="fa fa-arrow-left "></i>
										Cancelar
									</a>
								';
							} ?>
					</div>
				</div><!-- dataTable_wrapper -->
			</div><!-- row -->	    			

		</div><!-- col -->

	</div><!-- row -->	

<?php require_once("template/footer-custom-start.php"); ?>

<script>    

    $(document).ready(function() 
    {        
        /* DataTable */
        $('#dataTables-example').DataTable({
                responsive: true
        }); 

    });	
	
	//Evento: Enter no Mês
	$("#mes").keypress(function() {
  		$("#ano").focus();
	});	

	//Evento: Enter no Ano
	$("#ano").keypress(function() {			
		//$("#maquina").focus();		
	});

	//Evento: Enter na Escolha da Maquina
	$("#maquina").keypress(function() {			
		$("#enviar").focus();
	});	

	/* Mantém os dados do filtro após pesquisa */
	if($("#mes_selecionado"))
	{		
		let mes = $("#mes_selecionado").val();	   
		$("#mes").prop('selectedIndex', mes-1);	
	}

    if ($("#ano_selecionado")) $("#ano").val($("#ano_selecionado").val());

    if ($("#maquina_selecionada"))
    {
    	let maquina = $("#maquina_selecionada").val();	   	        	
    	$("#maquina").prop('selectedIndex', maquina-1);	
    }

	var data = new Date();
	var dataMes = data.getMonth();
	var dataAno = data.getFullYear();		
	
	$("#mes").prop('selectedIndex',dataMes);	
	$("#ano").val(dataAno);		
	
</script>      

<?php require_once("template/footer-custom-end.php"); ?>