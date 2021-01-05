<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class MatrizCurricularDAO extends MatrizCurricular
	{
		public function __construct($id_matriz = false)
		{
			if ($id_matriz)
			{
				$this->id = $id_matriz;				
				//$this->carregar();
			}
		}

		public function create()
		{
			$query = 	"INSERT INTO matriz_curricular 
						(
							nome_matriz
						) 
						VALUES 
						(
							:nome_matriz
						)";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome_matriz', $this->nome);

			$stmt->execute();
			$ultimo = $conexao->lastInsertId();
			return $ultimo;
		}

		/* public function apresentaNome()
		{
			$nome = $this->nome;
			return $nome;
		} */

		public function update()
		{
			$query ="	UPDATE matriz_curricular
						SET	nome_matriz = :nome
						WHERE id_matriz = :id ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome', $this->nome);
			$stmt->bindValue(':id', $this->id);

			$stmt->execute();
		}
		
		public static function listarMatrizes()
	    {
	        $query = "	SELECT nome_matriz, id_matriz
				 		FROM matriz_curricular ORDER BY nome_matriz";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
			return $lista;
		}

		public static function listarDisciplinasEcho()
	    {
	        $query = "	SELECT nome, id
				 		FROM disciplina ORDER BY nome";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
			foreach ($lista as $disciplinas) 
			{
				echo '<option value="'.$disciplinas['id'].'">'.$disciplinas['nome'].'</option>';
			}
		}

		public static function listarDisciplinaEspecifica()
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

		public function deletaDisciplinasDaMatriz()
		{
			$query ="	SELECT 	d.id
						FROM disciplina d
						JOIN disciplinas_da_matriz m
						ON d.id = m.id_disciplina
						WHERE m.id_matriz = :idDisciplina";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':idDisciplina', $this->id);

			$stmt->execute();
			$fetchAll = $stmt->fetchAll();

			$tamanho = count($fetchAll);
			$tem = $tamanho;
			$naoTem = "Não tem matérias";

			if ($tamanho > 0)
			{
				foreach ($fetchAll as $linha)
				{
					$idDisciplina = $linha['id'];
					try 
					{	
						$query = 	"	DELETE FROM disciplinas_da_matriz
										WHERE id_disciplina = :idDisciplina AND id_matriz = :idMatriz";

						$conexao = Conexao::pegarConexao();
						$stmt = $conexao->prepare($query);
						$stmt->bindValue(':idDisciplina', $idDisciplina);
						$stmt->bindValue(':idMatriz', $this->id);

						$stmt->execute();
					} 
					catch (Exception $e)
					{
						$response['text'] = (string) $e;
						$response['message'] = "erro no catch";
						// echo json_encode($e);
					}
				}
				return $tem;
			}
			else {
				return $naoTem;
			}
		}

		public function delete()
		{
			$query = 	"	DELETE FROM matriz_curricular
							WHERE id_matriz = :idMatriz";

			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->bindValue(':idMatriz', $this->id);

			$stmt->execute();
		}
	}

	