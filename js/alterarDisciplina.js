$(function() {
    $("#botao-alterar-disciplina").on("click", alterarDisciplina);
});


function alterarDisciplina() 
{
    var nome = $("#nomeDisciplina").val();
    var id = $("#idDisciplina").attr("data-id");
        
    if (nome != '')
    { 
        $.ajax({
            url: 'disciplina-alterar-post.php',
            method: 'post',
            dataType: 'json',
            data:{
                nome: nome,
                idDisciplina: id
            },

            success: function(ultimoId)
            {
                if (ultimoId['mensagem'] == 'ok') 
                {
                    console.log(ultimoId);
                    
                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Disciplina alterada com sucesso!',
                        animation: true,
                        customClass: {
                            popup: 'animated bounce'
                        }                      
                    }).then( function() {
                        location.reload();
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
                Swal.fire({
                    type: 'warning',
                    title: 'Erro ao alterar a Disciplina',
                    text: ultimoId,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
    }    
}
