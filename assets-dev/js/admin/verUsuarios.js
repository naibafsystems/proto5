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
        'ordering': false,
        'responsive': true,
        'searching': false,
        'info': false
    });

    $.fn.buscarUsuarios = function () {
        var param = '';
        var frm = generarURLserialize('formUsuario');
        for (var i = 0; i < frm.length; i++) {
            if (isNaN(frm[i]) && frm[i].indexOf('%2F') > 0) {
                frm[i] = formatearFecha(frm[i]);
            }
        }
        $('#btnBuscar').button('loading');
        tablaUsuarios.ajax.url(base_url + 'usuarios/ver/A/' + frm.join('/')).load();
    };

    $.fn.activarUsuario = function (opc, idUsua) {
        var title = 'Inactivar usuario';
        var msgPreg = '¿Está seguro que desea inactivar el usuario?';
        var titleError = 'Error al inactivar el usuario';
        if (opc == 'ac') {
            title = 'Activar usuario';
            msgPreg = '¿Está seguro que desea activar el usuario?';
            titleError = 'Error al activar el usuario';
        }
        BootstrapDialog.show({
            title: title,
            message: msgPreg,
            type: BootstrapDialog.TYPE_WARNING,
            closable: false,
            buttons: [{
                label: 'Cancelar',
                cssClass: 'btn-warning',
                action: function(dialogRef){
                    dialogRef.close();
                }
            }, {
                label: 'Aceptar',
                cssClass: 'btn-success',
                action: function(dialogRef){
                    $.ajax({
                        url: base_url + 'usuarios/activar',
                        type: 'POST',
                        dataType: 'json',
                        data: {'opc': opc, 'idUsua': idUsua}
                    })
                    .done(function(data) {
                        if(data.codiError == 0) {
                            tablaUsuarios.ajax.reload();
                            dialogRef.close();
                        } else {
                            dialogo.setTitle(titleError);
                            dialogo.setType(BootstrapDialog.TYPE_DANGER);
                            dialogo.setMessage(data.mensaje);
                            dialogo.open();
                        }
                    })
                    .fail(function(jqXHR) {
                        dialogo.setTitle(titleError);
                        dialogo.setType(BootstrapDialog.TYPE_DANGER);
                        dialogo.setMessage(jqXHR.responseText);
                        dialogo.open();
                    });
                }
            }]
        });
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
            if(data.codiError === 0) {
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
            if(data.codiError === 0) {
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

    $('#tablaUsuarios').on('click', '.activarUsuario', function() {
        var $item = $(this);
        $(this).activarUsuario('ac', $item.data('usua'));
    });

    $('#tablaUsuarios').on('click', '.inactivarUsuario', function() {
        var $item = $(this);
        $(this).activarUsuario('in', $item.data('usua'));
    });

    $('#tablaUsuarios').on( 'draw.dt', function () {
        $('#btnBuscar').button('reset');
    });
});