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
        position: { my: 'top left' },
        style: { classes: 'qtip-bootstrap qtip-DANE' }
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('input[type=radio][name=asistencia_educacion]').on('change', function() {
        if($(this).val() == 1) {
            $('#principal_causa-col').addClass('hidden');
            $('#deja_asistir-col').addClass('hidden');
        } else if($(this).val() == 2) {
            $('#principal_causa-col').removeClass('hidden');
            $('input[name=principal_causa]').prop('checked', false);
            $('input[name=causa_familiar]').prop('checked', false);
            $('input[name=causa_economica]').prop('checked', false);
            $('input[name=causa_instituto]').prop('checked', false);
            $('input[name=causa_educativa]').prop('checked', false);
            $('input[name=causa_entorno]').prop('checked', false);
            $('input[name=causa_discriminacion]').prop('checked', false);
            $('input[name=causa_personal]').prop('checked', false);
            $('#deja_asistir-col').removeClass('hidden');
            $('input[name=deja_asistir]').prop('checked', false);
        }
    });

    $('input[type=radio][name=principal_causa]').on('change', function() {
        $('#principal_causa-1-panel').addClass('hidden');
        $('input[name=causa_familiar]').prop('checked', false);
        $('#principal_causa-2-panel').addClass('hidden');
        $('input[name=causa_economica]').prop('checked', false);
        $('#principal_causa-3-panel').addClass('hidden');
        $('input[name=causa_instituto]').prop('checked', false);
        $('#principal_causa-4-panel').addClass('hidden');
        $('input[name=causa_educativa]').prop('checked', false);
        $('#principal_causa-5-panel').addClass('hidden');
        $('input[name=causa_entorno]').prop('checked', false);
        $('#principal_causa-6-panel').addClass('hidden');
        $('input[name=causa_discriminacion]').prop('checked', false);
        $('#principal_causa-7-panel').addClass('hidden');
        $('input[name=causa_personal]').prop('checked', false);
        $('#principal_causa-' + $(this).val() + '-panel').removeClass('hidden');
    });

    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            asistencia_educacion: {required: true},
            principal_causa: {required: true},
            causa_familiar: {required: true},
            causa_economica: {required: true},
            causa_instituto: {required: true},
            causa_educativa: {required: true},
            causa_entorno: {required: true},
            causa_discriminacion: {required: true},
            causa_personal: {required: true},
            deja_asistir: {required: true},
            nivel_anios: {required: true}
        },
        messages: {
            asistencia_educacion: {required: 'ERROR: Debe seleccionar si la persona asiste a algún preescolar, escuela, colegio o universidad, de forma presencial o virtual.'},
            principal_causa: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            causa_familiar: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            causa_economica: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            causa_instituto: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            causa_educativa: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            causa_entorno: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            causa_discriminacion: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            causa_personal: {required: 'ERROR: Debe seleccionar la principal causa por la que la persona no asiste.'},
            deja_asistir: {required: 'ERROR: Debe seleccionar si la persona va a dejar de asistir definitivamente.'},
            nivel_anios: {required: 'ERROR: Debe seleccionar el nivel educativo más alto alcanzado y el último año o grado aprobado de la persona.'}
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