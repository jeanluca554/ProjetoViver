<?php
	class Turma
	{
        private $id;
		private $idAluno;
		private $idDisciplina;
		private $idTurma;
		private $prova1;
		private $prova2;
		private $trabalho;
		private $recuperacao;
		private $media;
		private $faltas;

		public function getId()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;
		}
        
        
	}