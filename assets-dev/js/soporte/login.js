$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

    $('#frmIngreso').validate({
        rules: {
            usuario_soporte: {required: true},
            contrasena: {required: true}
        },
        messages: {
            usuario_soporte: {
                required: 'Digite su usuario.'
            },
            contrasena: {required: 'Digite su contrase\u00f1a.'}
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
            /*if (grecaptcha.getResponse() == '') {
                BootstrapDialog.alert({
                    title: 'Verificar reCAPTCHA',
                    message: 'Por favor verifica que no eres un robot',
                    closable: true,
                    buttonLabel: 'Aceptar'});
                $('#btnIngresar').removeClass('disabled');
                $('#btnIngresar').prop('disabled', false);
                return false;
            } else {
                return true;
            }*/
            if (typeof grecaptcha != "undefined"){
                if (grecaptcha.getResponse() == '') {
                    $(':button').removeClass('disabled').prop('disabled', false);
                    $('#btnIngresar').button('');
                    return false;
                 }
             }
            return true;
        }
    });

    $.fn.ingresar = function () {
        if ($('#frmIngreso').valid() == true) {
            if (typeof grecaptcha != "undefined"){
                if (grecaptcha.getResponse() == '') {
                    BootstrapDialog.alert({
                        title: 'Verificar reCAPTCHA',
                        message: 'Por favor verifica que no eres un robot',
                        closable: true,
                        buttonLabel: 'Aceptar'});
                } else {
                    var md5 = $.md5($("#contrasena").val());
                    $("#contrasena").val(md5);
                    $(':button').addClass('disabled').prop('disabled', true);
                    $('#btnIngresar').button('loading');
                    $('#frmIngreso').submit();
                }
            } /*else{
                var md5 = $.md5($("#contrasena").val());
                $("#contrasena").val(md5);
                $(':button').addClass('disabled').prop('disabled', true);
                $('#btnIngresar').button('loading');
                $('#frmIngreso').submit();
            }*/
        }
        return false;
    };

    $('#frmIngreso').keypress(function(event) {
        if(event.which == 13) {
            $(this).ingresar();
        }
    });

    $('#btnIngresar').on('click', function() {
        $(this).ingresar();
    });
});

var onloadCallback = function() {
    grecaptcha.render('html_element', {
      'sitekey' : '6LeiWxcUAAAAAGtuMc8JuqFnyn7R3L4C4zWj4Eho',
     'callback' : correctCaptcha
    });
};

var correctCaptcha = function(response) {
};