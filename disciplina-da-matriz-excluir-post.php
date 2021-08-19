<?php
	require_once 'global.php';
	require_once 'DAO/DisciplinaDAO.php';

	$response = array();	

	try
	{
		$idDisciplina = $_POST['idDisciplina'];
		$idMatriz = $_POST['idMatriz'];
		
		$query ="	DELETE FROM disciplinas_da_matriz
					WHERE id_disciplina = $idDisciplina AND id_matriz = $idMatriz";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->execute();

		$response['mensagem'] = 'ok';
		echo json_encode($response);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
