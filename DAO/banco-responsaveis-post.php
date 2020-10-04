<?php
	require("Conexao.php");
	require_once("config.php");
	session_start();

	isset($_SESSION['alunoID']) ? $idAluno = $_SESSION['alunoID'] : $idAluno = 1;
	// $idAluno = isset($_SESSION['alunoID']);
	//$idAluno = 123;
	// $idAluno = $_SESSION['alunoID'];

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
			atribuirParentesco();
			break;

		case 5:
			$id = $_POST['id'];
			buscarEExcluirResponsavelPeloAluno($id);
			break;
		
		case 6:
			$cpf = $_POST['cpf'];
			buscarDadosResponsavel($cpf);
			break;

		case 7:
            $enderecoResp = $_POST['enderecoResp'];

            if ($enderecoResp == null)
            {
                $enderecoResp = 1;
            }

			buscaEnderecoResponsavel($enderecoResp);
		break;
		
		case 8:
			$idAluno = $_POST['idAluno'];
			$cpf = $_POST['cpf'];
			$idRespPeloAluno = $_POST['idRespPeloAluno'];
			buscarEExcluirResponsavelVinculado($idAluno, $cpf, $idRespPeloAluno);
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


			$query = "	SELECT 	r.nome_responsavel, 
								r.cpf_responsavel, 
								b.id_responsavel_pelo_aluno,
								b.parentesco_responsavel,
								r.id_endereco_residencia
						FROM responsavel_pelo_aluno b
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
				$responsaveis[$i] = array(
					'nome' => $linha['nome_responsavel'], 
					'cpf' =>$linha['cpf_responsavel'], 
					'idResponsavelPeloAluno' => $linha['id_responsavel_pelo_aluno'],
					'parentescoResponsavel' => $linha['parentesco_responsavel'],
					'idEnderecoResp' => $linha['id_endereco_residencia']
				);
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
			$idRespAluno = $_POST['idResponsavelPeloAluno'];
			$parentesco = $_POST['parentescoSelecionado'];

			$query = 	"	UPDATE responsavel_pelo_aluno 
							SET parentesco_responsavel = :parentesco 
							WHERE id_responsavel_pelo_aluno = :respAlunoId
						";

	        $conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
	        
	        $stmt->bindValue(':parentesco', $parentesco);
	        $stmt->bindValue(':respAlunoId', $idRespAluno);

			$stmt->execute();
			$ultimo = $conexao->lastInsertId();
			$_SESSION['responsavelPeloAlunoID'] = $ultimo;

			$response['message'] = "Parentesco atribuído com sucesso" .$idRespAluno;
			echo json_encode($response);

		}
		catch (Exception $e)
		{
			echo json_encode($e);
		}
	}

	function buscarEExcluirResponsavelPeloAluno($id)
	{
		try
		{	
			$query = 	"	SELECT 	id_responsavel_pelo_aluno
							FROM 	responsavel_pelo_aluno
							WHERE 	aluno_id = :idAluno;
						";

						

	        $conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
	        $stmt->bindValue(':idAluno', $id);

			$stmt->execute();
			$fetchAll = $stmt->fetchAll();

			// excluirResponsavelPeloAluno($fetchAll);

			foreach ($fetchAll as $linha)
			{
				$idResponsavelPeloAluno = $linha['id_responsavel_pelo_aluno'];
				try 
				{	
					$query = 	"	DELETE FROM responsavel_pelo_aluno
									WHERE id_responsavel_pelo_aluno = :idResponsavel
								";

					$conexao = Conexao::pegarConexao();
					$stmt = $conexao->prepare($query);
					$stmt->bindValue(':idResponsavel', $idResponsavelPeloAluno);

					$stmt->execute();
				} 
				catch (Exception $e)
				{
					$response['text'] = (string) $e;
					$response['message'] = "erro no catch";
					// echo json_encode($e);
				}
			}		
			// $response['message'] = "Parentesco atribuído com sucesso";
			echo json_encode($fetchAll);

		}

		catch (Exception $e)
		{
			$response['text'] = (string) $e;
			// echo json_encode($e);
		}
	}

	function excluirResponsavelPeloAluno($id)
	{
		try
		{	
			$query = 	"	SELECT 	id_responsavel_pelo_aluno
							FROM 	responsavel_pelo_aluno
							WHERE 	aluno_id = :idAluno;
						";

						

	        $conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
	        $stmt->bindValue(':idAluno', $id);

			$stmt->execute();
			$fetchAll = $stmt->fetchAll();

			foreach ($fetchAll as $linha)
			{
				$idResponsavelPeloAluno = $linha['id_responsavel_pelo_aluno'];
				try 
				{	
					$query = 	"	DELETE FROM responsavel_pelo_aluno
									WHERE id_responsavel_pelo_aluno = :idResponsavel
								";

					$conexao = Conexao::pegarConexao();
					$stmt = $conexao->prepare($query);
					$stmt->bindValue(':idResponsavel', $idResponsavelPeloAluno);

					$stmt->execute();
				} 
				catch (Exception $e)
				{
					$response['text'] = (string) $e;
					// echo json_encode($e);
				}
			}		
			// $response['message'] = "Parentesco atribuído com sucesso";
			echo json_encode($fetchAll);

		}

		catch (Exception $e)
		{
			$response['text'] = (string) $e;
			// echo json_encode($e);
		}
	}

	function buscarDadosResponsavel($cpf)
	{
		try
		{
			$query = 	"	SELECT 
								rg_responsavel, 
								telefone_pessoal_responsavel, 
								telefone_adicional_responsavel 
							FROM responsavel
							WHERE cpf_responsavel = '".$cpf."'";

	        $conexao = Conexao::pegarConexao();
			$resultado = $conexao->query($query);
			$lista = $resultado->fetchAll();
			echo json_encode($lista);
			// echo json_encode($lista);

		}
		catch (Exception $e)
		{
			echo json_encode($e);
		}
	}

	function buscaEnderecoResponsavel($enderecoResp)
    {
        try
        {
            $query = "  SELECT 
                            cep,
                            logradouro,
                            numero_casa,
                            complemento,
                            bairro,
                            cidade, 
                            estado
                        FROM endereco_residencial
                        WHERE id_endereco_residencia = ".$enderecoResp;
                $conexao = Conexao::pegarConexao();
                $resultado = $conexao->query($query);
                $lista = $resultado->fetchAll();
                echo json_encode($lista);
        }

        catch (Exception $e)
        {
            echo Erro::trataErro($e);

            echo json_encode( (string) $e);
            // echo "eita Jovem!";
        }
	}
	
	function buscarEExcluirResponsavelVinculado($idAluno, $cpfResp, $idRespPeloAluno)
	{
		$resultadoRespFinanceiro = verificaRespFinanceiroDidatico($idAluno, $cpfResp);

		if ($resultadoRespFinanceiro == 1)
		{
			$response['mensagem'] = "O responsável está como responsável financeiro. Por isso não pode ser removido";
			$response['resultado'] = "Erro";

			echo json_encode($response);
		}
		else {
			if ($resultadoRespFinanceiro == 2)
			{
				$response['mensagem'] = "O responsável está como responsável didático. Por isso não pode ser removido";
				$response['resultado'] = "Erro";
				echo json_encode($response);
			}
			else 
			{
				try 
				{	
					$query = 	"	DELETE FROM responsavel_pelo_aluno
									WHERE id_responsavel_pelo_aluno = :idRespPeloAluno;
								";

					$conexao = Conexao::pegarConexao();
					$stmt = $conexao->prepare($query);
					$stmt->bindValue(':idRespPeloAluno', $idRespPeloAluno);

					$stmt->execute();
					$response['resultado'] = "Ok";
					echo json_encode($response);
				} 
				catch (Exception $e)
				{
					$response['resultado'] = (string) $e;
					$response['resultado'] = "Erro";
					echo json_encode($response);
				}
				
			}
		}
		
		/* try
		{	
			$query = 	"	SELECT 	id_responsavel_pelo_aluno
							FROM 	responsavel_pelo_aluno
							WHERE 	aluno_id = :idAluno;
						";

						

	        $conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
	        $stmt->bindValue(':idAluno', $id);

			$stmt->execute();
			$fetchAll = $stmt->fetchAll();

			foreach ($fetchAll as $linha)
			{
				$idResponsavelPeloAluno = $linha['id_responsavel_pelo_aluno'];
				try 
				{	
					$query = 	"	DELETE FROM responsavel_pelo_aluno
									WHERE id_responsavel_pelo_aluno = :idResponsavel
								";

					$conexao = Conexao::pegarConexao();
					$stmt = $conexao->prepare($query);
					$stmt->bindValue(':idResponsavel', $idResponsavelPeloAluno);

					$stmt->execute();
				} 
				catch (Exception $e)
				{
					$response['text'] = (string) $e;
					// echo json_encode($e);
				}
			}		
			// $response['message'] = "Parentesco atribuído com sucesso";
			echo json_encode($fetchAll);

		} 

		catch (Exception $e)
		{
			$response['text'] = (string) $e;
			// echo json_encode($e);
		}*/
	}

	function verificaRespFinanceiroDidatico($idAluno, $cpfResp)
	{
		try
		{	
			$query = 	"	SELECT 	resp_financeiro, resp_didatico
							FROM 	aluno
							WHERE 	id_aluno = :idAluno;
						";

	        $conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
	        $stmt->bindValue(':idAluno', $idAluno);

			$stmt->execute();
			$fetchAll = $stmt->fetchAll();


			foreach ($fetchAll as $cpf) 
			{
				if ($cpf['resp_financeiro'] == $cpfResp)
				{
					return 1;
				}
				else 
				{
					if ($cpf['resp_didatico'] == $cpfResp)
					{
						return 2;
					}
					else 
					{
						return 3;
					}
				}		
			}
		}
		catch (Exception $e)
		{
			$response['text'] = (string) $e;
			// echo json_encode($e);
		}
	}