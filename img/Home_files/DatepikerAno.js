$(function() {    
    configuraDatepikerParaMes();
    // $("#btnNovaMatricula").on("click", configuraDatepikerParaMes);
});

function configuraDatepikerParaMes() {
    var data = new Date();
        ano = data.getFullYear().toString();
        dia = data.getDay().toString();
    $('.anoLetivo').datepicker({  
            format: "yyyy",  
            language: "pt-BR",
            viewMode: "years", 
            minViewMode: "years",
            language:"pt-BR",
            todayHighlight: true
        }).datepicker('setDate', ano);

    $('#dataMatricula').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        todayHighlight: true
    }).datepicker('setDate', dia);

    $('#dataAlteracaoMatricula').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        todayHighlight: true
    }).datepicker('setDate', dia);
    

    $('#dataNascimento').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        todayHighlight: true
    });
}

