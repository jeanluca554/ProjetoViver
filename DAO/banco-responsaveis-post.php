<?php
	require_once("Conexao.php");
	require_once("config.php");
	session_start();

	
	$funcao = $_POST['funcao'];


	switch ($funcao) 
	{
		case 1:
			pegaResponsaveis();
			break;

		case 2:
			insereResponsavelPeloAluno();
			break;
		
		default:
			# code...
			break;
	}


	function insereResponsavelPeloAluno()		
	{
		try
		{
			$idAluno = $_SESSION['alunoID'];

			$cpf = $_POST['cpf'];

	        $query = "	INSERT INTO responsavel_pelo_aluno
	        			( 
	        				responsavel_cpf,
	        				aluno_id
	        			)
	        			VALUES
	        			(
	        				:cpf,
	        				:idAluno
	        			)";
	                  
	        $conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
	        
	        $stmt->bindValue(':cpf', $cpf);
	        $stmt->bindValue(':idAluno', $idAluno);

	        $stmt->execute();

	        return "Cadastrado";

		}
		catch (Exception $e)
		{
			return "erro";
		}

		
	}

	function pegaResponsaveisEFuncionarios()
	{
		$responsavelDigitado = $_POST['responsavel'];
		//$query = "SELECT * FROM funcionario WHERE nome_funcionario like '%".$responsavelDigitado."%'";
		$query = "SELECT DISTINCT nome_responsavel, cpf_responsavel
		FROM responsavel WHERE nome_responsavel like '%".$responsavelDigitado."%'
		UNION ALL
		SELECT DISTINCT nome_funcionario, cpf_funcionario
		FROM funcionario 
		WHERE nome_funcionario like '%".$responsavelDigitado."%'";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
		$espaco = "&nbsp--&nbsp";
	
		foreach ($fetchAll as $responsaveis) 
		{
			echo "<a href='#' class='list-group-item list-group-item-action border-1'>".$responsaveis['nome_responsavel'].$espaco.$responsaveis['cpf_responsavel']."</a>";
			

			/*echo "<tr class='border-1'>
					<td align='left'>".$responsaveis['nome_funcionario']."</td>
					<td align='right'>".$responsaveis['cpf_funcionario']."</td>
				  </tr>";*/

		}
	}

	function pegaResponsaveis()
	{
		$responsavelDigitado = $_POST['responsavel'];
		$query = "	SELECT nome_responsavel, cpf_responsavel
					FROM responsavel 
					WHERE nome_responsavel 
					like '%".$responsavelDigitado."%'";

		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
		$espaco = "&nbsp--&nbsp";
	
		foreach ($fetchAll as $responsaveis) 
		{
			echo "<a href='#' class='list-group-item list-group-item-action border-1'>".$responsaveis['nome_responsavel'].$espaco.$responsaveis['cpf_responsavel']."</a>";
		}
	}

	function colocaResponsaveisNaTabela()
	{
		$idAluno = $_SESSION['alunoID'];
		$responsavelCPF = $_SESSION['cpfResponsavel'];

		$query = "	SELECT nome_responsavel, cpf_responsavel
					FROM responsavel 
					WHERE nome_responsavel 
					like '%".$responsavelDigitado."%'";

		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
	}