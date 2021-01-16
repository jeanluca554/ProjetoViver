<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class MatriculaDAO extends Matricula
	{
		public function __construct($id_matricula = false)
		{
			if ($id_matricula)
			{
				$this->id = $id_matricula;				
				//$this->carregar();
			}
		}

		public function create($idAluno)
		{
			$alunoId = $idAluno;
			$query = 	"INSERT INTO matricula 
						(
							id_turma,
							id_aluno,
							tipo_ensino_turma,
							data_matricula
						) 
						VALUES 
						(
							:id_turma,
							:id_aluno,
							:tipo_ensino_turma,
							:data_matricula
						)";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':id_turma', $this->turma);
			$stmt->bindValue(':id_aluno', $alunoId);
			$stmt->bindValue(':tipo_ensino_turma', $this->tipoEnsino);
			$stmt->bindValue(':data_matricula', $this->dataMatricula);
			

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
			$query ="	UPDATE turma
						SET	nome_turma = :nome_turma,
							sigla = :sigla,
							ano = :ano,
							turno = :turno,
							capacidade = :capacidade,
							tipo_ensino_turma = :tipo_ensino,
							num_ensino_turma = :num_ensino
						WHERE id_turma = :id ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':id', $this->id);
			$stmt->bindValue(':nome_turma', $this->nome);
			$stmt->bindValue(':sigla', $this->sigla);
			$stmt->bindValue(':ano', $this->ano);
			$stmt->bindValue(':turno', $this->turno);
			$stmt->bindValue(':capacidade', $this->capacidade);
			$stmt->bindValue(':tipo_ensino', $this->tipoEnsino);
			$stmt->bindValue(':num_ensino', $this->numTipoEnsino);

			$stmt->execute();
		}
		
		public static function listarTurmas()
	    {
	        $query = "	SELECT 
								nome_turma,
								id_turma,
								sigla,
								ano,
								turno,
								capacidade,
								tipo_ensino_turma,
								num_ensino_turma,
								situacao,
								alunos_ativos
				 		FROM turma
						ORDER BY nome_turma";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
			return $lista;
		}

		public static function listarTurmasMatricula($ano, $tipo)
	    {
	        $query = "	SELECT 
								nome_turma,
								id_turma,
								sigla,
								turno
				 		FROM turma
						WHERE ano = $ano AND situacao = 1 AND tipo_ensino_turma = '$tipo'
						ORDER BY nome_turma";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
			return $lista;
		}

		public static function listarMatrizesOption()
	    {
			try 
			{
				$query = "	SELECT nome_matriz, id_matriz, tipo_ensino
				 			FROM matriz_curricular ORDER BY nome_matriz";
				$conexao = Conexao::pegarConexao();
				$resultado = $conexao->query($query);
				$lista = $resultado->fetchAll();
				
				foreach ($lista as $cursos) 
				{
					switch ($cursos['tipo_ensino'])
					{
						case 1:
							$cursos['tipo_ensino'] = "Educação Infantil";
							break;
						
						case 2:
							$cursos['tipo_ensino'] = "Ensino Fundamental";
							break;

						case 3:
							$cursos['tipo_ensino'] = "Ensino Médio";
							break;

						default:
							# code...
							break;
					}
					
					echo 	'<option value="'.$cursos['id_matriz'].'">'.
								$cursos['nome_matriz'].' - '. $cursos['tipo_ensino'].
							'</option>';
				}
			} catch (Exception $e) 
			{
				$response = (string) $e;
				echo json_encode($response);
			}
			
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
			$query = 	"	DELETE FROM turma
							WHERE id_turma = :idTurma";

			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->bindValue(':idTurma', $this->id);

			$stmt->execute();
		}
	}

	