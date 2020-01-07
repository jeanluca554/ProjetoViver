<?php
	require_once("Conexao.php");
	require_once("config.php");

	
	$funcao = $_POST['funcao'];
	
	if($funcao == 1)
	{
		pegaResponsaveis();
	}
	else
	{
		if ($funcao == 3)
		{
			insereResponsavelPeloRG();
		}
	}


	function insereResponsavelPeloRG()		
	{
		$cpf = $_POST['cpf'];



        $query = "INSERT INTO responsavel_pelo_aluno
                  FROM responsavel
                  WHERE cpf_responsavel = ";
        $conexao = Conexao::pegarConexao();
        $resultado = $conexao->query($query);
        $lista = $resultado->fetchAll();
        return $lista;






		$query = "SELECT * FROM cidade WHERE uf='".$id."'";
		//$query = "SELECT * FROM cidades WHERE uf=4";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
	
		foreach ($fetchAll as $cidades) 
		{
			echo '<option>'.$cidades['nome'].'</option>';			
		}
	}

	function pegaResponsaveis()
	{
		$responsavelDigitado = $_POST['responsavel'];
		//$query = "SELECT * FROM funcionario WHERE nome_funcionario like '%".$responsavelDigitado."%'";
		$query = "SELECT DISTINCT nome_responsavel, cpf_responsavel
		FROM responsavel WHERE nome_responsavel like '%".$responsavelDigitado."%'
		UNION ALL
		SELECT DISTINCT nome_funcionario, cpf_funcionario
		FROM funcionario 
		WHERE nome_funcionario like '%".$responsavelDigitado."%'";
		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();
		$espaco = "&nbsp--&nbsp";
	
		foreach ($fetchAll as $responsaveis) 
		{
			echo "<a href='#' class='list-group-item list-group-item-action border-1'>".$responsaveis['nome_responsavel'].$espaco.$responsaveis['cpf_responsavel']."</a>";
			

			/*echo "<tr class='border-1'>
					<td align='left'>".$responsaveis['nome_funcionario']."</td>
					<td align='right'>".$responsaveis['cpf_funcionario']."</td>
				  </tr>";*/

		}
	}