$(function() {
   $("#btnAdicionaResponsavel").click(adicionaResponsaveis);   
});


function adicionaResponsaveis()
{
    $("#btnAdicionaResponsavel").attr("disabled", true);

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