$(function () {
    $("#matricularAluno-tab").on("click", buscaMatriculasDoAluno);
    //$("#btnAdicionaResponsavel").click(buscaResponsaveisVinculadosAoAluno); 
});

function buscaMatriculasDoAluno() {
    var idDoAluno = sessionStorage.getItem('alunoID');
    console.log(idDoAluno);
    if (idDoAluno != null) {
        $.ajax({
            url: 'matriculas-listar-post.php',
            dataType: 'json',
            method: 'post',
            data: {
                idAluno: idDoAluno
            },

            success: function (response) {

                if (response['mensagem'] == 'ok') {
                    $(".tabelaMatriculas > tbody").empty();
                    insereMatriculasNaTabela(response);
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
            error: function (jqXHR, status, error) {
                //alert('Ocorreu durante a execução do filtro. Tente novamente mais tarde!');
                console.log(jqXHR.responseText, status, error);
            }
            /* error: function (response) {
                console.log(response);
                Swal.fire({
                    type: 'warning',
                    title: 'Algo errado aconteceu',
                    text: 'Erro ao buscar as matrículas do aluno',
                    //  text: response['message'],
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            } */
        });
    }


}

function insereMatriculasNaTabela(response) {
    $.each(response['matriculas'], function (key, value) {
        var corpoTabela = $(".tabelaMatriculas").find("tbody");

        var idMatricula = value['id_matricula'];
        var ano = value['ano'];
        var tipoEnsino = value['tipo_ensino_turma'];
        var nomeTurma = value['nome_turma'];
        var sigla = value['sigla'];
        var dataMatricula = value['data_matricula'];
        var dataFim = value['data_fim_matricula'];
        var situacao = value['situacao'];
        var turno = value['turno'];
        var idTurma = value['id_turma'];

        var dataMatriculaFormatada = trataDataMatricula(dataMatricula);

        if (dataFim != null) {
            var dataFimFormatada = trataDataMatricula(dataFim);
        }

        var nomeTurmaCompleto = nomeTurma + " " + sigla;

        var linha = novaLinhaMatriculas(idMatricula, ano, tipoEnsino, nomeTurmaCompleto, dataMatriculaFormatada, dataFimFormatada, situacao, turno, idTurma);

        corpoTabela.append(linha);
    })
}

function novaLinhaMatriculas(id, ano, tipoEnsino, nomeTurma, dataMatricula, dataFim, situacao, turno, idTurma) {
    var linha = $("<tr>");
    var colunaAno = $("<td>").text(ano).attr({ "class": "align-middle", "align": "center" });
    var colunaTipoEnsino = $("<td>").text(tipoEnsino).attr({ "class": "align-middle", "align": "center" });
    var colunaTurma = $("<td>").text(nomeTurma).attr({ "class": "align-middle", "align": "center" });
    var colunaDataMatricula = $("<td>").text(dataMatricula).attr({ "class": "align-middle", "align": "center" });
    var colunaDataFim = $("<td>").text(dataFim).attr({ "class": "align-middle", "align": "center" });
    var colunaSituacao = $("<td>").text(situacao).attr({ "class": "align-middle", "align": "center" });

    //Criação da coluna Alterar:
    var descricaoTurma = nomeTurma + " - " + turno;
    sessionStorage.setItem('descrTurmaAlterarMatricula', descricaoTurma);
    sessionStorage.setItem('tipoEnsinoAlterarMatricula', tipoEnsino);

    var dadosAlterar = "setDadosAlterarMatricula('" + tipoEnsino + "', '" + descricaoTurma + "', " + id + ", '" + situacao + "', " + idTurma + ", '" + dataMatricula + "')";
    var colunaAlterar = $("<td>").attr({
        'id': "btnAlterarMatricula",
        'align': "center",
        'data-id': id,
        'data-ano': ano,
        'data-toggle': "modal",
        'data-target': "#MatriculaAlterarModal",
        'onclick': dadosAlterar
        // 'onclick': "($('#MatriculaAlterarModal').modal('show'))"
    });
    var botaoEditar = $("<a>").addClass("btn btn-outline-info").attr({ "href": "#" });
    var imagemEditar = $("<img>").attr("src", "img/editar.png");
    botaoEditar.append(imagemEditar);
    colunaAlterar.append(botaoEditar);


    var colunaRemover = $("<td>").attr("align", "center");
    var botaoRemover = $("<button>")
        .addClass("btn btn-outline-danger")
        .attr({
            'id': "btnExcluirMatricula" + id,
            'onclick': "excluirMatricula(" + id + ", '" + situacao + "', " + idTurma + ")"
        });
    var imagemRemover = $("<img>").attr("src", "img/menos-25.png");
    botaoRemover.append(imagemRemover);
    colunaRemover.append(botaoRemover);

    linha.append(colunaAno);
    linha.append(colunaTipoEnsino);
    linha.append(colunaTurma);
    linha.append(colunaDataMatricula);
    linha.append(colunaDataFim);
    linha.append(colunaSituacao);
    linha.append(colunaAlterar);
    linha.append(colunaRemover);

    return linha;

}

$('#matricularAluno-tab').on('hidden.bs.modal', function () {

    buscaResponsaveisVinculadosAoAluno();
});

function trataDataMatricula(date) {
    dataArray = date.split("-");
    dataInvertida = dataArray.reverse();
    dataCorrigida = dataInvertida.join('/');
    return dataCorrigida;
}