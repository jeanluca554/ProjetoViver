<?php
	require_once 'global.php';
	require_once 'DAO/TurmaDAO.php';

	$response = array();	

	try
	{
		$idTurma = $_POST['turmaVal'];
		$acao = $_POST['acao'];
		
		
		$turmaDAO = new TurmaDAO($idTurma);

		$turmaDAO->alteraQtdAlunoAtivo($acao);

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
