$(function() {
    
    
});

function excluirDadosAluno(id) 
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
        text: "Tem certeza que deseja excluir o aluno?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) 
        {
            buscarEExcluirResponsaveisVinculados(id);

            swalWithBootstrapButtons.fire(
                'Excluído!',
                'O aluno foi excluído com sucesso',
                'success'
            )
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
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#"+id).parent().parent();

    linha.fadeOut(1000);
    setTimeout(function () {
        linha.remove();
    }, 1000);
}