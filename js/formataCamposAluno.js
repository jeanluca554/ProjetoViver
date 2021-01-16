$(function() {    
    formatarCamposAluno();
    $('#anoLetivoMatricula').on("change", setSelectTipoEnsino);
    $('#tipoEnsinoMatricula').on("change", setSelectTurmas);
    $('#botao-salvar-aluno').on("click", habilitaAbaEnderecoAluno);
    $('#botao-salvar-endereco-aluno').on("click", habilitaAbaResponsaveisAluno);
    $('#btnNovaMatricula').on("click", setDataAtualMatricula);
    $('#btn-cadastrar-aluno').on("click", setSessionAbas);
});

function formatarCamposAluno()
{
    $('#dataNascimento').mask('00/00/0000');
    
}

function setDataAtualMatricula() {
    console.log('clicou no botão Nova Matrícula')
    $('#dataMatricula').mask('00/00/0000');
    $('#tipoEnsinoMatricula').attr('option value', 0);
    $('#selectTurmasMatricula').val('');
}

function verificaAlterar(nome, id, idEndereco)
{
    if (nome != "")
    {
        var idEnderecoAluno = idEndereco;

        sessionStorage.setItem('nomeBtnAlterar', nome);
        sessionStorage.setItem('idBtnAlterar', id);
        sessionStorage.setItem('idBtnEndereco', idEnderecoAluno);
        console.log(idEnderecoAluno);
    }
}

function habilitaAbaEnderecoAluno()
{
    $('#enderecoAluno-tab').attr('class', 'nav-link');
    $('#enderecoAluno-tab').attr('href', '#abaEnderecoAluno');
}

function habilitaAbaResponsaveisAluno() {
    $('#responsaveisAluno-tab').attr('class', 'nav-link');
    $('#responsaveisAluno-tab').attr('href', '#abaResponsaveisAluno');
}

function setSelectTipoEnsino() {
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
                console.log(response['text']);
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
            var idTurma = value["id_turma"]

            var turmaCompleta = nomeTurma + " " + sigla + " - " + turno;

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

function setSessionAbas()
{
    sessionStorage.setItem('liberaAbas', 0);
    // sessionStorage.removeItem('alunoID');
}