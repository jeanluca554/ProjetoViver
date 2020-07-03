$(function() {
    //$("#btnTesteSalvaAluno").click(salvarResponsavelDoAluno2);
    //salvarResponsavelDoAluno2();

    /*$("#parentesco").on("change", function () {
        var conteudo = $("option:selected").text();
            alert(conteudo);

        if ($(this).children){
            alert("aqui");
        }
        
    });*/
    
});

function salvarResponsavelDoAluno() {
    var table = $("#tabelaParentescoTeste");
    
    table.find('tr').each(function() {
        $(this).find('td').each(function() {
            console.log(this);
        })
    })
}

function salvarResponsavelDoAluno2() {
    $("#parentesco").on("change", function () {
        var conteudo = $("option:selected").text();
        alert(conteudo);

        if ($(this).children) {
            var conteudo = $("option:selected").text();
            alert(conteudo);
        }

    });

}

function salvarResponsavelDoAluno3(option) {
    
        alert(option);

        

}

function salvarResponsavelDoAluno4() {
    var x = document.getElementById("parentesco4").selectedIndex;
    var y = document.getElementById("parentesco4").options;
    alert("Index: " + y[x].index + " is " + y[x].text);

}