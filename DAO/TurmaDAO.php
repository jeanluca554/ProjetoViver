<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class TurmaDAO extends Turma
	{
		public function __construct($id_turma = false)
		{
			if ($id_turma)
			{
				$this->id = $id_turma;				
				//$this->carregar();
			}
		}

		public function create()
		{
			$query = 	"INSERT INTO turma 
						(
							nome_turma,
							sigla,
							ano,
							turno,
							capacidade,
							tipo_ensino_turma,
							num_ensino_turma
						) 
						VALUES 
						(
							:nome_turma,
							:sigla,
							:ano,
							:turno,
							:capacidade,
							:tipo_ensino,
							:num_ensino
						)";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome_turma', $this->nome);
			$stmt->bindValue(':sigla', $this->sigla);
			$stmt->bindValue(':ano', $this->ano);
			$stmt->bindValue(':turno', $this->turno);
			$stmt->bindValue(':capacidade', $this->capacidade);
			$stmt->bindValue(':tipo_ensino', $this->tipoEnsino);
			$stmt->bindValue(':num_ensino', $this->numTipoEnsino);

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

		public function alteraQtdAlunoAtivo($acao)
		{
			/*if ($acao == "+")
			{
				$query ="	UPDATE turma
							SET	alunos_ativos = alunos_ativos + 1
							WHERE id_turma = :id ";
			}
			else
			{
				$query ="	UPDATE turma
							SET	alunos_ativos = alunos_ativos - 1
							WHERE id_turma = :id ";
			}*/
			
			$query ="	UPDATE turma
						SET	alunos_ativos = alunos_ativos $acao 1
						WHERE id_turma = :id ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':id', $this->id);

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

		public static function listarTurmasProfessor($idProfessor)
	    {
	        $query = "	SELECT t.nome_turma as Turma, d.nome as Disciplina, t.id_turma, t.sigla, d.id AS idDisciplina
						FROM turma t
						INNER JOIN professor_vinculado p
						ON t.id_turma = p.id_turma
						INNER JOIN disciplina d
						ON d.id = p.id_disciplina
						WHERE p.id_professor = '$idProfessor' ";
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
								turno, 
								capacidade,
								alunos_ativos
				 		FROM turma
						WHERE ano = $ano AND situacao = 1 AND tipo_ensino_turma = '$tipo'
						ORDER BY nome_turma";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
			return $lista;
		}

		public static function listarTurmasAssociarProf($ano, $tipo)
	    {
	        $query = "	SELECT 
								ano,
								nome_turma,
								id_turma,
								sigla,
								turno, 
								tipo_ensino_turma,
								num_ensino_turma
				 		FROM turma
						WHERE ano = $ano AND situacao = 1 AND tipo_ensino_turma = '$tipo'
						ORDER BY nome_turma";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
			return $lista;
		}

		public static function listarProfessoresAssociados($idTurma)
	    {
	        $query = "	SELECT 
								ano,
								nome_turma,
								id_turma,
								sigla,
								turno, 
								tipo_ensino_turma,
								num_ensino_turma
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

	