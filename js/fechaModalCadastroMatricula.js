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

        $('#dadosPessoaisAluno-tab').attr('href', '#abaDadosPessoaisAluno');
        $('#abaDadosPessoaisAluno').removeClass('tab-pane fade active show');
        $('#abaDadosPessoaisAluno').addClass('tab-pane fade');
        $('#dadosPessoaisAluno-tab').removeClass('active');
        $('#dadosPessoaisAluno-tab').addClass('nav-link');
        $('#dadosPessoaisAluno-tab').attr({
            'aria-selected': "false"
        });

        $('#matricularAluno-tab').attr('href', '#abaMatricularAluno');
        $('#abaMatricularAluno').removeClass('tab-pane fade active show');
        $('#matricularAluno-tab').addClass('nav-link active');
        $('#matricularAluno-tab').attr({
            'aria-selected': "true"
        });

        buscaMatriculasDoAluno();
        
    });

}