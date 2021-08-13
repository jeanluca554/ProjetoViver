<?php
	require_once("Conexao.php");
	require_once("config.php");
	
	
	/**
	 * 
	 */
	class PaisDao extends Pais
	{
		
		static function carregaPais()
		{
			$query = "SELECT * FROM pais ORDER BY nome_pt ASC";
			$conexao = Conexao::pegarConexao();
			$stmt = $conexao->prepare($query);
			$stmt->execute();
			$fetchAll = $stmt->fetchAll();
		
			foreach ($fetchAll as $paises) 
			{
				echo '<option value="'.$paises['id'].'">'.$paises['nome_pt'].'</option>';
			}
		}
		
	}

	
