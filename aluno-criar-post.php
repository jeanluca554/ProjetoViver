	<?php
	require_once 'global.php';
	require_once 'DAO/AlunoDAO.php';

	$response = array();

	try
	{
		$nome = $_POST['nome'];
		$nascimento = $_POST['dataNascimento'];
		//echo $nascimento;
		//echo "Qualquer coisa<br>";
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

		$response['mensagem'] = 'ok';
		$response['ultimoID'] = $ultimoID;
		echo json_encode($response);
	}
	
	catch (Exception $e)
	{
		Erro::trataErro($e);
		//echo "Este CPF já foi cadastrado. Por favor, cadastre um número de CPF diferente.";
		$response['mensagem'] = 'erro';
		//$response['title'] = "Ops...";
		$response['title'] = $e;
		$response['text'] = "Houve um erro ao cadastrar o aluno". $nascimento;
		echo json_encode($response);
	}