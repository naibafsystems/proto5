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

    $('input[type=radio][name=etnia_persona]').on('change', function() {
        if($(this).val() == 1) {
            $('#etnia_persona-1-panel').removeClass('hidden');
            $('#etnia_persona-2-panel').addClass('hidden');
            $('#vitsa_gitano').val('');
            $('#kumpania').val('');
            $('#habla_lengua-col').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#etnia_persona-2-panel').removeClass('hidden');
            $('#etnia_persona-1-panel').addClass('hidden');
            $('#pueblo_indigena').val('');
            $('#clan_indigena').val('');
            $('#habla_lengua-col').removeClass('hidden');
        } else if($(this).val() == 3 || $(this).val() == 4) {
            $('#habla_lengua-col').removeClass('hidden');
            $('#etnia_persona-1-panel').addClass('hidden');
            $('#pueblo_indigena').val('');
            $('#clan_indigena').val('');
            $('#etnia_persona-2-panel').addClass('hidden');
            $('#vitsa_gitano').val('');
            $('#kumpania').val('');
        } else {
            $('#etnia_persona-1-panel').addClass('hidden');
            $('#pueblo_indigena').val('');
            $('#clan_indigena').val('');
            $('#etnia_persona-2-panel').addClass('hidden');
            $('#vitsa_gitano').val('');
            $('#habla_lengua-col').addClass('hidden');
            $('input[name=habla_lengua]').prop('checked', false);
            $('#otras_lenguas-col').addClass('hidden');
            $('input[name=otras_lenguas]').prop('checked', false);
            $('#otras_lenguas-1-panel').addClass('hidden');
            $('#cuantas_lenguas').val('');
        }
    });

    $('input[type=radio][name=habla_lengua]').on('change', function() {
        $('#otras_lenguas-col').removeClass('hidden');
        if($(this).val() == 1) {
            $('#habla_lengua-2-panel').addClass('hidden');
            $('input[name=entiende_lengua]').prop('checked', false);
            //$('#otras_lenguas-col').addClass('hidden');
            //$('input[name=otras_lenguas]').prop('checked', false);
            $('#otras_lenguas-1-panel').addClass('hidden');
            $('#cuantas_lenguas').val('');
        } else if($(this).val() == 2) {
            $('#habla_lengua-2-panel').removeClass('hidden');
            //$('#otras_lenguas-col').removeClass('hidden');
        }
    });

    $('input[type=radio][name=otras_lenguas]').on('change', function() {
        if($(this).val() == 1) {
            $('#otras_lenguas-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#otras_lenguas-1-panel').addClass('hidden');
            $('#cuantas_lenguas').val('');
        }
    });

    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            etnia_persona: {required: true},
            grupo_etnico: {required: true},
            pueblo_indigena: {required: true},
            clan_indigena: {required: true},
            vitsa_gitano: {required: true},
            kumpania: {required: true},
            habla_lengua: {required: true},
            entiende_lengua: {required: true},
            otras_lenguas: {required: true},
            cuantas_lenguas: {required: true}
        },
        messages: {
            etnia_persona: {required: 'ERROR: Debe seleccionar la etnia de la persona.'},
            grupo_etnico: {required: 'ERROR: Debe seleccionar el grupo étnico de la persona.'},
            pueblo_indigena: {required: 'ERROR: Debe seleccionar el pueblo indigena la persona.'},
            clan_indigena: {required: 'ERROR: Debe seleccionar el clan indigena de la persona.'},
            vitsa_gitano: {required: 'ERROR: Debe seleccionar la vitsa de la persona.'},
            kumpania: {required: 'ERROR: Debe seleccionar la kumpania de la persona.'},
            habla_lengua: {required: 'ERROR: Debe seleccionar si la persona habla la lengua nativa de su pueblo.'},
            otra_lengua: {required: 'ERROR: Debe seleccionar si la persona otra(s) lengua(s) nativa(s).'},
            otras_lenguas: {required: 'ERROR: Debe seleccionar si la persona habla otra(s) lengua(s) nativa(s).'},
            cuantas_lenguas: {required: 'ERROR: Debe seleccionar cuantas lengua(s) nativa(s) habla.'},
            entiende_lengua: {required: 'ERROR: Debe seleccionar si la persona entiende la lengua nativa de su pueblo.'},
            cual_lengua: {required: 'ERROR: Debe seleccionar cuantas lengua(s) nativa(s) habla la persona.'},
            habla_espanol: {required: 'ERROR: Debe seleccionar si la persona habla español.'}
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
            var frm = $('#frmPersona').serialize();
            $(':input').addClass('disabled').prop('disabled', true);
            $(':button').addClass('disabled').prop('disabled', true);
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
                dialogo.setMessage(jqXHR.response)
                // window.location.href = base_url + 'persona';
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