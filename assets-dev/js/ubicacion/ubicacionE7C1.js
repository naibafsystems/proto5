$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    var direccion = '';

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

    $('#numero_via').textoDireccion().maxlength(20);
    $('#numero_via2').textoDireccion().maxlength(20);
    $('#numero_placa').textoDireccion().maxlength(20);
    $('#complementos').textoDireccion().maxlength(100);

    $('#tipo_via, #numero_via, #numero_via2, #numero_placa, #complementos').change(function(event) {
        var item = $(this);
        var tipo_via = $('#tipo_via ');
        var numero_via = $('#numero_via ');
        var numero_via2 = $('#numero_via2 ');
        var numero_placa = $('#numero_placa');
        var complementos = $('#complementos');

        // si todos los campos estan vacios son obligatorios
        if (tipo_via.val() == '' && numero_via.val() == '' && numero_via2.val() == '' && numero_placa.val() == '' && complementos.val() == ''){
            tipo_via.rules('add',{selectVacio: true});
            numero_via.rules('add',{required: true});
            numero_via2.rules('add',{required: true});
            numero_placa.rules('add',{required: true});
            complementos.rules('add', {required: true});
        }
        // si digita solo complemento los demas campos no son obligatorios
        if (tipo_via.val() == '' && numero_via.val() == '' && numero_via2.val() == '' && numero_placa.val() == '' && complementos.val() != ''){
            tipo_via.rules('add',{selectVacio: false});
            numero_via.rules('add',{required: false});
            numero_via2.rules('add',{required: false});
            numero_placa.rules('add',{required: false});
            complementos.rules('add', {required: true});
            tipo_via.valid();
            numero_via.valid();
            numero_via2.valid();
            numero_placa.valid();
        }

        // si digita cualquier campo el complemento no es obligatorio
        if ((tipo_via.val() != '' || numero_via.val() != '' || numero_via2.val() != '' || numero_placa.val() != '') && complementos.val() == '') {
            tipo_via.rules('add',{selectVacio: true});
            numero_via.rules('add',{required: true});
            numero_via2.rules('add',{required: true});
            numero_placa.rules('add',{required: true});
            complementos.rules('add', {required: false});
            complementos.valid();
        }
    });

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            tipo_via: {selectVacio: true },
            numero_via: {required: true },
            numero_via2: {required: true },
            numero_placa: {required: true },
            complementos: {required: true }
        },
        messages: {
            tipo_via: { selectVacio: 'ERROR: Seleccione el tipo de vía de la dirección.' },
            numero_via: { required: 'ERROR: Digite el número de vía de la dirección.' },
            numero_via2: { required: 'ERROR: Digite el número de vía secundaria de la  dirección.' },
            numero_placa: { required: 'ERROR: Digite el número de placa de la dirección.' },
            complementos: { required: 'ERROR: Digite la dirección.' }
        },
        /*acc*/
        // onfocusout: function (element) {
        //     if(!$(element).valid()) {
        //         $('#' + $(element).attr('id')).focus();
        //     }
        // },
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
        if ($('#frmUbicacion').valid() == true) {
            $('#divContent').addClass('hidden');
            //$('#direccion-confirm').html($('#direccion').val());
            direccion = $('#tipo_via').val();
            if($('#numero_via').val().length > 0) {
                direccion += ' ' + $('#numero_via').val();
            }
            if($('#numero_via2').val().length > 0) {
                direccion += ' &#35; ' + $('#numero_via2').val();
            }
            if($('#numero_placa').val().length > 0) {
                direccion += ' - ' + $('#numero_placa').val();
            }
            if($('#complementos').val().length > 0) {
                direccion += ' ' + $('#complementos').val();
            }
            $('#direccion-confirm').html(direccion);
            $('#mensajeConfirmacion').removeClass('hidden');
        }
    });

    $('#btnAnteriorConfirmacion').on('click', function() {
        $('#divContent').removeClass('hidden');
        $('#mensajeConfirmacion').addClass('hidden');
    });

    $('#btnSiguienteConfirmacion').on('click', function() {
        $('.alert').addClass('hidden');
        var frm = $('#frmUbicacion').serialize();
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'ubicacion/guardar',
            type: 'POST',
            dataType: 'json',
            data: frm + '&duracion=' + duracionPagina(),
            beforeSend: function () {
                $('#msgSuccessConfirm').html('Guardando las respuestas...');
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgSuccessConfirm').removeClass('hidden');
            }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#msgSuccessConfirm').html(data.mensaje);
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgSuccessConfirm').removeClass('hidden');
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                //setTimeout(recargar, 2000);
                recargar();
            } else {
                $('#msgErrorConfirm').html(data.mensaje);
                $('#divMsgConfirm').removeClass('hidden');
                $('#divMsgAlertConfirm').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'ubicacion';
        });
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