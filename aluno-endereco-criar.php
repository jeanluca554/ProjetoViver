<?php
	require_once 'global.php';
	require_once 'DAO/AlunoDAO.php';

	try
	{
		$ultimoId = $_POST['ultimoId'];
		$enderecoId = $_POST['enderecoId'];

		$alunoDAO = new AlunoDAO();

		$alunoDAO->id = $ultimoId;
		$alunoDAO->endereco = $enderecoId;
		
		$alunoDAO->atualizarEndereco();

		$response['code'] = 'ok';
		$response['message'] = "Endereço do aluno criado com sucesso";
		echo json_encode($response);
	}

	catch (Exception $e)
	{
		//$erro = Erro::trataErro($e);
		$response['code'] = 'erro';
		$response['message'] = "Erro ao associar o endereço ao AlunoDAO.";
		//$response['message'] = (string) $e;
		echo json_encode($response);
	}