<?php
	require_once 'global.php';
	require_once 'DAO/EnderecoDAO.php';
	session_start();

	$response = array();

	try
	{
		$id = $_POST['id'];
		$cep = $_POST['cep'];
		$logradouro = $_POST['logradouro'];
		$numero = $_POST['numeroCasa'];
		$complemento = $_POST['complemento'];
		$bairro = $_POST['bairro'];
		$estado = $_POST['estado'];
		$cidade = $_POST['cidade'];
		
		$enderecoDAO = new EnderecoDAO($id);

		$enderecoDAO->cep = $cep;
		$enderecoDAO->logradouro = $logradouro;
		$enderecoDAO->numero = $numero;
		$enderecoDAO->complemento = $complemento;
		$enderecoDAO->bairro = $bairro;
		$enderecoDAO->estado = $estado;
		$enderecoDAO->cidade = $cidade;

		$enderecoDAO->update();

		$response['mensagem'] = 'ok';
		// $response['teste'] = $teste;
		echo json_encode($response);

		
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		//$response['text'] = "Eita";
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