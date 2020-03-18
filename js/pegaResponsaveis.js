$(function() {
    buscaResponsaveis();
    // $("#btnAdicionaResponsavel").click(insereResponsaveisNaTabela);
    // $("#btnAdicionaResponsavel").click(adicionaResponsaveis); 
    $("#btnAdicionaResponsavel").click(buscaResponsaveisVinculadosAoAluno); 
});


function buscaResponsaveis()
{
    $("#selecionaResponsavel").keyup(function(){
        var responsavelDigitado = $(this).val();
        if(responsavelDigitado != ''){
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
            sessionStorage.setItem('cpfResponsavel', responsavelSemCPF[1].trim())
            sessionStorage.setItem('nomeResponsavel', responsavelSemCPF[0].trim())

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
            // Swal.fire({
            //     type: 'success',
            //     title: 'Deu certo',
            //     text: response,
            //     animation: true,
            //     customClass: {
            //         popup: 'animated bounce'
            //     }                      
            // })
            buscaResponsaveisVinculadosAoAluno();            
        },
        error: function(response)
        {
            Swal.fire({
                type: 'warning',
                title: 'Algo errado aconteceu',
                text: 'Erro ao responsavel ao aluno',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
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
            // Swal.fire({
            //     type: 'success',
            //     title: 'Deu certo',
            //     text: 'Fomos buscar os responsáveis vinculados',
            //     animation: true,
            //     customClass: {
            //         popup: 'animated bounce'
            //     }                      
            // })

            insereResponsaveisNaTabela2(response);            
        },
        error: function(response)
        {
            Swal.fire({
                type: 'warning',
                title: 'Algo errado aconteceu',
                text: 'Erro ao responsavel ao aluno',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        }
    });
}

function insereResponsaveisNaTabela2(response)
{
    // console.log(response);
    $.each(response, function(key, value) {
        console.log(response);                     
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
    var colunaResponsavel = $("<td>").text(responsavel);

    var colunaCpfResponsavel = $("<td>").text(cpfResponsavel);


    //Criação da coluna Parentesco:
    var colunaParentesco = $("<td>").attr("align", "center");

    var selectParentesco = $("<select>").addClass("form-control").attr("id", "parentesco");

    var optionSel = $("<option>").attr("value", "0").text("Selecione...");
    var optionMae = $("<option>").attr("value", "Mãe").text("Mãe");
    var optionPai = $("<option>").attr("value", "Pai").text("Pai");
    var optionRes = $("<option>").attr("value", "Responsavel").text("Responsável");

    selectParentesco.append(optionSel);
    selectParentesco.append(optionMae);
    selectParentesco.append(optionPai);
    selectParentesco.append(optionRes);

    colunaParentesco.append(selectParentesco);

    
    /*Criação da coluna Financeiro:
    colunaFinanceiro = $("<td>").attr("align", "center");
    var selectFinanceiro = $("<select>").addClass("form-control").attr("id", "selectFinanceiro");

    var optionFinanceiroSel = $("<option>").attr("value", "0").text("Selecione...");
    var optionMensalidades = $("<option>").attr("value", "Mensalidades").text("Mensalidades");
    var optionDidatico = $("<option>").attr("value", "Ditatico").text("Ditático");

    selectFinanceiro.append(optionFinanceiroSel);
    selectFinanceiro.append(optionMensalidades);
    selectFinanceiro.append(optionDidatico);

    colunaFinanceiro.append(selectFinanceiro);*/
  
    
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
    //linha.append(colunaFinanceiro);
    linha.append(colunaEditar);
    linha.append(colunaRemover);

    return linha;

}

function insereResponsaveisNaTabela3(data)
{
    
    $("#selectCidadeResidencia").html(data);
    
}