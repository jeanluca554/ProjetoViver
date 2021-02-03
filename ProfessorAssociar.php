<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once("DAO/MatrizCurricularDAO.php");
    require_once("DAO/TurmaDAO.php");

    verificaUsuario();

    // try 
    // {
    //     $listaTurmas = TurmaDAO::listarTurmas();
    // } 
    // catch(Exception $e) 
    // {
    //     Erro::trataErro($e);
    // }
   

?>


<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>
<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>


<!-- <h1 class="text-success ml-4">
	Associar professor à classe
</h1> -->
<div class="card border-success mb-3">
	<div class="card-header bg-transparent text-success">
	<!-- <div class="card-header bg-transparent text-success border-success"> -->
		<h1 class="card-title">
			Associar professor à classe
		</h1>
	</div>
	<div class="card-body">
		<div class="form-row align-items-end">
			<div class="col-3">
				<label for="nome">Selecione o ano letivo</label>
				<input 
					type="year" 
					name="anoLetivo" 
					class="form-control anoLetivo" 
					id="anoLetivoAssociarProfessor" 
					required
				>       
			</div>
			
			<div class="col-3">
				<label for="tipoEnsino">Selecione o tipo ensino</label>
				<select name="tipoEnsino" class="form-control" id="tipoEnsinoAssociarProfessor">    
					<option value="0">Selecione...</option>
					<option value="1">Educação Infantil</option>
					<option value="2">Ensino Fundamental</option>            
					<option value="3">Ensino Médio</option>            
				</select>
			</div>	
		</div>

		<div class="card mt-4">
			<div class="card-body">
				<div class="col-md-12 table-responsive">
					<table 
						class="table table-hover table-bordered table-striped tabelaPTBR tabelaTurmasAssociacao" id="tabelaTurmasAssociacao"
					>
						<thead class="thead-dark" align="center">
							<tr>
								<th class="align-middle" width="100">AnoLetivo</th>
								<th class="align-middle" >Nome</th>
								<th class="align-middle" >Turno</th>
								<th class="align-middle" width="200">Tipo de Ensino</th>
								<th class="align-middle" width="100">Associar</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
    			</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Associar Professor -->
<div class="modal fade" id="AssociarProfessorModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">              
                <h4 class="modal-title text-white">Associar Professor à disciplina</h4>
                <button 
                    type="button" 
                    class="close fecharModalVincularProfessor" 
                    data-dismiss="modal"
                >
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
				
				<div class="card">
					<div class="card-header bg-transparent text-success">
					<!-- <div class="card-header bg-transparent text-success border-success"> -->
						<h5 class="card-title">
							Professores Associados
						</h5>
					</div>
					<div class="card-body">
						<table 
								class="table table-hover table-bordered table-striped tabelaProfessoresAssociados" id="tabelaProfessoresAssociados"
							>
							<thead class="thead-dark" align="center">
								<tr>
									<th style="display:none">idDisciplina</th>
									<th class="align-middle">Disciplinas</th>
									<th class="align-middle" >Professor Associado</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="card mt-3">
					<div class="card-header bg-transparent text-success">
					<!-- <div class="card-header bg-transparent text-success border-success"> -->
						<h5 class="card-title">
							Alterar vínculo
						</h5>
					</div>
					<div class="card-body">
						<div class="form-row align-items-end">
							<div class="col-5">
								<label for="nome">Selecione a diciplina</label>
								<select 
									name="alterarVinculoDisciplina" 
									class="form-control alterarVinculoDisciplina" 
									id="alterarVinculoDisciplina"
								>
								</select>   
							</div>
							
							<div class="col-5">
								<label for="tipoEnsino">Selecione o Professor</label>
								<select 
									name="alterarVinculoProfessor" 
									class="form-control alterarVinculoProfessor" 
									id="alterarVinculoProfessor"
								>    
									        
								</select>
							</div>
							<div class="col-2">
								<button 
									type="submit" 
									class="btn btn-outline-success ml-auto" 
									id="botao-alterar-vinculo-professor"
								>
									Alterar
								</button>	
							</div>
						</div>
					</div>
				</div>


				<div class="modal-footer">

					<div class="form-row">
						<!-- <button 
							type="submit" 
							class="btn btn-success ml-auto" 
							id="botao-alterar-matricula"
						>
							Salvar
						</button> -->

						<!-- <button 
							type="submit" 
							class="btn btn-success ml-auto mt-3" 
							id="botao-alterar-matricula"
						>
							Matricular
						</button> -->

						<button 
							type="reset" 
							class="btn btn-danger ml-2 fecharModalVincularProfessor"
							data-dismiss="modal"
						>
							Fechar
						</button>
					<div>
				</div>	
            </div>
        </div>
    </div>
</div>
<!-- Fim do modal associar professor -->

<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="js/popper.min.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>
<script src="datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script> 
<script src="js/DatepikerAno.js"></script>

<script src="js/pegaTurmas.js"></script>
<script src="js/formataAssociacaoProfessor.js"></script>
<script src="js/alterarVinculoProfessor.js"></script>
<!-- <script src="js/salvarTurma.js"></script>
<script src="js/excluirTurma.js"></script> -->



<?php 
    include("rodape.php");
?>