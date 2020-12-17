$(function() {    
	formatarCamposFuncionario();
    verificarCpf();
    //desabilitar();

    $('#cargo').on('change', function () {
        mostraSalario();
    });

    $('#emailFuncionario').on('blur', function(){
        geraSenha();
    });
});

function formatarCamposFuncionario()
{
    $('#telefoneFuncionario').mask('(00)00000-0000');
    $('#cpfFuncionario').mask('000.000.000-00');
    $('#salario').mask("##.##0,00", {reverse: true});
}

function mostraSalario()
{
    var cargo = $('#cargo').val();
    console.log(cargo);
    if (cargo == 'Ensino Fundamental 2 / Médio')
    {
        console.log('É igual');
        $('#salario').attr("disabled", true);
        $('#salario').val("");
    }
    else
    {
        $('#salario').attr("disabled", false);
    }
    //document.getElementById('salarioFuncionario').disabled = valor == 'Ensino Fundamental 2 / Médio';   
}

function desabilitar(selecionado) 
{
    document.getElementById('btnPesquisarAlunos').disabled = !selecionado;
}

function verificarCpf()
{
    $('#cpfFuncionario').blur(function()
    {
        var cpf = $('#cpfFuncionario').val().replace(/[^0-9]/g, '').toString();

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

                $('#cpfFuncionario').val('');
                $('#cpfFuncionario').focus();
            }
        }
        else
        {
            if( cpf.length != 0 )
            {
                alert('CPF inválido:' + cpf);

                $('#cpfFuncionario').val('');
                $('#cpfFuncionario').focus();
            }           
        }
    });
}

function geraSenha() {
    var email = $('#emailFuncionario').val();
    $.ajax({
        url: 'DAO/banco-usuario.php',
        // dataType: 'json',
        method: 'post',
        data: { email: email, funcao: 2 },

        success: function (response) 
        {
            var senha = response;
            $('#senhaFuncionario').val(senha);
            //console.log(senha);
        },

        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            Swal.fire({
                icon: 'error',
                title: 'Ops..',
                text: 'Houve um erro ao gerar a senha. Por favor tente mais tarde',
                showClass: {
                    popup: 'animated tada'
                    // backdrop: 'animated tada'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            })
        }

        // error: function (request, status, error) {
        //     console.log(status.responseText);
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Ops..',
        //         text: 'Houve um erro ao gerar a senha. Por favor tente mais tarde',
        //         showClass: {
        //             popup: 'animated tada'
        //             // backdrop: 'animated tada'
        //         }
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             location.reload();
        //         }
        //     })
        // }

        /* error: function (response) {
            console.log(response);
            Swal.fire({
                type: 'warning',
                title: 'Algo errado aconteceu',
                text: 'Erro ao buscar os dados do aluno eita' + response,
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        } */
    });
}