<?php
	require_once 'global.php';
	require_once 'DAO/DisciplinaDAO.php';

	$response = array();	

	try
	{
		$nome = $_POST['nome'];
		$id = $_POST['idDisciplina'];
		
		$disciplinaDAO = new DisciplinaDAO($id);

		$disciplinaDAO->nome = $nome;	

		$disciplinaDAO->update();

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
