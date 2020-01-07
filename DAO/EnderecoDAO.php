<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class EnderecoDAO extends Endereco
	{
		public function __construct($id_endereco = false)
		{
			if ($id_endereco)
			{
				$this->id = $id_endereco;				
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

		public function create()
		{
			$query = "INSERT INTO endereco_residencial (cep, logradouro, numero_casa, complemento, bairro, cidade) VALUES (:cep, :logradouro, :numero, :complemento, :bairro, :cidade)";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':cep', $this->cep);
			$stmt->bindValue(':logradouro', $this->logradouro);
			$stmt->bindValue(':numero', $this->numero);
			$stmt->bindValue(':complemento', $this->complemento);
			$stmt->bindValue(':bairro', $this->bairro);
			$stmt->bindValue(':cidade', $this->cidade);

			$stmt->execute();
			$ultimo = $conexao->lastInsertId();

			return $ultimo;

		}

		public static function read()
	    {
	        $query = "SELECT id_funcionario, nome_funcionario, cargo_funcionario FROM funcionario ORDER BY nome_funcionario";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
	        return $lista;
	    }

	    public function limpaSalario($valor)
		{
			$valor = trim($valor);
			$valor = str_replace(".", "", $valor);
			$valor = str_replace(",", "", $valor);
			
			return (double)$valor;
		}
	}