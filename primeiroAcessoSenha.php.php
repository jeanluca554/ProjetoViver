<?php
  require_once("mostra-alerta.php");
?>
<html lang="pt-br">
	<head>
		<title>Login</title>
			
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/releases/v5.10.2/js/all.js"></script>

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="node_modules/bootstrap/compiler/stylePrimeiroAcessoEmail.css">
		<link rel="stylesheet" href="node_modules/bootstrap/compiler/jquery-ui-1.10.3.custom.min.css">
		<link rel="stylesheet" href="node_modules/bootstrap/compiler/animate.css">
		<link rel="stylesheet" href="node_modules/bootstrap/compiler/bootstrap.css">
			
	</head>
	<body>
		<div class="box">
			<div class="col-12 anglo-img">
				<img src="img/logo.png">
			</div>
			<h2>Para finalizar o Cadastro digite a senha</h2>
			<div class="mensagem">
				<div class="principal">
				<?php mostraAlerta("danger"); ?>
			</div>
			</div>
			<!-- <form> -->
				<div class="formCpf">
					<div class="inputBox">
						<input 
							type="text" 
							required=""
							id="primeiraSenha"
						>
						<label>Digite a senha</label>
					</div>

					<div class="inputBox">
						<input 
							type="text" 
							required=""
							id="segundaSenha"
						>
						<label>Confirme a senha</label>
					</div>
					
					<div class="botao">
						<button 
							class="btn prosseguir"
							id="prosseguirSenha"
						>
							<i class="fas fa-sign-in-alt"></i>Prosseguir
						</button>
					</div>

				<div class="col-12 forgot">
						<a href="index.html">Fazer Login</a>
					</div>
					<div class="col-12 forgot">
						<a href="#">Esqueceu a Senha?</a>
					</div>
				</div>

			<!-- </form> -->

		</div>

		<script src="js/jq.js"></script>
		<!-- <script src="js/teste.js"></script> -->
		<script src="js/verificaPrimeiroAcesso.js"></script>
		<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
		<script src="js/formataCpf.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	</body>
</html>