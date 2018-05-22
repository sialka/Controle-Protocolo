<?php
	/*
	*	PROTOCOLO-SQL-PRINT-INDIVIDUAL.PHP
	*	Gera impressão individual realizada pela pesquisa.
	*/
	
	#use controllers\UsuarioController;
	#use controllers\CidadeController;
	use controllers\ProtocoloController;
	#use controllers\MaquinaController;

	#use model\CidadeModel;
	use model\ProtocoloModel;

	require_once("../autoload.php");
    require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();

	# Validando $_POST
	if (!isset($_POST["dados"]) || !isset($_POST["regs"]) ){	
		header("Location: index.php");		
		die();
	} 	

	$cabecario_cidade = array();
	$rodape_usuario = array();

	$linha = "";
	$dados = $_POST["dados"];
	$regs = $_POST["regs"];		

	/*
	echo $dados;
	echo $regs;
	die();
	*/

	$protocoloController = new ProtocoloController();
	$protocolos = $protocoloController->buscaProtocolos($dados);		
	
	foreach ($protocolos as $protocolo){
	
		$data = $protocolo->getData();
		$cidade = $protocolo->getCidadeId();
		$vara = $protocolo->getVara();

		if ($vara == 0){		
			$vara = "-";
		}

		$processo = $protocolo->getProcesso();
		$chancela = $protocolo->getChancela();
		$maquina = $protocolo->getMaquinaId();
		$usuario = $protocolo->getUsuarioId();
		
		$linha = $linha.
				$data.' '.
				$cidade.str_repeat(" ", 30-strlen($cidade)).
				$vara.str_repeat(" ", 05-strlen($vara)).
				$processo.str_repeat(" ", 22-strlen($processo)).
				$chancela.str_repeat(" ", 10-strlen($chancela)).
				$maquina."\r\n"; 	

				
		// Cidades
		if (!in_array($cidade,$cabecario_cidade)){
			array_push($cabecario_cidade, $cidade);
		}
		// Usuarios		
		if (!in_array($usuario,$rodape_usuario)){
			array_push($rodape_usuario, $usuario);
		}
	}		

	/*
	var_dump($protocolos);
	var_dump($cabecario_cidade);
	var_dump($rodape_usuario);
	die();
	*/

	// Cabeçario e Rodape para o arquivo de impressao
	require_once("modelo_impressao.php");

	/*
	$cab_titulo = "POSTO AVANCADO TRT SAO PAULO - 02ª REGIAO\n";
	$cab_subtitulo = "PROTOCOLO INTEGRADO - CAPITAL\n";
	$cab_posto = "CASA DA ADVOCACIA E DA CIDADANIA - TRABALHISTA\n";
	$cab_end = "Avenida Ipiranga, 1.267 - 3ª andar - República\n\n";
	$titulo1 = "CONTROLE DE PROTOCOLO\n";
	$titulo = str_repeat(" ", 40-strlen($titulo1)/2).$titulo1;	
	$tabela = "DATA       CIDADE                        VARA PROCESSO(S)           CHANCELA  P\n\n";	
	$registros = count($protocolos);	
	$rod_total = "Total de ".$registros." registro(s).\n\n";
	$rod_usuarios = "Cadastrado por: ";
	$rod_data = "Recebido em: ____/ ____/ 20____.\n\n";
	$rod_ass0 = "___________________\n";
	$rod_ass1 = "Assinatura e Carimbo\n";
	$rod_ass2 = "Observação:\n";

	$cabecario_posto = 'POSTO AVANCADO TRT SAO PAULO - 02ª REGIAO';
	$cabecario_setor_parte1 = 'PROTOCOLO INTEGRADO - CAPITAL';
	$cabecario_setor_parte2 = 'CASA DA ADVOCACIA E DA CIDADANIA - TRABALHISTA';
	$cabecario_setor_endereco = 'Avenida Ipiranga, 1.267 - 3ª andar - República';
	$titulo = 'CONTROLE DE PROTOCOLO';
	$cabecario_titulo = str_repeat(" ", 40-strlen($titulo)/2).$titulo;	
	$cabecario_tabela = 'DATA       CIDADE                        VARA PROCESSO(S)           CHANCELA  P';
	$rodape_usuarios = 'Cadastrado por: ';
	$rodape_recebido = 'Recebido em: ____/ ____/ 20____.';
	$rodape_assinatura_parte1 = '___________________';
	$rodape_assinatura_parte2 = 'Assinatura e Carimbo';
	$rodape_observacao = 'Observação:';
	*/
	
	# Cabeçario
	$arquivo = $cabecario_posto."\r\n";
	$arquivo .= $cabecario_setor_parte1."\r\n";
	$arquivo .= $cabecario_setor_parte2."\r\n";
	$arquivo .= $cabecario_setor_endereco."\r\n";
	$arquivo .= "\r\n";
	$arquivo .= $cabecario_titulo."\r\n";
	
	#Subtitulo
	foreach ($cabecario_cidade as $nome){	
		$subtitulo = str_repeat(" ", 40-strlen($nome)/2).$nome;
		$arquivo .= $subtitulo."\r\n";
	}	
	$arquivo .= "\r\n";

	# Corpo (tabela de dados)
	$arquivo .= $cabecario_tabela."\r\n";
	$arquivo .= "\r\n";
	$arquivo .= $linha."\r\n";
	
	# Total de registros
	//$arquivo .= $rod_total;
	$arquivo .= "Total de ".$regs." registro(s).\r\n";
	$arquivo .= "\r\n";
	
	// Listandos os usuarios responsaveis pela digitacao
	$arquivo .= $rodape_usuarios;
	$chave = 1;
	$nomes = "";
	foreach ($rodape_usuario as $nome){	
		if ($chave){
			$nomes .= $nome;
			$chave=0;
		}else{
			$nomes .= ", ".$nome;
		}
	} 	
	
	$arquivo .= $nomes.".\n\n";		


	# Rodapé da Impressão
	$arquivo .= $rodape_recebido."\r\n";
	$arquivo .= "\r\n";
	$arquivo .= $rodape_assinatura_parte1."\r\n";
	$arquivo .= $rodape_assinatura_parte2."\r\n";
	$arquivo .= $rodape_observacao."\r\n";	

	if (file_exists("../impressao-individual.txt")) {
		unlink("../impressao-individual.txt");		
	}

	$fp = fopen("../impressao-individual.txt", "a");
	$escreve = fwrite($fp, $arquivo);
	fclose($fp); //-> OK   			
				

		/*					
		<iframe id="textfile" src="impressao2.txt"></iframe>
	
		
		<button class="btn btn-primary" onclick="print()">
			<i class="fa fa-print"></i>
			Imprimir
		</button>
		*/

	header("Location: ../protocolos-lista-impressao.php");
	die();
?>