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

    $('.scrollup').on('click', function() {
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });

    $('[data-tooltip!=""]').qtip({
        content: { attr: 'data-tooltip' },
        position: { my: 'top right' },
        style: { classes: 'qtip-bootstrap qtip-DANE' },
        show: {
            event: 'load',
            ready: true
        },
        hide: function (event, api) {
            $(this).show();
        }
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('input[type=radio][name=sabe_fecha_ultimo]').on('change', function() {
        if($(this).val() == 1) {
            $('#sabe_fecha_ultimo-1-panel').removeClass('hidden');
        } else {
            $('#sabe_fecha_ultimo-1-panel').addClass('hidden');
            $('#mes_ultimo_vivo').val('');
            $('#anio_ultimo_vivo').val('');
        }
    });

    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            ultimo_vivo: {required: true},
            sabe_fecha_ultimo: {required: true},
            mes_ultimo_vivo: {required: true},
            anio_ultimo_vivo: {required: true}
        },
        messages: {
            ultimo_vivo: {required: 'ERROR: Seleccione si último hijo o hija de la persona está vivo actualmente.'},
            sabe_fecha_ultimo: {required: 'ERROR: Seleccione si sabe la fecha de nacimiento del último hijo o hija nacido(a) vivo(a).'},
            mes_ultimo_vivo: {required: 'ERROR: Seleccione el mes de nacimiento del último hijo o hija nacido(a) vivo(a).'},
            anio_ultimo_vivo: {required: 'ERROR: Seleccione el año de nacimiento del último hijo o hija nacido(a) vivo(a).'}
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
        $('.alert').addClass('hidden');
        if ($('#frmPersona').valid() == true) {
            $(this).addClass('disabled').prop('disabled', true);
            var frm = $('#frmPersona').serialize();
            $.ajax({
                url: base_url + 'personas/persona/guardar',
                type: 'POST',
                dataType: 'json',
                data: frm + '&numePers=' + $('#frmPersona').data('nume_pers') + '&duracion=' + duracionPagina(),
                beforeSend: function () {
                    $('#msgSuccess').html('Guardando la(s) respuesta(s). Espere por favor...');
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgSuccess').removeClass('hidden');
                }
            })
            .done(function(data) {
                if(data.codiError == 0) {
                    $('#msgSuccess').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgSuccess').removeClass('hidden');
                    $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                    //setTimeout(recargar, 2000);
                    recargar();
                } else {
                    $('#msgError').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgAlert').removeClass('hidden');
                }
            })
            .fail(function(jqXHR) {
                window.location.href = base_url + 'persona'; 
            });
        }
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'personas/persona/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                window.location.href = base_url + 'personas/persona';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'persona';
        });
    });
});

function recargar() {
    window.location.href = base_url + 'personas/persona';
}