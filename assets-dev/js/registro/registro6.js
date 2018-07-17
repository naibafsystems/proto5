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

    $.validator.addMethod('validaTelefono', function (value, element, params) {
        var indiTeleFijo = $('#' + params[0]).val();
        var teleFijo = $('#' + params[1]).val();
        var teleCelular = $('#' + params[2]).val();
        if((indiTeleFijo == '-' || teleFijo.trim() == '') && teleCelular.trim() == '') {
            return false;
        }
        return true;
    });

    $.validator.addMethod('validarCelular', function (value, element, params) {
        if(value.length > 0) {
            if(value.length < 10 || isNaN(value)) {
                return false;
            }
            if(value[0] != 3) {
                return false;
            }
        }
        return true;
    });

    $('#telefono_fijo').soloNumeros();
    $('#telefono_celular').soloNumeros();
    
    $('#frmRegistro').validate({
        errorClass: 'error-form',
        rules: {
            telefono_celular: {validarCelular: true}
        },
        messages: {
            telefono_celular: {
                validarCelular: 'ERROR: El número del teléfono celular debe tener 10 dígitos y comenzar con el número 3.',
                validaTelefono: 'ERROR: Digite el teléfono celular.'
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
        if ($('#frmRegistro').valid() == true) {
            var validator = $('#frmRegistro').validate();
            var indiTeleFijo = $('#indicativo_fijo').val();
            var teleFijo = $('#telefono_fijo').val();
            var teleCelular = $('#telefono_celular').val();

            if(indiTeleFijo.length > 0) {
                if(teleFijo.length == 0) {
                    validator.showErrors({'telefono_fijo': 'ERROR: Digite el teléfono fijo de 7 dígitos.'});
                    return false;
                } else if(teleFijo.length != 7) {
                    validator.showErrors({'telefono_fijo': 'ERROR: El teléfono fijo debe tener 7 dígitos.'});
                    return false;
                }
            }
            if(indiTeleFijo.length == 0 && teleFijo.length > 0) {
                validator.showErrors({'indicativo_fijo': 'ERROR: Seleccione el indicativo del teléfono fijo.'});
                return false;
            }
            if(teleCelular.length == 0 && teleFijo.length == 0) {
                validator.showErrors({'telefono_celular': 'ERROR: Ingrese un teléfono fijo o un teléfono celular.'});
                return false;
            }

            var frm = $('#frmRegistro').serialize();
            $(':input').addClass('disabled').prop('disabled', true);
            $(':button').addClass('disabled').prop('disabled', true);
            $.ajax({
                url: base_url + 'registro/guardar',
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
                    setTimeout(recargar, 2000);
                } else {
                    $('#msgError').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgAlert').removeClass('hidden');
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