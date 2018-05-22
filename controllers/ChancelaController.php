<?php
	/*
	* CHANCELACONTROLLER.PHP
	* Este arquivo contem todas as ações que serão feitas na tabela CHANCELAS.
	*/
	namespace controllers;

	use model\ConnectionFactory;
	use model\ChancelaModel;	
	use model\UltimaChancelaModel;	
	use model\MaquinaModel;	

	class ChancelaController{

		private $con;
		private $tabela = 'chancelas2017';		

		public function __construct()
		{
			# Faz conexão com o banco de dados
			$con = ConnectionFactory::getConnection();			
			$this->con = $con;			
		}

		function listaChancelas(ChancelaModel $chancela)
		{

		 	# Lista todas as Chancelas.
			$lista = array();		
			$query = "SELECT c.*, m.nome as nome FROM ".$this->tabela." c LEFT JOIN (maquinas m) ON c.maquina_id = m.id WHERE maquina_id={$chancela->getMaquinaid()} AND mes={$chancela->getMes()} AND ano={$chancela->getAno()}";
			$resultado = mysqli_query($this->con, $query);	

			while($chancelas_atual = mysqli_fetch_assoc($resultado))
			{		

				# Objeto Chancela
				$chancela = new ChancelaModel;		
				$chancela->setId($chancelas_atual['id']);
				$chancela->setData($chancelas_atual['data']);				
				# $chancela->setMaquinaId($chancelas_atual['maquina_id']);
				$chancela->setMaquinaId($chancelas_atual['nome']);
				$chancela->setInicio($chancelas_atual['inicio']);
				$chancela->setFinal($chancelas_atual['final']);
				$chancela->setMes($chancelas_atual['mes']);
				$chancela->setAno($chancelas_atual['ano']);

				array_push($lista, $chancela);
			}

			mysqli_close($this->con);
			return $lista; 
		}

		function buscaChancela(ChancelaModel $chancela)
		{
			/*
			* Buscando Chancela
			* Comparamos se a chancela inicial ou final coinside com as passadas.
			* Retornos:
			* 0 - Não achou
			* 1 - Achou
			*/

			$query1 = "SELECT count(*) FROM ".$this->tabela." WHERE maquina_id={$chancela->getMaquinaId()} AND inicio={$chancela->getInicio()}";
			$query2 = "SELECT count(*) FROM ".$this->tabela." WHERE maquina_id={$chancela->getMaquinaId()} AND final={$chancela->getFinal()}";

			$resultado1 = mysqli_query($this->con, $query1);
			$resultado2 = mysqli_query($this->con, $query2);

			$chancela1 = mysqli_fetch_assoc($resultado1);
			$chancela2 = mysqli_fetch_assoc($resultado2);	 

			
			if ($chancela1['count(*)']>0)
			{						
				return "1";		
			}	
			if ($chancela2['count(*)']>0)
			{						
				return "1";
			}					
			
			return "0";
		}	

		function verificaChancelaData(ChancelaModel $chancela)
		{
			/*
			* Buscan Chancela por Data
			* Retornos:
			* 0 - Não encontrou.
			* 1 - Encontrou.
			*/
			
			$query = "SELECT count(*) FROM ".$this->tabela." WHERE maquina_id={$chancela->getMaquinaId()} AND data='{$chancela->getData()}'";
			$resultado = mysqli_query($this->con, $query);
			$chancela = mysqli_fetch_assoc($resultado);
			if ($chancela['count(*)']>0)
			{						
				return "1";		
			}				
			return "0";
		}

		function adicionarChancela(ChancelaModel $chancela){
			/*
			* Adicionando uma nova chancela.
			* Retornos
			* 0 - Salvo com sucesso
			* 1 - Chancela já cadastrada
			* 2 - Chancela inicial maior que chancela final
			* 3 - Erro ao tentar salvar
			*/

			# Verificando se a chancela já está cadastrada
			$busca = $this->buscaChancela($chancela);			
			if ($busca)
			{
				mysqli_close($this->con);
				return "1";
			}	

			# Verifica se a chancela->inicio é maior que a chancela->final 
			if ($chancela->getInicio() > $chancela->getFinal())
			{		
				mysqli_close($this->con);
				return "2";
			}	

			# Setando mês e ano.
			$chancela->setMes(intval(substr($chancela->getData(),3,2)));
			$chancela->setAno(intval(substr($chancela->getData(),6,4)));

			# Verificar se a chancela já está cadastrada nesta data.
			$busca = $this->verificaChancelaData($chancela);

			if ($busca)
			{
				mysqli_close($this->con);
				return "1";
			}

			# Salvando a nova chancela.
			$query = "INSERT INTO ".$this->tabela." (data, maquina_id, inicio, final, mes, ano) VALUE ('{$chancela->getData()}', {$chancela->getMaquinaId()}, {$chancela->getInicio()}, {$chancela->getFinal()}, {$chancela->getMes()}, {$chancela->getAno()})";
			$resultado = mysqli_query($this->con, $query);
			if ($resultado)
			{
				mysqli_close($this->con);
				return "0";	
			}
			else
			{
				mysqli_close($this->con);
				return "3";		
			}
		}

		function ultimaChancela($id_maquina)
		{	

			/*
			* Pesquisando as últimas chancelas de cada máquina.
			* Listando em ordem ascendente.
			* Retornos:
			* 0 - Caso não haja registros;
			* Caso haja registro retornamos o array do mesmo
			*/

			$ultimo = array();			
			
			//$query = "SELECT * FROM ".$this->tabela." WHERE maquina_id= ".$id_maquina." ORDER BY mes AND final ASC";			
			$query = "SELECT * FROM ".$this->tabela." WHERE maquina_id= ".$id_maquina;			
			
			$resultado = mysqli_query($this->con, $query);			

			while($chancela = mysqli_fetch_assoc($resultado))
			{
				array_push($ultimo, $chancela);
			}				
			
			if (count($ultimo) == 0)
			{
				//mysqli_close($this->con);
				return "0";
			}
			else
			{					
				
				return $ultimo[count($ultimo)-1]['final'];
			}	
		}

		function removerChancelas(ChancelaModel $chancela)
		{
			/*
			* Removendo uma chancela
			* Retornos:
			* 0 - Transação OK
			* 1 - Erro ao tentar excluir chancela
			*/
			
			$query = "DELETE FROM ".$this->tabela." WHERE id={$chancela->getId()};";					
			$resultado = mysqli_query($this->con, $query);
			$resultado ? $retorno = "1" : $retorno = "0";			
			mysqli_close($this->con);
			return $retorno;
		}

		function ultimasChancelas()
		{
			# Mostra ultimas chancelas.

			# Cria objeto com a info da chancela
			$objetos = array();			
			$i = 0;
			$query = "SELECT id, nome FROM maquinas";		
			$retorno = mysqli_query($this->con, $query);					
			while($maquina = mysqli_fetch_assoc($retorno))
			{				
				$objeto = new UltimaChancelaModel;
				$objeto->setidMaquina($maquina['id']);
				$objeto->setNome($maquina['nome']);	
				array_push($objetos, $objeto);				
			}							
			
			# Adiciona apenas o ultima numerado de cada maquina
			$i = 0;
			foreach ($objetos as $objetoId)
			{			

				$query = "SELECT final FROM ".$this->tabela." WHERE maquina_id = ".$objetoId->getidMaquina()." ORDER BY id DESC LIMIT 1;";
				$resultado = mysqli_query($this->con, $query);		
				$chancelas = mysqli_fetch_assoc($resultado);							
				
				if ($chancelas['final']==null)
				{
					$objetos[$i]->setChancela("0");					
				}
				else
				{					
					$objetos[$i]->setChancela($chancelas['final']);					
				}
				
				
				$i++;

			}	
			
			return $objetos;
			
		}

	}

?>