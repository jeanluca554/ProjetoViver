<?php
	require_once 'global.php';
	require_once 'DAO/MatriculaDAO.php';

	$response = array();	

	try
	{
		$idTurma = $_POST['idTurma'];

		$turmaDAO = new TurmaDAO();

		$associacoes = $turmaDAO->listarProfessoresAssociados($idTurma);

		$response['mensagem'] = 'ok';
		$response['associacoes'] = $associacoes;
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
