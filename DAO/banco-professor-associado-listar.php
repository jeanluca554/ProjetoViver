<?php
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idMateria = $_POST['idMateria'];
		$idTurma = $_POST['idTurma'];

		$materias = array();
		$query = "	SELECT 
						v.id_vinculo, 
						f.nome_funcionario
					FROM professor_vinculado v
						INNER JOIN funcionario f ON v.id_professor = f.cpf_funcionario
						INNER JOIN turma t ON t.id_turma = v.id_turma
					WHERE v.id_disciplina = $idMateria AND v.id_turma = $idTurma";

		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetch = $stmt->fetch();
		
		
		echo json_encode($fetch);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
