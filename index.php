<?php
require_once("cabecalho.php");
require_once("logica-usuario.php");
?>

<?php
	verificaUsuario();
	if(usuarioEstaLogado()) 
	{
		$ensino = 'Ensino';
		$cargo = cargoUsuarioLogado();

		$cargoVerificado = strpos($cargo, $ensino);
		if($cargoVerificado === false) 
		{
			if($cargo == "Diretor")
			{?>
				<h2 class="card-title">Seja bem-vindo(a) Diretor(a)</h2>
				<div class=" col-md-10 mx-auto">
					<img class="card-img-bottom" src="img/Diretor.svg" alt="imagem Diretor">
				</div>
			<?php
			}
			else 
			{
				if ($cargo == "Coordenador")
				{?>
					<h2 class="card-title">Seja bem-vindo(a) Coordenador(a)</h2>
					<div class=" col-md-9 mx-auto">
						<img class="card-img-bottom" src="img/Coordenador.svg" alt="imagem Diretor">
					</div>
		<?php }
				else 
				{
					if ($cargo == "Secretário")
					{?>
						<h2 class="card-title">Seja bem-vindo(a) Secretário(a)</h2>
						<div class=" col-md-7 mx-auto">
							<img class="card-img-bottom" src="img/secretario.svg" alt="imagem Diretor">
						</div>
				<?php }
				}
			}
		}
		else 
		{?>
			<h2 class="card-title">Seja bem-vindo(a) Professor(a) </h2>
			<div class=" col-md-7 mx-auto">
				<img class="card-img-bottom" src="img/professor.svg" alt="imagem Diretor">
			</div>
			<?php
		}
	} ?>
	<script src="js/sweetalert.js"></script>


<?php include("rodape.php"); ?>