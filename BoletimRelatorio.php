<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    

    verificaUsuario();

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
			Gerar Boletim
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
					id="anoLetivoBoletimRelatorio" 
					required
				>       
			</div>
			
			<div class="col-3">
				<label for="tipoEnsino">Selecione o tipo ensino</label>
				<select name="tipoEnsino" class="form-control" id="tipoEnsinoBoletimRelatorio">    
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
						class="table table-hover table-bordered table-striped tabelaPTBR tabelaTurmasBoletimRelatorio" id="tabelaTurmasBoletimRelatorio"
					>
						<thead class="thead-dark" align="center">
							<tr>
								<th class="align-middle" width="100">AnoLetivo</th>
								<th class="align-middle" >Nome</th>
								<th class="align-middle" >Turno</th>
								<th class="align-middle" width="200">Tipo de Ensino</th>
								<th class="align-middle" width="100">Visualizar</th>
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

<!-- Modal Boletim Relatório -->
<div class="modal fade" id="BoletimRelatorioModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">              
                <h4 class="modal-title text-white">Boletim</h4>
                <button 
                    type="button" 
                    class="close fecharModalBoletimRelatorio" 
                    data-dismiss="modal"
                >
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
				<div class="card">
						<div class="card-body">
							<div class="form-row align-items-end">
								<div class="col-6">
									<label for="nome">Selecione o Bimestre</label>
									<select 
										name="alterarVinculoDisciplina" 
										class="form-control bimestreBoletimRelatorio" 
										id="bimestreBoletimRelatorio"
									>
										<option value="1">1º Bimestre</option>
										<option value="2">2º Bimestre</option>
										<option value="3">3º Bimestre</option>
										<option value="4">4º Bimestre</option>
									</select>
								</div>
								<div class="col- 6 ml-auto">
									<label for="tipoEnsino">Visualizar PDF da sala: </label>
									<button 
									type="submit" 
									class="btn btn-outline-info ml-2" 
									id="botao-gerar-pdf-sala"
								>
									Arquivo PDF<!-- <img src="img/pdf-25.png" alt=""> -->
								</button>
									<input 
										type="hidden"
										class="form-control" 
										id="idTurmaBoletim" 
										disabled
									>
									<input 
										type="hidden"
										class="form-control" 
										id="idDisciplinaBoletim" 
										disabled
									>
								</div>
								
							</div>
						</div>
					</div>
				<div class="card mt-3">
					<div class="card-body">
						<div class="table-responsive">
							<table 
									class="table table-hover table-bordered table-striped tabelaAlunosDaTurma" id="tabelaAlunosDaTurma"
								>
								<thead class="thead-dark" align="center">
									<tr>
										<th class="align-middle" >Id</th>
										<th class="align-middle" >Aluno</th>
										<th class="align-middle" >Gerar PDF</th>				
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
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

<script src="js/pegaTurmasBoletimRelatorio.js"></script>
<script src="js/formataBoletimRelatorio.js"></script>
<script src="js/formataBoletimPDF.js"></script>
<!-- <script src="js/salvarTurma.js"></script>
<script src="js/excluirTurma.js"></script> -->



<?php 
    include("rodape.php");
?>