<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");

    verificaUsuario();
?>

<h2>Calcular Salário de Funcionário</h2>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover" id="tabelaDeFuncionarios">
            <thead class="thead-dark" align="center">
                <tr>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Calcular</th>                        
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaFuncionarios as $linha): ?>
                    <tr>
                        <td><?php echo $linha['nome_funcionario'] ?></td>
                        <td><?php echo $linha['cargo_funcionario'] ?></td>
                        <td align="center"><a href="CalculaSalarioFormulario.php?id=<?php echo $linha['id_funcionario'] ?>" class="btn btn-info">Calcular Salário</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div class=" mt-5 ml-auto">
    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalAlunoFormulario"><img src="img/laranja-adicionar-25.png"> Cadastrar Aluno</button>
</div>
            

<?php 
    include("Modal/ModalAlunoFormulario.php");
    include("rodape.php");
?>