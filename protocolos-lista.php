<?php
	/*
	*	PROTOCOLOS-LISTA.PHP
	*	VIEW - PESQUISA DE PROTOCOLO
	*/

	use controllers\ProtocoloController;
	use controllers\UsuarioController;
	use controllers\CidadeController;
	use controllers\MaquinaController;

	require_once("autoload.php");
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();
	
	$cidadeControlle = new CidadeController();
	$cidades = $cidadeControlle->listaCidades();	

	$maquinaControlle = new MaquinaController();	
	$maquinas = $maquinaControlle->listaMaquinas();		

	$usuarioControlle = new UsuarioController();	
	$usuarios = $usuarioControlle->listaUsuarios();		
	
	$protocoloControlle = new ProtocoloController();		

	# HAVENDO POST

	# Coletando os dados para a pesquisa

	$dados = ''; 		// variavel com as dados a serem pesquisados.

	if (isset($_REQUEST['enviar']))
	{
		
		$dado_unico = 0;	// pesquisa com um unico dados não precisa do and.

		// Data para pesquisa
		if (isset($_POST["data"]))
		{	
			$data = $_POST["data"];
			$dados = "data='".$data."'";
			$dado_unico++;
		}

		// Cidade para pesquisa
		if (isset($_POST["cidade"]))
		{
			$cidade = $_POST["cidade"];
			if ($dado_unico == 0)
			{
				$dados .= "destino_id=".$cidade;
			}
			else
			{
				$dados .= " and destino_id=".$cidade;
			}
			$dado_unico++;
		}

		// Vara para pesquisa
		if (isset($_POST["vara"]))
		{	
			$vara = $_POST["vara"];
			if ($dado_unico == 0)
			{
				$dados .= "vara=".$vara;
			}
			else
			{
				$dados .= " and vara=".$vara;
			}
			$dado_unico++;
		}

		// Vara para processo
		if (isset($_POST["processo"]))
		{	
			$processo = $_POST["processo"];
			if ($dado_unico == 0)
			{
				$dados .= "processo=".$processo;
			}
			else
			{
				$dados .= " and processo=".$processo;
			}
			$dado_unico++;
		}

		// Chancela para processo
		if (isset($_POST["chancela"]))
		{	
			$chancela = $_POST["chancela"];
			if ($dado_unico == 0)
			{
				$dados .= "chancela=".$chancela;
			}
			else
			{
				$dados .= " and chancela=".$chancela;
			}
			$dado_unico++;
		}

		// Maquina para processo
		if (isset($_POST["maquina"]))
		{	
			$maquina = $_POST["maquina"];
			if ($dado_unico == 0)
			{
				$dados .= "maquina_id=".$maquina;
			}
			else
			{
				$dados .= " and maquina_id=".$maquina;
			}
			$dado_unico++;
		}

		// Usuario para processo
		if (isset($_POST["usuario"]))
		{	
			$usuario = $_POST["usuario"];
			if ($dado_unico == 0)
			{
				$dados .= "usuario_id=".$usuario;
			}
			else
			{
				$dados .= " and usuario_id=".$usuario;
			}
			$dado_unico++;
		}

		// Impressao para processo
		if (isset($_POST["impressao"]))
		{	
			
			if ($_POST["impressao"]=="on")
			{
				$impressao = 1;	
			}
			else
			{
				$impressao = 0;	
			}

			if ($dado_unico == 0)
			{
				$dados .= "impressao=".$impressao;
			}
			else
			{
				$dados .= " and impressao=".$impressao;
			}
			$dado_unico++;
		}

		// Duplicado para processo
		if (isset($_POST["duplicado"]))
		{	
			
			if ($_POST["duplicado"]=="on")
			{
				$duplicado = 1;	
			}
			else
			{
				$duplicado = 0;	
			}

			if ($dado_unico == 0)
			{
				$dados .= "duplicado=".$duplicado;
			}
			else
			{
				$dados .= " and duplicado=".$duplicado;
			}
			$dado_unico++;
		}

		//echo $dados;
	}

	// Carrega o restante da pagina.
	require_once("template/html-head.php");
