$(function() {    
    $('#cadastrar-disciplina').on("click", setCadastrarDisciplinas);
    $('.fecharModalCadastroDisciplina').on("click", recarregarPagina);
    // $('#bnt-editar-disciplina').on("click", setAlterarDisciplinas);
});

function setCadastrarDisciplinas()
{
    $('#botao-alterar-disciplina').hide();
    $('#botao-salvar-disciplina').show();
    $('#nomeDisciplina').val("");
    $('#ModalDisciplinasFormulario').find('.modal-title').text('Cadastrar Disciplina');

}

function setAlterarDisciplinas(nome, id)
{
    $('#botao-salvar-disciplina').hide();
    $('#botao-alterar-disciplina').show();

    $('#ModalDisciplinasFormulario').find('.modal-title').text('Alterar Disciplina');

    $('#nomeDisciplina').val(nome);
    $('#idDisciplina').attr('data-id', id);
}

function recarregarPagina() {
    location.reload();
}
