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

    $('#formulario').maxlength(15).verificaEspacios();
    $('#nombre1Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#nombre2Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#apellido1Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#apellido2Pers').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();

    var tablaUsuarios = $('#tablaUsuarios').DataTable({
        'processing': true,
        'columns': [
            { 'data': 'usuario' },
            { 'data': 'nume_docu' },
            { 'data': 'nombre' },
            { 'data': 'estado' },
            { 'data': 'estado_form' },
            { 'data': 'opciones' }
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

    $.fn.buscarUsuarios = function () {
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
        if(content < 9){
            $('#btnBuscar').button('loading');
            tablaUsuarios.ajax.url(base_url + 'usuarios/ver/S/' + frm.join('/')).load();
        }
    };

    $('#formUsuario').on('submit', function(event) {
        event.preventDefault();
        $(this).buscarUsuarios();
    });

    $('#btnBuscar').on('click', function() {
        $(this).buscarUsuarios();
    });

    $('#tablaUsuarios').on('click', '.verUsuario', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'usuarios/validarUsuario',
            type: 'POST',
            dataType: 'json',
            data: { 'id':$item.data('usua'),'opc':'verUsuario' }
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

    $('#tablaUsuarios').on('click', '.editarUsuario', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'usuarios/validarUsuario',
            type: 'POST',
            dataType: 'json',
            data: { 'id':$item.data('usua'),'opc':'editarUsuario' }
        })
        .done(function(data) {
            if(data.codiError == 0) {
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

    $('#tablaUsuarios').on('click', '.editarCorreo', function() {
        $(this).parents('form').find('input,select').not('[type=hidden]').val('');
        var $item = $(this);
        $.ajax({
            url: base_url + 'usuarios/validarUsuario',
            type: 'POST',
            dataType: 'json',
            data: { 'id':$item.data('usua'),'opc':'editarCorreo' }
        })
        .done(function(data) {
            if(data.codiError == 0) {
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

    $('#tablaUsuarios').on('click', '.verEntrevistas', function() {
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
                        'searching': false,
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

    $('#tablaUsuarios').on( 'draw.dt', function () {
        $('#btnBuscar').button('reset');
    });
});