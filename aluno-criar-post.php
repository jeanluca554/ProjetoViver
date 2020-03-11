<?php
	require_once 'global.php';
	require_once 'DAO/AlunoDAO.php';
	session_start();

	$response = array();	

	try
	{
		$nome = $_POST['nome'];
		$postNascimento = $_POST['dataNascimento'];
		$nascimento = trataData($postNascimento);
		$sexo = $_POST['sexo'];
		$nacionalidade = $_POST['nacionalidade'];
		$estado = $_POST['estado'];
		$cidade = $_POST['cidade'];
		$pais = $_POST['pais'];
		
		$alunoDAO = new AlunoDAO();

		$alunoDAO->nome = $nome;
		$alunoDAO->nascimento = $nascimento;
		$alunoDAO->sexo = $sexo;
		$alunoDAO->nacionalidade = $nacionalidade;
		$alunoDAO->estado = $estado;
		$alunoDAO->cidade = $cidade;
		$alunoDAO->pais = $pais;

		$ultimoID = $alunoDAO->create();

		$_SESSION["alunoID"] = $ultimoID;
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