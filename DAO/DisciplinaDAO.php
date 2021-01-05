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

		public static function listarDisciplinasPelaMatriz($idMatriz)
	    {
			$materias = array();
			$query = "	SELECT 	d.nome, 
								d.id
						FROM disciplina d
						JOIN disciplinas_da_matriz m
						ON d.id = m.id_disciplina
						WHERE m.id_matriz = $idMatriz";

			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->execute();
			$fetchAll = $stmt->fetchAll();
			
			$i = 0;

			foreach ($fetchAll as $linha)
			{
				$materias[$i] = array(
					'nome' => $linha['nome'], 
					'id' =>$linha['id']
				);
				// $responsaveis['nome'] = $linha['nome_responsavel'];
				// $responsaveis['cpf'] = $linha['cpf_responsavel'];
				$i++;
			}
				echo json_encode($materias);
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
			$query ="	DELETE FROM disciplina 
						WHERE id = :idDisciplina ";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':idDisciplina', $this->id);

			$stmt->execute();
		}
	}