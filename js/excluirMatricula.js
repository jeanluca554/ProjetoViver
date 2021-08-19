$(function() {
    
    
});

function excluirMatricula(id, situacao, idTurma) 
{
    var idExcluirMatricula = id;
    var idExcluirTurma = idTurma;
    var situacaoMatricula = situacao;

    const swalWithBootstrapButtons = Swal.mixin(
    {
        customClass: 
        {
            confirmButton: 'btn btn-success btn-lg',
            cancelButton: 'btn btn-danger btn-lg mr-3'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Atenção!',
        text: "Tem certeza que deseja excluir essa Matrícula?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => 
    {
        if (result.value) 
        {
            $.ajax({
                url: 'matricula-excluir-post.php',
                method: 'post',
                dataType: 'json',
                data: 
                {
                    id: idExcluirMatricula
                },

                success: function (response) 
                {
                    if (response['mensagem'] == "ok")
                    {
                        if (situacaoMatricula == "Ativo") {
                            $.ajax({
                                url: 'turma-adiciona-aluno-ativo.php',
                                method: 'post',
                                dataType: 'json',
                                data: { turmaVal: idExcluirTurma, acao: "-" },

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
                        
                        
                        
                        var mensagem = response['text'];
                        swalWithBootstrapButtons.fire(
                            'Excluído!',
                            mensagem,
                            'success'
                        ).then((result) => {
                            removerLinhaMatricula(id);
                        })
                    }
                    else 
                    {
                        console.log(response)
                        Swal.fire({
                            type: 'warning',
                            title: 'Atenção',
                            text: response['text'],
                            animation: false,
                            customClass: {
                                popup: 'animated tada'
                            }
                        })
                    }
                },
                error: function (response) {
                    console.log(response)
                    Swal.fire({
                        type: 'warning',
                        title: 'Erro ao remover Matrícula',
                        text: response,
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
                }
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'A Matrícula não foi excluída',
                'error'
            )
        }
                    
    })    
}



function removerLinhaMatricula(id) 
{
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#btnExcluirMatricula" + id).parent().parent();

    linha.fadeOut(1000);
    setTimeout(function () {
        linha.remove();
    }, 1000);
}