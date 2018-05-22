<?php
	/*
	*  CIDADES-NOVO.PHP
	*  VIEW - ADICIONA NOVAS CIDADES 
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
			<?php PageHeader("Cidades") ?>
			<?php PageTitle("fa-pencil", "Cadastro de Cidade") ?>
  		</div>
 	</div>

	<?php					
		MensagenSucesso("cidade_cadastro_msg_success");
		MensagenErro("cidade_cadastro_msg_error");    
	?>	

	<form role="form" method="post" action="DAO/cidades-sql-novo.php" id="form" autocomplete="off">
			
		<div class="row">     
			<h4><i class="fa fa-map-marker"></i> Nova Cidade</h4>
		</div>	
		
		<div class="row">     
			<div class="col-md-6">
				<div class="control-group">
					<label for="cidade">Nome da Cidade <span class="vermelho">*</span></label>
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-map-marker"></i>
						</span>										
						<input  class="form-control"
								name="cidade"
								type="nome"
								id="cidade" 
								placeholder="Nome da cidade" 
								oninput="Mensagem()"
								autofocus
								required>																														
					</div>
					<div class="help-block vermelho"></div>
				</div>
			</div>
		</div>
				
		<div class="row">
			<div class="col-md-6">
				<div class="control-group">
					<label for="vara">Quantidade de Varas <span class="vermelho">*</span></label>
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-tag"></i>
						</span>
						<input class="form-control"
								name="vara"
								id="vara"
								type="number" 
								placeholder="0" 
								pattern="\d{1,2}"
								size="2"
								maxlength="2" 
								oninput="Mensagem()"
								required>
					</div>
					<div class="help-block vermelho"></div>
				</div>
			</div>
		</div>
				
		<div class="row">      
			<div class="pager">
				<button type="submit" id="submit" class="btn btn-success" aria-label="Left Align">
					<i class="fa fa-save"></i>
					Gravar Cidade
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