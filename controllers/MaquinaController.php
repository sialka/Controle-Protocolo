<?php
	/*
	* MAQUINACONTROLLER.PHP	
	* Este arquivo contém todas as ações que serão feitas na tabela MAQUINAS.
	*/
	namespace controllers;

	use model\ConnectionFactory;
	use model\MaquinaModel;	

	class MaquinaController{

		private $con;

		public function __construct(){
			# Faz conexão com o banco de dados
			$con = ConnectionFactory::getConnection();			
			$this->con = $con;			
		}

		function listaMaquinas(){
			
			# Lista todas as Máquinas
			$maquinas = array();
			$resultado = mysqli_query($this->con, "SELECT * FROM maquinas");
			while($maquina_atual = mysqli_fetch_assoc($resultado)) {

				$maquina = new MaquinaModel();
				$maquina->setId($maquina_atual['id']);
				$maquina->setNome($maquina_atual['nome']);

				array_push($maquinas, $maquina);
			}
			mysqli_close($this->con);
			return $maquinas;
		}

		function buscaMaquinaId(MaquinaModel $maquina) {	
			
			/* Busca Máquinas por Id
			* Retornos:
			* 1 - Achou
			* 0 - Não encontrou
			*/
			$query = "SELECT * FROM maquinas WHERE id={$maquina->getId()}";	
			$resultado = mysqli_query($this->con, $query);		
			$resultado->num_rows ? $retorno = "1" : $retorno = "0";						
			return $retorno;
		}

		function buscaMaquinaNome(MaquinaModel $maquina){			 	
		 	
			/* Busca Máquinas por Nome
			* Retornos
			* 1 - Achou
			* 0 - Não encontrou
			*/
			$query = "SELECT * FROM maquinas WHERE nome='{$maquina->getNome()}'";
			$resultado = mysqli_query($this->con, $query);
			$resultado->num_rows ? $retorno = "1" : $retorno = "0";						
			return $retorno;			
		}

		function editarMaquinas(MaquinaModel $maquina){	
		 
			/*
			* Editando Máquinas do Protocolo 		 
			* Retornos:
			* 0 - Transação ok
			* 1 - Erro na transação
			*/			

			# Verificando se a maquina já existe
			$busca = $this->buscaMaquinaNome($maquina);	
			if ($busca){				
				# Duplicando maquina com id diferente
				if ($maquina->getId() != $busca['id']){						
					mysqli_close($this->con);
					return "2";
				}
			}

			# Salvando a alteracao			
			$query = "UPDATE maquinas SET nome='{$maquina->getNome()}' WHERE id={$maquina->getId()}";	
			$resultado = mysqli_query($this->con, $query);			
			
			$resultado ? $retorno = "1" : $retorno = "0";

			mysqli_close($this->con);			

			return $resultado;
		}

		function adicionarMaquinas(MaquinaModel $maquina){
		 
			/* Adiciona Máquina
			* Retornos:
			* 0 - Salvo com sucesso
			* 1 - Máquina já cadastrada
			* 2 - Erro ao tentar salvar		 
			*/
			
			# Verificando se a maquina já existe pelo nome.
			$busca = $this->buscaMaquinaNome($maquina);
			if ($busca){
				return "1";		
			}		
			
			$query = "INSERT INTO maquinas (nome) VALUE ('{$maquina->getNome()}');";
			$resultado = mysqli_query($this->con, $query);	

			$resultado ? $retorno = "0" : $retorno = "2";			
			mysqli_close($this->con);		

			return $retorno;
		}

		function removerMaquinas(MaquinaModel $maquina) {
		
			/* Removendo Máquina
			* Retornos:
			* 0 - Transação Ok 
			* 1 - Erro ao tentar remover 
			*/		 			
			$query = "DELETE FROM maquinas WHERE id={$maquina->getId()};";		
			$resultado = mysqli_query($this->con, $query);			
			$resultado ? $retorno = "0" : $retorno = "1";
			return $retorno;
		}

		function contaMaquinas(){
		 
		 	# Contador de Máquinas
			$query = "SELECT count(id) FROM maquinas";
			$resultado = mysqli_query($this->con, $query);		
			$maquinas = mysqli_fetch_assoc($resultado);
			$total = $maquinas['count(id)'];
			mysqli_close($this->con);
			return $total;
		}

	}

?>