?>
 
	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Protocolos") ?>
			<?php PageTitle("fa-search", "Pesquisa de Protocolo") ?>
  		</div>
 	</div>

	<form class="form-horizontal" method="post" _action="protocolo-lista.php">
				
		<!-- Data, Cidade e Vara -->
		<div class="row">			
			
			<!-- Data -->																	
			<div class="col-sm-4">											
				<div class="control-group">																			
					<h4><i class="fa fa-calendar"></i> Data do Recebimento</h4>
					<div class="input-group">
						<span class="input-group-addon">
							<?php
								if (isset($_POST['data']))
								{												
									echo '<input type="checkbox" id="check_data" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_data">';
								}
							?>
						</span>
						<?php
							isset($_POST['data']) ? $data_formatada = $_POST['data']:$data_formatada = date("d/m/Y");											
						?>
						<input class="form-control" 
								id="data" 
								name="data"
								type="text"
								size=10
								placeholder="DD/MM/AAAA"
								pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])\/(0[1-9]|1[012])\/[0-9]{4}"
								title="DD/MM/AAAA"
								value=<?= $data_formatada ?>
								disabled>										
					</div>	
				</div>
			</div>

			<!-- Cidade -->			
			<div class="col-sm-4">															
				<div class="control-group">		
					<h4><i class="fa fa-map-marker"></i> Cidade</h4>
					<div class="input-group">
						<span class="input-group-addon">
							<?php
								if (isset($_POST['cidade']))
								{
									echo '<input type="checkbox" id="check_destino" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_destino">';
								}
							?>
						</span>
						<select class="form-control" 
								id="cidade" 
								name="cidade" 
								disabled>
							  	<?php 
							  		foreach ($cidades as $cidade)
							  		{
								  		if (isset($_POST['cidade']))
								  		{
								  			if ($_POST['cidade']==$cidade->getId())
								  			{
								  				echo '<option value='.$cidade->getId().' selected>'.$cidade->getNome().'</option>';
								  			}
								  			else
								  			{
								  				echo '<option value='.$cidade->getId().'>'.$cidade->getNome().'</option>';
								  			}
								  		}
							  			else
							  			{
						  					echo '<option value='.$cidade->getId().'>'.$cidade->getNome().'</option>';
						  				}
							  		}
							  	?>										  	
						</select>
					</div>								
				</div>
			</div>

			<!-- Vara -->
			<div class="col-sm-4">
				<div class="control-group">
					<h4><i class="fa fa-tag"></i> Vara</h4>
					<div class="input-group">
						<span class="input-group-addon">																				
							<?php
								if (isset($_POST['vara']))
								{
									echo '<input type="checkbox" id="check_vara" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_vara">';
								}											
							?>
						</span>										
						<select class="form-control" 
								name="vara" 
								id="vara" 
								disabled>
			    		</select>
			    		<!-- Oculto -->
						<select class="form-control" name="vara_qtd" id="vara_qtd" disabled>
							<?php
								foreach ($cidades as $cidade)
								{
									if (isset($_POST['vara']))
									{
										if ($_POST['vara']==$cidade->getVaras())
										{
											echo '<option selected>'.$cidade->getVaras().'</option>';
										}
										else
										{
											echo '<option>'.$cidade->getVaras().'</option>';
										}
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
					<h4><i class="fa fa-file"></i> Processo</h4>
					<div class="input-group">
						<span class="input-group-addon">											
							<?php
								if (isset($_POST['processo']))
								{
									echo '<input type="checkbox" id="check_processo" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_processo">';
								}
							?>											
						</span>
						<?php
							isset($_POST['processo']) ? $processo_atual = $_POST['processo'] : $processo_atual = "0" ;
						?>																	
		    			<input class="form-control" 
		    				id="processo" 
		    				name="processo" 
		    				type="text"
		    				pattern="\d{20}|(\d{4}\/\d{4})"
		    				placeholder="00000000000005020000"
		    				title="0000/0000 ou 00000000000005020000" 
		    				value=<?=$processo_atual?>
		    				disabled>
		    		</div>
	    		</div>
    		</div>	

			<!-- Chancela -->			    		
			<div class="col-sm-4">			    				
				<div class="control-group">
					<h4><i class="fa fa-file-text-o"></i> Chancela</h4>
					<div class="input-group">
						<span class="input-group-addon">										
							<?php
								if (isset($_POST['chancela']))
								{
									echo '<input type="checkbox" id="check_chancela" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_chancela">';
								}
							?>																					
						</span>	
						<?php
							isset($_POST['chancela'])? $chancela_atual = $_POST['chancela']:$chancela_atual="0";
						?>				    														
		    			<input class="form-control"
		    				id="chancela" 
		    				name="chancela" 
		    				type="number" 
		    				placeholder="000000"
		    				min=1
		    				max=999999
		    				size=6
		    				value=<?=$chancela_atual?>
		    				disabled>
		    		</div>				    		
		    	</div>
    		</div>

			<!-- Máquina -->						
			<div class="col-sm-4">								
				<div class="control-group">
					<h4><i class="fa fa-barcode"></i> Máquina</h4>
					<div class="input-group">
						<span class="input-group-addon">											
							<?php
								if (isset($_POST['maquina']))
								{
									echo '<input type="checkbox" id="check_maquina" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_maquina">';
								}											
							?>
						</span>													
			    		<select class="form-control" name="maquina" id="maquina" disabled>
						  	<?php
						  		foreach ($maquinas as $maquina)
						  		{
							  		if (isset($_POST['maquina']))
							  		{
							  			if ($_POST['maquina']==$maquina->getId())
							  			{
							  				echo '<option value='.$maquina->getId().' selected>'.$maquina->getNome().'</option>';
								  		}
								  		else
								  		{
								  			echo '<option value='.$maquina->getId().'>'.$maquina->getNome().'</option>';
								  		}
							  		}
							  		else
							  		{
							  			echo '<option value='.$maquina->getId().'>'.$maquina->getNome().'</option>';
							  		}
				  				}
				  			?>  	
						</select>
					</div>
				</div>
			</div>

		</div>								
				
		<!-- Usuario, Malote e Maquina -->
		<div class="row">

			<!-- Usuarios -->
			<div class="col-sm-4">							
				<div class="control-group">
					<h4><i class="fa fa-user"></i> Usuário</h4>
					<div class="input-group">
						<span class="input-group-addon">											
							<?php
								if (isset($_POST['usuario']))
								{
									echo '<input type="checkbox" id="check_usuario" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_usuario">';
								}																						
							?>
						</span>
			    		<select class="form-control" id="usuario" name="usuario" disabled>
						  	<?php 
						  		foreach ($usuarios as $usuario)
						  		{
							  		if (isset($_POST['usuario']))
							  		{
								  		if ($_POST['usuario'] == $usuario->getId())
								  		{
								  			echo '<option value='.$usuario->getId().' selected>'.$usuario->getNome().'</option>';
								  		}
								  		else
								  		{
								  			echo '<option value='.$usuario->getId().'>'.$usuario->getNome().'</option>';
								  		}
								  	}
								  	else
								  	{
								  		echo '<option value='.$usuario->getId().'>'.$usuario->getNome().'</option>';
								  	}
				  				} 
				  			?>  	
						</select>
					</div>
				</div>
			</div>

			<!-- Malote -->
			<div class="col-sm-4">
				<div class="control-group">
					<h4><i class="fa fa-tags"></i> Malote</h4>								
					<div class="input-group">
						<span class="input-group-addon">								
							<?php 
								if (isset($_POST['impressao']))
								{
									echo '<input type="checkbox" id="check_impressao" name="impressao" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_impressao" name="impressao">';
								}
							?>
						</span>								
						<label class="form-control" for="check_impressao">
							2ª Malote
						</label>
					</div>		
				</div>																
			</div>				
		
			<!-- Duplicado  -->
			<div class="col-sm-4">
				<div class="control-group">
					<h4><i class="fa fa-copy"></i> Chancela</h4>
					<div class="input-group">
						<span class="input-group-addon">
							<?php
								if (isset($_POST['duplicado']))
								{
									echo '<input type="checkbox" id="check_duplicado" name="duplicado" checked>';
								}
								else
								{
									echo '<input type="checkbox" id="check_duplicado" name="duplicado">';
								}
							?>
						</span>
						<label class="form-control" for="check_duplicado">
							Em Duplicidade
						</label>
					</div>
				</div>
			</div>	

		</div>					
		
		<!-- Submit -->	    
    	<div class="row">
	    	<div class="pager">
	    		<button type="submit" name="enviar" id="enviar" class="btn btn-success" autofocus>
	    			<i class="fa fa-search"></i>
	    			Pesquisar Protocolos
	    		</button>
				<a class="btn btn-danger" href="index.php">
					<i class="fa fa-arrow-left"></i>
					Cancelar
				</a>						    		
	    	</div>			    			    
    	</div>

	</form>							  			

	<?php									
		// Mensagens da ação de Excluir cidades
		MensagenSucesso("protocolo_excluir_msg_success");
		MensagenErro("protocolo_excluir_msg_error");    
	?>	

	<!-- Tabela -->
	<div class="row">			

    	<div class="dataTable_wrapper">

			<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">
				<thead>
					<tr>								
						<th class="azul">DATA</th>
						<th class="azul">COMARCA</th>
						<th class="azul"></th>
						<th class="azul">PROCESSO</th>
						<th></th>
						<th class="azul">P</th>																	
						<th class="azul"><i class="fa fa-print"></i></th>
						<th class="azul"><i class="fa fa-copy"></i></th>
						<th></th>								
					</tr>
				</thead>
				<tbody>

					<?php							
						if ($dados != '')
						{									
							$protocolos = $protocoloControlle->buscaProtocolos($dados);									
							if (count($protocolos)==0)
							{
								echo '
									<div class="alert alert-danger text-center">			
										<i class="fa fa-times"></i>
										Não há registro de recebimento de protocolos com os dados informados.
									</div>
								';
							}

							foreach ($protocolos as $protocolo)
							{
								echo '							
									<tr>												
										<td>'.$protocolo->getData().'</td>				
										<td>'.$protocolo->getCidadeId().'</td>			
										<td>';
											if ($protocolo->getVara() == 0)
											{
												echo '-';
											}
											else
											{
												echo $protocolo->getVara(); 
											}
										echo '
										</td>
										<td>'.$protocolo->getProcesso().'</td>
										<td>'.$protocolo->getChancela().'</td>
										<td>'.$protocolo->getMaquinaId().'</td>
										<td>';
											if ($protocolo->getImpressao() == 1)
											{
												echo '<span class="verde"><i class="fa fa-check"></i></span>';
											}
											else
											{
												echo '-';
											}													
										echo '
										</td>
										<td>';													
											if ($protocolo->getDuplicado() == 1)
											{
												echo '<span class="verde"><i class="fa fa-check"></i></span>';
											}
											else
											{
												echo '-';
											}													
										echo '
										</td>
										<td>
											<div class="dropdown">
												<a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
													Opções
													<span class="caret"></span>
												</a>
												<ul class="dropdown-menu dropdown-menu2">
													<!-- Edita protocolo -->
													<li>
														<form method="post" action="protocolos-editar.php">
															<input type="hidden" name="id" value='.$protocolo->getId().'>
															<button type="submit" class="btn-link">
																<span class="dropdown-icone">
																	<i class="fa fa-pencil azul"></i>
																</span>
																Editar
															</button>
														</form>
													</li>
													<!-- Exclui protocolo -->
													<li>										
														<form method="post" action="DAO/protocolo-sql-remove.php">
															<input type="hidden" name="id" value='.$protocolo->getId().'>
															<input type="hidden" name="chancela" value='.$protocolo->getChancela().'>
															<button type="submit" class="btn-link">
																<span class="dropdown-icone">
																	<i class="fa fa-trash vermelho"></i>
																</span>
																Remover
															</button>
														</form>
													</li>
												</ul>
											</div>
										</td>
									</tr>
								';							
							}
						}								
					?>
				</tbody>	
			</table>

			<?php 
				if ($dados != '')
				{	
					if (count($protocolos) > 0)
					{
						echo '
							<form  method="post" action="DAO/protocolo-sql-print-individual.php">
								<div class="pager">																
									<input type="hidden" name="dados" value="'.$dados.'">
									<input type="hidden" name="regs" value="'.count($protocolos).'">
									<button type="submit" 
											class="btn btn-success">								
												<i class="fa fa-print"></i>
												Imprimir Relatório
									</button>							
								</div>	  			
							</form>';							
						
					}
				}
			?>

		</div><!-- dataTable -->				    		

	</div>
	
<?php require_once("template/footer-custom-start.php"); ?>
<script type="text/javascript">	

    /* DATATABLE */
    $(document).ready(function()
    {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });	  	

    /*  FUNÇÕES */
	function print()
	{
		let iframe = document.getElementById('textfile');
		iframe.contentWindow.print();
	}	  

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

	function habilita_Data()
	{
		if (!$('#check_data').prop("checked"))
		{
			$('#check_data').prop("checked", true);
			$('#data').prop("disabled", false);
		}
	};

	/* EVENTOS */

	// Carrega qtde de varas
	$( "#cidade" ).click(function() {
		carrega_varas();        
	});

	// CHECK - DATA	
	$("#check_data").click(function() {


		if($('#data').prop("disabled"))
		{
			$('#data').prop( "disabled", false );
			$('#data').focus();
		}
		else
		{
			$('#data').prop( "disabled", true );			

			// Desativa Pesquisa por Maquina
			if ($("#check_maquina").prop("checked"))
			{
				$("#check_maquina").prop("checked",false);
				$("#maquina").prop("disabled",true);
			}						
			
			// Desativa Pesquisa por 2ª Malote
			if ($("#check_impressao").prop("checked"))
			{			
				$("#check_impressao").prop("checked",false);
			}

			// Desativa Pesquisa por Duplicidade
			if ($("#check_duplicado").prop("checked"))
			{				
				$("#check_duplicado").prop("checked",false);
			}

		}	
	});
	
	// CHECK - CIDADE		
	$("#check_destino").click(function() {		

		if($('#cidade').prop("disabled"))
		{
			//Muda as quantidades de varas das cidades			
			carrega_varas();
			
			$('#cidade').prop( "disabled", false );
			$('#cidade').focus();

		}
		else
		{			
			$("#cidade").prop("disabled",true);
		}	
	});

	// CHECK VARA
	$("#check_vara").click(function() {		
		
		if($('#vara').prop("disabled"))
		{
			
			// Verifica se o CHECK CIDADE esta desabilitado
			if ($('#cidade').prop("disabled"))
			{				
				/*  Carregar 90 Varas */
				$("#vara").empty();

				for (i = 0; i < 90; i++)
				{
					$("#vara").append("<option>"+(i+1)+"</option>");
				}			
			}
			else
			{			
				// Carrega as Varas de acordo com a cidade
				carrega_varas();				
			}			

			$('#vara').prop("disabled", false);
			$('#vara').focus();
			
		}
		else
		{			
			$("#vara").prop("disabled", true);
		}	
		
	});

	// CHECK - PROCESSO	
	$("#check_processo").click(function() {		
		
		if ($('#processo').prop("disabled"))
		{
			$('#processo').prop("disabled", false);
			$('#processo').prop("required", true);
			$("#processo").focus();		
		}
		else
		{
			$('#processo').prop("disabled", true);
			$('#processo').prop("required", false);
		}	
	});

	// CHECK - CHANCELA	
	$("#check_chancela").click(function() {		

		if ($('#chancela').prop("disabled"))
		{
			$('#chancela').prop("disabled", false);
			$('#chancela').prop("required", true);
			$("#chancela").focus();		
		}
		else
		{
			$('#chancela').prop("disabled", true);
			$('#chancela').prop("required", false);			
		}	
	});

	// CHECK - MAQUINA
	$("#check_maquina").click(function() {		
		
		if ($('#maquina').prop("disabled"))
		{					
			$('#maquina').prop("disabled", false);
			$('#maquina').prop("required", true);
			$("#maquina").focus();		
		}
		else
		{
			$('#maquina').prop("disabled", true);
			$('#maquina').prop("required", false);
		}	

		// Caso o CHECK DA DATA não esteja marcado
		habilita_Data();
	});

	// CHECK - USUARIO	
	$("#check_usuario").click(function() {		
		
		if ($('#usuario').prop("disabled"))
		{
			$('#usuario').prop("disabled", false);
			$('#usuario').prop("required", true);
			$("#usuario").focus();		
		}
		else
		{
			$('#usuario').prop("disabled", true);
			$('#usuario').prop("required", false);			
		}	
		
		// Caso o CHECK DA DATA não esteja marcado
		habilita_Data();

	});

	// CHECK DUPLICADO	
	$("#check_duplicado").click(function() {		
		// Caso o CHECK DA DATA não esteja marcado
		habilita_Data();
	});

	// CHECK 2ª IMPRESSÃO
	$("#check_impressao").click(function() {		
		// Caso o CHECK DA DATA não esteja marcado
		habilita_Data();
	});

	// Havendo POST tornar visivel os inputs dos CHECKS
	if ($("#check_data").prop("checked")) $('#data').prop( "disabled", false );
	if ($("#check_destino").prop("checked")) $('#cidade').prop( "disabled", false );
	if ($("#check_vara").prop("checked")) $('#vara').prop( "disabled", false );
	if ($("#check_processo").prop("checked")) $('#processo').prop( "disabled", false );
	if ($("#check_chancela").prop("checked")) $('#chancela').prop( "disabled", false );
	if ($("#check_maquina").prop("checked")) $('#maquina').prop( "disabled", false );
	if ($("#check_usuario").prop("checked")) $('#usuario').prop( "disabled", false );

	/* Preparando Form */
	carrega_varas();
	$("#vara_qtd").css("display","none");

</script>

<?php require_once("template/footer-custom-end.php"); ?>