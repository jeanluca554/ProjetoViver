<?php
	class Turma
	{
        private $id;
		private $nome;
		private $sigla;
		private $ano;
		private $turno;
		private $capacidade;
		private $tipoEnsino;
		private $numTipoEnsino;
		private $alunosAtivos;

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
		
		public function getSigla()
		{
			return $this->sigla;
		}

		public function setSigla($sigla)
		{
			$this->sigla = $sigla;
		}

		public function getAno()
		{
			return $this->ano;
		}

		public function setAno($ano)
		{
			$this->ano = $ano;
		}

		public function getTurno()
		{
			return $this->turno;
		}

		public function setTurno($turno)
		{
			$this->turno = $turno;
		}

		public function getCapacidade()
		{
			return $this->capacidade;
		}

		public function setCapacidade($capacidade)
		{
			$this->capacidade = $capacidade;
		}

		public function getTipoEnsino()
		{
			return $this->tipoEnsino;
		}

		public function setTipoEnsino($tipoEnsino)
		{
			$this->tipoEnsino = $tipoEnsino;
		}

		public function getNumTipoEnsino()
		{
			return $this->numTipoEnsino;
		}

		public function setNumTipoEnsino($numTipoEnsino)
		{
			$this->numTipoEnsino = $numTipoEnsino;
		}

		public function getAlunosAtivos()
		{
			return $this->alunosAtivos;
		}

		public function setAlunosAtivos($alunosAtivos)
		{
			$this->alunosAtivos = $alunosAtivos;
		}
	}