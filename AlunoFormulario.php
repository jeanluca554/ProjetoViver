<?php 
    require_once("cabecalho.php");
    require_once("logica-usuario.php");
    require_once('DAO/AlunoDAO.php');
    require_once("DAO/EstadoDao.php");
    require_once("DAO/PaisDAO.php");
    require_once("DAO/ResponsavelDAO.php");
    require_once("DAO/TurmaDAO.php");

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
    <h1>Alunos Cadastrados</h1>
    <div class="ml-auto">
        <button 
            id="btn-cadastrar-aluno"
            type="button" 
            class="btn btn-outline-success" 
            data-toggle="modal" 
            data-target="#ModalAlunoFormulario"
            onclick="garanteSessionNomeAluno()"
        >
            <img src="img/laranja-adicionar-25.png" class="mr-1">Cadastrar Aluno
        </button>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <table class="table table-hover table-bordered tabelaPTBR" id="tabelaDeFuncionarios">
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
                                id="bnt-editar-aluno"
                                class="btn btn-outline-info btn-editar-aluno" 
                                data-toggle="modal" 
                                data-target="#ModalAlunoFormulario" 
                                data-nome="<?php echo $linha['nome_aluno'] ?>"
                                data-id="<?php echo $linha['id_aluno'] ?>"
                                data-endereco="<?php echo $linha['id_endereco_residencia'] ?>"
                                onclick="verificaAlterar('<?php echo $linha['nome_aluno'] ?>', <?php echo $linha['id_aluno'] ?>, <?php echo $linha['id_endereco_residencia'] ?>)"
                            >
                                <img src="img/editar.png">
                            </button>
                        </td>
                        <td align="center">
                            <button 
                                type="button"
                                id="<?php echo $linha['id_aluno'] ?>"
                                class="btn btn-outline-danger btn-excluir-aluno" 
                                onclick="excluirDadosAluno(<?php echo $linha['id_aluno'] ?>)"
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
                <div id="tituloCadastrarAluno">              
                    <h5 class="modal-title">Cadastrar Aluno</h5>
                </div>
                <!--<div id="tituloNomeAluno">              
                    <h5 class="modal-title">Cadastrar Aluno</h5>
                </div> -->

                <button 
                    type="button" 
                    class="close fecharModalCadastroAluno" 
                    id="fecharMoldalAluno" 
                    data-dismiss="modal"
                    
                >
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item pessoaisAluno">
                        <a  class="nav-link active" 
                            id="dadosPessoaisAluno-tab" 
                            data-toggle="tab" 
                            href="#abaDadosPessoaisAluno" 
                            role="tab" 
                            aria-controls="hom" 
                            aria-selected="true"
                        >
                            Dados Pessoais
                        </a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link disabled" 
                            id="enderecoAluno-tab" 
                            data-toggle="tab" 
                            href="#abaEnderecoAluno" 
                            role="tab" 
                            aria-controls="enderecoAluno" 
                            aria-selected="false"
                        >
                            Endereço
                        </a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link disabled" 
                        id="responsaveisAluno-tab" 
                        data-toggle="tab" 
                        href="#abaResponsaveisAluno" 
                        role="tab" 
                        aria-controls="profil" 
                        aria-selected="false"
                    >
                        Responsáveis
                    </a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link disabled" 
                            id="matricularAluno-tab" 
                            data-toggle="tab" 
                            href="#abaMatricularAluno" 
                            role="tab" 
                            aria-controls="contac" 
                            aria-selected="false"
                        >
                            Matrícula
                        </a>
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
                            <div class="form-row col-md-12 ml-auto">       
                                <button type="submit" class="btn btn-success mr-2 ml-auto" id="botao-salvar-aluno">Salvar</button>

                                <button type="submit" class="btn btn-success mr-2 ml-auto" id="botao-alterar-aluno">Alterar</button>
                                
                                <div class="cancelar-aluno">
                                    <button type="reset" class="btn btn-danger fecharModalCadastroAluno" data-dismiss="modal">Cancelar</button>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade divEndereco" id="abaEnderecoAluno" role="tabpanel" aria-labelledby="profile-tab">                       
                        <div class="form-row mt-5">                       
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

                            <button type="submit" class="btn btn-success ml-auto mt-3" id="botao-salvar-endereco-aluno">Salvar</button>

                            <button type="submit" class="btn btn-success ml-auto mt-3" id="botao-alterar-endereco-aluno">Alterar</button>

                            <button type="reset" class="btn btn-danger ml-2 mt-3 fecharModalCadastroAluno" data-dismiss="modal" id="closeButton">Fechar</button>
                        </div> 
                    </div>

                    <div 
                        class="tab-pane fade" 
                        id="abaResponsaveisAluno" 
                        role="tabpanel" 
                        aria-labelledby="profile-tab"
                    >
                       
                        <div class="form-row align-items-end mt-5">
                            <div class="col-md-4 my-1">
                                <label for="selecionarResponsavel">Selecione o Responsável</label>
                                <input 
                                    type="text" 
                                    name="selecionaResponsavel" 
                                    class="form-control" 
                                    id="selecionaResponsavel" 
                                    placeholder="Digite o nome do responsável"
                                >

                            </div>
                            <div class="col-auto my-1">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-primary" 
                                    id="btnAdicionaResponsavel" 
                                    disabled
                                >
                                    Adicionar
                                </button>
                            </div>

                            <div class="ml-auto">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-success" 
                                    data-toggle="modal" 
                                    data-target="#ResponsaveisModal" 
                                    id="btnCadastrarResponsaveis"
                                    onclick="($('#ModalAlunoFormulario').modal('hide'))"
                                >
                                    <img src="img/laranja-adicionar-25.png">Cadastrar Responsável
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
                        <div class='form-row col-md-12 ml-auto'>
                            <button 
                                type="submit" 
                                class="btn btn-success ml-auto mt-3" 
                                id="botao-salvar-responsavel-do-aluno"
                            >
                                Salvar
                            </button>

                            <button 
                                type="submit" 
                                class="btn btn-success ml-auto mt-3" 
                                id="botao-alterar-responsavel-do-aluno"
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

                    <div 
                        class="tab-pane fade" 
                        id="abaMatricularAluno" 
                        role="tabpanel" 
                        aria-labelledby="profile-tab"
                    >
                        <div class="form-row align-items-end mt-5">
                            <div class="ml-auto">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-success" 
                                    data-toggle="modal" 
                                    data-target="#NovaMatriculaModal" 
                                    id="btnNovaMatricula"
                                    onclick="($('#ModalAlunoFormulario').modal('hide'))"
                                >
                                    <img src="img/laranja-adicionar-25.png" class="mr-1">Nova Matricula
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12 table-responsive mt-4">
                        <table class="table table-hover table-bordered table-striped tabelaMatriculas tabelaPTBR" id="tabelaMatriculas">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th class="align-middle">Ano Letivo</th>
                                        <th class="align-middle">Tipo de Ensino</th>
                                        <th class="align-middle">Turma</th>
                                        <th class="align-middle">Data Início da Matrícula</th>
                                        <th class="align-middle">Data Fim da Matrícula</th>
                                        <th class="align-middle">Situação</th>
                                        <th class="align-middle">Alterar</th>
                                        <th class="align-middle">Remover</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class='form-row col-md-12 ml-auto'>
                            <button 
                                type="reset" 
                                class="btn btn-danger ml-auto mt-3 fecharModalCadastroAluno" data-dismiss="modal" 
                                id="closeButton"
                            >
                                Fechar
                            </button>  
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim do modal Aluno Formulário -->

