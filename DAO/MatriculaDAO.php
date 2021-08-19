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

		public function update($movimentacao, $dataAlteracao)
		{
			$query ="	UPDATE matricula
						SET	situacao = '$movimentacao',
							data_fim_matricula = :dataAlteracao
						WHERE id_matricula = :id ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':id', $this->id);
			$stmt->bindValue(':dataAlteracao', $this->dataMatricula);

			$stmt->execute();
		}
		
		public static function listarMatriculasDoAluno($idAluno)
	    {
			$matriculas = array();
			$query = "	SELECT 	t.ano,
								t.tipo_ensino_turma,
								t.nome_turma,
								t.sigla,
								t.turno,
								t.id_turma,
								m.id_matricula,
								m.data_matricula,
								m.data_fim_matricula,
								m.situacao
						FROM matricula m
						INNER JOIN turma t
						ON m.id_turma = t.id_turma
						WHERE m.id_aluno = $idAluno";

	        $conexao = Conexao::pegarConexao();
	        $stmt = $conexao->query($query);
	        $stmt->execute();
			$fetchAll = $stmt->fetchAll();
			
			$i = 0;

			foreach ($fetchAll as $linha)
			{
				$matriculas[$i] = array(
					'id_matricula' => $linha['id_matricula'],
					'ano' => $linha['ano'],
					'tipo_ensino_turma' => $linha['tipo_ensino_turma'],
					'nome_turma' => $linha['nome_turma'],
					'sigla' => $linha['sigla'],
					'turno' => $linha['turno'],
					'id_turma' => $linha['id_turma'],
					'data_matricula' => $linha['data_matricula'],
					'data_fim_matricula' => $linha['data_fim_matricula'],
					'situacao' => $linha['situacao']
				);
				
				$i++;
			}
			return $matriculas;
		}

		public static function verificarMatriculasDoAluno($idAluno, $ano)
	    {
	        $query = "	SELECT 	t.nome_turma,
								t.sigla
						FROM matricula m
						INNER JOIN turma t
						ON m.id_turma = t.id_turma
						WHERE m.id_aluno = $idAluno AND t.ano = $ano AND m.situacao = 'Ativo'";
	        $conexao = Conexao::pegarConexao();
	        $stmt = $conexao->query($query);
	        $stmt->execute();
			$fetchAll = $stmt->fetchAll();
			
			$i = 0;

			foreach ($fetchAll as $linha)
			{
				$matriculas[$i] = array(
					'nome_turma' => $linha['nome_turma'],
					'sigla' => $linha['sigla'],
				);
				
				$i++;
			}

			return $fetchAll;

			// if ($matriculas)
			// {
			// 	return $matriculas = 'não ha turmas';
			// }
			// else
			// {
			// 	return $matriculas;
			// }

			
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

		public function delete()
		{
			$query = 	"	DELETE FROM matricula
							WHERE id_matricula = :idMatricula";

			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->bindValue(':idMatricula', $this->id);

			$stmt->execute();
		}
	}

	