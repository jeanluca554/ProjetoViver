<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class ResponsavelDAO extends Responsavel
	{
		public function __construct($id_responsavel = false)
		{
			if ($id_responsavel)
			{
				$this->id = $id_responsavel;				
				$this->carregar();
			}
		}

		public function carregar()
		{
			$query = "SELECT nome_funcionario, salario_funcionario 
					  FROM funcionario 
					  WHERE id_funcionario = :id_funcionario";
			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->bindValue(':id_funcionario', $this->id);
			$stmt->execute();
			$linha = $stmt->fetch();
			$this->nome = $linha['nome_funcionario'];
			$this->salario_funcionario = $linha['salario_funcionario'];
		}

		/* public static function listar()
	    {
	        $query = "SELECT r.nome, preco, descricao, categoria_id, c.nome as categoria_nome
	                  FROM produtos p
	                  INNER JOIN categorias c ON p.categoria_id = c.id
	                  ORDER BY p.nome ";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
	        return $lista;
	    } */

		public function create()
		{
			$query =   "INSERT INTO responsavel 
						(
							cpf_responsavel,
							nome_responsavel,							
							rg_responsavel,
							telefone_pessoal_responsavel, 
							telefone_adicional_responsavel
						) 
					  	VALUES 
					  	(
					  		:cpf_responsavel,
							:nome_responsavel, 
					  		:rg_responsavel,
					  		:telefone_responsavel,
					  		:telefone_adicional_responsavel
					  	)";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome_responsavel', $this->nome);
			$stmt->bindValue(':cpf_responsavel', $this->cpf);
			$stmt->bindValue(':rg_responsavel', $this->rg);
			$stmt->bindValue(':telefone_responsavel', $this->telefone);
			$stmt->bindValue(':telefone_adicional_responsavel', $this->telefoneAdicional);

			$stmt->execute();
			$ultimo = $conexao->lastInsertId();

			return $ultimo;

		}

		public function atualizarEndereco()
	    {
	        $query = "UPDATE responsavel SET id_endereco_residencia = :endereco WHERE cpf_responsavel = :cpf";
	        $conexao = Conexao::pegarConexao();
	        $stmt = $conexao->prepare($query);
	        $stmt->bindValue(':endereco', $this->endereco);
	        $stmt->bindValue(':cpf', $this->cpf);
	        
	        $stmt->execute();
		}
		
		public function update()
		{
			$query ="	UPDATE responsavel 
						SET	nome_responsavel = :nome,
							rg_responsavel = :rg, 
							telefone_pessoal_responsavel = :telPessoal, 
							telefone_adicional_responsavel = :telAdicional
						WHERE cpf_responsavel = :cpf";
					  	
			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':cpf', $this->cpf);
			$stmt->bindValue(':nome', $this->nome);
			$stmt->bindValue(':rg', $this->rg);
			$stmt->bindValue(':telPessoal', $this->telefone);
			$stmt->bindValue(':telAdicional', $this->telefoneAdicional);
			

			$stmt->execute();
		}
	}
	