<!-- Modal Cadastrar Responsável-->
<div class="modal fade" id="ResponsaveisModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">              
                <h5 class="modal-title">Cadastrar Responsável</h5>

                <button 
                    type="button" 
                    class="close fecharModalCadastroResponsavel" 
                    data-dismiss="modal"
                >
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="dadosPessoaisResponsavel-tab" data-toggle="tab" href="#abaDadosPessoaisResponsavel" role="tab" aria-controls="DadosPessoais" aria-selected="true">Dados Pessoais</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link disabled" id="enderecoResponsavel-tab" data-toggle="tab" href="#" role="tab" aria-controls="Endereco" aria-selected="false">Endereço</a>
                    </li>
                    
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="abaDadosPessoaisResponsavel" role="tabpanel" aria-labelledby="dadosPessoaisResponsavel-tab">

                        <div class="form-row mt-5">
                            
                            <div class="form-group col-md-9">
                                <label for="nome">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" id="nomeResponsavel" placeholder="Nome Completo" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="cpf">CPF</label>
                                <input type="text" name="cpf" class="form-control" id="cpf" placeholder="000.000.000-00" required>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="cpf">RG</label>
                                <input type="text" name="rg" class="form-control" id="rgResponsavel" placeholder="RG" maxlength="13">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="telefone">Telefone Pessoal</label>
                                <input type="text" name="telefone" class="form-control telefone" id="telefone1" placeholder="(00)00000-0000">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="telefone">Telefone Adicional</label>
                                <input type="text" name="telefone" class="form-control telefone" id="telefone2" placeholder="(00)00000-0000">
                            </div>

                            <button 
                                type="submit" 
                                class="btn btn-success ml-auto mt-3" 
                                id="botao-salvar-dados-pessoais-responsavel"
                            >
                                Salvar
                            </button>

                            <button 
                                type="submit" 
                                class="btn btn-success ml-auto mt-3" 
                                id="botao-alterar-dados-pessoais-responsavel"
                            >
                                Alterar
                            </button>

                            <button 
                                type="reset" 
                                class="btn btn-danger mt-3 ml-2 fecharModalCadastroResponsavel"
                                data-dismiss="modal"
                            >
                                Fechar
                            </button>
                        </div>                             
                        
                    </div>

                    <div class="tab-pane fade divEndereco" id="abaEnderecoResponsavel" role="tabpanel" aria-labelledby="profile-tab">   
                        <div class="form-check mt-4">
                            <!--<div class="form-row mt-4 ml-auto"> -->
                            <input 
                                type="checkbox" 
                                class="form-check-input col-md-1" 
                                id="checkboxcopiaendereco"
                            >
                            <label class="form-check-label ml-2" for="exampleCheck1">Copiar endereço do Aluno</label>
                        </div>
                        <div class="form-row mt-4">                            
                            <div class="form-group col-md-2">
                                <label for="cep">CEP</label>
                                <input 
                                    type="text" 
                                    name="cep" 
                                    class="form-control cep" 
                                    id="cepResponsavel" 
                                    placeholder="00000-000" 
                                    required
                                >
                            </div>

                            <div class="form-group col-md-8">
                                <label for="logradouro">Logradouro</label>
                                <input 
                                    type="text" 
                                    name="logradouro" 
                                    class="form-control" 
                                    id="logradouroResponsavel" 
                                    placeholder="Rua / Avenida"
                                >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="numeroCasa">Número</label>
                                <input 
                                    type="number" 
                                    name="numeroCasa" 
                                    class="form-control" 
                                    id="numeroCasaResponsavel" 
                                    placeholder="Nº"
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="complemento">Complemento</label>
                                <input 
                                    type="text" 
                                    name="complemento" 
                                    class="form-control" 
                                    id="complementoResponsavel" 
                                    placeholder="Complemento"
                                >
                            </div>

                            <div class="form-group col-md-6">
                                <label for="bairro">Bairro</label>
                                <input 
                                    type="text" 
                                    name="bairro" 
                                    class="form-control" 
                                    id="bairroResponsavel" 
                                    placeholder="Bairro"
                                >
                            </div>
                        </div>

                        <div class="form-row">                            
                            <div class="form-group col-md-6" id="divEstadoResidencia">
                                <label for="estadoResidencia">Estado</label>
                                <select 
                                    name="estadoResidencia" 
                                    class="form-control" 
                                    id="selectEstadoResidenciaResponsavel"
                                >
                                    <option value="">Selecione o Estado</option>
                                    <?php EstadoDAO::carregaEstado();?>
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="divCidadeResidencia">
                                <label for="cidadeResidencia">Cidade</label>
                                <select 
                                    name="cidadeResidencia" 
                                    class="form-control" 
                                    id="selectCidadeResidenciaResponsavel"
                                >
                                </select>
                            </div>

                            <button 
                                type="submit" 
                                class="btn btn-success ml-auto mt-3" 
                                id="botao-salvar-endereco-responsavel"
                            >
                                Salvar
                            </button>

                            <button 
                                type="submit" 
                                class="btn btn-success ml-auto mt-3" 
                                id="botao-alterar-endereco-responsavel"
                            >
                                Alterar
                            </button>

                            <button 
                                type="reset" 
                                class="btn btn-danger mt-3 ml-2 fecharModalCadastroResponsavel"
                                data-dismiss="modal"
                            >
                                Fechar
                            </button>

                        </div> 

                    </div>
                    
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Fim do modal Cadastrar Responsável -->

