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

    var edadTipoDocu = function (edad, tipoDocu) {
        switch (tipoDocu) {
            case '2':
                if (edad > 6) {
                    return true;
                }
                break;
            case '3':
                if (edad > 17) {
                    return true;
                }
                break;
        }
        return false;
    };

    var mayorEdad = function (idCampo) {
        var fechaNaci = $('#' + idCampo).val();

        if(fechaNaci.length == 0) {
            $('#' + idCampo + '-error').html('Selecciona la fecha de nacimiento.').removeClass('hide').show();
            $(this).val('');
            return false;
        }

        var edad = calculaEdad(formatearFecha(fechaNaci), '');
        if(edad < 18) {
            return false;
        }
        return true;
    };

    $.validator.addMethod('validaRC', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        if(tipoDocu.length == 0) {
            return false;
        } else if(tipoDocu == '1') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu, value);
        }
        return true;
    });

    $.validator.addMethod('validaTI', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        if(tipoDocu.length == 0) {
            return false;
        } else if(tipoDocu == '2') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu, value);
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
        return mayorEdad($(element).attr('id'));
    });

    $.validator.addMethod('mayor121', function (value, element, params) {
        if(value > 121) {
            return false;
        }
        return true;
    });

    $.validator.addMethod('validarEdadTI', function (value, element, params) {
        var tipoDocu = $('#' + params[1]).val();
        if(tipoDocu == 2) {
            var edad = $('#' + params[0]).val();
            return edadTipoDocu(edad, tipoDocu);
        }
        return true;
    });

    $.validator.addMethod('validarEdadCC', function (value, element, params) {
        var tipoDocu = $('#' + params[1]).val();
        if(tipoDocu == 3) {
            var edad = $('#' + params[0]).val();
            return edadTipoDocu(edad, tipoDocu);
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

    $('#primer_nombre').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#segundo_nombre').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#primer_apellido').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#segundo_apellido').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#edad_persona').soloNumeros();

    $('#tipo_documento').on('change', function() {
        $('#numero_documento').val('');
        /*if($(this).val() == 3) {
            $('#fecha_expe-col').removeClass('hidden');
        } else {
            $('#fecha_expe-col').addClass('hidden');
            $('#anio_expe').val('');
            $('#mes_expe').val('');
            $('#dia_expe').val('');
        }*/
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
            return true;
            // return unicaCedula('tipo_documento', 'numero_documento');
        }

        return false;
    });

    var tabla_personas = $('#tabla_personas').DataTable({
        'processing': true,
        'ajax': base_url + 'personas/consultarGrilla',
        'columns': [
            { 'data': 'tipo_docu' },
            { 'data': 'nume_docu' },
            { 'data': 'fecha_expe' },
            { 'data': 'nombre' },
            { 'data': 'jefe' },
            { 'data': 'sexo' },
            { 'data': 'edad' },
            { 'data': 'opciones' }
        ],
        'language': {
            'url': base_url + 'assets/plugins/DataTables/datatables.locale-es.json'
        },
        'paging': false,
        'pageLength': 100,
        'bFilter': true,
        'ordering': true,
        'responsive': true,
        'searching': false,
        'info': false
    });

    $('#frmHogar').validate({
        errorClass: 'error-form',
        rules: {
            tipo_documento: {selectVacio: true},
            numero_documento: {
                //required: true,
                validaRC:['tipo_documento'],
                validaTI:['tipo_documento'],
               // validaCC:['tipo_documento'],
                validaCE:['tipo_documento'],
            },
            anio_expe: {validarCamposFecha: ['tipo_documento'], validarFecha:['anio_expe', 'mes_expe', 'dia_expe']},
            mes_expe: {validarCamposFecha: ['tipo_documento'], validarFecha:['anio_expe', 'mes_expe', 'dia_expe']},
            dia_expe: {validarCamposFecha: ['tipo_documento'], validarFecha:['anio_expe', 'mes_expe', 'dia_expe']},
            primer_nombre: {required: true, maxlength: 30},
            segundo_nombre: {maxlength: 30},
            primer_apellido: {required: true, maxlength: 30},
            segundo_apellido: {maxlength: 30},
            sexo_persona: {selectVacio: true},
            edad_persona: {required: true, validarEdadTI:['edad_persona', 'tipo_documento'], validarEdadCC:['edad_persona', 'tipo_documento'], mayor121: true, jefeMenorEdad:['edad_persona', 'jefe_hogar']},
            jefe_hogar: {required: true, jefeMenorEdad:['edad_persona', 'jefe_hogar']},
            // csrf_token: {required:false},
        },
        messages: {
            tipo_documento: {
                selectVacio: 'ERROR: Selecciona el tipo de identificación de la persona.'
            },
            numero_documento: {
                // required: 'ERROR: Digite el número de documento de la persona.',
                validaRC: 'ERROR: La longitud del número de documento debe ser entre 3 a 10 caracteres.',
                validaTI: 'ERROR: La longitud del número de documento debe ser  entre 2 a 12 caracteres.',
                //validaCC: 'ERROR: La longitud del número de documento debe ser entre 2 a 10 caracteres.',
                validaCE: 'ERROR: El documento debe tener entre 2 a 10 dígitos y/o caracteres.'
            },
            anio_expe: {
                validarCamposFecha: 'ERROR: Seleccione el año de la fecha de expedición.',
                validarFecha: 'ERROR: La fecha de expedición definida no es válida.'
            },
            mes_expe: {
                validarCamposFecha: 'ERROR: Seleccione el mes de la fecha de expedición.',
                validarFecha: 'ERROR: La fecha de expedición definida no es válida.'
            },
            dia_expe: {
                validarCamposFecha: 'ERROR: Seleccione el día de la fecha de expedición.',
                validarFecha: 'ERROR: La fecha de expedición definida no es válida.'
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
            edad_persona: {
                required: 'ERROR: Digite la edad de la persona.',
                validarEdadTI: 'ERROR: La persona con tarjeta de identidad debe ser mayor a 7 años',
                validarEdadCC: 'ERROR: La persona con cédula de ciudadanía debe ser mayor a 18 años',
                mayor121: 'ERROR: La edad no debe ser mayor de 121 años.',
                jefeMenorEdad: 'ERROR: No puede ser jefe(a) del hogar si es menor de 10 años.'
            },
            jefe_hogar: {
                required: 'ERROR: Seleccione si la persona es o no jefe de hogar.',
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
            return false;
        }
    });


    $('#btnGuardarPersona').on('click', function() {
        if ($('#frmHogar').valid() == true) {
            /*if(unicaCedula('tipo_documento', 'numero_documento') == false) {
                return false;
            }*/
            var frm = $('#frmHogar').serialize();
            //var accion = $('#btnGuardarPersona').data('accion');
            //var idpers = $('#btnGuardarPersona').data('idpers');
            var accion = $('#hdnAccion').val();
            var idpers = $('#idEditar').val();
            $.ajax({
                url: base_url + 'personas/persona/guardarPersona',
                type: 'POST',
                dataType: 'json',
                data: frm + '&accion=' + accion + '&id=' + idpers,
                beforeSend: function () {
                    $('#animationload').fadeIn();
                },
                complete: function () {
                    $('#animationload').fadeOut();
                }
            })
            .done(function(data) {
                if(data.codiError == 0) {
                    tabla_personas.ajax.reload();
                    $('#frmHogar').find('input,select').not('[type=hidden]').val('').prop({disabled:false});
                    $('#hdnAccion').val('agregar');
                    $('#idEditar').val('');
                    $('#btnGuardarPersona').html('Agregar');
                    $("html, body").animate({ scrollTop: 0 }, 600);
                } else {
                    dialogo.setTitle('Error al guardar la persona');
                    dialogo.setType(BootstrapDialog.TYPE_DANGER);
                    dialogo.setMessage(data.mensaje);
                    dialogo.open();
                }
            })
            .fail(function(jqXHR) {
                dialogo.setTitle('Error al guardar la persona');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(jqXHR.responseText);
                dialogo.open();
                // window.location.href = base_url + 'hogar';
            });
        }
    });

    $('#btnLimpiarPersona').on('click', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('').prop({disabled:false});
        $('#hdnAccion').val('agregar');
        $('#idEditar').val('');
        $('#btnGuardarPersona').html('Agregar residente');
        $("html, body").animate({ scrollTop: 0 }, 600);
    });

    $('#tabla_personas').on('click', '.editarPersona', function() {

       $('html, body').animate({
         scrollTop: $("#tipo_documento-col").offset().top
     }, 1500);

        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'personas/persona/consultarPersona',
            type: 'POST',
            dataType: 'json',
            data: { 'idPers': $item.data('idpers') }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $.each(data.form, function(key, value) {
                  $('#' + key).val(value);
                  if(data.registro != '' && key != 'jefe_hogar'){
                    $('#' + key).prop( "disabled", true );
                  }else{
                    $('#' + key).prop( "disabled", false );
                  }
                });
                //$("html, body").animate({ scrollTop: 0 }, 600);
                if(data.form.tipo_documento == 3) {
                    $('#fecha_expe-col').removeClass('hidden');
                }
                $('#hdnAccion').val('editar');
                $('#idEditar').val($item.data('idpers'));
                $('#btnGuardarPersona').html('Guardar cambios');
            } else {
                dialogo.setTitle('Error al consultar la persona');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(data.mensaje);
                dialogo.open();
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'hogar';
        });
    });

    $('#tabla_personas').on('click', '.eliminarPersona', function() {
        var total = tabla_personas.data().count();
        if(total <= 1) {
            dialogo.setTitle('Borrar persona');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage('Debe existir mínimo una persona.');
            dialogo.open();
            return false;
        } else {
            var $item = $(this);
            BootstrapDialog.show({
                title: 'Borrar persona',
                message: '¿Está seguro que quiere borrar a la persona seleccionada?',
                type: BootstrapDialog.TYPE_WARNING,
                closable: false,
                buttons: [{
                    label: 'Cancelar',
                    cssClass: 'btn-warning',
                    action: function(dialogRef){
                        dialogRef.close();
                    }
                }, {
                    label: 'Aceptar',
                    cssClass: 'btn-success',
                    action: function(dialogRef){
                        $.ajax({
                            url: base_url + 'personas/persona/eliminarPersona',
                            type: 'POST',
                            dataType: 'json',
                            data: {'idPers': $item.data('idpers')}
                        })
                        .done(function(data) {
                            if(data.codiError == 0) {
                                tabla_personas.ajax.reload();
                                dialogRef.close();
                            } else {
                                dialogo.setTitle('Error al eliminar la persona');
                                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                                dialogo.setMessage(data.mensaje);
                                dialogo.open();
                            }
                        })
                        .fail(function(jqXHR) {
                            dialogo.setTitle('Error al eliminar la persona');
                            dialogo.setType(BootstrapDialog.TYPE_DANGER);
                            dialogo.setMessage(jqXHR.responseText);
                            dialogo.open();
                        });
                    }
                }]
            });
        }
    });

    $('#btnSiguiente').on('click', function() {
        $('#divContent').addClass('hidden');
        var nombres = '<ul>';
        //$('#total_personas-confirm').html(total);
        $.each(tabla_personas.rows().data(), function(key, value) {
          nombres += '<li>' + value.nombre + '</li>';
        });
        nombres += '</ul>';
        $('#lblPersonsList').html(nombres);
        $('#mensajeConfirmacion').removeClass('hidden');
    });

    $('#btnAnteriorConfirmacion').on('click', function() {
        $('#divContent').removeClass('hidden');
        $('#mensajeConfirmacion').addClass('hidden');
    });

    $('#btnSiguienteConfirmacion').on('click', function() {
        $('.error-form').addClass('hidden');
        var total = tabla_personas.data().count();
        $.ajax({
            url: base_url + 'hogar/guardar',
            type: 'POST',
            dataType: 'json',
            data: 'numero_personas=' + total + '&duracion=' + duracionPagina(),
            beforeSend: function () {
                $('#msgSuccessConfirm').html('Guardando las respuestas...');
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgSuccessConfirm').removeClass('hidden');
            }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $(':input').addClass('disabled').prop('disabled', true);
                $(':button').addClass('disabled').prop('disabled', true);
                $('#msgSuccessConfirm').html(data.mensaje);
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgSuccessConfirm').removeClass('hidden');
                $('#progressbar').html(data.avance + '% COMPLETADO').css('width', data.avance + '%');
                //setTimeout(recargar, 2000);
                recargar();
            } else {
                $('#msgErrorConfirm').html(data.mensaje);
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgAlertConfirm').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'hogar';
        });
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'hogar/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + '% COMPLETADO').css('width', data.avance + '%');
                window.location.href = base_url + 'hogar';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'hogar';
        });
    });
});

function recargar() {
    window.location.href = base_url + 'hogar';
}