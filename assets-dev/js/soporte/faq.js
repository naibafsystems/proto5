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

    var tablaSolicitudes = $('#tablaSolicitudes').DataTable({
        'processing': true,
        'ajax': base_url + 'soporte/verSolicitudes/S',
        'columns': [
            { 'data': 'tipo' },
            { 'data': 'respuesta' },
            { 'data': 'observacion' }
        ],
        'language': {
            'url': base_url + 'assets/plugins/DataTables/datatables.locale-es.json'
        },
        'paging': true,
        'pageLength': 50,
        'bFilter': true,
        'bInfo': false,
        'ordering': false,
        'responsive': true,
        'searching': false,
        'info': false
    });

    $.fn.buscarSolicitudes = function () {
        var param = '';
        var frm = generarURLserialize('formSolicitudes');
        for (var i = 0; i < frm.length; i++) {
            if (isNaN(frm[i]) && frm[i].indexOf('%2F') > 0) {
                frm[i] = formatearFecha(frm[i]);
            }
        }
        $('#btnBuscar').button('loading');
        tablaSolicitudes.ajax.url(base_url + 'soporte/verSolicitudes/S/' + frm.join('/')).load();
    };

    $('#formSolicitudes').on('submit', function(event) {
        event.preventDefault();
        $(this).buscarSolicitudes();
    });

    /*$('#btnBuscar').on('click', function() {
        $(this).buscarSolicitudes();
    });*/

    
    $('#tablaSolicitudes').on( 'draw.dt', function () {
        $('#btnBuscar').button('reset');
    });
});