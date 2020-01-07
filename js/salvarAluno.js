$(function() {
    //$("#botao-salvar-dados-pessoais-alunolkjçlkjçlkj").click(coisonaMaluca);
});

function salvaDadosPessoaisAluno() 
{
    var nome = $("#nomeAluno").val();
    var nascimentinho = 12112010;
    //var dataNascimento = $("#dataNascimento").val();
    //var nascimento = dataNascimento.replace("/","-");
    //console.log(nascimento);
    var sexo = $("#sexo").text();
    var nacionalidade = $("#nacionalidade").val();
    var estado = $("#selectEstadoNascimento").val();
    var cidade = $("#selectCidadeNascimento").val();
    var pais = $("#paisOrigem").val();
    ultimoIdLimpo = 0;
        
    if (nome != '')
    {
        $.ajax({
            url: 'aluno-criar-post.php',
            method: 'post',
            dataType: 'json',
            data:{nome:nome, dataNascimento:nascimentinho, sexo:sexo, nacionalidade:nacionalidade, estado:estado, cidade:cidade, pais:pais},

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

            error: function()
            {
                alert("Erro ao criar Responsável");
            }
        });
    }    
}

function salvaTesteTeste() 
{
    var nome = $("#nomeAluno").val();
    var nascimentinho = 12112010;
    //var dataNascimento = $("#dataNascimento").val();
    //var nascimento = dataNascimento.replace("/","-");
    //console.log(nascimento);
    var sexo = $("#sexo").text();
    var nacionalidade = $("#nacionalidade").val();
    var estado = $("#selectEstadoNascimento").val();
    var cidade = $("#selectCidadeNascimento").val();
    var pais = $("#paisOrigem").val();
    ultimoIdLimpo = 0;
        
    if (nome != '')
    {
        $.ajax({
            url: 'aluno-criar-post.php',
            method: 'post',
            dataType: 'json',
            data:{nome:nome, dataNascimento:nascimentinho, sexo:sexo, nacionalidade:nacionalidade, estado:estado, cidade:cidade, pais:pais},

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

            error: function()
            {
                alert("Erro ao criar Responsável");
            }
        });
    }    
}
