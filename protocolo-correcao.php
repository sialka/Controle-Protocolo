<?php
	/*
	*  REFATORAR - DESATIVADO
	*/

	# Fazer os ajustes (pendente)
	//die();   

	use controllers\UsuarioController;	

	require_once("autoload.php");
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();

	$usuarioController = new UsuarioController();	
	$usuarios = $usuarioController->listaUsuarios();

	require_once("template/html-head.php"); 
?>
	
	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Protocolos") ?>
			<?php PageTitle("fa-pencil", "Correção de Protocolos") ?>
  		</div>
 	</div>

	<form class="form-horizontal" action="protocolo-correcao-lista.php" method="post">

		<?php
		    // caso ha protocolo_correcao_msg_success exibe e cai fora 
			MensagenSucesso("protocolo_correcao_msg_success");
			MensagenErro("protocolo_correcao_msg_error");    		

		?>	   					

		<!-- Titulo -->
		<div class="row">					
			<h4><i class="fa fa-search"></i> Filtro para Pesquisa</h4>	
		</div>

		<!-- Datas -->					
		<div class="row">						
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-sm-6">
					 	<label for="data">Data da Digitação <span class="vermelho">*</span></label>
					 	<div class="input-group">	 	
						 	<span class="input-group-addon">
						 		<i class="fa fa-pencil"></i>
							</span>
							<input class="form-control" 
									id="datadigitacao"
									name="datadigitacao"
									type="text"				
									pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" 
									title="dd/mm/aaaa" 									
									autofocus 
									required >
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
						</div>
					</div>
					<div class="col-sm-6">
					 	<label for="data">Data da Chancela <span class="vermelho">*</span></label>
					 	<div class="input-group">	 	
						 	<span class="input-group-addon">
						 		<i class="fa fa-pencil"></i>
							</span>
							<input class="form-control" 
									id="datachancela"
									name="datachancela"
									type="text"				
									pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" 
									title="dd/mm/aaaa" 									
									autofocus 
									required >
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
						</div>
					</div>
				</div>
			</div>							
		</div>

		<!-- Titulo -->
		<div class="row">					
			<h4><i class="fa fa-wrench"></i> Opções</h4>			
		</div>
			
		<!-- Usuarios -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-sm-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" id="check_usuario">
							</span>
				    		<select class="form-control" id="usuario" name="usuario" disabled>
							  	<?php foreach ($usuarios as $usuario) : ?>
							  		<option value=<?= $usuario->getId() ?>><?= strtoupper($usuario->getNome()) ?></option>
					  			<?php endforeach ?>  	
							</select>
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- 2ª impressão -->	
		<div class="row">				
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-sm-6">
						<div class="input-group">
							<span class="input-group-addon">								
								<input type="checkbox" id="check_impressao" name="impressao">										
							</span>								
							<label class="form-control">
								2ª Malote
							</label>
						</div>
					</div>									
				</div>	
			</div>
		</div>

		<!-- Duplicado  -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-sm-6">
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" id="check_duplicado" name="duplicado">
							</span>
							<label class="form-control">
								Chancela Duplicada
							</label>
						</div>
					</div>									
				</div>						
			</div>
		</div>

		<div class="pager">
			<button class="btn btn-success">
				<i class="fa fa-search"></i>
				Pesquisar Protocolos
			</button>
			<a class="btn btn-danger" href="index.php">
				<i class="fa fa-arrow-left"></i>
				Cancelar
			</a>						    	
		</div>	

	</from>

<!-- Carregando o rodape -->
<?php require_once("template/footer-custom-start.php"); ?>
<script type="text/javascript">	

// Formatando a Data
let data = new Date();
let dataFormatada = ("0" + data.getDate()).substr(-2) + "/" + ("0" + (data.getMonth() + 1)).substr(-2) + "/" + data.getFullYear();

$("#datadigitacao").val(dataFormatada);
$("#datachancela").val(dataFormatada);

$( "#check_usuario" ).click(function() {	
	
	if ($("#usuario").prop("disabled"))
	{
		$("#usuario").prop("disabled", false).focus();
	}
	else
	{
		$("#usuario").prop("disabled", true);

	}

});

</script>
<?php require_once("template/footer-custom-end.php"); ?>