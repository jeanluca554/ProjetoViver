<?php
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idTurma = $_POST['idTurma'];
		$idDisciplina = $_POST['idDisciplina'];
		$idAluno = $_POST['idAluno'];
		$bimestre = $_POST['bimestre'];

		$query = "	INSERT INTO boletim 
					(
						id_turma, 
						id_disciplina, 
						id_aluno, 
						bimestre
					)
					VALUES 
					(
						$idTurma,
						$idDisciplina,
						$idAluno,
						$bimestre
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
