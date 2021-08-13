<?php
	require_once 'global.php';
	require_once 'DAO/TurmaDAO.php';

	$response = array();	

	try
	{
		$id = $_POST['id'];
		$qtdAlunos = $_POST['alunos'];

		if ($qtdAlunos == 0)
		{
			$turmaDAO = new TurmaDAO($id);

			$turmaDAO->delete();

			$response['mensagem'] = 'ok';
			$response['text'] = "Turma excluída com sucesso!";
			echo json_encode($response);
		}
		else 
		{
			$response['mensagem'] = 'erro';
			$response['text'] = "Essa turma não pode ser excluída porque ainda existem alunos ativos!";
			echo json_encode($response);
		}
		
		
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
