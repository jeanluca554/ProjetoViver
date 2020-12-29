<?php
	require_once 'global.php';
	require_once 'DAO/DisciplinaDAO.php';

	$response = array();	

	try
	{
		$id = $_POST['id'];
		
		$disciplinaDAO = new DisciplinaDAO($id);

		$disciplinaDAO->delete();

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
