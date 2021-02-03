<?php
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idMateria = $_POST['idMateria'];
		$idTurma = $_POST['idTurma'];

		$query = 	"INSERT INTO professor_vinculado
						(
							id_turma,
							id_disciplina,
							id_professor
						) 
						VALUES 
						(
							$idTurma, 
							$idMateria, 
							0
						)";

			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->execute();
			$ultimo = $conexao->lastInsertId();
			echo json_encode($ultimo);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
