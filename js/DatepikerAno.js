$(function() {    
    configuraDatepikerParaMes();
});

function configuraDatepikerParaMes() {
    $('#anoLetivo').datepicker({  
            format: "yyyy",  
            language: "pt-BR",
            viewMode: "years", 
            minViewMode: "years",
            language:"pt-BR",
            todayHighlight: true
        });
}