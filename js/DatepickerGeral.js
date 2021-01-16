$(function() {    
    datasGerais();
});

function datasGerais() {
    $('.anoLetivo').datepicker({
        format: "yyyy",
        language: "pt-BR",
        viewMode: "years",
        minViewMode: "years",
        language: "pt-BR",
        todayHighlight: true
    });

    $('#dataMatricula').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        todayHighlight: true
    });

    $('#dataNascimento').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        todayHighlight: true
    });
}