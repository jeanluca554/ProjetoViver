<?php
	require_once 'Pais.php';

	class Estado
	{
		private $idEstado;
		private $nomeEstado;
		private $uf;
		private $pais;

		public function getIdEstado()
		{
			return $this->idEstado;
		}

		public function setIdEstado($idEstado)
		{
			$this->idEstado = $idEstado;
		}

		public function getNomeEstado()
		{
			return $this->nomeEstado;
		}

		public function setNomeEstado($nomeEstado)
		{
			$this->nomeEstado = $nomeEstado;
		}

		public function getUf()
		{
			return $this->uf;
		}

		public function setUf($uf)
		{
			$this->uf = $uf;
		}

		public function getPais()
		{
			return $this->pais;
		}

		public function setPais(Pais $pais)
		{
			$this->pais = $pais;
		}
	}