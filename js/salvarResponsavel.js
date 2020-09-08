$(function() {
    $("#botao-salvar-dados-pessoais-responsavel").click(salvaDadosPessoais);
    $("#botao-salvar-endereco-responsavel").click(salvaEnderecoResponsavel);
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
    var cpfResp = ultimoIdLimpo;
    var enderecoId = parseInt(idEndereco);

    $.ajax({
            url: 'responsavel-endereco-criar.php',
            method: 'post',
            dataType: 'json',
            data: {ultimoId:cpfResp, enderecoId:enderecoId},

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