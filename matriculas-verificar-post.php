<?php
	require_once 'global.php';
	require_once 'DAO/MatriculaDAO.php';

	$response = array();	

	try
	{
		$idAluno = $_POST['idAluno'];
		$ano = $_POST['ano'];

		$matriculaDAO = new MatriculaDAO();

		$matriculas = $matriculaDAO->verificarMatriculasDoAluno($idAluno, $ano);

		$tamanho = count($matriculas);
		if ($tamanho == 0)
		{
			$response['mensagem'] = 'ok';
		}
		else
		{
			$response['mensagem'] = 'erro';
		}
		
		// $response['mensagem'] = 'ok';
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
