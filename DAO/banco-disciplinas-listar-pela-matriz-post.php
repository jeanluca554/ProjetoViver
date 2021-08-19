<?php
	require_once("Conexao.php");
	require_once("config.php");

	$response = array();	

	try
	{
		$idMatriz = $_POST['idMatriz'];
		$materias = array();
		$query = "	SELECT 	d.nome, 
							d.id
					FROM disciplina d
					JOIN disciplinas_da_matriz m
					ON d.id = m.id_disciplina
					WHERE m.id_matriz = $idMatriz";

		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
		
		$i = 0;

		foreach ($fetchAll as $linha)
		{
			$materias[$i] = array(
				'nome' => $linha['nome'], 
				'id' =>$linha['id']
			);
			// $responsaveis['nome'] = $linha['nome_responsavel'];
			// $responsaveis['cpf'] = $linha['cpf_responsavel'];
			$i++;
		}
		echo json_encode($materias);
	}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
