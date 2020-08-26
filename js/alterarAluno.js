$(function () {
    $("#botao-alterar-aluno").click(alterarDadosAluno);
    $("#botao-salvar-endereco-aluno").click(salvaEnderecoAluno);
    //$("#parentesco438.024.498-94").onchange="salvarResponsavelDoAluno(438.024.498-94)";
});

function alterarDadosAluno() {
    var nome = $("#nomeAluno").val();
    var dataNascimento = $("#dataNascimento").val();
    var sexo = $("#sexo").val();
    var nacionalidade = $("#nacionalidade").val();
    var estado = $("#selectEstadoNascimento").val();
    var cidade = $("#selectCidadeNascimento").val();
    var pais = $("#paisOrigem").val();
    var id = parseInt(sessionStorage.getItem('alunoAlterando'));
    console.log(id);

    if (nome != '') {
        $.ajax({
            url: 'aluno-alterar-post.php',
            method: 'post',
            dataType: 'json',
            data: {
                id: id,
                nome: nome,
                dataNascimento: dataNascimento,
                sexo: sexo,
                nacionalidade: nacionalidade,
                estado: estado,
                cidade: cidade,
                pais: pais
            },

            success: function (response) {
                if (response['mensagem'] == 'ok') {

                    Swal.fire({
                        type: 'success',
                        title: 'Concluído',
                        text: 'Dados pessoais alterados com sucesso!',
                        animation: true,
                        customClass: {
                            popup: 'animated bounce'
                        }
                    })
                }
                else {
                    Swal.fire({
                        type: 'warning',
                        title: response['title'],
                        text: response['text'],
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
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
                    title: 'mensagem',
                    text: response['text'],
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
    }
}