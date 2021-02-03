<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once("DAO/MatrizCurricularDAO.php");
    require_once("DAO/TurmaDAO.php");

    verificaUsuario();

    try 
    {
        $listaTurmas = TurmaDAO::listarTurmas();
    } 
    catch(Exception $e) 
    {
        Erro::trataErro($e);
    }
   

?>


<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>
<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>

<div class="form-row align-items-end">
    <h1>Turmas</h1>
    <div class="ml-auto">
        <button 
            type="button" 
            class="btn btn-outline-success" 
            data-toggle="modal" 
            data-target="#ModalTurma"
            id="cadastrar-turma"
        >
            <img src="img/laranja-adicionar-25.png">Cadastrar Turma
        </button>
    </div>
</div>

<!-- Tabela Matrizes Curriculares -->
<div class="row mt-4 justify-content-center">
    <div class="col-md-12 table-responsive">
        <table class="table table-hover table-bordered table-striped tabelaPTBR" id="tabelaTurmas">
            <thead class="thead-dark" align="center">
                <tr>
                    <th class="align-middle" >Nome</th>
                    <th class="align-middle" >Tipo de Ensino</th>
                    <th class="align-middle" >Turno</th>
                    <th class="align-middle" >AnoLetivo</th>
                    <th class="align-middle" width="50">Capacidade Física</th>
                    <th class="align-middle" width="50">Alunos Ativos</th>
                    <th class="align-middle" width="50">Vagas Disponíveis</th>
                    <th class="align-middle" >Situação</th>
                    <th class="align-middle" width="50">Editar</th>
                    <th class="align-middle" width="50">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaTurmas as $linha): ?>
                    <tr>
                        <td align="center"><?php echo $linha['nome_turma']." ".$linha['sigla']?></td>
                        <td align="center"><?php echo $linha['tipo_ensino_turma']?></td>
                        <td align="center"><?php echo $linha['turno']?></td>
                        <td align="center"><?php echo $linha['ano']?></td>
                        <td align="center"><?php echo $linha['capacidade']?></td>
                        <td align="center"><?php echo $linha['alunos_ativos']?></td>
                        <td align="center"><?php echo $linha['capacidade'] - $linha['alunos_ativos']?></td>
                        <td align="center"><?php echo $linha['situacao'] == 0 ? "inativo" : "ativo" ?></td>
                        <td align="center">
                            <button 
                                type="button"
                                id="bnt-editar-turma"
                                class="btn btn-outline-info" 
                                data-toggle="modal" 
                                data-target="#ModalTurma" 
                                data-nomeTurma="<?php echo $linha['nome_turma'] ?>"
                                data-id="<?php echo $linha['id_turma'] ?>"
                                onclick="setAlterarTurma(<?php echo $linha['id_turma'] ?>, '<?php echo $linha['sigla'] ?>', <?php echo $linha['num_ensino_turma'] ?>, '<?php echo $linha['turno'] ?>', <?php echo $linha['ano'] ?>, <?php echo $linha['capacidade'] ?>, <?php echo $linha['alunos_ativos'] ?>)"
                            >
                                <img src="img/editar.png">
                            </button>
                        </td>
                        <td align="center">
                            <button 
                                type="button"
                                id="btnExcluirTurma<?php echo $linha['id_turma'] ?>"
                                class="btn btn-outline-danger btn-excluir-turma" 
                                onclick="excluirTurma(<?php echo $linha['id_turma'] ?>, <?php echo $linha['alunos_ativos'] ?>)"
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



<!-- Modal Turma -->
<div class="modal fade" id="ModalTurma" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <div id="tituloCadastrarMatrizCurricular">              
                    <h5 class="modal-title">Cadastrar Turma</h5>
                </div>
            
                <button 
                    type="button" 
                    class="close fecharModalCadastroTurma" 
                    id="fecharMoldalTurma" 
                    data-dismiss="modal"
                    
                >
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-row align-items-end mt-4">
                    <div class="col-7">
                        <label for="tipoEnsino">Tipo de Ensino</label>
                        <select name="tipoEnsino" class="form-control" id="tipoEnsinoTurma">    
                            <option value="0">Selecione...</option>
                            <?php MatrizCurricularDAO::listarMatrizesOption() ?>
                        </select> 
                        <input hidden id="idTurma" data-id="">       
                        <input hidden id="alunosAtivos" data-id="">       
                    </div>
                    
                    <div class="col-2">
                        <label for="nome">Sigla</label>
                        <input 
                            type="text" 
                            name="sigla" 
                            class="form-control" 
                            id="siglaTurma" 
                            placeholder="Sigla" 
                            required
                        >
                    </div>

                    <div class="col-3">
                        <label for="nome">Ano Letivo</label>
                        <input 
                            type="year" 
                            name="anoLetivo" 
                            class="form-control anoLetivo" 
                            id="anoLetivo" 
                            required
                        >
                    </div>
                </div>

                <div class="form-row align-items-end mt-2">
                    <div class="col-4">
                        <label for="tipoEnsino">Turno</label>
                        <select name="turno" class="form-control" id="turno">    
                            <option value="0">Selecione...</option>
                            <option value="Manha">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                        </select> 
                    </div>
                    <div class="col-4">
                        <label for="nome">Capacidade Física</label>
                        <input 
                            type="number" 
                            name="capacidadeFisica" 
                            class="form-control" 
                            id="capacidadeFisica"
                            placeholder="0"
                            min="0"
                            max="50"
                            maxlength="50"
                            step="1"
                            required
                        >
                    </div>
                </div>
        
                <div class='form-row col-md-12 ml-auto mt-3'>
                    <button 
                        type="submit" 
                        class="btn btn-success ml-auto mt-3" 
                        id="botao-salvar-turma"
                    >
                        Salvar
                    </button>

                    <button 
                        type="submit" 
                        class="btn btn-success ml-auto mt-3" 
                        id="botao-alterar-turma"
                    >
                        Alterar
                    </button>

                    <button 
                        type="reset" 
                        class="btn btn-danger ml-2 mt-3 fecharModalCadastroTurma" data-dismiss="modal" 
                        id="closeButton"
                    >
                        Fechar
                    </button>  
                </div>    
            </div>
        </div>
    </div>
</div>
<!-- Fim do modal Turma Formulário -->



<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="js/popper.min.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>
<script src="datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script> 
<script src="js/DatepikerAno.js"></script>

<script src="js/formataTurma.js"></script>
<script src="js/salvarTurma.js"></script>
<script src="js/excluirTurma.js"></script>



<?php 
    include("rodape.php");
?>