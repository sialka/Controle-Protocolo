<?php
	/*
	 * Model - ProtocoloModel
	 * Representa a tabela Protocolo
	 */	

 	namespace model;

	class ProtocoloModel {

		private $id;
		private $data;				
		private $cidade_id;
		private $vara;
		private $processo;
		private $chancela;				
		private $maquina_id;				
		private $usuario_id;
		private $impressao;
		private $duplicado;
		private $digitacao;

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
		public function getCidadeId(){
			return $this->cidade_id;
		}
		public function setCidadeId($cidade_id){
			$this->cidade_id = $cidade_id;
		}		
		public function getVara(){
			return $this->vara;
		}
		public function setVara($vara){
			$this->vara = $vara;
		}		
		public function getProcesso(){
			return $this->processo;
		}
		public function setProcesso($processo){
			$this->processo = $processo;
		}		
		public function getChancela(){
			return $this->chancela;
		}
		public function setChancela($chancela){
			$this->chancela = $chancela;
		}		
		public function getMaquinaId(){
			return $this->maquina_id;
		}
		public function setMaquinaId($maquina_id){
			$this->maquina_id = $maquina_id;
		}		
		public function getUsuarioId(){
			return $this->usuario_id;
		}
		public function setUsuarioId($usuario_id){
			$this->usuario_id = $usuario_id;
		}		
		public function getImpressao(){
			return $this->impressao;
		}
		public function setImpressao($impressao){
			$this->impressao = $impressao;
		}		
		public function getDuplicado(){
			return $this->duplicado;
		}
		public function setDuplicado($duplicado){
			$this->duplicado = $duplicado;
		}		
		public function getDigitacao(){
			return $this->digitacao;
		}
		public function setDigitacao($digitacao){
			$this->digitacao = $digitacao;
		}		

	}

?>