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

    var validarUnicoCorreo = function (idCampo) {
        if($('#' + idCampo).val().length > 0) {
            $.ajax({
                type: 'POST',
                url: base_url + 'registro/validarCorreo',
                data: {'email': $('#' + idCampo).val()},
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    $('#animationload').fadeIn();
                },
                complete: function () {
                    $('#animationload').fadeOut();
                },
                success: function (data) {
                    if (data.codiError === 0) {
                        $('#' + idCampo + '-error').html('').removeClass('error-form');
                        return true;
                    } else {
                        $('#' + idCampo + '-error').html(data.msgError).addClass('error-form');
                        $('#' + idCampo).val('');
                        return false;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    dialogo.setTitle('Validar correo electrónico único');
                    dialogo.setType(BootstrapDialog.TYPE_DANGER);
                    dialogo.setMessage(jqXHR.responseText);
                    dialogo.open();
                    return false;
                },
                timeout: 10000 // se define el timeout a 10 segundos
            });
        }
    };

    $.validator.addMethod('emailValido2', function (value, element, params) {
        if (value.length > 0) {
            if (/^[a-zA-Z0-9_\-\.~]{2,}@[a-zA-Z0-9_\-\.~]{2,}\.[a-zA-Z]{2,4}$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    });

    $('#correo_electronico').on('blur', function() {
        var validator = $('#frmRegistro').validate();
        if(validarUnicoCorreo('correo_electronico') == false) {
            validator.showErrors({'correo_electronico': 'ERROR: El correo electrónico ya está registrado en el sistema.'});
            return false;
        }
    });
    
    $('#frmRegistro').validate({
        errorClass: 'error-form',
        rules: {
            correo_electronico: {required: true, emailValido2: true}
        },
        messages: {
            correo_electronico: {
                required: 'ERROR: Digite un correo electrónico válido.', 
                emailValido2: 'ERROR: No es una dirección de correo electrónico válida.',
                validarEmail: 'ERROR: El correo electrónico ya esta registrado en el sistema'
            },
            correo2_electronico: {
                required: 'ERROR: Digite un correo electrónico válido.', 
                emailValido2: 'ERROR: No es una dirección de correo electrónico válida.',
                equalTo: 'ERROR: El correo electrónico debe ser igual al primer correo electrónico.'
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
        if ($('#frmRegistro').valid() == true) {
            var validator = $('#frmRegistro').validate();
            if(validarUnicoCorreo('correo_electronico') == false) {
                validator.showErrors({'correo_electronico': 'ERROR: El correo electrónico ya está registrado en el sistema.'});
                return false;
            }
            var frm = $('#frmRegistro').serializeArray();
            $.each(frm, function(key, value) {
                if ($('#' + value.name + '-confirm').length > 0) {
                    if($('#' + value.name).is('select')) {
                        $('#' + value.name + '-confirm').html($('#' + value.name + ' option[value="' + value.value + '"]').html());
                    } else {
                        $('#' + value.name + '-confirm').html(value.value);
                    }
                }
            });
            $('#frmRegistro').addClass('hidden');
            $('#mensajeConfirmacion').removeClass('hidden');
        }
    });

    $('#btnAnteriorConfirmacion').on('click', function() {
        $('#frmRegistro').removeClass('hidden');
        $('#mensajeConfirmacion').addClass('hidden');
    });

    $('#btnSiguienteConfirmacion').on('click', function() {
        $('.alert').addClass('hidden');
        if ($('#frmRegistro').valid() == true) {
            var validator = $('#frmRegistro').validate();
            if(validarUnicoCorreo('correo_electronico') == false) {
                validator.showErrors({'correo_electronico': 'Error: El correo electrónico ya está registrado en el sistema.'});
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

    $('.terminosCondiciones').on('click', function(event) {
        $.ajax({
            url: base_url + 'encuesta/terminosCondiciones',
            type: 'POST',
            dataType: 'json',
        })
        .done(function(data) {
            dialogo.setTitle(data.title);
            dialogo.setType(BootstrapDialog.TYPE_INFO);
            // dialogo.setSize(BootstrapDialog.SIZE_WIDE);
            // dialogo.getModalDialog().css({width:'90%'});
            dialogo.setMessage($(data.view));
            dialogo.open(); 
        })
        .fail(function(jqXHR) {
            dialogo.setTitle('Manejo de error');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open(); 
        });
    });

    $('#btnNoAcepto').click(function () {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $(location).attr('href', base_url + 'registro/noAcepto');
    });
});

function recargar() {
    window.location.href = base_url + 'registro';
}