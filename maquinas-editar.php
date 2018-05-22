<?php
	/*
	*	MAQUINAS-EDITAR.PHP
	*	VIEW - EDIÇÃO DE MAQUINAS PROTOCOLOLIZADORAS
	*/
    
    require_once("lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_Adm(); 
    
    // tratamento de erro - caso nao exista id retorna para lista    
	if (!isset($_SESSION["maquina_editar_msg_success"]) && !isset($_SESSION["maquina_editar_msg_error"]))
	{		
		if (!isset($_POST["id"]))
		{
			header("Location: index.php");
			die();
		}	
	}

	require_once("template/html-head.php"); 

?>

	<?php require_once("template/html-menu.php"); 

		// caso exista a sessoes
		if (!isset($_SESSION["maquina_editar_msg_success"]) && !isset($_SESSION["maquina_editar_msg_error"]))
		{		
			
			$id = $_POST["id"];			
			$maquina = $_POST["maquina"];
		}

	?>	

	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Máquinas") ?>
			<?php PageTitle("fa-pencil", "Editando Máquina") ?>
  		</div>
 	</div>

	<?php
		// caso exista a sessoes
		if (!isset($_SESSION["maquina_editar_msg_success"]) && !isset($_SESSION["maquina_editar_msg_error"]))
		{

			$id = $_POST['id'];
			$maquina = $_POST['maquina'];
	?>

			<form method="POST" action="DAO/maquinas-sql-editar.php" id="form" autocomplete="off">

				<div class="row">
					<h4><i class="fa fa-tags"></i> Identificação da Máquina</h4>
				</div>

				<div class="row">
					
					<table class="table table-striped table-bordered">
						<thead>
							<tr class="azul">
								<th>ID</th>
								<th>Máquina</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td id="id"><?= $id?></td>
								<td id="maquinaAtual"><?= $maquina?></td>								
							</tr>
						</tbody>
					</table>
					
				</div>
				
				<div class="row">
					<h4><i class="fa fa-edit"></i> Novas Informações</h4>								
					<div class="col-md-6">
						<label>Nome da Máquina <span  class="vermelho">*</span></label>		
						<div class="control-group">
							<div class="form-group input-group">
								<span class="input-group-addon">
									<i class="fa fa-barcode"></i>
								</span>
								<input class="form-control"
										name="maquina"
										id="maquina"
										type="nome" 
										value="<?= $maquina ?>" 										
										title="Minimo 03 letras"
										placeholder="Digite o nome da Maquina" 
										oninput="Mensagem()"
										autofocus required>
							</div>
							<p class="help-block vermelho"></p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="pager">
						<button id="submit" type="submit" class="btn btn-success" disabled>
							<i class="fa fa-save"></i>
							Gravar Máquina
						</button>
						<a href="maquinas-lista.php" class="btn btn-danger">
							<i class="fa fa-arrow-left"></i>
							Cancelar
						</a>
					</div>
				</div>

			</form>  			
					
	<?php
    		
		}
		else
		{
		
			MensagenSucesso("maquina_editar_msg_success");
			MensagenErro("maquina_editar_msg_error");    				

			echo '
				<div class="pager">
					<a href="maquinas-lista.php" class="btn btn-danger">
						<i class="fa fa-arrow-left"></i>
						Voltar
					</a>
				</div>
				';
		}
	?>

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
        ValidaMaquina();
    }; 		
	
	function ValidaMaquina()
	{ 						
		
		let maquinaAtual = $("td#maquinaAtual").text();
		let maquina = $("#maquina").val();		

		if (maquinaAtual == maquina)
		{
			$("#submit").prop("disabled",true);
        }
        else
        {	            
            $("#submit").prop("disabled",false);
        }
        
    };
</script>		

<?php require_once("template/footer-custom-end.php"); ?>