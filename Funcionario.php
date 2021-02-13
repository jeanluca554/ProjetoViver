<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once("DAO/FuncionarioDAO.php");

    verificaUsuario();

?>
<?php
    try 
    {
        $listaFuncionarios = FuncionarioDAO::listarFuncionarios();
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
			Cadastrar Funcionário
		</h1>
	</div>
	<div class="card-body">
		<div class="form-row align-items-end">
			<div class="ml-auto mb-3">
				<button 
					type="button" 
					class="btn btn-outline-success" 
					data-toggle="modal" 
					data-target="#ModalFuncionario"
					id="cadastrar-Funcionario"
				>
					<img src="img/laranja-adicionar-25.png"> Novo Funcionário
				</button>
			</div>
		</div>
		<div class="col-md-12 table-responsive">
			<table 
				class="table table-hover table-bordered table-striped tabelaPTBR tabelaTurmasAssociacao" id="tabelaTurmasAssociacao"
			>
				<thead class="thead-dark" align="center">
					<tr>
						<th class="align-middle" >Nome</th>
						<th class="align-middle" >Cargo</th>
						<th>Editar</th>
                    	<th>Excluir</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($listaFuncionarios as $linha): ?>
                    <tr>
                        <td><?php echo $linha['nome_funcionario'] ?></td>
                        <td><?php echo $linha['cargo_funcionario'] ?></td>
                        <td align="center">
                            <button 
                                type="button"
                                id="bnt-editar-funcionario"
                                class="btn btn-outline-info btn-editar-funcionario" 
                                data-toggle="modal" 
                                data-target="#ModalFuncionarioFormulario" 
                                data-nomefuncionario="<?php echo $linha['nome_funcionario'] ?>"
                                data-id="<?php echo $linha['cpf_funcionario'] ?>"
                                onclick="setAlterarFuncionario('<?php echo $linha['cpf_funcionario'] ?>')"
                            >
                                <img src="img/editar.png">
                            </button>
                        </td>
                        <td align="center">
                            <button 
                                type="button"
                                id="<?php echo $linha['cpf_funcionario'] ?>"
                                class="btn btn-outline-danger btn-excluir-funcionario" 
                                onclick="excluirDadosFuncionario(<?php echo $linha['cpf_funcionario'] ?>)"
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
</div>

<!-- Modal Cadastrar Funcionarios -->
<div class="modal fade" id="ModalFuncionario" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 1120px">
        <div class="modal-content">
            <div class="modal-header bg-success">              
                <h4 class="modal-title text-white">Cadastrar Funcionário</h4>
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
							Dados do Funcionário
						</h5>
					</div>
					<div class="card-body">
						<!-- <h2>Cadastro de Funcionário</h2> -->
						<!-- <form action="funcionario-criar-post.php" method="post"> -->
						<div class="form-group">
							<label for="nome">Nome Completo</label>
							<input type="text" name="nome" class="form-control" id="nomeFuncionario" placeholder="Nome Completo" required>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="email">Email</label>
								<input type="email" name="email" class="form-control" id="emailFuncionario" placeholder="Email" required>
							</div>

							<div class="form-group col-md-6">
								<label for="senha">Senha gerada automaticamente</label>
								<input type="text" name="senhaFuncionario" class="form-control" id="senhaFuncionario" disabled>
							</div>
						</div>

						<div class="form-row"> 
							<div class="form-group col-md-4">
								<label for="cpf">CPF</label>
								<input type="text" name="cpf" class="form-control" id="cpfFuncionario" placeholder="000.000.000-00" required>
							</div>

							<div class="form-group col-md-4">
								<label for="rg">RG</label>
								<input type="text" name="rg" class="form-control" id="rgFuncionario" placeholder="00.000.000-0" maxlength="12">
							</div>
						
							<div class="form-group col-md-4">
								<label for="telefone">Telefone</label>
								<input type="text" name="telefone" class="form-control" id="telefoneFuncionario" placeholder="(00)00000-0000">
							</div>
						</div>

						<div class="form-row align-items-center">
							<div class="form-group col-md-2">
								<label for="numeroAgencia">Número da Agencia</label>
								<input type="text" name="numeroAgencia" class="form-control" id="numeroAgencia" maxlength="10">
							</div>

							<div class="form-group col-md-4">
								<label for="numeroContaBancaria">Número da Conta Bancária</label>
								<input type="text" name="numeroContaBancaria" class="form-control" id="numeroContaBancaria" maxlength="15">
							</div>

							<div class="form-group col-md-3">
								<label for="cargo">Cargo</label>
								<select name="cargo" class="form-control" id="cargo" onchange="mostraSalario(this.value)">
									<option>
										Selecionar..
									</option>
									<optgroup label="Professores">
										<option>
											Ensino Fundamental 2 / Médio
										</option>
										<option>
											Ensino Fundamental 1
										</option>
										<option>
											Ensino Fundamental Infantil
									</option>
									</optgroup>
									<optgroup label="Administração">
										<option>
											Secretário
										</option>
									</optgroup>
									<optgroup label="Direção">
										<option>
											Diretor
										</option>
										<option>
											Coordenador
										</option>
									</optgroup>
									<optgroup label="Diversos">
										<option>
											Cozinheiro
										</option>
										<option>
											Faxineiro
										</option>
										<option>
											Serviços Gerais
										</option>
										<option>
											Orientador Pedagógico
										</option>
										<option>
											Inspetor de alunos
										</option>
										<option>
											Nutricionista
										</option>
									</optgroup>
								</select>
							</div>

							<div class="col-md-3">
								<label class="form-group mb-2" for="salario">Salário</label>
								<div class="input-group mb-3">
									<span class="input-group-btn">
										<button class="btn btn-secondary" type="button">R$</button>
									</span>
									<input type="int" name="salario" class="form-control" id="salario" placeholder="0000,00">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">

					<div class="form-row">
						<button 
							type="submit" 
							class="btn btn-success ml-auto" 
							id="botao-salvar-funcionario"
						>
							Salvar
						</button>

						<!-- <button 
							type="submit" 
							class="btn btn-success ml-auto mt-3" 
							id="botao-alterar-matricula"
						>
							Matricular
						</button> -->

						<button 
							type="reset" 
							class="btn btn-danger ml-2 fecharModalcadastrarFuncionario"
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

<script type="text/javascript" src="node_modules/bootstrap/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="js/formataCamposFuncionarios.js"></script>
<script src="js/salvarFuncionario.js"></script>

<?php 
    include("rodape.php");
?>