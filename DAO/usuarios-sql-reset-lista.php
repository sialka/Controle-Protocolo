<?php 
	/*
	*	USUARIOS-SQL-RESET-LISTA.PHP
	*	Reseta senha do usuario selecionado pela lista.
	*/

	use controllers\UsuarioController;
	use model\UsuarioModel;
	
	require_once("class.phpmailer.php");
	require_once("../autoload.php");
	require_once("../lib-v1.php"); 

    # Verifica se o usuario está logado
    Esta_logado_DAO();
    # Só usuario administrador pode acessar essa view.    
    So_Usuario_DAO_Adm();
    	
 	// Direciona casa não exista o Id
	if (!isset($_POST["id"])) {		
		header("Location: ../index.php");
		die();
	}	

	$UsuarioController = new UsuarioController();
	$novaSenha = $UsuarioController->geraHash(6);

	$usuario = new UsuarioModel();
	$usuario->setId($_POST["id"]);	
	$usuario->setSenha(md5($novaSenha));	
	
	$email = $_POST["email"];
	$nome = $_POST["nome"];
	$user = $_POST["usuario"];
	
	$resultado = $UsuarioController->alteraSenhaLista($usuario);
	
	//$novaSenha = "admin";

	$msg_success = null;
	$msg_error = null;

	if ($resultado){
		$msg_success = "Senha Resetada com sucesso, a nova senha é <strong>$novaSenha</strong>";			
	}else{		
		$msg_error = "Não foi possivel resetar a senha";
	}

	//enviando e-mail
	if ($resultado)
	{
	
		// Inicia a classe PHPMailer
		$mail = new PHPMailer(true);

		// Define os dados do servidor e tipo de conexão
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsSMTP(); // Define que a mensagem será SMTP

		try
		{

		 $mail->Host = 'smtp.gmail.com'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
		 $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
		 $mail->SMTPSecure = "tls";
		 $mail->Port       = 587; //  Usar 587 porta SMTP
		 $mail->Username = 'cp2web.contato@gmail.com'; // Usuário do servidor SMTP (endereço de email)
		 $mail->Password = 'cp2@2016'; // Senha do servidor SMTP (senha do email usado)

		 //Define o remetente
		 // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
		 $mail->SetFrom('cp2web.contato@gmail.com', 'CP2 - Controle de Protocolo'); //Seu e-mail
		 $mail->AddReplyTo('cp2web.contato@gmail.com', 'CP2 - Controle de Protocolo'); //Seu e-mail
		 $mail->Subject = 'CP2 - Nova Senha';//Assunto do e-mail


		 //Define os destinatário(s)
		 //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		 #$mail->AddAddress('contato@inovasystems.com.br', 'Teste Locaweb');
		 $mail->AddAddress($email, 'CP2 - OABSP');     

		 //Campos abaixo são opcionais 
		 //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		 //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
		 //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
		 //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


		 //Define o corpo do email
		 $mail->MsgHTML('
		 		<div style="font: 12px Arial">
			 		<p>		 		
			 			Prezado Usuario,
			 		</p>
			 		<p>		 		
						Conforme solicitacao, segue abaixo uma <strong>nova senha</strong> para acesso ao Sistena de Controle de Protocolo:
					</p>
					<ul>
						<li>
							Usuario: <span style="color:blue"><strong>'.$user.'</strong></span>
						</li>
						<li>
							Senha Provisoria: <span style="color:blue"><strong>'.$novaSenha.'</strong></span>
						</li>
					</ul>				
					<p>		 		
						No proximo acesso ao sistema voce devera informar a senha definitiva.
					</p>
					<p style="font: italic 12px Arial; color: red">
						<strong>(*) Nao precisa responde, e-mail automatico.</strong>
					</p>								
					<p>Atenciosamente,</p>				
					<p>
						<strong>Sidnei Monteiro da Silva Filho</strong>
						<br>
						CP2 - Controle de Protocolo
					</p>
				<div>
		 	'); 

		 ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
		 //$mail->MsgHTML(file_get_contents('arquivo.html'));

		 $mail->Send();
		 //echo "Mensagem enviada com sucesso</p>\n";
		 $msg = "Mensagem enviada com sucesso";

		//caso apresente algum erro é apresentado abaixo com essa exceção.
		}
		catch (phpmailerException $e) 
		{
		    //echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
		    $msg = $e->errorMessage();
		}


		if (!isset($_SESSION)) session_start();     

		//$_SESSION["email_envio"] = $msg;		
		#header("Location: ../atendimento-dcf.php#email");

	}

	
	if (!isset($_SESSION)) session_start();

	$_SESSION["usuario_reset_lista_msg_success"] = $msg_success;
	$_SESSION["usuario_reset_lista_msg_error"] = $msg_error;				

	header("Location: ../usuarios-lista.php");
	die();

?>

