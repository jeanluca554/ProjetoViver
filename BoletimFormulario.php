<?php 
    require_once("cabecalho.php");
	require_once("logica-usuario.php");
	require_once("DAO/MatrizCurricularDAO.php");
    require_once("DAO/TurmaDAO.php");
	
	verificaUsuario();

?>

<?php 
    if(professorEstaLogado())
    {
		$funcionario = $_SESSION["idFuncionario"];
		$idFuncionario = $funcionario[0];
		
		try 
		{
			$listaTurmas = TurmaDAO::listarTurmasProfessor($idFuncionario);
		} 
		catch(Exception $e) 
		{
			Erro::trataErro($e);
		}
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
				Boletim - notas e faltas
			</h1>
		</div>
		<div class="card-body">
			<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped tabelaPTBR" id="tabelaTurmasProfessor">
					<thead class="thead-dark" align="center">
						<tr>
							<th class="align-middle" >Turma</th>
							<th class="align-middle" >Disciplina</th>
							
							<th class="align-middle" width="50">Editar</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaTurmas as $linha): ?>
							<tr>
								<td align="center"><?php echo $linha['Turma']?>  <?php echo $linha['sigla'] ?></td>
								<td align="center"><?php echo $linha['Disciplina']?></td>
								<td align="center">
									<button 
										type="button"
										id="bnt-editar-boletim"
										class="btn btn-outline-info" 
										data-toggle="modal" 
										data-target="#ModalBoletim" 
										data-idturmaboletim="<?php echo $linha['id_turma'] ?>"
										data-iddisciplinaboletim="<?php echo $linha['idDisciplina'] ?>"
										onclick="setBoletim(<?php echo $linha['id_turma'] ?>, <?php echo $linha['idDisciplina'] ?>)"
									>
										<img src="img/editar.png">
									</button>
								</td>
								
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal Boletim -->
	<div class="modal fade" id="ModalBoletim" tabindex="-1" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg" role="document" style="max-width: 1120px">
			<div class="modal-content">
				<div class="modal-header bg-success">              
					<h4 class="modal-title text-white">Boletim</h4>
					<button 
						type="button" 
						class="close fecharModalBoletim" 
						data-dismiss="modal"
					>
						<span class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="card">
						<div class="card-body">
							<div class="form-row align-items-end">
								<div class="col-5">
									<label for="nome">Selecione o Bimestre</label>
									<select 
										name="alterarVinculoDisciplina" 
										class="form-control bimestreBoletim" 
										id="bimestreBoletim"
									>
										<option value="1">1º Bimestre</option>
										<option value="2">2º Bimestre</option>
										<option value="3">3º Bimestre</option>
										<option value="4">4º Bimestre</option>
									</select>
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
											<th class="align-middle" >Situação</th>
											<th class="align-middle" >Prova 1</th>
											<th class="align-middle" >Prova 2</th>
											<th class="align-middle" >Trabalho</th>
											<th class="align-middle" width="90">Média Parcial</th>
											<th class="align-middle" width="90">Recuperação</th>
											<th class="align-middle" width="100">Média Final</th>
											<th class="align-middle" >Faltas</th>
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
							<button 
								type="submit" 
								class="btn btn-success ml-auto" 
								id="botao-salvar-boletim"
							>
								Salvar
							</button>

							<button 
								type="reset" 
								class="btn btn-danger ml-2 fecharModalBoletim"
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
	<!-- Fim do modal boletim -->
<?php 
    }
?>

<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="js/popper.min.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>
<script src="datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script> 
<script src="js/DatepikerAno.js"></script>

<script src="js/pegaTurmas.js"></script>
<script src="js/formataBoletim.js"></script>
<script src="js/formataBoletimPDF.js"></script>
<script src="js/alterarVinculoProfessor.js"></script>
<script src="js/salvarBoletim.js"></script>
<!-- <script src="js/excluirTurma.js"></script> -->



<?php 
    include("rodape.php");
?>