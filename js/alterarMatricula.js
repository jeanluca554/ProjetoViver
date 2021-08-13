$(function() {
    $(document).on('shown.bs.modal', '#MatriculaAlterarModal', function (event) {
        $('.modal').css('overflow-y', 'auto');

    });
    $("#botao-alterar-matricula").on('click', alterarMatricula);
});


function setDadosAlterarMatricula(tipoEnsino, descricao, id, situacao, idTurma, dataMatricula) 
{
    $('#ModalAlunoFormulario').modal('toggle');
    var nome = sessionStorage.getItem('alunoNomeAlterarMatricula');
    var dataNascimento = sessionStorage.getItem('alunoNascimentoAlterarMatricula');

    $("#nomeAlterarMatricula").val(nome);
    $("#idAlterarMatricula").val(id);
    $("#idTurmaMatricula").val(idTurma);
    $("#situacaoAtualMatricula").val(situacao);
    $("#dataAlterarMatricula").val(dataNascimento);
    $("#tipoEnsinoAlterarMatricula").val(tipoEnsino);
    $("#turmaAlterarMatricula").val(descricao);
    $("#dataInicioMatricula").val(dataMatricula);
}


function alterarMatricula()
{

    var movimentacao = $("#tipoMovimentacao option:selected").text();
    var dataAlteracao = $("#dataAlteracaoMatricula").val();
    var idMatricula = $("#idAlterarMatricula").val();
    var situacao = $("#situacaoAtualMatricula").val();
    var idTurma = $("#idTurmaMatricula").val();
    var dataInicioMatricula = $("#dataInicioMatricula").val();

    console.log(movimentacao, dataAlteracao, idMatricula);


    partesDataMatricula = dataInicioMatricula.split("/");
    partesDataFim = dataAlteracao.split("/");

    var data1 = new Date(partesDataMatricula[2], partesDataMatricula[1] - 1, partesDataMatricula[0]);
    var data2 = new Date(partesDataFim[2], partesDataFim[1] - 1, partesDataFim[0]);
        
    if (movimentacao != 'Selecione...')
    { 
        if (data1 <= data2)
        {
            $.ajax({
                url: 'matricula-alterar-post.php',
                method: 'post',
                dataType: 'json',
                data:{
                    movimentacao: movimentacao,
                    dataAlteracao: dataAlteracao,
                    idMatricula: idMatricula
                },

                success: function(ultimoId)
                {
                    if (ultimoId['mensagem'] == 'ok') 
                    {
                        if (situacao == "Ativo")
                        {
                            $.ajax({
                                url: 'turma-adiciona-aluno-ativo.php',
                                method: 'post',
                                dataType: 'json',
                                data: { turmaVal: idTurma, acao: "-" },

                                success: function (ultimoId) {
                                    if (ultimoId['mensagem'] == 'ok') {
                                        console.log("Mais um aluno ativo adicionado");
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
                            })
                        }
                        
                        Swal.fire({
                            type: 'success',
                            title: 'Concluído',
                            text: 'Matrícula alterada com sucesso!',
                            animation: true,
                            customClass: {
                                popup: 'animated bounce'
                            }                      
                        }).then( function() {

                        });
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
                    console.log(response)
                    Swal.fire({
                        type: 'warning',
                        title: 'Erro ao alterar a Matrícula',
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
            mensagemErro('A Data da movimentação <b>não pode ser menor</b> que a data da Matrícula')
        } 
    }  
    else 
    {
        mensagemErro('Para salvar você deve selecionar o <b>tipo de Movimentação</b>')
    }    
}

function mensagemErro(mensagem) {
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
