$("#prosseguirEmail").on("click", function () {
    var email1 = $('#primeiroEmail').val();
    var email2 = $('#segundoEmail').va();

    if (email1 != email2) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Os e-mails digitados são diferentes',
            showClass: {
                popup: 'animated tada'
                // backdrop: 'animated tada'
            }
        })

        $('#primeiroEmail').val('');
        $('#segundoEmail').val('');
    }
    else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Tá certo jovem',
            showClass: {
                popup: 'animated tada'
                // backdrop: 'animated tada'
            }
        })
    }
})

$("#prosseguirEmail").on("click", function () {
    var email1 = $('#primeiroEmail').val();
    var email2 = $('#segundoEmail').va();

    if (email1 != email2) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Os e-mails digitados são diferentes',
            showClass: {
                popup: 'animated tada'
                // backdrop: 'animated tada'
            }
        })

        $('#primeiroEmail').val('');
        $('#segundoEmail').val('');
    }
    else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Tá certo jovem',
            showClass: {
                popup: 'animated tada'
                // backdrop: 'animated tada'
            }
        })
    }
})