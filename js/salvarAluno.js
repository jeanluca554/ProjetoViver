$(function() {
    $("#botao-salvar-aluno").click(salvaDadosAluno);
});

function salvaDadosAluno() 
{
    var nome = $("#nomeAluno").val();
    var dataNascimento = $("#dataNascimento").val();
    var sexo = $("#sexo").val();
    var nacionalidade = $("#nacionalidade").val();
    var estado = $("#selectEstadoNascimento").val();
    var cidade = $("#selectCidadeNascimento").val();
    var pais = $("#paisOrigem").val();
    //var ultimoIdLimpo = 0;
        
    if (nome != '')
    { 
        $.ajax({
            url: 'aluno-criar-post.php',
            method: 'post',
            dataType: 'json',
            data:{nome:nome, dataNascimento:dataNascimento, sexo:sexo, nacionalidade:nacionalidade, estado:estado, cidade:cidade, pais:pais},

            success: function(ultimoId)
            {
                if(ultimoId['mensagem'] == 'ok')
                {
                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Dados pessoais cadastrados com sucesso!',
                        animation: true,
                        customClass: {
                            popup: 'animated bounce'
                        }                      
                    })
                }
                else
                {
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
                    title: 'Erro ao Salvar o Aluno',
                    text: ultimoId['text'],
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
    }    
}

function salvarResponsavelDoAluno() 
{
    var table = $(".tabelaParentesco tbody tr td").click(function() {
        alert('mudou');
    });

    table.find('tr')
}