$(function(){
	$('.fecharModalCadastroResponsavel').on("click", limparCampos);
    $('#botao-salvar-endereco-responsavel').on("click", limparCampos);
	
});

function limparCampos()
{
    $('#cpf').val('');
    $('#rgResponsavel').val('');
    $('#telefone1').val('');
    $('#telefone2').val('');
    $('#cep').val('');
    $('#logradouro').val('');
    $('#numeroCasa').val('');
    $('#complemento').val('');
    $('#bairro').val('');
    $('#SelectCidadeResidencia').attr('option value', '');
    $('#SelectEstadoResidencia').attr('option value', 'Selecione o Estado');
    $('#nomeResponsavel').val('');

    
    $('#enderecoResponsavel-tab').attr('href', '#');
    $('#enderecoResponsavel-tab').attr('class', 'nav-link disabled');
    $("#dadosPessoaisResponsavel-tab").addClass("nav-link");
    $('.nav-tabs li a[href="#abaDadosPessoaisResponsavel"]').tab('show');


    $('#ResponsaveisModal').on('hidden.bs.modal', function () {
        
        $('#ModalAlunoFormulario').modal('show');

        $('#abaResponsaveisAluno').addClass('tab-pane fade active show');
        $('#responsaveisAluno-tab').addClass('nav-link active');
        $('#responsaveisAluno-tab').attr({
            'aria-selected': "true"
        });

        $('#abaEnderecoAluno').removeClass('tab-pane fade active show');
        $('#abaEnderecoAluno').addClass('tab-pane fade');
        $('#enderecoAluno-tab').removeClass('active');
        $('#enderecoAluno-tab').addClass('nav-link');
        $('#enderecoAluno-tab').attr({
            'aria-selected': "false"
        });

        $('#abaDadosPessoaisAluno').removeClass('tab-pane fade active show');
        $('#abaDadosPessoaisAluno').addClass('tab-pane fade');
        $('#dadosPessoaisAluno-tab').removeClass('active');
        $('#dadosPessoaisAluno-tab').addClass('nav-link');
        $('#dadosPessoaisAluno-tab').attr({
            'aria-selected': "false"
        });
    });
    
}
