$(document).on('shown.bs.modal', '#ModalAlunoFormulario', function (event) 
{   
    var modalFoiAberto = sessionStorage.getItem('modalCadastroAlunoFoiAberto');

    do
    {    
        sessionStorage.setItem('modalCadastroAlunoFoiAberto', 1);
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var nome = button.data('nome')
        var id = button.data('id')
        var idEnderecoResidencial = button.data('endereco');
        console.log("esse é o id: " + id)

        if (id == "undefined")
        {
            console.log("o id é igual a undefined");
        }
        else
        {
            sessionStorage.setItem('alunoID', id);
        }

        // alguns alunos foram cadastrados sem endereço, então atribui-se o endereço padrão "1":
        idEnderecoResidencial == '' ? sessionStorage.setItem('idEnderecoAluno', 1) : sessionStorage.setItem('idEnderecoAluno', idEnderecoResidencial);

        // Verifica se foi cliclado em alterar ou em cadastrar aluno:
        //obs: Variáveis setadas no arquivo js/formataCamposAluno.js
        var nomeBtnAlterarSession = sessionStorage.getItem('nomeBtnAlterar');
        console.log("O nome para alterar: " + nomeBtnAlterarSession);

        var idBtnAlterarSession = sessionStorage.getItem('idBtnAlterar');
        console.log("O ID para alterar: " + idBtnAlterarSession);
        
        var enderecoBtnAlterarSession = sessionStorage.getItem('idBtnEndereco');
        console.log("O endereço para alterar: " + enderecoBtnAlterarSession);

        if (nomeBtnAlterarSession == null) {
            console.log(nome);
            var modal = $(this)
            modal.find('.modal-title').text('Cadastrar Aluno ');

            modal.find('#botao-salvar-aluno').show();
            modal.find('#botao-alterar-aluno').hide();

            modal.find('#botao-salvar-endereco-aluno').show();
            modal.find('#botao-alterar-endereco-aluno').hide();

            modal.find('#botao-salvar-responsavel-do-aluno').show();
            modal.find('#botao-alterar-responsavel-do-aluno').hide();

            $('#enderecoAluno-tab').attr('class', 'nav-link disabled');
            $('#responsaveisAluno-tab').attr('class', 'nav-link disabled');

            //evita que toda configuração seja feita do zero
            sessionStorage.setItem('modalCadastroAlunoFoiAberto', 1);
        }
        else
        {
            // libera a aba matricula porque clicou em editar
            sessionStorage.setItem('abaMatricula', 1);

            //evita que toda configuração seja feita do zero
            sessionStorage.setItem('modalCadastroAlunoFoiAberto', 1);
            
            var modal = $(this)
            modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nomeBtnAlterarSession + '-' + idBtnAlterarSession);
            sessionStorage.setItem('alunoID', id);

            liberaAbasModalAluno();

            // Preenche a Aba Dados do Aluno
            $.ajax({
                url: 'DAO/banco-alunos-post.php',
                dataType: 'json',
                method: 'post',
                data: { idAluno: idBtnAlterarSession, funcao: 1 },

                success: function (response) {
                    $.each(response, function (key, value) {
                        var dataNascimento = trataData(value['nascimento_aluno']);
                        var sexo = value["sexo"];
                        var nacionalidade = value["nacionalidade"];
                        var estadoNascimento = value["estado_nascimento"];
                        var cidadeNascimento = value["cidade_nascimento"];
                        var paisNascimento = value["pais_nascimento"];
                        var respFinanceiro = value["resp_financeiro"];
                        var respDidatico = value["resp_didatico"];

                        sessionStorage.setItem('respFinanceiro', respFinanceiro);
                        sessionStorage.setItem('respDidatico', respDidatico);

                        modal.find('#nomeAluno').val(nomeBtnAlterarSession);
                        modal.find('#dataNascimento').datepicker("setDate", dataNascimento);
                        modal.find('#sexo').val(sexo);
                        modal.find('#nacionalidade').val(nacionalidade);

                        if (nacionalidade == "Brasileiro") {
                            $("#divEstadoNascimento").show();
                            modal.find('#selectEstadoNascimento').val(estadoNascimento);

                            $("#divCidadeNascimento").show();
                            var option = $("<option>").attr("value", cidadeNascimento).text(cidadeNascimento);
                            modal.find('#selectCidadeNascimento').append(option);

                            $("#divPaisOrigem").hide();
                        }
                        else {
                            if (nacionalidade == "Estrangeiro") {
                                $("#divPaisOrigem").show();
                                modal.find('#paisOrigem').val(paisNascimento);

                                $("#divEstadoNascimento").hide();
                                $("#divCidadeNascimento").hide();
                            }
                        }

                        modal.find('#botao-salvar-aluno').hide();
                        modal.find('#botao-alterar-aluno').show();

                        modal.find('#botao-salvar-responsavel-do-aluno').hide();
                        modal.find('#botao-alterar-responsavel-do-aluno').show();

                    });    
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

            // Preenche a Aba Endereço do Aluno
            $.ajax({
                url: 'DAO/banco-alunos-post.php',
                dataType: 'json',
                method: 'post',
                data: { idEndereco: enderecoBtnAlterarSession, funcao: 2 },

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
    } while (modalFoiAberto == 0);

    function liberaAbasModalAluno() {
        $('#enderecoAluno-tab').attr('class', 'nav-link');
        $('#enderecoAluno-tab').attr('href', '#abaEnderecoAluno');

        $('#responsaveisAluno-tab').attr('class', 'nav-link');
        $('#responsaveisAluno-tab').attr('href', '#abaResponsaveisAluno');

        $('#matricularAluno-tab').attr('class', 'nav-link');
        $('#matricularAluno-tab').attr('href', '#abaMatricularAluno');
    }

    function trataData(date) {
        dataArray = date.split("-");
        dataInvertida = dataArray.reverse();
        dataCorrigida = dataInvertida.join('/');
        return dataCorrigida;
    }
});