<?php
	/*
	 * Model - ChancelaModel
	 * Representa a tabela Chancela
	 */	

 	namespace model;

	class ChancelaModel {

		private $id;
		private $data;				
		private $maquina_id;
		private $inicio;
		private $final;
		private $mes;
		private $ano;	

		public function getId(){
			return $this->id;
		}
		public function setId($id){
			$this->id = $id;
		}
		public function getData(){
			return $this->data;
		}
		public function setData($data){
			$this->data = $data;
		}
		public function getMaquinaId(){
			return $this->maquina_id;
		}
		public function setMaquinaId($maquina_id){
			$this->maquina_id = $maquina_id;
		}		
		public function getInicio(){
			return $this->inicio;
		}
		public function setInicio($inicio){
			$this->inicio = $inicio;
		}	
		public function getFinal(){
			return $this->final;
		}
		public function setFinal($final){
			$this->final = $final;
		}			
		public function getMes(){
			return $this->mes;
		}
		public function setMes($mes){
			$this->mes = $mes;
		}	
		public function getAno(){
			return $this->ano;
		}
		public function setAno($ano){
			$this->ano = $ano;
		}	

	}

?>