<?php
	require_once 'global.php';
	require_once 'DAO/MatrizCurricularDAO.php';

	$response = array();	

	try
	{
		$nome = $_POST['nome'];
		$idMatriz = $_POST['idMatriz'];
		
		$matrizCurricularDAO = new MatrizCurricularDAO($idMatriz);

		$matrizCurricularDAO->nome = $nome;

		$matrizCurricularDAO->update();

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
