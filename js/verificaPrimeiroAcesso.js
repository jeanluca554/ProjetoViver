$("#prosseguirPrimeiroAcesso").on("click", function () {
    var cpf = $("#cpfPrimeiroAcesso").val()
    if (cpf.length > 0) {
        $.ajax({
            url: 'DAO/banco-usuario.php',
            dataType: 'json',
            method: 'post',
            data: { cpf: cpf, funcao: 1 },

            success: function (response) 
            {
                resp = response;

                if (resp) {
                    var id = resp['id_funcionario'];
                    sessionStorage.setItem('idFuncionario', id);
                    window.location.replace('http://localhost/ProjetoViver/primeiroAcessoEmail.php');
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops..',
                        text: 'CPF ainda não cadastrado. Por favor, entre em contato com a secretaria da escola.',
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
                //console.log(resp);

                $(".formCPF").remove();
                event.preventDefault();
            },

            error: function (request, status, error) {
                // alert(request.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Ops..',
                    text: 'Houve um erro ao buscar o cpf. Por favor tente mais tarde',
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

});

    

$("#prosseguirEmail").on("click", function () {
    var email1 = $('#primeiroEmail').val();
    var email2 = $('#segundoEmail').val();

    if(email1 != '')
    {
        if (email1 != email2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Os e-mails digitados são diferentes',
                showClass: {
                    popup: 'animated tada'
                    // backdrop: 'animated tada'
                }
            })

            $('#primeiroEmail').val('');
            $('#segundoEmail').val('');
        }
        else 
        {
            
            $.ajax({
                url: 'DAO/banco-usuario.php',
                dataType: 'json',
                method: 'post',
                data: { email: email1, funcao: 2 },

                success: function (response) {
                    console.log(response);
                    var ultimoIdLogin = response;
                    var idfunc = sessionStorage.getItem('idFuncionario');
                    $.ajax({
                        url: 'envia-email-confirmacao.php',
                        dataType: 'json',
                        method: 'post',
                        data: { 
                            email: email1, 
                            idFuncionario: idfunc,
                            idLogin: ultimoIdLogin
                        },

                        success: function (response) {
                            console.log(response);

                            // if (response == 1)
                            // {
                            //     Swal.fire({
                            //         icon: 'success',
                            //         title: 'E-mail enviado!',
                            //         text: 'Por favor, verifique sua caixa de entrada',
                            //         showClass: {
                            //             popup: 'animated tada'
                            //             // backdrop: 'animated tada'
                            //         }
                            //     })
                            //     // response.preventDefault();
                            // }
                            // else if (response == 2) {
                            //     Swal.fire({
                            //         icon: 'danger',
                            //         title: 'o e-mail não foi enviado',
                            //         text: 'Por favor, tente mais tarde',
                            //         showClass: {
                            //             popup: 'animated tada'
                            //             // backdrop: 'animated tada'
                            //         }
                            //     })
                            //     // response.preventDefault();
                            // }
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'nenhum nem outro',
                            //     text: 'Por favor, verifique sua caixa de entrada',
                            //     showClass: {
                            //         popup: 'animated tada'
                            //         // backdrop: 'animated tada'
                            //     }
                            // })
                        },

                        error: function (request, status, error) {
                            console.log(request.responseText);
                            Swal.fire({
                                icon: 'success',
                                title: 'E-mail enviado!',
                                text: 'Por favor, verifique sua caixa de entrada e siga as instruções. Caso não encontre verifique no lixo eletrônico',
                                showClass: {
                                    popup: 'animated tada'
                                    // backdrop: 'animated tada'
                                }
                            })
                            window.location.replace('http://localhost/ProjetoViver/index.html');
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
                },

                error: function (request, status, error) {
                    console.log(request.responseText);
                }
            });
        }
    }
})

$("#prosseguirSenha").on("click", function () {
    var senha1 = $('#primeiraSenha').val();
    var senha2 = $('#segundaSenha').val();

    if (senha1 != '') {
        if (senha1 != senha2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'As senhas digitadas são diferentes',
                showClass: {
                    popup: 'animated tada'
                    // backdrop: 'animated tada'
                }
            })

            $('#primeiraSenha').val('');
            $('#segundaSenha').val('');
        }
        else {

            $.ajax({
                url: 'DAO/banco-usuario.php',
                dataType: 'json',
                method: 'post',
                data: { senha: senha1, funcao: 3 },

                success: function (response) {
                    console.log(response);
                    var ultimoIdLogin = response;
                    var idfunc = sessionStorage.getItem('idFuncionario');
                },

                error: function (request, status, error) {
                    console.log(request.responseText);
                }
            });
        }
    }
})