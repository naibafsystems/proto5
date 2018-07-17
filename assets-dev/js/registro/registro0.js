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

    var registerExplanationHeight= $('#register-explanation-container').height();
    $('.register-explanation-divider').css('height',registerExplanationHeight);

    $('.progress').addClass('hidden');

    if($('#has-doubts-title').length!=0) {
        $('#main_container').css('width','80%');
    }

    $('#btnEmpezar').on('click', function () {
        $('.alert').addClass('hidden');
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'registro/empezar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                setTimeout(recargar, 1000);
            } else {
                $('#msgSuccess').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            dialogo.setTitle('Error al guardar');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
        });
    });

    $('#btnTerminos').on('click', function () {
        $(location).attr('href', base_url + 'encuesta/terminosCondiciones');
    });
});

function recargar() {
    window.location.href = base_url + 'registro';
}