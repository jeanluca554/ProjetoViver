$(function() 
{  
    $(document).on('shown.bs.modal', '#AssociarProfessorModal', function (event) 
    {
        // $('#AssociarProfessorModal').css('overflow-y', 'auto');

        var button = $(event.relatedTarget) // Button that triggered the modal
        var idSala = button.data('idturma')
        buscaDisciplinasVinculo(idSala);
        buscaProfessoresVinculo();

    });

});

function setAssociacao(idMatriz, idTurma)
{
    var nomeBuscaProf = "";

    $.ajax({
        url: 'professor-listar.php',
        method: 'post',
        dataType: 'json',
        data: {
            ano: "ano"
        },

        success: function (response) 
        {
            if (response['mensagem'] == 'ok') {
                console.log(response['professores']);

                var professores = response['professores'];
                sessionStorage.setItem("professores", professores);

                var profNome = [];
                $.each(professores, function (key, value) {
                    var nomeProfessor = value['nome_funcionario'];
                    var cpfProfessor = value["cpf_funcionario"];

                    var optionItems = $("<option>").attr("value", cpfProfessor).text(nomeProfessor);
                    $("#selectProfessores").append(optionItems);

                    profNome.push(nomeProfessor);

                    // utilizado no alterarVinculoProfessor.js
                    sessionStorage.setItem("idMatriz", idMatriz);
    
                })
                sessionStorage.setItem("professoresNome", profNome)

                $.ajax({
                    url: 'DAO/banco-disciplinas-listar-pela-matriz-post.php',
                    method: 'post',
                    dataType: 'json',
                    data: { idMatriz: idMatriz },

                    success: function (response) {
                        if (response['mensagem'] != 'erro') {
                            console.log(response);

                            $(".tabelaProfessoresAssociados > tbody").empty();
                            var materiasSession = [];
                            $.each(response, function (key, value) 
                            {
                                var corpoTabela = $(".tabelaProfessoresAssociados").find("tbody");
                                var materia = value['nome'];
                                var idMateria = value["id"];

                                
                                //será utilizado no botão de vincular (aterarVinculoProfessor.js)
                                sessionStorage.setItem("idTurmaVinculo", idTurma);

                                console.log("está prcurando a matéria: " + idMateria + " e a turma: " + idTurma);

                                $.ajax({
                                    url: 'DAO/banco-professor-associado-listar.php',
                                    method: 'post',
                                    dataType: 'json',
                                    data: { idMateria: idMateria, idTurma: idTurma },

                                    success: function (response) {
                                        if (response['mensagem'] != 'erro') {
                                            if (response == false)
                                            {
                                                

                                                $.ajax({
                                                    url: 'DAO/banco-professor-associado-criar.php',
                                                    method: 'post',
                                                    dataType: 'json',
                                                    data: { idMateria: idMateria, idTurma: idTurma },

                                                    success: function (response) {
                                                        if (response['mensagem'] != 'erro') 
                                                        {
                                                            console.log("Foi criado a associação. ID: " + response);
                                                        }
                                                        else {
                                                            console.log(response)
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
                                                var nomeBuscaProf = response['nome_funcionario'];
                                                if (nomeBuscaProf.length > 0) 
                                                {
                                                    // console.log(nomeBuscaProf)
                                                    // sessionStorage.setItem("nomeBuscaProf", nomeBuscaProf)

                                                    // var nomeProf = sessionStorage.getItem("nomeBuscaProf")
                                                    var linha = novaLinhaTabelaMateriasAssociacao(materia, nomeBuscaProf);

                                                    corpoTabela.append(linha);
                                                    materiasSession.push(idMateria)
                                                }
                                                else{
                                                    var linha = novaLinhaTabelaMateriasAssociacao(materia, "Nenhum professor vinculado à essa disciplina");

                                                    corpoTabela.append(linha);
                                                    materiasSession.push(idMateria)
                                                }

                                                console.log(response);
                                                console.log(nomeBuscaProf);
                                                
                                                // var nomeBuscaProf = response['nome_funcionario'];

                                                // sessionStorage.setItem("nomeBuscaProf", nomeBuscaProf)
                                                // console.log(response['nome_funcionario']);
                                                // console.log(nomeBuscaProf);
                                            }

                                        }
                                        else {
                                            console.log(response)
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
                                // var nomeProf = sessionStorage.getItem("nomeBuscaProf")
                                // var linha = novaLinhaTabelaMateriasAssociacao(materia, nomeProf);

                                // corpoTabela.append(linha);
                                // materiasSession.push(idMateria)
                            })
                            // console.log(materiasSession);
                            // sessionStorage.setItem('disciplinasAssociacao', materiasSession);
                        }
                        else {
                            console.log(response)
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

function novaLinhaTabelaMateriasAssociacao(materia, nomeProf)
{
    var linha = $("<tr>");
    var colunaDisciplina = $("<td>").text(materia).attr("class", "text-center");
    // var colunaProfessor = $("<td>").attr("class", "text-center");
    var select = $("<select>").attr({ "id": "selectProfessor", "class": "form-control" });
    // var select = $("<select>").attr({ "id": "selectProfessor", "class": "form-control" }).text("<? php DisciplinaDAO:: listarDisciplinasEcho();?>")

    var professores = sessionStorage.getItem("professoresNome");
    var profSeparados = professores.split(",")
    var profBuscado = nomeProf;

    for (var i = 0; i < profSeparados.length; i++) 
    {
        colunaProfessor = $("<td>").attr("class", "text-center").text(profBuscado);
        // console.log(profSeparados + " e " + profBuscado);
        // prof1 = profSeparados[i].toString();
        // prof2 = profBuscado.toString()
        // if(profSeparados[i] == profBuscado)
        // {
        //     console.log("profBuscado: " + profBuscado);
        //     console.log("eparados[i]: " + profSeparados[i]);

        //     colunaProfessor = $("<td>").attr("class", "text-center").text(profSeparados[i]);
        // }
        // else{
        //     colunaProfessor = $("<td>").attr("class", "text-center").text("Nenhum professor vinculado à essa disciplina");  
        // }
        
        // var optionItems = $("<option>").attr("value", i).text(profSeparados[i]);
        // select.append(optionItems);
    }

    // colunaProfessor.append(select);
    // for (var i = 0; i < profSeparados.length; i++) 
    // {
    //     if (nomeProf == profSeparados[i]) {
    //         select.val(i);
    //         $("#selectProfessor").val(i);
    //         console.log('é igual');
    //     }
    //     else {
    //         console.log('não achei igual');
    //     }
    // }
    

    //Criação da coluna Editar:

    // var colunaEditar = $("<td>").attr({
    //     'align': "center",
    //     'data-nome': responsavel,
    //     'data-cpf': cpf,
    //     'data-enderecoresp': idEnderecoResp,
    //     'data-toggle': "modal",
    //     'data-target': "#ResponsaveisModal",
    //     'onclick': "($('#ModalAlunoFormulario').modal('hide'))"
    // });
    

    linha.append(colunaDisciplina);
    linha.append(colunaProfessor);

    return linha;
}

function buscaDisciplinasVinculo(idSala)
{
    $(".alterarVinculoDisciplina > option").remove();
    console.log("entrei no vinculo disciplina. ID turma: " + idSala)
    $.ajax({
        url: 'DAO/banco-disciplinas-listar-pela-matriz-post.php',
        method: 'post',
        dataType: 'json',
        data: { idMatriz: idSala },

        success: function (response) {
            if (response['mensagem'] != 'erro') {
                console.log(response);


                $.each(response, function (key, value) {
                    var nomeDisciplina = value['nome'];
                    var idDisciplina = value["id"];

                    console.log(value['nome'], value["id"])

                    var optionItems = $("<option>").attr("value", idDisciplina).text(nomeDisciplina);

                    $("#alterarVinculoDisciplina").append(optionItems);
                })
            }
            else {
                console.log(response)
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

function buscaProfessoresVinculo()
{
    $(".alterarVinculoProfessor > option").remove();
    $.ajax({
        url: 'professor-listar.php',
        method: 'post',
        dataType: 'json',
        data: {
            ano: "ano"
        },

        success: function (response) {
            if (response['mensagem'] == 'ok') {
                console.log(response['professores']);
                $.each(response['professores'], function (key, value) {
                    var nomeProfessor = value['nome_funcionario'];
                    var cpfProfessor = value["cpf_funcionario"];

                    console.log(value[nomeProfessor], value[cpfProfessor])
                    if (value[cpfProfessor] != "")
                    {
                        var optionItems = $("<option>").attr("value", cpfProfessor).text(nomeProfessor);

                        $("#alterarVinculoProfessor").append(optionItems);
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

