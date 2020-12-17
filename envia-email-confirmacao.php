<?php
session_start();
// $nome = $_POST["nome"];
// $email = $_POST["email"];
// $mensagem = $_POST["mensagem"];

require_once("mailer/PHPMailer.php");
require_once("mailer/SMTP.php");
require_once("mailer/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$emailCadastrado = $_POST['email'];
$senha = $_POST['senha'];

$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";

try
{
	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = "projetovivereaprender0@gmail.com";
	$mail->Password = "Pod160496";
	$mail->Port = 587;
	// $mail->SMTPSecure = 'tls';
	

	$mail->setFrom("projetovivereaprender0@gmail.com", "Cadastro em Viver e Aprender");
	$mail->addAddress($emailCadastrado);
	$mail->isHTML(true);
	$mail->Subject = "Cadastro em Viver e Aprender";
	$mail->Body = "O seu cadastro foi realizado com sucesso! Para acessar o sistema insira o seu email e a senha: ".$senha;
	// $mail->msgHTML("<html>de: {$nome}<br/>email: {$email}<br/>mensagem: {$mensagem}</html>");
	// $mail->AltBody = "de: {$nome}\nemail:{$email}\nmensagem: {$mensagem}";

	if($mail->send()) 
	{
		$_SESSION["success"] = "Mensagem enviada com sucesso";
		// header("Location: index.php");
		echo json_encode(1);
	} 
	else 
	{
		$_SESSION["danger"] = "Erro ao enviar mensagem " . $mail->ErrorInfo;
		// header("Location: index.php");
		echo json_encode(2);
	}
	// return "3";
}
catch(Exception $e) {
	echo "Erro ao enviar mensage: {$mail->ErrorInfo}";
}
// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->Port = 587;
// $mail->SMTPSecure = 'tls';
// $mail->SMTPAuth = true;
// $mail->Username = "projetovivereaprender0@gmail.com";
// $mail->Password = "Pod160496";

// $mail->setFrom("projetovivereaprender0@gmail.com", "Alura Curso PHP e MySQL");
// $mail->addAddress("sjeanluca@gmail.com");
// $mail->Subject = "Email de contato da loja";
// $mail->msgHTML("<html>de: {$nome}<br/>email: {$email}<br/>mensagem: {$mensagem}</html>");
// $mail->AltBody = "de: {$nome}\nemail:{$email}\nmensagem: {$mensagem}";

// if($mail->send()) {
// 	$_SESSION["success"] = "Mensagem enviada com sucesso";
// 	header("Location: index.php");
// } else {
// 	$_SESSION["danger"] = "Erro ao enviar mensagem " . $mail->ErrorInfo;
// 	header("Location: contato.php");
// }
// die();