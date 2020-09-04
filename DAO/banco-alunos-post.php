<?php
	require("Conexao.php");
	require_once("config.php");
    session_start();
    
    $funcao = $_POST['funcao'];

	switch ($funcao) 
	{
        case 1:
            $idAluno = $_POST['idAluno'];
            $_SESSION['alunoID'] = $idAluno;
			buscaDadosAluno($idAluno);
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
    
    function buscaDadosAluno($idAluno)
    {
        try
        {
            /* $query = "SELECT 
                        a.nascimento_aluno, 
                        a.sexo, 
                        a.nacionalidade, 
                        a.estado_nascimento, 
                        a.cidade_nascimento, 
                        a.pais_nascimento, 
                        a.id_endereco_residencia,
                        (select r.nome_responsavel
                            FROM aluno a
                            JOIN responsavel r
                            ON a.resp_financeiro = r.cpf_responsavel
                            WHERE id_aluno = ".$idAluno.") as resp_financeiro,
                        (select r.nome_responsavel
                            FROM aluno a
                            JOIN responsavel r
                            ON a.resp_didatico = r.cpf_responsavel
                            WHERE id_aluno = ".$idAluno.") as resp_didatico
                    FROM aluno a
                    WHERE id_aluno = ".$idAluno; */

                    $query = "  SELECT 
                                    nascimento_aluno, 
                                    sexo, 
                                    nacionalidade, 
                                    estado_nascimento, 
                                    cidade_nascimento, 
                                    pais_nascimento, 
                                    id_endereco_residencia,
                                    resp_financeiro,
                                    resp_didatico                        
                                FROM aluno 
                                WHERE id_aluno = ".$idAluno;

            $conexao = Conexao::pegarConexao();
            $resultado = $conexao->query($query);
            $lista = $resultado->fetchAll();
            echo json_encode($lista);
        }

        catch (Exception $e)
        {
            echo Erro::trataErro($e);

            echo json_encode( (string) $e);
        }
    }

    function buscaEnderecoAluno($idEndereco)
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
                        WHERE id_endereco_residencia = ".$idEndereco;
                $conexao = Conexao::pegarConexao();
                $resultado = $conexao->query($query);
                $lista = $resultado->fetchAll();
                echo json_encode($lista);
        }

        catch (Exception $e)
        {
            echo Erro::trataErro($e);

            // echo json_encode( (string) $e);
            echo "eita Jovem!";
        }
    }

    function excluirAluno($id)
    {
        try
        {
            $query = "  DELETE FROM aluno
                        WHERE id_aluno = :id";
            $conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
	        $stmt->bindValue(':id', $id);

			$stmt->execute();
        }

        catch (Exception $e)
        {
            //$response['text'] = $id;
            $response['text'] = (string) $e;
            // echo Erro::trataErro($e);

            // echo json_encode( (string) $e);
        }
    }