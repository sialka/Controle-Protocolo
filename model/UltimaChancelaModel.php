<?php

namespace model;

class UltimaChancelaModel {

	private $idMaquina;				
	private $nome;				
	private $chancela;

	public function getidMaquina(){
		return $this->idMaquina;
	}
	public function setidMaquina($idMaquina){
		$this->idMaquina = $idMaquina;
	}

	public function getNome(){
		return $this->nome;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getChancela(){
		return $this->chancela;
	}
	public function setChancela($chancela){
		$this->chancela = $chancela;
	}

}

?>