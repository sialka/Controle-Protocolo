<?php
	/*
	*	USUARIOS-NOVO.PHP
	*	VIEW - ADICIONAR NOVOS USUARIOS
	*/

	use controllers\UsuarioController;
	
	require_once("autoload.php");
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_Adm(); 

	$usuarioController = new UsuarioController();
	$senha = $usuarioController->GeraHash(6);

	require_once("template/html-head.php"); 
?>

	<main>

		<div class="row">		            
            <div class="col-md-12">
				<?php PageHeader("Usuários") ?>
				<?php PageTitle("fa-users", "Novo Usuário") ?>
      		</div>
     	</div>

		<?php				

			MensagenSucesso("usuario_cadastro_msg_success");
			MensagenErro("usuario_cadastro_msg_error");				

		?>					

		<form method="post" action="DAO/usuarios-sql-novo.php" id="usuario_form" autocomplete="off">
				
			<div class="row">	
				<h4><i class="fa fa-thumb-tack"></i> Identificação de Acesso</h4>
			</div>

			<!-- Nome do Usuario-->
			<div class="row">	
				<div class="col-md-6">
					<div class="form-group control-group">
						<label>Nome do Usuário <span class="vermelho">*</span></label>
						<input class="form-control" 
								type="usuario"
								name="usuario"
								id="usuario"										
								placeholder="Digite o nome do usuario"	
								onchange="offMsg()"
								autofocus
								required>
						<p class="help-block text-danger"></p>
					</div>
				</div>
			</div>

			<!-- Nome do Usuario-->
			<div class="row">	
				<div class="col-md-3">						
					<div class="form-group">
						<label>Senha do Usuário <span class="vermelho">*</span></label>
						<input class="form-control" 
								type="text"
								name="senha"
								id="senha"
								placeholder="Digite a senha"
								onchange="offMsg()"
								value=<?php echo $senha ?> 
								required>
					</div>
					<div class="form-group">
						<label for="check-senha">
							<input type="checkbox" id="check-senha" checked>
							Mostrar Senha
						</label>
					</div>
				</div>
			</div>						

			<div class="row">							
				<h4><i class="fa fa-tags"></i> Identificação do Usuário</h4>
			</div>

			<!-- Nome Completo -->							
			<div class="row">							
				<div class="col-md-6">
					<div class="form-group control-group">
						<label>Nome Completo <span class="vermelho">*</span></label>
						<input class="form-control" 
								type="nome"
								name="nome"
								id="nome"
								placeholder="Digite o nome completo"
								onchange="offMsg()"
								required>
						<p class="help-block text-danger"></p>
					</div>
				</div>
			</div>

			<!-- E-mail -->							
			<div class="row">							
				<div class="col-md-6">
					<div class="form-group control-group">
						<label>E-Mail <span class="vermelho">*</span></label>
						<input class="form-control" 
								type="email"
								name="email"
								id="email"
								placeholder="Digite o email"
								onchange="offMsg()"
								required>
						<p class="help-block text-danger"></p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="pager">							
					<button class="btn btn-success" id="submit" disabled>
						<i class="fa fa-save"></i>
						Salvar Novo Usuário
					</button>
					<a class="btn btn-danger" href="usuarios-lista.php">
						<i class="fa fa-arrow-left"></i>
						Cancelar
					</a>
				</div>
			</div>

		</form>					  			

	</main>

<?php require_once("template/footer-custom-start.php"); ?>
<script>     
 		
 		function validate()
 		{

 			let $sel = document.querySelector.bind(document);
 			
			var val1 = $sel("#usuario").value;
			var val2 = $sel("#nome").value;
			var val3 = $sel("#email").value;
			
			var regUsuario = new RegExp("[a-zA-Z0-9]");
			var regNome = new RegExp("[a-zA-Z0-9 çÇãÃõÕéÉêÊúÚ]");
			var regEmail = new RegExp("[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\\.[A-Za-z]{2,4}");
			
			var res1 = regUsuario.test(val1);
			var res2 = regNome.test(val2);
			var res3 = regEmail.test(val3);
			/*
			console.log(val1+" - "+res1);
			console.log(val2+" - "+res2);
			console.log(val3+" - "+res3);
			*/

			if (res1 && res2 && res3)
			{	            
	            document.getElementById("submit").disabled = false;  
	        }
	        else
	        {	            
	            document.getElementById("submit").disabled = true;  
	        }
            
        };
       
        function offMsg()
        {                       
            if (document.getElementById("msg")!=null){               
                document.getElementById("msg").style.display = "none";
            }
            validate();
        };
	
		document.getElementById("check-senha").onclick = function()
		{    								
			offMsg();						
			if (document.getElementById("check-senha").checked)
			{				
				document.getElementById("senha").type="text";				
			}
			else
			{
				document.getElementById("senha").type="password";				
			}
		}	
	
</script>      
<?php require_once("template/footer-custom-end.php"); ?>