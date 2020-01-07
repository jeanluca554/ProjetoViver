<?php
	require_once("Conexao.php");
	require_once("config.php");

	
	$funcao = $_POST['funcao'];
	
	if($funcao == 1)
	{
		pegaCidadePeloEstado();
	}
	else
	{
		if ($funcao == 2)
		{
			pegaCidades();
		}
	}


	function pegaCidadePeloEstado()
	{
		$id = $_POST['id'];
		$query = "SELECT * FROM cidade WHERE uf='".$id."'";
		//$query = "SELECT * FROM cidades WHERE uf=4";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
	
		foreach ($fetchAll as $cidades) 
		{
			echo '<option>'.$cidades['nome'].'</option>';			
		}
	}

	function pegaCidades()
	{
		$cidadeDigitada = $_POST['cidade'];
		$query = "SELECT * FROM cidade WHERE nome like '%".$cidadeDigitada."%'";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
	
		foreach ($fetchAll as $cidades) 
		{
			echo "<a href='#' class='list-group-item list-group-item-action border-1'>".$cidades['nome']."</a><input type='hidden' name='id' value=".$cidades['id'].">";		
		}
	}