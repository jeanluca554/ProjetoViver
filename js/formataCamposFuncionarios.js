$(function() {    
	formatarCamposFuncionario();
    verificarCpf();
    mostraSalario(valor);
    desabilitar(selecionado);
});

function formatarCamposFuncionario()
{
    $('#telefone').mask('(00)00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#salario').mask("##.##0,00", {reverse: true});
}

function mostraSalario(valor)
{
    document.getElementById('salario').disabled = valor == 'Ensino Fundamental 2 / Médio';   
}

function desabilitar(selecionado) 
{
    document.getElementById('btnPesquisarAlunos').disabled = !selecionado;
}

function verificarCpf()
{
    $('#cpf').blur(function()
    {
        var cpf = $('#cpf').val().replace(/[^0-9]/g, '').toString();

        if( cpf.length == 11 )
        {
            var v = [];

            //Calcula o primeiro dígito de verificação.
            v[0] = 1 * cpf[0] + 2 * cpf[1] + 3 * cpf[2];
            v[0] += 4 * cpf[3] + 5 * cpf[4] + 6 * cpf[5];
            v[0] += 7 * cpf[6] + 8 * cpf[7] + 9 * cpf[8];
            v[0] = v[0] % 11;
            v[0] = v[0] % 10;

            //Calcula o segundo dígito de verificação.
            v[1] = 1 * cpf[1] + 2 * cpf[2] + 3 * cpf[3];
            v[1] += 4 * cpf[4] + 5 * cpf[5] + 6 * cpf[6];
            v[1] += 7 * cpf[7] + 8 * cpf[8] + 9 * v[0];
            v[1] = v[1] % 11;
            v[1] = v[1] % 10;

            //Retorna Verdadeiro se os dígitos de verificação são os esperados
            if ( (v[0] != cpf[9]) || (v[1] != cpf[10]) )
            {
                alert('CPF inválido: ' + cpf);

                $('#cpf').val('');
                $('#cpf').focus();
            }
        }
        else
        {
            if( cpf.length != 0 )
            {
                alert('CPF inválido:' + cpf);

                $('#cpf').val('');
                $('#cpf').focus();
            }           
        }
    });
}