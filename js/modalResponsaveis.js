$('#ResponsaveisModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var nome = button.data('nome')
    console.log(nome);
    var cpf = button.data('cpf')
    var enderecoResp = button.data('enderecoresp');
    console.log(enderecoResp);

    enderecoResp == '' ? sessionStorage.setItem('idEnderecoResp', 1) : sessionStorage.setItem('idEnderecoResp', enderecoResp);

    if (typeof nome === "undefined")
    {
        var modal = $(this)
        modal.find('.modal-title').text('Cadastrar Responsável');

        modal.find('#botao-salvar-dados-pessoais-responsavel').show();
        modal.find('#botao-alterar-dados-pessoais-responsavel').hide();

        modal.find('#botao-salvar-endereco-responsavel').show();
        modal.find('#botao-alterar-endereco-responsavel').hide();
    }

    else
    {
        var modal = $(this)
        modal.find('.modal-title').text('Alterar dados do responsável' + nome + '-' + cpf);
        sessionStorage.setItem('responsavelID', cpf);

        $.ajax({
            url: 'DAO/banco-responsaveis-post.php',
            dataType: 'json',
            method: 'post',
            data: { cpf: cpf, funcao: 6 },

            success: function (response) {

                $.each(response, function (key, value) {
                    var rgResp = value["rg_responsavel"];
                    console.log(rgResp);

                    var telefonePessoal = value["telefone_pessoal_responsavel"];
                    var telefoneAdicional = value["telefone_adicional_responsavel"];

                    modal.find('#nomeResponsavel').val(nome);
                    modal.find('#cpf').val(cpf);
                    modal.find('#rgResponsavel').val(rgResp);
                    modal.find('#telefone1').val(telefonePessoal);
                    modal.find('#telefone2').val(telefoneAdicional);
                    
                    
                    modal.find('#botao-salvar-dados-pessoais-responsavel').hide();
                    modal.find('#botao-alterar-dados-pessoais-responsavel').show();

                    $('#enderecoResponsavel-tab').attr('class', 'nav-link');
                    $('#enderecoResponsavel-tab').attr('href', '#abaEnderecoResponsavel');
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
            url: 'DAO/banco-responsaveis-post.php',
            dataType: 'json',
            method: 'post',
            data: { enderecoResp: enderecoResp, funcao: 7 },

            success: function (response) {
                $.each(response, function (key, value) {
                    var cepResp = value["cep"];
                    var logradouroResp = value["logradouro"];
                    var numeroCasaResp = value["numero_casa"];
                    var complementoResp = value["complemento"];
                    var bairroResp = value["bairro"];
                    var cidadeResp = value["cidade"];
                    var estadoResp = value["estado"];

                    modal.find('#cepResponsavel').val(cepResp);
                    modal.find('#logradouroResponsavel').val(logradouroResp);
                    modal.find('#numeroCasaResponsavel').val(numeroCasaResp);
                    modal.find('#complementoResponsavel').val(complementoResp);
                    modal.find('#bairroResponsavel').val(bairroResp);
                    modal.find('#selectEstadoResidenciaResponsavel').val(estadoResp);
                    var option = $("<option>").attr("value", cidadeResp).text(cidadeResp);
                    modal.find('#selectCidadeResidenciaResponsavel').append(option);

                    modal.find('#botao-salvar-endereco-responsavel').hide();
                    modal.find('#botao-alterar-endereco-responsavel').show();
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
})