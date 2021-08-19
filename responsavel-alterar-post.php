<?php
	require_once 'global.php';
	require_once 'DAO/ResponsavelDAO.php';
	session_start();

	$response = array();

	try
	{
		$id = $_POST['id'];
		$cpf = $_POST['cpf'];
		$nome = $_POST['nome'];
		$rg = $_POST['rg'];
		$telPessoal = $_POST['telPessoal'];
		$telAdicional = $_POST['telAdicional'];
		
		$responsavelDAO = new ResponsavelDAO();

		$responsavelDAO->id = $id;
		$responsavelDAO->nome = $nome;
		$responsavelDAO->cpf = $cpf;
		$responsavelDAO->telefone = $telPessoal;
		$responsavelDAO->telefoneAdicional = $telAdicional;
		$responsavelDAO->rg = $rg;

		$responsavelDAO->update();

		$response['mensagem'] = 'ok';
		// $response['teste'] = $teste;
		echo json_encode($response);

		
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = "Erro ao atualizar os dados do responsável";
		// $response['text'] = (string) $e;
		echo json_encode($response);
	}

	function trataData($data)
	{
		$dataArray = explode('/', $data); //remove o caractere '/'
		$dataInvertida = array_reverse($dataArray); // invete as posições da data de trás pra frente
		$dataCorrigida = implode('-', $dataInvertida); //transforma o array da data em uma string separada por '-'
		return (string) $dataCorrigida;
	}