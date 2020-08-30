<?php

    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once("DAO/EstadoDao.php");
    require_once("DAO/PaisDAO.php");
    require_once("DAO/ResponsavelDAO.php");

    verificaUsuario();
?>

<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>

<div class="modal fade" id="ModalAlunoFormulario" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">              
                <h5 class="modal-title">Cadastrar Aluno</h5>

                <button type="button" class="close fecharModalCadastroAluno" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="dadosPessoaisAluno-tab" data-toggle="tab" href="#abaDadosPessoaisAluno" role="tab" aria-controls="hom" aria-selected="true">Dados Pessoais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="enderecoAluno-tab" data-toggle="tab" href="#abaEnderecoAluno" role="tab" aria-controls="enderecoAluno" aria-selected="false">Endereço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="responsaveisAluno-tab" data-toggle="tab" href="#abaResponsaveisAluno" role="tab" aria-controls="profil" aria-selected="false">Responsáveis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contac" aria-selected="false">Matrícula</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="abaDadosPessoaisAluno" role="tabpanel" aria-labelledby="cadastroAlunos-tab">
                        
                        <div class="form-group mt-5">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" id="nomeAluno" placeholder="Nome Completo" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="DataNascimento">Data de Nascimento</label>
                                <div class="input-group date">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" disabled><img src="img/laranja-hoje-25.png"></button>
                                    </span>
                                    <input type="text" class="form-control" id="dataNascimento" name="dataNascimento">
                                </div>
                            </div>

                                <div class="form-group col-md-6">
                                    <label for="sexo">Sexo</label>
                                    <select name="sexo" class="form-control" id="sexo">
                                        <option>
                                            Masculino
                                        </option>
                                        
                                        <option>
                                            Feminino
                                        </option>                                
                                    </select>        
                                </div>
                            

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nacionalidade">Nacionalidade</label>
                                <select name="nacionalidade" class="form-control" id="nacionalidade">    <option value="0">Selecione...</option>
                                    <option value="Brasileiro">Brasileiro</option>
                                    <option value="Estrangeiro">Estrangeiro</option>                
                                </select>        
                            </div>

                            <div class="form-group col-md-3" id="divEstadoNascimento">
                                <label for="estadoNascimento">Estado</label>
                                <select class="form-control" id="selectEstadoNascimento" name="estado">
                                    <?php EstadoDAO::carregaEstado();?>
                                </select>
                            </div>

                            <div class="form-group col-md-5" id="divCidadeNascimento">
                                <label for="cidadeNascimento">Cidade</label>
                                <select class="form-control" id="selectCidadeNascimento" name="cidade">
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="divPaisOrigem">
                                <label for="paisOrigem">País de Origem</label>
                                <select class="form-control" id="paisOrigem" name="pais">
                                    <?php PaisDAO::carregaPais();?>
                                </select>
                            </div>
                        </div> 
                        
                        <div class="form-row mt-4">
                            <div class="form-row col-md-12 botao-salvar-aluno">       
                                <button type="submit" class="btn btn-success btn-lg" id="botao-salvar-aluno">Salvar</button>
                                
                                <div class="ml-auto">
                                    <button type="reset" class="btn btn-danger btn-lg fecharModalCadastroAlunos" data-dismiss="modal">Cancelar</button>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade divEndereco" id="abaEnderecoAluno" role="tabpanel" aria-labelledby="profile-tab">                       
                        <div class="form-row mt-4">                            
                            <div class="form-group col-md-2">
                                <label for="cep">CEP</label>
                                <input type="text" name="cepAluno" class="form-control cep" id="cepAluno" placeholder="00000-000" required>
                            </div>

                            <div class="form-group col-md-8">
                                <label for="logradouro">Logradouro</label>
                                <input type="text" name="logradouroAluno" class="form-control" id="logradouroAluno" placeholder="Rua / Avenida">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="numeroCasa">Número</label>
                                <input type="number" name="numeroCasaAluno" class="form-control" id="numeroCasaAluno" placeholder="Nº">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="complemento">Complemento</label>
                                <input type="text" name="complementoAluno" class="form-control" id="complementoAluno" placeholder="Complemento">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="bairro">Bairro</label>
                                <input type="text" name="bairroAluno" class="form-control" id="bairroAluno" placeholder="Bairro">
                            </div>
                        </div>

                        <div class="form-row">                            
                            <div class="form-group col-md-6" id="divEstadoResidencia">
                                <label for="estadoResidenciaAluno">Estado</label>
                                <select name="estadoResidenciaAluno" class="form-control" id="selectEstadoResidenciaAluno">
                                    <option value="">Selecione o Estado</option>
                                    <?php EstadoDAO::carregaEstado();?>
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="divCidadeResidencia">
                                <label for="cidadeResidenciaAluno">Cidade</label>
                                <select name="cidadeResidenciaAluno" class="form-control" id="selectCidadeResidenciaAluno">
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success mr-auto mt-3" id="botao-salvar-endereco-aluno">Salvar</button>

                            <button type="reset" class="btn btn-danger mt-3 fecharModalCadastroResponsavel" data-dismiss="modal" id="closeButton">Fechar</button>
                        </div> 

                    </div>

                    <div class="tab-pane fade" id="abaResponsaveisAluno" role="tabpanel" aria-labelledby="profile-tab">
                       
                        <div class="form-row align-items-end mt-5">
                            <div class="col-md-4 my-1">
                                <label for="selecionarResponsavel">Selecione o Responsável</label>
                                <input type="text" name="selecionaResponsavel" class="form-control" id="selecionaResponsavel" placeholder="Digite o nome do responsável">

                            </div>
                            <div class="col-auto my-1">
                                <button type="button" class="btn btn-outline-primary" id="btnAdicionaResponsavel" disabled>Adicionar</button>
                            </div>

                            <div class="ml-auto">
                                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ResponsaveisModal" id="btnPesquisaResponsaveis"><img src="img/laranja-adicionar-25.png"> Cadastrar Responsável</button>
                            </div>
                        </div>

                        <div class="form-row align-items-end">                           
                            <div class="col-md-4">                                
                                <div class="list-group table table-borderless" id="show-list">             
                                    <!--Aqui entra a janela com todos os responsáveis -->
                                </div>                               
                            </div>                        
                        </div>

                        <div class="table-responsive-xl mt-5 table-striped table-bordered">
                            <table class="table table-hover table-responsive-sm tabelaParentesco" id="tabelaParentesco">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th>Responsável</th>
                                        <th width="150">CPF</th>
                                        <th width="170">Parentesco</th>
                                        
                                        <th width="50">Editar</th>
                                        <th width="50">Remover</th>              
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        

                        <div class="form-row mt-5">
                            <div class="form-group col-md-4">
                                <label for="responsavelFinanceiro">Responsável Financeiro</label>
                                <select name="selectResponsavelFinanceiro" class="form-control" id="selectResponsavelFinanceiro">
                                    <option value='Selecione'>Selecione o responsável</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="responsavelDidatico">Responsável Didático</label>
                                <select name="responsavelDidatico" class="form-control" id="selectResponsavelDidatico">
                                <option value='Selecione'>Selecione o responsável</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row col-md-12 ml-auto">
                            <div class="form-row mt-5">
                                <div class="form-row col-md-12">       
                                    <button type="submit" class="btn btn-success btn-lg" id="botao-salvar-resonsavel-do-aluno">Salvar</button>

                                    <button type="submit" class="btn btn-success btn-lg" id="botao-alterar-resonsavel-do-aluno">Alterar</button>
                                    
                                    <div class="ml-auto mt-auto">
                                        <button type="reset" class="btn btn-danger btn-lg fecharModalCadastroAlunos" data-dismiss="modal">Cancelar</button>
                                    </div> 
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        
                        <form id="form">
                            <h3>Plugin Autocomplete do jQuery UI trabalhando em Conjunto com a Interface Ajax do jQuery</h3>
                            <fieldset>
                                <input type="text" id="campo-busca" placeholder="Buscar" />
                                <input type="submit" id="submit-busca" value="Buscar" />
                            </fieldset>
                        </form>

                    </div>
                        
                </div> 
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script> 
<script src="js/DatepikerComum.js"></script>
<script src="js/nacionalidadeAluno.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/pegaResponsaveis.js"></script>
<script src="js/formataCamposAluno.js"></script>
<script src="js/salvarAluno.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>


<?php 
    include("Modal/ModalCadastrarResponsaveis.php");
    include("rodape.php");
?>
