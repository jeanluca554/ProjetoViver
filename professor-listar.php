<?php
	require_once 'global.php';
	require_once 'DAO/FuncionarioDAO.php';

	$response = array();	

	try
	{
		$ano = $_POST['ano'];

		$funcionarioDAO = new FuncionarioDAO();

		$professores = $funcionarioDAO->listarProfessores();

		$response['mensagem'] = 'ok';
		$response['professores'] = $professores;
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
