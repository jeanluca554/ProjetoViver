$(function() {
    buscaResponsaveis();
    // buscaResponsaveisVinculadosAoAluno();
    // $("#btnAdicionaResponsavel").click(insereResponsaveisNaTabela);
    $("#btnAdicionaResponsavel").on("click", adicionaResponsaveis); 
    $("#responsaveisAluno-tab").on("click", buscaResponsaveisVinculadosAoAluno);
    //$("#btnAdicionaResponsavel").click(buscaResponsaveisVinculadosAoAluno); 
});


function buscaResponsaveis()
{
    $("#selecionaResponsavel").on("keyup", function(){
        var responsavelDigitado = $(this).val();
        if(responsavelDigitado.length > 2){
            $.ajax({
                async: false,
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
            
            if (responsavelSemCPF[1] != undefined)
            {
                sessionStorage.setItem('cpfResponsavel', responsavelSemCPF[1].trim());
            }
            sessionStorage.setItem('nomeResponsavel', responsavelSemCPF[0].trim());

        });
    });
}

function adicionaResponsaveis()
{
    var cpf_responsavel = sessionStorage.getItem('cpfResponsavel');
    $.ajax({
        async: false,
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
        async: false,
        url: 'DAO/banco-responsaveis-post.php',
        dataType: 'json',
        method: 'post',
        data: {funcao: 3},

         success: function(response)
        {
            $(".tabelaParentesco > tbody").empty();
            $("#selectResponsavelFinanceiro").empty();
            $("#selectResponsavelDidatico").empty();
            insereSelectResponsavelFinanceiro(response);
            insereSelectResponsavelDidatico(response);
            insereResponsaveisNaTabela2(response);          
        },
        /* error: function (XMLHttpRequest, textStatus, errorThrown) {
            for (i in XMLHttpRequest) {
                if (i != "channel")
                    document.write(i + " : " + XMLHttpRequest[i] + "<br>")
            }
        } */
        error: function(response)
        {
            Swal.fire({
                type: 'warning',
                title: 'Algo errado aconteceu',
                text: 'Erro ao buscar responsáveis vinculados ao aluno',
                //  text: response['message'],
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
        var cpfResponsavel = value["cpf"];
        
        var option = $("<option>").attr("value", cpfResponsavel).text(responsavel);

        $("#selectResponsavelFinanceiro").append(option);
    })
    var respFinanceiro = sessionStorage.getItem('respFinanceiro');
    //console.log(respFinanceiro);
    $("#selectResponsavelFinanceiro").val(respFinanceiro);
}

function insereSelectResponsavelDidatico(response)
{
    $.each(response, function (key, value) {
        var responsavel = value['nome'];
        var cpfResponsavel = value["cpf"];
        
        var option = $("<option>").attr("value", cpfResponsavel).text(responsavel);

        $("#selectResponsavelDidatico").append(option);
    })
    var respDidatico = sessionStorage.getItem('respDidatico');
    //console.log(respDidatico);
    $("#selectResponsavelDidatico").val(respDidatico);
}

function insereResponsaveisNaTabela2(response)
{
    $.each(response, function(key, value) {
        var corpoTabela = $(".tabelaParentesco").find("tbody");
        var responsavel = value['nome'];
        var cpfResponsavel = value["cpf"];
        var IdResponsavelPeloAluno = value["idResponsavelPeloAluno"];
        var parentescoResponsavel = value["parentescoResponsavel"];
        var idEnderecoResp = value["idEnderecoResp"];
        var linha = novaLinha(responsavel, cpfResponsavel, IdResponsavelPeloAluno, parentescoResponsavel, idEnderecoResp);

        corpoTabela.append(linha);

        $("#selecionaResponsavel").val('');
     })
}

function novaLinha(responsavel, cpfResponsavel, IdResponsavelPeloAluno, parentescoResponsavel, idEnderecoResp) 
{
    var linha = $("<tr>");
    var colunaResponsavel = $("<td>").text(responsavel).attr("class", "align-middle");

    var colunaCpfResponsavel = $("<td>").text(cpfResponsavel).attr("class", "align-middle");


    //Criação da coluna Parentesco:
    var colunaParentesco = $("<td>").attr("align", "center");

    var parentesco = "parentesco";
    var cpf = cpfResponsavel;
    var idSelect = parentesco.concat(cpf);

    // var selectParentesco = $("<select>").addClass("form-control");
    var selectParentesco = $("<select>").addClass("form-control").attr(
    {
        id: idSelect,
        onclick: "salvarResponsavelDoAluno('" + cpf + "', "+ IdResponsavelPeloAluno +")"
    });
    

    var optionSel = $("<option>").attr("value", "0").text("Selecione...");
    var optionMae = $("<option>").attr("value", "Mãe").text("Mãe");
    var optionPai = $("<option>").attr("value", "Pai").text("Pai");
    var optionRes = $("<option>").attr("value", "Responsável").text("Responsável");

    selectParentesco.append(optionSel);
    selectParentesco.append(optionMae);
    selectParentesco.append(optionPai);
    selectParentesco.append(optionRes);
    colunaParentesco.append(selectParentesco);


    parentescoResponsavel === null ? selectParentesco.val(parentescoResponsavel = "0") : selectParentesco.val(parentescoResponsavel);
    
    if (idEnderecoResp === null)
    {
        idEnderecoResp = 1
    }
    console.log(idEnderecoResp);

    //Criação da coluna Editar:
    var colunaEditar = $("<td>").attr({
        'align': "center",
        'data-nome': responsavel,
        'data-cpf': cpf,
        'data-enderecoresp': idEnderecoResp,
        'data-toggle': "modal",
        'data-target': "#ResponsaveisModal",
        'onclick': "($('#ModalAlunoFormulario').modal('hide'))"
    });
    var botaoEditar = $("<a>").addClass("btn btn-outline-info").attr("href", "#");
    var imagemEditar = $("<img>").attr("src", "img/editar.png");
    botaoEditar.append(imagemEditar);
    colunaEditar.append(botaoEditar);

    
    //Criação da coluna Remover:
    cpfSemPonto = cpf.replace(".", "");
    cpfSemPonto = cpfSemPonto.replace(".", "");
    cpfSemTraco = cpfSemPonto.replace("-", "");

    var idAluno = sessionStorage.getItem('idBtnAlterar');

    var colunaRemover = $("<td>").attr("align", "center");
    var botaoRemover = $("<button>")
        .addClass("btn btn-outline-danger")
        .attr({
            'id': "btnExcluir" + cpfSemTraco,
            'onclick': "excluirResponsavel(" + idAluno + ", '" + cpf + "', " + IdResponsavelPeloAluno + ")"
        });
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

$('#ResponsaveisModal').on('hidden.bs.modal', function () {

    buscaResponsaveisVinculadosAoAluno();
});