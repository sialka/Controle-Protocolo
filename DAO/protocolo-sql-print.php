<?php
	/*
	*	PROTOCOLO-SQL-PRINT.PHP
	*	Gerar relatorio de impressaão.
	*/
	
	use controllers\UsuarioController;
	use controllers\CidadeController;
	use controllers\ProtocoloController;
	use controllers\MaquinaController;

	use model\CidadeModel;
	use model\ProtocoloModel;

	#require_once("../autoload.php");
	#require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    #Esta_logado_DAO();

	# Validando $_POST
	if (!isset($_POST["data"]) || !isset($_POST["cidade"]) ){	
		header("Location: index.php");		
		die();
	}

	/* COLETANDO INFORMORMAÇÕES PARA IMPRESSÃO */

	# Coletando Data
	$data = $_POST["data"];	

	# Coletando Cidade(s)
	if (isset($_POST["cidade"])){
		if ($_POST["cidade"]=="true"){			
			$modo_impressao=0;
		}else{			
			$modo_impressao=1;
		}
	}

	# 2ª Impressão / Malote
	if (isset($_POST["impressao"])){
		$imp = 1;
	} else {
		$imp = 0;
	}

	# Deletando o arquivo impressao.txt se existir, pois iremos criar outro
	if (file_exists("impressao.txt")) {		
		unlink("impressao.txt");
	}	


	// Cabeçario e Rodape para o arquivo de impressao
	require_once("modelo_impressao.php");

	# INICIANDO OS CONTROLLERS

	# Controller de Protocolo
	$protocoloController = new ProtocoloController();

	# Dados dos Usuarios
	$usuarioController =  new UsuarioController();
	$usuarios = $usuarioController->listaUsuarios();

	# Dados das Máquinas Protocolizadoras
	$maquinaController =  new MaquinaController();
	$maquinas = $maquinaController->listaMaquinas();		

	# Dados das Comarcas		
	$cidadeController =  new CidadeController();
	$cidades = $cidadeController->listaCidades();					

	# localizando os dados da cidade de são paulo e armazenando no array capital		
	foreach ($cidades as $cidade) {

		if ($cidade->getNome() == 'SAO PAULO'){
			#array_push($capital, $cidade);		
			$capital = new CidadeModel();
			$capital->setId($cidade->getId());
			$capital->setNome($cidade->getNome());
			$capital->setVaras($cidade->getVaras());
		}
	}

	# DETERMINANDO A QUANTIDADE DE CIDADES 

	# $modo_impressao = 0 -> CAPITAL
	# $modo_impressao = 1 -> GRANDE SÃO PAULO

	if ($modo_impressao == 0) {
		
		$qtd_cidades = 1;			
	
	}else{
	
		//desconta a cidade de spaulo		
		$qtd_cidades = count($cidades);	
	
		// Estatistica - Armazena qtd de comarcas que possuem impressoes
		$qtd_comarcas = array();		
	}	

	# PRIMEIRO LOOP - GIRO PELAS CIDADES
		 
		$contador = 0;	// Contador de Cidades
		$aponta_cidade = 0; // Apontador de Cidade
		
		$conta_varas_capital = 0; // Estatistica - Armazena qtd de varas que possuem impressão			
		$conta_cidades = 0; // Estatistica - Armazena qtd de cidades que possuem impressão	

		while($aponta_cidade < $qtd_cidades){									
			
			# Preparando dados para buscas
			if ($modo_impressao == 0) {						
			   	
			   	# Capital			
			   	$cidade = $capital->getNome();
				$qtd_varas = $capital->getVaras();								
				$id_cidade = $capital->getId();						
			
			}else{
				
				# Grande São Paulo								
				if ($cidades[$aponta_cidade]->getId() == $capital->getId()){
					// Pular a cidade de SPaulo
					$aponta_cidade++;
				}
				
				$cidade = $cidades[$aponta_cidade]->getNome();				
				$qtd_varas = $cidades[$aponta_cidade]->getVaras();				
				$id_cidade = $cidades[$aponta_cidade]->getId();						

			}	

			//Loop das varas
			$i = 0;				
			
			// Caso a cidade não possui varas o loop acontece apenas uma vez.		
			if ($qtd_varas == 0){
				$i_varas = 0;
			}else{
				$i_varas = 1;
			}					
			
			# SEGUNDO LOOP - GIRA PELAS VARAS DAS CIDADES

			while($i_varas <= $qtd_varas){		

				// contador de varas para estatistica capital
				// variavel responsavel pelo if que faz a contagem de varas que contem impressao
				$chave_conta_vara = 1;

				$buscaCidade = new ProtocoloModel();
				$buscaCidade->setData($data);
				$buscaCidade->setCidadeId($id_cidade);				
				$buscaCidade->setImpressao($imp);

				if ($cidades[$aponta_cidade]->getVaras()==0){
					$buscaCidade->setVara(0);
				}else{
					$buscaCidade->setVara($i_varas);
				}				

				# Fazendo as buscas.	
				$res = $protocoloController->buscaPorCidadeParaImpressao($buscaCidade);	

				# Se houver retorno da busca
				if ($res) {				
					
					# Estatisticas - Capital
					if ($modo_impressao == 0) {
					
						# Contando a quantidade de varas que possuem impressão
						if ($chave_conta_vara) {
							$conta_varas_capital++;
							$chave_conta_vara=0;
						}

					}

					# Estatisticas - Grande São Paulo
					if ($modo_impressao == 1) {
						
						# Contando a quantidade de cidades que possuem impressão
						$atual = $id_cidade;
						if (!in_array($atual,$qtd_comarcas)){
							array_push($qtd_comarcas, $atual);
						}

					}

					// Armazena o nome do usuario que digitou o protocolos no cp2
					$usuarios_lista = array();

					# Gerando os dados da pesquisa
					$dados = '';			
					
					for ($i=0; $i < count($res); $i++){

						# Data
						$dados .= $res[$i]->getData().' ';

						# Cidade
						$comarca = localizaNomePorId($cidades, $id_cidade);
						$dados .= $comarca.str_repeat(" ", 30-strlen($comarca));
						
						# Vara
						if($qtd_varas == 0){
							$vara = '-';
						}else{
							
							$vara = $res[$i]->getVara();
						}						
						$dados .= $vara.str_repeat(" ", 05-strlen($vara));

						# Processo						
						$processo = $res[$i]->getProcesso();
						$dados .= $processo.str_repeat(" ", 22-strlen($processo));

						# Chancela						
						$chancela = $res[$i]->getChancela();
						$dados .= $chancela.str_repeat(" ", 10-strlen($chancela));

						# Maquina
						$maquina = localizaNomePorId($maquinas, $res[$i]->getMaquinaId());
						$dados .= $maquina;

						# Usuario
						$registro_usuario = localizaUsuarioPorId($usuarios, $res[$i]->getUsuarioId());							
						if (!in_array($registro_usuario,$usuarios_lista)){
							array_push($usuarios_lista, $registro_usuario);
						}							
						
						$dados .= "\r\n";						
					}

					# Criando string com os nomes dos usuarios responsaveis pelas digitação dos protocolos
					$nomes = '';
					$chave = 1;
					foreach ($usuarios_lista as $nome){
						if ($chave){
							$nomes .= $nome;
							$chave = 0;
						}else{
							$nomes .= ", ".$nome;
						}
					} 
					$nomes .= ".";					

					# GERANDO ARQUIVO TXT

					# Criando o arquivo
					$fp = fopen("impressao.txt", "a");					
					
					# Formatando o cabeçario da pagina
					$arquivo = '';
					$arquivo .= $cabecario_posto."\r\n";
					$arquivo .= $cabecario_setor_parte1."\r\n";
					$arquivo .= $cabecario_setor_parte2."\r\n";
					$arquivo .= $cabecario_setor_endereco."\r\n";
					$arquivo .= "\r\n";
					$arquivo .= $cabecario_titulo."\r\n";				

					# Titulo e subtitulo
					if($qtd_varas == 0){
						$cabecario_subtitulo = $cidade;
					} else {
						$cabecario_subtitulo = $cidade . ' - ' . $i_varas . 'ª VARA';						
					}					
					$arquivo .= str_repeat(" ", 40 - strlen($cabecario_subtitulo) / 2 ).$cabecario_subtitulo;

					$arquivo .= "\r\n";
					$arquivo .= "\r\n";
					$arquivo .= $cabecario_tabela."\r\n";
					$arquivo .= "\r\n";

					# Dados gerado pela pesquisa já formatado
					$arquivo .= $dados;
					$arquivo .= "\r\n";					
					
					# Total de Protocolos
					$arquivo .= 'Total de '.count($res).' registro(s).'."\r\n";
					$arquivo .= "\r\n";
					
					# Usuarios responsaveis pela digitação
					$rodape_usuarios = 'Cadastrado por: ' .$nomes;
					$arquivo .= $rodape_usuarios."\r\n";

					# Radape					
					$arquivo .= "\r\n";
					$arquivo .= $rodape_recebido."\r\n";
					$arquivo .= "\r\n";
					$arquivo .= $rodape_assinatura_parte1."\r\n";
					$arquivo .= $rodape_assinatura_parte2."\r\n";
					$arquivo .= $rodape_observacao."\r\n";

					# Completando o restanta da folha A4 com enter.

					# Cabeçario + Rodape = 20 linhas + contagem dos registro da busca
					$linha = 20+count($res);

					# Pagina A4 contem 73 linhas
					if ($linha < 73) {											
						$falta = 73 - $linha;										
						for ($a=0; $a<=$falta; $a++){							
							$arquivo .= "\r\n";
						}
						
					}
					
					# Salvando o arquivo txt para impressão
					$escreve = fwrite($fp, $arquivo);
					fclose($fp);
													
				}				
				
				# Contador de Vara
				$i_varas++;							
			}
			
			# Contador de Cidade
			$aponta_cidade++;		
		}	


	if (!isset($_SESSION)) session_start();
	
	$msg_success = null;
	$msg_error  = null;



	if (file_exists("impressao.txt")) {		

		if ($modo_impressao == 0){
			$msg_success = '
				<i class="fa fa-print fa-2x"></i>
				<br><strong>PRONTO PARA IMPRESSÃO</strong><br><br>
				<i class="fa fa-calendar"></i> '.$data.'
				<i class="fa fa-map-marker"></i> SÃO PAULO			        		
				<i class="fa fa-database"></i> Quantidade de Varas: '.$conta_varas_capital;			
		}else{
			$msg_success = '
				<i class="fa fa-print fa-2x"></i>
				<br><strong>PRONTO PARA IMPRESSÃO</strong><br><br>			
				<i class="fa fa-calendar"></i> '.$data.'
				<i class="fa fa-database"></i> Quantidade de Cidades: '.count($qtd_comarcas);			
		}
		$_SESSION["protocolo_print_msg_success"] = $msg_success;
	}else{

		$msg_error = 'Não houve protocolos recebidos no dia <strong>'.$data.'</strong>';
		
		if ($modo_impressao == 0){
			$msg_error .= ', para a <strong>Capital</strong>';
		}else{
			$msg_error .= ', para a <strong>Grande São Paulo</strong>';
		}

		if ($imp == 0){
			$msg_error .= ', no <strong>primeiro malote</strong>.';
		}else{
			$msg_error .= ', no <strong>segundo malote</strong>.';
		}
		$_SESSION["protocolo_print_msg_error"] = $msg_error;
	}
?>
