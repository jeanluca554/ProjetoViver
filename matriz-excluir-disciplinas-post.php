<?php
	require_once 'global.php';
	require_once 'DAO/MatrizCurricularDAO.php';

	$response = array();	

	try
	{
		$id = $_POST['id'];
		
		$matrizDAO = new MatrizCurricularDAO($id);

		$teste = $matrizDAO->deletaDisciplinasDaMatriz();

		$response['mensagem'] = 'ok';
		$response['text'] = $teste;
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
