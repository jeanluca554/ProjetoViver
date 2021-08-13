<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once 'DAO/FuncionarioDAO.php';

    verificaUsuario();
?>
<?php
    try 
    {   
        $id_funcionario = $_GET['id'];
        $funcionarioDAO = new FuncionarioDAO($id_funcionario);        
    } 
    catch (Exception $e) 
    {
        Erro::trataErro($e);
    }
?>

<script type="text/javascript" src="node_modules/bootstrap/js/jquery-3.3.1.min.js"/></script>
<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"/></script>

<script type="text/javascript">
    $(document).ready(function()
    {
        $('#salario').mask("##.##0,00", {reverse: true});
        $('#cestaBasica').mask("##.##0,00", {reverse: true});
        $('#inss').mask("##.##0,00", {reverse: true});
        $('#irrf').mask("##.##0,00", {reverse: true});

        var salario = parseFloat($('#salario').val().replace(/[^0-9]/g, '').toString());
        var cestaBasica = parseFloat($('#cestaBasica').val().replace(/[^0-9]/g, '').toString());
        var inss = parseFloat($('#inss').val().replace(/[^0-9]/g, '').toString());
        var irrf = parseFloat($('#irrf').val().replace(/[^0-9]/g, '').toString());
        var total = salario + cestaBasica - inss - irrf;
        $('#total').val(total).mask("##.##0,00", {reverse: true});
        $(function()
        {
            //Executa a requisição quando o campo username perder o foco
            $('.calc').change(function()
            {
                var salario = parseFloat($('#salario').val().replace(/[^0-9]/g, '').toString());
                var cestaBasica = parseFloat($('#cestaBasica').val().replace(/[^0-9]/g, '').toString());
                var inss = parseFloat($('#inss').val().replace(/[^0-9]/g, '').toString());
                var irrf = parseFloat($('#irrf').val().replace(/[^0-9]/g, '').toString());
                var total = salario + cestaBasica - inss - irrf;
                $('#total').val(total).mask("##.##0,00", {reverse: true});
                
            });
        });
    })
</script>




</script>

<div class="row">
    <div class="col-md-12 text-center">
        <h2>Cálculo de Salário</h2>
    </div>
</div>

<div class="row justify-content-center">
    <form action="#" method="post">
        <div class="form-group row">
            <label for="nome" class="col-sm-4 col-form-label">Funcionário</label>
            <div class="col-sm-8 relative">
                <input type="hidden" name="id" value="<?php echo $funcionarioDAO->id ?>">
                <input type="text" name="nome" value="<?php echo $funcionarioDAO->nome ?>" class="form-control-plaintext" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="salario" class="col-sm-4 col-form-label">Salário</label>
            <div class="col-sm-8 input-group mb-3">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">R$</button>
                </span>
                <input type="text" class="form-control calc" name="salario" id="salario" value="<?php echo $funcionarioDAO->salario_funcionario ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="cestaBasica" class="col-sm-4 col-form-label">Cesta Básica</label>
            <div class="col-sm-8 input-group mb-3">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button">R$</button>
                </span>
                <input type="text" class="form-control calc" name="cestaBasica" id="cestaBasica" value="10000">
            </div>
        </div>
        <div class="form-group row">
            <label for="inss" class="col-sm-4 col-form-label">INSS</label>
            <div class="col-sm-8 input-group mb-3">
                <span class="input-group-btn">
                    <button class="btn btn-danger" type="button">R$</button>
                </span>
                <input type="text" class="form-control calc" name="inss" id="inss" placeholder="000,00" value="00000">
            </div>
        </div>
        <div class="form-group row ">
            <label for="irrf" class="col-sm-4 col-form-label">IRRF</label>
            <div class="col-sm-8 input-group mb-3">
                <span class="input-group-btn">
                    <button class="btn btn-danger" type="button">R$</button>
                </span>
                <input type="text" class="form-control calc" name="irrf" id="irrf" placeholder="000,00" value="00000">
            </div>
        </div>

        <div class="form-group row ">
            <div class="col-sm-4 col-form-label">
                <h2>Total</h2>
            </div>
            
            <div class="col-sm-8 input-group mb-3">
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button">R$</button>
                </span>
                <input type="text" class="form-control calc" name="total" id="total" placeholder="000,00">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <input type="submit" class="btn btn-success btn-block" value="Calcular">
            </div>
        </div>
    </form>
</div>
<?php require_once 'rodape.php' ?>

