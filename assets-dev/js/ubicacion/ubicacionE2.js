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

    if($('#otro_centro_poblado-col').val().length == 0) {
        $('#otro_centro_poblado-col').addClass('hidden');
    }

    $('input[type=radio][name=clase]').on('change', function() {
        if($(this).val() == 1) {
            $('#clase-1-panel').removeClass('hidden');
            $('#clase-2-panel').addClass('hidden');
            $('#centro_poblado').val('');
            $('#clase-3-panel').addClass('hidden');
            $('input[name=tipo_centro]').prop('checked', false);
            $('input[name=tipo_rural]').prop('checked', false);
        } else if($(this).val() == 2) {
            $('#clase-1-panel').addClass('hidden');
            $('#localidad').val('');
            $('#clase-2-panel').removeClass('hidden');
            $('#clase-3-panel').addClass('hidden');
            $('input[name=tipo_rural]').prop('checked', false);
        } else if($(this).val() == 3) {
            $('#clase-1-panel').addClass('hidden');
            $('#localidad').val('');
            $('#clase-2-panel').addClass('hidden');
            $('#centro_poblado').val('');
            $('#clase-3-panel').removeClass('hidden');
            $('input[name=tipo_centro]').prop('checked', false);
        }
    });

    $('#centro_poblado').on('change', function() {
        if($(this).val() == 888) {
            $('#otro_centro_poblado-col').removeClass('hidden');
        } else {
            $('#otro_centro_poblado-col').addClass('hidden');
            $('#otro_centro_poblado').val('');
        }
    });

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            clase: {required: true},
            localidad: {selectVacio: true},
            centro_poblado: {selectVacio: true},
            otro_centro_poblado: {required: true},
        },
        messages: {
            clase: { required: 'ERROR: Seleccione el lugar donde reside.' },
            localidad: {selectVacio: 'ERROR: Seleccione la localidad o comuna.'},
            centro_poblado: {selectVacio: 'ERROR: Seleccione el centro poblado.'},
            otro_centro_poblado: {required: 'ERROR: Digite el nombre del otro centro de poblado.'},
            tipo_centro: {required: 'ERROR: Seleccione el tipo de centro poblado.'},
            tipo_rural: {required: 'ERROR: Seleccione el tipo de rural disperso.' }
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
            var frm = $('#frmUbicacion').serialize();
            $(':input').addClass('disabled').prop('disabled', true);
            $(':button').addClass('disabled').prop('disabled', true);
            $.ajax({
                url: base_url + 'ubicacion/guardar',
                type: 'POST',
                dataType: 'json',
                data: frm + '&duracion=' + duracionPagina(),
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
                    //$('#animationload').fadeIn();
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