<?php
	/*
	* USUARIOCONTROLLER.PHP	
	* Este arquivo contem todas as ações que serão feitas na tabela USUARIOS.
	*/
	namespace controllers;

	use model\ConnectionFactory;
	use model\UsuarioModel;	

	class UsuarioController{

		private $con;

		public function __construct(){
			# Faz conexão com o banco de dados
			$con = ConnectionFactory::getConnection();			
			$this->con = $con;			
		}
		
		function listaUsuarios(){

			# Lista todas as Usuarios
			$usuarios = array();
			$resultado = mysqli_query($this->con, "SELECT * FROM usuarios");

			while($usuario_atual = mysqli_fetch_assoc($resultado)) {
				$usuario = new UsuarioModel();
				$usuario->setId($usuario_atual['id']);
				$usuario->setNome($usuario_atual['nome']);
				$usuario->setSenha($usuario_atual['senha']);
				$usuario->setStatus($usuario_atual['status']);
				$usuario->setNivel($usuario_atual['nivel']);
				$usuario->setReset($usuario_atual['reset']);
				$usuario->setUsuario($usuario_atual['usuario']);
				$usuario->setEmail($usuario_atual['email']);

				array_push($usuarios, $usuario);
			}
			mysqli_close($this->con);
			return $usuarios;
		}
		
		function contaUsuarios(){		 

			# Contador de usuários
			$query = "SELECT count(id) FROM usuarios";		
			$resultado = mysqli_query($this->con, $query);		
			$usuarios = mysqli_fetch_assoc($resultado);
			$total = $usuarios['count(id)'];
			mysqli_close($this->con);
			return $total;		
		}
		
		function login($usuario, $senha){	
		
			/*
			* Login de Acesso
			* Respostas:
			* 0 - OK
			* 1 - Usuario não existe
			* 2 - Senha invalida
			* 3 - Usuario Bloqueado
			* 4 - Usuario deve trocar a senha
			*/
		
			$query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
			$resultado = mysqli_query($this->con, $query);		
			$resposta = mysqli_fetch_assoc($resultado);	

			if ($resposta['senha']==null){
				
				# Usuário não existe.
				mysqli_close($this->con);
				return "1";

			}else{				
				
				# Usuário bloqueado
				if ($resposta['status']==0){
					mysqli_close($this->con);
					return "3";	
				}

				# Verificando a senha do usuário
				if ($resposta['senha']== md5($senha)){				
					
					# O usuário pediu resete da sennha.
					if($resposta['reset']==1){
						
						if (!isset($_SESSION)) session_start();								
						
						# Carregando dados do usuário.
						$_SESSION["usuario_logado"] = $resposta['usuario'];
						$_SESSION["usuario_id"] = $resposta['id'];
						$_SESSION["usuario_nivel"] = $resposta['nivel'];						
						$_SESSION["usuario_nome"] = $resposta['nome'];
						
						mysqli_close($this->con);
						return "4";						
					}
					
					# O usuário e a senha está OK.
					if (!isset($_SESSION)) session_start();						

					# Carregando dados do usuário.
					$_SESSION["usuario_logado"] = $resposta['usuario'];
					$_SESSION["usuario_id"] = $resposta['id'];
					$_SESSION["usuario_nivel"] = $resposta['nivel'];					
					$_SESSION["usuario_nome"] = $resposta['nome'];					

					mysqli_close($this->con);
					return "0";
				}else{
					
					# A senha está errada.
					if (!isset($_SESSION)) session_start();						
					
					$_SESSION["usuario_erro_msg"] = "Usuário não existe";				
					mysqli_close($this->con);
					return "2";
				}

			}	
		}
		
		function GeraHash($qtd){

			# Gerador de senha.
			$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZqwertyuiopasdfghjklzxcvbnm@#!$*0123456789';
			$QuantidadeCaracteres = strlen($Caracteres);
			$QuantidadeCaracteres--;

			$Hash=NULL;

		    for($x=1;$x<=$qtd;$x++){
		        $Posicao = rand(0,$QuantidadeCaracteres);
		        $Hash .= substr($Caracteres,$Posicao,1);
		    }

			return $Hash; 
		}

		function buscaUsuario(UsuarioModel $usuario){

			# Busca usuario pelo nome de usuário.
			$query = "SELECT * FROM usuarios WHERE usuario='{$usuario->getUsuario()}'";
			$resultado = mysqli_query($this->con, $query);							
			$resultado->num_rows ? $retorno = "1" : $retorno = "0";						
			
			return $retorno;
		}

		function criarUsuario(UsuarioModel $usuario){		

			/* Cria novo usuário.
			* Retornos:
			* 0 - Usuario já existe
			* 1 - Usuario criado sucesso no envio de email com a senha
			* 2 - Usuario criado erro ao enviar o email com a senha		  
			*/

			$busca = $this->buscaUsuario($usuario);	

			if (!$busca) {			
				
				$usuario->setSenha(md5($usuario->getSenha()));
				$usuario->setStatus(0);			
				$usuario->setNivel(0);
				$usuario->setReset(1);

				$query = "INSERT INTO usuarios (usuario, senha, nome, email, status, nivel, reset) VALUE ('{$usuario->getUsuario()}','{$usuario->getSenha()}','{$usuario->getNome()}','{$usuario->getEmail()}',{$usuario->getStatus()},{$usuario->getNivel()},{$usuario->getReset()});";
				$resultado = mysqli_query($this->con, $query);		

				//disparando e-mail para o usuario			
				//$envio = enviaEmail($usuario);			
				$envio = true;			
				
				$envio ? $retorno = "1" : $retorno = "2";

				mysqli_close($this->con);
				return $retorno;
			}else{
				mysqli_close($this->con);
				return "0";
			}	
		}

		function excluirUsuario(UsuarioModel $usuario){

			/*	Remove usuários.
			*	Retornos:
			*	0 - Usuario cancelado.
			* 	1 - O usuario logado não pode se deletar.
			*   2 - Erro ao tentar remover o usuario do banco.
			*/

			if (!isset($_SESSION)) session_start();
		
			# Não permite que o usuario logado se exclua.
			$idLogado = $_SESSION["usuario_id"];			
			if ($idLogado == $usuario->getId()){
			
				mysqli_close($this->con);
				return "1";
			
			}else{				

				# Remove o usuario pelo id.				
				$query = "DELETE FROM usuarios WHERE id={$usuario->getId()}";
				$resultado = mysqli_query($this->con, $query);
				$resultado->num_rows ? $retorno = "1" : $retorno = "0";						

				mysqli_close($this->con);
				return $retorno;
			}		
		}		

		function buscaUsuarioParaBloqueio(UsuarioModel $usuario){

			# Busca usuario pelo nome de usuário para bloqueio
			$query = "SELECT * FROM usuarios WHERE usuario='{$usuario->getUsuario()}'";
			$resultado = mysqli_query($this->con, $query);			
			
			return mysqli_fetch_assoc($resultado);
		}

		function bloquearUsuario(UsuarioModel $usuario){

			/* Bloqueando usuário.
			* Retornos:
			* 0 - Usuário bloqueado.
			* 1 - Usuário desbloqueado.
			* 2 - Administrador tentando bloquear a si mesmo.
			*/		

			# O usuário administrador não pode bloquear a si mesmo.
			if (!isset($_SESSION)) session_start();		 			
		 	if ($_SESSION["usuario_id"]== $usuario->getId()){
		 		mysqli_close($this->con);
		 		return "2";
		 	}
			
			$busca = $this->buscaUsuarioParaBloqueio($usuario);

			if ($busca['status']==0) {
				$query = "UPDATE usuarios SET status=1 WHERE id={$usuario->getId()}";
				$resultado = mysqli_query($this->con, $query);
				mysqli_close($this->con);
				return "0";
			}else{
				$query = "UPDATE usuarios SET status=0 WHERE id={$usuario->getId()}";
				$resultado = mysqli_query($this->con, $query);
				mysqli_close($this->con);
				return "1";
			}		
		}
		
		function alteraSenha($senha){

			# Altera a senha do usuario atravez de formulário
			if (!isset($_SESSION)) session_start();
			
			$id = $_SESSION["usuario_id"];					
			$senhaMd5 = md5($senha);		

			$query = "UPDATE usuarios SET senha='{$senhaMd5}', reset=0 WHERE id=$id";
			$resultado = mysqli_query($this->con, $query);		
			$resultado ? $retorno = "1" : $retorno = "0";
			mysqli_close($this->con);
			return $retorno;		
		}
		
		function alteraSenhaLista(UsuarioModel $usuario){

			# Reseta a senha do usuário.
			$query = "UPDATE usuarios SET senha='{$usuario->getSenha()}', reset=1 WHERE id={$usuario->getId()}";
			$resultado = mysqli_query($this->con, $query);		
			$resultado ? $retorno = "1" : $retorno = "0";
			mysqli_close($this->con);
			return $retorno;
		}
		
		function editarUsuario(UsuarioModel $usuario){
		
			# Editando usuário.
			$query = "UPDATE usuarios SET nome='{$usuario->getNome()}', email='{$usuario->getEmail()}', nivel={$usuario->getNivel()} WHERE id={$usuario->getId()}";
			$resultado = mysqli_query($this->con, $query);
			$resultado ? $retorno = "1" : $retorno = "0";
			mysqli_close($this->con);
			return $retorno;
		}
		
	}

?>