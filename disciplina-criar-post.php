<?php
	require_once 'global.php';
	require_once 'DAO/DisciplinaDAO.php';

	$response = array();	

	try
	{
		$nome = $_POST['nome'];
		
		$disciplinaDAO = new DisciplinaDAO();

		$disciplinaDAO->nome = $nome;

		$ultimoID = $disciplinaDAO->create();

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
