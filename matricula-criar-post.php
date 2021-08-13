<?php
	require_once 'global.php';
	require_once 'DAO/MatriculaDAO.php';

	$response = array();	

	try
	{
		$tipoEnsino = $_POST['tipoEnsinoVal'];
		$turma = $_POST['turmaVal'];
		$dataMatriculaPost = $_POST['dataMatricula'];
		$dataMatricula = trataData($dataMatriculaPost);
		$idAluno = $_POST['idAluno'];
		
		$matriculaDAO = new MatriculaDAO();

		$matriculaDAO->tipoEnsino = $tipoEnsino;
		$matriculaDAO->turma = $turma;
		$matriculaDAO->dataMatricula = $dataMatricula;
		

		$ultimoID = $matriculaDAO->create($idAluno);

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

	function trataData($data)
	{
		$dataArray = explode('/', $data); //remove o caractere '/'
		$dataInvertida = array_reverse($dataArray); // invete as posições da data de trás pra frente
		$dataCorrigida = implode('-', $dataInvertida); //transforma o array da data em uma string separada por '-'
		return (string) $dataCorrigida;
	}
