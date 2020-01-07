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

<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>

    <div class="card text-center w-50 mx-auto">
        <div class="card-header">
            <h2 >Cálculo de Salário</h2>
        </div>

        <div class="card-body">
        
            <div class="row justify-content-center">
                <form action="#" method="post">

                    <input type="hidden" name="id" value="<?php echo $funcionarioDAO
                    ->id ?>">

                    <div class="form-group row">
                        <label for="nome" class="col-sm-4 col-form-label">Nome</label>
                        <div class="col-sm-8 input-group mb-3">
                            
                            <input type="text" class="form-control calc" name="nome" id="nome" value="<?php echo $funcionarioDAO->nome ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mes" class="col-sm-4 col-form-label">Mês</label>
                        <div class="col-sm-8 input-group mb-3">
                            <div class="input-group date">
                                <span class="input-group-btn">
                                    <button class="btn btn-info" type="button" disabled><img src="img/calendarioPequeno.png"></button>
                                </span>
                                <input type="text" class="form-control calc" id="mes" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="salario" class="col-sm-4 col-form-label">Salário</label>
                        <div class="col-sm-8 input-group mb-3">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button" disabled>R$</button>
                            </span>
                            <input type="text" class="form-control calc" name="salario" id="salario" value="<?php echo $funcionarioDAO->salario_funcionario ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cestaBasica" class="col-sm-4 col-form-label">Cesta Básica</label>
                        <div class="col-sm-8 input-group mb-3">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" disabled>R$</button>
                            </span>
                            <input type="text" class="form-control calc" name="cestaBasica" id="cestaBasica" value="10000">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inss" class="col-sm-4 col-form-label">INSS</label>
                        <div class="col-sm-8 input-group mb-3">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" disabled>R$</button>
                            </span>
                            <input type="text" class="form-control calc" name="inss" id="inss" placeholder="000,00" value="">
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label for="irrf" class="col-sm-4 col-form-label">IRRF</label>
                        <div class="col-sm-8 input-group mb-3">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" disabled>R$</button>
                            </span>
                            <input type="text" class="form-control calc" name="irrf" id="irrf" placeholder="000,00" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="button" id="btn-calcular" class="btn btn-success btn-block" value="Calcular">
                        </div>
                    </div>

                    <div class="form-group row ">
                        <div class="col-sm-4 col-form-label">
                            <h2>Total</h2>
                        </div>
                        
                        <div class="col-sm-8 input-group mb-3">
                            <span class="input-group-btn">
                                <button id="botao-calcular" class="btn btn-success" type="button">R$</button>
                            </span>
                            <input type="text" class="form-control calc" name="total" id="total" placeholder="000,00">
                        </div>
                    </div>   
                </form>
            </div>
        </div>
    </div>

<script type="text/javascript" src="node_modules/bootstrap/js/jquery-3.3.1.min.js"/></script>
<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"/></script>
<script src="datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="datepicker/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>
<script src="js/DatepikerMes.js"></script>
<script src="js/formataCamposCalculadora.js"></script>
<script src="js/calculaSalario.js"></script>  
    
</body>
</html>




<?php require_once 'rodape.php' ?>