<!-- Modal Nova Matrícula-->
<div class="modal fade" id="NovaMatriculaModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">              
                <h5 class="modal-title">Matricular </h5>
                <button 
                    type="button" 
                    class="close fecharModalNovaMatricula" 
                    data-dismiss="modal"
                >
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-row mt-3 d-flex justify-content-center">
                    <div class="form-group col-md-10">
                        <label for="nome">Ano Letivo</label>
                        <input 
                            type="year" 
                            name="anoLetivo" 
                            class="form-control anoLetivo" 
                            id="anoLetivoMatricula" 
                            required
                        >
                    </div>
                </div>
                <div class="form-row d-flex justify-content-center">
                    <div class="form-group col-md-10">
                        <label for="tipoEnsino">Tipo Ensino</label>
                        <select name="tipoEnsino" class="form-control" id="tipoEnsinoMatricula">    
                        <option value="0">Selecione...</option>
                            <option value="1">Educação Infantil</option>
                            <option value="2">Ensino Fundamental</option>            
                            <option value="3">Ensino Médio</option>            
                        </select>
                    </div>
                </div>
                <div class="form-row d-flex justify-content-center">
                    <div class="form-group col-md-10">
                        <label for="tipoEnsino">Turmas</label>
                        <select 
                            name="tipoEnsino" 
                            class="form-control" 
                            id="selectTurmasMatricula" 
                            disabled
                        >    
                                       
                        </select>
                    </div>
                                    
                </div>
                <div class="form-row d-flex justify-content-center">
                     
                    <div class="form-group col-md-10 nascimentoAluno">
                        <label for="DataMatricula">Data de Matricula</label>
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="button" disabled><img src="img/laranja-hoje-25.png"></button>
                            </span>
                            <input type="text" class="form-control" id="dataMatricula" name="dataMatricula">
                        </div>
                    </div>                   
                </div>
                <div class="form-row">
                    <button 
                        type="submit" 
                        class="btn btn-success ml-auto mt-3" 
                        id="botao-salvar-matricula"
                    >
                        Matricular
                    </button>

                    <button 
                        type="submit" 
                        class="btn btn-success ml-auto mt-3" 
                        id="botao-alterar-matricula"
                    >
                        Matricular
                    </button>

                    <button 
                        type="reset" 
                        class="btn btn-danger mt-3 ml-2 fecharModalNovaMatricula"
                        data-dismiss="modal"
                    >
                        Fechar
                    </button>
                <div>
            </div>
        </div>
    </div>
