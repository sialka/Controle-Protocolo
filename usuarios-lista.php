<?php
	/*
	*	USUARIOS-LISTA.PHP
	*	VIEW - LISTAS OS USUARIOS
	*/

	use controllers\UsuarioController;

	require_once("autoload.php");
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_Adm(); 

	// Eliminando session caso exista do usuario-editar.php
	if (!isset($_SESSION)) session_start();
	
	// Deleta mensagem se houver

	MensagenSucesso("usuario_editar_msg_success");
	MensagenErro("usuario_editar_msg_error");

	// Load corpo padrao do HTML
	require_once("template/html-head.php"); 
?>

	<main>

		<div class="row">		            
            <div class="col-md-12">
				<?php PageHeader("Usuários") ?>
				<?php PageTitle("fa-users", "Todas os Usuários") ?>
      		</div>
     	</div>	

		<?php

			// Mensagens da ação de Desbloquear Usuarios
			MensagenSucesso("usuario_bloqueio_msg_success");
			MensagenErro("usuario_bloqueio_msg_error");
			
			// Mensagens da ação de Excluir Usuarios
			MensagenSucesso("usuario_excluir_msg_success");
			MensagenErro("usuario_excluir_msg_error");

			// Mensagens da ação de Resete Usuarios
			MensagenSucesso("usuario_reset_lista_msg_success");
			MensagenErro("usuario_reset_lista_msg_error");			

		?>	

		<div class="row">
		
    		<div class="dataTable_wrapper">    			

				<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">

					<thead>
						<tr>			
							<th>
								<i class="fa fa-list-ul fa-fw"></i> 
							</th>								
							<th class="azul">USUÁRIOS</th>
							<th class="azul">NOMES</th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						<?php
							$usuarioController = new UsuarioController();	
							$usuarios = $usuarioController->listaUsuarios();
							foreach ($usuarios as $usuario) :
								
								$id = $usuario->getId();
								$nome = $usuario->getNome();
								$user = $usuario->getUsuario();
								$email = $usuario->getEmail();
								$nivel = $usuario->getNivel();
								$status = $usuario->getStatus();

						?>	
							<tr>
								<td><?= $id ?></td>
								<td>
									<?php 
										
										# Identificador do Administrador
										if ($nivel == 1) echo '<i class="fa fa-star verde"></i>';

										echo $user;

										# Identificando usuarios bloqueados
										if ($status == 1)
										{
											echo ' <i class="fa fa-unlock amarelo"></i>';	
										}
										else
										{
											echo ' <i class="fa fa-lock vermelho"></i>';
										}
									?>
								</td>									
								<td><?= $nome ?></td>
								<td>
									<div class="dropdown">
										<a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
											Opções
											<span class="caret"></span>
										</a>
										<ul class="dropdown-menu"> 
											<li>
												<!-- Resetar a senha -->
												<form method="POST" action="DAO/usuarios-sql-reset-lista.php">
													<input type="hidden" name="id" value=<?= $id ?>>
													<input type="hidden" name="usuario" value="<?= $user ?>">
													<input type="hidden" name="nome" value="<?= $nome ?>">
													<input type="hidden" name="email" value="<?= $email ?>">
													<button type="submit" class="btn-link">
														<i class="fa fa-refresh dropdown-icone"></i>
														Resetar
													</button>									
												</form>									
											</li>
											<li>
												<!-- Bloquear usuario -->									
												<form method="POST" action="DAO/usuarios-sql-bloqueio.php">
													<input type="hidden" name="id" value=<?= $id ?>>
													<input type="hidden" name="usuario" value="<?= $user ?>">
													<input type="hidden" name="nome" value="<?= $nome ?>">
													<button class="btn-link" data-toggle="modal" data-target="#myModal">
														<i class='fa fa-unlock verde dropdown-icone'></i>
														<?php 
															if ($usuario->getStatus() == 1)
															{
																echo 'Bloquear';
															}
															else
															{	
																echo 'Desbloquear';
															}
														?>																	
													</button>									
												</form>									
											</li>
											<li>
												<!-- Editar usuario -->																					
												<form method="POST" action="usuarios-editar.php">
													<input type="hidden" name="id" value=<?= $id ?>>
													<input type="hidden" name="usuario" value="<?= $user ?>">
													<input type="hidden" name="nome" value="<?= $nome ?>">
													<input type="hidden" name="email" value="<?= $email ?>">
													<input type="hidden" name="nivel" value="<?= $nivel ?>">
													<button class="btn-link">
														<i class="fa fa-pencil dropdown-icone"></i>
														Editar
													</button>									
												</form>									
											</li>
											<li>
												<!-- Excluir usuario -->									
												<form method="POST" action="DAO/usuarios-sql-excluir.php">
													<input type="hidden" name="id" value=<?= $id ?>>
													<input type="hidden" name="nome" value="<?= $nome ?>">											
													<button class="btn-link">
														<i class="fa fa-trash vermelho dropdown-icone"></i>
														Remover
													</button>									
												</form>
											</li>
										</ul>
									</div>
								</td>
							</tr>					
						<?php
							endforeach
						?>

					</tbody>
				</table>	

				<div class="pager">
					<a class="btn btn-success" href="usuarios-novo.php">
						<i class="fa  fa-plus"></i>
						Novo Usuario
					</a>
					<a class="btn btn-danger" href="index.php">
						<i class="fa fa-arrow-left "></i>
						Voltar
					</a>						
				</div>

			</div>			

		</div><!-- Row -->			

	</main> <!-- main -->

<?php require_once("template/footer-custom-start.php"); ?>

<script>    

    $(document).ready(function() 
    {        
        /* DataTable */
        $('#dataTables-example').DataTable({
                responsive: true
        }); 

    });	
	
	
</script>      

<?php require_once("template/footer-custom-end.php"); ?>