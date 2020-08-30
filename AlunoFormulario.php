<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once('DAO/AlunoDAO.php');
    require_once("DAO/EstadoDao.php");
    require_once("DAO/PaisDAO.php");
    require_once("DAO/ResponsavelDAO.php");

    verificaUsuario();
?>

<?php
    try 
    {
        $listaAlunos = AlunoDAO::listarAlunos();
    } 
    catch(Exception $e) 
    {
        Erro::trataErro($e);
    }
?>

<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>
<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>

<div class="form-row align-items-end">
    <h1>Alunos Matriculados</h1>
    <div class="ml-auto">
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalAlunoFormulario"><img src="img/laranja-adicionar-25.png"> Cadastrar Aluno</button>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <table class="table table-hover table-bordered" id="tabelaDeFuncionarios">
            <thead class="thead-dark" align="center">
                <tr>
                    <th>Nome</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaAlunos as $linha): ?>
                    <tr>
                        <td><?php echo $linha['nome_aluno'] ?></td>
                        <td align="center">
                            <button 
                                type="button" 
                                class="btn btn-outline-info" 
                                data-toggle="modal" 
                                data-target="#ModalAlunoFormulario" 
                                data-nome="<?php echo $linha['nome_aluno'] ?>"
                                data-id="<?php echo $linha['id_aluno'] ?>"
                                data-endereco="<?php echo $linha['id_endereco_residencia'] ?>"
                            >
                                <img src="img/editar.png">
                            </button>
                        </td>
                        <td align="center">
                            <button 
                                type="button" 
                                class="btn btn-outline-danger" 
                                data-toggle="modal" 
                                data-target="#"
                            >
                                <img src="img/menos-25.png">
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Aluno Formulário -->
<div class="modal fade" id="ModalAlunoFormulario" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">              
                <h5 class="modal-title">Cadastrar Aluno</h5>

                <button 
                    type="button" 
                    class="close fecharModalCadastroAluno" 
                    id="fecharMoldalAluno" 
                    data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item pessoaisAluno">
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
                    <div 
                        class="tab-pane fade show active" 
                        id="abaDadosPessoaisAluno" 
                        role="tabpanel" 
                        aria-labelledby="cadastroAlunos-tab"
                    >
                        <div class="form-group mt-5">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" id="nomeAluno" placeholder="Nome Completo" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 nascimentoAluno">
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
                                    <option value="0">Selecione o Estado</option>    
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

                        <div class="form-row mt-4 footer-botoes">
                            <div class="form-row col-md-12 footer-dados-aluno">       
                                <button type="submit" class="btn btn-success btn-lg" id="botao-salvar-aluno">Salvar</button>

                                <button type="submit" class="btn btn-success btn-lg" id="botao-alterar-aluno">Alterar</button>
                                
                                <div class="ml-auto cancelar-aluno">
                                    <button type="reset" class="btn btn-danger btn-lg fecharModalCadastroAluno" data-dismiss="modal">Cancelar</button>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade divEndereco" id="abaEnderecoAluno" role="tabpanel" aria-labelledby="profile-tab">                       
                        <div class="form-row mt-4">                            
                            <div class="form-group col-md-2">
                                <label for="cep">CEP</label>
                                <input 
                                    type="text" 
                                    name="cepAluno" 
                                    class="form-control cep" 
                                    id="cepAluno" 
                                    placeholder="00000-000" 
                                    required
                                >
                            </div>

                            <div class="form-group col-md-8">
                                <label for="logradouro">Logradouro</label>
                                <input 
                                    type="text" 
                                    name="logradouroAluno" 
                                    class="form-control" 
                                    id="logradouroAluno" 
                                    placeholder="Rua / Avenida"
                                >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="numeroCasa">Número</label>
                                <input 
                                    type="number" 
                                    name="numeroCasaAluno" 
                                    class="form-control" 
                                    id="numeroCasaAluno" 
                                    placeholder="Nº"
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="complemento">Complemento</label>
                                <input 
                                    type="text" 
                                    name="complementoAluno" 
                                    class="form-control" 
                                    id="complementoAluno" 
                                    placeholder="Complemento"
                                >
                            </div>

                            <div class="form-group col-md-6">
                                <label for="bairro">Bairro</label>
                                <input 
                                    type="text" 
                                    name="bairroAluno" 
                                    class="form-control" 
                                    id="bairroAluno" 
                                    placeholder="Bairro"
                                >
                            </div>
                        </div>

                        <div class="form-row">                            
                            <div class="form-group col-md-6" id="divEstadoResidencia">
                                <label for="estadoResidenciaAluno">Estado</label>
                                <select 
                                    name="estadoResidenciaAluno" 
                                    class="form-control" 
                                    id="selectEstadoResidenciaAluno"
                                >
                                    <option value="">Selecione o Estado</option>
                                    <?php EstadoDAO::carregaEstado();?>
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="divCidadeResidencia">
                                <label for="cidadeResidenciaAluno">Cidade</label>
                                <select 
                                    name="cidadeResidenciaAluno" 
                                    class="form-control" 
                                    id="selectCidadeResidenciaAluno"
                                >
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success mr-auto mt-3" id="botao-salvar-endereco-aluno">Salvar</button>

                            <button type="submit" class="btn btn-success mr-auto mt-3" id="botao-alterar-endereco-aluno">Alterar</button>

                            <button type="reset" class="btn btn-danger mt-3 fecharModalCadastroAluno" data-dismiss="modal" id="closeButton">Fechar</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim do modal Aluno Formulário -->




<script src="js/salvarAluno.js"></script>
<script src="js/alterarAluno.js"></script>
<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script> 
<script src="js/DatepikerComum.js"></script>
<script src="js/nacionalidadeAluno.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/pegaResponsaveis.js"></script>
<script src="js/pegaCidades.js"></script>
<script src="js/formataCamposAluno.js"></script>
<script type="text/javascript" src="js/modal.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>
<script src="js/limpaModalCadastroAluno.js"></script>

<?php 
    //include("Modal/ModalAlunoFormulario.php");
    // include("Modal/ModalTeste.php");
    include("rodape.php");
?>