$("#nacionalidade").on("input", function() 
{
    var nomeDigitado = $("#selectResponsavel").val()

    $.ajax(
    {                
        url: 'DAO/banco-cidades-post.php',
        type: 'POST',
        data: {id:nomeDigitado},
        beforeSend: function()
        {                
            $("#selectCidadeNascimento").html("<option>Carregando...</option>");                
        },

        success: function(data)
        {
            $("#selectCidadeNascimento").html(data);
        },
        
        error: function(data)
        {
            alert("Informações da requisição: \n" + data.getAllResponseHeaders());
            $("#selectCidadeNascimento").html("<option>Houve um erro ao carregar as cidades</option>");
        }
        
    })
}); 