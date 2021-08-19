<?php
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idDisciplina = $_POST['idDisciplina'];
		$idTurma = $_POST['idTurma'];
		$idProfessor = $_POST['idProfessor'];


		$query = 	"UPDATE professor_vinculado SET id_disciplina = $idDisciplina, id_professor = '$idProfessor' WHERE id_disciplina = $idDisciplina AND id_turma = $idTurma";

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
