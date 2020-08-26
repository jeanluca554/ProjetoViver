$('#ModalAlunoFormulario').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var nome = button.data('nome')
    var id = button.data('id')

    if (typeof nome === "undefined")
    {
        var modal = $(this)
        modal.find('.modal-title').text('Cadastrar Aluno ');
        modal.find('#botao-salvar-aluno').show();
        modal.find('#botao-alterar-aluno').hide();
    }

    else
    {
        var modal = $(this)
        modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nome)
        sessionStorage.setItem('alunoAlterando', id);

        $.ajax({
            url: 'DAO/banco-alunos-post.php',
            dataType: 'json',
            method: 'post',
            data: { idAluno: id, funcao: 1 },

            success: function (response) {
                $.each(response, function (key, value) {
                    var dataNascimento = trataData(value['nascimento_aluno']);
                    // var nacimento = trataData(dataNascimento);
                    var sexo = value["sexo"];
                    var nacionalidade = value["nacionalidade"];
                    var estadoNascimento = value["estado_nascimento"];
                    var cidadeNascimento = value["cidade_nascimento"];
                    var paisNascimento = value["pais_nascimento"];

                    modal.find('#nomeAluno').val(nome);
                    modal.find('#dataNascimento').datepicker("setDate", dataNascimento);

                    //solução para o problema gerado ao clicar no campo datas que estava alterando o botão de alterar aluno.
                    modal.find('#dataNascimento').click(function () {
                        modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nome);
                        modal.find('#botao-salvar-aluno').hide();
                        modal.find('#botao-alterar-aluno').show();
                    })


                    modal.find('#sexo').val(sexo);
                    modal.find('#nacionalidade').val(nacionalidade);
                    if (nacionalidade == "Brasileiro")
                    {
                        $("#divEstadoNascimento").show();
                        modal.find('#selectEstadoNascimento').val(estadoNascimento);

                        $("#divCidadeNascimento").show();
                        var option = $("<option>").attr("value", cidadeNascimento).text(cidadeNascimento);
                        modal.find('#selectCidadeNascimento').append(option);

                        $("#divPaisOrigem").hide();
                    }
                    else 
                    {
                        if (nacionalidade == "Estrangeiro")
                        {
                            $("#divPaisOrigem").show();
                            modal.find('#paisOrigem').val(paisNascimento);

                            $("#divEstadoNascimento").hide();
                            $("#divCidadeNascimento").hide();
                        }
                    }
                    
                    modal.find('#botao-salvar-aluno').hide();
                    modal.find('#botao-alterar-aluno').show();
                })
            },
            error: function (response) {
                console.log(response);
                Swal.fire({
                    type: 'warning',
                    title: 'Algo errado aconteceu',
                    text: 'Erro ao buscar os dados do aluno' + response,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            }
        });
    }   

    function trataData(date) {
        dataArray = date.split("-");
        dataInvertida = dataArray.reverse();
        dataCorrigida = dataInvertida.join('/');
        return dataCorrigida;
    }
})