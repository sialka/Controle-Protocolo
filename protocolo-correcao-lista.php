<?php
	/*
	* REFATORAR - DESATIVADO
	*/

	use controllers\ProtocoloController;	

	require_once("autoload.php");
	require_once("lib-v1.php");

    # Verifica se o usuario está logado
    Esta_logado();

	if (isset($_POST['datadigitacao']))
	{
		$dt_digitacao = $_POST['datadigitacao'];
	}
	else
	{
		// erro
		die();
	}

	if (isset($_POST['datachancela']))
	{
		$dt_chancela = $_POST['datachancela'];
	}
	else
	{
		// erro
		die();
	}

	$pesquisa = "data='".$dt_chancela."' and digitacao='".$dt_digitacao."' ";
	
	if (isset($_POST['usuario']))
	{
		$usuario = $_POST['usuario'];
		$pesquisa .= " and usuario_id=".$usuario;
	}

	if (isset($_POST['impressao']))
	{
		$impressao = $_POST['impressao'];
		$pesquisa .= " and impressao=1 ";
	}
	else
	{
		$pesquisa .= " and impressao=0 ";	
	}

	if (isset($_POST['duplicado']))
	{
		$impressao = $_POST['duplicado'];
		$pesquisa .= " and duplicado=1 ";
	}		
	else
	{
		$pesquisa .= " and duplicado=0 ";
	}	
	
	$protocoloController = new ProtocoloController();		
	$busca = $protocoloController->contaProtocolosCorrecao($pesquisa);	
	
	require_once("template/html-head.php"); 
?>

	<div class="row">		            
        <div class="col-md-12">
			<?php PageHeader("Protocolos") ?>
			<?php PageTitle("fa-pencil", "Protocolos para Correção") ?>
  		</div>
 	</div>

	<?php
        if ($busca==0)
        {	

    		echo '        				        		
    		<div class="row">
        		<div class="alert alert-danger pager">
        			<i class="fa fa-times"></i>
        			Não há registro de Protocolos com esses dados
        		</div>
        	</div>'; 			        						

			echo '
			<div class="pager">
				<a href="protocolo-correcao.php" class="btn btn-success">
					<i class="fa fa-arrow-left"></i>
					Voltar
				</a>			        	
			</div>';			        
    	
    	}
        else
        {
        	echo '
        		<div class="row">
	        		<div class="alert alert-info pager" role="alert">
	        			<i class="fa fa-search"></i>
	        			Foram localizados: <strong>'.$busca.'</strong> protocolo(s).
	        		</div>
        		</div>';
        		?>		        	

	        <form class="form-horizontal" action="DAO/protocolo-sql-correcao.php" method="post">

	        	<div class="row">							
					<h4 class="text-left">
						<i class="fa fa-pencil"></i>
						Dados para Alteração dos Protocolos
					</h4>
				</div>
				
				<!-- dados para where da update -->
				<input type="hidden" name="pesquisa" value="<?= $pesquisa?>">
						
				<!-- Data -->					
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div class="col-sm-6">
							 	<label for="data">Data da Chancela <span class="vermelho">*</span></label>
							 	<div class="input-group">	 	
								 	<span class="input-group-addon">
								 		<i class="fa fa-pencil"></i>
									</span>
									<input class="form-control" 
											id="novadata"
											name="novadata"
											type="text"				
											pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" 
											title="dd/mm/aaaa" 
											onkeydown="dataEnter(event)"
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

				<!-- 2ª impressão -->
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon">								
										<input type="checkbox" id="nova_check_impressao" name="impressao">										
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
										<input type="checkbox" id="nova_check_duplicado" name="duplicado">
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
					<?php 
						if ($busca)
						{
							echo '
								<button class="btn btn-success">
									<i class="fa fa-check"></i>
									Salvar Alterações
								</button>';
						}
					?>
					<a href="protocolo-correcao.php" class="btn btn-danger">
						<i class="fa fa-arrow-left"></i>
						Cancelar
					</a>
				</div>

	        </from>

        <?php			        
        }
    	?>	       

<!-- Carregando o rodape -->
<?php require_once("template/footer-custom-start.php"); ?>
<script type="text/javascript">	

	// Formatando a Data
	let data = new Date();
	let dataFormatada = ("0" + data.getDate()).substr(-2) + "/" + ("0" + (data.getMonth() + 1)).substr(-2) + "/" + data.getFullYear();
	
	$("#novadata").val(dataFormatada);

</script>
<?php require_once("template/footer-custom-end.php"); ?>