<?php
	require_once 'global.php';
	require_once 'DAO/TurmaDAO.php';

	$response = array();	

	try
	{
		$nome = $_POST['nomeTurma'];
		$sigla = $_POST['sigla'];
		$ano = $_POST['anoLetivo'];
		$turno = $_POST['turno'];
		$capacidade = $_POST['capacidade'];
		$tipoEnsino = $_POST['tipoEnsinoTurma'];
		$numTipoEnsino = $_POST['numTipoEnsino'];
		
		$turmaDAO = new TurmaDAO();

		$turmaDAO->nome = trim($nome);
		$turmaDAO->sigla = $sigla;
		$turmaDAO->ano = $ano;
		$turmaDAO->turno = $turno;
		$turmaDAO->capacidade = $capacidade;
		$turmaDAO->tipoEnsino = trim($tipoEnsino);
		$turmaDAO->numTipoEnsino = $numTipoEnsino;

		$ultimoID = $turmaDAO->create();

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
