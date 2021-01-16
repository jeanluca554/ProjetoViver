$(function() {    
    configuraDataTable();
});

function configuraDataTable() {
    $('.tabelaPTBR').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Nada encontrado - desculpe.",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Último",
                "next":       "Próximo",
                "previous":   "Anterior"
            },
            "infoFiltered": "(filtrar de _MAX_ registro no total)"
        }
    });
}

function configurarTabelaResponsavel()
{
    $('#tabelaParentesco').DataTable({
        "language": {
            "zeroRecords": "Nenhum responsável foi adicionado ainda"
                
        },
        "paging":   false,
        "ordering": false,
        "searching": false,
        "info":     false 

    });
}
