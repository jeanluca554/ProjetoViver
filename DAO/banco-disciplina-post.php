<?php
	require("Conexao.php");
	require_once("config.php");
	// session_start();

	pegaDisciplina();


	function pegaDisciplina()
	{
		$disciplinaDigitada = $_POST['disciplina'];
		$query = "	SELECT id, nome
					FROM disciplina 
					WHERE nome
					like '%".$disciplinaDigitada."%'";

		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
		$espaco = "&nbsp--&nbsp";
	
		foreach ($fetchAll as $disciplinas) 
		{
			echo "<a href='#' class='list-group-item list-group-item-action border-1'>".$disciplinas['nome'].$espaco.$disciplinas['id']."</a>";
		}
	}
