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

    $('#depto_1anio').cargarCombo('depto_1anio', 'muni_1anio', base_url + 'formulario/listaDesplegable');

     $('#depto_1anio').change(function() {
        $("#muni_1anio").select2("val", "");

        $('option', '#muni_1anio').remove();
    });
     
    $('#muni_1anio').select2({
        allowClear: true,
        //containerCssClass: 'select2-container', // No funciona
        //dropdownCssClass: 'select2-container', // No funciona
        language: 'es',
        //minimumInputLength: 2,
        placeholder: 'Municipio o área no municipalizada',
        theme: 'bootstrap',
        width: '100%'
    });

    $('input[type=radio][name=lugar_1anio]').on('change', function() {
        if($(this).val() == 2) {
            $('#lugar_1anio-3-panel').addClass('hidden');
            $('#depto_1anio').val('');
            $('#muni_1anio').val('');
            $('#muni_1anio').select2({
                allowClear: true,
                language: 'es',
                placeholder: 'Municipio o área no municipalizada',
                theme: 'bootstrap',
                width: '100%'
            });
            $('#lugar_1anio-4-panel').addClass('hidden');
            $('#pais_1anio').val('');
            $('#clase_1anio-col').removeClass('hidden');
            $('#causa_1anio-col').addClass('hidden');
            $('input[name=causa_1anio]').prop('checked', false);
        } else if($(this).val() == 3) {
            $('#lugar_1anio-3-panel').removeClass('hidden');
            $('#lugar_1anio-4-panel').addClass('hidden');
            $('#pais_1anio').val('');
            $('#clase_1anio-col').removeClass('hidden');
            $('#causa_1anio-col').removeClass('hidden');
        } else if($(this).val() == 4) {
            $('#lugar_1anio-4-panel').removeClass('hidden');
            $('#lugar_1anio-3-panel').addClass('hidden');
            $('#depto_1anio').val('');
            $('#muni_1anio').val('');
            $('#muni_1anio').select2({
                allowClear: true,
                language: 'es',
                placeholder: 'Municipio o área no municipalizada',
                theme: 'bootstrap',
                width: '100%'
            });
            $('#clase_1anio-col').addClass('hidden');
            $('input[name=clase_1anio]').prop('checked', false);
            $('#causa_1anio-col').removeClass('hidden');
        } else {
            $('#lugar_1anio-3-panel').addClass('hidden');
            $('#depto_1anio').val('');
            $('#muni_1anio').val('');
            $('#muni_1anio').select2({
                allowClear: true,
                language: 'es',
                placeholder: 'Municipio o área no municipalizada',
                theme: 'bootstrap',
                width: '100%'
            });
            $('#lugar_1anio-4-panel').addClass('hidden');
            $('#pais_1anio').val('');
            $('#clase_1anio-col').addClass('hidden');
            $('input[name=clase_1anio]').prop('checked', false);
            $('#causa_1anio-col').addClass('hidden');
            $('input[name=causa_1anio]').prop('checked', false);
        }
    });

    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            lugar_1anio: {required: true},
            depto_1anio: {selectVacio: true, required: function(elemtn){
                var cm =  $('input[type=radio][name=lugar_5anios]:checked');
                if (cm.val()==3)
                    return true;
                return false;
            }},
            muni_1anio: {selectVacio: true, required: function(elemtn){
                var cm =  $('input[type=radio][name=lugar_5anios]:checked');
                if (cm.val() == 3)
                    return true;
                return false;
            }},
            pais_1anio: {selectVacio: true},
            clase_1anio: {required: true},
            causa_1anio: {required: true}
        },
        messages: {
            lugar_1anio: {required: 'ERROR: Debe seleccionar donde residía la persona.'},
            depto_1anio: {selectVacio: 'ERROR: Debe seleccionar el departamento donde residía la persona.', required: 'ERROR: Debe seleccionar el departamento donde residía la persona.'},
            muni_1anio: {selectVacio: 'ERROR: Debe seleccionar el municipio donde residía de la persona.', required: 'ERROR: Debe seleccionar el municipio donde residía de la persona.'},
            pais_1anio: {selectVacio: 'ERROR: Debe seleccionar el país donde residía de la persona.'},
            clase_1anio: {required: 'ERROR: Debe seleccionar la clase donde residía la persona.'},
            causa_1anio: {required: 'Error: Debe seleccionar el principal motivo por el que cambió de municipio o de país la persona.'}
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
        if( $("#muni_1anio").val() == null){
            recargar();
        }else{
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
});

function recargar() {
    window.location.href = base_url + 'personas/persona';
}