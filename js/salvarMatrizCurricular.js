$(function() {
    $("#btnAdicionaDisciplina").on("click", adicionaNome);
    $("#btnMostrarDisciplina").on("click", apresentaNome);
    $("#cadastrar-matriz-curricular").on("click", limpaSes);
    $("#botao-salvar-matriz-curricular").on("click", salvaMatrizCurricular);
    $("#botao-alterar-matriz-curricular").on("click", alteraMatrizCurricular);
    $("#btnAdicionaDisciplina2").on("click", salvaUmaDisciplinaDaMatriz);
});

function adicionaNome() 
{
    //sessionStorage.getItem('idBtnEndereco')

    var disciplinasSession = sessionStorage.getItem('disciplinas');
    var disciplinasNomeSession = sessionStorage.getItem('disciplinasNome');
    var disciplinaNume = $("#selectDisciplina").val();
    var disciplinaNome = $("#selectDisciplina option:selected").text();
    if(disciplinasSession == null)
    {
        // console.log('Estava vazio, então o primeiro foi adicionado');
        var disciplinas = [];
        disciplinas.push(disciplinaNume)
        sessionStorage.setItem('disciplinas', disciplinas);

        //nome
        var disciplinasNome = [];
        disciplinasNome.push(disciplinaNome)
        sessionStorage.setItem('disciplinasNome', disciplinasNome);

        insereMateriasNaTabela(disciplinaNome);
    }
    else
    {
        var existe = 0;
        for (var i = 0; i < disciplinasSession.length; i++) {
            if (disciplinasSession[i] == disciplinaNume) {
                existe = 1;
                break;
            }
        }
        if(existe == 0)
        {
            // console.log('Não temos um igual e ');
            // console.log('Não estava vazio, então adicionamos mais um');
            var materiasSession = [];
            materiasSession.push(disciplinasSession);

            materiasSession.push(disciplinaNume);
            sessionStorage.setItem('disciplinas', materiasSession);

            //Nome
            var materiasNomeSession = [];
            materiasNomeSession.push(disciplinasNomeSession);

            materiasNomeSession.push(disciplinaNome);
            sessionStorage.setItem('disciplinasNome', materiasNomeSession);

            insereMateriasNaTabela(disciplinaNome, disciplinaNume);
        }
        else{
            console.log('Esse valor já existe, então não foi adicionado');
            Swal.fire({
                type: 'warning',
                title: 'Ops..',
                text: 'Essa matéria já foi adiciona na tabela!',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }  
    }
}

function apresentaNome()
{
    var disciplinasSession = [];
    disciplinasSession.push(sessionStorage.getItem('disciplinas'));
    console.log(disciplinasSession);

    var disciplinasNomeSession = [];
    disciplinasNomeSession.push(sessionStorage.getItem('disciplinasNome'));
    console.log(disciplinasNomeSession);
}

function limpaSes()
{
    sessionStorage.clear();
    $(".tabelaMaterias > tbody").empty();
}

function salvaMatrizCurricular() 
{
    var nome = $("#nomeMatriz").val();
    var idDisciplinas = sessionStorage.getItem('disciplinas');
    // console.log(idDisciplinas);
        
    if (idDisciplinas != null) 
    {
        if (nome != '') 
        { 
            $.ajax({
                url: 'matriz-curricular-criar-post.php',
                method: 'post',
                dataType: 'json',
                data:{
                    nome: nome
                },

                success: function(ultimoId)
                {
                    if (ultimoId['mensagem'] == 'ok') 
                    {
                        //console.log("Matriz curricular criada com sucesso. Último ID: " + ultimoId['ultimoID']);                        
                        salvaTodasDisciplinasDaMatriz(ultimoId['ultimoID'])
                        
                        $('#nomeMatriz').val("");
                    }
                    else {
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
                    console.log(ultimoId);
                    Swal.fire({
                        type: 'warning',
                        title: 'Erro ao cadastrar a Matriz Curricular',
                        text: ultimoId,
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
                }
            });
        }
        else {
            Swal.fire({
                type: 'warning',
                title: 'Ops..',
                text: 'Para salvar você deve digitar um nome para a Matriz Curricular',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        } 
    }
    else {
        Swal.fire({
            type: 'warning',
            title: 'Ops..',
            text: 'Para salvar você deve isnerir uma matéria na Matriz Curricular',
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        })
    }   
}

function salvaTodasDisciplinasDaMatriz(ultimoId) {
    var idDisciplinas = sessionStorage.getItem('disciplinas');
    var ultimoID = ultimoId;

    for (var i = 0; i < idDisciplinas.length; i++) 
    {
        if (idDisciplinas[i] != ",")
        {
            $.ajax({
                url: 'DAO/banco-matriz-disciplinas-criar-post.php',
                method: 'post',
                dataType: 'json',
                data: {
                    idDisciplina: idDisciplinas[i],
                    idMatriz: ultimoID
                },

                success: function (ultimoId) {
                    if (ultimoId['mensagem'] == 'ok') 
                    {
                        apresentaMensagemSucesso("cadastrada");                        
                    }
                    else {
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
                /* error: function (jqXHR, status, error) {
                    //alert('Ocorreu durante a execução do filtro. Tente novamente mais tarde!');
                    console.log(status, error, jqXHR);

                } */

                error: function (ultimoId) {
                    console.log(ultimoId)
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops..',
                        text: 'Erro ao salvar as Disciplinas Da Matriz',
                        animation: false,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
                }
            });
        }
    }
    $('#nomeDisciplina').val("");
    limpaSes();
}

function insereMateriasNaTabela(nomeMateria, numeMateria) 
{
    var corpoTabela = $(".tabelaMaterias").find("tbody");
    var materia = nomeMateria;
    var numero = numeMateria;
    
    var linha = novaLinha(materia, numero);

    corpoTabela.append(linha);
    $("#selectDisciplina").val('');
}

function novaLinha(materia, numero) 
{
    var linha = $("<tr>");
    var colunaNome = $("<td>").text(materia).attr("class", "align-middle");

    //Criação da coluna Remover:

    var colunaRemover = $("<td>").attr("align", "center");
    var botaoRemover = $("<button>")
        .addClass("btn btn-outline-danger")
        .attr({
            'id': "btnExcluir" + numero,
            'onclick': "removerLinha(" + numero + ")"
        });
    var imagemRemover = $("<img>").attr("src", "img/menos-25.png");
    botaoRemover.append(imagemRemover);
    colunaRemover.append(botaoRemover);

    linha.append(colunaNome);
    linha.append(colunaRemover);

    return linha;
}



function apresentaMensagemSucesso(texto)
{
    //console.log("Disciplina criada com sucesso. Último ID: " + ultimoId['ultimoID']);
    Swal.fire({
        type: 'success',
        title: 'Concluído',
        text: 'Matriz Curricular ' + texto + ' com sucesso!',
        animation: true,
        customClass: {
            popup: 'animated bounce'
        }
    })
}

function alteraMatrizCurricular() {
    var nome = $("#nomeMatriz").val();
    var idMatriz = sessionStorage.getItem('idMatriz');
    // console.log(idDisciplinas);

    if (nome != '') {
        $.ajax({
            url: 'matriz-curricular-alterar-post.php',
            method: 'post',
            dataType: 'json',
            data: {
                nome: nome, 
                idMatriz: idMatriz
            },

            success: function (response) {
                if (response['mensagem'] == 'ok') {
                    //console.log("Matriz curricular criada com sucesso. Último ID: " + response['ultimoID']);                        
                    apresentaMensagemSucesso("alterada");
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

            error: function (ultimoId) {
                console.log(ultimoId);
                Swal.fire({
                    type: 'warning',
                    title: 'Erro ao alterar a Matriz Curricular',
                    text: ultimoId,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
    }
    else {
        Swal.fire({
            type: 'warning',
            title: 'Ops..',
            text: 'Para salvar você deve digitar um nome para a Matriz Curricular',
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        })
    }
}

function salvaUmaDisciplinaDaMatriz() 
{
    var idMatriz = sessionStorage.getItem('idMatriz');
    var disciplinaNume = $("#selectDisciplina").val();
    var disciplinaNome = $("#selectDisciplina option:selected").text();

    var disciplinasSession = sessionStorage.getItem('disciplinas');

    var existe = 0;
    for (var i = 0; i < disciplinasSession.length; i++) {
        if (disciplinasSession[i] == disciplinaNume) {
            existe = 1;
            break;
        }
    }
    if (existe == 0) 
    {
        $.ajax({
            url: 'DAO/banco-matriz-disciplinas-criar-post.php',
            method: 'post',
            dataType: 'json',
            data: {
                idDisciplina: disciplinaNume,
                idMatriz: idMatriz
            },

            success: function (ultimoId) {
                if (ultimoId['mensagem'] == 'ok') 
                {
                    var materiasSession = [];
                    materiasSession.push(disciplinasSession);

                    materiasSession.push(disciplinaNume);
                    sessionStorage.setItem('disciplinas', materiasSession);

                    insereMateriasNaTabela(disciplinaNome, disciplinaNume)
                }
                else {
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
            /* error: function (jqXHR, status, error) {
                //alert('Ocorreu durante a execução do filtro. Tente novamente mais tarde!');
                console.log(status, error, jqXHR);

            } */

            error: function (ultimoId) {
                console.log(ultimoId)
                Swal.fire({
                    type: 'warning',
                    title: 'Oops..',
                    text: 'Erro ao salvar as Disciplinas Da Matriz',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
        
    }
    else {
        Swal.fire({
            type: 'warning',
            title: 'Ops..',
            text: 'Essa matéria já existe na tabela!',
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        })
    }  
}
