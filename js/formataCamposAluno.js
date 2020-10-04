$(function() {    
    formatarCamposAluno();   
    $('#botao-salvar-aluno').on("click", habilitaAbaEnderecoAluno);
    $('#botao-salvar-endereco-aluno').on("click", habilitaAbaResponsaveisAluno);
});

function formatarCamposAluno()
{
    $('#dataNascimento').mask('00/00/0000');
}

function verificaAlterar(nome, id, idEndereco)
{
    if (nome != "")
    {
        var idEnderecoAluno = idEndereco;

        sessionStorage.setItem('nomeBtnAlterar', nome);
        sessionStorage.setItem('idBtnAlterar', id);
        sessionStorage.setItem('idBtnEndereco', idEnderecoAluno);
        console.log(idEnderecoAluno);
    }
}

function habilitaAbaEnderecoAluno()
{
    $('#enderecoAluno-tab').attr('class', 'nav-link');
    $('#enderecoAluno-tab').attr('href', '#abaEnderecoAluno');
}

function habilitaAbaResponsaveisAluno() {
    $('#responsaveisAluno-tab').attr('class', 'nav-link');
    $('#responsaveisAluno-tab').attr('href', '#abaResponsaveisAluno');
}