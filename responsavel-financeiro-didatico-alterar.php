<?php
	require_once 'global.php';
	require_once 'DAO/AlunoDAO.php';
	session_start();

	$response = array();

	try
	{
		$id = $_POST['idAluno'];
		$respFinanceiro = $_POST['respFinanceiro'];
		$respDidatico = $_POST['respDidatico'];
		
		$alunoDAO = new AlunoDAO($id);

		$alunoDAO->responsavelFinanceiro = $respFinanceiro;
		$alunoDAO->responsavelDidatico = $respDidatico;

		$alunoDAO->updateResponsavelDidaticoFinanceiro();

		$response['text'] = "Sucesso";
		// $response['teste'] = $teste;
		echo json_encode($response);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		// $response['text'] = "Eita";
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