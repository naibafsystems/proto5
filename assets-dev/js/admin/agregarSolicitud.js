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

    $('#respuesta').verificaEspacios();
    $('#observacion').verificaEspacios();

    $('#formSolicitud').validate({
        errorClass: 'error-form',
        rules: {
            tipoSolicitud: {selectVacio: true},
            respuesta: {required: true}
        },
        messages: {
            tipoSolicitud: { selectVacio: 'Seleccione el tipo de solicitud.' },
            respuesta: { required: 'Digite la respuesta de la solicitud.' },
        },
        onfocusout: function (element) {
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
        },
        errorPlacement: function (error, element) {
            element.after(error.attr('role','alert'));
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parent().addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parent().removeClass('has-error');
        },
        submitHandler: function (form) {
            return true;
        }
    });

    $('#btnAgregar').click(function () {
        //$('#msgSuccess').html('');
        if ($('#formSolicitud').valid() === true) {
            var frm = $('#formSolicitud').serialize();
            $(':input').addClass('disabled').prop('disabled', true);
            $(':button').addClass('disabled').prop('disabled', true);
            $.ajax({
                url: base_url + 'admin/guardarSolicitud',
                type: 'POST',
                dataType: 'json',
                data: frm
            })
            .done(function(data) {
                if(data.codiError === 0) {
                    $('#msgSuccess').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgSuccess').removeClass('hidden');
                    setTimeout(recargar, 2000);
                } else {
                    $('#msgError').html(data.mensaje);
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
        }
    });
});

function recargar() {
    window.location.href = base_url + 'admin/inicio';
}