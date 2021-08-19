	<?php
	require_once 'global.php';
	require_once 'DAO/ResponsavelDAO.php';

	$response = array();

	try
	{
		$nome = $_POST['nome'];
		$cpf = $_POST['cpf'];
		$telefone = $_POST['telefone'];
		$telefoneAdicional = $_POST['telefoneAdicional'];
		$rgResponsavel = $_POST['rgResponsavel'];
		
		$responsavelDAO = new ResponsavelDAO();

		$responsavelDAO->nome = $nome;
		$responsavelDAO->cpf = $cpf;
		$responsavelDAO->telefone = $telefone;
		$responsavelDAO->telefoneAdicional = $telefoneAdicional;
		$responsavelDAO->rg = $rgResponsavel;

		$ultimoID = $responsavelDAO->create();

		$response['code'] = 'ok';
		$response['message'] = $ultimoID;
		echo json_encode($response);
	}
	
	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['code'] = 'erro';
		$response['title'] = "Este CPF já foi cadastrado!";
		//$response['text'] = (string) $e; //Apresenta o erro no banco de dados
		$response['text'] = "Por favor, cadastre um número de CPF diferente.";
		echo json_encode($response);
	}