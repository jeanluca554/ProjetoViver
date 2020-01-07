<?php
	require_once("Conexao.php");
	require_once("config.php");

	function buscaUsuario($email, $senha) {
		$senhaMd5 = md5($senha);
		
		$query = "select * from usuarios where email = :email and senha = :senha";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);

		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':senha', $senhaMd5);

		$stmt->execute();

		$usuario = $stmt->fetch();

		return $usuario;
	}