$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

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

    $('[data-tooltip!=""]').qtip({
        content: { attr: 'data-tooltip' },
        position: { my: 'top left' },
        style: { classes: 'qtip-bootstrap qtip-DANE' }
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('#ayudaBarrio').hint('Barrio, corregimiento o vereda', 'Espacio geográfico en que se divide el área urbana, y donde se ubican un conjunto de manzanas.');
    $('#departamento').cargarCombo('departamento', 'municipio', base_url + 'formulario/listaDesplegable');

    $('#departamento').change(function() {
        $('option', '#municipio').remove();
    });

    $('#municipio').select2({
        allowClear: true,
        //containerCssClass: 'select2-container', // No funciona
        //dropdownCssClass: 'select2-container', // No funciona
        language: 'es',
        //minimumInputLength: 2,
        placeholder: 'Municipio o área no municipalizada',
        theme: 'bootstrap',
        width: '100%'
    });

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            departamento: {selectVacio: true},
            municipio: {selectVacio: true}
        },
        messages: {
            departamento: { selectVacio: 'ERROR: Es obligatorio diligenciar el Departamento en el que reside habitualmente.' },
            municipio: { selectVacio: 'ERROR: Es obligatorio diligenciar el Municipio en el que reside habitualmente.' }
        },
        /*acc*/
        onfocusout: function (element) {
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').first().append(error.attr('role', 'alert'));
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').first().addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').first().removeClass('has-error');
        },
        submitHandler: function (form) {
            return true;
        }
    });

    $('#btnSiguiente').on('click', function() {
        if( $("#municipio").val() == null){
            recargar();
        }else{
            $('.alert').addClass('hidden');
            if ($('#frmUbicacion').valid() == true) {
                var frm = $('#frmUbicacion').serialize();
                $(':input').addClass('disabled').prop('disabled', true);
                $(':button').addClass('disabled').prop('disabled', true);
                $.ajax({
                    url: base_url + 'ubicacion/guardar',
                    type: 'POST',
                    dataType: 'json',
                    data: frm + '&duracion=' + duracionPagina(),
                    beforeSend: function () {
                        $('#msgSuccess').html('Guardando la(s) respuesta(s). Espere por favor...');
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
                        //$('#animationload').fadeIn();
                        //setTimeout(recargar, 2000);
                        recargar();
                    } else {
                        $('#msgError').html(data.mensaje);
                        $('#divMsg').removeClass('hidden');
                        $('#divMsgAlert').removeClass('hidden');
                        //setTimeout(recargar, 5000);
                        recargar();
                    }
                })
                .fail(function(jqXHR) {
                    window.location.href = base_url + 'ubicacion';
                });
            }
        }
    });
});

function recargar() {
    window.location.href = base_url + 'ubicacion';
}