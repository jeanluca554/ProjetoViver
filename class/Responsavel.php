<?php
	require_once 'Endereco.php';

	class Responsavel extends Pessoa
	{
		private $endereco;
		private $telefoneAdicional;

		public function getEndereco()
		{
			return $this->endereco;
		}

		public function setEndereco($endereco)
		{
			$this->endereco = $endereco;
		}

		public function getTelefoneAdicional()
		{
			return $this->telefoneAdicional;
		}

		public function setTelefoneAdiciona($telefoneAdicional)
		{
			$this->telefoneAdicional = $telefoneAdicional;
		}
	}