<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once("DAO/banco-estado.php");

    verificaUsuario();
    carregaEstados2();

?>