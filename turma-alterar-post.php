<?php
	require_once 'global.php';
	require_once 'DAO/TurmaDAO.php';

	$response = array();	

	try
	{
		$id = $_POST['idTurma'];
		$nome = $_POST['nomeTurma'];
		$sigla = $_POST['sigla'];
		$ano = $_POST['anoLetivo'];
		$turno = $_POST['turno'];
		$capacidade = $_POST['capacidade'];
		$tipoEnsino = $_POST['tipoEnsinoTurma'];
		$numTipoEnsino = $_POST['numTipoEnsino'];
		
		$turmaDAO = new TurmaDAO($id);

		$turmaDAO->nome = $nome;
		$turmaDAO->sigla = $sigla;
		$turmaDAO->ano = $ano;
		$turmaDAO->turno = $turno;
		$turmaDAO->capacidade = $capacidade;
		$turmaDAO->tipoEnsino = $tipoEnsino;
		$turmaDAO->numTipoEnsino = $numTipoEnsino;

		$turmaDAO->update();

		$response['mensagem'] = 'ok';
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
