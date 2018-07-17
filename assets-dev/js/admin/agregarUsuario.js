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

    $('#formUsuario').validate({
        errorClass: 'error-form',
        rules: {
            nombre1Pers: {required: true},
            apellido1Pers: {required: true},
            usuario: {required: true, emailValido2: true},
            tipo: {selectVacio: true},
            contrasena1: {required: true, maxlength: 20, minlength: 8, validarPass: true},
            contrasena2: {required: true, maxlength: 20, minlength: 8, validarPass: true, equalTo: '#contrasena1'}
        },
        messages: {
            nombre1Pers: { required: 'Digite el primer nombre del usuario.' },
            apellido1Pers: { required: 'Digite el primer apellido del usuario.' },
            usuario: {
                required: 'Digite un correo electrónico válido.',
                // emailValido2: 'No es una dirección de correo electrónico válida.',
                validarEmail: 'El correo electrónico ya esta registrado en el sistema'
            },
            tipo: { selectVacio: 'Seleccione el tipo de usuario.' },
            contrasena1: {
                required: 'Digite una contraseña válida.',
                maxlength: 'La contraseña debe ser máximo de {0} caracteres.',
                minlength: 'La contraseña debe ser mínimo de {0} caracteres.',
                // validarPass: 'La contraseña debe combinar letras y números, con mínimo ocho (8) caracteres y mínimo una mayúscula.'
            },
            contrasena2: {
                required: 'Digite una contraseña válida.',
                maxlength: 'La contraseña debe ser máximo de {0} caracteres.',
                minlength: 'La contraseña debe ser mínimo de {0} caracteres.',
                // validarPass: 'La contraseña debe combinar letras y números, con mínimo ocho (8) caracteres y mínimo una mayúscula.',
                equalTo: 'La segunda contraseña debe ser igual a la primera contraseña.'
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
        if ($('#formUsuario').valid() === true) {
            var frm = $('#formUsuario').serialize();
            //$(':input').addClass('disabled').prop('disabled', true);
            //$(':button').addClass('disabled').prop('disabled', true);
            $.ajax({
                url: base_url + 'usuarios/agregar',
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