<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once("DAO/MatrizCurricularDAO.php");
    require_once("DAO/DisciplinaDAO.php");

    verificaUsuario();

    try 
    {
        $listaMatrizes = MatrizCurricularDAO::listarMatrizes();
    } 
    catch(Exception $e) 
    {
        Erro::trataErro($e);
    }

?>


<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>
<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>

<div class="form-row align-items-end">
    <h1>Matrizes Curriculares</h1>
    <div class="ml-auto">
        <button 
            type="button" 
            class="btn btn-outline-success" 
            data-toggle="modal" 
            data-target="#ModalMatrizCurricular"
            id="cadastrar-matriz-curricular"
        >
            <img src="img/laranja-adicionar-25.png">Cadastrar Matriz Curricular
        </button>
    </div>
</div>

<!-- Tabela Matrizes Curriculares -->
<div class="row mt-4 justify-content-center">
    <div class="col-md-8">
        <table class="table table-hover table-bordered table-striped" id="tabelaMatrizes">
            <thead class="thead-dark" align="center">
                <tr>
                    <th>Nome</th>
                    <th width="90">Editar</th>
                    <th width="90">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaMatrizes as $linha): ?>
                    <tr>
                        <td><?php echo $linha['nome_matriz'] ?></td>
                        <td align="center">
                            <button 
                                type="button"
                                id="bnt-editar-matriz"
                                class="btn btn-outline-info btn-editar-matriz" 
                                data-toggle="modal" 
                                data-target="#ModalMatrizCurricular" 
                                data-nomeDisciplina="<?php echo $linha['nome_matriz'] ?>"
                                data-idDisciplina="<?php echo $linha['id_matriz'] ?>"
                                onclick="setAlterarMatriz('<?php echo $linha['nome_matriz'] ?>', <?php echo $linha['id_matriz'] ?>)"
                            >
                                <img src="img/editar.png">
                            </button>
                        </td>
                        <td align="center">
                            <button 
                                type="button"
                                id="btnExcluirMatriz<?php echo $linha['id_matriz'] ?>"
                                class="btn btn-outline-danger btn-excluir-matriz" 
                                onclick="excluirMatriz(<?php echo $linha['id_matriz'] ?>)"
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



<!-- Modal Matriz Curricular -->
<div class="modal fade" id="ModalMatrizCurricular" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog ">

        <div class="modal-content">

            <div class="modal-header">
                <div id="tituloCadastrarMatrizCurricular">              
                    <h5 class="modal-title">Cadastrar Matriz Curricular</h5>
                </div>
            
                <button 
                    type="button" 
                    class="close fecharModalCadastroMatrizCurricular" 
                    id="fecharMoldalMatrizCurricular" 
                    data-dismiss="modal"
                    
                >
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group mt-4">
                    <label for="nome">Nome da Matriz Curricular</label>
                    <input 
                        type="text" 
                        name="nome" 
                        class="form-control" 
                        id="nomeMatriz" 
                        placeholder="Nome da Matriz Curricular" 
                        required
                    >
                    <input hidden id="idMatriz" data-id="">
                </div>
            <div class="form-row align-items-end mt-5">


                <div class="my-1 mr-1">
                    <label for="disciplina">Selecione a Disciplina</label>
                    <select 
                        name="disciplina" 
                        class="form-control" 
                        id="selectDisciplina"
                    >
                        <option value="">Selecione a Disciplina</option>
                        <?php DisciplinaDAO::listarDisciplinasEcho();?>
                    </select>

                </div>
                <div class="col-auto my-1">
                    <button 
                        type="button" 
                        class="btn btn-outline-primary" 
                        id="btnAdicionaDisciplina" 
                    >
                        Adicionar
                    </button>
                </div>
                <div class="col-auto my-1">
                    <button 
                        type="button" 
                        class="btn btn-outline-primary" 
                        id="btnAdicionaDisciplina2" 
                    >
                        Adicionar
                    </button>
                </div>

            </div>

            <div class="form-row align-items-end">                           
                <div class="col-md-4">                                
                    <div class="list-group table table-borderless" id="show-list">             
                        <!--Aqui entra a janela com todos os responsáveis -->
                    </div>                               
                </div>                        
            </div>

            <!-- <div class="row justify-content-center">
                <div class="col-md-6 "> -->
                    <div class="table-responsive-xl mt-5 table-striped table-bordered">
                        <table class="table table-hover table-responsive-sm tabelaMaterias" id="tabelaMaterias">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th>Matéria</th>
                                        
                                    <th width="50">Remover</th>              
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ovalor é adicionado aqui dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                <!-- </div>
            </div>
 -->
            
            <div class='form-row col-md-12 ml-auto'>
                <button 
                    type="submit" 
                    class="btn btn-success ml-auto mt-3" 
                    id="botao-salvar-matriz-curricular"
                >
                    Salvar
                </button>

                <button 
                    type="submit" 
                    class="btn btn-success ml-auto mt-3" 
                    id="botao-alterar-matriz-curricular"
                >
                    Alterar
                </button>

                <button 
                    type="reset" 
                    class="btn btn-danger ml-2 mt-3 fecharModalCadastroAluno" data-dismiss="modal" 
                    id="closeButton"
                >
                    Fechar
                </button>  
            </div>    
        </div>
    </div>
</div>
<!-- Fim do modal Disciplina Formulário -->



<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="js/popper.min.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/matrizDataTable.js"></script>

<script src="js/formataMatrizCurricular.js"></script>
<script src="js/salvarMatrizCurricular.js"></script>
<script src="js/alterarDisciplina.js"></script>
<script src="js/excluirDisciplina.js"></script>
<script src="js/excluirMatriz.js"></script>
<!-- <script src="js/pegaDisciplinas.js"></script> -->

<?php 
    include("rodape.php");
?>