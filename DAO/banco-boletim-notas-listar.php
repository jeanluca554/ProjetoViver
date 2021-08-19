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

		$query = "	SELECT b.prova1, b.prova2, b.trabalho, b.recuperacao, b.media, b.faltas, b.media_parcial
					FROM boletim b
					INNER JOIN turma t
					ON b.id_turma = t.id_turma
					INNER JOIN disciplina d
					ON b.id_disciplina = d.id
					INNER JOIN aluno a
					ON b.id_aluno = a.id_aluno
					WHERE b.id_turma = $idTurma 
					AND b.id_disciplina = $idDisciplina 
					AND b.id_aluno = $idAluno 
					AND b.bimestre = $bimestre";

		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
		
		
		echo json_encode($fetchAll);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
