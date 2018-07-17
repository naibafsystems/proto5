$(document).ready(function() {
    // $('table').DataTable();

    var dAlert = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje de prueba',
        onhidden: function(dgRef){
            $(this).loadEncuestas();
            // window.location.reload(true);
        }
    });

    var tabla_encuestas = $('#tbEncuestas').DataTable({
        'processing': true,
        "ajax": {
            "url": base_url + 'soporte/digitacion/getEncuestas',
            "dataSrc": "data"
        },
        'columns': [
            { 'data': 'encuesta' },
            { 'data': 'formulario' },
            { 'data': 'estado' },
            { 'data': 'ubicacion' },
            { 'data': 'vivienda' },
            { 'data': 'hogar' },
            { 'data': 'personas' },
            { 'data': 'diligenciar' }
        ],
        'language': {
            'url': base_url + 'assets/plugins/DataTables/datatables.locale-es.json'
        },
        'paging': true,
        'pageLength': 10,
        'bFilter': true,
        'ordering': true,
        'responsive': true,
        'searching': false,
        'info': false
    });

    // $.post(base_url + 'soporte/digitacion/getEncuestas').done(function(data, textStatus, xhr) {
    //     console.log(data);
    // }).fail(function(jqXHR) {
    //     console.log(jqXHR.responseText);
    // })
    // ;

    $.fn.loadEncuestas = function () {
        // $('#btnBuscar').button('loading');
        tabla_encuestas.ajax.url(base_url + 'soporte/digitacion/getEncuestas').load();
    };

    $("#addEncuesta").on('click', function(event) {
        // event.preventDefault();
        // dAlert.open();
        //
        $.ajax({
            url: base_url + 'soporte/digitacion/addEncuesta',
            type: 'POST',
            dataType: 'json',
            data: {numForm: $("#textNumformulario").val()},
        })
        .done(function(data) {
            console.log(data);
            if (data.error){
                // dAlert.setType(BootstrapDialog.TYPE_SUCCESS);
                dAlert.setTitle('Creaci&oacute;n Exitosa');
                dAlert.setType(BootstrapDialog.TYPE_SUCCESS);
                dAlert.setMessage(data.message);
                // console.log(data.message);
                // console.log(data.data);
                abrirEncuesta(data.encuesta);
            } else {
                dAlert.setTitle('Creación Fallida');
                dAlert.setType(BootstrapDialog.TYPE_SUCCESS);
                dAlert.setMessage(data.message);
            }
            dAlert.open();
        })
        .fail(function(jqXHR) {
            console.log(jqXHR.responseText);
        });
    });

    $('#encuestas').on('click', '.dg', function(event) {
        event.preventDefault();

        var encuesta = $(this).data('encuesta');

        abrirEncuesta(encuesta);
    });

    function abrirEncuesta(encuesta){

        $.post(base_url + 'inicio/setVariables', {encuesta: encuesta}).done(function(data) {
            if (data.error){
                window.location.href = base_url + 'soporte/digitacion';
            } else { 
                window.location.href = base_url + 'inicio ';
            }


        });
    }

});