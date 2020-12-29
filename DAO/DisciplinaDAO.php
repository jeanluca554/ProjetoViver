<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class DisciplinaDAO extends Disciplina
	{
		public function __construct($id_disciplina = false)
		{
			if ($id_disciplina)
			{
				$this->id = $id_disciplina;				
				//$this->carregar();
			}
		}

		public function create()
		{
			$query = 	"INSERT INTO disciplina 
						(
							nome
						) 
						VALUES 
						(
							:nome_disciplina
						)";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome_disciplina', $this->nome);

			$stmt->execute();
			$ultimo = $conexao->lastInsertId();
			return $ultimo;
		}

		

		public function update()
		{
			$query ="	UPDATE disciplina 
						SET	nome = :nome
						WHERE id = :id ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome', $this->nome);
			$stmt->bindValue(':id', $this->id);

			$stmt->execute();
		}
		
		public static function listarDisciplinas()
	    {
	        $query = "	SELECT nome, id
				 		FROM disciplina ORDER BY nome";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
	        return $lista;
		}

		public function delete()
		{
			$query ="	DELETE FROM disciplina 
						WHERE id = :idDisciplina ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':idDisciplina', $this->id);

			$stmt->execute();
		}
	}