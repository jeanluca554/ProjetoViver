	<?php
	require_once 'global.php';
	require_once 'DAO/ResponsavelDAO.php';

	$response = array();

	try
	{
		$nome = $_POST['nome'];
		$cpf = $_POST['cpf'];
		$telefone = $_POST['telefone'];
		
		$responsavelDAO = new ResponsavelDAO();

		$responsavelDAO->nome = $nome;
		$responsavelDAO->cpf = $cpf;
		$responsavelDAO->telefone = $telefone;

		$ultimoID = $responsavelDAO->create();

		$response['code'] = 'ok';
		$response['message'] = $ultimoID;
		echo json_encode($response);
	}
	
	catch (Exception $e)
	{
		//Erro::trataErro($e);
		//echo "Este CPF já foi cadastrado. Por favor, cadastre um número de CPF diferente.";
		$response['code'] = 'erro';
		$response['title'] = "Este CPF já foi cadastrado!";
		$response['text'] = "Por favor, cadastre um número de CPF diferente.";
		echo json_encode($response);
	}