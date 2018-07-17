$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

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

    $.fn.mostrarEstaTerritoEtnico = function (campo) {
        $('#' + campo + '-col').removeClass('hidden');
    };

    $.fn.mostrarNombreTerritoEtnico = function (campo) {
        $('#' + campo + '-1-panel').removeClass('hidden');
    };

    $.fn.borrarEstaTerritoEtnico = function (campo1, campo2) {
        $('input[name=' + campo1 + ']').prop('checked', false);
        $('#' + campo2).val('');
        $('#' + campo1 + '-col').addClass('hidden');
        $('#' + campo1 + '-1-panel').addClass('hidden');
    };

    $.fn.borrarNombreTerritoEtnico = function (campo1, campo2) {
        $('#' + campo2).val('');
        $('#' + campo1 + '-1-panel').addClass('hidden');
    };

    //$('#nombre_terri_etnico').soloNombre().maxlength(40).verificaEspacios();
    $('#nombre_ancestral').soloNombre().maxlength(20).verificaEspacios();
    $('#nombre_parcialidad').soloNombre().maxlength(20).verificaEspacios();
    $('#nombre_reserva').soloNombre().maxlength(20).verificaEspacios();
    $('#nombre_comunidad_negra').soloNombre().maxlength(20).verificaEspacios();
    $('#nombre_raizal').soloNombre().maxlength(20).verificaEspacios();

    /*$('input[type=radio][name=es_resguardo_terri]').on('change', function() {
        if($(this).val() == 1) {
            $('#tipo_territo-col').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#tipo_territo-col').addClass('hidden');
            $('input[name=tipo_territo]').prop('checked', false);
            $('#tipo_territo-1-panel').addClass('hidden');
            $('#resguardo').val('');
            $('#tipo_territo-2-panel').addClass('hidden');
            $('#territorio').val('');
        }
    });*/

    /*$('input[type=radio][name=tipo_territo]').on('change', function() {
        if($(this).val() == 1) {
            $('#tipo_territo-1-panel').removeClass('hidden');
            $('#tipo_territo-2-panel').addClass('hidden');
            $('#territorio').val('');
        } else if($(this).val() == 2) {
            $('#tipo_territo-1-panel').addClass('hidden');
            $('#resguardo').val('');
            $('#tipo_territo-2-panel').removeClass('hidden');
        }
    });*/

    /*$('input[type=radio][name=es_area]').on('change', function() {
        if($(this).val() == 1) {
            $('#es_area-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#es_area-1-panel').addClass('hidden');
            $('#area_protegida').val('');
        }
    });*/

    $('input[type=radio][name=es_vivi_etnico]').on('change', function() {
        if($(this).val() == 1) {
            $(this).mostrarEstaTerritoEtnico('esta_ancestral');
            $(this).mostrarEstaTerritoEtnico('esta_parcialidad');
            $(this).mostrarEstaTerritoEtnico('esta_reserva');
            $(this).mostrarEstaTerritoEtnico('esta_comunidad_negra');
            $(this).mostrarEstaTerritoEtnico('esta_raizal');
        } else if($(this).val() == 2) {
            $('#es_vivi_etnico-1-panel').addClass('hidden');
            $(this).borrarEstaTerritoEtnico('esta_ancestral', 'nombre_ancestral');
            $(this).borrarEstaTerritoEtnico('esta_parcialidad', 'nombre_parcialidad');
            $(this).borrarEstaTerritoEtnico('esta_reserva', 'nombre_reserva');
            $(this).borrarEstaTerritoEtnico('esta_comunidad_negra', 'nombre_comunidad_negra');
            $(this).borrarEstaTerritoEtnico('esta_raizal', 'nombre_raizal');
        }
    });

    $('input[type=radio][name=esta_ancestral]').on('change', function() {
        $(this).borrarNombreTerritoEtnico('esta_comunidad_negra', 'nombre_comunidad_negra');
        $('input[name=esta_comunidad_negra]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_raizal', 'nombre_raizal');
        $('input[name=esta_raizal]').prop('checked', false);
        if($(this).val() == 1) {
            $('#esta_ancestral-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $(this).borrarNombreTerritoEtnico('esta_ancestral', 'nombre_ancestral');
        }
    });

    $('input[type=radio][name=esta_parcialidad]').on('change', function() {
        $(this).borrarNombreTerritoEtnico('esta_comunidad_negra', 'nombre_comunidad_negra');
        $('input[name=esta_comunidad_negra]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_raizal', 'nombre_raizal');
        $('input[name=esta_raizal]').prop('checked', false);
        if($(this).val() == 1) {
            $('#esta_parcialidad-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $(this).borrarNombreTerritoEtnico('esta_parcialidad', 'nombre_parcialidad');
        }
    });

    $('input[type=radio][name=esta_reserva]').on('change', function() {
        $(this).borrarNombreTerritoEtnico('esta_comunidad_negra', 'nombre_comunidad_negra');
        $('input[name=esta_comunidad_negra]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_raizal', 'nombre_raizal');
        $('input[name=esta_raizal]').prop('checked', false);
        if($(this).val() == 1) {
            $('#esta_reserva-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $(this).borrarNombreTerritoEtnico('esta_reserva', 'nombre_reserva');
        }
    });

    $('input[type=radio][name=esta_comunidad_negra]').on('change', function() {
        $(this).borrarNombreTerritoEtnico('esta_ancestral', 'nombre_ancestral');
        $('input[name=esta_ancestral]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_parcialidad', 'nombre_parcialidad');
        $('input[name=esta_parcialidad]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_reserva', 'nombre_reserva');
        $('input[name=esta_reserva]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_raizal', 'nombre_raizal');
        $('input[name=esta_raizal]').prop('checked', false);
        if($(this).val() == 1) {
            $('#esta_comunidad_negra-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $(this).borrarNombreTerritoEtnico('esta_comunidad_negra', 'nombre_comunidad_negra');
        }
    });

    $('input[type=radio][name=esta_raizal]').on('change', function() {
        $(this).borrarNombreTerritoEtnico('esta_ancestral', 'nombre_ancestral');
        $('input[name=esta_ancestral]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_parcialidad', 'nombre_parcialidad');
        $('input[name=esta_parcialidad]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_reserva', 'nombre_reserva');
        $('input[name=esta_reserva]').prop('checked', false);
        $(this).borrarNombreTerritoEtnico('esta_comunidad_negra', 'nombre_comunidad_negra');
        $('input[name=esta_comunidad_negra]').prop('checked', false);
        if($(this).val() == 1) {
            $('#esta_raizal-1-panel').removeClass('hidden');
        } else if($(this).val() == 2) {
            $(this).borrarNombreTerritoEtnico('esta_raizal', 'nombre_raizal');
        }
    });
    
    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            es_vivi_etnico: {required: true},
            nombre_ancestral: {required: true},
            nombre_parcialidad: {required: true},
            nombre_reserva: {required: true},
            nombre_comunidad_negra: {required: true},
            nombre_raizal: {required: true}
        },
        messages: {
            es_vivi_etnico: {required: 'ERROR: Seleccione si la vivienda en la cual reside habitualmente se encuentra en el interior de un territorio étnico.'},
            nombre_ancestral: {required: 'ERROR: Digite el nombre del territorio ancestral o tradicional indígena.'},
            nombre_parcialidad: {required: 'ERROR: Digite el nombre de la parcialidad o asentamiento indígena fuera de resguardo.'},
            nombre_reserva: {required: 'ERROR: Digite el nombre la reserva indígena.'},
            nombre_comunidad_negra: {required: 'ERROR: Digite el nombre del territorio ancestral o tradicional de comunidades negras no tituladas.'},
            nombre_raizal: {required: 'ERROR: Digite el nombre del territorio ancestral raizal del Archipiélago de San Andrés, Providencia y Santa Catalina.'}
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
        if ($('#frmUbicacion').valid() == true) {
            var validator = $('#frmUbicacion').validate();
            var es_vivi_etnico =  $('input[type=radio][name=es_vivi_etnico]:checked').val();
            if(es_vivi_etnico == 1) {
                var esta_ancestral =  $('input[type=radio][name=esta_ancestral]:checked').val();
                var esta_parcialidad =  $('input[type=radio][name=esta_parcialidad]:checked').val();
                var esta_reserva =  $('input[type=radio][name=esta_reserva]:checked').val();
                var esta_comunidad_negra =  $('input[type=radio][name=esta_comunidad_negra]:checked').val();
                var esta_raizal =  $('input[type=radio][name=esta_raizal]:checked').val();
                var esta_etnico_1 = true;
                // Falta hacer la validacion de las opciones al guardar
                /*if (typeof esta_parcialidad == undefined) {
                    esta_etnico_1 = false;
                }*/
                if(esta_ancestral != 1 && esta_ancestral != 2) {
                    esta_ancestral = 3;
                }
                if(esta_parcialidad != 1 && esta_parcialidad != 2) {
                    esta_parcialidad = 3;
                }
                if(esta_reserva != 1 && esta_reserva != 2) {
                    esta_reserva = 3;
                }
                if(esta_comunidad_negra != 1 && esta_comunidad_negra != 2) {
                    esta_comunidad_negra = 3;
                }
                if(esta_raizal != 1 && esta_raizal != 2) {
                    esta_raizal = 3;
                }
                if ((esta_ancestral == 2 || esta_ancestral == 3) && (esta_parcialidad == 2 || esta_parcialidad == 3) && (esta_reserva == 2 || esta_reserva == 3)) {
                    esta_etnico_1 = false;
                }

                if(esta_etnico_1 == false && (esta_comunidad_negra == 2 || esta_raizal == 2)) {
                    validator.showErrors({'es_vivi_etnico': 'Error: Debe seleccionar el territorio étnico donde se encuentra la vivienda.'});
                    return false;
                }
                if(esta_etnico_1 == false && (esta_comunidad_negra == 3 && esta_raizal == 3)) {
                    validator.showErrors({'es_vivi_etnico': 'Error: Debe seleccionar el territorio étnico donde se encuentra la vivienda.'});
                    return false;
                }
            }

            var frm = $('#frmUbicacion').serialize();
            $(':input').addClass('disabled').prop('disabled', true);
            $(':button').addClass('disabled').prop('disabled', true);
            $.ajax({
                url: base_url + 'ubicacion/guardar',
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
                    //setTimeout(recargar, 2000);
                    recargar();
                } else {
                    $('#msgError').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgAlert').removeClass('hidden');
                }
            })
            .fail(function(jqXHR) {
                window.location.href = base_url + 'ubicacion';
            });
        }
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'ubicacion/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                window.location.href = base_url + 'ubicacion';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'ubicacion';
        });
    });
});

function recargar() {
    window.location.href = base_url + 'ubicacion';
}