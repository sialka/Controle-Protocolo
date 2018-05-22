<?php
	/*
	 * Model - MaquinaModel
	 * Representa a tabela Maquina
	 */	

 	namespace model;

	class MaquinaModel {
		
		private $id;
		private $nome;	

		public function getId(){
			return $this->id;
		}
		public function setId($id){
			$this->id = $id;
		}		
		public function getNome(){
			return $this->nome;
		}
		public function setNome($nome){
			$this->nome = $nome;
		}		

	}

?>