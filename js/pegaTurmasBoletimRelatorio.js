$(function() {
    selecionaTurma();
    
});

function selecionaTurma()
{
    $("#tipoEnsinoBoletimRelatorio").on("change", function()
    {
        var anoBoletimRelatorio = $("#anoLetivoBoletimRelatorio").val();
        var tipoEnsinoBoletimRelatorioNume = $("#tipoEnsinoBoletimRelatorio").val();
        var tipoEnsinoBoletimRelatorioNome = $("#tipoEnsinoBoletimRelatorio option:selected").text();
        // console.log(tipoEnsinoNume);
        // console.log(tipoEnsinoNome);
        // console.log(anoAssociarProf);

        $(".tabelaTurmasBoletimRelatorio > tbody").empty();

        $.ajax({
            url: 'turmas-listar-boletim-relatorio.php',
            method: 'post',
            dataType: 'json',
            data: { 
                tipoEnsino: tipoEnsinoBoletimRelatorioNome, 
                ano: anoBoletimRelatorio
                },

            success: function (response) {
                if (response['mensagem'] == 'ok') 
                {
                    console.log(response);


                    // for (var i = 0; i < response['turmas'].length; i++) 
                    // {
                    //     console.log(response[i]);
                    // }

                    var turmas = response['turmas'];

                    $.each(turmas, function (key, value) {
                        var corpoTabela = $(".tabelaTurmasBoletimRelatorio").find("tbody");
                        var ano = value['ano'];
                        var idTurma = value["id_turma"];
                        var nomeTurma = value["nome_turma"] + " " + value["sigla"];
                        var tipoEnsino = value["tipo_ensino_turma"];
                        var turno = value["turno"];
                        var idMatrizCurricular = value["num_ensino_turma"];

                        console.log(ano, idTurma, nomeTurma, tipoEnsino, turno)

                        var linha = novaLinhaTabelaTurmasBoletimRelatorio(ano, idTurma, nomeTurma, tipoEnsino, turno, idMatrizCurricular);

                        corpoTabela.append(linha);
                        // materiasSession.push(idMateria)
                    })
                    // console.log(materiasSession);
                    // sessionStorage.setItem('disciplinas', materiasSession);
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

            error: function (response) {
                console.log(response);
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
        })







               

        // 

    })
}

function novaLinhaTabelaTurmasBoletimRelatorio(ano, idTurma, nomeTurma, tipoEnsino, turno, idMatrizCurricular)
{
    var linha = $("<tr>");
    var colunaAno = $("<td>").text(ano).attr("class", "text-center");
    var colunaNome = $("<td>").text(nomeTurma).attr("class", "text-center");
    var colunaTurno = $("<td>").text(turno).attr("class", "text-center");
    var colunaTipoEnsino = $("<td>").text(tipoEnsino).attr("class", "text-center");

    var colunaEditar = $("<td>").attr({
        'align': "center",
        'id': "btnEditarVinculo",
        'data-idturma': idTurma,
        'data-toggle': "modal",
        'data-target': "#BoletimRelatorioModal",
        'onclick': "setBoletimRelatorio(" + idTurma + ")"
    });
    var botaoEditar = $("<a>").addClass("btn btn-outline-info").attr("href", "#");
    var imagemEditar = $("<img>").attr("src", "img/visualizar.png");
    botaoEditar.append(imagemEditar);
    colunaEditar.append(botaoEditar);

    linha.append(colunaAno);
    linha.append(colunaNome);
    linha.append(colunaTurno);
    linha.append(colunaTipoEnsino);
    linha.append(colunaEditar);

    return linha;
}

