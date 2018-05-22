<?php
	/*
	*	CIDDES-LISTA.PHP
	*	VIEW - LISTA DE CIDADES
	*/

	use controllers\CidadeController;

	require_once("autoload.php");
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();
	
	# Eliminando session caso exista do usuario-editar.php
	if (!isset($_SESSION)) session_start();
	
	# Deleta mensagem se houver
	if(isset($_SESSION["cidade_editar_msg_success"])) unset($_SESSION["cidade_editar_msg_success"]);			
	if(isset($_SESSION["cidade_editar_msg_error"])) unset($_SESSION["cidade_editar_msg_error"]);

	# Carrega o restante da pagina.
	require_once("template/html-head.php");
?>
            
	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Cidades") ?>
			<?php PageTitle("fa-search", "Todas as Cidades") ?>
  		</div>
 	</div>			        

	<?php				
		MensagenSucesso("cidade_excluir_msg_success");
		MensagenErro("cidade_excluir_msg_error");
	?>

	<div class="row">

		<div class="dataTable_wrapper">

			<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">
			
				<!-- Cabeçario da Tabela -->
				<thead>
					<tr>
						<th>										
							<i class="fa fa-list-ul fa-fw"></i> 
						</th>
						<th class="azul">CIDADES</th>
						<th class="azul">VARAS</th>												
						<?php
							if ($_SESSION["usuario_nivel"] == 1) echo '<th></th>';
						?>
					</tr>
				</thead>
				
				<!-- Corpo da Tabela -->
				<tbody>
				<?php
					$cidadeController = new CidadeController();	
					$cidades = $cidadeController->listaCidades();
					foreach ($cidades as $cidade) :
						
						$id = $cidade->getId();
						$nome = $cidade->getNome();
						$varas = $cidade->getVaras();
				?>	

					<tr>
						<td><?= $id ?></td>								
						<td><?= $nome ?></td>
						<td>
							<?php 
								if ($varas == 0){
									echo "-";
								} else {
									echo $varas;
								}
							?>
						</td>								
						<?php 	
						if ($_SESSION["usuario_nivel"] == 1) { ?>
						<td>
							<div class="dropdown">
								<a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
									Opções
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu"> 
									<li><!-- Editar Cidade -->
										<form method="post" action="cidades-editar.php">
											<input type="hidden" name="id" value="<?= $id ?>">
											<input type="hidden" name="cidade" value="<?= $nome ?>">
											<input type="hidden" name="vara" value="<?= $varas ?>">
											<button type="submit" class="btn-link">
												<span class="dropdown-icone">
													<i class="fa fa-pencil azul"></i>
												</span>
												Editar
											</button>
										</form>
									</li>
									<li><!-- Remover Cidade -->
										<form method="post" action="DAO/cidades-sql-remove.php">
											<input type="hidden" name="id" value="<?= $id ?>">
											<input type="hidden" name="cidade" value="<?= $nome ?>">
											<button type="submit" class="btn-link red">
												<span class="dropdown-icone">
													<i class="fa fa-trash-o vermelho"></i>
												</span>
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
					if ($_SESSION["usuario_nivel"] == 1) { 
						echo '
							<a class="btn btn-success" href="cidades-novo.php">
								<i class="fa fa-plus"></i>
								Nova Cidade
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