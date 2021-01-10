<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once('DAO/FuncionarioDAO.php');

    verificaUsuario();
?>

<?php
    try 
    {
        $listaFuncionarios = FuncionarioDAO::read();
    } 
    catch(Exception $e) 
    {
        Erro::trataErro($e);
    }
?>

<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>


<h2>Calcular Salário de Funcionário</h2>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover tabelaPTBR" id="tabelaDeFuncionarios">
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
                        <td align="center"><a 
                            href="CalculaSalarioFormulario.php?id=<?php echo $linha['id_funcionario'] ?>" class="btn btn-info">Calcular Salário</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>

<?php 
    include("rodape.php");
?>
