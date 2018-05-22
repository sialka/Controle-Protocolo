<?php
	/*
	*	MAQUINAS-LISTA.PHP
	*	VIEW - LISTA TODAS AS MÁQUINAS NO PROTOCOLO
	*/

	use controllers\MaquinaController;

	require_once("autoload.php");
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();

	// Eliminando session caso exista do usuario-editar.php
	if (!isset($_SESSION)) session_start();
	
	// Deleta mensagem se houver
	if(isset($_SESSION["maquinas_editar_msg_success"])) unset($_SESSION["maquinas_editar_msg_success"]);			
	if(isset($_SESSION["maquinas_editar_msg_error"])) unset($_SESSION["maquinas_editar_msg_error"]);		
	
	// Load corpo padrao do HTML
	require_once("template/html-head.php"); 
?>

	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Máquinas") ?>
			<?php PageTitle("fa-search", "Todas as Máquinas") ?>
  		</div>
 	</div>

	<?php
		// Mensagens da ação de Excluir cidades
		MensagenSucesso("maquina_excluir_msg_success");
		MensagenErro("maquina_excluir_msg_error");    		
	?>		        		

	<div class="row">

    	<div class="dataTable_wrapper">

			<table class="table table-striped table-bordered table-hover" id="dataTables-example">

				<thead>
					<tr>
						<th>			
							<i class="fa fa-list-ul fa-fw"></i> 
						</th>								
						<th class="azul">MAQUINAS</th>										
						<?php
							if ($_SESSION["usuario_nivel"] == 1) echo '<th></th>';
						?>
					</tr>
				</thead>							
				<tbody>

					<?php

						$maquinaController = new MaquinaController();	
						$maquinas = $maquinaController->listaMaquinas();		
						foreach ($maquinas as $maquina) :

							$id = $maquina->getId();
							$nome = $maquina->getNome();
					?>	
						<tr>
							<td><?= $id ?></td>
							<td><?= $nome ?></td>
							<?php 	
							if ($_SESSION["usuario_nivel"] == 1) { ?>
							<td>
								<div class="dropdown">
									<a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
										Opções
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu"> 
										<li><!-- Editar Maquina -->
											<form method="post" action="maquinas-editar.php">
												<input type="hidden" name="id" value="<?= $id ?>">
												<input type="hidden" name="maquina" value="<?= $nome ?>">
												<button type="submit" class="btn-link">
													<i class='fa fa-pencil azul dropdown-icone'></i>
													 Editar
												</button>
											</form>
										</li>												
										<li><!-- Remover Maquina -->
											<form method="post" action="DAO/maquinas-sql-remove.php">
												<input type="hidden" name="id" value="<?= $id ?>">
												<input type="hidden" name="maquina" value="<?= $nome ?>">
												<button type="submit" class="btn-link red">
													<i class="fa fa-trash-o vermelho dropdown-icone"></i>
													 Remover
												</button>
											</form>
										</li>
									</ul>
								</div>
							</td>
							<?php
							} ?>				
						</tr>
					<?php
						endforeach
					?>						

				</tbody>

			</table>

			<div class="pager">
				<?php
					if ($_SESSION["usuario_nivel"] == 1)
					{ 
						echo '								
							<a class="btn btn-success" href="maquinas-novo.php">
								<i class="fa fa-plus"></i>
								Nova Máquina
							</a>';
					}
				?>
				<a class="btn btn-danger" href="index.php">
					<i class="fa fa-arrow-left "></i>
					Cancelar
				</a>						
			</div>

		</div><!-- dataTable_wrapper -->		

	</div>    	

<?php require_once("template/footer-default.php"); ?>