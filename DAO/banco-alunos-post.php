<?php
	require("Conexao.php");
	require_once("config.php");
    session_start();
    
    $funcao = $_POST['funcao'];
    $idAluno = $_POST['idAluno'];

	switch ($funcao) 
	{
		case 1:
			buscaDadosAluno($idAluno);
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