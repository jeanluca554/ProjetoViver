$(function(){
	$('.fecharModalCadastroAluno').click(limparCampos);
	$('#botao-salvar-endereco-responsavel').click(limparCampos);
	
});

function limparCampos()
{
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
    $('#selectEstadoResidenciaAluno').attr('option value', 'Selecione o Estado');
    $('#selectCidadeResidenciaAluno').hide();

    //$('#abaDadosPessoaisAluno-tab').addClass('active');
    //$('#abaDadosPessoaisAluno-tab').attr({
      //  'aria-selected': "true"
   // });
    //$('.nav-tabs li a[data-toggle=tab][href="#dadosPessoaisAluno-tab"]').tab('show');
    //$('.nav-tabs li a[href="#enderecoAluno-tab"]').addClass('nav-link');
        

    
}