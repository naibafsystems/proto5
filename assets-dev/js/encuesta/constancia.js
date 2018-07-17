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

    $('.scrollup').click(function() {
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });
    
    $('#btnDescargar').click(function () {
        //$(location).attr('href', base_url + 'encuesta/generarConstancia');
        window.open(base_url + 'encuesta/generarConstancia','Constancia','width=900,height=820,left=50,top=50,location=no,menubar=no,resizable=no,toolbar=no');
    });
});