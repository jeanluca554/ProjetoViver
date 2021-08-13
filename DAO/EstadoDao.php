<?php
	require_once("Conexao.php");
	require_once("config.php");
	
	/**
	 * 
	 */
	class EstadoDAO extends Estado
	{
		public static function carregaEstado()
		{
			$query = "SELECT * FROM estado ORDER BY nome ASC";
			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->execute();
			$fetchAll = $stmt->fetchAll();
		
			foreach ($fetchAll as $estados) 
			{
				echo '<option value="'.$estados['id'].'">'.$estados['nome'].'</option>';
			}
		}
	}
