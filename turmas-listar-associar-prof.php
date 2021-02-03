<?php
	require_once 'global.php';
	require_once 'DAO/TurmaDAO.php';

	$response = array();	

	try
	{
		$ano = $_POST['ano'];
		$tipo = $_POST['tipoEnsino'];

		$turmaDAO = new TurmaDAO();

		$turmas = $turmaDAO->listarTurmasAssociarProf($ano, $tipo);

		$response['mensagem'] = 'ok';
		$response['turmas'] = $turmas;
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
