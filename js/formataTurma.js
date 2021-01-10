$(function() {  
    $('#cadastrar-turma').on("click", setCadastrarTurma);
    $('#siglaTurma').mask('A', {
        'translation': {
            A: {pattern: /[A-Za-z]/}
        }
        ,onKeyPress: function (value, event) {
            event.currentTarget.value = value.toUpperCase();
        }
    });
    $('#capacidadeFisica').mask('00');
    $('#capacidadeFisica').on('blur', garanteCapacidade);
    $('.fecharModalCadastroTurma').on("click", recarregarPagina);
});

function setCadastrarTurma()
{
    $('#botao-alterar-turma').hide();
    $('#botao-salvar-turma').show();

    $('#tipoEnsinoTurma').val(0);
    $('#siglaTurma').val("");
    $('#turno').val(0);
    $('#capacidadeFisica').val("");
    $('#ModalTurma').find('.modal-title').text('Cadastrar Turma');

    var ano = pegaAnoAtual();
    // console.log(ano);
    $('#anoLetivo').val(ano);

}

function pegaAnoAtual()
{
    var data = new Date(),
        ano = data.getFullYear();
    
    return ano;
}

function setAlterarTurma(id, sigla, tipoEnsino, turno, ano, capacidade, alunos) {
    $('#botao-salvar-turma').hide();
    $('#botao-alterar-turma').show();

    $('#ModalTurma').find('.modal-title').text('Alterar Matriz Curricular - ' + alunos + ' aluno(s) ativos');

    $('#idTurma').val(id);
    $('#tipoEnsinoTurma').val(tipoEnsino);
    $('#siglaTurma').val(sigla);
    $('#anoLetivo').val(ano);
    $('#turno').val(turno);
    $('#capacidadeFisica').val(capacidade);
    $('#alunosAtivos').val(alunos);

}


function recarregarPagina() {
    location.reload();
}


function garanteCapacidade()
{
    var alunosAtivos = $("#alunosAtivos").val();
    var capacidade = $("#capacidadeFisica").val();

    console.log(alunosAtivos, capacidade);

    if (alunosAtivos == "")
    {
        console.log("está no criar")
    }
    else
    {
        if (capacidade < alunosAtivos)
        {
            Swal.fire({
                type: 'warning',
                title: 'Atenção!',
                text: 'A capacidade da sala não pode ser menor que a quantidade de alunos ativos.',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
            $("#capacidadeFisica").val(alunosAtivos);
        }
    }
}