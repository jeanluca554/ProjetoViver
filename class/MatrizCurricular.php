<?php
	class MatrizCurricular
	{
        private $id;
        private $nome;
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
               
         public function getDisciplinas()
		{
			return $this->disciplinas;
		}

		public function setDisciplinas(Disciplina $disciplinas)
		{
			$this->disciplinas = $disciplinas;
        }
	}