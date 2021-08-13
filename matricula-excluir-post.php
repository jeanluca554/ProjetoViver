<?php
	require_once 'global.php';
	require_once 'DAO/MatriculaDAO.php';

	$response = array();	

	try
	{
		$id = $_POST['id'];
		
		$matriculaDAO = new MatriculaDAO($id);

		$matriculaDAO->delete();

		$response['mensagem'] = 'ok';
		$response['text'] = "Matrícula excluída com sucesso!";
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
