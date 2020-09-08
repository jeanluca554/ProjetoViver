$(function() {
    buscaCidades();       
    buscaCidadesAluno();       
    buscaCidadesResponsavel();       
});


function buscaCidades()
{
    /*$("#cidadeResidencia").keyup(function(){
        var cidadeDigitada = $(this).val();
        if(cidadeDigitada != ''){
            $.ajax({
                url: 'DAO/banco-cidades-post.php',
                method: 'post',
                data: {cidade:cidadeDigitada, funcao: 2},

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
            $("#cidadeResidencia").val($(this).text());
            $("#show-list").html('');
        });
    });*/

    $("#selectEstadoResidencia").on("change", function() 
    {   
        var codEstado = $("#selectEstadoResidencia").val();
        
        $.ajax({                
            url: 'DAO/banco-cidades-post.php',
            type: 'POST',
            data: {funcao:1, id:codEstado},
            beforeSend: function()
            {                
                $("#selectCidadeResidencia").html("<option>Carregando...</option>");                
            },

            success: function(data)
            {
                $("#selectCidadeResidencia").html(data);
                //$("#cidadeResidencia").html(data);
            },
            error: function(data)
            {
                alert("Informações da requisição: \n" + data.getAllResponseHeaders());
                $("#selectCidadeResidencia").html("<option>Houve um erro ao carregar as cidades</option>");
            }
            
        })
    });
}

function buscaCidadesAluno() {
    $("#selectEstadoResidenciaAluno").on("change", function () {
        var codEstado = $("#selectEstadoResidenciaAluno").val();

        $.ajax({
            url: 'DAO/banco-cidades-post.php',
            type: 'POST',
            data: { funcao: 1, id: codEstado },
            beforeSend: function () {
                $("#selectCidadeResidenciaAluno").html("<option>Carregando...</option>");
            },

            success: function (data) {
                $("#selectCidadeResidenciaAluno").html(data);
                //$("#cidadeResidencia").html(data);
            },
            error: function (data) {
                alert("Informações da requisição: \n" + data.getAllResponseHeaders());
                $("#selectCidadeResidenciaAluno").html("<option>Houve um erro ao carregar as cidades</option>");
            }

        })
    });
}

function buscaCidadesResponsavel() {
    $("#selectEstadoResidenciaResponsavel").on("change", function () {
        var codEstado = $("#selectEstadoResidenciaResponsavel").val();

        $.ajax({
            url: 'DAO/banco-cidades-post.php',
            type: 'POST',
            data: { funcao: 1, id: codEstado },
            beforeSend: function () {
                $("#selectCidadeResidenciaAluno").html("<option>Carregando...</option>");
            },

            success: function (data) {
                $("#selectCidadeResidenciaResponsavel").html(data);
                //$("#cidadeResidencia").html(data);
            },
            error: function (data) {
                alert("Informações da requisição: \n" + data.getAllResponseHeaders());
                $("#selectCidadeResidenciaResponsavel").html("<option>Houve um erro ao carregar as cidades</option>");
            }

        })
    });
}