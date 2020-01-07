$(function() {    
    configuraDatepikerParaMes();
});

function configuraDatepikerParaMes() {
    $('#mes').datepicker({  
            format: "mm/yyyy",  
            language: "pt-BR",
            viewMode: "months", 
            minViewMode: "months",
            language:"pt-BR"
        });
}