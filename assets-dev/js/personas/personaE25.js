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

    $.validator.addMethod('validarHoras', function (value, element, params) {
        if(value < 1 || value > 167) {
            return false;
        }
        return true;
    });

    $('input[type=radio][name=negocio_familia]').on('change', function() {
        if($(this).val() == 1) {
            $('#negocio_familia-1-panel').removeClass('hidden');
        } else {
            $('#negocio_familia-1-panel').addClass('hidden');
            $('#horas_negocio_familia').val('');
        }
    });

    $('input[type=radio][name=venta_producto]').on('change', function() {
        if($(this).val() == 1) {
            $('#venta_producto-1-panel').removeClass('hidden');
        } else {
            $('#venta_producto-1-panel').addClass('hidden');
            $('#horas_venta_producto').val('');
        }
    });

    $('input[type=radio][name=elaboro_producto]').on('change', function() {
        if($(this).val() == 1) {
            $('#elaboro_producto-1-panel').removeClass('hidden');
        } else {
            $('#elaboro_producto-1-panel').addClass('hidden');
            $('#horas_elaboro_producto').val('');
        }
    });

    $('input[type=radio][name=otro_pago]').on('change', function() {
        if($(this).val() == 1) {
            $('#otro_pago-1-panel').removeClass('hidden');
        } else {
            $('#otro_pago-1-panel').addClass('hidden');
            $('#horas_otro_pago').val('');
        }
    });

    $('input[type=radio][name=trabajo_etnico]').on('change', function() {
        if($(this).val() == 1) {
            $('#trabajo_etnico-1-panel').removeClass('hidden');
        } else {
            $('#trabajo_etnico-1-panel').addClass('hidden');
            $('#horas_trabajo_etnico').val('');
        }
    });

    $('input[type=radio][name=labores_campo]').on('change', function() {
        if($(this).val() == 1) {
            $('#labores_campo-1-panel').removeClass('hidden');
        } else {
            $('#labores_campo-1-panel').addClass('hidden');
            $('#horas_labores_campo').val('');
        }
    });

    $('input[type=radio][name=voluntario]').on('change', function() {
        if($(this).val() == 1) {
            $('#voluntario-1-panel').removeClass('hidden');
        } else {
            $('#voluntario-1-panel').addClass('hidden');
            $('#horas_voluntario').val('');
        }
    });

    $('input[type=radio][name=cuido_ninos]').on('change', function() {
        if($(this).val() == 1) {
            $('#cuido_ninos-1-panel').removeClass('hidden');
        } else {
            $('#cuido_ninos-1-panel').addClass('hidden');
            $('#horas_cuido_ninos').val('');
        }
    });

    $('input[type=radio][name=otra_actividad]').on('change', function() {
        if($(this).val() == 1) {
            $('#otra_actividad-1-panel').removeClass('hidden');
        } else {
            $('#otra_actividad-1-panel').addClass('hidden');
            $('#horas_otra_actividad').val('');
        }
    });
    
    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            negocio_familia: {required: true},
            horas_negocio_familia: {
                required: true,
                validarHoras: true
            },
            venta_producto: {required: true},
            horas_venta_producto: {
                required: true,
                validarHoras: true
            },
            elaboro_producto: {required: true},
            horas_elaboro_producto: {
                required: true,
                validarHoras: true
            },
            otro_pago: {required: true},
            horas_otro_pago: {
                required: true,
                validarHoras: true
            },
            trabajo_etnico: {required: true},
            horas_trabajo_etnico: {
                required: true,
                validarHoras: true
            },
            labores_campo: {required: true},
            horas_labores_campo: {
                required: true,
                validarHoras: true
            },
            voluntario: {required: true},
            horas_voluntario: {
                required: true,
                validarHoras: true
            },
            cuido_ninos: {required: true},
            horas_cuido_ninos: {
                required: true,
                validarHoras: true
            },
            otra_actividad: {required: true},
            horas_otra_actividad: {
                required: true,
                validarHoras: true
            }
        },
        messages: {
            negocio_familia: {required: 'Error: Debe seleccionar si la persona ayudó en un negocio familiar o no familiar.'},
            horas_negocio_familia: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            venta_producto: {required: 'Error: Debe seleccionar si la persona vendió por su cuenta algún producto.'},
            horas_venta_producto: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            elaboro_producto: {required: 'Error: Debe seleccionar si la persona elaboró algún producto para vender.'},
            horas_elaboro_producto: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            otro_pago: {required: 'Error: Debe seleccionar si la persona realizó otro tipo de actividad a cambio de algún pago.'},
            horas_otro_pago: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            trabajo_etnico: {required: 'Error: Debe seleccionar si la persona participó en algún tipo de actividad colectiva o comunitaria de grupos étnicos.'},
            horas_trabajo_etnico: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            labores_campo: {required: 'Error: Debe seleccionar si la persona ayudó en las labores del campo o en la cría de animales.'},
            horas_labores_campo: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            voluntario: {required: 'Error: Debe seleccionar si la persona fue pasante o aprendiz, o realizó algún trabajo como voluntario.'},
            horas_voluntario: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            cuido_ninos: {required: 'Error: Debe seleccionar si la persona cuidó niños, adultos mayores, enfermos o personas con discapacidad.'},
            horas_cuido_ninos: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
            },
            otra_actividad: {required: 'Error: Debe seleccionar si la persona realizó otras actividades para el hogar (coser o tejer ropa, plomería, pintar la vivienda).'},
            horas_otra_actividad: {
                required: 'Error: Debe digitar el número de horas a la semana.',
                validarHoras: 'Error: Debe diligenciar máximo 167 horas.'
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
    
    $("#acc_title").focus();
});

function recargar() {
    window.location.href = base_url + 'personas/persona';
}