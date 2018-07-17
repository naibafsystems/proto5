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

    var codigoEncuesta = $('#codigo_encuesta').data('encuesta');

    var tabla_personas = $('#tabla_personas').DataTable({
        'processing': true,
        'ajax': base_url + 'personas/consultarGrillaEncuesta/' + codigoEncuesta,
        'columns': [
            { 'data': 'tipo_docu' },
            { 'data': 'nume_docu' },
            { 'data': 'nombre' },
            { 'data': 'jefe' },
            { 'data': 'sexo' },
            { 'data': 'edad' },
            { 'data': 'pagina' }
        ],
        'language': {
            'url': base_url + 'assets/plugins/DataTables/datatables.locale-es.json'
        },
        'paging': false,
        'pageLength': 50,
        'bFilter': true,
        'ordering': true,
        'responsive': true,
        'searching': false,
        'info': false
    });

    $('.verPreguntas').on('click', function() {
        $.ajax({
            url: base_url + 'encuesta/verPreguntasPagina',
            type: 'POST',
            dataType: 'json',
            data: { 'modulo':$(this).data('modulo'),'pagina':$(this).data('pagina') }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                dialogo.setTitle(data.title);
                dialogo.setType(BootstrapDialog.TYPE_INFO);
                dialogo.setSize(BootstrapDialog.SIZE_WIDE);
                dialogo.setMessage($(data.view));
                dialogo.open();
            } else {
                dialogo.setTitle('Error al consultar el proceso');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(data.mensaje);
                dialogo.open();
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'hogar';
        });
    });

    $('#tabla_personas').on('click', '.verPreguntas', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'encuesta/verPreguntasPagina',
            type: 'POST',
            dataType: 'json',
            data: { 'modulo':'4','pagina':$item.data('pagina') }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                dialogo.setTitle(data.title);
                dialogo.setType(BootstrapDialog.TYPE_INFO);
                dialogo.setSize(BootstrapDialog.SIZE_WIDE);
                dialogo.setMessage($(data.view));
                dialogo.open();
            } else {
                dialogo.setTitle('Error al consultar el proceso');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(data.mensaje);
                dialogo.open();
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'hogar';
        });
    });

    $('#btnRegresar').on('click', function() {
        $(':button').addClass('disabled').prop('disabled', true);
        window.location.href = base_url + 'soporte/verPersonas';
    });
});