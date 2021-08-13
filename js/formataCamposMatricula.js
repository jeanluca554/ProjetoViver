$(function() {    
    $('#anoLetivoMatricula').on("change", setSelectTipoEnsino);
    $('#tipoEnsinoMatricula').on("change", setSelectTurmas);
    $('#btnNovaMatricula').on("click", formatarCamposAluno);
    $('#btnNovaMatricula').on("click", formatarCamposAluno);
});


function formataCamposAluno()
{
    setDataAtualMatricula();
    setSelectTipoEnsino();
}

function setDataAtualMatricula() {
    $(document).on('shown.bs.modal', '#NovaMatriculaModal', function (event) 
    {
        $('#NovaMatriculaModal').css('overflow-y', 'auto');
        console.log('clicou no botão Nova Matrícula')
        $('#dataMatricula').mask('00/00/0000');
        $('#tipoEnsinoMatricula').attr('option value', 0);
        $('#selectTurmasMatricula').val('');
        $("#selectTurmasMatricula").attr('disabled', 'disabled');
    });
    
}

function setSelectTipoEnsino() {
    console.log('entrou na função alterar campos matrícula')
    $("#tipoEnsinoMatricula").val(0);
    $("#selectTurmasMatricula").text('');
    $("#selectTurmasMatricula").attr('disabled', 'disabled');
}

function setSelectTurmas()
{
    var anoLetivoMat = $('#anoLetivoMatricula').val();
    var tipoEnsino = $("#tipoEnsinoMatricula option:selected").text();

    console.log(tipoEnsino);

    $.ajax({
        url: 'turmas-matricula-listar-post.php',
        method: 'post',
        dataType: 'json',
        data: {
            ano: anoLetivoMat,
            tipo: tipoEnsino
        },

        success: function (response) {
            if (response['mensagem'] == 'ok') 
            {
                var turmas = response['turmas'];
                insereSelectTurmas(turmas);
                $("#selectTurmasMatricula").attr('disabled', false);
            }
            else {
                console.log(response);
                Swal.fire({
                    type: 'warning',
                    title: 'erro',
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
       }  */
        error: function (response) {
            Swal.fire({
                type: 'warning',
                title: 'Algo errado aconteceu',
                text: response['Erro ao alterar o endereço do aluno'],
                //text: response['text'],
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
}

function insereSelectTurmas(response) {
    $("#selectTurmasMatricula").empty();
    if (response.length > 0)
    {
        $.each(response, function (key, value) {
            var nomeTurma = value['nome_turma'];
            var sigla = value["sigla"];
            var turno = value["turno"];
            var idTurma = value["id_turma"];
            var capacidade = value["capacidade"];
            var alunosAtivos = value["alunos_ativos"];

            var vagas = capacidade - alunosAtivos;
            var textoVagas = "";

            vagas == 1 ? textoVagas = "vaga disponível" : textoVagas = "vagas disponíveis";
            vagas == 0 ? textoVagas = "não há vagas" : console.log("não há vagas");

            var turmaCompleta = nomeTurma + " " + sigla + " - " + turno + " (" + vagas + " " + textoVagas + ")";

            var option = $("<option>").attr("value", idTurma).text(turmaCompleta);

            $("#selectTurmasMatricula").append(option);
        })
    }
    else
    {
        var turmaCompleta = "Não existem turmas no Ano e Ensino selecionados";

        var option = $("<option>").attr("value", 0).text(turmaCompleta);
        $("#selectTurmasMatricula").append(option);
    }
    
    
}

