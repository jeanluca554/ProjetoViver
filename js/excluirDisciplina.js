$(function() {
    
    
});

function excluirDisciplina(id) 
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
        text: "Tem certeza que deseja excluir a Disciplina?",
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
                url: 'disciplina-excluir-post.php',
                method: 'post',
                dataType: 'json',
                data: 
                {
                    id: id,
                },

                success: function (response) {
                    swalWithBootstrapButtons.fire(
                        'Excluído!',
                        'O aluno foi excluído com sucesso',
                        'success'
                    ).then((result) => {
                        removerLinhaAluno(id);
                    })
                },
                error: function (ultimoId) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Erro ao cadastrar a Disciplina',
                        text: ultimoId,
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



function removerLinha(idMateria, idDisciplina) 
{
    var removerLinha = sessionStorage.getItem('removeLinha');

    if (removerLinha == null) 
    {
        var disciplinas1 = [];
        var disciplinas2 = [];

        var disciplinasSession = sessionStorage.getItem('disciplinas');

        console.log("idMateria: " + idMateria);
        console.log("antes: " + disciplinasSession);
        for (var i = 0; i < disciplinasSession.length; i++) {
            if (disciplinasSession[i] == idMateria || disciplinasSession[i] == ",") {
                disciplinas1.push(disciplinasSession[i])
            }
            else {
                disciplinas2.push(disciplinasSession[i])
            }
        }
        console.log("depois1: " + disciplinas1);
        console.log("depois2: " + disciplinas2);

        removerLinhaAluno(idMateria);
    }
    else
    {
        excluirMateriaDaTabela(idMateria, idDisciplina)
    }
}

function excluirMateriaDaTabela(idDisciplina, idMatriz)
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
        text: "Tem certeza que deseja essa disciplina da tabela?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'disciplina-da-matriz-excluir-post.php',
                method: 'post',
                dataType: 'json',
                data:
                {
                    idDisciplina: idDisciplina,
                    idMatriz: idMatriz
                },

                success: function (response) 
                {
                    removerLinhaJquery(idDisciplina)
                },
                error: function (response) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Erro ao excluir a disciplina',
                        text: response['text'],
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

function excluirDisciplina(id) 
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
        text: "Tem certeza que deseja excluir a Disciplina?",
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
                url: 'disciplina-excluir-post.php',
                method: 'post',
                dataType: 'json',
                data: 
                {
                    id: id,
                },

                success: function (response) {
                    console.log(response['text'])

                    var mensagem = response['text'];

                    if (mensagem != null)
                    {
                        //Irá verificar se ao excluir apresenta o erro de Chave Estrangeira
                        var verifica = mensagem.indexOf("Integrity constraint violation: 1451")

                        if (verifica > -1) {
                            Swal.fire({
                                type: 'warning',
                                title: 'Erro ao excluir a Disciplina',
                                text: "Essa disciplina já está sendo usada e não pode ser removida",
                                animation: false,
                                customClass: {
                                    popup: 'animated tada'
                                }
                            })
                        }
                        else {
                            swalWithBootstrapButtons.fire(
                                'Excluído!',
                                'A Disciplina foi excluída com sucesso!',
                                'success'
                            ).then((result) => {
                                removerLinhaJquery(id);
                            })
                        }
                    }
                    else
                    {
                        swalWithBootstrapButtons.fire(
                            'Excluído!',
                            'A Disciplina foi excluída com sucesso!',
                            'success'
                        ).then((result) => {
                            removerLinhaJquery(id);
                        })
                    }
                    




                    
                },
                error: function (ultimoId) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Erro ao cadastrar a Disciplina',
                        text: ultimoId,
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

function removerLinhaJquery(idMateria)
{
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#btnExcluir" + idMateria).parent().parent();

    linha.fadeOut(1000);
    setTimeout(function () {
        linha.remove();
    }, 1000);
}