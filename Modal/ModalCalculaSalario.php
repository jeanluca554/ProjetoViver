<?php
    try 
    {   
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
    })
</script>



<div class="modal fade" id="modalCalculaSalario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">              
                <h5 class="modal-title">Cálculo de Salário5</h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
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
                                <input type="text" class="form-control" name="salario" id="salario" value="<?php echo $funcionarioDAO->salario_funcionario ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cestaBasica" class="col-sm-4 col-form-label">Cesta Básica</label>
                            <div class="col-sm-8 input-group mb-3">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">R$</button>
                                </span>
                                <input type="text" class="form-control" name="cestaBasica" id="cestaBasica" value="10000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inss" class="col-sm-4 col-form-label">INSS</label>
                            <div class="col-sm-8 input-group mb-3">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button">R$</button>
                                </span>
                                <input type="text" class="form-control" name="inss" id="inss" placeholder="000,00">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="irrf" class="col-sm-4 col-form-label">IRRF</label>
                            <div class="col-sm-8 input-group mb-3">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button">R$</button>
                                </span>
                                <input type="text" class="form-control" name="irrf" id="irrf" placeholder="000,00">
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
                                <input type="text" class="form-control" name="irrf" id="irrf" placeholder="000,00">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-success btn-block" value="Calcular">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>