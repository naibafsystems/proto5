$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    
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

    $('input[type=radio][name=es_resguardo_terri]').on('change', function() {
        if($(this).val() == 1) {
            $('#tipo_territo-col').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#tipo_territo-col').addClass('hidden');
            $('input[name=tipo_territo]').prop('checked', false);
            $('#tipo_territo-1-panel').addClass('hidden');
            $('#resguardo').val('');
            $('#tipo_territo-2-panel').addClass('hidden');
            $('#territorio').val('');
        }
    });

    $('input[type=radio][name=tipo_territo]').on('change', function() {
        if($(this).val() == 1) {
            $('#tipo_territo-1-panel').removeClass('hidden');
            $('#tipo_territo-2-panel').addClass('hidden');
            $('#territorio').val('');
        } else if($(this).val() == 2) {
            $('#tipo_territo-1-panel').addClass('hidden');
            $('#resguardo').val('');
            $('#tipo_territo-2-panel').removeClass('hidden');
        }
    });

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            es_resguardo_terri: {required: true},
            tipo_territo: {required: true},
            resguardo: {selectVacio: true},
            territorio: {selectVacio: true}
        },
        messages: {
            es_resguardo_terri: { required: 'ERROR: Seleccione si la vivienda en la cual reside habitualmente se encuentra al interior de un Resguardo indígena o un Territorio colectivo de Comunidad negra.' },
            tipo_territo: { required: 'ERROR: Seleccione el tipo de territorialidad étnica.' },
            resguardo: { selectVacio: 'ERROR: Seleccione el resguardo indígena.' },
            territorio: {selectVacio: 'ERROR: Seleccione el territorio colectivo de Comunidad negra.'}
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
                    $('#msgSuccess').html('Guardando las respuestas...');
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