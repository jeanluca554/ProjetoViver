$(function() 
{  
    $("#bimestreBoletimRelatorio").on("change", function() {
        var bimestre = $("#bimestreBoletimRelatorio").val();
        sessionStorage.setItem("pdfBimestre", bimestre);
    })

});

function sessionPDF(idTurma, idAluno)
{
    var bimestre = $("#bimestreBoletimRelatorio").val();
    sessionStorage.setItem("pdfBimestre", bimestre);
    sessionStorage.setItem("pdfIdTurma", idTurma);
    sessionStorage.setItem("pdfIdAluno", idAluno);
}

function paralelepipedo(idTurma, idAluno)
{
    console.log('paralelepipedo')
    var bimestre = $("#bimestreBoletimRelatorio").val();
    // $(".tabelaBoletimPDF > tbody").empty();
    var corpoTabela = $(".tabelaBoletimPDF").find("tbody");
    console.log(corpoTabela);
    $.ajax({
        url: 'DAO/banco-boletim-notas-listar-pdf.php',
        method: 'post',
        dataType: 'json',
        data: {
            idTurma: idTurma,
            idAluno: idAluno,
            bimestre: bimestre
        },

        success: function (response) {
            if (response['mensagem'] != 'erro') 
            {
                console.log(response);
                $.each(response, function (key, value) {
                    var disciplina = value['disciplina']
                    var prova1 = value['prova1'];
                    var prova2 = value["prova2"];
                    var trabalho = value["trabalho"];
                    var recuperacao = value["recuperacao"];
                    var media = value["media"];
                    var faltas = value["faltas"];
                    var mediaParcial = value["media_parcial"];

                    var linha = novaLinhaTabelaAlunosPdf(disciplina, prova1, prova2, trabalho, recuperacao, media, faltas, mediaParcial);
                    corpoTabela.append(linha);
                })
                var conteudo = $("#conteudo").val();
                console.log("antes do ajax");
                console.log(conteudo);
                // geraPDF();
                // $.ajax({
                //     url: 'domPdf.php',
                //     method: 'post',
                //     dataType: 'json',
                //     data: {
                //         conteudo: conteudo
                //     },

                //     success: function (response) {
                //         if (response['mensagem'] != 'erro') {
                //             console.log(response);
                //         }
                //         else {
                //             console.log("estou no else")
                //             Swal.fire({
                //                 type: 'warning',
                //                 title: response['title'],
                //                 text: response['text'],
                //                 animation: false,
                //                 customClass: {
                //                     popup: 'animated tada'
                //                 }
                //             })
                //         }
                //     },

                //     error: function (response) {
                //         console.log(response);
                //         Swal.fire({
                //             type: 'warning',
                //             title: response['title'],
                //             text: response['text'],
                //             animation: false,
                //             customClass: {
                //                 popup: 'animated tada'
                //             }
                //         })
                //     }
                // })
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
                
}

function novaLinhaTabelaAlunosPdf(disciplina, prova1, prova2, trabalho, recuperacao, media, faltas, mediaParcial)
{
    var linha = $("<tr>");
    var colunaDisciplina = $("<td>").text(disciplina).attr("class", "text-center");
    var colunaP1 = $("<td>").text(prova1).attr("class", "text-center");
    var colunaP2 = $("<td>").text(prova2).attr("class", "text-center");
    var colunaTrabalho = $("<td>").text(trabalho).attr("class", "text-center");
    var colunaMediaP = $("<td>").text(mediaParcial).attr({ "class": "text-center"});
    var colunaRec = $("<td>").text(recuperacao).attr({ "class": "text-center"});
    var colunaMedia = $("<td>").text(media).attr("class", "text-center table-info");
    var colunaFaltas = $("<td>").text(faltas).attr("class", "text-center table-danger");

    linha.append(colunaDisciplina);
    linha.append(colunaP1);
    linha.append(colunaP2);
    linha.append(colunaTrabalho);
    linha.append(colunaMediaP);
    linha.append(colunaRec);
    linha.append(colunaMedia);
    linha.append(colunaFaltas);

    return linha;
}
