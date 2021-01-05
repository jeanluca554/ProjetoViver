$(function() {
    
    
});

function excluirMatriz(id) 
{
    var idExcluir = id;

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
        text: "Tem certeza que deseja excluir a Matriz Curricular?",
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
                url: 'matriz-excluir-disciplinas-post.php',
                method: 'post',
                dataType: 'json',
                data: 
                {
                    id: id,
                },

                success: function (response) {
                    console.log(response['text'])
                    $.ajax({
                        url: 'matriz-excluir-post.php',
                        method: 'post',
                        dataType: 'json',
                        data:
                        {
                            id: id,
                        },

                        success: function (response) 
                        {
                            console.log(response['text']);
                            var mensagem = response['text'];
                            swalWithBootstrapButtons.fire(
                                'Excluído!',
                                mensagem,
                                'success'
                            ).then((result) => {
                                removerLinhaMatriz(id);
                            })
                        },
                        error: function (response) {
                            console.log(response)
                            Swal.fire({
                                type: 'warning',
                                title: 'Erro ao excluir a Disciplina',
                                text: response['text'],
                                animation: false,
                                customClass: {
                                    popup: 'animated tada'
                                }
                            })
                        }
                    });
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
                'A disciplina não foi excluída',
                'error'
            )
        }
                    
    })    
}



function removerLinhaMatriz(id) 
{
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#btnExcluirMatriz" + id).parent().parent();

    linha.fadeOut(1000);
    setTimeout(function () {
        linha.remove();
    }, 1000);
}