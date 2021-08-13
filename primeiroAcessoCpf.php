<?php 
	require_once("DAO/banco-usuario.php");
	require_once("logica-usuario.php");

	$funcao = $_POST['funcao'];

	switch ($funcao) 
	{
		case 1:
			$cpf = $_POST["cpf"];
			verificaCpfCadastrado($cpf);
		break;

		case 2:
			$idEndereco = $_POST['idEndereco'];

			if ($idEndereco == null)
			{
				$idEndereco = 1;
			}

			// $idEndereco = 142;
			buscaEnderecoAluno($idEndereco);
		break;

		case 3:
			$idAluno = $_POST['id'];
			excluirAluno($idAluno);
		break;
		
		default:
			# code...
			break;
	}

	function verificaCpfCadastrado($cpf)
	{
		$usuario = buscaCpf($cpf);

		if($usuario == null)
		{
			$_SESSION["danger"] = "CPF ainda não cadastrado. Por favor, entre em contato com a secretaria da escola.";
			echo $usuario;
			// return 1;
			// header("Location: loginInvalido.php");
		} else {
			// $_SESSION["success"] = "Desenvolva a próxima parte";
			// return $usuario;
			echo json_encode($usuario);
			confirmaCpf($cpf);
			// echo json_encode($usuario);
			// header("Location: primeiroAcessoEmail.php");
		}
		die();
	}
?>