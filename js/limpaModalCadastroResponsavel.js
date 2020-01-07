$(function(){
	$('.fecharModalCadastroResponsavel').click(limparCampos);
	$('#botao-salvar-endereco-responsavel').click(limparCampos);
	
});

function limparCampos()
{
    $('#cpf').val('');
    $('#telefone').val('');
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
}