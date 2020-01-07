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
				$this->carregar();
			}
		}

		public function carregar()
		{
			$query = "SELECT nome_funcionario, salario_funcionario FROM funcionario WHERE id_funcionario = :id_funcionario";
			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->bindValue(':id_funcionario', $this->id);
			$stmt->execute();
			$linha = $stmt->fetch();
			$this->nome = $linha['nome_funcionario'];
			$this->salario_funcionario = $linha['salario_funcionario'];
		}

		public static function listar()
	    {
	        $query = "SELECT r.nome, preco, descricao, categoria_id, c.nome as categoria_nome
	                  FROM produtos p
	                  INNER JOIN categorias c ON p.categoria_id = c.id
	                  ORDER BY p.nome ";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
	        return $lista;
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

			console.log($ultimo);
			return $ultimo;


		}

		public function atualizarEndereco()
	    {
	        $query = "UPDATE responsavel SET id_endereco_residencia = :endereco WHERE id_responsavel = :id";
	        $conexao = Conexao::pegarConexao();
	        $stmt = $conexao->prepare($query);
	        $stmt->bindValue(':endereco', $this->endereco);
	        $stmt->bindValue(':id', $this->id);
	        
	        $stmt->execute();
	    }
	}