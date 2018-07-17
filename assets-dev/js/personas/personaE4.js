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
    
    $('#depto_nacimiento').cargarCombo('depto_nacimiento', 'muni_nacimiento', base_url + 'formulario/listaDesplegable');

    $('#depto_nacimiento').change(function() {
        $('option', '#muni_nacimiento').remove();
    });

    $('#muni_nacimiento').select2({
        allowClear: true,
        //containerCssClass: 'select2-container', // No funciona
        //dropdownCssClass: 'select2-container', // No funciona
        language: 'es',
        //minimumInputLength: 2,
        placeholder: 'Municipio o área no municipalizada',
        theme: 'bootstrap',
        width: '100%'
    });

    $('input[type=radio][name=lugar_nacimiento]').on('change', function() {
        if($(this).val() == 2) {
            $('#lugar_nacimiento-2-panel').removeClass('hidden');
            $('#lugar_nacimiento-3-panel').addClass('hidden');
            $('#pais_nacimiento').val('');
            $('#anio_llego').val('');
            $('#anio_llego-col').addClass('hidden');
        } else if($(this).val() == 3) {
            $('#lugar_nacimiento-3-panel').removeClass('hidden');
            $('#lugar_nacimiento-2-panel').addClass('hidden');
            $('#depto_nacimiento').val('');
            $('#muni_nacimiento').val('');
            $('#muni_nacimiento').select2({
                allowClear: true,
                language: 'es',
                placeholder: 'Municipio o área no municipalizada',
                theme: 'bootstrap',
                width: '100%'
            });
            $('#anio_llego-col').removeClass('hidden');
        } else {
            $('#lugar_nacimiento-2-panel').addClass('hidden');
            $('#depto_nacimiento').val('');
            $('#muni_nacimiento').val('');
            $('#muni_nacimiento').select2({
                allowClear: true,
                language: 'es',
                placeholder: 'Municipio o área no municipalizada',
                theme: 'bootstrap',
                width: '100%'
            });
            $('#lugar_nacimiento-3-panel').addClass('hidden');
            $('#pais_nacimiento').val('');
            $('#anio_llego').val('');
            $('#anio_llego-col').addClass('hidden');
        }
    });

    $('input[type=radio][name=otra_lengua]').on('change', function() {
        if($(this).val() == 1) {
            $('#cual_lengua-col').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#cual_lengua-col').addClass('hidden');
            $('#cual_lengua').val('');
        }
    });

    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            lugar_nacimiento: {required: true},
            depto_nacimiento: {selectVacio: true, required: function(elemtn){
                var cm =  $('input[type=radio][name=lugar_nacimiento]:checked');
                if (cm.val()==3)
                    return true;
                return false;
            }},
            muni_nacimiento: {selectVacio: true, required: function(elemtn){
                var cm =  $('input[type=radio][name=lugar_nacimiento]:checked');
                if (cm.val() == 3)
                    return true;
                return false;
            }},
            pais_nacimiento: {selectVacio: true},
            anio_llego: {selectVacio: true}
        },
        messages: {
            lugar_nacimiento: {required: 'ERROR: Debe seleccionar donde nació la persona.'},
            depto_nacimiento: {selectVacio: 'ERROR: Debe seleccionar el departamento de nacimiento de la persona.', required: 'ERROR: Debe seleccionar el departamento de nacimiento de la persona.'},
            muni_nacimiento: {selectVacio: 'ERROR: Debe seleccionar el municipio de nacimiento de la persona.', required: 'ERROR: Debe seleccionar el municipio de nacimiento de la persona.'},
            pais_nacimiento: {selectVacio: 'ERROR: Debe seleccionar el país de nacimiento de la persona.'},
            anio_llego: {selectVacio: 'ERROR: Debe seleccionar el año en que año llegó a Colombia.'}
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
        if( $("#muni_nacimiento").val() == null){
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