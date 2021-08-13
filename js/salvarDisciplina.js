$(function() {
    $("#botao-salvar-disciplina").on("click", salvaDisciplina);
});


function salvaDisciplina() 
{
    var nome = $("#nomeDisciplina").val();
        
    if (nome != '')
    { 
        $.ajax({
            url: 'disciplina-criar-post.php',
            method: 'post',
            dataType: 'json',
            data:{
                nome:nome, 
            },

            success: function(ultimoId)
            {
                if (ultimoId['mensagem'] == 'ok') 
                {
                    console.log(ultimoId);
                    
                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Disciplina cadastrada com sucesso!',
                        animation: true,
                        customClass: {
                            popup: 'animated bounce'
                        }                      
                    })
                    $('#nomeDisciplina').val("");
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
                    title: 'Erro ao cadastrar a Disciplina',
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

