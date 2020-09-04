$('#ModalAlunoFormulario').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var nome = button.data('nome')
    var id = button.data('id')
    var idEnderecoResidencial = button.data('endereco');

    idEnderecoResidencial == '' ? sessionStorage.setItem('idEnderecoAluno', 1) : sessionStorage.setItem('idEnderecoAluno', idEnderecoResidencial);

    if (typeof nome === "undefined")
    {
        var modal = $(this)
        modal.find('.modal-title').text('Cadastrar Aluno ');

        modal.find('#botao-salvar-aluno').show();
        modal.find('#botao-alterar-aluno').hide();

        modal.find('#botao-salvar-endereco-aluno').show();
        modal.find('#botao-alterar-endereco-aluno').hide();
        
        modal.find('#botao-salvar-resonsavel-do-aluno').show();
        modal.find('#botao-alterar-resonsavel-do-aluno').hide();
    }

    else
    {
        var modal = $(this)
        modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nome + '-' + id);
        sessionStorage.setItem('alunoID', id);

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
                    var respFinanceiro = value["resp_financeiro"];
                    sessionStorage.setItem('respFinanceiro', respFinanceiro);
                    var respDidatico = value["resp_didatico"];
                    sessionStorage.setItem('respDidatico', respDidatico);

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



                    modal.find('#botao-salvar-resonsavel-do-aluno').hide();
                    modal.find('#botao-alterar-resonsavel-do-aluno').show();
                })
            },

            error: function (XMLHttpRequest, textStatus, errorThrown) {
                for (i in XMLHttpRequest) {
                    if (i != "channel")
                        document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                }
            }
            /* error: function (response) {
                console.log(response);
                Swal.fire({
                    type: 'warning',
                    title: 'Algo errado aconteceu',
                    text: 'Erro ao buscar os dados do aluno, Jovem' + response,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            } */
        });

        $.ajax({
            url: 'DAO/banco-alunos-post.php',
            dataType: 'json',
            method: 'post',
            data: { idEndereco: idEnderecoResidencial, funcao: 2 },

            success: function (response) {
                $.each(response, function (key, value) {
                    var cep = value["cep"];
                    var logradouro = value["logradouro"];
                    var numeroCasa = value["numero_casa"];
                    var complemento = value["complemento"];
                    var bairro = value["bairro"];
                    var cidade = value["cidade"];
                    var estado = value["estado"];

                    modal.find('#cepAluno').val(cep);
                    modal.find('#logradouroAluno').val(logradouro);
                    modal.find('#numeroCasaAluno').val(numeroCasa);
                    modal.find('#complementoAluno').val(complemento);
                    modal.find('#bairroAluno').val(bairro);
                    modal.find('#selectEstadoResidenciaAluno').val(estado);
                    var option = $("<option>").attr("value", cidade).text(cidade);
                    modal.find('#selectCidadeResidenciaAluno').append(option);

                    modal.find('#botao-salvar-endereco-aluno').hide();
                    modal.find('#botao-alterar-endereco-aluno').show();
                })
            },

            error: function (XMLHttpRequest, textStatus, errorThrown) {
                for (i in XMLHttpRequest) {
                    if (i != "channel")
                        document.write(i + " : " + XMLHttpRequest[i] + "<br>")
                }
            }

            /* error: function (response) {
                console.log(response);
                Swal.fire({
                    type: 'warning',
                    title: 'Algo errado aconteceu',
                    text: 'Erro ao buscar os dados do aluno eita' + response,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })
            } */
        });

    }   

    function trataData(date) {
        dataArray = date.split("-");
        dataInvertida = dataArray.reverse();
        dataCorrigida = dataInvertida.join('/');
        return dataCorrigida;
    }
})