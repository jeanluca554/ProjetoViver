$(function() {
    $("#botao-salvar-aluno").click(salvaDadosAluno);
    $("#botao-salvar-endereco-aluno").click(salvaEnderecoAluno);
    //$("#parentesco438.024.498-94").onchange="salvarResponsavelDoAluno(438.024.498-94)";
});

var ultimoIdAluno;

function salvaDadosAluno() 
{
    var nome = $("#nomeAluno").val();
    var dataNascimento = $("#dataNascimento").val();
    var sexo = $("#sexo").val();
    var nacionalidade = $("#nacionalidade").val();
    var estado = $("#selectEstadoNascimento").val();
    var cidade = $("#selectCidadeNascimento").val();
    var pais = $("#paisOrigem").val();
    //var ultimoIdLimpo = 0;
        
    if (nome != '')
    { 
        $.ajax({
            url: 'aluno-criar-post.php',
            method: 'post',
            dataType: 'json',
            data:{
                nome:nome, 
                dataNascimento:dataNascimento, 
                sexo:sexo, 
                nacionalidade:nacionalidade, 
                estado:estado, 
                cidade:cidade, 
                pais:pais
            },

            success: function(ultimoId)
            {
                if(ultimoId['mensagem'] == 'ok')
                {
                    ultimoIdAluno = ultimoId['ultimoID'];
                    
                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Dados pessoais cadastrados com sucesso!',
                        animation: true,
                        customClass: {
                            popup: 'animated bounce'
                        }                      
                    })
                }
                else
                {
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

            error: function(ultimoId)
            {
                Swal.fire({
                    type: 'warning',
                    title: 'Erro ao Salvar o Aluno',
                    text: ultimoId['text'],
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
    }    
}

function salvaEnderecoAluno() {
    var cep = $('#cepAluno').val();
    var logradouro = $('#logradouroAluno').val();
    var numeroCasa = $('#numeroCasaAluno').val();
    var complemento = $('#complementoAluno').val();
    var bairro = $('#bairroAluno').val();
    var cidade = $('#selectCidadeResidencia').val();

    if (logradouro != '') {
        $.ajax({
            url: 'endereco-criar-post.php',
            method: 'post',
            dataType: 'json',
            data: { cep: cep, logradouro: logradouro, numeroCasa: numeroCasa, complemento: complemento, bairro: bairro, cidade: cidade },

            success: function (ultimoId) {
                if (ultimoId['code'] == 'ok') {
                    ultimoIdEndereco = ultimoId['message'];
                    vincularEnderecoAoAluno(ultimoIdEndereco)
                }
                else {
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

            error: function () {
                //alert("Erro ao criar o endereço do responsável");
                Swal.fire({
                    type: 'error',
                    title: 'Ops...',
                    text: 'Houve um erro ao criar o endereço do aluno',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });

    }
    else {
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

function vincularEnderecoAoAluno(idEndereco) {
    var alunoId = parseInt(ultimoIdAluno);
    var enderecoId = parseInt(idEndereco);

    $.ajax({
        url: 'aluno-endereco-criar.php',
        method: 'post',
        dataType: 'json',
        data: { ultimoId:alunoId, enderecoId:enderecoId },

        success: function (data) 
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

        error: function (data) 
        {
            //alert("Erro ao associar endereço ao responsável");
            Swal.fire({
                type: 'error',
                title: 'Ops...',
                text: data['message'],
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
    /* }).done(function (resposta) {
        console.log(resposta);

    }).fail(function (jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);

    }); */
}

function salvarResponsavelDoAluno(cpfResponsavel, IdResponsavelPeloAluno) 
{
    var idRespAluno = IdResponsavelPeloAluno;

    console.log(idRespAluno);
    var parentesco = "parentesco";
    var cpf = cpfResponsavel;
    console.log(cpf);
    var idSelect = parentesco.concat(cpf);
    console.log(idSelect);
    var x = document.getElementById(idSelect).selectedIndex;
    var y = document.getElementById(idSelect).options;
    //alert("Index: " + y[x].index + " is " + y[x].text);
    var parentescoSelecionado = y[x].text;
    console.log(parentescoSelecionado);

    $.ajax({
        url: 'DAO/banco-responsaveis-post.php',
        method: 'post',
        dataType: 'json',
        data: { 
            cpf: cpf,
            idResponsavelPeloAluno: idRespAluno,
            parentescoSelecionado: parentescoSelecionado,
            funcao: 4
        },

        success: function (response) {
            console.log(response);
        },

        error: function (ultimoId) {
            Swal.fire({
                type: 'warning',
                title: 'Erro ao Salvar o Aluno',
                text: ultimoId['text'],
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
}