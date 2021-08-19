<?php
	require_once("Conexao.php");
	require_once("config.php");

	
	if (isset($_POST['query']))
	{
		$inpText=$_POST['query'];
		$query = "SELECT * FROM cidade WHERE nome like '%".$inpText."%'";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
	
		foreach ($fetchAll as $cidades) 
		{
			echo "<a href='#' class='list-group-item list-group-item-action border-1'>".$cidades['nome']."</a>";			
		}
	}
