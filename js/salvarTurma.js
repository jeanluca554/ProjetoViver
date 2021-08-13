$(function() {
    $("#botao-salvar-turma").on("click", salvaTurma);
    $("#botao-alterar-turma").on("click", alterarTurma);
});

function salvaTurma() 
{
    var tipoEnsino = $("#tipoEnsinoTurma option:selected").text();
    var numTipoEnsino = $("#tipoEnsinoTurma").val();
    var sigla = $("#siglaTurma").val();
    var anoLetivo = $("#anoLetivo").val();
    var turno = $("#turno").val();
    var capacidade = $("#capacidadeFisica").val();

    var dadosTurma = tipoEnsino.split("-");
    var nomeTurma = dadosTurma[0];
    var tipoEnsinoTurma = dadosTurma[1];
        
    if (tipoEnsino != 'Selecione...')
    {
        if (sigla != "") 
        {
            if (anoLetivo != "") 
            {
                if (turno != 0)
                {
                    if (capacidade != "")
                    {
                        $.ajax({
                            url: 'turma-criar-post.php',
                            method: 'post',
                            dataType: 'json',
                            data:{
                                nomeTurma: nomeTurma,
                                sigla: sigla,
                                anoLetivo: anoLetivo,
                                turno: turno,
                                capacidade: capacidade,
                                tipoEnsinoTurma: tipoEnsinoTurma,
                                numTipoEnsino: numTipoEnsino
                            },

                            success: function(ultimoId)
                            {
                                if (ultimoId['mensagem'] == 'ok')
                                {
                                    console.log("Turma criada com sucesso. Último ID: " + ultimoId['ultimoID']);
                                    apresentaMensagemSucesso("cadastrada"); 

                                    $("#tipoEnsinoTurma").val(0);
                                    $("#siglaTurma").val("");
                                    $("#turno").val(0);
                                    $("#capacidadeFisica").val("");

                                    var descricaoTurma = nomeTurma + " " + sigla + " - " + turno;
                                    sessionStorage.setItem('descrTurmaAlterarMatricula', descricaoTurma);
                                    sessionStorage.setItem('tipoEnsinoAlterarMatricula', tipoEnsinoTurma);
                                }
                                else {
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

                            error: function(response)
                            {
                                console.log(response);
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
                        });
                    }
                    else 
                    {
                        mensagemErro('Para salvar você deve informar a <b>capacidade da sala</b>')
                    }
                } 
                else 
                {
                    mensagemErro('Para salvar você deve selecionar o <b>turno</b>')
                }
            }
            else 
            {
                mensagemErro('Para salvar você deve informar o <b>Ano Letivo</b>')
            } 
        }
        else 
        {
            mensagemErro('Para salvar você deve digitar uma <b>Sigla</b')
        }             
    }
    else 
    {
        mensagemErro('Para salvar você deve selecionar o <b>tipo de ensino</b>')
    }   
}

function mensagemErro(mensagem)
{
    Swal.fire({
        type: 'warning',
        title: 'Ops..',
        html: mensagem,
        animation: false,
        customClass: {
            popup: 'animated tada'
        }
    })
}

function alterarTurma() {
    console.log("cliquei em alterar turma");
    var idTurma = $("#idTurma").val();
    var tipoEnsino = $("#tipoEnsinoTurma option:selected").text();
    var numTipoEnsino = $("#tipoEnsinoTurma").val();
    var sigla = $("#siglaTurma").val();
    var anoLetivo = $("#anoLetivo").val();
    var turno = $("#turno").val();
    var capacidade = $("#capacidadeFisica").val();

    var dadosTurma = tipoEnsino.split("-");
    var nomeTurma = dadosTurma[0];
    var tipoEnsinoTurma = dadosTurma[1];

    if (tipoEnsino != 'Selecione...') {
        if (sigla != "") {
            if (anoLetivo != "") {
                if (turno != 0) {
                    if (capacidade != "") {
                        $.ajax({
                            url: 'turma-alterar-post.php',
                            method: 'post',
                            dataType: 'json',
                            data: {
                                idTurma: idTurma,
                                nomeTurma: nomeTurma,
                                sigla: sigla,
                                anoLetivo: anoLetivo,
                                turno: turno,
                                capacidade: capacidade,
                                tipoEnsinoTurma: tipoEnsinoTurma,
                                numTipoEnsino: numTipoEnsino
                            },

                            success: function (ultimoId) {
                                if (ultimoId['mensagem'] == 'ok') {
                                    apresentaMensagemSucesso("alterada");

                                    var descricaoTurma = nomeTurma + " " + sigla + " - " + turno;
                                    sessionStorage.setItem('descrTurmaAlterarMatricula', descricaoTurma);
                                    sessionStorage.setItem('tipoEnsinoAlterarMatricula', tipoEnsinoTurma);
                                    
                                }
                                else {
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

                            error: function (response) {
                                console.log(response);
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
                        });
                    }
                    else {
                        mensagemErro('Para salvar você deve informar a <b>capacidade da sala</b>')
                    }
                }
                else {
                    mensagemErro('Para salvar você deve selecionar o <b>turno</b>')
                }
            }
            else {
                mensagemErro('Para salvar você deve informar o <b>Ano Letivo</b>')
            }
        }
        else {
            mensagemErro('Para salvar você deve digitar uma <b>Sigla</b')
        }
    }
    else {
        mensagemErro('Para salvar você deve selecionar o <b>tipo de ensino</b>')
    }
}


function apresentaMensagemSucesso(texto)
{
    //console.log("Disciplina criada com sucesso. Último ID: " + ultimoId['ultimoID']);

    if (texto == "alterada")
    {
        Swal.fire({
            type: 'success',
            title: 'Concluído',
            text: 'Turma ' + texto + ' com sucesso!',
            animation: true,
            customClass: {
                popup: 'animated bounce'
            }
        }).then(function () {
            location.reload();
        });
    }
    else
    {
        Swal.fire({
            type: 'success',
            title: 'Concluído',
            text: 'Turma ' + texto + ' com sucesso!',
            animation: true,
            customClass: {
                popup: 'animated bounce'
            }
        })
    }
    
}
