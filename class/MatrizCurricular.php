<?php
	class MatrizCurricular
	{
        private $id;
		private $nome;
		private $tipoEnsino;
		private $disciplinas;

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
		
		public function getTipoEnsino()
		{
			return $this->tipoEnsino;
		}

		public function setTipoEnsino($tipoEnsino)
		{
			$this->tipoEnsino = $tipoEnsino;
        }
               
         public function getDisciplinas()
		{
			return $this->disciplinas;
		}

		public function setDisciplinas(Disciplina $disciplinas)
		{
			$this->disciplinas = $disciplinas;
        }
	}