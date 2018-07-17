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

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('#btnNoAcepto').click(function () {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $(location).attr('href', base_url + 'registro/noAcepto');
    });

    $('#btnAcepto').on('click', function() {
        $('.alert').addClass('hidden');
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'registro/guardar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#msgSuccess').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgSuccess').removeClass('hidden');
                $('#progressbar').html(data.avance + '% COMPLETADO').css('width', data.avance + '%');
                setTimeout(recargar, 2000);
            } else {
                BootstrapDialog.show({
                    title: 'Alerta',
                    message: data.mensaje,
                    closable: false,
                    buttons: [{
                        label: 'Aceptar',
                        action: function(dialog) {
                            $(location).attr('href', base_url + '/registro');
                        }
                    }]
                });
            }
        })
        .fail(function(jqXHR) {
            dialogo.setTitle('Error al guardar');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
        });
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'registro/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + '% COMPLETADO').css('width', data.avance + '%');
                window.location.href = base_url + 'registro';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            dialogo.setTitle('Error al regresar');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
        });
    });
});

function recargar() {
    window.location.href = base_url + 'registro';
}