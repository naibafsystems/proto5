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

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $.fn.initContadorTa = function (idtextarea, idcontador, max) {
        $("#"+idtextarea).keyup(function() {
            $(this).updateContadorTa(idtextarea, idcontador, max);
        });
        $("#"+idtextarea).change(function() {
            $(this).updateContadorTa(idtextarea, idcontador, max);
        });
    };

    $.fn.updateContadorTa = function (idtextarea, idcontador, max) {
        var contador = $("#"+idcontador);
        var ta = $("#"+idtextarea);
        contador.html("0/"+max);
        contador.html(ta.val().length+"/"+max);
        if(parseInt(ta.val().length)>max) {
            ta.val(ta.val().substring(0,max-1));
            contador.html(max+"/"+max);
        }
    };

    $('.progress').addClass('hidden');
    $('#observacion').initContadorTa('observacion','contadorTaComentario', 2000);
    
    $('input[name=razon]').click(function () {
        if($('input:radio[name=razon]:checked').val() == 5) {
            $('#observacion').prop('disabled', false).removeClass('disabled');
        } else {
            $('#observacion').prop('disabled', true).addClass('disabled').val('');
        }
    });
    
    $('#frmNoAcepto').validate({
        errorClass: 'error-form',
        rules: {
            razon: {required: true},
            observacion: {required: true}
        },
        messages: {
            razon: { required: 'Error: Seleccione la razón por la que no deseas participar.' },
            observacion: { required: 'Error: Digite la razón por la que no deseas participar.' }
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
    
    $('#btnNoAcepto').click(function () {
        if ($('#frmNoAcepto').valid() == true) {
            //$(':input').addClass('disabled').prop('disabled', true);
            //$(':button').addClass('disabled').prop('disabled', true);
            var frm = $('#frmNoAcepto').serialize();
            $.ajax({
                url: base_url + 'registro/guardarNoAcepto',
                type: 'POST',
                dataType: 'json',
                data: frm
            })
            .done(function(data) {
                if(data.codiError == 0) {
                    BootstrapDialog.show({
                        title: 'Guardar no acepto',
                        message: data.mensaje,
                        closable: false,
                        buttons: [{
                            label: 'Aceptar',
                            action: function(dialog) {
                                $(location).attr('href', base_url);
                            }
                        }]
                    });
                } else if(data.codiError == 1) {
                    BootstrapDialog.show({
                        title: 'Guardar no acepto',
                        message: data.mensaje,
                        closable: false,
                        buttons: [{
                            label: 'Aceptar',
                            action: function(dialog) {
                                $(location).attr('href', base_url + '/registro');
                            }
                        }]
                    });
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
    
    $('#btnRegresar').click(function () {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $(location).attr('href', base_url + 'registro');
    });
});