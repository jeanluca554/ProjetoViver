<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class AlunoDAO extends Aluno
	{
		public function __construct($id_aluno = false)
		{
			if ($id_aluno)
			{
				$this->id = $id_aluno;				
				//$this->carregar();
			}
		}

		

		public function create()
		{
			$query = 	"INSERT INTO aluno 
					  	(
					      	nome_aluno, 
					      	nascimento_aluno,
					      	sexo, 
					      	nacionalidade, 
					      	estado_nascimento, 
					      	cidade_nascimento, 
					      	pais_nascimento
					    ) 
					    VALUES 
					    (
					    	:nome_aluno, 
					    	:nascimento, 
					    	:sexo, 
					    	:nacionalidade, 
					    	:estado, 
					    	:cidade, 
					    	:pais
					    )";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome_aluno', $this->nome);
			$stmt->bindValue(':nascimento', $this->nascimento);
			$stmt->bindValue(':sexo', $this->sexo);
			$stmt->bindValue(':nacionalidade', $this->nacionalidade);
			$stmt->bindValue(':estado', $this->estado);
			$stmt->bindValue(':cidade', $this->cidade);
			$stmt->bindValue(':pais', $this->pais);

			$stmt->execute();
			$ultimo = $conexao->lastInsertId();
			return $ultimo;


		}

	}