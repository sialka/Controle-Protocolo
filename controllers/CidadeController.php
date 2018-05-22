<?php
	/*
	* CIDADECONTROLLER.PHP	
	* Este arquivo contém todas as ações que serão feitas na tabela CIDADES.
	*/
	namespace controllers;

	use model\ConnectionFactory;
	use model\CidadeModel;	

	class CidadeController{

		private $con;

		public function __construct(){
			# Faz conexão com o banco de dados
			$con = ConnectionFactory::getConnection();			
			$this->con = $con;			
		}
	 	
		function listaCidades(){
			
			# Lista todas as Cidades
			$cidades = array();
			$resultado = mysqli_query($this->con, "SELECT * FROM cidades ORDER BY nome;");	
			while($cidade_atual = mysqli_fetch_assoc($resultado)) {

				$cidade = new CidadeModel();
				$cidade->setId($cidade_atual['id']);
				$cidade->setNome($cidade_atual['nome']);
				$cidade->setVaras($cidade_atual['varas']);

				array_push($cidades, $cidade);
			}
			mysqli_close($this->con);
			return $cidades;
		}

		function buscaCidadeId($id) {			
			
			/* Busca Cidade por Id
			* Retornos:
			* 1 - Achou
			* 0 - Não encontrou
			*/				
			$query = "SELECT * FROM cidades WHERE id=$id";		
			$resultado = mysqli_query($this->con, $query);
			$resultado->num_rows ? $retorno = "1" : $retorno = "0";						
			return $retorno;
		}

		function buscaCidadeNome($nome){	
			
			/* Busca Cidade por Nome
			* Retornos:
			* 1 - Achou
			* 0 - Não encontrou
			*/	
			$query = "SELECT * FROM cidades WHERE nome='{$nome}'";		
			$resultado = mysqli_query($this->con, $query);	
			$resultado->num_rows ? $retorno = "1" : $retorno = "0";						
			return $retorno;
		}

		function editarCidades(CidadeModel $cidade){	
	
			/*
			* Editando uma cidade especifica
			* Retornos
			* 0 - Transacao Ok
			* 1 - Erro ao tentar salvar alteracao
			* 2 - Tentando alterar a cidade para um nome de outro ID
			* function editarCidades($conexao, $id, $cidade, $vara){	
			*/

			# Verificando se a cidade já existe
			$busca = $this->buscaCidadeNome($cidade->getNome());				
			if ($busca){				
				mysqli_close($this->con);
				return "2";
			}						

			# Salvando a alteracao
			$query = "UPDATE cidades SET nome='{$cidade->getNome()}', varas={$cidade->getVaras()} WHERE id={$cidade->getId()}";	
			$resultado = mysqli_query($this->con, $query);	
			$resultado ? $retorno = "0" : $retorno = "1";
			mysqli_close($this->con);
			return $retorno;			
		}

		function adicionarCidades(CidadeModel $cidade){	
		 
			/*
			* Adicionando uma nova Cidade 
			* Retornos:
			* 0 - Salvo com sucesso
			* 1 - Cidade já cadastrada
			* 2 - Erro ao tentar salvar			
			*/
			
			# Verificando se a cidade já existe.
			$busca = $this->buscaCidadeNome($cidade->getNome());	
			if ($busca){
				mysqli_close($this->con);
				return "1";
			}

			# Salvando nova cidade.
			$query = "INSERT INTO cidades (nome, varas) VALUE ('{$cidade->getNome()}', {$cidade->getVaras()})";		
			$resultado = mysqli_query($this->con, $query);
			$resultado ? $retorno = "0" : $retorno = "1";			
			mysqli_close($this->con);
			return $retorno;
		}

		function removerCidades(CidadeModel $cidade) {

			/*
			* Removendo uma cidade 
			* Retornos:
			* 0 - Transação OK
			* 1 - Erro ao tentar excluir 
			*/
			$query = "DELETE FROM cidades WHERE id={$cidade->getId()}";			
			$resultado = mysqli_query($this->con, $query);
			$resultado ? $retorno = "0" : $retorno = "1";			
			mysqli_close($this->con);
			return $retorno;
		}

		function contaCidades(){
		 
			# Contador de Máquinas
			$query = "SELECT count(id) FROM cidades";					
			$resultado = mysqli_query($this->con, $query);		
			$cidades = mysqli_fetch_assoc($resultado);
			$total = $cidades['count(id)'];
			mysqli_close($this->con);
			return $total;
		}
	}
	
?>