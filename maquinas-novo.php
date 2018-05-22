<?php
	/*
	*  MAQUINAS-NOVO.PHP
	*  VIEW - ADICIONA NOVAS MAQUINAS NO SETOR DE PROTOCOLO.
	*/		
	
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_Adm(); 	

	require_once("template/html-head.php"); 
?>
	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Máquinas") ?>
			<?php PageTitle("fa-pencil", "Cadastro de Máquina") ?>
  		</div>
 	</div>

	<?php						
		MensagenSucesso("maquina_cadastro_msg_success");
		MensagenErro("maquina_cadastro_msg_error");
	?>		        		
			        		
	<form method="POST" action="DAO/maquinas-sql-novo.php" id="form" autocomplete="off">
				
		<div class="row">     
			<h4><i class="fa fa-tags"></i> Nova Máquina</h4>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="control-group">
					<label>Nome da Máquina <span class="vermelho">*</span></label>		
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-barcode"></i>
						</span>
						<input class="form-control"
								id="maquina" 
								name="maquina" 								
								title="Minimo 03 letras"
								type="nome"
								placeholder="Nome da Maquina" 
								autofocus
								oninput="Mensagem()"
								required>
					</div>
					<div class="help-block vermelho"></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="pager">
				<button id="submit" type="submit" class="btn btn-success">
					<i class="fa fa-save"></i>
					Gravar Máquina
				</button>
				<a href="index.php" class="btn btn-danger">
					<i class="fa fa-arrow-left"></i>
					Cancelar
				</a>									
			</div>
		</div>

	</form>					
 	
<!-- Carregando o rodape -->
<?php require_once("template/footer-custom-start.php"); ?>

<script type="text/javascript">

	$(function() {    
	    
	    $("#form input,#form textarea").jqBootstrapValidation({
	        preventSubmit: true,
	        submitError: function($form, event, errors) {
	            // additional error messages or events            
	        },
	        submitSuccess: function($form, event) {            
	        },
	        filter: function() {            
	            return $(this).is(":visible");
	        },
	    });	    

	    $("a[data-toggle=\"tab\"]").click(function(e) {
	        
	        e.preventDefault();
	        $(this).tab("show");
	    });
	});

	function Mensagem()
	{    	
    	if ($("#msg")!=null)
    	{
    		$("#msg").css("display","none");
    	} 
       
    }; 		

</script>	

<?php require_once("template/footer-custom-end.php"); ?>