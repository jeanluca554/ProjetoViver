<?php
	/**
	 * 
	 */
	class Pais 
	{
		private $id;
		private $nomePais;
		private $nomePaisPT;
		private $sigla;


		public function getIdPais()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function getNomePais()
		{
			return $this->nomePais;
		}

		public function setNomePais($nomePais)
		{
			$this->nomePais = $nomePais;
		}

		public function getNomePaisPT()
		{
			return $this->nomePaisPT;
		}

		public function setNomePaisPT($nomePaisPT)
		{
			$this->nomePaisPT = $nomePaisPT;
		}

		public function getSigla()
		{
			return $this->sigla;
		}

		public function setSigla($sigla)
		{
			$this->sigla = $sigla;
		}
	}