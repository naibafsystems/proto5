$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    var direccion = '';

    $(window).scroll(function() {
        if ($(this).scrollTop() > 400) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function() {
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });

    $('[data-tooltip!=""]').qtip({
        content: { attr: 'data-tooltip' },
        position: { my: 'top left' },
        style: { classes: 'qtip-bootstrap qtip-DANE' }
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('#complementos').textoDireccion().maxlength(100);

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            complementos: {required: true }
        },
        messages: {
            complementos: { required: 'ERROR: Digite la dirección.' }
        },
        /*acc*/
        // onfocusout: function (element) {
        //     if(!$(element).valid()) {
        //         $('#' + $(element).attr('id')).focus();
        //     }
        // },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').first().append(error.attr('role', 'alert'));
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').first().addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').first().removeClass('has-error');
        },
        submitHandler: function (form) {
            return true;
        }
    });

    $('#btnSiguiente').on('click', function() {
        if ($('#frmUbicacion').valid() == true) {
            $('#divContent').addClass('hidden');

            if($('#complementos').val().length > 0) {
                direccion = ' ' + $('#complementos').val();
            }
            $('#direccion-confirm').html(direccion);
            $('#mensajeConfirmacion').removeClass('hidden');
        }
    });

    $('#btnAnteriorConfirmacion').on('click', function() {
        $('#divContent').removeClass('hidden');
        $('#mensajeConfirmacion').addClass('hidden');
    });

    $('#btnSiguienteConfirmacion').on('click', function() {
        $('.alert').addClass('hidden');
        var frm = $('#frmUbicacion').serialize();
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'ubicacion/guardar',
            type: 'POST',
            dataType: 'json',
            data: frm + '&duracion=' + duracionPagina(),
            beforeSend: function () {
                $('#msgSuccessConfirm').html('Guardando las respuestas...');
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgSuccessConfirm').removeClass('hidden');
            }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#msgSuccessConfirm').html(data.mensaje);
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgSuccessConfirm').removeClass('hidden');
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                //setTimeout(recargar, 2000);
                recargar();
            } else {
                $('#msgErrorConfirm').html(data.mensaje);
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgAlertConfirm').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'ubicacion';
        });
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'ubicacion/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                window.location.href = base_url + 'ubicacion';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'ubicacion';
        });
    });
});

function recargar() {
    window.location.href = base_url + 'ubicacion';
}