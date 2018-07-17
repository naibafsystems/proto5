$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

    $('#frmReminder').validate({
        errorClass: 'error-form',
        rules: {
            usuario: {required: true, emailValido: true}
        },
        messages: {
            usuario: {
                required: 'Digita tu correo electr\u00f3nico.',
                emailValido: 'No es una direcci\u00f3n de correo electr\u00f3nico v\u00e1lida'
            }
        },
        errorPlacement: function (error, element) {
            element.after(error.attr('role', 'alert'));
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parent().addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parent().removeClass('has-error');
        },
         submitHandler: function (form) {
            if (typeof grecaptcha != "undefined"){
                if (grecaptcha.getResponse() == '') {
                    return false;
                }
            }
            return true;
        }
    });
      
    $('#btnReminder').click(function () {

        if ($("#frmReminder").valid()) {
             if (typeof grecaptcha != "undefined"){
                 if (grecaptcha.getResponse() == '') {
                    BootstrapDialog.alert({
                        title: 'Verificar reCAPTCHA',
                        message: 'Por favor verifica que no eres un robot',
                        closable: true,
                        buttonLabel: 'Aceptar'});
                } else {
                    $('.glyphicon-refresh-animate').removeClass('hide');
                    $('.glyphicon-save').addClass('hide');
                    $(this).addClass('disabled');
                    $(this).prop('disabled', true);
                    $("#frmReminder").submit();
                    //setTimeout(recargar, 3000);
                }
            }else{
                $('.glyphicon-refresh-animate').removeClass('hide');
                $('.glyphicon-save').addClass('hide');
                $(this).addClass('disabled');
                $(this).prop('disabled', true);
                $("#frmReminder").submit();
                //setTimeout(recargar, 3000);
            }
        }
        return false;
    });

    $('#btnRegresar').click(function () {
        window.location.href = base_url + 'login';
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

function recargar() {
    window.location.href = base_url + 'login';
}