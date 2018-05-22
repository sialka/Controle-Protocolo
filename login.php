<?php
	/*
	* LOGIN.PHP
	* VIEW - LOGIN DE ACESSO
	*/
	
    if (!isset($_SESSION)) session_start();        

    # Templates - Head e Nav 
    require_once("template/html-head-login.php");    

?>
	
	<div class="panel panel-primary">

		<div class="panel-heading">		            
				<i class="fa fa-lock"></i>
				Login de acesso
        </div>		
		
		<div class="panel-body">

			<!--form method="post" action="login-msg.php"-->
			<form method="post" action="DAO\login-sql.php">							
				
				<!-- USUARIO -->
				<div class="row">										
					<div id="usuario-top" class="col-sm-offset-2 col-sm-8">											
						<div class="form-group azul has-feedback">
							<label class="control-label" for="usuario">Usuario:</label>
							<input type="text" 
									class="form-control" 
									id="usuario" 
									name="usuario"
									aria-describedby="usuario"
									pattern="[a-zA-Z0-9]+" 
									title="Use somente letras e números" 
									placeholder="Login"
									autofocus 
									required>										
							<small>
								<?php													
									if (isset($_SESSION["login_tipo_erro"]))
									{
										if ($_SESSION["login_tipo_erro"]==1)
											echo $_SESSION["login_msg_error"];
									}
								?>
							</small>
						</div>										
					</div>										
				</div>

				<div class="row">
					<!-- SENHA -->
					<div class="col-sm-offset-2 col-sm-8">
						<div class="form-group azul has-feedback">
							<label class="control-label" for="senha">Senha:</label>
							<input class="form-control" 
									id="senha"
									name="senha"
									type="password"
									aria-describedby="senha"												
									placeholder="******"
									required>												
							<small>
								<?php																								
									if (isset($_SESSION["login_tipo_erro"]))
									{
										if ($_SESSION["login_tipo_erro"]==2)
											echo $_SESSION["login_msg_error"];
									}
								?>
							</small>
						</div>
					</div>
				</div>

			    <!-- Botao Submit -->							    
			    <div class="row">
			    	<br>
			    	<div class="text-center">
				    	<button type="submit" id="enviar" class="btn btn-primary">
				    		<i class="fa fa-check"></i>
				    		Acessar
				    	</button>
			    	</div>
			    	<br>
				</div>							

			</form>

		</div><!-- Panel-body -->

	</div><!-- Panel -->

  			
<?php require_once("template/footer-login.php");    ?>