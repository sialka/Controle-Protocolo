<?php
	/*
	*	USUARIOS-EDITAR.PHP
	*	VIEW - EDIÇÃO DE USUARIO
	*/
    
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_Adm(); 
    
    /*
    // tratamento de erro - caso nao exista id retorna para lista    
	if (!isset($_SESSION["usuario_editar_msg_success"]) && !isset($_SESSION["usuario_editar_msg_error"])) {		
		if (!isset($_POST["id"])){
			header("Location: index.php");
			die();
		}	
	}
	*/

	if (!isset($_SESSION["usuario_editar_msg_success"]) && !isset($_SESSION["usuario_editar_msg_error"]))
	{	
		
		$id = $_POST["id"];
		$usuario = $_POST["usuario"];
		$nome = $_POST["nome"];
		$email = $_POST["email"];
		$nivel = $_POST["nivel"];
	}

	require_once("template/html-head.php"); 
?>	
	
		<main>

			<div class="row">		            
	            <div class="col-md-12">
					<?php PageHeader("Usuário") ?>
					<?php PageTitle("fa-cogs", "Editando Usuário") ?>
	      		</div>
	     	</div>	
	  			
			<?php
				// caso exista a sessoes
				if (!isset($_SESSION["usuario_editar_msg_success"]) && !isset($_SESSION["usuario_editar_msg_error"]))
				{
			?>

					<form method="POST" action="DAO/usuarios-sql-editar.php" id="usuario_form" autocomplete="off">
		
					
						<div class="row">						
							<h4><i class="fa fa-tag"></i> Identificação do Usuário</h4>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>ID</label>									
									<input class="form-control" type="text" name="id" value=<?= $id ?> readonly="readonly">
								</div>
							</div>							
							<div class="col-md-3">
								<div class="form-group">
									<label>Usuario</label>									
									<input class="form-control" type="text" name="usuario" value=<?= $usuario ?> readonly="readonly">									
								</div>
							</div>
						</div>								

					<div class="row">						
						<h4><i class="fa fa-thumb-tack"></i> Edição de Dados</h4>
					</div>

					<div class="row">						
						<div class="col-md-6">
							<div class="form-group control-group">
								<label>Nome Completo <span class="vermelho">*</span></label>
								<input class="form-control" 
										type="nome"
										name="nome"
										id="nome"												
										placeholder="Digite o nome completo"
										value="<?= $nome ?>"
										onchange="offMsg()"
										autofocus
										required>
								<p class="help-block text-danger"></p>
							</div>
						</div>
					</div>					

					<div class="row">
						<div class="col-md-6">
							<div class="form-group control-group">
								<label>e-mail <span class="vermelho">*</span></label>
								<input class="form-control" 
										type="email"
										name="email"
										id="email"
										placeholder="Digite o email"
										value="<?= $email ?>"
										onchange="offMsg()"
										required>
								<p class="help-block text-danger"></p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>
									<?php 
										if ($nivel==0)
										{
											echo '<input type="checkbox" name="adm" id="adm">';
										}
										else
										{
											echo '<input type="checkbox" name="adm" id="adm" checked>';
										}
									?>
									Administrador
								</label>								
							</div>
						</div>
					</div>						

					<div class="row">
						<div class='pager'>
							<button class="btn btn-success" id="submit" disabled>
								<i class="fa fa-save"></i>
								Salvar Alterações
							</button>							
							<a href="usuarios-lista.php" class="btn btn-danger">
								<i class="fa fa-arrow-left "></i>
								Cancelar
							</a>
						</div>
					</div>

					</form>	

    		<?php    		
    			}
    			else
    			{

					MensagenSucesso("usuario_editar_msg_success");
					MensagenErro("usuario_editar_msg_error");				

					echo '
						<div class="pager">
							<a href="usuarios-lista.php" class="btn btn-danger">
								<i class="fa fa-arrow-left"></i>
								Voltar
							</a>
						</div>
						';
				}
    		?>
	
		</main><!-- Main -->	

	
<?php require_once("template/footer-custom-start.php"); ?>
<script>     

		function validate(){

 			let $sel = document.querySelector.bind(document);
 						
			var val1 = $sel("#nome").value;
			var val2 = $sel("#email").value;			
			
			var regNome = new RegExp("[a-zA-Z0-9 çÇãÃõÕéÉêÊúÚ]");
			var regEmail = new RegExp("[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\\.[A-Za-z]{2,4}");			
			
			var res1 = regNome.test(val1);
			var res2 = regEmail.test(val2);
			
			/*
			console.log(val1+" - "+res1);
			console.log(val2+" - "+res2);
			*/			

			if (res1 && res2){	            
	            document.getElementById("submit").disabled = false;  
	        }else {	            
	            document.getElementById("submit").disabled = true;  
	        }
            
        };
       
        function offMsg(){                       
            /*if (document.getElementById("msg")!=null){               
                document.getElementById("msg").style.display = "none";
            }*/
            validate();
        };

</script>      
<?php require_once("template/footer-custom-end.php"); ?>
