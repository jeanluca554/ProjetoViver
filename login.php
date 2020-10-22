<?php 
require_once("DAO/banco-usuario.php");
require_once("logica-usuario.php");

$usuario = buscaUsuario($_POST["email"], $_POST["senha"]);

if($usuario == null)
{
	$_SESSION["danger"] = "O usuário ou a senha são inválidos.";
	header("Location: loginInvalido.php");
} else {
	$_SESSION["success"] = "Usuário logado com sucesso.";
	logaUsuario($usuario["email"]);
	header("Location: index.php");
}
die();?>