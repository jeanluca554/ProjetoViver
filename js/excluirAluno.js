$(function() {
    
    
});

function excluirDadosAluno(id) 
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
        text: "Tem certeza que deseja excluir o aluno?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) 
        {

            $.ajax({
                url: 'DAO/banco-responsaveis-post.php',
                method: 'post',
                dataType: 'json',
                data: {
                    id: id,
                    funcao: 5,
                },

                success: function (response) {

                    swalWithBootstrapButtons.fire(
                        'Excluído!',
                        'Os responsáveis foram desvinculados com sucesso',
                        'success'
                    )

                    // excluirAluno(id);
                    $.ajax({
                        url: 'DAO/banco-alunos-post.php',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            id: idExcluir,
                            funcao: 3,
                        },

                        success: function (response) {
                            swalWithBootstrapButtons.fire(
                                'Excluído!',
                                'O aluno foi excluído com sucesso',
                                'success'
                            ).then((result) => {
                                removerLinhaAluno(idExcluir);
                            })
                        },

                        error: function (response) {
                            console.log(response['message']);
                            Swal.fire({
                                type: 'warning',
                                title: 'Algo errado aconteceu',
                                text: response['message'],
                                animation: false,
                                customClass: {
                                    popup: 'animated tada'
                                }
                            })
                        }

                    });


                    

                },

                /* error: function (XMLHttpRequest, textStatus, errorThrown) {
                    for (i in XMLHttpRequest) {
                        if (i != "channel")
                            document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                    }
                } */
                error: function (response) {
                    swalWithBootstrapButtons.fire(
                        'ERRO',
                        // 'Houve um erro ao desvincular os responsáveis do aluno',
                        response['message'],
                        'error'
                    )
                }
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'O aluno não foi excluído',
                'error'
            )
        }
    })    
}

function buscarEExcluirResponsaveisVinculados(id)
{
    $.ajax({
        url: 'DAO/banco-responsaveis-post.php',
        method: 'post',
        dataType: 'json',
        data: {
            id: id,
            funcao: 5,
        },

        success: function (response) {
            
            swalWithBootstrapButtons.fire(
                'Excluído!',
                'Os responsáveis foram desvinculados com sucesso',
                'success'
            )
            // excluirAluno(id);
            
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
                text: response['text'],
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        } */
    });
}

function excluirAluno(id)
{
    var idExcluir = id;
    $.ajax({
        url: 'DAO/banco-alunos-post.php',
        method: 'post',
        dataType: 'json',
        data: {
            id: idExcluir,
            funcao: 3,
        },

        success: function (response) {

            
            swalWithBootstrapButtons.fire(
                'Excluído!',
                'O aluno foi excluído com sucesso',
                'success'
            )

        },

        error: function (XMLHttpRequest, textStatus, errorThrown) {
            for (i in XMLHttpRequest) {
                if (i != "channel")
                    document.write(i + " : " + XMLHttpRequest[i] + "<br>")
            }
        }
        
    });
    removerLinha(idExcluir);

}

function removerLinhaAluno(id) {
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#"+id).parent().parent();
    console.log(linha);
    console.log("Loucura jovaem");

    linha.fadeOut(1000);
    setTimeout(function () {
        linha.remove();
    }, 1000);
    setTimeout(function () {
        location.reload();
    }, 1000);

}