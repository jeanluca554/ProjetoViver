<?php
	require_once 'global.php';
	require_once 'DAO/MatriculaDAO.php';

	$response = array();	

	try
	{
		$idAluno = $_POST['idAluno'];

		$matriculaDAO = new MatriculaDAO();

		$matriculas = $matriculaDAO->listarMatriculasDoAluno($idAluno);

		$response['mensagem'] = 'ok';
		$response['matriculas'] = $matriculas;
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
