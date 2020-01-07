<?php
	abstract class Pessoa
	{
		private $id;
		private $nome;
		private $rg;
		private $cpf;
		private $telefone;
		private $nascimento;

		

		public function getId()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function getNome()
		{
			return $this->nome;
		}

		public function setNome($nome)
		{
			$this->nome = $nome;
		}

		public function getRg()
		{
			return $this->rg;
		}

		public function setRg($rg)
		{
			$this->rg = $rg;
		}

		public function getCpf()
		{
			return $this->cpf;
		}

		public function setCpf($cpf)
		{
			$this->cpf = $cpf;
		}

		public function getTelefone()
		{
			return $this->telefone;
		}

		public function setTelefone($telefone)
		{
			$this->telefone = $telefone;
		}

		public function getNascimento()
		{
			return $this->nascimento;
		}

		public function setNascimento($nascimento)
		{
			$this->nascimento = $nascimento;
		}
	}