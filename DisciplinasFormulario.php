<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once("DAO/DisciplinaDAO.php");

    verificaUsuario();

    try 
    {
        $listaDisciplinas = DisciplinaDAO::listarDisciplinas();
    } 
    catch(Exception $e) 
    {
        Erro::trataErro($e);
    }
?>


<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>
<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>

<div class="form-row align-items-center">
    <h1>Disciplinas Cadastradas</h1>
    <div class="ml-auto">
        <button 
            type="button" 
            class="btn btn-outline-success" 
            data-toggle="modal" 
            data-target="#ModalDisciplinasFormulario"
            id="cadastrar-disciplina"
        >
            <img src="img/laranja-adicionar-25.png">Cadastrar Disciplina
        </button>
    </div>
</div>

<!-- Tabela Disciplinas -->
<div class="row mt-4 justify-content-center">
    <div class="col-md-8">
        <table class="table table-hover table-bordered table-striped tabelaPTBR" id="tabelaDisciplinas">
            <thead class="thead-dark" align="center">
                <tr>
                    <th>Nome</th>
                    <th width="90">Editar</th>
                    <th width="90">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaDisciplinas as $linha): ?>
                    <tr>
                        <td><?php echo $linha['nome'] ?></td>
                        <td align="center">
                            <button 
                                type="button"
                                id="bnt-editar-disciplina"
                                class="btn btn-outline-info btn-editar-disciplina" 
                                data-toggle="modal" 
                                data-target="#ModalDisciplinasFormulario" 
                                data-nomeDisciplina="<?php echo $linha['nome'] ?>"
                                data-idDisciplina="<?php echo $linha['id'] ?>"
                                onclick="setAlterarDisciplinas('<?php echo $linha['nome'] ?>', <?php echo $linha['id'] ?>)"
                            >
                                <img src="img/editar.png">
                            </button>
                        </td>
                        <td align="center">
                            <button 
                                type="button"
                                id="btnExcluir<?php echo $linha['id'] ?>"
                                class="btn btn-outline-danger btn-excluir-disciplina" 
                                onclick="excluirDisciplina(<?php echo $linha['id'] ?>)"
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

<!-- Modal Disciplina Formulário -->
<div class="modal fade" id="ModalDisciplinasFormulario" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <div id="tituloCadastrarDisciplina">              
                    <h5 class="modal-title">Cadastrar Disciplina</h5>
                </div>
            
                <button 
                    type="button" 
                    class="close fecharModalCadastroDisciplina" 
                    id="fecharMoldalDisciplina" 
                    data-dismiss="modal"
                    
                >
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <div class="form-group mt-4">
                    <label for="nome">Nome da Disciplina</label>
                    <input type="text" name="nome" class="form-control" id="nomeDisciplina" placeholder="Nome da Disciplina" required>
                    <input hidden id="idDisciplina" data-id="">
                </div>

                <div class="form-row mt-4 footer-botoes">
                    <div class="form-row col-md-12 ml-auto">       
                        <button type="submit" class="btn btn-success mr-2 ml-auto" id="botao-salvar-disciplina">Salvar</button>

                        <button type="submit" class="btn btn-success mr-2 ml-auto" id="botao-alterar-disciplina">Alterar</button>
                        
                        <div class="cancelar-aluno">
                            <button type="reset" class="btn btn-danger fecharModalCadastroDisciplina" data-dismiss="modal">Cancelar</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim do modal Disciplina Formulário -->



<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="js/popper.min.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>

<script src="js/formataFormularioDisciplinas.js"></script>
<script src="js/salvarDisciplina.js"></script>
<script src="js/alterarDisciplina.js"></script>
<script src="js/excluirDisciplina.js"></script>

<?php 
    include("rodape.php");
?>