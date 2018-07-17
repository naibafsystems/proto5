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
    
    $('#btnContinuar').on('click', function () {
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'vivienda/finalizar',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('#msgSuccess').html('Finalizando la sección...');
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
            window.location.href = base_url + 'vivienda';
        });
    });
});

function recargar() {
    window.location.href = base_url + 'inicio';
}