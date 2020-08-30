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

		public function update()
		{
			$query ="	UPDATE aluno 
						SET	nome_aluno = :nome,
					      	nascimento_aluno = :nascimento,
					      	sexo = :sexo, 
					      	nacionalidade = :nacionalidade, 
					      	estado_nascimento = :estado, 
					      	cidade_nascimento = :cidade, 
					      	pais_nascimento = :pais
						WHERE id_aluno = :id ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome', $this->nome);
			$stmt->bindValue(':nascimento', $this->nascimento);
			$stmt->bindValue(':sexo', $this->sexo);
			$stmt->bindValue(':nacionalidade', $this->nacionalidade);
			$stmt->bindValue(':estado', $this->estado);
			$stmt->bindValue(':cidade', $this->cidade);
			$stmt->bindValue(':pais', $this->pais);
			$stmt->bindValue(':id', $this->id);

			$stmt->execute();
		}

		public function update2()
		{
			return $this->id;
		}

		public function atualizarEndereco()
	    {
	        $query = "UPDATE aluno SET id_endereco_residencia = :endereco WHERE id_aluno = :idAluno";
	        $conexao = Conexao::pegarConexao();
	        $stmt = $conexao->prepare($query);
	        $stmt->bindValue(':endereco', $this->endereco);
	        $stmt->bindValue(':idAluno', $this->id);
	        
	        $stmt->execute();
		}
		
		public static function listarAlunos()
	    {
	        $query = "	SELECT nome_aluno, id_aluno, id_endereco_residencia
				 		FROM aluno ORDER BY nome_aluno";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
	        return $lista;
	    }

	}