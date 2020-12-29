<?php
require_once("cabecalho.php");
require_once("logica-usuario.php");
?>

<h1>Bem vindo!</h1>

<?php
verificaUsuario();
if(usuarioEstaLogado()) 
{
	?>
		<p class="text-success">Você está logado como <?= cargoUsuarioLogado() ?>. <a href="logout.php">Deslogar</a></p>
	<?php
} 
?>
	<script src="js/sweetalert.js"></script>


<?php include("rodape.php"); ?>