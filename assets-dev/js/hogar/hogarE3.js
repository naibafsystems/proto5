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

    $.validator.addMethod('mayor121', function (value, element, params) {
        if(value > 121) {
            return false;
        }
        return true;
    });

    $.validator.addMethod('totalPersonas', function (value, element, params) {
        var total = tabla_fallecidas.data().count();
        if(value == total) {
            return true;
        }
        return false;
    });

    var tabla_fallecidas = $('#tabla_fallecidas').DataTable({
        'processing': true,
        'ajax': base_url + 'personas/consultarPersonasFallecidas',
        'columns': [
        { 'data': 'sexo' },
        { 'data': 'edad' },
        { 'data': 'certificado' },
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
        /*'infoCallback': function(settings, start, end, max, total, pre) {
			return 'Mostrando registros del ' + start + ' al ' + end + ' de ' + total + ' registros'
				+ ((total !== max) ? " (filtered from " + max + " total entries)" : "");
          }*/
      });

    //new $.fn.dataTable.FixedHeader('tabla_fallecidas');

    $('#numero_fallecidas').on('change', function() {
        if($(this).val() > 0) {
            $('#grillaFallecidas').removeClass('hidden');
        } else {
            $('#grillaFallecidas').addClass('hidden');
        }
    });

    $('#edad_fallecida').bloquearTexto();

    $('#frmHogar').validate({
        errorClass: 'error-form',
        rules: {
            sexo_fallecida: {selectVacio: true},
            edad_fallecida: {selectVacio: true, mayor121: true},
            certificado_fallecida: {selectVacio: true}
        },
        messages: {
            sexo_fallecida: { selectVacio: 'ERROR: Seleccione el tipo el sexo de la persona fallecida.' },
            edad_fallecida: {
                selectVacio: 'ERROR: Seleccione la edad al morir de la persona fallecida.',
                mayor121: 'ERROR: La edad no debe ser mayor de 121 años.'
            },
            certificado_fallecida: { selectVacio: 'ERROR: Seleccione si se expidió el certificado médico de defunción.' }
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

    $('#btnGuardarFallecida').on('click', function() {
        if ($('#frmHogar').valid() == true) {
            var frm = $('#frmHogar').serialize();
            //var accion = $('#btnGuardarPersona').data('accion');
            //var idpers = $('#btnGuardarPersona').data('idpers');
            var accion = $('#hdnAccion').val();
            var idpers = $('#idEditar').val();

            $.ajax({
                url: base_url + 'personas/persona/guardarFallecida',
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
                    /*tabla_fallecidas.ajax.reload(function(json) {
                        //$('#totalPersonasFallecidas').html(tabla_fallecidas.data().count());
                        $('#numero_fallecidas').val(tabla_fallecidas.data().count());
                    });*/
                    tabla_fallecidas.ajax.reload();
                    $('#sexo_fallecida').val('');
                    $('#edad_fallecida').val('');
                    $('#certificado_fallecida').val('');
                    //$('#frmHogar').find('input,select').not('[type=hidden]').val('');
                    $('#hdnAccion').val('agregar');
                    $('#idEditar').val('');
                    $('#btnGuardarFallecida').html('Agregar');
                } else {
                    dialogo.setTitle('Error al guardar la persona fallecida');
                    dialogo.setType(BootstrapDialog.TYPE_DANGER);
                    dialogo.setMessage(data.mensaje);
                    dialogo.open();
                }
            })
            .fail(function(jqXHR) {
                window.location.href = base_url + 'hogar';
            });
        }
    });

    $('#btnLimpiarFallecida').on('click', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        $('#sexo_fallecida').focus();
        $('#hdnAccion').val('agregar');
        $('#idEditar').val('');
        $('#btnGuardarFallecida').html('Agregar');
    });

    $('#tabla_fallecidas').on('click', '.editarFallecida', function() {
        $('#sexo_fallecida').val('');
        $('#edad_fallecida').val('');
        $('#certificado_fallecida').val('');
        //$(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'personas/persona/consultarFallecida',
            type: 'POST',
            dataType: 'json',
            data: { 'idPers': $item.data('idpers') }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $.each(data.form, function(key, value) {
                  $('#' + key).val(value);
                });
                $('#sexo_fallecida').focus();
                $('#hdnAccion').val('editar');
                $('#idEditar').val($item.data('idpers'));
                $('#btnGuardarFallecida').html('Editar');
            } else {
                dialogo.setTitle('Error al consultar la persona fallecida');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(data.mensaje);
                dialogo.open();
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'hogar';
        });
    });

    $('#tabla_fallecidas').on('click', '.eliminarFallecida', function() {
    	var $item = $(this);
        BootstrapDialog.show({
            title: 'Borrar persona fallecida',
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
                        url: base_url + 'personas/persona/eliminarFallecida',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'idPers': $item.data('idpers')
                        }
                    })
                    .done(function(data) {
                        if(data.codiError == 0) {
                            tabla_fallecidas.ajax.reload(function(json) {
                                //$('#totalPersonasFallecidas').html(data.total);
                                $('#numero_fallecidas').val(data.total);
                            });
                            dialogRef.close();
                        } else {
                            dialogo.setTitle('Error al eliminar la persona fallecida');
                            dialogo.setType(BootstrapDialog.TYPE_DANGER);
                            dialogo.setMessage(data.mensaje);
                            dialogo.open();
                        }
                    })
                    .fail(function(jqXHR) {
                        window.location.href = base_url + 'hogar';
                    });
                }
            }]
        });
    });

    $('#numero_fallecidas').on('click', function() {
        if($(this).val() > 0) {
            $('#divFallecidos').removeClass('hidden');
            //tabla_fallecidos.load();
        } else {
            $('#divFallecidos').addClass('hidden');
        }
    });

    $('#btnSiguiente').on('click', function() {
        var validator = $('#frmHogar').validate();
        var total = $('#numero_fallecidas').val();
        var data_tabla = tabla_fallecidas.rows(0).data();
        var total_tabla = tabla_fallecidas.data().count();
        if(data_tabla[0].sexo.length == 0) {
            total_tabla = 0;
        }
        if(total.length == 0) {
            validator.showErrors({'numero_fallecidas': 'ERROR: Debe seleccionar el número de personas que fallecierón en el 2017.'});
            return false;
        }
        if(total != total_tabla) {
            validator.showErrors({'numero_fallecidas': 'ERROR: El número de personas fallecidas debe ser igual a las personas de la grilla.'});
            return false;
        }
        $('#divContent').addClass('hidden');
        $('#total_fallecidas-confirm').html(total);
        $('#mensajeConfirmacion').removeClass('hidden');
    });

    $('#btnAnteriorConfirmacion').on('click', function() {
        $('#divContent').removeClass('hidden');
        $('#mensajeConfirmacion').addClass('hidden');
    });

    $('#btnSiguienteConfirmacion').on('click', function() {
        var total = $('#numero_fallecidas').val();
        $('.error-form').addClass('hidden');
        $.ajax({
            url: base_url + 'hogar/guardar',
            type: 'POST',
            dataType: 'json',
            data: 'numero_fallecidas=' + total + '&duracion=' + duracionPagina(),
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