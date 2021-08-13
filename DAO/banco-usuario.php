<?php
	require_once("Conexao.php");
	require_once("config.php");

	$funcao = $_POST['funcao'];
	switch ($funcao) 
	{
		case 1:
			$cpf = $_POST['cpf'];
			buscaCpf($cpf);
			break;

		case 2:
			$email = $_POST['email'];
			geraSenhaComEmail($email);
			break;

		case 3:
			$senha = $_POST['senha'];
			insereSenhaNoLogin($email);
			break;

		default:
			# code...
			break;
	}
	// $cpf = $_POST['cpf'];
	// if ($funcao == 1)
	// {
	// 	buscaCpf($cpf);
	// }


	function buscaUsuario($email, $senha) {
		$senhaMd5 = md5($senha);
		
		$query = "select * from login where email = :email and senha = :senha";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);

		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':senha', $senhaMd5);

		$stmt->execute();

		$usuario = $stmt->fetch();

		return $usuario;
	}

	function pegaIdFuncionario($id) {
		
		$query = "	SELECT 	f.cpf_funcionario
					FROM funcionario f
					JOIN login l
					ON l.id_login = f.id_login
					WHERE l.id_login = :id";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);

		$stmt->bindValue(':id', $id);

		$stmt->execute();

		$idUsuario = $stmt->fetch();

		return $idUsuario;
	}

	function buscaCpf($cpf) {
		// $query = "select * from funcionario where cpf_funcionario = :cpf";
		$query = "SELECT id_funcionario FROM funcionario WHERE cpf_funcionario = :cpf AND id_login IS NULL";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);

		$stmt->bindValue(':cpf', $cpf);

		$stmt->execute();

		$usuario = $stmt->fetch();

		//return $usuario;
		if($usuario == false)
		{
			//$_SESSION["danger"] = "CPF ainda não cadastrado. Por favor, entre em contato com a secretaria da escola.";
			echo json_encode($usuario);
			// return 1;
			// header("Location: loginInvalido.php");
		} else {
			// $_SESSION["success"] = "Desenvolva a próxima parte";
			// return $usuario;
			echo json_encode($usuario);
			// echo json_encode($usuario);
			// header("Location: primeiroAcessoEmail.php");
		}
	}

	function insereEmailNoLogin($email) {
		$query = "INSERT INTO login (email) VALUES (:email)";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);

		$stmt->bindValue(':email', $email);

		$stmt->execute();
		$ultimo = $conexao->lastInsertId();
		return $ultimo;
	}

	function insereSenhaNoLogin($senha) {
		$query = "INSERT INTO login (senha) VALUES (:senha)";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);

		$stmt->bindValue(':senha', $senha);

		$stmt->execute();
		$ultimo = $conexao->lastInsertId();
		return $ultimo;
	}

	function geraSenhaComEmail($email) {
		$md5 = md5($email);
		$senhaGerada = substr($md5, -8);
		echo $senhaGerada;
	}