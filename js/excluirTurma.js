$(function() {
    
    
});

function excluirTurma(id, alunos) 
{
    var idExcluir = id;
    var qtdAlunos = alunos

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
        text: "Tem certeza que deseja excluir essa Turma?",
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
                url: 'turma-excluir-post.php',
                method: 'post',
                dataType: 'json',
                data: 
                {
                    id: idExcluir,
                    alunos: qtdAlunos
                },

                success: function (response) 
                {
                    if (response['mensagem'] == "ok")
                    {
                        var mensagem = response['text'];
                        swalWithBootstrapButtons.fire(
                            'Excluído!',
                            mensagem,
                            'success'
                        ).then((result) => {
                            removerLinhaTurma(id);
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
                        title: 'Erro ao remover as disciplinas da Matriz',
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
                'A Turma não foi excluída',
                'error'
            )
        }
                    
    })    
}



function removerLinhaTurma(id) 
{
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#btnExcluirTurma" + id).parent().parent();

    linha.fadeOut(1000);
    setTimeout(function () {
        linha.remove();
    }, 1000);
}