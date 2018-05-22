<?php
	/*
	 * CONNECTIONFACTORY.PHP
	 * Rev. 1.1 - 05/10/2016	
	 * Conecta ao banco de dados		
	 */	
	namespace model;

	error_reporting(0);

	class ConnectionFactory{	

		public static function getConnection(){			
			
			/* Ambiente teste */
			$host = 'localhost';
			$user = 'root';
			$pass = 'suporte';
			$db = 'cp2';	
			

			/* Ambiente local Meire (Produção) 
			$host = 'localhost';
			$user = 'admin';
			$pass = 'cact';
			$db = 'cp2';			
			*/

			/* Hostinger 
			$host = 'mysql.hostinger.com.br';
			$user = 'u257886421_admin';
			$pass = 'suporte';
			$db = 'u257886421_cp2';
			*/

			$app = 'CP2';
			echo "<meta charset='UTF-8'>";

			$con = mysqli_connect($host, $user, $pass, $db);

			if (!$con) 
			{

				date_default_timezone_set('America/Sao_Paulo');
			
			echo '
				<!DOCTYPE html>
				<html lang="pt-BR">
					<head>
						<meta charset="UTF-8">
						<meta http-equiv="Content-Language" content="pt-BR">
						<link href="../html/css/bootstrap.min.css" rel="stylesheet">
						<link href="../html/css/font-awesome.min.css" rel="stylesheet">
						<link href="html/css/bootstrap.min.css" rel="stylesheet">
						<link href="html/css/font-awesome.min.css" rel="stylesheet">
					</head>
				<body>
					<div class="container">
						<br>
						<br>
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">
								<div class="panel panel-danger text-center">			    
				    
				    				<div class="panel-heading">
				    					<i class="fa fa-warning"></i>
				    					<strong> ERRO </strong>
				    					<p>APP - CONTROLE DE PROTOCOLO TRT 2</p>
				    				</div>

				    				<div class="panel-body">
					    				<br>
					    				<p>Não estou conseguindo conectar ao Banco de dados.</p>		
				    					<br>
				    					<div class="row">
				    						<div class="col-lg-6 col-lg-offset-3 text-left">
					    					<small>
						    					<ul>
							    					<li>Verifique a sua conexão de rede.
							    					</li>
							    					<li>Insistindo o problema contate o <strong>Suporte<strong>.
							    					</li>
						    					</ul>
					    					</small>
					    					</div>
					    				</div>
					    				<br>			    					    			

						    			<a href="/index.php" class="btn btn-danger">
						    				<i class="fa fa-home"></i>
						    				Retornar
						    			</a>
						    			
					    			</div>

					    			<div class="panel-footer">
					    				<p>
					    					<i class="fa fa-wrench"></i>
					    					<strong>Depuração</strong>
					    				</p>
					    				<p><strong>Erro:</strong> '.mysqli_connect_errno().' - '
					     				.utf8_encode (mysqli_connect_error()).'
					     				</p>					     				
				     				</div>

				    			</div>
				    		</div>
				    	</div>
				    </div>
			    </body>
			    </html>
			    ';
			    exit;			    
			}

			
			return $con;
		}
	}
		
?>
