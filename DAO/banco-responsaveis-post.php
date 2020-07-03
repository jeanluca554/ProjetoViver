<?php
	require_once("Conexao.php");
	require_once("config.php");
	session_start();

	$idAluno = $_SESSION['alunoID'];

	$funcao = $_POST['funcao'];


	switch ($funcao) 
	{
		case 1:
			pegaResponsaveis();
			break;

		case 2:
			insereResponsavelPeloAluno($idAluno);
			break;

		case 3:
			colocaResponsaveisNaTabela($idAluno);
			break;

		case 4:
			colocaResponsaveisNaTabela($idAluno);
			break;
		
		default:
			# code...
			break;
	}


	function insereResponsavelPeloAluno($idAluno)		
	{
		try
		{
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
			$ultimo = $conexao->lastInsertId();
			$_SESSION['responsavelPeloAlunoID'] = $ultimo;

			echo json_encode($ultimo);
			//return $cpf;

		}
		catch (Exception $e)
		{
			echo json_encode($e);
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

	function colocaResponsaveisNaTabela($idAluno)
	{
		try
		{
			$idDoAluno = $idAluno;
			$responsaveis = array();


			$query = "	SELECT r.nome_responsavel, r.cpf_responsavel FROM responsavel_pelo_aluno b
						JOIN responsavel r
						ON r.cpf_responsavel = b.responsavel_cpf
						WHERE b.aluno_id = ".$idDoAluno;

			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->execute();
			$fetchAll = $stmt->fetchAll();
			//$responsaveis = json_encode($fetchAll);
			//echo $responsaveis;
			// echo print_r($fetchAll);
			$i = 0;

			foreach ($fetchAll as $linha)
			{
				$responsaveis[$i] = array('nome' => $linha['nome_responsavel'], 'cpf' =>$linha['cpf_responsavel']);
				// $responsaveis['nome'] = $linha['nome_responsavel'];
				// $responsaveis['cpf'] = $linha['cpf_responsavel'];
				$i++;
			}
				echo json_encode($responsaveis);
				//echo $responsaveis;
				//echo json_encode($idAluno);
		}

		catch (Exception $e)
		{
			//$erro = Erro::trataErro($e);
			$response['code'] = 'erro';
			//$response['message'] = "Erro ao associar o endereço ao AlunoDAO.";
			$response['message'] = (string) $e;
			echo json_encode($response);
		}
		
		
	}

	function atribuirParentesco()
	{
		try
		{
			$cpf = $_POST['cpf'];
			$parentesco = $_POST['parentescoSelecionado'];
			$responsavelDoAluno = $_SESSION['responsavelPeloAlunoID'] ;

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
			$ultimo = $conexao->lastInsertId();
			$_SESSION['responsavelPeloAlunoID'] = $ultimo;

			echo json_encode($cpf);
			//return $cpf;

		}
		catch (Exception $e)
		{
			echo json_encode($e);
		}
	}