<?php
    /*function carregaClasse($nomeDaClasse) {
    	require_once("class/".$nomeDaClasse.".php");
    }

    spl_autoload_register("carregaClasse");*/
    require_once("global.php");

    error_reporting(E_ALL ^ E_NOTICE);
    require_once("mostra-alerta.php");
    require_once("logica-usuario.php");
    $cargoUsuario = cargoUsuarioLogado();
    $verifica = substr($cargoUsuario, 0, 6);

    if ($verifica == "Ensino")
    {
        $cargoUsuario = 'Professor';
        //echo $cargoUsuario;
    }
    

    switch ($cargoUsuario) {
        case 'Diretor':
            $nivel = 1;
            break;

        case 'Coordenador':
            $nivel = 2;
            break;

        case 'Secretário':
            $nivel = 3;
            break;
        
        case 'Professor':
            $nivel = 4;
            break;
        
        default:
            # code...
            break;
    }

    
?>
<!doctype html>
<html>
    <head>
    	<meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- não é correto inserir esses links aqui porém, somente assim funcionou o jquery no modal de responsável  -->
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/bootstrap.css">
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/home.css">
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/jquery-ui-1.10.3.custom.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/animate.css">
        <script type="text/javascript" src="node_modules/bootstrap/js/jquery-3.3.1.min.js"></script>
        <script src="js/sweetalert.js"></script>

        <title>Home</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000F26">
            <div class="container">
                <a class="navbar-brand h1 mb-0" href="#">Viver e Aprender</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
                    <span class="navbar-toggler-icon"></span>        
                </button>
                <div class="collapse navbar-collapse" id="navbarSite">
                    <ul class="navbar-nav mr-auto">
                        <?php
                        if ($nivel != 4 && $nivel != 2){?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navDrop">Cadastrar</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="FuncionarioFormulario.php">Funcionário</a>
                                <a class="dropdown-item" href="AlunoFormulario.php">Aluno</a>
                            </div>
                        </li>

                        <?php
                        }   
                        ?>

                        <?php
                            if ($nivel != 2 && $nivel != 3 && $nivel != 1){
                        ?>
                        
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navDrop">Boletim</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="BoletimFormulario.php">Notas e Faltas</a>
                                </div>
                            </li>

                        <?php
                        }   
                        ?>

                        <?php
                            if ($nivel != 4 && $nivel != 2){
                        ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navDrop">Financeiro</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="FuncionariosCalculaSalario.php">Calcular Salário</a>
                                    <a class="dropdown-item" href="#">Contas a Receber</a>
                                </div>
                            </li>

                        <?php
                        }   
                        ?>

                        <?php
                        if ($nivel != 4 && $nivel != 3){?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navDrop">Pedagógico</a>
                                <div class="dropdown-menu">
                                    <a 
                                        class="dropdown-item" 
                                        href="DisciplinasFormulario.php"
                                    >
                                        Disciplinas
                                    </a>

                                    <a 
                                        class="dropdown-item" 
                                        href="MatrizCurricularFormulario.php"
                                    >
                                        Matrizes Curriculares
                                    </a>

                                    <a 
                                        class="dropdown-item" 
                                        href="TurmasFormulario.php"
                                    >
                                        Turmas
                                    </a>

                                    <a 
                                        class="dropdown-item" 
                                        href="ProfessorAssociar.php"
                                    >
                                        Associar Professor
                                    </a>
                                </div>
                            </li>

                        <?php
                        }   
                        ?>

                        <?php
                        if ($nivel != 4){?>
                       
                            <li class="nav-item">
                                <a class="nav-link" href="#">Relatórios</a>
                            </li>
                        <?php
                        }   
                        ?>
                        
                    </ul>
                    
                    <ul class="navbar-nav ml-auto">
                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle mr-4" href="#" data-toggle="dropdown" id="navDrop">Social</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="https://www.facebook.com/colegiovivereaprendercj">Facebook</a>
                                <a class="dropdown-item" href="https://instagram.com/cpvaanglo?igshid=7d2rco4bkm0i">Instagram</a>
                            </div>
                        </li> 
                    </ul>
                    
                    <form class="form-inline">
                        <input class="form-control mr-2" type="search" placeholder="Buscar...">
                        <button class="btn btn-dark" type="submit">Ok</button>
                    </form>

                     <ul class="navbar-nav ml-auto ml-md-3">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sair</a>
                        </li>  
                    </ul>

                </div>
            </div> 
        </nav>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="node_modules/jquery/dist/jquery.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
            <div class="container">
                <div class="principal">
                    <?php mostraAlerta("success"); ?>
                    <?php mostraAlerta("danger"); ?>
      

