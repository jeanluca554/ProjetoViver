$(function() {    
    $('#cadastrar-matriz-curricular').on("click", setCadastrarMatriz);
    // $('.').on("click", recarregarPagina);
    $('.fecharModalCadastroMatrizCurricular').on("click", limparCampos);
    $('#botao-salvar-endereco-responsavel').on("click", limparCampos);
    // $('#bnt-editar-disciplina').on("click", setAlterarDisciplinas);
});

function setCadastrarMatriz()
{
    $('#botao-alterar-matriz-curricular').hide();
    $('#botao-salvar-matriz-curricular').show();

    $('#btnAdicionaDisciplina2').hide();
    $('#btnAdicionaDisciplina').show();


    $('#nomeMatriz').val("");
    $('#ModalMatrizCurricular').find('.modal-title').text('Cadastrar Matriz Curricular');

    sessionStorage.clear();
    $(".tabelaMaterias > tbody").empty();
    sessionStorage.setItem('removeLinha', "0");

}

function setAlterarMatriz(nome, id, tipoEnsino)
{
    $('#botao-salvar-matriz-curricular').hide();
    $('#botao-alterar-matriz-curricular').show();

    $('#btnAdicionaDisciplina').hide();
    $('#btnAdicionaDisciplina2').show();

    $('#ModalMatrizCurricular').find('.modal-title').text('Alterar Matriz Curricular');

    sessionStorage.setItem('idMatriz', id);
    sessionStorage.setItem('removeLinha', 1);

    $('#nomeMatriz').val(nome);
    $('#tipoEnsino').val(tipoEnsino);
    $('#idMatriz').attr('data-id', id);

    $(".tabelaMaterias > tbody").empty();

    buscarDisciplinasDaMatriz(id);
}

function recarregarPagina() {
    location.reload();
}

function buscarDisciplinasDaMatriz(id)
{
    $.ajax({
        url: 'DAO/banco-disciplinas-listar-pela-matriz-post.php',
        method: 'post',
        dataType: 'json',
        data: {
            idMatriz: id
        },

        success: function (response) 
        {
            var idMatriz = id;
            console.log(idMatriz);
            var materiasSession = [];
            $.each(response, function (key, value) {
                var corpoTabela = $(".tabelaMaterias").find("tbody");
                var materia = value['nome'];
                var idMateria = value["id"];
                
                var linha = novaLinhaTabelaMaterias(materia, idMateria, idMatriz);

                corpoTabela.append(linha);
                materiasSession.push(idMateria)
            })
            console.log(materiasSession);      
            sessionStorage.setItem('disciplinas', materiasSession);
        },

        error: function (ultimoId) {
            console.log(ultimoId);
            Swal.fire({
                type: 'warning',
                title: 'Erro ao listar as diciplinas da Matriz Curricular',
                text: ultimoId,
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
}

function novaLinhaTabelaMaterias(materia, numero, idMatriz) {
    console.log(idMatriz);
    var linha = $("<tr>");
    var colunaNome = $("<td>").text(materia).attr("class", "align-middle");

    //Criação da coluna Remover:

    var colunaRemover = $("<td>").attr("align", "center");
    var botaoRemover = $("<button>")
        .addClass("btn btn-outline-danger")
        .attr({
            'id': "btnExcluir" + numero,
            'onclick': "removerLinha(" + numero + "," + idMatriz +")"
        });
    var imagemRemover = $("<img>").attr("src", "img/menos-25.png");
    botaoRemover.append(imagemRemover);
    colunaRemover.append(botaoRemover);

    linha.append(colunaNome);
    linha.append(colunaRemover);

    return linha;
}

function limparCampos()
{
    $("#tipoEnsino").val(0);
}