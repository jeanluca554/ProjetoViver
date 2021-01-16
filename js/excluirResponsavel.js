$(function() {
    
    
});

function excluirResponsavel(idAluno, cpf, idRespPeloAluno) 
{
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
        text: "Tem certeza que deseja excluir o Responsável?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, remover!',
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
                    idAluno: idAluno,
                    cpf: cpf,
                    idRespPeloAluno: idRespPeloAluno,
                    funcao: 8,
                },

                success: function (response) {
                    if (response['resultado'] == "Erro")
                    {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            response['mensagem'],
                            'error'
                        )
                    }
                    else
                    {
                        if (response['resultado'] == "Ok")
                        {
                            swalWithBootstrapButtons.fire(
                                'Removido!',
                                'O responsável foi desvinculado com sucesso!',
                                'success'
                            ).then((result) => 
                            {
                                cpfSemPonto = cpf.replace(".", "");
                                cpfSemPonto = cpfSemPonto.replace(".", "");
                                cpfSemTraco = cpfSemPonto.replace("-", "");
                                removerLinha(cpfSemTraco);

                                //remove do select ao excluir o responsável
                                var optSelectFinanceiro = "#selectResponsavelFinanceiro option[value='" + cpf + "']";
                                var optSelectDidatico = "#selectResponsavelDidatico option[value='" + cpf + "']";
                                $(optSelectFinanceiro).remove();
                                $(optSelectDidatico).remove();
                            })
                        }
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
                        title: response['resultado'],
                        // text: response['mensagem'],
                        text: "Erro",
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
                'O responsável não foi removido',
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
            excluirAluno(id);
            
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
    removerLinha(id);
    $.ajax({
        url: 'DAO/banco-alunos-post.php',
        method: 'post',
        dataType: 'json',
        data: {
            id: id,
            funcao: 3,
        },

        /* success: function (response) {
            
        },

        error: function (XMLHttpRequest, textStatus, errorThrown) {
            for (i in XMLHttpRequest) {
                if (i != "channel")
                    document.write(i + " : " + XMLHttpRequest[i] + "<br>")
            }
        } */
        
    });
}

function removerLinha(id) {
    cpf = id;
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#btnExcluir"+cpf).parent().parent();

    linha.fadeOut(1000);
    setTimeout(function () {
        linha.remove();
    }, 1000);
}