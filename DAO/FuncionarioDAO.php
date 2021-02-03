<?php
	require_once 'global.php';
	require_once 'Conexao.php';

	class FuncionarioDAO extends Funcionario
	{
		public function __construct($id_funcionario = false)
		{
			if ($id_funcionario)
			{
				$this->id = $id_funcionario;				
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
			$query = "INSERT INTO funcionario (nome_funcionario, email_funcionario, senha_funcionario, cpf_funcionario, rg_funcionario, telefone_funcionario, numeroAgencia_funcionario, numeroContaBancaria_funcionario, salario_funcionario, cargo_funcionario) VALUES (:nome_funcionario, :email_funcionario, :senha_funcionario, :cpf_funcionario, :rg_funcionario, :telefone_funcionario, :numeroAgencia_funcionario, :numeroContaBancaria_funcionario, :salario_funcionario, :cargo_funcionario)";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':nome_funcionario', $this->nome);
			$stmt->bindValue(':email_funcionario', $this->email_funcionario);
			$stmt->bindValue(':senha_funcionario', $this->senha_funcionario);
			$stmt->bindValue(':cpf_funcionario', $this->cpf);
			$stmt->bindValue(':rg_funcionario', $this->rg);
			$stmt->bindValue(':telefone_funcionario', $this->telefone);
			$stmt->bindValue(':numeroAgencia_funcionario', $this->numeroAgencia_funcionario);
			$stmt->bindValue(':numeroContaBancaria_funcionario', $this->numeroContaBancaria_funcionario);
			$stmt->bindValue(':salario_funcionario', $this->salario_funcionario);
			$stmt->bindValue(':cargo_funcionario', $this->cargo_funcionario);

			$stmt->execute();
		}

		public function createLogin()
		{
			$query = 	"INSERT INTO login 
					  	(
					      	email, 
					      	senha,
					      	situacao,
							cargo
					    ) 
					    VALUES 
					    (
					    	:email, 
					    	:senha, 
					    	:situacao,
							:cargo
					    )";

			$conexao = Conexao::pegarConexao();

			$stmt = $conexao->prepare($query);

			$stmt->bindValue(':email', $this->email_funcionario);
			$stmt->bindValue(':senha', $this->senha_funcionario);
			$stmt->bindValue(':cargo', $this->cargo_funcionario);
			$stmt->bindValue(':situacao', 1);

			$stmt->execute();
			$ultimo = $conexao->lastInsertId();
			return $ultimo;
		}

		public function vinculaLoginAoFuncionario($idLogin)
	    {
	        $query = "UPDATE funcionario SET id_login = :idLogin WHERE cpf_funcionario = :cpf";
	        $conexao = Conexao::pegarConexao();
	        $stmt = $conexao->prepare($query);
	        $stmt->bindValue(':idLogin', $idLogin);
	        $stmt->bindValue(':cpf', $this->cpf);
	        
	        $stmt->execute();
	    }

		public static function read()
	    {
	        $query = "SELECT cpf_funcionario, nome_funcionario, cargo_funcionario FROM funcionario ORDER BY nome_funcionario";
	        $conexao = Conexao::pegarConexao();
	        $resultado = $conexao->query($query);
	        $lista = $resultado->fetchAll();
	        return $lista;
		}
		
		public static function listarProfessores()
	    {
	        $query = "SELECT nome_funcionario, cpf_funcionario FROM funcionario WHERE cargo_funcionario LIKE '%Ensino%' ORDER BY nome_funcionario";
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

	