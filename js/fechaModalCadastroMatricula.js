$(function(){
    $('.fecharModalNovaMatricula').on("click", abrirModalAluno);
	
});



function abrirModalAluno() {

    $('#NovaMatriculaModal').on('hidden.bs.modal', function () 
    {
        // liberaAbasModalAluno();
        sessionStorage.setItem('liberaAbas', 1);
        console.log('fechei o modal matricula');
        $('#ModalAlunoFormulario').modal('show');

        
    });

}

function liberaAbasModalAluno() {
    $('#enderecoAluno-tab').attr('class', 'nav-link');
    $('#enderecoAluno-tab').attr('href', '#abaEnderecoAluno');

    $('#responsaveisAluno-tab').attr('class', 'nav-link');
    $('#responsaveisAluno-tab').attr('href', '#abaResponsaveisAluno');

    $('#matricularAluno-tab').attr('class', 'nav-link');
    $('#matricularAluno-tab').attr('href', '#abaMatricularAluno');
}