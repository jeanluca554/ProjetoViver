$(function() {    
    verificarCampoTelefone();
	formatarCamposResponsavel();
    verificarCpf();
});

function formatarCamposResponsavel()
{
    
    $('#cpf').mask('000.000.000-00');
    $('.cep').mask('00000-000');
}

function verificarCampoTelefone()
{
    
    $("#telefone1").keyup(function(){
        var telefoneDigitado = $(this).val();
        if(telefoneDigitado.length < 13){
            $('#telefone1').mask('(00)0000-0000');
        }
        else
        {
            $('#telefone1').mask('(00)00000-0000');
        }
    });

    $("#telefone2").keyup(function(){
        var telefoneDigitado = $(this).val();
        if(telefoneDigitado.length < 13){
            $('#telefone2').mask('(00)0000-0000');
        }
        else
        {
            $('#telefone2').mask('(00)00000-0000');
        }
    });
}

function verificarCpf()
{
    $('#cpf').blur(function()
    {
        var cpfComDigitos = $('#cpf').val();
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
                //alert('CPF inválido: ' + cpf);
                Swal.fire({
                    type: 'error',
                    title: 'Ops..',
                    text: 'CPF inválido: ' + cpfComDigitos,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })

                $('#cpf').val('');
                $('#cpf').focus();
            }
        }
        else
        {
            if( cpf.length != 0 )
            {
                //alert('CPF inválido:' + cpf);
                Swal.fire({
                    type: 'error',
                    title: 'Ops..',
                    text: 'CPF inválido: ' + cpfComDigitos,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })

                $('#cpf').val('');
                $('#cpf').focus();
            }           
        }
    });
}

function garanteSessionNomeAluno()
{
    sessionStorage.removeItem('nomeBtnAlterar');
    sessionStorage.removeItem('idBtnEndereco');
    sessionStorage.removeItem('idBtnAlterar');
}

