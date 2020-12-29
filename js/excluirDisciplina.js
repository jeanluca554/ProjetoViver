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



function removerLinhaAluno(id) 
{
    event.preventDefault();// evitar o evento padrão de jogar pro topo da tela ao excluir
    var linha = $("#"+id).parent().parent();
    console.log(linha);
    console.log("Loucura jovaem");

    linha.fadeOut(1000);
    setTimeout(function () 
    {
        linha.remove();
    }, 1000);
    setTimeout(function () 
    {
        location.reload();
    }, 1000);

}