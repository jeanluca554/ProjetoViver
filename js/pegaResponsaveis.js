$(function() {
    buscaResponsaveis();
    // $("#btnAdicionaResponsavel").click(insereResponsaveisNaTabela);
    $("#btnAdicionaResponsavel").click(adicionaResponsaveis); 
    //$("#btnAdicionaResponsavel").click(buscaResponsaveisVinculadosAoAluno); 
});


function buscaResponsaveis()
{
    $("#selecionaResponsavel").keyup(function(){
        var responsavelDigitado = $(this).val();
        if(responsavelDigitado.length > 2){
            $.ajax({
                url: 'DAO/banco-responsaveis-post.php',
                method: 'post',
                data: {responsavel:responsavelDigitado, funcao: 1},

                success: function(response){
                    $("#show-list").html(response);
                }
            });
        }
        else
        {
            $("#show-list").html('');
        }
        $(document).on('click', 'a', function(){
            var responsavel = $(this).text();
            var responsavelSemCPF = responsavel.split("--");
            $("#selecionaResponsavel").val(responsavelSemCPF[0].trim());
            $("#show-list").html('');
            $("#btnAdicionaResponsavel").attr("disabled", false);
            //$("#btnAdicionaResponsavel").click(adicionaResponsaveis(responsavelSemCPF[1].trim()));
            sessionStorage.setItem('cpfResponsavel', responsavelSemCPF[1].trim());
            sessionStorage.setItem('nomeResponsavel', responsavelSemCPF[0].trim());

        });
    });
}

function adicionaResponsaveis()
{
    var cpf_responsavel = sessionStorage.getItem('cpfResponsavel');
    $.ajax({
        url: 'DAO/banco-responsaveis-post.php',
        method: 'post',
        data: {cpf: cpf_responsavel, funcao: 2},

        success: function(response)
        {
            //console.log(response);
            sessionStorage.setItem('responsavelPeloAlunoID', response);
            buscaResponsaveisVinculadosAoAluno();            
        },
        error: function(response)
        {
            Swal.fire({
                type: 'warning',
                title: 'Algo errado aconteceu',
                text: 'Erro ao vincular o responsavel ao aluno',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
    /* }).done(function (resposta) {
        console.log(resposta);

    }).fail(function (jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);

    }); */
}

function buscaResponsaveisVinculadosAoAluno()
{
    $.ajax({
        url: 'DAO/banco-responsaveis-post.php',
        dataType: 'json',
        method: 'post',
        data: {funcao: 3},

         success: function(response)
        {
            $(".tabelaParentesco > tbody").empty();
            insereSelectResponsavelFinanceiro(response);
            insereSelectResponsavelDidatico(response);
            insereResponsaveisNaTabela2(response);          
        },
        error: function(response)
        {
            Swal.fire({
                type: 'warning',
                title: 'Algo errado aconteceu',
                 text: 'Erro ao buscar responsáveis vinculados ao aluno',
                 text: response['message'],
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
    /* }).done(function (resposta) {
        console.log(resposta);

    }).fail(function (jqXHR, textStatus) {
    console.log("Request failed: " + textStatus);

    }); */
}

function insereSelectResponsavelFinanceiro(response)
{
    $.each(response, function (key, value) {
        var responsavel = value['nome'];
        
        var option = $("<option>").attr("value", responsavel).text(responsavel);

        $("#selectResponsavelFinanceiro").append(option);
    })
}

function insereSelectResponsavelDidatico(response)
{
    $.each(response, function (key, value) {
        var responsavel = value['nome'];
        
        var option = $("<option>").attr("value", responsavel).text(responsavel);

        $("#selectResponsavelDidatico").append(option);
    })
}

function insereResponsaveisNaTabela2(response)
{
    $.each(response, function(key, value) {
        var corpoTabela = $(".tabelaParentesco").find("tbody");
        var responsavel = value['nome'];
        var cpfResponsavel = value["cpf"];

        var linha = novaLinha(responsavel, cpfResponsavel);

        corpoTabela.append(linha);

        $("#selecionaResponsavel").val('');
     })
}

function novaLinha(responsavel, cpfResponsavel) 
{
    var linha = $("<tr>");
    var colunaResponsavel = $("<td>").text(responsavel).attr("class", "align-middle");

    var colunaCpfResponsavel = $("<td>").text(cpfResponsavel).attr("class", "align-middle");


    //Criação da coluna Parentesco:
    var colunaParentesco = $("<td>").attr("align", "center");

    var parentesco = "parentesco";
    var cpf = cpfResponsavel;
    var idSelect = parentesco.concat(cpf);

    var selectParentesco = $("<select>").addClass("form-control").attr(
        {
            id: idSelect,
            onchange: "salvarResponsavelDoAluno('"+cpf+"')"
        });

    var optionSel = $("<option>").attr("value", "0").text("Selecione...");
    var optionMae = $("<option>").attr("value", "Mãe").text("Mãe");
    var optionPai = $("<option>").attr("value", "Pai").text("Pai");
    var optionRes = $("<option>").attr("value", "Responsavel").text("Responsável");

    selectParentesco.append(optionSel);
    selectParentesco.append(optionMae);
    selectParentesco.append(optionPai);
    selectParentesco.append(optionRes);

    //hidden do id_responsavel_pelo_aluno para usar mais tarde
    //var idResponsavelPeloAluno = sessionStorage.getItem('responsavelPeloAlunoID');
    //var hiddenIdResponsavelPeloAluno = $("input").attr({ type: "hidden", id: idResponsavelPeloAluno });

    colunaParentesco.append(selectParentesco);
   // colunaParentesco.append(hiddenIdResponsavelPeloAluno);

    
    //Criação da coluna Editar:
    var colunaEditar = $("<td>").attr("align", "center");
    var botaoEditar = $("<a>").addClass("btn btn-outline-info").attr("href", "#");
    var imagemEditar = $("<img>").attr("src", "img/editar.png");
    botaoEditar.append(imagemEditar);
    colunaEditar.append(botaoEditar);

    
    //Criação da coluna Remover:
    var colunaRemover = $("<td>").attr("align", "center");
    var botaoRemover = $("<a>").addClass("btn btn-outline-danger").attr("href", "#");
    var imagemRemover = $("<img>").attr("src", "img/menos-25.png");
    botaoRemover.append(imagemRemover);
    colunaRemover.append(botaoRemover);

    linha.append(colunaResponsavel);
    linha.append(colunaCpfResponsavel);
    linha.append(colunaParentesco);
    linha.append(colunaEditar);
    linha.append(colunaRemover);

    return linha;

}

function insereResponsaveisNaTabela3(data)
{
    
    $("#selectCidadeResidencia").html(data);
    
}