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

    // $.validator.addMethod('validarPass', function (value, element, params) {
    //     //validate the length
    //     //var regex = /^(?=^.{8,20}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
    //     var regex = /^(?=^.{8,20}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[a-z]).*$/;
    //     if (value.match(regex)) {
    //         return true;
    //     }
    //     return false;
    // });

    $('#contrasena1').keypress(function(tecla) {
        if(tecla.charCode == 32 ) return false;
    });

    $('#contrasena2').keypress(function(tecla) {
        if(tecla.charCode == 32 ) return false;
    });

    $('#frmChange').validate({
        errorClass: 'error-form',
        rules: {
            contrasena1: {required: true, minlength: 8, maxlength: 20, validarPass: true},
            contrasena2: {required: true, minlength: 8, maxlength: 20, validarPass: true, equalTo: '#contrasena1'}
        },
        messages: {
            contrasena1: {
                required: 'ERROR: Digite una contraseña válida.',
                minlength: 'ERROR: La contraseña debe ser mínimo de {0} caracteres.',
                maxlength: 'ERROR: La contraseña debe ser máximo de {0} caracteres.',
                validarPass: 'ERROR: La contraseña debe contener al menos: una letra mayúscula, una letra minúscula, un número o carácter especial. con mínimo ocho (8) caracteres.'
            },
            contrasena2: {
                required: 'ERROR: Digite una contraseña válida.',
                minlength: 'ERROR: La contraseña debe ser mínimo de {0} caracteres.',
                maxlength: 'ERROR: La contraseña debe ser máximo de {0} caracteres.',
                validarPass: 'ERROR: La contraseña debe contener al menos: una letra mayúscula, una letra minúscula, un número o carácter especial. con mínimo ocho (8) caracteres.',
                equalTo: 'ERROR: Las contraseñas no coinciden.'
            }
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
        $('.alert').addClass('hidden');
        if ($('#frmChange').valid() == true) {
            var md5 = $.md5($("#contrasena1").val());
            $("#contrasena1").val(md5);
            $("#contrasena2").val(md5);
            var frm = $('#frmChange').serialize();
            $(':input').addClass('disabled').prop('disabled', true);
            $(':button').addClass('disabled').prop('disabled', true);
            $.ajax({
                url: base_url + 'login/actualizarContrasena',
                type: 'POST',
                dataType: 'json',
                data: frm,
                beforeSend: function () {
                    $('#msgSuccess').html('Guardando la información...');
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgSuccess').removeClass('hidden');
                }
            })
            .done(function(data) {
                if(data.codiError == 0) {
                    $('#msgSuccess').html(data.mensaje);
                    $('#divMsgSuccess').removeClass('hidden');
                    setTimeout(recargar, 3000);
                } else {
                    $('#msgError').html(data.mensaje);
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
    window.location.href = base_url + 'login';
}