<?php
	class Matricula
	{
		private $id;
		private $anoLetivo;
		private $turma;
		private $dataMatricula;
		private $tipoEnsino;
		

		public function getId()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;
		}
        
        public function getAnoLetivo()
		{
			return $this->anoLetivo;
		}

		public function setAnoLetivo($anoLetivo)
		{
			$this->anoLetivo = $anoLetivo;
		}

        public function getAnoTurma()
		{
			return $this->anoTurma;
		}

		public function setAnoTurma($anoTurma)
		{
			$this->anoTurma = $anoTurma;
		}

        public function getDataMatricula()
		{
			return $this->dataMatricula;
		}

		public function setDataMatricula($dataMatricula)
		{
			$this->dataMatricula = $dataMatricula;
		}

		public function getTipoEnsino()
		{
			return $this->tipoEnsino;
		}

		public function setTipoEnsino($tipoEnsino)
		{
			$this->tipoEnsino = $tipoEnsino;
		}
	}