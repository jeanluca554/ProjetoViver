<?php 
    
    require_once("DAO/banco-cidades.php");
    require_once("DAO/EstadoDao.php");

    verificaUsuario();

?>

<div class="modal fade" id="ResponsaveisModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">              
                <h5 class="modal-title">Cadastrar Responsável</h5>

                <button type="button" class="close fecharModalCadastroResponsavel" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="dadosPessoaisResponsavel-tab" data-toggle="tab" href="#abaDadosPessoaisResponsavel" role="tab" aria-controls="DadosPessoais" aria-selected="true">Dados Pessoais</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link disabled" id="enderecoResponsavel-tab" data-toggle="tab" href="#" role="tab" aria-controls="Endereco" aria-selected="false">Endereço</a>
                    </li>
                    
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="abaDadosPessoaisResponsavel" role="tabpanel" aria-labelledby="dadosPessoaisResponsavel-tab">

                        <div class="form-row">
                            
                            <div class="form-group col-md-9">
                                <label for="nome">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" id="nomeResponsavel" placeholder="Nome Completo" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="cpf">CPF</label>
                                <input type="text" name="cpf" class="form-control" id="cpf" placeholder="000.000.000-00" required>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="cpf">RG</label>
                                <input type="text" name="rg" class="form-control" id="rgResponsavel" placeholder="RG" maxlength="13">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="telefone">Telefone Pessoal</label>
                                <input type="text" name="telefone" class="form-control telefone" id="telefone1" placeholder="(00)00000-0000">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="telefone">Telefone Adicional</label>
                                <input type="text" name="telefone" class="form-control telefone" id="telefone2" placeholder="(00)00000-0000">
                            </div>

                            <button type="submit" class="btn btn-success mr-auto mt-3" id="botao-salvar-dados-pessoais">Salvar</button>
                            <button type="reset" class="btn btn-danger mt-3 fecharModalCadastroResponsavel" data-dismiss="modal">Fechar</button>
                        </div>                             
                        
                    </div>

                    <div class="tab-pane fade divEndereco" id="abaEnderecoResponsavel" role="tabpanel" aria-labelledby="profile-tab">                       
                        <div class="form-row mt-4">                            
                            <div class="form-group col-md-2">
                                <label for="cep">CEP</label>
                                <input type="text" name="cep" class="form-control cep" id="cep" placeholder="00000-000" required>
                            </div>

                            <div class="form-group col-md-8">
                                <label for="logradouro">Logradouro</label>
                                <input type="text" name="logradouro" class="form-control" id="logradouro" placeholder="Rua / Avenida">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="numeroCasa">Número</label>
                                <input type="number" name="numeroCasa" class="form-control" id="numeroCasa" placeholder="Nº">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="complemento">Complemento</label>
                                <input type="text" name="complemento" class="form-control" id="complemento" placeholder="Complemento">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="bairro">Bairro</label>
                                <input type="text" name="bairro" class="form-control" id="bairro" placeholder="Bairro">
                            </div>
                        </div>

                        <div class="form-row">                            
                            <div class="form-group col-md-6" id="divEstadoResidencia">
                                <label for="estadoResidencia">Estado</label>
                                <select name="estadoResidencia" class="form-control" id="selectEstadoResidencia">
                                    <option value="">Selecione o Estado</option>
                                    <?php EstadoDAO::carregaEstado();?>
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="divCidadeResidencia">
                                <label for="cidadeResidencia">Cidade</label>
                                <select name="cidadeResidencia" class="form-control" id="selectCidadeResidencia">
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success mr-auto mt-3" id="botao-salvar-endereco-responsavel">Salvar</button>

                            <button type="reset" class="btn btn-danger mt-3 fecharModalCadastroResponsavel" data-dismiss="modal" id="closeButton">Fechar</button>
                        </div> 

                    </div>
                    
                </div>

            </div>

        </div>
    </div>
</div>

<script src="js/pegaCidades.js"></script>
<script src="js/formataCamposResponsavel.js"></script>
<script src="js/salvarResponsavel.js"></script>
<script src="js/limpaModalCadastroResponsavel.js"></script>

<!--<script>
    $('#closeButton').on('click', mudarTab);
    function mudarTab(){
        $('.nav-tabs li a[href="#abaDadosPessoaisResponsavel"]').tab('show');
    }

</script>-->