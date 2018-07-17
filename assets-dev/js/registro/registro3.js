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

    var mayorEdad = function (valor) {
        if(valor.length == 0) {
            $('#' + idCampo + '-error').html('Selecciona la fecha de nacimiento.').removeClass('hide').show();
            $(this).val('').focus();
            return false;
        }

        var edad = calculaEdad(valor, '');
        if(edad < 18) {
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

    $.validator.addMethod('validarMayorEdad', function (value, element, params) {
        var anio = $('#' + params[0]).val();
        var mes = $('#' + params[1]).val();
        var dia = $('#' + params[2]).val();

        if(anio.length > 0 && mes.length > 0 && dia.length > 0) {
            return mayorEdad(anio + '-' + mes + '-' + dia);
        }
        return true;
    });

    $('#frmRegistro').validate({
        errorClass: 'error-form',
        rules: {
            anio_naci: {required: true, validarFecha:['anio_naci', 'mes_naci', 'dia_naci'], validarMayorEdad:['anio_naci', 'mes_naci', 'dia_naci']},
            mes_naci: {required: true, validarFecha:['anio_naci', 'mes_naci', 'dia_naci'], validarMayorEdad:['anio_naci', 'mes_naci', 'dia_naci']},
            dia_naci: {required: true, validarFecha:['anio_naci', 'mes_naci', 'dia_naci'], validarMayorEdad:['anio_naci', 'mes_naci', 'dia_naci']}
        },
        messages: {
            anio_naci: {
                required: 'ERROR: Seleccione el año de la fecha de nacimiento.',
                validarFecha: 'ERROR: La fecha de nacimiento definida no es válida.',
                validarMayorEdad: 'ERROR: Usted es menor de edad y no esta habilitado para la inscripción al eCenso.'
            },
            mes_naci: {
                required: 'ERROR: Seleccione el mes de la fecha de nacimiento.',
                validarFecha: 'ERROR: La fecha de nacimiento definida no es válida.',
                validarMayorEdad: 'ERROR: Usted es menor de edad y no esta habilitado para la inscripción al eCenso.'
            },
            dia_naci: {
                required: 'ERROR: Seleccione el día de la fecha de nacimiento.',
                validarFecha: 'ERROR: La fecha de nacimiento definida no es válida.',
                validarMayorEdad: 'ERROR: Usted es menor de edad y no esta habilitado para la inscripción al eCenso.'
            }
        },
        /*acc*/
        onfocusout: function (element) {
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
        },
        errorPlacement: function (error, element) {
            if (element.parents('.input-group').hasClass('input-group')){
                element.parents('.input-group').parent().append(error);
            } else {
                $(element).parents('.form-group').first().append(error.attr('role', 'alert'));
            }
        },
        highlight: function (element, errorClass, validClass) {
            if ($(element).parents('.input-group').hasClass('input-group')){
                //$(element).parents('.form-group').first().append(error.attr('role', 'alert'));
            } else {
                $(element).parent('.control-option').addClass('has-error');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if ($(element).parents('.input-group').hasClass('input-group') && $(element).attr('id')=='anioExpe'){
                $(element).parents('.input-group').parent().removeClass('has-error errorForm');
            } else {
                $(element).parents('.control-option').removeClass('has-error');
            }
        },
        submitHandler: function (form) {
            return true;
        }
    });

    $('#btnSiguiente').on('click', function() {
        $('.alert').addClass('hidden');
        if ($('#frmRegistro').valid() == true) {
            var frm = $('#frmRegistro').serialize();
            var edad = calculaEdad($('#anio_naci').val() + '-' + $('#mes_naci').val() + '-' + $('#dia_naci').val(), '');
            $(':input').addClass('disabled').prop('disabled', true);
            $(':button').addClass('disabled').prop('disabled', true);
            $.ajax({
                url: base_url + 'registro/guardar',
                type: 'POST',
                dataType: 'json',
                data: frm + '&edad=' + edad + '&duracion=' + duracionPagina(),
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
                    setTimeout(recargar, 2000);
                } else {
                    $('#msgError').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgAlert').removeClass('hidden');
                    setTimeout(recargar, 5000);
                }
            })
            .fail(function(jqXHR) {
                dialogo.setTitle('Error al guardar');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(jqXHR.responseText);
                dialogo.open();
            });
        }
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'registro/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                window.location.href = base_url + 'registro';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            dialogo.setTitle('Error al regresar');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
        });
    });
});

function recargar() {
    window.location.href = base_url + 'registro';
}