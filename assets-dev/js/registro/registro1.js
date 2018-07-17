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

    $('[data-tooltip!=""]').qtip({
        content: { attr: 'data-tooltip' },
        position: { my: 'top left' },
        style: { classes: 'qtip-bootstrap qtip-DANE' }
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('#fecha_expe-lbl').qtip({
      content: '<img src="' + base_url + 'assets/images/cedula.jpg" alt="Owl" />',
      //content: { attr: 'data-tooltip' },
      position: { my: 'top right' },
      style: { classes: 'qtip-bootstrap qtip-DANE' }
    });

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
            data: {'tipoDocu': tipoDocu, 'numeDocu': numeDocu, 'peticion':'1'},
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
                    if(data.registraduria == 0){
                         return true;
                    }/*else if(tipoDocu == 3){
                        BootstrapDialog.show({
                            closable: false,
                            title: 'Mensaje de Notificación',
                            type: BootstrapDialog.TYPE_WARNING,
                            message: 'Para crear una cuenta en el eCenso es necesario ser mayor de edad y tener cédula de ciudadanía o de extranjería. Su documento no figura en la base de datos de la Registraduría Nacional; por favor verifique la información e intente nuevamente.',
                            buttons: [{
                                label: 'Aceptar',
                                action: function(dialog) {
                                    $(location).attr('href', base_url + '/registro');
                                }
                            }]
                        });
                    }*/

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

    $.validator.addMethod('validaRC', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        var tipoDocu2 = $('#' + params[1]).val();
        if(tipoDocu == 6 && tipoDocu2.length == 0) {
            return false;
        } else if(tipoDocu2 == '1') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu2, value);
        }
        return true;
    });

    $.validator.addMethod('validaTI', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        var tipoDocu2 = $('#' + params[1]).val();
        if(tipoDocu == 6 && tipoDocu2.length == 0) {
            return false;
        } else if(tipoDocu2 == '2') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu2, value);
        }
        return true;
    });

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

    $.validator.addMethod('validaNN', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        var tipoDocu2 = $('#' + params[1]).val();
        if(tipoDocu == 6 && tipoDocu2.length == 0) {
            return false;
        } else if(tipoDocu2 == '5') {
            return true;
        }
        return true;
    });

    $.validator.addMethod('validarCamposFecha', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        if(tipoDocu == 3) {
            if(value.length == 0 || value == '-') {
                return false;
            }
            if(isNaN(value)) {
                return false;
            }
        }
        return true;
    });

    $.validator.addMethod('validarFechaExpe', function (value, element, params) {
        var tipoDocu = $('#' + params[0]);
        var anio = $('#' + params[1]);
        var mes = $('#' + params[2]);
        var dia = $('#' + params[3]);

        if(tipoDocu.val() == 3) {
            if(anio.val().length > 0 && mes.val().length > 0 && dia.val().length > 0) {
                var m = moment(anio.val() + '-' + mes.val() + '-' + dia.val());

                if(m.isValid() == false) {
                    return false;
                }
            }
        }
        return true;
    });

    $('#tipo_documento').on('change', function() {
        $('#numero_documento').val('');
        $('#tipo_documento option:selected').each(function () {
            if($(this).val() == 6) {
                $('#fecha_expe-col').addClass('hidden');
                //$('#tipo_documento2-col').removeClass('hidden');
                /*dialogo.setTitle('Mensaje de Notificación');
                            dialogo.setType(BootstrapDialog.TYPE_WARNING);
                            dialogo.setMessage('Para poderse registrar en el eCenso debe tener cédula de ciudadanía o extranjería.');
                            dialogo.see
                            dialogo.open();*/
                BootstrapDialog.show({
                        title: 'Mensaje de Notificación',
                        closable: false,
                        type: BootstrapDialog.TYPE_WARNING,
                        message: 'Para crear una cuenta en el eCenso es necesario ser mayor de edad y tener cédula de ciudadanía o de extranjería. Su documento no figura en la base de datos de la Registraduría Nacional; por favor verifique la información e intente nuevamente.',
                        buttons: [{
                            label: 'Aceptar',
                            action: function(dialog) {
                                $(location).attr('href', base_url + '/registro');
                            }
                        }]
                    });
            } else {
                $('#tipo_documento2-col').addClass('hidden');
                $('#tipo_documento2').val('');
                if($(this).val() == 3) {
                    $('#fecha_expe-col').removeClass('hidden');
                } else {
                    $('#fecha_expe-col').addClass('hidden');
                    $('#anio_expe').val('');
                    $('#mes_expe').val('');
                    $('#dia_expe').val('');
                }
            }
        });
    });

    $('#tipo_documento2').on('change', function() {
        if($(this).val() == 5) {
            $('#numero_documento-col').addClass('hidden');
        } else {
            $('#numero_documento-col').removeClass('hidden');
        }
        $('#numero_documento').val('');
    });

    $('#numero_documento').on('keypress', function(event) {
        var tipoDocu = $('#tipo_documento').val();

        if(tipoDocu.length == 0 || tipoDocu == '-') {
            $(this).val('').focus();
        } else if(tipoDocu == 6) {
            tipoDocu = $('#tipo_documento2').val();
        }

        if (tipoDocu == 3) {
            if ((event.which == 8) || (event.which == 0))
                return true;
            if ((event.which >= 48) && (event.which <= 57))
                return true;
            return false;
        } else if (tipoDocu == 4 || tipoDocu == 2  || tipoDocu == 1) {
            if (event.which == 0 || event.which == 8 || event.which == 13)
                return true;
            if ((event.which >= 48) && (event.which <= 57)) // Numeros
                return true;
            if ((event.which >= 65) && (event.which <= 90))  // Mayusculas
                return true;
            if ((event.which >= 97) && (event.which <= 122)) // Minusculas
                return true;
            return false;
        }
    });

    $('#numero_documento').on('blur', function() {
        var tipoDocu = $('#tipo_documento').val();
        var tipoDocu2 = $('#tipo_documento2').val();

        if(tipoDocu != 6 || (tipoDocu == 6 && tipoDocu2 != 5)) {
            var numeDocu = $('#numero_documento').val();
            if(longitudNumeDocu(tipoDocu, numeDocu)) {
                return unicaCedula('tipo_documento', 'numero_documento');
            }
        }
        return false;
    });

    //$('#ayudaSexo').hint('Intersexual', 'Cuerpo en el que la diferenciación sexual en cualquiera de los tipos de sexo (hombre – mujer) no se alcanza en su totalidad; es decir, la persona nace con órganos sexuales, tanto internos como externos, de hombre y de mujer. Se denomina también "hermafrodita" o "sexo indeterminado".');

    $('#frmRegistro').validate({
        errorClass: 'error-form',
        rules: {
            tipo_documento: {selectVacio: true},
            tipo_documento2: {selectVacio: true},
            numero_documento: {
                validaRC:['tipo_documento', 'tipo_documento2'],
                validaTI:['tipo_documento', 'tipo_documento2'],
                validaCC:['tipo_documento'],
                validaCE:['tipo_documento']
            },
            anio_expe: {validarCamposFecha: ['tipo_documento'], validarFechaExpe:['tipo_documento', 'anio_expe', 'mes_expe', 'dia_expe']},
            mes_expe: {validarCamposFecha: ['tipo_documento'], validarFechaExpe:['tipo_documento', 'anio_expe', 'mes_expe', 'dia_expe']},
            dia_expe: {validarCamposFecha: ['tipo_documento'], validarFechaExpe:['tipo_documento', 'anio_expe', 'mes_expe', 'dia_expe']}
        },
        messages: {
            tipo_documento: {
                selectVacio: 'ERROR: Seleccione el tipo de identificación de la persona.'
            },
            tipo_documento2: {
                selectVacio: 'ERROR: Seleccione el tipo 2 de identificación de la persona.'
            },
            numero_documento: {
                //required: 'ERROR: Digite el número de documento de la persona.',
                validaRC: 'ERROR: La longitud del número de documento debe serRC ser entre 2 a 10 caracteres.',
                validaTI: 'ERROR: La longitud del número de documento debe serTI ser entre 2 a 12 caracteres.',
                validaCC: 'ERROR: La longitud del número de documento debe ser entre 2 a 10 caracteres.',
                validaCE: 'ERROR: El documento debe tener entre 2 a 10 dígitos y/o caracteres.'
            },
            anio_expe: {
                validarCamposFecha: 'ERROR: Seleccione el año de la fecha de expedición.',
                validarFechaExpe: 'ERROR: La fecha de expedición definida no es válida.'
            },
            mes_expe: {
                validarCamposFecha: 'ERROR: Seleccione el mes de la fecha de expedición.',
                validarFechaExpe: 'ERROR: La fecha de expedición definida no es válida.'
            },
            dia_expe: {
                validarCamposFecha: 'ERROR: Seleccione el día de la fecha de expedición.',
                validarFechaExpe: 'ERROR: La fecha de expedición definida no es válida.'
            }
        },
        /*acc*/
        onfocusout: function (element) {
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
            //$(element).valid();
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
        if ($('#frmRegistro').valid() == true) {
            var validator = $('#frmRegistro').validate();
            var tipoDocu = $('#tipo_documento').val();
            var tipoDocu2 = $('#tipo_documento2').val();
            // if(tipoDocu != 6 || (tipoDocu == 6 && tipoDocu2 != 5)) {
            //     if(unicaCedula('tipo_documento', 'numero_documento') == false) {
            //         validator.showErrors({'numero_documento': 'ERROR: Ya existe un usuario registrado con este número de documento.'});
            //         return false;
            //     }
            // }

            var frm = $('#frmRegistro').serializeArray();
            $.each(frm, function(key, value) {
                if ($('#' + value.name + '-confirm').length > 0) {
                    if($('#' + value.name).is('select')) {
                        $('#' + value.name + '-confirm').html($('#' + value.name + ' option[value="' + value.value + '"]').html());
                        if(value.name == 'tipo_documento' && value.value == 6) {
                            $('#' + value.name + '-confirm').html('');
                        }
                        if(value.name == 'tipo_documento2' && value.value != 6) {
                            $('#' + value.name + '-confirm').html('');
                        }
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
        if ($('#frmRegistro').valid() == true) {
            /*var tipoDocu = $('#tipo_documento').val();
            var tipoDocu2 = $('#tipo_documento2').val();
            if(tipoDocu != 6 || (tipoDocu == 6 && tipoDocu2 != 5)) {
                if(unicaCedula('tipo_documento', 'numero_documento') == false) {
                    validator.showErrors({'numero_documento': 'Error: Ya existe un usuario registrado con este número de documento.'});
                    return false;
                }
            }*/

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
                    dialogo.setTitle('Guardar cuenta');
                    dialogo.setMessage(data.mensaje);
                    dialogo.open();
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

});

function recargar() {
    window.location.href = base_url + 'registro';
}