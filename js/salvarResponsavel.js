$(function() {
    $("#botao-salvar-dados-pessoais-responsavel").click(salvaDadosPessoais);
    $("#botao-salvar-endereco-responsavel").click(salvaEnderecoResponsavel);

    $("#botao-alterar-dados-pessoais-responsavel").click(alterarDadosResponsavel);
    $("#botao-alterar-endereco-responsavel").click(verificaIdEnderecoResponsavel);
});

function salvaDadosPessoais() 
{
    var nome = $("#nomeResponsavel").val();
    var cpf = $("#cpf").val();
    var telefone = $("#telefone1").val();
    var telefoneAdicional = $("#telefone2").val();
    var rgResponsavel = $("#rgResponsavel").val();
    ultimoIdLimpo = 0;
        
    if (nome != '')
    {
        $.ajax({
            url: 'responsavel-criar-post.php',
            method: 'post',
            dataType: 'json',
            data: {nome:nome, cpf:cpf, telefone:telefone, telefoneAdicional:telefoneAdicional, rgResponsavel:rgResponsavel},

            success: function(ultimoId)
            {
                if(ultimoId['code'] == 'ok')
                {
                    ultimoIdLimpo = cpf;
                    //alert("Dados pessoais cadastrados com sucesso!");
                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Dados pessoais cadastrados com sucesso!',
                        animation: true,
                        customClass: {
                            popup: 'animated bounce'
                        }                      
                    })
                    $('#enderecoResponsavel-tab').attr('class', 'nav-link');
                    $('#enderecoResponsavel-tab').attr('aria-selected', 'true');
                    $('#enderecoResponsavel-tab').attr('href', '#abaEnderecoResponsavel');
                }
                else
                {
                    //alert(ultimoId['message']);
                    Swal.fire({
                        type: 'warning',
                        title: ultimoId['title'],
                        text: ultimoId['text'],
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
                }
            },

            error: function()
            {
                //alert("Erro ao criar Responsável");
                Swal.fire({
                    type: 'error',
                    title: 'Ops...',
                    text: 'Houve um erro ao criar o Responsável',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }                      
                })
            }
        });
    }    
}

function salvaEnderecoResponsavel() 
{
    var cep = $('#cepResponsavel').val();
    var logradouro = $('#logradouroResponsavel').val();
    var numeroCasa = $('#numeroCasaResponsavel').val();
    var complemento = $('#complementoResponsavel').val();
    var bairro = $('#bairroResponsavel').val();
    var estado = $('#selectEstadoResidenciaResponsavel').val();
    var cidade = $('#selectCidadeResidenciaResponsavel').val();

    console.log(logradouro);

    if (logradouro != '')
    {
        $.ajax({
            url: 'endereco-criar-post.php',
            method: 'post',
            dataType: 'json',
            data: {cep:cep, logradouro:logradouro, numeroCasa:numeroCasa, complemento:complemento, bairro:bairro, estado:estado, cidade:cidade},

            success: function(ultimoId)
            {
                if(ultimoId['code'] == 'ok')
                {
                    ultimoIdEndereco = ultimoId['message'];

                    salvaResponsavelCompleto(ultimoIdEndereco);
                }
                else
                {
                    //alert(ultimoId['message']);
                    Swal.fire({
                        type: 'warning',
                        title: ultimoId['title'],
                        text: ultimoId['text'],
                        animation: false,
                        customClass: {
                            popup: 'animated bounce'
                        }
                    })
                }

                
            },

            /* error: function()
            {
                //alert("Erro ao criar o endereço do responsável");
                Swal.fire({
                    type: 'error',
                    title: 'Ops...',
                    text: 'Houve um erro ao criar o endereço do responsável',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }                      
                })
            } */
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                for (i in XMLHttpRequest) {
                    if (i != "channel")
                        document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                }
            }

            
        });

    }
    else{
        Swal.fire({
                    type: 'warning',
                    title: 'Atenção!',
                    text: 'Preencha os campos obrigatórios',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }                      
                })
    }    
}

