<?php	
	/*
	*	USUARIOS-RESET.PHP
	*	VIEW - RESETA SENHA DE USUARIO
	*/    

    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();    
    
    // Carrega o restante da pagina
    require_once("template/html-head-login.php");    
?>
	
	<div class="panel panel-primary">

        <div class="panel-heading">		            
				<i class="fa fa-cogs"></i>
				Troca de Senha
        </div>

    	<div class="panel-body">

			<form class="col-lg-offset-2 col-lg-8" method="POST" action="DAO/usuarios-sql-reset.php">
				<br>
				<!-- Corpo do formulario -->
				<?php

					if (!isset($_SESSION))session_start();
					
					if (!isset($_SESSION["usuario_reset_msg_success"])) 
					{
						echo '
							<div class="form-group">
								<input class="form-control" 
										id="senha1"
										name="senha1"
										type="password"
										placeholder="Digite a nova senha"
										autofocus
										required>
							</div>
							<div class="form-group">
							<input class="form-control"
									id="senha2"
									name="senha2"
									type="password"
									placeholder="Repita a nova senha"
									required >
							</div>
							';
					}

					// Mensagen de Erro
				    if (isset($_SESSION["usuario_reset_msg_error"])) {								    	
				    	$msg = $_SESSION["usuario_reset_msg_error"];
				        echo '<p id="msg" class="help-block text-danger text-center">'.$msg.'</p>';
				        unset($_SESSION["usuario_reset_msg_error"]);
				    }									 										

					if (!isset($_SESSION["usuario_reset_msg_success"])) {
						echo '
							<div class="form-group">
								<label for="checkbox">
									<input type="checkbox" id="checkbox">
								 	Mostrar Senha
								</label>
							</div>
							';
					}								

					// Mensagen de Sucesso
				    if (isset($_SESSION["usuario_reset_msg_success"])) 
				    {
				    	$msg = $_SESSION["usuario_reset_msg_success"];
				        echo '<p  id="msg" class="help-block text-danger text-center">'.$msg.'</p>';
				        unset($_SESSION["usuario_reset_msg_success"]);

				        echo '
			        		<div class="row">
			        			<br>
			        			<div class="text-center">
				        			<a href="index.php" class="btn btn-primary">
				        				<i class="fa fa-arrow-left"></i>
				        				Sair
				        			</a>
			        			</div>
			        			<br>
			        		</div>
			        		';

				    }
				    else
				    {

						echo '
							<div class="row">
								<br>
								<div class="text-center">
									<button class="btn btn-primary">
										<i class="fa fa-check"></i>
										Salvar
									</button>
								</div>
								<br>
							</div>
							';
					}

				?>

			</form>

		</div><!-- Panel-body -->

	</div><!-- Panel -->					

<script>     
	
		document.getElementById("checkbox").onclick = function()
		{    		
			var objeto = document.getElementById("checkbox");
			if (objeto.checked)
			{				
				document.getElementById("senha1").type="text";
				document.getElementById("senha2").type="text";
			}
			else
			{
				document.getElementById("senha1").type="password";
				document.getElementById("senha2").type="password";
			}	    	

		}

</script>      
<?php require_once("template/footer-login.php"); ?>


