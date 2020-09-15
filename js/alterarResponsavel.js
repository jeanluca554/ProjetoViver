$(function () {
    $("#botao-alterar-dados-pessoais-responsavel").click(alterarDadosResponsavel);
    $("#botao-alterar-endereco-responsavel").click(verificaIdEnderecoResponsavel);
    //$("#parentesco438.024.498-94").onchange="salvarResponsavelDoAluno(438.024.498-94)";
});

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

function alterarEnderecoResponsavel() 
{
    var cep = $("#cepResponsavel").val();
    var logradouro = $("#logradouroResponsavel").val();
    var numeroCasa = $("#numeroCasaResponsavel").val();
    var complemento = $("#complementoResponsavel").val();
    var bairro = $("#bairroResponsavel").val();
    var estado = $("#selectEstadoResidenciaResponsavel").val();
    var cidade = $("#selectEstadoResidenciaResponsavel").val();
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
                    text: response['Erro ao alterar o endereço do responsável'],
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

function verificaIdEnderecoResponsavel() {
    var id = parseInt(sessionStorage.getItem('idEnderecoResp'));
    id == 1 ? salvaEnderecoAluno() : alterarEnderecoAluno();
}