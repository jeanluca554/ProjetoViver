<?php
	require_once 'global.php';
	require_once 'DAO/MatriculaDAO.php';

	$response = array();	

	try
	{
		$movimentacao = $_POST['movimentacao'];
		$dataAlteracaoPost = $_POST['dataAlteracao'];
		$idMatricula = $_POST['idMatricula'];
		
		$dataAlteracao= trataData($dataAlteracaoPost);
		
		$matriculaDAO = new MatriculaDAO($idMatricula);

		$matriculaDAO->dataMatricula = $dataAlteracao;

		$matriculaDAO->update($movimentacao, $dataAlteracao);

		$response['mensagem'] = 'ok';
		echo json_encode($response);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		// $response['text'] = $dataAlteracao;
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
