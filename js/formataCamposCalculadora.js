$("#btn-calcular").click(formatarCamposCalculadora);

$(function() {    
	formatarCamposCalculadora();
});

function formatarCamposCalculadora()
{
	$('#salario').mask("##.##0,00", {reverse: true});
    $('#cestaBasica').mask("##.##0,00", {reverse: true});
    $('#inss').mask("##.##0,00", {reverse: true});
    $('#irrf').mask("##.##0,00", {reverse: true});
    //$('#total').mask("##.##0,00", {reverse: true});
}

