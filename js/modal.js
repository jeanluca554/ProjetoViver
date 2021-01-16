$(document).on('shown.bs.modal', '#ModalAlunoFormulario', function (event) {

    var liberarAbas = sessionStorage.getItem('liberaAbas');

    liberarAbas == 1 ? liberaAbasModalAluno() : console.log("ainda não clicou em matricular");
    console.log(liberarAbas);
    
    var button = $(event.relatedTarget) // Button that triggered the modal
    var nome = button.data('nome')
    var id = button.data('id')
    var idEnderecoResidencial = button.data('endereco');

    sessionStorage.setItem('alunoID', id);
    console.log(id)

    sessionStorage.setItem('nomeModal', nome)
    var modal = $(this)

    var verificaEnderecoAluno = sessionStorage.getItem('idBtnEndereco');
    console.log(verificaEnderecoAluno);

    idEnderecoResidencial == '' ? sessionStorage.setItem('idEnderecoAluno', 1) : sessionStorage.setItem('idEnderecoAluno', idEnderecoResidencial);

    modal.find('#dataNascimento').on("focus", function () {
        var nomeBtnAlterar = sessionStorage.getItem('nomeBtnAlterar');
        console.log("clicou Alterar " + nomeBtnAlterar);
        if (nomeBtnAlterar == "undefined" || nomeBtnAlterar == null) {
            modal.find('.modal-title').text('Cadastrar Aluno');
            modal.find('#botao-salvar-aluno').show();
            modal.find('#botao-alterar-aluno').hide();
            //$('#enderecoAluno-tab').attr('class', 'nav-link disabled');
            //$('#responsaveisAluno-tab').attr('class', 'nav-link disabled'); 
        }
        else {
            modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nomeBtnAlterar);
            modal.find('#botao-salvar-aluno').hide();
            modal.find('#botao-alterar-aluno').show();

            //$('#enderecoAluno-tab').attr('class', 'nav-link');
            //$('#enderecoAluno-tab').attr('href', '#abaEnderecoAluno');

            //$('#responsaveisAluno-tab').attr('class', 'nav-link');
            //$('#responsaveisAluno-tab').attr('href', '#abaResponsaveisAluno');
        }

    })

    //Variáveis setadas no arquivo js/formataCamposAluno.js
    var nomeBtnAlterarSession = sessionStorage.getItem('nomeBtnAlterar');
    console.log(nomeBtnAlterarSession);
    var idBtnAlterarSession = sessionStorage.getItem('idBtnAlterar');
    var enderecoBtnAlterarSession = sessionStorage.getItem('idBtnEndereco');
    console.log(idBtnAlterarSession);


    if ( nomeBtnAlterarSession == null) {
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
        //vez = 1;
    } else {
        console.log(nome);
        var modal = $(this)
        modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nomeBtnAlterarSession + '-' + idBtnAlterarSession);
        sessionStorage.setItem('alunoID', id);

        liberaAbasModalAluno();

        $.ajax({
            url: 'DAO/banco-alunos-post.php',
            dataType: 'json',
            method: 'post',
            data: { idAluno: idBtnAlterarSession, funcao: 1 },

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

                    modal.find('#nomeAluno').val(nomeBtnAlterarSession);
                    modal.find('#dataNascimento').datepicker("setDate", dataNascimento);

                    //solução para o problema gerado ao clicar no campo datas que estava alterando o botão de alterar aluno.

                    /* modal.find('#dataNascimento').on("blur", function () {
                        modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nome);
                        modal.find('#botao-salvar-aluno').hide();
                        modal.find('#botao-alterar-aluno').show();
                    })
                    modal.find('#dataNascimento').on("click", function () {
                        modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nome);
                        modal.find('#botao-salvar-aluno').hide();
                        modal.find('#botao-alterar-aluno').show();
                    }) */



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
        vez = 1;
    }




    /* var vez = 0;
    modal.find('#dataNascimento').on("click", function () 
    {
        var nomeModal = sessionStorage.getItem('nomeModal');
        console.log("click cadastrar")
        console.log(nomeModal)
        if (nomeModal == "undefined") {
            modal.find('.modal-title').text('Cadastrar Aluno');
            modal.find('#botao-salvar-aluno').toggle();
            modal.find('#botao-alterar-aluno').toggle();
        }
        else
        {
            console.log("click alterar")
            modal.find('.modal-title').text('Alterar dados do(a) aluno(a) ' + nome);
            modal.find('#botao-salvar-aluno').hide();
            modal.find('#botao-alterar-aluno').toggle();
        }
    }) */







    /*if (nomeModal == "undefined")
    {
        var modal = $(this)
        modal.find('.modal-title').text('Cadastrar Aluno ');

        modal.find('#botao-salvar-aluno').show();
        modal.find('#botao-alterar-aluno').hide();

        modal.find('#botao-salvar-endereco-aluno').show();
        modal.find('#botao-alterar-endereco-aluno').hide();
        
        modal.find('#botao-salvar-responsavel-do-aluno').show();
        modal.find('#botao-alterar-responsavel-do-aluno').hide();

        //solução para o problema gerado ao clicar no campo datas que estava alterando o botão de salvar aluno.
        /* var tituloModal = modal.find('.modal-title').text();
        console.log(tituloModal + "titulo modal");
        if(tituloModal == "Cadastrar Aluno ")
        {
            console.log(tituloModal + "titulo modal");
            modal.find('#dataNascimento').on("blur", function () {
                modal.find('.modal-title').text('Cadastrar Aluno');
                modal.find('#botao-salvar-aluno').show();
                modal.find('#botao-alterar-aluno').hide();
            })
            modal.find('#dataNascimento').on("click", function () {
                modal.find('.modal-title').text('Cadastrar Aluno');
                modal.find('#botao-salvar-aluno').show();
                modal.find('#botao-alterar-aluno').hide(); 
            })
        } 
    }*/

    function preencherCamposAluno(nome, id, idEnderecoResidencial) {


    }


    function trataData(date) {
        dataArray = date.split("-");
        dataInvertida = dataArray.reverse();
        dataCorrigida = dataInvertida.join('/');
        return dataCorrigida;
    }

    function configurarModalCadastrar() {
        console.log("Entrei no modal, Jovem");
        var modal = $(this)
        modal.find('.modal-title').text('Cadastrar Aluno ');

        modal.find('#botao-salvar-aluno').show();
        modal.find('#botao-alterar-aluno').hide();

        modal.find('#botao-salvar-endereco-aluno').show();
        modal.find('#botao-alterar-endereco-aluno').hide();

        modal.find('#botao-salvar-responsavel-do-aluno').show();
        modal.find('#botao-alterar-resonsavel-do-aluno').hide();

        //solução para o problema gerado ao clicar no campo datas que estava alterando o botão de salvar aluno.
        var tituloModal = modal.find('.modal-title').text();
        console.log(tituloModal + "titulo modal");
        if (tituloModal == "Cadastrar Aluno ") {
            console.log(tituloModal + "titulo modal");
            modal.find('#dataNascimento').on("blur", function () {
                modal.find('.modal-title').text('Cadastrar Aluno');
                modal.find('#botao-salvar-aluno').show();
                modal.find('#botao-alterar-aluno').hide();
            })
            modal.find('#dataNascimento').on("click", function () {
                modal.find('.modal-title').text('Cadastrar Aluno');
                modal.find('#botao-salvar-aluno').show();
                modal.find('#botao-alterar-aluno').hide();
            })
        }
    }
});


function liberaAbasModalAluno()
{
    $('#enderecoAluno-tab').attr('class', 'nav-link');
    $('#enderecoAluno-tab').attr('href', '#abaEnderecoAluno');

    $('#responsaveisAluno-tab').attr('class', 'nav-link');
    $('#responsaveisAluno-tab').attr('href', '#abaResponsaveisAluno');

    $('#matricularAluno-tab').attr('class', 'nav-link');
    $('#matricularAluno-tab').attr('href', '#abaMatricularAluno');
}