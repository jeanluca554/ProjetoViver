<?php
	
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idDisciplinasPost = $_POST['idDisciplina'];
		$idMatrizPost = $_POST['idMatriz'];

		$idDisciplinas = intval($idDisciplinasPost);
		$idMatriz = intval($idMatrizPost);
		
		$query = 	"INSERT INTO disciplinas_da_matriz
						(
							id_matriz,
							id_disciplina
						) 
						VALUES 
						(
							:id_matriz,
							:id_disciplina
						)";

		$conexao = Conexao::pegarConexao();

		$stmt = $conexao->prepare($query);

		$stmt->bindValue(':id_matriz', $idMatriz);
		$stmt->bindValue(':id_disciplina', $idDisciplinas);

		$stmt->execute();
		$ultimo = $conexao->lastInsertId();

		$response['mensagem'] = 'ok';
		$response['ultimoID'] = $ultimo;
		echo json_encode($response);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops... Erro banco-matriz-disciplinas-criar-post";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
