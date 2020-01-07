$(function(){
    $("#divEstadoNascimento").hide();
    $("#divCidadeNascimento").hide();
    $("#divPaisOrigem").hide();
    $("#spinner").toggle();
});

$("#nacionalidade").on("change", function() 
{
    var nacionalidade = $("#nacionalidade").val()

    switch (nacionalidade) 
    {
        case "1":
            $("#divEstadoNascimento").show();
            $("#divCidadeNascimento").show();
            $("#divPaisOrigem").hide();
            $("#spinner").toggle();                  
            break;

        case "2":
            $("#divPaisOrigem").show();
            $("#divEstadoNascimento").hide();
            $("#divCidadeNascimento").hide();
            break;

        default:
            $("#divEstadoNascimento").hide();
            $("#divCidadeNascimento").hide();
            $("#divPaisOrigem").hide();
    }
});

$("#selectEstadoNascimento").on("change", function() 
{   
    var codEstado = $("#selectEstadoNascimento").val();
    
    $.ajax({                
        url: 'DAO/banco-cidades-post.php',
        type: 'POST',
        data: {funcao:1, id:codEstado},
        beforeSend: function()
        {                
            $("#selectCidadeNascimento").html("<option>Carregando...</option>");                
        },

        success: function(data)
        {
            $("#selectCidadeNascimento").html(data);
            $("#cidadeResidencia").html(data);
        },
        error: function(data)
        {
            alert("Informações da requisição: \n" + data.getAllResponseHeaders());
            $("#selectCidadeNascimento").html("<option>Houve um erro ao carregar as cidades</option>");
        }
        
    })
    .always(function()
    {
        $("#spinner").toggle();
    })
});
