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
    
    $('#depto_5anios').cargarCombo('depto_5anios', 'muni_5anios', base_url + 'formulario/listaDesplegable');

    $('#depto_5anios').change(function() {
        $('option', '#muni_5anios').remove();
    });

    $('#muni_5anios').select2({
        allowClear: true,
        //containerCssClass: 'select2-container', // No funciona
        //dropdownCssClass: 'select2-container', // No funciona
        language: 'es',
        //minimumInputLength: 2,
        placeholder: 'Municipio o área no municipalizada',
        theme: 'bootstrap',
        width: '100%'
    });

    $('input[type=radio][name=lugar_5anios]').on('change', function() {
        if($(this).val() == 2) {
            $('#depto_5anios').val('');
            $('#muni_5anios').val('');
            $('#muni_5anios').select2({
                allowClear: true,
                language: 'es',
                placeholder: 'Municipio o área no municipalizada',
                theme: 'bootstrap',
                width: '100%'
            });
            $('#pais_5anios').val('');
            $('#anio_llego_5anios').val('');
            $('#lugar_5anios-3-panel').addClass('hidden');
            $('#lugar_5anios-4-panel').addClass('hidden');
            $('#clase_5anios-col').removeClass('hidden');
        } else if($(this).val() == 3) {
            $('#lugar_5anios-3-panel').removeClass('hidden');
            $('#lugar_5anios-4-panel').addClass('hidden');
            $('#pais_5anios').val('');
            $('#anio_llego_5anios').val('');
            $('#clase_5anios-col').removeClass('hidden');
        } else if($(this).val() == 4) {
            $('#depto_5anios').val('');
            $('#muni_5anios').val('');
            $('#muni_5anios').select2({
                allowClear: true,
                language: 'es',
                placeholder: 'Municipio o área no municipalizada',
                theme: 'bootstrap',
                width: '100%'
            });
             $('#lugar_5anios-4-panel').removeClass('hidden');
            $('#lugar_5anios-3-panel').addClass('hidden');
            $('#clase_5anios-col').addClass('hidden');
            $('input[name=clase_5anios]').prop('checked', false);
        } else {
            $('#lugar_5anios-3-panel').addClass('hidden');
            $('#depto_5anios').val('');
            $('#muni_5anios').val('');
            $('#lugar_5anios-4-panel').addClass('hidden');
            $('#pais_5anios').val('');
            $('#anio_llego_5anios').val('');
            $('#clase_5anios-col').addClass('hidden');
            $('input[name=clase_5anios]').prop('checked', false);
        }
    });

    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            lugar_5anios: {required: true},
            depto_5anios: {selectVacio: true, required: function(elemtn){
                var cm =  $('input[type=radio][name=lugar_5anios]:checked');
                if (cm.val()==3)
                    return true;
                return false;
            }},
            muni_5anios: {selectVacio: true, required: function(elemtn){
                var cm =  $('input[type=radio][name=lugar_5anios]:checked');
                if (cm.val() == 3)
                    return true;
                return false;
            }},
            pais_5anios: {selectVacio: true},
            anio_llego_5anios: {selectVacio: true},
            clase_5anios: {required: true}
        },
        messages: {
            lugar_5anios: {required: 'ERROR: Debe seleccionar donde residía la persona.'},
            depto_5anios: {selectVacio: 'ERROR: Debe seleccionar el departamento donde residía la persona.', required: 'ERROR: Debe seleccionar el departamento donde residía la persona.'},
            muni_5anios: {selectVacio: 'ERROR: Debe seleccionar el municipio donde residía de la persona.', required: 'ERROR: Debe seleccionar el municipio donde residía de la persona.'},
            pais_5anios: {selectVacio: 'ERROR: Debe seleccionar el país donde residía de la persona.'},
            anio_llego_5anios: {selectVacio: 'ERROR: Debe seleccionar el año en que año llegó a Colombia.'},
            clase_5anios: {required: 'ERROR: Debe seleccionar la clase donde residía la persona.'}
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
        if( $("#muni_5anios").val() == null){
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