$(function(){
    $('.fecharModalCadastroAluno').on("click", recarregarPagina);

	$('#botao-salvar-endereco-responsavel').click(limparCampos);

    $('#ModalAlunoFormulario').on('hidden.bs.modal', function () {
        
        $('#abaDadosPessoaisAluno').addClass('tab-pane fade active show');
        $('#dadosPessoaisAluno-tab').addClass('nav-link active');
        $('#dadosPessoaisAluno-tab').attr({
            'aria-selected': "true"
        });

        $('#abaEnderecoAluno').removeClass('tab-pane fade active show');
        $('#abaEnderecoAluno').addClass('tab-pane fade');
        $('#enderecoAluno-tab').removeClass('active');
        $('#enderecoAluno-tab').addClass('nav-link');
        $('#enderecoAluno-tab').attr({
            'aria-selected': "false"
        });

        $('#abaResponsaveisAluno').removeClass('tab-pane fade active show');
        $('#abaResponsaveisAluno').addClass('tab-pane fade');
        $('#responsaveisAluno-tab').removeClass('active');
        $('#responsaveisAluno-tab').addClass('nav-link');
        $('#responsaveisAluno-tab').attr({
            'aria-selected': "false"
        });

        sessionStorage.removeItem('alunoID');
        sessionStorage.setItem('nomeModal', "undefined");
        // sessionStorage.setItem('nomeBtnAlterar', "undefined");

        $('#nomeAluno').val('');
        $('#dataNascimento').val('');
        $('#sexo').val('Masculino');
        $('#nacionalidade').val('0');
        $('#selectEstadoNascimento').val('0');
        $('#selectCidadeNascimento').val('0');
        $("#divEstadoNascimento").hide();
        $("#divCidadeNascimento").hide();
        $("#divCidadeNascimento").hide();
        $("#divPaisOrigem").hide();
        $('#paisOrigem').val('');
        $('#cepAluno').val('');
        $('#logradouroAluno').val('');
        $('#numeroCasaAluno').val('');
        $('#complementoAluno').val('');
        $('#bairroAluno').val('');
        $('#selectCidadeResidenciaAluno').hide();

    });
});


function limparCampos()
{
    location.reload();
}

function recarregarPagina()
{
    location.reload();
}