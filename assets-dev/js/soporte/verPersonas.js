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

    $('#formulario').soloNumeros().maxlength(15).verificaEspacios();
    $('#nombre1Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#nombre2Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#apellido1Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#apellido2Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();

    var tabla_personas = $('#tabla_personas').DataTable({
        'processing': true,
        'columns': [
            { 'data': 'tipo_docu' },
            { 'data': 'nume_docu' },
            { 'data': 'nombre' },
            { 'data': 'jefe' },
            { 'data': 'sexo' },
            { 'data': 'edad' },
            { 'data': 'opciones' }
        ],
        'language': {
            'url': base_url + 'assets/plugins/DataTables/datatables.locale-es.json'
        },
        'paging': true,
        'pageLength': 50,
        'bFilter': true,
        'ordering': true,
        'responsive': true,
        'searching': false,
        'info': false
    });

    $.fn.buscarPersonas = function () {
        var param = '';
        var content = 0;
        var frm = generarURLserialize('formUsuario');
        for (var i = 0; i < frm.length; i++) {
            if (isNaN(frm[i]) && frm[i].indexOf('%2F') > 0) {
                frm[i] = formatearFecha(frm[i]);
            }

            if(frm[i] == '-'){
                content++;
            }
        }
        if(content < 7){
            $('#btnBuscar').button('loading');
            tabla_personas.ajax.url(base_url + 'personas/consultarGrillaSoporte/' + frm.join('/')).load();
        }
    };

    $('#formUsuario').on('submit', function(event) {
        event.preventDefault();
        $(this).buscarPersonas();
    });

    $('#btnBuscar').on('click', function() {
        $(this).buscarPersonas();
    });

    $('#tabla_personas').on('click', '.verHogar', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'hogar/validarHogar',
            type: 'POST',
            dataType: 'json',
            data: { 'encuesta':$item.data('encuesta'),'opc':'verHogar' }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                //window.open(data.url);
                window.location.href = data.url;
            } else {
                dialogo.setTitle('Error al consultar el proceso');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(data.mensaje);
                dialogo.open();
            }
        })
        .fail(function(jqXHR) {
            dialogo.setTitle('Error al consultar el proceso');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
        });
    });

    $('#tabla_personas').on( 'draw.dt', function () {
        $('#btnBuscar').button('reset');
    });

    $('#tabla_personas').on('click', '.verEntrevistas', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'encuesta/verResultadoEntrevistas',
            type: 'POST',
            dataType: 'json',
            // async : false,
            data: { 'encuesta':$item.data('encuesta') }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                dialogo.setTitle(data.title);
                dialogo.setType(BootstrapDialog.TYPE_INFO);
                dialogo.setSize(BootstrapDialog.SIZE_WIDE);
                dialogo.setMessage($(data.view));
                dialogo.onShown(function(){
                    $('.tabla_entrevistas').DataTable({
                        'paging': 20,
                        'info': false,
                        'search': false,
                        language: {'url': base_url + 'assets/plugins/DataTables/datatables.locale-es.json'}
                    });
                });
            } else {
                dialogo.setTitle('Error al consultar las entrevistas');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(data.mensaje);
            }
            dialogo.open();
        })
        .fail(function(jqXHR) {
            dialogo.setTitle('Error al consultar las entrevistas');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
        });
    });

    $('#tabla_personas').on( 'draw.dt', function () {
        $('#btnBuscar').button('reset');
    });
});