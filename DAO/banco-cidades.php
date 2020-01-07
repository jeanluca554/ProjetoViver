<?php
	require_once("Conexao.php");
	require_once("config.php");

	function carregaCidade()
	{
		$query = "SELECT * FROM cidade ORDER BY nome ASC";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
	
		foreach ($fetchAll as $cidades) 
		{
			echo '<option value="'.$cidades['id'].'">'.$cidades['nome'].'</option>';
		}
	}