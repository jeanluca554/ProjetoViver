$(function() {    
    configuraDatepikerComum();
});

function configuraDatepikerComum() {
    $('#dataNascimento').datepicker({  
            format: "dd/mm/yyyy",  
            language: "pt-BR",
            todayHighlight: true
        });
}