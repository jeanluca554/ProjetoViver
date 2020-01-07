$("#btn-calcular").click(calculaValores);

function calculaValores()
{
	var campoSalario = parseFloat(limpaValores($("#salario").val()));
	
	var campoCestaBasica = parseFloat(limpaValores($("#cestaBasica").val()));
	
	var campoINSS;
	var campoIRRF;

	limpaValores($("#inss").val()) == 0 ? campoINSS = 0 : campoINSS = parseFloat(limpaValores($("#inss").val()));

	var campoCestaBasica = parseFloat(limpaValores($("#cestaBasica").val()));
	
	limpaValores($("#irrf").val()) == 0 ? campoIRRF = 0 : campoIRRF = parseFloat(limpaValores($("#irrf").val()));
	
	var campoTotal = campoSalario + campoCestaBasica - campoINSS - campoIRRF;
	console.log(campoTotal);

	$("#total").mask("0000,00");//evita que a linha abaixo pare de funcionar quando #total for clicado mais de uma vez

	$("#total").val(campoTotal).mask("##.##0,00", {reverse: true});	
}

function limpaValores(valor)
{
    var v = $.trim(valor);
    var valorSemPonto = v.replace(".", "");
    var valorFinal = valorSemPonto.replace(",", "");
    return valorFinal;
}