function salvaResponsavelCompleto(idEndereco)
{
    var cpf = $("#cpf").val();
    var enderecoId = parseInt(idEndereco);

    $.ajax({
            url: 'responsavel-endereco-criar.php',
            method: 'post',
            dataType: 'json',
            data: {ultimoId: cpf, enderecoId: enderecoId},

            success: function(data)
            {                
                //alert(data['message']);
                Swal.fire({
                    type: 'success',
                    title: 'Concluído',
                    text: data['message'],
                    animation: true,
                    customClass: {
                        popup: 'animated bounce'
                    }                      
                })
            },

            error: function()
            {
                //alert("Erro ao associar endereço ao responsável");
                Swal.fire({
                    type: 'error',
                    title: 'Ops...',
                    text: 'Houve um erro ao associar endereço ao responsável',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }                      
                })
            }
        });
}

function alterarDadosResponsavel() {
    var nome = $("#nomeResponsavel").val();
    var cpf = $("#cpf").val();
    var rg = $("#rgResponsavel").val();
    var telPessoal = $("#telefone1").val();
    var telAdicional = $("#telefone2").val();
    var id = sessionStorage.getItem('responsavelID');

    if (nome != '') {
        $.ajax({
            url: 'responsavel-alterar-post.php',
            method: 'post',
            dataType: 'json',
            data: {
                cpf: cpf,
                nome: nome,
                rg: rg,
                telPessoal: telPessoal,
                telAdicional: telAdicional,
                id: id
            },

            success: function (response) {
                if (response['mensagem'] == 'ok') {

                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Dados pessoais alterados com sucesso!',
                        animation: true,
                        customClass: {
                            popup: 'animated bounce'
                        }
                    })
                }
                else {
                    Swal.fire({
                        type: 'warning',
                        title: response['title'],
                        text: response['text'],
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
                }
            },

            error: function (XMLHttpRequest, textStatus, errorThrown) {
                for (i in XMLHttpRequest) {
                    if (i != "channel")
                        document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                }
            }
            /* error: function (response) {
                Swal.fire({
                    type: 'warning',
                    title: 'mensagem',
                    text: 'Erro ao alterar dados',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            } */
        });
    }
}

function alterarEnderecoResponsavel() {
    var cep = $("#cepResponsavel").val();
    var logradouro = $("#logradouroResponsavel").val();
    var numeroCasa = $("#numeroCasaResponsavel").val();
    var complemento = $("#complementoResponsavel").val();
    var bairro = $("#bairroResponsavel").val();
    var estado = $("#selectEstadoResidenciaResponsavel").val();
    var cidade = $("#selectCidadeResidenciaResponsavel").val();
    var idEnderecoResp = sessionStorage.getItem('idEnderecoResp');

    if (idEnderecoResp != '') {
        $.ajax({
            url: 'endereco-alterar-post.php',
            method: 'post',
            dataType: 'json',
            data: {
                id: idEnderecoResp,
                cep: cep,
                logradouro: logradouro,
                numeroCasa: numeroCasa,
                complemento: complemento,
                bairro: bairro,
                estado: estado,
                cidade: cidade,
            },

            success: function (response) {
                if (response['mensagem'] == 'ok') {

                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Endereço do responsavel alterado com sucesso!',
                        // text: response['teste'],
                        animation: true,
                        customClass: {
                           popup: 'animated bounce'
                       }
                    })


            
                }
                else {
                    Swal.fire({
                        type: 'warning',
                        title: response['title'],
                        text: response['text'],
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
                }
            },

            error: function (XMLHttpRequest, textStatus, errorThrown) {
               for (i in XMLHttpRequest) {
                   if (i != "channel")
                       document.write(i + " : " + XMLHttpRequest[i] + "<br>")
               }
           } 
            /* error: function (response) {
                Swal.fire({
                    type: 'warning',
                    title: 'Algo errado aconteceu',
                    text: response['Erro ao alterar o endereço do responsável'],
                    //text: response['text'],
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            } */
        });
    }
}

function verificaIdEnderecoResponsavel() {
    var id = sessionStorage.getItem('idEnderecoResp');
    console.log(id);
    (id == 'undefined' || id == 1) ? salvaEnderecoResponsavel() : alterarEnderecoResponsavel();
}