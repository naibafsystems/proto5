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

    $('#formUsuario').validate({
        rules: {
            txtDescripcion: {required: true},
        },
        messages: {
            txtDescripcion: {
                required: 'Error: Debe ingresar las observaciones del cambio de estado.'
            }
        },
        focusCleanup: true,
        /*acc*/
        onfocusout: function (element) {
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
        },
        errorPlacement: function (error, element) {
            element.after(error.attr('role','alert'));
            element.after(error.addClass('errorForm'));
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

    $('#btnGuardarUsuario').on('click', function() {
        var encuesta = $('#hddEncuesta').val();
        var descripcion = $('#txtDescripcion').val();
        if ($('#formUsuario').valid() == true) {
            var frm = $('#formUsuario').serialize();
            $.ajax({
                url: base_url + 'usuarios/guardarUsuario',
                type: 'POST',
                dataType: 'json',
                data: 'encuesta=' + encuesta + '&descripcion=' + descripcion
            })
            .done(function(data) {
                if(data.codiError == 0) {
                    $('#msgSuccess').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgSuccess').removeClass('hidden');
                    setTimeout(recargar, 2000);
                } else {
                    dialogo.setTitle('Error al guardar el usuario');
                    dialogo.setType(BootstrapDialog.TYPE_DANGER);
                    dialogo.setMessage(data.mensaje);
                    dialogo.open();
                }
            })
            .fail(function(jqXHR) {
                dialogo.setTitle('Error al guardar el usuario');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(jqXHR.responseText);
                dialogo.open();
            });
        }
    });
});

function recargar() {
    window.location.href = base_url + 'soporte/verUsuarios';
}