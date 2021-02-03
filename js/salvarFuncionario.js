$(function() {
    $("#botao-salvar-funcionario").on("click", salvaDadosFuncionario);
})

function salvaDadosFuncionario()
{
    var nome = $("#nomeFuncionario").val();
    var email = $("#emailFuncionario").val();
    var senha = $("#senhaFuncionario").val();
    var cpf = $("#cpfFuncionario").val();
    var rg = $("#rgFuncionario").val();
    var telefone = $("#telefoneFuncionario").val();
    var numeroAgencia = $("#numeroAgencia").val();
    var numeroContaBancaria = $("#numeroContaBancaria").val();
    var salario = $("#salario").val();
    var cargo = $("#cargo").val();

    

    
    

    

    $.ajax({
        url: 'funcionario-criar-post.php',
        dataType: 'json',
        method: 'post',
        data:   {   nome: nome, 
                    email: email,
                    senha: senha,
                    cpf: cpf,
                    rg: rg,
                    telefone: telefone,
                    numeroAgencia: numeroAgencia,
                    numeroContaBancaria: numeroContaBancaria,
                    salario: salario,
                    cargo: cargo

                },

        success: function (response) {
            var jovem = response;
            console.log(jovem);
            Swal.fire({
                type: 'success',
                title: 'Concluído',
                text: 'Funcionário criado com sucesso!',
                animation: true,
                customClass: {
                    popup: 'animated bounce'
                }
            })
            
            cargos = ["Cozinheiro", "Faxineiro", "Serviços Gerais", "Orientador Pedagógico", "Inspetor de alunos", "Nutricionista"];

            var resultado = 0;

            $.each(cargos, function (key, value) {
                if (value == cargo) {
                    resultado = 1;
                }
            })

            if (resultado == 0) {
                $.ajax({
                    url: 'envia-email-confirmacao.php',
                    dataType: 'json',
                    method: 'post',
                    data: { email: email, senha: senha },

                    success: function (response) {
                        console.log(response);

                    },

                    // error: function (request, status, error) {
                    //     console.log(request.responseText);
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                        Swal.fire({
                            icon: 'success',
                            title: 'E-mail enviado!',
                            text: 'Por favor, verifique sua caixa de entrada e siga as instruções. Caso não encontre verifique no lixo eletrônico',
                            showClass: {
                                popup: 'animated tada'
                                // backdrop: 'animated tada'
                            }
                        })
                        location.reload();
                    }

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
            else {
                console.log("Não enviar email");
            }
            
        },

        // error: function (xhr, ajaxOptions, thrownError) {
        //     console.log(xhr.status);
        //     console.log(thrownError);
        error: function (response) {
            console.log(response);
            Swal.fire({
                icon: 'error',
                title: 'Ops..',
                text: 'Houve um erro ao salvar os dados do funcionário. Por favor tente mais tarde',
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

function verificaSeIgual(cargo)
{
    
}