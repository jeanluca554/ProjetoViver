<?php
	require("Conexao.php");
	require_once("config.php");
    session_start();
    
    $funcao = $_POST['funcao'];

	switch ($funcao) 
	{
        case 1:
            $idAluno = $_POST['idAluno'];
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
		
		default:
			# code...
			break;
    }
    
    function buscaDadosAluno($idAluno)
    {
        try
        {
            $query = "  SELECT 
                            nascimento_aluno, 
                            sexo, 
                            nacionalidade, 
                            estado_nascimento, 
                            cidade_nascimento, 
                            pais_nascimento, 
                            id_endereco_residencia 
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