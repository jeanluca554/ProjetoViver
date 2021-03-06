<?php
  require_once("mostra-alerta.php");
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
        <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/compiler/style.css">
    </head>
    <body>
        <div class="box">
          <div class="col-12 anglo-img">
            <img src="img/logo.png">
          </div>
          <h2>Tente novamente </h2>
          <div class="mensagem">
            <div class="principal">
                
                <?php mostraAlerta("danger"); ?>
            </div>
          </div>
          <form action="login.php" method="post">
            <div class="inputBox">
              <input type="text" name="email" required="">
              <label>Entre com o e-mail</label>
            </div>
            <div class="inputBox">
              <input type="password" name="senha" required="">
              <label>Entre com a senha</label>
            </div>
            
            <div class="botao">
            <button type="submit" class="btn"><i class="fas fa-sign-in-alt"></i>Login</button>
			</div>
			<div class="col-12 forgot">
				<a href="#">Para o primeiro acesso clique aqui.</a>
			</div>
            <div class="col-12 forgot">
                <a href="#">Esqueceu a Senha?</a>
            </div>

          </form>
        </div>

    </body>
</html>