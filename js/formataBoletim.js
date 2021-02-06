$(function() 
{  
    $(".fecharModalBoletim").on("click", function(){
        location.reload();
    });
    $(document).on('shown.bs.modal', '#ModalBoletim', function (event) 
    {
        // $('.modal').css('overflow-y', 'auto');
        var button = $(event.relatedTarget) // Button that triggered the modal
        var idTurmaBoletim = button.data('idturmaboletim');
        var idDisciplinaBoletim = button.data('iddisciplinaboletim');

        $('#idTurmaBoletim').val(idTurmaBoletim);
        $('#idDisciplinaBoletim').val(idDisciplinaBoletim);



        $(".nota").mask('00');
        $("#notaP1").on("blur", function(){
            valor = $("#notaP1").val();
            if (valor > 10)
            {
                $("#notaP1").val(10);
            }
        });

        $("#notaP2").on("blur", function(){
            valor = $("#notaP2").val();
            if (valor > 10)
            {
                $("#notaP2").val(10);
            }
        });

        $("#notaTrabalho").on("blur", function(){
            valor = $("#notaTrabalho").val();
            if (valor > 10)
            {
                $("#notaTrabalho").val(10);
            }
        });

        $("#notaRec").on("blur", function(){
            valor = $("#notaRec").val();
            if (valor > 10)
            {
                $("#notaRec").val(10);
            }
        });

        $("#notaMedia").on("blur", function(){
            valor = $("#notaMedia").val();
            if (valor > 10)
            {
                $("#notaMedia").val(10);
            }
        });
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var idSala = button.data('idturma')
        

        $("#bimestreBoletim").on("change", function(){
            setBoletim(idTurmaBoletim, idDisciplinaBoletim);
        })

    });

});

function setBoletim(idTurma, idDisciplina)
{

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
                console.log(response);
                $(".tabelaAlunosDaTurma > tbody").empty();
                $.each(response, function (key, value) {
                    var corpoTabela = $(".tabelaAlunosDaTurma").find("tbody");
                    var nomeAluno = value['nome_aluno'];
                    var idAluno = value["id_aluno"];
                    var situacao = value["situacao"];

                    var bimestre = $("#bimestreBoletim").val();

                    $.ajax({
                        url: 'DAO/banco-boletim-notas-listar.php',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            idTurma: idTurma,
                            idDisciplina: idDisciplina,
                            idAluno: idAluno,
                            bimestre: bimestre
                        },

                        success: function (response) {
                            if (response['mensagem'] != 'erro') {
                                
                                if(response == false)
                                {
                                    console.log("não existe boletim para esse aluno");

                                    $.ajax({
                                        url: 'DAO/banco-boletim-notas-criar.php',
                                        method: 'post',
                                        dataType: 'json',
                                        data: {
                                            idTurma: idTurma,
                                            idDisciplina: idDisciplina,
                                            idAluno: idAluno,
                                            bimestre: bimestre
                                        },

                                        success: function (response) {
                                            if (response['mensagem'] != 'erro') 
                                            {
                                                console.log("Foi criado a associação. ID: " + response);
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
                                else
                                {
                                    console.log(response);
                                    $.each(response, function (key, value) {
                                        var prova1 = value['prova1'];
                                        var prova2 = value["prova2"];
                                        var trabalho = value["trabalho"];
                                        var recuperacao = value["recuperacao"];
                                        var media = value["media"];
                                        var faltas = value["faltas"];

                                        var linha = novaLinhaTabelaAlunosDaTurma(nomeAluno, idAluno, situacao, prova1, prova2, trabalho, recuperacao, media, faltas)
                                        corpoTabela.append(linha);
                                    })
                                }

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

                    // var linha = novaLinhaTabelaAlunosDaTurma(nomeAluno, idAluno, situacao)
                    // corpoTabela.append(linha);
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

function novaLinhaTabelaAlunosDaTurma(nomeAluno, idAluno, situacao, prova1, prova2, trabalho, recuperacao, media, faltas)
{
    var linha = $("<tr>");
    var colunaId = $("<td>").text(idAluno).attr("class", "text-center");
    var colunaNome = $("<td>").text(nomeAluno).attr("class", "text-center");
    var colunaSituacao = $("<td>").text(situacao).attr("class", "text-center");

    var inputN1 = $("<input>").attr({
        "class": "form-control nota", 
        "type": "number", 
        "placeholder": "0", 
        "min": "0", 
        "max": "10", 
        "id": "notaP1"
    }).val(prova1);
    console.log("o valor da prova 1 é: " + prova1);
    var colunaP1 = $("<td>").attr("class", "text-center");
    colunaP1.append(inputN1);

    var inputN2 = $("<input>").attr({
        "class": "form-control nota",
        "type": "number",
        "placeholder": "0",
        "min": "0",
        "max": "10",
        "id": "notaP2"
    }).val(prova2);
    var colunaP2 = $("<td>").attr("class", "text-center");
    colunaP2.append(inputN2);

    var inputTrabalho = $("<input>").attr({
        "class": "form-control nota",
        "type": "number",
        "placeholder": "0",
        "min": "0",
        "max": "10",
        "id": "notaTrabalho"
    }).val(trabalho);
    var colunaTrabalho = $("<td>").attr("class", "text-center");
    colunaTrabalho.append(inputTrabalho);

    var inputRec = $("<input>").attr({
        "class": "form-control nota",
        "type": "number",
        "placeholder": "0",
        "min": "0",
        "max": "10",
        "id": "notaRec"
    }).val(recuperacao);
    var colunaRec = $("<td>").attr({ "class": "text-center"});
    colunaRec.append(inputRec);

    var inputMedia = $("<input>").attr({
        "class": "form-control nota",
        "type": "number",
        "placeholder": "0",
        "min": "0",
        "max": "10",
        "id": "notaMedia"
    }).val(media);
    var colunaMedia = $("<td>").attr("class", "text-center table-info");
    colunaMedia.append(inputMedia);

    var inputFaltas = $("<input>").attr({
        "class": "form-control nota",
        "type": "number",
        "placeholder": "0",
        "min": "0",
        "max": "10",
        "id": "notaFaltas"
    }).val(faltas);
    var colunaFaltas = $("<td>").attr("class", "text-center table-danger");
    colunaFaltas.append(inputFaltas);

    linha.append(colunaId);
    linha.append(colunaNome);
    linha.append(colunaSituacao);
    linha.append(colunaP1);
    linha.append(colunaP2);
    linha.append(colunaTrabalho);
    linha.append(colunaRec);
    linha.append(colunaMedia);
    linha.append(colunaFaltas);

    return linha;
}
