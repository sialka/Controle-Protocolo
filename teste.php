<html>
	
	<head>
	
		<link rel="shortcut icon" type="image/x-png" href="favicon.ico">

	    <!-- CSS -->    
	    <link href="html/css/normalize.css" rel="stylesheet">    
	    <!-- Bootstrap Core CSS -->
	    <link href="html/css/bootstrap.min.css" rel="stylesheet">
	    <!-- MetisMenu CSS -->
	    <link href="html/css/metisMenu.min.css" rel="stylesheet">    
	    <!-- sb-admin Theme CSS -->
	    <link href="html/css/sb-admin-2.min.css" rel="stylesheet">
	    <!-- Custom Fonts -->
	    <link href="html/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	    <!-- DataTables CSS -->
	    <link href="html/css/dataTables.bootstrap.css" rel="stylesheet">
	    <!-- DataTables Responsive CSS -->
	    <link href="html/css/dataTables.responsive.css" rel="stylesheet">    
	    <!-- Custom CSS -->    
	    <link href="html/css/cp2-theme.css" rel="stylesheet">

	</head>
	<body>

		<div class="row">
			<div class="col-md-6">
				
					<label for="data">Data da Chancela <span class="vermelho">*</span></label>
					<input class="form-control" 
							id="data"
							name="data"
							type="text" 											
							pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" 
							title="dd/mm/aaaa" 								
							autofocus>
							

					<label id="ttt" for="cidade">Comarca (Destino do Processo) <span class="vermelho">*</span></label>
					<select class="form-control" 
							id="cidade" 
							name="cidade" 															
							required>									
							<option value="A">Cidade A</option>';
							<option value="B">Cidade B</option>';
							<option value="C">Cidade C</option>';
					</select>



				
			</div>
		</div>
  	
  	<!-- jQuery -->
    <script src="html/js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="html/js/bootstrap.min.js"></script>    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="html/js/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="html/js/sb-admin-2.js"></script>        
    <!-- Validação de inputs -->
    <script src="html/js/jqBootstrapValidation.js"></script>    

    <script src="html/js/jquery.dataTables.js"></script>
    <script src="html/js/dataTables.bootstrap.min.js"></script>
    <script src="html/js/dataTables.responsive.js"></script>    	
	<script type="text/javascript">	

		// Tratamento de Erro
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

		// Preparando o Formulario
		//$("#vara_qtd").css("display","none");
		//$("#maquina_nome ").css("display","none");	
		//carrega_varas();

		// Funções
		function MaquinaPosicao()
		{
			let maquina = document.getElementById("maquina");
			let maquinaPosicao = document.getElementById("maquina_posicao");
			maquinaPosicao.value = maquina.selectedIndex;			
		};

		function DesativaMsg()
		{
			maquina = document.getElementById("msg").style.display = 'none';
		};

		function carrega_varas()
		{
			
			var cidade = document.getElementById("cidade");			
			var item_cidade = cidade.selectedIndex;	
			//console.log(item_cidade);
			var varas = document.getElementById("vara_qtd");	
			varas.selectedIndex = item_cidade;	

			var vara = document.getElementById("vara");
			vara.options.length=0;

			// (*)cidades que não tem vara

			if (varas.value==0){	

				//console.log("caso especial");
				var opt = document.createElement("option");
				opt.text = 0;
				vara.add(opt);		
				
				//document.getElementById("vara").disabled = true;
				document.getElementById("processo").focus();

			}else{
				//document.getElementById("vara").disabled = false;
				for (i = 0; i < varas.value; i++) {
					//console.log(i+1);
					var opt = document.createElement("option");
					opt.text = i+1;
					vara.add(opt);
				}
				//document.getElementById("vara").focus();
			}
		};
				

		// Eventos	
		$("#data").change(function() {
	  		//$("#cidade option:first").attr('selected','selected').focus();  		
	  		$("#cidade").focus();  		
		});	
		$("#cidade").change(function() {
	  		carrega_varas(); 

	  		$("#vara").focus();
		});
		$("#vara").keypress(function() {  		
	  		$("#processo").focus().select();
		});
		$("#processo").change(function() {  		
	  		$("#maquina").focus();
		});
		$("#maquina").keypress(function() {  		
	  		$("#chancela").focus();
		});
		$("#chancela").keypress(function() {  		
	  		$("#enviar").focus();
		});

		/*	
		// Apontando para a vara correta
		let varaBco = document.getElementById("vara_bco").value;
		let vara = document.getElementById("vara");		
		vara.selectedIndex = varaBco-1;	

		// Apontando para a vara correta
		let maquinaPosicao = document.getElementById("maquina_posicao").value;
		let maquina = document.getElementById("maquina");		
		maquina.selectedIndex = maquinaPosicao;	
		//console.log(maquinaPosicao);
		MaquinaPosicao();


		document.getElementById("data").focus();
		*/

	</script>

	</body>	
</html>