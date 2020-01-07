<?php
	require_once 'Endereco.php';

	class Responsavel extends Pessoa
	{
		private $endereco;

		public function getEndereco()
		{
			return $this->endereco;
		}

		public function setEndereco($endereco)
		{
			$this->endereco = $endereco;
		}
	}