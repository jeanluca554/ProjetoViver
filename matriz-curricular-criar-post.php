<?php
	require_once 'global.php';
	require_once 'DAO/MatrizCurricularDAO.php';

	$response = array();	

	try
	{
		$nome = $_POST['nome'];
		$tipoEnsino = $_POST['tipoEnsino'];
		
		$matrizCurricularDAO = new MatrizCurricularDAO();

		$matrizCurricularDAO->nome = $nome;
		$matrizCurricularDAO->tipoEnsino = $tipoEnsino;

		$ultimoID = $matrizCurricularDAO->create();

		$response['mensagem'] = 'ok';
		$response['ultimoID'] = $ultimoID;
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
