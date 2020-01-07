$(function() {
    buscaResponsaveis();
    $("#btnAdicionaResponsavel").click(adicionaResponsaveis); 
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
            $("#btnAdicionaResponsavel").click(adicionaResponsaveis(responsavelSemCPF[1].trim()));
        });
    });
}

function adicionaResponsaveis(cpf_responsavel)
{
    //$("#btnAdicionaResponsavel").attr("disabled", true);

    $.ajax({
        url: 'DAO/banco-responsaveis-post.php',
        method: 'post',
        data: {cpf:cpf_responsavel, funcao: 2},

        success: function(response){
            $("#show-list").html(response);
        }
    });
}

function adicionaResponsaveis()
{
    //$("#btnAdicionaResponsavel").attr("disabled", true);

    var corpoTabela = $(".tabelaParentesco").find("tbody");
    var responsavel = $("#selecionaResponsavel").val();
}

function inserePla() {
    var corpoTabela = $(".placar").find("tbody");
    var usuario = $("#usuarios").val();
    var numPalavras = $("#contador-palavras").text();

    var linha = novaLinha(usuario, numPalavras);
    linha.find(".botao-remover").click(removeLinha);

    corpoTabela.append(linha);
    $(".placar").slideDown(500);
    scrollPlacar();
}
