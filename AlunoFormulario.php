<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");

    verificaUsuario();
?>



<div class=" mt-5 ml-auto">
    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalAlunoFormulario"><img src="img/laranja-adicionar-25.png"> Cadastrar Aluno</button>
</div>
            

<?php 
    include("Modal/ModalAlunoFormulario.php");
    include("rodape.php");
?>