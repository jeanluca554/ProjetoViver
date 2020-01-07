<?php
	class Aluno extends Pessoa
	{
		private $endereco;
		private $sexo;
		private $nacionalidade;
		private $estado;
		private $cidade;

		public function getEndereco()
		{
			return $this->endereco;
		}

		public function setEndereco($endereco)
		{
			$this->endereco = $endereco;
		}

		public function getSexo()
		{
			return $this->sexo;
		}

		public function setSexo($sexo)
		{
			$this->sexo = $sexo;
		}
		
		public function getNacionalidade()
		{
			return $this->nacionalidade;
		}

		public function setnacioNalidade($nacionalidade)
		{
			$this->nacionalidade = $nacionalidade;
		}

		public function getCidade()
		{
			return $this->cidade;
		}

		public function setCidade(Cidade $cidade)
		{
			$this->cidade = $cidade;
		}

		public function getEstado()
		{
			return $this->estado;
		}

		public function setEstado(Estado $estado)
		{
			$this->estado = $estado;
		}
	}