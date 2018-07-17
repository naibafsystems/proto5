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

    var unicaCedula = function (idCampo, idCampo2) {
        $('#' + idCampo2 + '-error').remove();
        var tipoDocu = $('#' + idCampo).val();
        var numeDocu = $('#' + idCampo2).val();

        if(tipoDocu.length == 0 || tipoDocu == '-') {
            $(this).val('').focus();
            return false;
        }

        /*if(tipoDocu != 3) {
            return true;
        }*/

        if(numeDocu.length == 0) {
            $(this).val('').focus();
            return false;
        }

        $.ajax({
            type: 'POST',
            url: base_url + 'registro/completarPersona',
            data: {'tipoDocu': tipoDocu, 'numeDocu': numeDocu,'peticion':'2'},
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                $('#animationload').fadeIn();
            },
            complete: function () {
                $('#animationload').fadeOut();
            },
            success: function (data) {
                if (data.codiError == 0) {
                    return true;
                } else {
                    //$('#' + idCampo2).parents('.form-group').first().addClass('has-error');
                    $('#' + idCampo2).parents('.form-group').append('<label id="' + idCampo2 + '-error" class="error-form"></label>');
                    if(data.msgError.length > 0) {
                        //validator.showErrors({'nume_docu': data.msgError});
                        $('#' + idCampo2 + '-error').html(data.msgError).attr('style', '');
                        // $.validator.messages.validaRC = data.msgError;
                        $('#' + idCampo2).val('');

                    }
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (textStatus=="timeout"){
                    return true;
                } else {
                    dialogo.setTitle('Validar número de documento');
                    dialogo.setType(BootstrapDialog.TYPE_DANGER);
                    dialogo.setMessage(jqXHR.responseText);
                    dialogo.open();
                }
                return false;
            },
            timeout: 10000 // se define el timeout a 10 segundos
        });
    };

    var longitudNumeDocu = function (tipoDocu, numeDocu) {
        switch (tipoDocu) {
            case '1':
                if (numeDocu.length < 11 && numeDocu.length > 1) {
                    return true;
                }
                break;
            case '2':
                if (numeDocu.length < 13 && numeDocu.length > 1) {
                    return true;
                }
                break;
            case '3':
                if (numeDocu.length < 11 && numeDocu.length > 1) {
                    return true;
                }
                break;
            case '4':
                if (numeDocu.length < 11 && numeDocu.length > 2) {
                    var regex = /[a-zA-Z0-9]/;
                    if (numeDocu.match(regex)) {
                        return true;
                    }
                }
                break;
        }
        return false;
    };

     $.validator.addMethod('validaCC', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        if(tipoDocu.length == 0) {
            return false;
        } else if(tipoDocu == '3') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu, value);
        }
        return true;
    });

    $.validator.addMethod('validaCE', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        if(tipoDocu.length == 0) {
            return false;
        } else if(tipoDocu == '4') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu, value);
        }
        return true;
    });

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

    $('#primer_nombre').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#segundo_nombre').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#primer_apellido').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#segundo_apellido').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();

    $('#tipo_documento').on('change', function() {
        $('#numero_documento').val('');
    });

    $('#numero_documento').on('keypress', function(event) {
        var tipoDocu = $('#tipo_documento').val();

        if(tipoDocu.length == 0 || tipoDocu == '-') {
            $(this).val('');
            return false;
        }

        if (tipoDocu == 1 || tipoDocu == 2 || tipoDocu == 3) {
            if ((event.which == 8) || (event.which == 0))
                return true;
            if ((event.which >= 48) && (event.which <= 57))
                return true;
            else
                return false;
        } else if (tipoDocu == 4) {
            if (event.which == 0 || event.which == 8 || event.which == 13)
                return true;
            if ((event.which >= 48) && (event.which <= 57)) // Numeros
                return true;
            if ((event.which >= 65) && (event.which <= 90))  // Mayusculas
                return true;
            if ((event.which >= 97) && (event.which <= 122)) // Minusculas
                return true;
            else
                return false;
        }
    });

    $('#numero_documento').on('blur', function() {
        var tipoDocu = $('#tipo_documento').val();
        var numeDocu = $('#numero_documento').val();
        if(longitudNumeDocu(tipoDocu, numeDocu)) {
            //return true;
            return unicaCedula('tipo_documento', 'numero_documento');
        }

        return false;
    });

    $('#correo_electronico').on('blur', function() {
        var validator = $('#formCorreo').validate();
        if(validarUnicoCorreo('correo_electronico') == false) {
            validator.showErrors({'correo_electronico': 'ERROR: El correo electrónico ya está registrado en el sistema.'});
            return false;
        }
    });
    
    $('#formCorreo').validate({
        errorClass: 'error-form',
        rules: {
            tipo_documento: {selectVacio: true},
            numero_documento: {
                required: true,
                validaCC:['tipo_documento'],
                validaCE:['tipo_documento'],
            },
            correo_electronico: {required: true, emailValido2: true},
            primer_nombre: {required: true, maxlength: 30},
            segundo_nombre: {maxlength: 30},
            primer_apellido: {required: true, maxlength: 30},
            segundo_apellido: {maxlength: 30},
            sexo_persona: {selectVacio: true},
        },
        messages: {
            correo_electronico: {
                required: 'ERROR: Digite un correo electrónico válido.', 
                emailValido2: 'ERROR: No es una dirección de correo electrónico válida.',
                validarEmail: 'ERROR: El correo electrónico ya esta registrado en el sistema'
            },
            tipo_documento: {
                selectVacio: 'ERROR: Selecciona el tipo de identificación de la persona.'
            },
            numero_documento: {
                required: 'ERROR: Digite el número de documento de la persona.',
                validaCC: 'ERROR: La longitud del número de documento debe ser entre 2 a 10 caracteres.',
                validaCE: 'ERROR: El documento debe tener entre 2 a 10 dígitos y/o caracteres.'
            },
            primer_nombre: {
                required: 'ERROR: Digite el primer nombre de la persona.',
                maxlength: 'ERROR: El primer nombre no debe tener más de 30 caracteres.'
            },
            segundo_nombre: { maxlength: 'ERROR: El segundo nombre no debe tener más de 30 caracteres.' },
            primer_apellido: {
                required: 'ERROR: Digite el primer apellido de la persona.',
                maxlength: 'ERROR: El segundo apellido no debe tener más de 30 caracteres.'
            },
            segundo_apellido: { maxlength: 'ERROR: El segundo apellido no debe tener más de 30 caracteres.' },
            sexo_persona: { selectVacio: 'ERROR: Selecciona el sexo de la persona.' },
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

    $('#btnGuardarCorreo').on('click', function() {
        var encuesta = $('#hddEncuesta').val();
        var correo = $('#correo_electronico').val();
        if ($('#formCorreo').valid() == true) {
            var frm = $('#formCorreo').serialize();
            $.ajax({
                url: base_url + 'usuarios/guardarCorreo',
                type: 'POST',
                dataType: 'json',
                data: frm
            })
            .done(function(data) {
                if(data.codiError == 0) {
                    $('#msgSuccess').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgSuccess').removeClass('hidden');
                    setTimeout(recargar, 2000);
                } else {
                    dialogo.setTitle('Error al guardar el usuario');
                    dialogo.setType(BootstrapDialog.TYPE_DANGER);
                    dialogo.setMessage(data.mensaje);
                    dialogo.open();
                }
            })
            .fail(function(jqXHR) {
                dialogo.setTitle('Error al guardar el usuario');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(jqXHR.responseText);
                dialogo.open();
            });
        }
    });
});

function recargar() {
    window.location.href = base_url + 'soporte/verUsuarios';
}