</div>
<!-- Fim do modal Nova Matrícula -->


<script src="js/salvarAluno.js"></script>
<!-- <script src="js/alterarAluno.js"></script> -->
<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script> 
<!-- <script src="js/DatepickerGeral.js"></script> -->
<script src="js/DatepikerAno.js"></script>
<script src="js/nacionalidadeAluno.js"></script>
<script src="js/popper.min.js"></script>
<!-- <script src="js/setModalAluno.js"></script> -->
<script src="js/pegaResponsaveis.js"></script>
<script src="js/pegaCidades.js"></script>
<script src="js/formataCamposAluno.js"></script>
<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
<script src="js/dataTable.js"></script>
<script src="js/limpaModalCadastroAluno.js"></script>
<script src="js/excluirAluno.js"></script>
<script src="js/excluirResponsavel.js"></script>
<script src="js/formataCamposResponsavel.js"></script>
<script src="js/limpaModalCadastroResponsavel.js"></script>
<script src="js/salvarResponsavel.js"></script>
<script src="js/modalResponsaveis.js"></script>
<script src="js/salvarMatricula.js"></script>
<script src="js/fechaModalCadastroMatricula.js"></script>
<script src="js/formataCamposMatricula.js"></script>
<script src="js/pegaMatriculas.js"></script>

<?php 
    //include("Modal/ModalAlunoFormulario.php");
    // include("Modal/ModalTeste.php");
    include("rodape.php");
?>