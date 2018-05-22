<?php
	/*
	 * Model - CidadeModel
	 * Representa a tabela Cidade
	 */	

 	namespace model;

	class CidadeModel {
		
		private $id;
		private $nome;
		private $varas;

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
		public function getVaras(){
			return $this->varas;
		}
		public function setVaras($varas){
			$this->varas = $varas;
		}		

	}

?>