$(function() {
    $("#botao-alterar-vinculo-professor").on("click", alterarVinculo);
});


function alterarVinculo() 
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
        text: "Tem certeza que deseja vincular o professor à essa matéria?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, vincular!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) 
        {
            var idMatriz = sessionStorage.getItem("idMatriz");
            var idTurma = sessionStorage.getItem("idTurmaVinculo");
            var idDisciplina = $("#alterarVinculoDisciplina").val();
            var idProfessor = $("#alterarVinculoProfessor").val();
                
            $.ajax({
                url: 'DAO/banco-professor-associado-alterar.php',
                method: 'post',
                dataType: 'json',
                data:{
                    idTurma: idTurma,
                    idDisciplina: idDisciplina,
                    idProfessor: idProfessor
                },

                success: function(ultimoId)
                {
                    if (ultimoId['mensagem'] != 'erro') 
                    {
                        console.log("ultimo ID alterado: " + ultimoId);
                        
                        Swal.fire({
                            type: 'success',
                            title: 'Concluído',
                            text: 'O professor foi vinculado à disciplina com sucesso!',
                            animation: true,
                            customClass: {
                                popup: 'animated bounce'
                            }                      
                        }).then( function() {
                            // location.reload();
                            setAssociacao(idMatriz, idTurma);
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

                error: function(ultimoId)
                {
                    console.log(ultimoId);
                    Swal.fire({
                        type: 'warning',
                        title: 'Erro ao vincular o professor à disciplina',
                        text: ultimoId,
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
                }
            });   
        } 
        else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'O professro não foi viculado',
                'error'
            )
        }
    })   
}
