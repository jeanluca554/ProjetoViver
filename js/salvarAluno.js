$(function() {
    $("#botao-salvar-aluno").on("click", salvaDadosAluno);
    $("#botao-salvar-endereco-aluno").on("click", salvaEnderecoAluno);
    $("#botao-salvar-resonsavel-do-aluno").on("click", salvarResponsavelFinanceiroDidatico);

    $("#botao-alterar-aluno").on("click", alterarDadosAluno);
    $("#botao-alterar-endereco-aluno").on("click", verificaIdEnderecoAluno);
    $("#botao-alterar-resonsavel-do-aluno").on("click", salvarResponsavelFinanceiroDidatico);
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
                    sessionStorage.setItem('alunoID', ultimoId['ultimoID']);
                    
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

function alterarDadosAluno() {
    var nome = $("#nomeAluno").val();
    var dataNascimento = $("#dataNascimento").val();
    console.log(dataNascimento);
    var sexo = $("#sexo").val();
    var nacionalidade = $("#nacionalidade").val();
    var estado = $("#selectEstadoNascimento").val();
    var cidade = $("#selectCidadeNascimento").val();
    var pais = $("#paisOrigem").val();
    var id = parseInt(sessionStorage.getItem('idBtnAlterar'));
    console.log(id);

    if (nome != '') {
        $.ajax({
            url: 'aluno-alterar-post.php',
            method: 'post',
            dataType: 'json',
            data: {
                id: id,
                nome: nome,
                dataNascimento: dataNascimento,
                sexo: sexo,
                nacionalidade: nacionalidade,
                estado: estado,
                cidade: cidade,
                pais: pais
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

            /* error: function (XMLHttpRequest, textStatus, errorThrown) {
                for (i in XMLHttpRequest) {
                    if (i != "channel")
                        document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                }
            } */
            error: function (response) {
                Swal.fire({
                    type: 'warning',
                    title: 'mensagem',
                    text: response['text'],
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
    var cidade = $('#selectCidadeResidenciaAluno').val();
    var estado = $('#selectEstadoResidenciaAluno').val();

    if (logradouro != '') {
        $.ajax({
            url: 'endereco-criar-post.php',
            method: 'post',
            dataType: 'json',
            data: { cep: cep, logradouro: logradouro, numeroCasa: numeroCasa, complemento: complemento, bairro: bairro, cidade: cidade, estado: estado },

            success: function (ultimoId) {
                if (ultimoId['code'] == 'ok') {
                    ultimoIdEndereco = ultimoId['message'];
                    console.log(ultimoIdEndereco + "ultimo id do endereco");
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

            error: function (XMLHttpRequest, textStatus, errorThrown) {
                for (i in XMLHttpRequest) {
                    if (i != "channel")
                        document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                }
            }
            /* error: function () {
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
            } */
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

function alterarEnderecoAluno() {
    var cep = $("#cepAluno").val();
    var logradouro = $("#logradouroAluno").val();
    var numeroCasa = $("#numeroCasaAluno").val();
    var complemento = $("#complementoAluno").val();
    var bairro = $("#bairroAluno").val();
    var estado = $("#selectEstadoResidenciaAluno").val();
    var cidade = $("#selectCidadeResidenciaAluno").val();
    var id = parseInt(sessionStorage.getItem('idEnderecoAluno'));

    if (id != '') {
        $.ajax({
            url: 'aluno-endereco-alterar-post.php',
            method: 'post',
            dataType: 'json',
            data: {
                id: id,
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
                        text: 'Endereço do aluno alterado com sucesso!',
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

            /* error: function (XMLHttpRequest, textStatus, errorThrown) {
               for (i in XMLHttpRequest) {
                   if (i != "channel")
                       document.write(i + " : " + XMLHttpRequest[i] + "<br>")
               }
           }  */
            error: function (response) {
                Swal.fire({
                    type: 'warning',
                    title: 'Algo errado aconteceu',
                    text: response['Erro ao alterar o endereço do aluno'],
                    //text: response['text'],
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
    }
}

function vincularEnderecoAoAluno(idEndereco) {
    var alunoId = parseInt(ultimoIdAluno);
    var alunoId = sessionStorage.getItem('alunoID');
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

        /* error: function (ultimoId) {
            Swal.fire({
                type: 'warning',
                title: 'Erro ao Salvar o responsável do aluno',
                text: ultimoId['text'],
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

function salvarResponsavelFinanceiroDidatico() {
    var respFinanceiro = $('#selectResponsavelFinanceiro').val();
    var respDidatico = $('#selectResponsavelDidatico').val();
    var idAluno = sessionStorage.getItem('alunoID');
    console.log(respDidatico);
    console.log(respFinanceiro);

    if ((respFinanceiro != null) && (respDidatico != null))
    {
        $.ajax({
            url: 'responsavel-financeiro-didatico-alterar.php',
            method: 'post',
            dataType: 'json',
            data: {
                idAluno: idAluno,
                respFinanceiro: respFinanceiro,
                respDidatico: respDidatico
            },

            success: function (data) {
                //alert(data['message']);
                Swal.fire({
                    type: 'success',
                    title: 'Concluído',
                    text: 'Os responsaveis foram vinculados ao aluno com sucesso!',
                    // text: data['text'],
                    animation: true,
                    customClass: {
                        popup: 'animated bounce'
                    }
                })
            },

            error: function (ultimoId) {
                Swal.fire({
                    type: 'warning',
                    title: 'Erro ao vincular os responsáveis Financeiro e Didáticos ao aluno',
                    text: ultimoId['text'],
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
            /* error: function (XMLHttpRequest, textStatus, errorThrown) {
                for (i in XMLHttpRequest) {
                    if (i != "channel")
                        document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                }
            } */
        });
    }
    else
    {
        Swal.fire({
            type: 'warning',
            title: 'Atenção!',
            text: 'Para salvar é preciso selecionar um Responsável Financeiro e um Responsável Didático',
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        })
    }
}

function verificaIdEnderecoAluno()
{
    var id = parseInt(sessionStorage.getItem('idEnderecoAluno'));
    id == 1 ? salvaEnderecoAluno() : alterarEnderecoAluno();
}