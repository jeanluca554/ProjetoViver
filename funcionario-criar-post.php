<?php
	require_once 'global.php';
	require_once 'DAO/FuncionarioDAO.php';

	try
	{
		$nome = $_POST['nome'];
		$email= $_POST['email'];
		$cpf = $_POST['cpf'];
		$rg = $_POST['rg'];
		$telefone = $_POST['telefone'];
		$numeroAgencia = $_POST['numeroAgencia'];
		$numeroContaBancaria = $_POST['numeroContaBancaria'];
		$salario = $_POST['salario'];
		$cargo = $_POST['cargo'];

		$funcionarioDAO = new FuncionarioDAO();

		$salarioLimpo = $funcionarioDAO->limpaSalario($salario);

		$funcionarioDAO->nome = $nome;
		$funcionarioDAO->email_funcionario = $email;
		$funcionarioDAO->cpf = $cpf;
		$funcionarioDAO->rg = $rg;
		$funcionarioDAO->telefone = $telefone;
		$funcionarioDAO->numeroAgencia_funcionario = $numeroAgencia;
		$funcionarioDAO->numeroContaBancaria_funcionario = $numeroContaBancaria;
		$funcionarioDAO->salario_funcionario = $salarioLimpo;
		$funcionarioDAO->cargo_funcionario = $cargo;

		$funcionarioDAO->create();
	}
	catch (Exception $e)
	{
		Erro::trataErro($e);
	}