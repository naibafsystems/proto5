$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

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

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('.btn-add-once').on('click', function() {
        $('#direccion').val($('#direccion').val() + ' ' + $(this).val() + ' ');
        $(this).addClass('disabled').prop('disabled', true);
    });

    $('#direccion').textoDireccion().maxlength(80);

    $('#direccion').on('keyup', function() {
        if($(this).val().length == 0) {
            $('.btn-add-once').removeClass('disabled').prop('disabled', false);
        }
    });

    $('#btnAgregar').on('click', function() {
        var val = $('#otro_comple').val();
        $('#direccion').val($('#direccion').val() + ' ' + val + ' ');
        $('#otro_comple').find("option[value='" + val + "']").remove();
    });

    $('#btnLimpiar').on('click', function() {
        $('#direccion').val('');
        $('.btn-add-once').removeClass('disabled').prop('disabled', false);
    });

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            direccion: {required: true, minlength: 10 }
        },
        messages: {
            direccion: {
                required: 'ERROR: Digite la dirección.',
                minlength: 'ERROR: La dirección debe tener más de 10 carateres.'
            }
        },
        /*acc*/
        onfocusout: function (element) {
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
        },
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
        $('#divContent').addClass('hidden');
        $('#direccion-confirm').html($('#direccion').val());
        $('#mensajeConfirmacion').removeClass('hidden');
    });

    $('#btnAnteriorConfirmacion').on('click', function() {
        $('#divContent').removeClass('hidden');
        $('#mensajeConfirmacion').addClass('hidden');
    });

    $('#btnSiguienteConfirmacion').on('click', function() {
        $('.alert').addClass('hidden');
        if ($('#frmUbicacion').valid() == true) {
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
        }
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