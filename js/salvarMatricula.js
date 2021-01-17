$(function() {
    $("#botao-salvar-matricula").on("click", salvaMatricula);
});

function salvaMatricula() 
{
    var anoLetivo = $("#anoLetivoMatricula").val();
    var tipoEnsinoMatriculaText = $("#tipoEnsinoMatricula option:selected").text();
    var tipoEnsinoMatriculaVal = $("#tipoEnsinoMatricula").val();
    var turmaText = $("#selectTurmasMatricula option:selected").text();
    var turmaVal = $("#selectTurmasMatricula").val();
    var dataMatricula = $("#dataMatricula").val();

    
    var idAluno = sessionStorage.getItem('alunoID');

    console.log(anoLetivo) 
    console.log(tipoEnsinoMatriculaText, tipoEnsinoMatriculaVal) 
    console.log(turmaText, turmaVal) 
    console.log(dataMatricula) 

    var capacidadeTurma = turmaText.indexOf("não há vagas");

    var turmaTextVerificada = turmaText.indexOf("Não existem turmas");

    console.log(idAluno);
    
    if (tipoEnsinoMatriculaVal != 0)
    {
        if (turmaTextVerificada <= -1)// verifica se existe turma válida
        {
            if (capacidadeTurma <= -1)// verifica se existe turma válida
            {
                $.ajax({
                    url: 'matricula-criar-post.php',
                    method: 'post',
                    dataType: 'json',
                    data:{
                        tipoEnsinoVal: tipoEnsinoMatriculaVal,
                        turmaVal: turmaVal,
                        dataMatricula: dataMatricula,
                        idAluno: idAluno
                    },

                    success: function(ultimoId)
                    {
                        if (ultimoId['mensagem'] == 'ok')
                        {
                            console.log("matricula criada com sucesso. Último ID: " + ultimoId['ultimoID']);
                            apresentaMensagemSucesso("realizada"); 

                            $("#tipoEnsinoTurma").val(0);
                            $("#siglaTurma").val("");
                            $("#turno").val(0);
                            $("#capacidadeFisica").val("");
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
                mensagemErro('Para matricular o aluno você deve selecionar uma <b>turma com vagas disponíveis</b>')
            }
        } 
        else 
        {
            mensagemErro('Para salvar você deve selecionar uma <b>Turma válida</b>')
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

function apresentaMensagemSucesso(texto)
{
    //console.log("Disciplina criada com sucesso. Último ID: " + ultimoId['ultimoID']);

    if (texto == "alterada")
    {
        Swal.fire({
            type: 'success',
            title: 'Concluído',
            text: 'Matrícula ' + texto + ' com sucesso!',
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
            text: 'Matrícula ' + texto + ' com sucesso!',
            animation: true,
            customClass: {
                popup: 'animated bounce'
            }
        }).then(function () {
            $('#NovaMatriculaModal').modal('hide');
        });
    }
}