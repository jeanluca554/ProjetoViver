$(function() {
    $("#botao-salvar-boletim").on("click", salvarBoletim);
});


function salvarBoletim() 
{
    const swalWithBootstrapButtons = Swal.mixin(
    {
        customClass:
        {
            confirmButton: 'btn btn-success btn-lg',
            cancelButton: 'btn btn-danger btn-lg mr-3'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Atenção!',
        text: "Tem certeza que deseja salvar as alterações?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, salvar!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) 
        {
            var indices = [];

            //Pega os indices
            $('#tabelaAlunosDaTurma thead tr th').each(function () {
                indices.push($(this).text());
            });

            var arrayItens = [];

            //Pecorre todos os produtos
            $('#tabelaAlunosDaTurma tbody tr').each(function (index) {

                var obj = {};

                //Controle o objeto
                $(this).find('td').each(function (index) {
                    if ($(this).text() == "")
                    {
                        obj[indices[index]] = $(this).find('input').val();
                    }
                    else{
                        obj[indices[index]] = $(this).text();
                    }
                    
                });

                //Adiciona no arrray de objetos
                arrayItens.push(obj);

            });

            //Mostra dados pegos no console
            console.log(arrayItens);

            $.each(arrayItens, function (key, value) {
                var idTurmaBoletim = $('#idTurmaBoletim').val();
                var idDisciplinaBoletim = $('#idDisciplinaBoletim').val();
                var bimestreAluno = $('#bimestreBoletim').val();

                var idAluno = value['Id'];
                var situacaoAluno = value['Situação'];
                var prova1Aluno = value['Prova 1'];
                var prova2Aluno = value['Prova 2'];
                var trabalhoAluno = value['Trabalho'];
                var recuperacaoAluno = value['Recuperação'];
                var mediaAluno = value['Média'];
                var faltasAluno = value['Faltas'];
                var mediaParcial = value['Média Parcial'];

                $.ajax({
                    url: 'DAO/banco-boletim-notas-salvar.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        idTurmaBoletim: idTurmaBoletim,
                        idDisciplinaBoletim: idDisciplinaBoletim,
                        idAlunoBoletim: idAluno,
                        bimestreAlunoBoletim: bimestreAluno,
                        situacaoAluno: situacaoAluno,
                        prova1Aluno: prova1Aluno,
                        prova2Aluno: prova2Aluno,
                        trabalhoAluno: trabalhoAluno,
                        recuperacaoAluno: recuperacaoAluno,
                        mediaAluno: mediaAluno,
                        faltasAluno: faltasAluno,
                        mediaParcial: mediaParcial,
                    },

                    success: function (ultimoId) {
                        if (ultimoId['mensagem'] != 'erro') {
                            console.log("ultimo ID alterado: " + ultimoId);

                            Swal.fire({
                                type: 'success',
                                title: 'Concluído',
                                text: 'As notas foram salvas com sucesso!',
                                animation: true,
                                customClass: {
                                    popup: 'animated bounce'
                                }
                            }).then(function () {
                                // location.reload();
                                // setAssociacao(idMatriz, idTurma);
                            });
                        }
                        else {
                            Swal.fire({
                                type: 'warning',
                                title: ultimoId['title'],
                                text: ultimoId['text'],
                                animation: false,
                                customClass: {
                                    popup: 'animated tada'
                                }
                            })
                        }
                    },

                    error: function (ultimoId) {
                        console.log(ultimoId);
                        Swal.fire({
                            type: 'warning',
                            title: 'Erro ao salavar o boletim',
                            text: ultimoId,
                            animation: false,
                            customClass: {
                                popup: 'animated tada'
                            }
                        })
                    }
                });   
            })




            // var idMatriz = sessionStorage.getItem("idMatriz");
            // var idTurma = sessionStorage.getItem("idTurmaVinculo");
            // var idDisciplina = $("#alterarVinculoDisciplina").val();
            // var idProfessor = $("#alterarVinculoProfessor").val();
                
            
        } 
        else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'O as notas e faltas não foram salvas',
                'error'
            )
        }
    })   
}
