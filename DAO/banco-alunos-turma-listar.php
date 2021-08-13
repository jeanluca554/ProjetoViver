<?php
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idTurma = $_POST['idTurma'];

		$materias = array();
		$query = "	SELECT a.id_aluno, a.nome_aluno, m.situacao
					FROM aluno a
					INNER JOIN matricula m
					ON a.id_aluno = m.id_aluno
					INNER JOIN turma t
					ON t.id_turma = m.id_turma
					WHERE t.id_turma = $idTurma AND m.situacao = 'Ativo'
					ORDER BY a.nome_aluno" ;

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
