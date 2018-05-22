<?php
	/*
	 * Model - UsuarioModel
	 * Representa a tabela Usuario
	 */	

 	namespace model;

	class UsuarioModel {

		private $id;
		private $nome;
		private $senha;
		private $status;
		private $nivel;
		private $reset;
		private $usuario;
		private $email;

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
		public function getSenha(){
			return $this->senha;
		}
		public function setSenha($senha){
			$this->senha = $senha;
		}
		public function getStatus(){
			return $this->status;
		}
		public function setStatus($status){
			$this->status = $status;
		}	
		public function getNivel(){
			return $this->nivel;
		}
		public function setNivel($nivel){
			$this->nivel = $nivel;
		}
		public function getReset(){
			return $this->reset;
		}
		public function setReset($reset){
			$this->reset = $reset;
		}	
		public function getUsuario(){
			return $this->usuario;
		}
		public function setUsuario($usuario){
			$this->usuario = $usuario;
		}		
		public function getEmail(){
			return $this->email;
		}
		public function setEmail($email){
			$this->email = $email;
		}		
	}

?>