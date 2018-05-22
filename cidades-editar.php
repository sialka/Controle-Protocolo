<?php
	/**
	*  CIDADES-EDITAR.PHP
	*  VIEW - EDIÇÃO DE CIDADES
	*/
	
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_Adm(); 
    
    // tratamento de erro - caso nao exista id retorna para lista    
	if (!isset($_SESSION["cidade_editar_msg_success"]) && !isset($_SESSION["cidade_editar_msg_error"]))
	{		
		if (!isset($_POST["id"]) || !isset($_POST["cidade"]))
		{
			header("Location: index.php");
			die();
		}			
	}

	
	require_once("template/html-head.php"); 

?>

<!-- CSS adicional -->
<link href="html/css/cp2-listas.css" rel="stylesheet">


	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Cidades") ?>
			<?php PageTitle("fa-pencil", "Editando Cidade") ?>
  		</div>
 	</div>			            
	        		
	<?php
		// caso exista a sessoes
		if (!isset($_SESSION["cidade_editar_msg_success"]) && !isset($_SESSION["cidade_editar_msg_error"]))
		{
			$id = $_POST['id'];
			$cidade = $_POST['cidade'];
			$vara = $_POST['vara'];
		
	?>				
		
			<form method="POST" action="DAO/cidades-sql-editar.php" id="form" autocomplete="off">
		
				<div class="row">
					<h4><i class="fa fa-tags"></i> Cidade Selecionada</h4>
				</div>
				
				<div class="row">
					
					<table class="table table-striped table-bordered">
						<thead>
							<tr class="azul">
								<th>ID</th>
								<th>Cidade</th>
								<th>Varas</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td id="id"><?= $id?></td>
								<td id="cidadeAtual"><?= $cidade?></td>
								<td id="varaAtual"><?= $vara?></td>
							</tr>
						</tbody>
					</table>
					
				</div>				
					
				<div class="row">
					<h4><i class="fa fa-edit"></i> Novas Informações</h4>
					<div class="col-md-6">
						<label for="cidade">Nome da Cidade <span class="vermelho">*</span></label>
						<div class="control-group">
							<div class="form-group input-group">
								<span class="input-group-addon">
									<i class="fa fa-map-marker"></i>
								</span>
								<input class="form-control"
										name="cidade"
										id="cidade"
										type="nome" 
										value="<?= $cidade ?>" 
										placeholder="Digite o nome da cidade" 										
										title="Somente letras, não utilize acentuação"
										autofocus
										oninput="Mensagem()"
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
									value=<?= $vara ?>
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
						<button id="submit" type="submit" class="btn btn-success" disabled>
							<i class="fa fa-save"></i>
							Gravar Cidade
						</button>
						<a href="cidades-lista.php" class="btn btn-danger">
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

				MensagenSucesso("cidade_editar_msg_success");
				MensagenErro("cidade_editar_msg_error");
			    
				echo '
					<div class="pager">
						<a href="cidades-lista.php" class="btn btn-success">
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
        ValidaCidade();
    }; 		
	
	function ValidaCidade()
	{ 						
		
		let cidadeAtual = $("td#cidadeAtual").text();
		let varaAtual = $("#varaAtual").text();
		let cidade = $("#cidade").val();
		let vara = $("#vara").val();
		
		if (cidadeAtual == cidade && varaAtual == vara)
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