$('#ModalAlunoFormulario').on('show.bs.modal', function (event) {
    formatarCamposAluno();  
})

function formatarCamposAluno()
{
    $('#dataNascimento').mask('00/00/0000');
}

function limparCampos() {
    $('#enderecoResponsavel-tab').attr('class', 'nav-link');
    $('#enderecoResponsavel-tab').attr('aria-selected', 'true');
    $('#enderecoResponsavel-tab').attr('href', '#abaEnderecoResponsavel');
}