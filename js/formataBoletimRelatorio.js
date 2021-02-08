$(function() 
{  
    $(".fecharModalBoletim").on("click", function(){
        location.reload();
    });
    $(document).on('shown.bs.modal', '#BoletimRelatorioModal', function (event) 
    {
        // $('.modal').css('overflow-y', 'auto');
        var button = $(event.relatedTarget) // Button that triggered the modal
        var idTurmaBoletim = button.data('idturma');
        console.log("o teste da turma é: " + idTurmaBoletim)
        // var idDisciplinaBoletim = button.data('iddisciplinaboletim');

        // $('#idTurmaBoletim').val(idTurmaBoletim);
        // $('#idDisciplinaBoletim').val(idDisciplinaBoletim);

        // $("#bimestreBoletimRelatorio").on("change", function () {
        //     setBoletimRelatorio(idTurmaBoletim);
        //     console.log("alterei o bimestre");
        // })
    });
    var turma = sessionStorage.getItem("pdfIdTurma");
    $("#bimestreBoletimRelatorio").on("change", function () {
        setBoletimRelatorio(turma);
        console.log("alterei o bimestre");
    })

});

function setBoletimRelatorio(idTurma)
{
    var bimestre = $("#bimestreBoletimRelatorio").val();
    $.ajax({
        url: 'DAO/banco-alunos-turma-listar.php',
        method: 'post',
        dataType: 'json',
        data: {
            idTurma: idTurma
        },

        success: function (response) 
        {
            if (response['mensagem'] != 'erro') 
            {
                $(".tabelaAlunosDaTurma > tbody").empty();
                $.each(response, function (key, value) {
                    var corpoTabela = $(".tabelaAlunosDaTurma").find("tbody");
                    var nomeAluno = value['nome_aluno'];
                    var idAluno = value["id_aluno"];

                    var linha = novaLinhaTabelaAlunosBoletimRelatorio(nomeAluno, idAluno, idTurma, bimestre);
                    corpoTabela.append(linha);
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

function novaLinhaTabelaAlunosBoletimRelatorio(nomeAluno, idAluno, idTurma, bimestre)
{
    console.log('entrei no setPDF')
    var linha = $("<tr>");
    var colunaId = $("<td>").text(idAluno).attr("class", "text-center");
    var colunaNome = $("<td>").text(nomeAluno);
    
    var colunaGerarPDF = $("<td>").attr({
        'align': "center",
        'id': "btnGerarPdfAluno",
        'data-idaluno': idAluno,
        // 'onclick': "paralelepipedo(" + idTurma + ", " + idAluno + ")"
        'onclick': "sessionPDF(" + idTurma + ", " + idAluno + ")"
    });
    // var botaoGerarPDF = $("<a>").addClass("btn btn-outline-info");
    var link = "BoletimPDF.php?turma=" + idTurma + "&aluno=" + idAluno + "&bimestre=" + bimestre + "&nome=" + nomeAluno;
    var botaoGerarPDF = $("<a>").addClass("btn btn-outline-info").attr({ "href": link, "target":  "_blank"});
    var imagemGerarPDF = $("<img>").attr("src", "img/pdf-25.png");
    botaoGerarPDF.append(imagemGerarPDF);
    colunaGerarPDF.append(botaoGerarPDF);

    linha.append(colunaId);
    linha.append(colunaNome);
    linha.append(colunaGerarPDF);

    return linha;
}
