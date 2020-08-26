<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");

    verificaUsuario();
?>

<h2>Cadastro de Funcionário</h2>
<form action="funcionario-criar-post.php" method="post">
    <div class="form-group">
        <label for="nome">Nome Completo</label>
        <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome Completo" required>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
        </div>

        <div class="form-group col-md-6">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" class="form-control" id="cpf" placeholder="000.000.000-00" required>
        </div>
    </div>

    <div class="form-row">  
        <div class="form-group col-md-6">
            <label for="rg">RG</label>
            <input type="text" name="rg" class="form-control" id="rg" placeholder="00.000.000-0" maxlength="12">
        </div>
    
        <div class="form-group col-md-6">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" class="form-control" id="telefone" placeholder="(00)00000-0000">
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

    <div class="form-row align-items-start">
        <div class="form-row align-items-center col-md-6">
            <div class="form-check ml-4">
                <input class="form-check-input" type="checkbox" id="ChecaFilhos" onclick="desabilitar(this.checked);">
                <label class="form-check-label" for="gridCheck">
                    Tem alunos que são filhos?
                </label>
            </div>
            <div class="col-auto ml-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filhosModal" id="btnPesquisarAlunos" disabled>Pesquisar alunos</button>
            </div>
        </div>
        
    </div>

    <div class="form-row mt-5">       
        <button type="submit" class="btn btn-success btn-lg">Salvar</button>  
    </div>  
    
</form>

<script type="text/javascript" src="node_modules/bootstrap/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="js/formataCamposFuncionarios.js"></script>

<?php 
    include("Modal/ModalBuscaAlunos.php");
?>

<?php 
    include("rodape.php");
?>