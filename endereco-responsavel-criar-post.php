<?php
	require_once 'global.php';
	require_once 'DAO/EnderecoDAO.php';

	$response = array();

	try
	{
		$cep = $_POST['cep'];
		$logradouro = $_POST['logradouro'];
		$numeroCasa = $_POST['numeroCasa'];
		$complemento = $_POST['complemento'];
		$bairro = $_POST['bairro'];
		$cidade = $_POST['cidade'];

		$enderecoDAO = new EnderecoDAO();

		$enderecoDAO->cep = $cep;
		$enderecoDAO->logradouro = $logradouro;
		$enderecoDAO->numero = $numeroCasa;
		$enderecoDAO->complemento = $complemento;
		$enderecoDAO->bairro = $bairro;
		$enderecoDAO->cidade = $cidade;

		$ultimoID = $enderecoDAO->create();
	
		$response['code'] = 'ok';
		$response['message'] = $ultimoID;
		echo json_encode($response);
	}
	catch (Exception $e)
	{
		//Erro::trataErro($e);
		//echo "Erro ao cadastrar endereço do Responsável";
		$response['code'] = 'erro';
		$response['title'] = 'Ops...';
		//$response['text'] = $e;
		$response['text'] = "Houve um erro ao cadastrar endereço do Responsável";
		echo json_encode($response);
	}