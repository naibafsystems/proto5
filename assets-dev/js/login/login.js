$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

    // Se cambia el logo aleatoriamente
    $('#divLogin').css('background-image', 'url(' + base_url + 'assets/images/login-img' + Math.floor(Math.random() * 3) + '.jpg)');

    $('#frmIngreso').validate({
        rules: {
            usuario: {required: true},
            contrasena: {required: true},
            csrf_token: {required:false}
        },
        messages: {
            usuario: {
                required: 'ERROR: El usuario es obligatorio'
            },
            contrasena: {required: 'ERROR: contrase\u00f1a es obligatoria.'}
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
                $(':button').addClass('disabled').prop('disabled', false);
                $('#btnIngresar').button('loading');
                return false;
            } else {
                return true;
            }*/
            if (typeof grecaptcha == "undefined"){
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
            if (typeof grecaptcha == "undefined"){
                 if (grecaptcha.getResponse() == '') {
                    BootstrapDialog.alert({
                        title: 'Verificar reCAPTCHA',
                        message: 'Por favor verifica que no eres un robot',
                        closable: true,
                        buttonLabel: 'Aceptar'});
                    return false;
                } else {
                    var md5 = $.md5($("#contrasena").val());
                    $("#contrasena").val(md5);
                    $(':button').addClass('disabled').prop('disabled', true);
                    $('#btnIngresar').button('loading');
                    $('#frmIngreso').submit();
                }
            }else{
                var md5 = $.md5($("#contrasena").val());
                $("#contrasena").val(md5);
                $(':button').addClass('disabled').prop('disabled', true);
                $('#btnIngresar').button('loading');
                $('#frmIngreso').submit();
            }
        }

        $(':button').removeClass('disabled').prop('disabled', false);
        $('#btnIngresar').button('');

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

    $('#btnRegistrar').on('click', function() {
        $(location).attr('href', base_url + 'registro');
    });

    $('#btnConocer').on('click', function() {
        $(location).attr('href', base_url + 'encuesta/conocerCenso');
    });

    $('#btnLey').on('click', function() {
        $(location).attr('href', base_url + 'encuesta/conocerLey');
    });

    $('#btnTC').on('click', function() {
        $(location).attr('href', base_url + 'encuesta/terminosCondiciones');
    });

    $('#btnRecordar').on('click', function() {
        $(location).attr('href', base_url + 'login/recuperarContrasena');
    });

    //acc
    $('#acc_title').focus();
    $('#divMsgAlert').focus();


    $('#usuario').keyup(function(){
       checkFilledData();
    });

    $('#contrasena').keyup(function(){
        checkFilledData();
    });

    function checkFilledData() {
        if($('#usuario').val() != '' && $('#contrasena').val()!=''){
            $('#btnIngresar').css('background-color','#B6004C');
            $('#btnIngresar').css('color','white');
        }else{
            $('#btnIngresar').css('background-color','#CCCCCC');
            $('#btnIngresar').css('color','#333');
        }
    }
});

var onloadCallback = function() {
    grecaptcha.render('html_element', {
      'sitekey' : '6LeiWxcUAAAAAGtuMc8JuqFnyn7R3L4C4zWj4Eho',
     'callback' : correctCaptcha
    });
};

var correctCaptcha = function(response) {
};