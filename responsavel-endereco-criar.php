<?php
	require_once 'global.php';
	require_once 'DAO/ResponsavelDAO.php';

	try
	{
		$ultimoId = $_POST['ultimoId'];
		$enderecoId = $_POST['enderecoId'];
		
		$responsavelDAO = new ResponsavelDAO();

		$responsavelDAO->id = $ultimoId;
		$responsavelDAO->endereco = $enderecoId;
		
		$responsavelDAO->atualizarEndereco();

		$response['code'] = 'ok';
		$response['message'] = "Responsável criado com sucesso";
		echo json_encode($response);
	}
	catch (Exception $e)
	{
		//Erro::trataErro($e);
		//echo "Erro ao associar o endereço ao responsável.";
		$response['code'] = 'erro';
		$response['message'] = "Erro ao associar o endereço ao responsável.";
		echo json_encode($response);
	}