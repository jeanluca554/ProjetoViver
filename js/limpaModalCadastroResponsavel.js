$(function(){
	$('.fecharModalCadastroResponsavel').on("click", limparCampos);
    $('#botao-salvar-endereco-responsavel').on("click", limparCampos);
    // $('.fecharModalNovaMatricula').on("click", limparCamposMatricula);
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
        $('#responsaveisAluno-tab').removeClass('nav-link disabled');
        $('#responsaveisAluno-tab').addClass('nav-link');
        $('#responsaveisAluno-tab').attr('href', '#abaResponsaveisAluno');
        $('#responsaveisAluno-tab').attr({
            'aria-selected': "true"
        });

        console.log("fechei o modal cadastro REsnpinsavel")
        $('#abaEnderecoAluno').addClass('tab-pane fade');
        $('#enderecoAluno-tab').attr('href', '#abaEnderecoAluno');
        $('#enderecoAluno-tab').removeClass('nav-link disabled');
        $('#enderecoAluno-tab').addClass('nav-link');
        $('#enderecoAluno-tab').attr({
            'aria-selected': "false"
        });

        $('#abaDadosPessoaisAluno').removeClass('tab-pane fade active show');
        $('#abaDadosPessoaisAluno').addClass('tab-pane fade');
        $('#dadosPessoaisAluno-tab').attr('href', '#abaDadosPessoaisAluno');
        $('#dadosPessoaisAluno-tab').removeClass('active');
        $('#dadosPessoaisAluno-tab').addClass('nav-link');
        $('#dadosPessoaisAluno-tab').attr({
            'aria-selected': "false"
        });
        

        //Verifica se a aba Matricula já foi liberada
        var abaMatricula = sessionStorage.getItem('abaMatricula');

        if (abaMatricula == 0)
        {
            $('#abaMatricularAluno').removeClass('tab-pane fade active show');
            $('#abaMatricularAluno').addClass('tab-pane fade');
            $('#matricularAluno-tab').removeClass('active');
            $('#matricularAluno-tab').addClass('nav-link disabled');
            $('#matricularAluno-tab').attr({
                'aria-selected': "false"
            });
        }
        else
        {
            $('#matricularAluno-tab').attr('class', 'nav-link');
            $('#matricularAluno-tab').attr('href', '#abaMatricularAluno');
        }
    });
    
}
