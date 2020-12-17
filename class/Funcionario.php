<?php
	class Funcionario extends Pessoa
	{
		private $email_funcionario;
		private $senha_funcionario;
		private $cargo_funcionario;
		private $numeroAgencia_funcionario;
		private $numeroContaBancaria_funcio;
		private $salario_funcionario;
		private $filhos;

		public function getEmail_funcionario()
		{
			return $this->$email_funcionario;
		}

		public function setEmail_funcionario($email)
		{
			$this->email_funcionario = $email;
		}

		public function getSenha_funcionario()
		{
			return $this->$senha_funcionario;
		}

		public function setSenha_funcionario($senha)
		{
			$this->senha_funcionario = $senha;
		}

		public function getCargo_funcionario()
		{
			return $this->cargo_funcionario;
		}

		public function setCargo_funcionario($cargo)
		{
			$this->cargo_funcionario = $cargo;
		}

		public function getNumeroContaBancaria()
		{
			return $this->numeroContaBancaria;
		}

		public function setNumeroContaBancaria($numeroContaBancaria)
		{
			$this->numeroContaBancaria = $numeroContaBancaria;
		}

		public function setFilhos(Aluno $filhos)
		{
			$this->filhos = $filhos;
		}

		public function getSalario_Funcionario()
		{
			return $this->salario_funcionario;
		}

		public function setSalario_Funcionario($salario)
		{
			$this->salario_funcionario = $salario;
		}
	}