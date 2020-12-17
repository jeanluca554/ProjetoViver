<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
// session_start();

function usuarioEstaLogado() 
{
	return isset($_SESSION["usuario_logado"]);
}

function verificaUsuario() 
{
	if(!usuarioEstaLogado()) {
		$_SESSION["danger"] = "Você não tem acesso a esta funcionalidade. <a href='logout.php'>Clique aqui para fazer o login novamente</a>";
		//header("Location: index.html");
		
		die();
	}
}

function usuarioLogado() 
{
	return $_SESSION["usuario_logado"];
}

function logaUsuario($email) 
{
	$_SESSION["usuario_logado"] = $email;
}

function logout() 
{
	session_destroy();
	session_start();
}

function confirmaCpf($cpf)
{
	$_SESSION["cpf_verificado"] = $cpf;
}

function verificaCpf() 
{
	if(!cpfEstaVerificado()) 
	{
		$_SESSION["danger"] = "Você não tem acesso a esta funcionalidade. <a href='logout.php'>Clique aqui para fazer o login novamente</a>";
		//header("Location: index.html");
		
		die();
	}
}

function cpfEstaVerificado() 
{
	return isset($_SESSION["cpf_verificado"]);
}