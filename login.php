<?php 
require_once("DAO/banco-usuario.php");
require_once("logica-usuario.php");

$usuario = buscaUsuario($_POST["email"], $_POST["senha"]);

if($usuario == null)
{
	$_SESSION["danger"] = "O usuário ou a senha são inválidos.";
	header("Location: loginInvalido.php");
} else {
	logaUsuario($usuario["email"], $usuario["cargo"]);
	$idFuncionario = pegaIdFuncionario($usuario["id_login"]);
	$_SESSION["idFuncionario"] = $idFuncionario;
	// $_SESSION["success"] = "Usuário logado com sucesso.".$usuario["id_login"];

	header("Location: index.php");
}
die();?>