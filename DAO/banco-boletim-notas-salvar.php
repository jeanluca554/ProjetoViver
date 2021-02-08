<?php
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idTurma = $_POST['idTurmaBoletim'];
		$idDisciplina = $_POST['idDisciplinaBoletim'];
		$idAluno = $_POST['idAlunoBoletim'];
		$bimestre = $_POST['bimestreAlunoBoletim'];
		$situacaoAluno = $_POST['situacaoAluno'];
		$prova1Aluno = $_POST['prova1Aluno'];
		$prova2Aluno = $_POST['prova2Aluno'];
		$trabalhoAluno = $_POST['trabalhoAluno'];
		$recuperacaoAluno = $_POST['recuperacaoAluno'];
		$mediaAluno = $_POST['mediaAluno'];
		$faltasAluno = $_POST['faltasAluno'];
		$mediaParcial = $_POST['mediaParcial'];

		$query = "	UPDATE boletim 
					SET prova1 = $prova1Aluno, prova2 = $prova2Aluno, trabalho = $trabalhoAluno, recuperacao = $recuperacaoAluno, media = $mediaAluno , faltas = $faltasAluno, media_parcial = $mediaParcial
					WHERE id_turma = $idTurma AND id_disciplina = $idDisciplina AND bimestre = $bimestre AND id_aluno = $idAluno";

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
