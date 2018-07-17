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

    var edadReal = function (fechaNaci, edad) {
        if(fechaNaci.length == 0) {
            $('#' + idCampo + '-error').html('Selecciona la fecha de nacimiento.').removeClass('hide').show();
            $('#' + idCampo).val('').focus();
            return false;
        }

        var edad_real = calculaEdad(fechaNaci, '');
        if(edad_real != edad) {
            return false;
        }
        return true;
    };

    $.validator.addMethod('validarFecha', function (value, element, params) {
        var anio = $('#' + params[0]).val();
        var mes = $('#' + params[1]).val();
        var dia = $('#' + params[2]).val();

        if(anio.length > 0 && mes.length > 0 && dia.length > 0) {
            var m = moment(anio + '-' + mes + '-' + dia);
            return m.isValid();
        }
        return true;
    });

    $.validator.addMethod('validarEdad', function (value, element, params) {
        var anio = $('#' + params[0]).val();
        var mes = $('#' + params[1]).val();
        var dia = $('#' + params[2]).val();
        if(anio.length > 0 && mes.length > 0 && dia.length > 0) {
            return edadReal(anio + '-' + mes + '-' + dia, value);
        }
        return true;
    });

    $.validator.addMethod('jefeMenorEdad', function (value, element, params) {
        var edad = $('#' + params[0]).val();
        var jefe = $('#' + params[1]).val();
        if(edad.length > 0) {
            if(jefe == 1 && edad < 10) {
                return false;
            }
        } else {
            return false;
        }
        $('#' + params[0] + '-error').hide();
        $('#' + params[1] + '-error').hide();
        return true;
    });

    $('input[type=radio][name=sabe_fecha]').on('change', function() {
        if($(this).val() == 1) {
            $('#sabe_fecha-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#sabe_fecha-1-panel').addClass('hidden');
            $('#anio_naci').val('');
            $('#mes_naci').val('');
            $('#dia_naci').val('');
        }
    });

    $('#dia_naci').on('blur', function() {
        var anio = $('#anio_naci').val();
        var mes = $('#mes_naci').val();
        var dia = $('#dia_naci').val();

        if(anio.length > 0 && mes.length > 0 && dia.length > 0) {
            var m = moment(anio + '-' + mes + '-' + dia);
            if(m.isValid()) {
                /*$('#edad_persona').val('');
                var edad = calculaEdad((anio + '-' + mes + '-' + dia), '');
                if(!isNaN(edad)) {
                    $('#edad_persona').val(edad);
                }*/
            }
        }
    });        

    /*$('#sabe_fecha_fecha').datepicker().on('hide', function(e) {
        var fecha = $('#sabe_fecha_fecha').val();
        if(fecha.length > 0) {
            $('#edad_persona').val('');
            var edad = calculaEdad(formatearFecha(fecha), '');
            if(!isNaN(edad)) {
                $('#edad_persona').val(edad);
            }
        }
    });*/
    
    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            sabe_fecha: {required: true},
            anio_naci: {required: true, validarFecha:['anio_naci', 'mes_naci', 'dia_naci']},
            mes_naci: {required: true, validarFecha:['anio_naci', 'mes_naci', 'dia_naci']},
            dia_naci: {required: true, validarFecha:['anio_naci', 'mes_naci', 'dia_naci']},
            edad_persona: {required: true, validarEdad: ['anio_naci', 'mes_naci', 'dia_naci'], jefeMenorEdad:['edad_persona', 'jefe_hogar']},
        },
        messages: {
            sabe_fecha: {required: 'Error: Debes seleccionar una de las opciones del personas.'},
            anio_naci: {
                required: 'Error: Seleccione el año de la fecha de nacimiento.',
                validarFecha: 'Error: La fecha de nacimiento definida no es válida.',
                validarMayorEdad: 'Error: Es menor de edad y no estas habilitado para realizar la inscripción al eCenso.'
            },
            mes_naci: {
                required: 'Error: Seleccione el mes de la fecha de nacimiento.',
                validarFecha: 'Error: La fecha de nacimiento definida no es válida.',
                validarMayorEdad: 'Error: Es menor de edad y no estas habilitado para realizar la inscripción al eCenso.'
            },
            dia_naci: {
                required: 'Error: Seleccione el día de la fecha de nacimiento.',
                validarFecha: 'Error: La fecha de nacimiento definida no es válida.',
                validarMayorEdad: 'Error: Es menor de edad y no estas habilitado para realizar la inscripción al eCenso.'
            },
            edad_persona: {
                required: 'Error: Debe seleccionar la edad de la persona.',
                validarEdad: 'Error: Los años cumplidos no coinciden con la fecha de nacimiento de la persona.',
                jefeMenorEdad: 'ERROR: No puede ser jefe(a) del hogar si es menor de 10 años.'
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
                window.location.href = base_url + 'persona';
            });
        }
    });
});

function recargar() {
    window.location.href = base_url + 'personas/persona';
}