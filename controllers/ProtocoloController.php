<?php
	/* 
	* PROTOCOLO CONTROLLER
	* Este arquivo contem todas as ações que serão feitas na tabela PROTOCOLOS.
	*/
	namespace controllers;

	use model\ConnectionFactory;
	use model\ProtocoloModel;	
	use model\CidadeModel;	
	use model\MaquinaModel;	
	use model\UsuarioModel;	

	class ProtocoloController{

		private $con;
		private $tabela = 'protocolos2017';

		public function __construct()
		{
			# Faz conexão com o banco de dados
			$con = ConnectionFactory::getConnection();						
			$this->con = $con;			
		}

		function buscaChancelaNoProtocolo(ProtocoloModel $protocolo) 
		{
			# Busca por Chancela e Id e retorna o objeto 					
			$query = "SELECT * FROM ".$this->tabela." WHERE chancela='{$protocolo->getChancela()}' AND maquina_id={$protocolo->getMaquinaId()}";			
			$resultado = mysqli_query($this->con, $query);
			
			return mysqli_fetch_assoc($resultado);
		}	

		function insereProtocolo(ProtocoloModel $protocolo)
		{

			# Insere Protocolo - Retorna 0 caso já exista e 1 se não houver.

			# Verificando se o protocolo há existe na base ddados
			$consulta = $this->buscaChancelaNoProtocolo($protocolo);			
			
			# Se o checkbox duplicado estiver habilitado, insere sem verificar duplicidade mesmo que haja.
			if ($protocolo->getDuplicado())
			{
				
				# Inserindo o novo protocolo.
				$query = "INSERT INTO ".$this->tabela." (data, destino_id, vara, processo, chancela, maquina_id, usuario_id, duplicado, impressao, digitacao) VALUES ('{$protocolo->getData()}', {$protocolo->getCidadeId()}, {$protocolo->getVara()}, '{$protocolo->getProcesso()}', {$protocolo->getChancela()}, {$protocolo->getMaquinaId()}, {$protocolo->getUsuarioId()}, {$protocolo->getDuplicado()}, {$protocolo->getImpressao()},'{$protocolo->getDigitacao()}')";				
				$resultado = mysqli_query($this->con, $query);				
				$resultado ? $retorno = "1" : $retorno = "0";			
				mysqli_close($this->con);
				return $retorno;

			}
			else
			{

				# Se $consulta retorna true, já existe um registro na tabela
				if ($consulta){
					mysqli_close($this->con);
					return "0";
				}
				else
				{
					# Inserindo o novo protocolo.
					$query = "INSERT INTO ".$this->tabela." (data, destino_id, vara, processo, chancela, maquina_id, usuario_id, duplicado, impressao, digitacao) VALUES ('{$protocolo->getData()}', {$protocolo->getCidadeId()}, {$protocolo->getVara()}, '{$protocolo->getProcesso()}', {$protocolo->getChancela()}, {$protocolo->getMaquinaId()}, {$protocolo->getUsuarioId()}, {$protocolo->getDuplicado()}, {$protocolo->getImpressao()},'{$protocolo->getDigitacao()}')";			
					$resultado = mysqli_query($this->con, $query);
					$resultado ? $retorno = "1" : $retorno = "0";			
					mysqli_close($this->con);
					return $retorno;

				}
			}
		}

		function buscaProtocolos($dados)
		{
			# Busca Protocolo
						
			$protocolos = array();
			$resultado = mysqli_query($this->con, "SELECT p.id, p.data, c.nome AS cidade, p.vara, p.processo, p.chancela, m.nome AS maquina, u.usuario AS usuario, p.duplicado, p.impressao, p.digitacao FROM ".$this->tabela." p LEFT JOIN (cidades c, maquinas m, usuarios u) ON p.destino_id = c.id AND p.maquina_id = m.id AND p.usuario_id = u.id WHERE ".$dados);

			while($protocolo_atual = mysqli_fetch_assoc($resultado))
			{				

				$protocolo = new ProtocoloModel();
				$protocolo->setId($protocolo_atual['id']);
				$protocolo->setData($protocolo_atual['data']);
				$protocolo->setCidadeId($protocolo_atual['cidade']);
				$protocolo->setVara($protocolo_atual['vara']);
				$protocolo->setProcesso($protocolo_atual['processo']);
				$protocolo->setChancela($protocolo_atual['chancela']);
				$protocolo->setMaquinaId($protocolo_atual['maquina']);
				$protocolo->setUsuarioId($protocolo_atual['usuario']);
				$protocolo->setImpressao($protocolo_atual['impressao']);
				$protocolo->setDuplicado($protocolo_atual['duplicado']);
				$protocolo->setDigitacao($protocolo_atual['digitacao']);

				array_push($protocolos, $protocolo);
			}	
			
			mysqli_close($this->con);
			return $protocolos;
		}

		function deletaProtocolo(ProtocoloModel $protocolo)
		{
			# Remove protocolo - Retorno 1 OK, 0 Erro

			$query = "DELETE FROM ".$this->tabela." WHERE id={$protocolo->getId()}";	
			$resultado = mysqli_query($this->con, $query);		
			$resultado ? $retorno = "1" : $retorno = "0";			
			mysqli_close($this->con);
			return $retorno;
		}

		function buscaId($id)
		{

			# Busca Por Id do Protocolo
		 
			$query = "SELECT * FROM ".$this->tabela." WHERE id=$id";
			
			$resultado = mysqli_query($this->con, $query);
			$dados = mysqli_fetch_assoc($resultado);		

			$protocolo = new ProtocoloModel();			
			$protocolo->setId($dados['id']);
			$protocolo->setData($dados['data']);
			$protocolo->setCidadeId($dados['destino_id']);
			$protocolo->setVara($dados['vara']);
			$protocolo->setProcesso($dados['processo']);
			$protocolo->setChancela($dados['chancela']);			
			$protocolo->setMaquinaId($dados['maquina_id']);
			$protocolo->setImpressao($dados['impressao']);
			$protocolo->setDuplicado($dados['duplicado']);
			$protocolo->setDigitacao($dados['digitacao']);
			$protocolo->setUsuarioId($dados['usuario_id']);	
			
			mysqli_close($this->con);
			return $protocolo;
		}

		function alteraProtocoloId(ProtocoloModel $protocolo)
		{
			# Altera Protocolo por Id - Retornos 1 OK, 0 Erro

			$query = "UPDATE ".$this->tabela." SET data='{$protocolo->getData()}', destino_id={$protocolo->getCidadeId()}, vara={$protocolo->getVara()}, processo='{$protocolo->getProcesso()}', duplicado={$protocolo->getDuplicado()}, impressao={$protocolo->getImpressao()} WHERE id={$protocolo->getId()};";
			$resultado = mysqli_query($this->con, $query);		
			$resultado ? $retorno = "1" : $retorno = "0";			
			mysqli_close($this->con);
			return $retorno;			
		}

		function buscaPorCidadeParaImpressao(ProtocoloModel $protocolo)
		{

		 	# Busca por Cidade para gerar impressão			
			$query = "SELECT * FROM ".$this->tabela." WHERE data='{$protocolo->getData()}' and destino_id = {$protocolo->getCidadeId()} and vara = {$protocolo->getVara()} and impressao = {$protocolo->getImpressao()}";			
			$protocolos = array();
			$resultado = mysqli_query($this->con, $query);	

			while($registro = mysqli_fetch_assoc($resultado)) {

				$listaProtocolo = new ProtocoloModel();
				$listaProtocolo->setId($registro['id']);
				$listaProtocolo->setData($registro['data']);
				$listaProtocolo->setCidadeId($registro['destino_id']);
				$listaProtocolo->setVara($registro['vara']);
				$listaProtocolo->setProcesso($registro['processo']);
				$listaProtocolo->setChancela($registro['chancela']);
				$listaProtocolo->setMaquinaId($registro['maquina_id']);
				$listaProtocolo->setUsuarioId($registro['usuario_id']);
				$listaProtocolo->setImpressao($registro['impressao']);
				$listaProtocolo->setDuplicado($registro['duplicado']);
				$listaProtocolo->setDigitacao($registro['digitacao']);

				array_push($protocolos, $listaProtocolo);
			}			
			
			return $protocolos;
		}

		function contaProtocolos()
		{
			
			# Contador de Protocolos			
			$query = 'SELECT count(id) FROM '.$this->tabela;
			$resultado = mysqli_query($this->con, $query);		
			$protocolos = mysqli_fetch_assoc($resultado);
			$total = $protocolos['count(id)'];
			mysqli_close($this->con);
			return $total;
		}
		
		function contaProtocolosCorrecao($busca)
		{
			# Conta quantos protocolos serão alterados.
			$query = "SELECT count(id) FROM ".$this->tabela." WHERE ".$busca;
			$resultado = mysqli_query($this->con, $query);
			$protocolos = mysqli_fetch_assoc($resultado);

			return $protocolos['count(id)'];
		}
		
		function alteraProtocolosCorrecao($pesquisa, $data, $impressao, $duplicado)
		{
			# Altera protocolos de acordo com os dados: data chancela, data digitação, impressão e duplicidade
			$query = "UPDATE ".$this->tabela." SET data='{$data}', impressao=$impressao, duplicado=$duplicado WHERE $pesquisa;";			
			$resultado = mysqli_query($this->con, $query);		

			return $resultado;		
		}
		
	}

?>