$(function () {
    buscaAlunos();
});

function buscaAlunos() 
{
    $.ajax({
        url: 'DAO/AlunoDAO.php',
        method: 'post',
        data: { funcao: 1 },

        success: function (response) {
            $("#show-list").html(response);
        }
    });
}