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

function cargoUsuarioLogado() 
{
	return $_SESSION["usuario_cargo"];
}

function logaUsuario($email, $cargo) 
{
	$_SESSION["usuario_logado"] = $email;
	$_SESSION["usuario_cargo"] = $cargo;
}

function logout() 
{
	session_destroy();
	session_start();
}

// function confirmaCpf($cpf)
// {
// 	$_SESSION["cpf_verificado"] = $cpf;
// }

// function verificaCpf() 
// {
// 	if(!cpfEstaVerificado()) 
// 	{
// 		$_SESSION["danger"] = "Você não tem acesso a esta funcionalidade. <a href='logout.php'>Clique aqui para fazer o login novamente</a>";
// 		//header("Location: index.html");
		
// 		die();
// 	}
	
// }

// function cpfEstaVerificado() 
// {
// 	return isset($_SESSION["cpf_verificado"]);
// }

function secretarioEstaLogado() 
{
	$cargo = cargoUsuarioLogado();
	if($cargo != "Secretário") {
		if($cargo != "Diretor")
		{
			$_SESSION["danger"] = "Você não tem acesso a esta funcionalidade. <a href='logout.php'>Clique aqui para fazer o login novamente</a>";
			//header("Location: index.html");
			
			die();
		}
		else {
			return isset($_SESSION["usuario_cargo"]);
		}
	}
	else
	{
		return isset($_SESSION["usuario_cargo"]);
	}
}

function coordenadorEstaLogado() 
{
	$cargo = cargoUsuarioLogado();
	if($cargo != "Coordenador") {
		if($cargo != "Diretor") {
			$_SESSION["danger"] = "Você não tem acesso a esta funcionalidade. <a href='logout.php'>Clique aqui para fazer o login novamente</a>";
			//header("Location: index.html");
			
			die();
		}
		else {
			return isset($_SESSION["usuario_cargo"]);
		}
	}
	else
	{
		return isset($_SESSION["usuario_cargo"]);
	}
}

function professorEstaLogado() 
{
	$cargo = cargoUsuarioLogado();
	$ensino = 'Ensino';

	$cargoVerificado = strpos($cargo, $ensino);

	if($cargoVerificado === false) {
		if($cargo != "Diretor")
		{
			$_SESSION["danger"] = "Você não tem acesso a esta funcionalidade. <a href='logout.php'>Clique aqui para fazer o login novamente</a>";
		//header("Location: index.html");
		
		die();
		}
		else {
			return isset($_SESSION["usuario_cargo"]);
		}
		
	}
	else
	{
		return isset($_SESSION["usuario_cargo"]);
	}
}

function diretorEstaLogado() 
{
	$cargo = cargoUsuarioLogado();
	if($cargo != "Diretor") {
		$_SESSION["danger"] = "Você não tem acesso a esta funcionalidade. <a href='logout.php'>Clique aqui para fazer o login novamente</a>";
		//header("Location: index.html");
		
		die();
	}
	else
	{
		return isset($_SESSION["usuario_cargo"]);
	}
}