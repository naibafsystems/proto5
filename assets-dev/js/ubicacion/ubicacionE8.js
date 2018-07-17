$(function () {
    var $direccion = {
        'bis_via': '',
        'bis_via2': ''
    };
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

    $('#letra_via').soloNombre().maxlength(3);
    $('#letra_sufijo').soloNombre().maxlength(3);
    $('#letra_via2').soloNombre().maxlength(3);
    $('#letra_sufijo2').soloNombre().maxlength(3);
    $('#numero_placa').soloNumeros().maxlength(3);
    $('#direccion').prop('readOnly', true);
    $('input[type=checkbox]').on('click', function() {
        if ($(this).is(':checked')) {
            $direccion[$(this).attr('id')] = 'BIS';
        } else {
            $direccion[$(this).attr('id')] = '';
        }
    });

    $('#frmUbicacion').on('blur', 'input,select', function(event) {
        item = $(this);
        var dir = '';
        $direccion[item.attr('id')]=item.val();

        if ($direccion.tipo_via != undefined && $direccion.tipo_via.length > 0) {
            dir = dir + ' ' + $direccion.tipo_via;
        }
        if ($direccion.numero_via != undefined && $direccion.numero_via.length > 0) {
            dir = dir + ' ' + $direccion.numero_via;
        }
        if ($direccion.letra_via != undefined && $direccion.letra_via.length > 0) {
            dir = dir + ' ' + $direccion.letra_via;
        }
        if ($direccion.bis_via != undefined && $direccion.bis_via.length > 0) {
            dir = dir + ' ' + $direccion.bis_via;
        }
        if ($direccion.letra_sufijo != undefined && $direccion.letra_sufijo.length > 0) {
            dir = dir + ' ' + $direccion.letra_sufijo;
        }
        if ($direccion.cuadrante != undefined && $direccion.cuadrante.length > 0) {
            dir = dir + ' ' + $direccion.cuadrante;
        }
        if ($direccion.tipo_via2 != undefined && $direccion.tipo_via2.length > 0) {
            dir = dir + ' ' + $direccion.tipo_via2;
        }
        if ($direccion.numero_via2 != undefined && $direccion.numero_via2.length > 0) {
            dir = dir + ' ' + $direccion.numero_via2;
        }
        if ($direccion.letra_via2 != undefined && $direccion.letra_via2.length > 0) {
            dir = dir + ' ' + $direccion.letra_via2;
        }
        if ($direccion.bis_via2 != undefined && $direccion.bis_via2.length > 0) {
            dir = dir + ' ' + $direccion.bis_via;
        }
        if ($direccion.letra_sufijo2 != undefined && $direccion.letra_sufijo2.length > 0) {
            dir = dir + ' ' + $direccion.letra_sufijo2;
        }
        if ($direccion.numero_placa != undefined && $direccion.numero_placa.length > 0) {
            dir = dir + ' ' + $direccion.numero_placa;
        }
        if ($direccion.cuadrante2 != undefined && $direccion.cuadrante2.length > 0) {
            dir = dir + ' ' + $direccion.cuadrante2;
        }
        if ($direccion.complemento != undefined && $direccion.complemento.length > 0) {
            dir = dir + ' ' + $direccion.complemento;
        }
        if ($direccion.texto_complemento != undefined && $direccion.texto_complemento.length > 0) {
            dir = dir + ' ' + $direccion.texto_complemento;
        }

        $('#direccion').val($.trim(dir));
    });

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            tipo_via: {selectVacio: true},
            numero_via: {required: true},
            tipo_via2: {selectVacio: true},
            numero_via2: {required: true},
            numero_placa: {required: true}
        },
        messages: {
            tipo_via: { selectVacio: 'ERROR: El tipo de vía no puede estar vacio.' },
            numero_via: { required: 'ERROR: Digite el número de vía.' },
            tipo_via2: { selectVacio: 'ERROR: El tipo de vía generadora no puede estar vacio.' },
            numero_via2: { required: 'ERROR: Digite el número de vía generadora.' },
            numero_placa: { required: 'ERROR: Digite el número de placa.' }
        },
        /*acc*/
        onfocusout: function (element) {
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
        },
        errorPlacement: function (error, element) {
            var item = $('<li></li>');
            item.append(error);
            $('#direccion-error').append(item);
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
        //data: frm + '&duracion=' + duracionPagina() + '&jdire=' + JSON.stringify($direccion)
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
                    $('#msgSuccess').html('Guardando las respuestas...');
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
                    //setTimeout(recargar, 2000);
                    recargar();
                } else {
                    $('#msgError').html(data.mensaje);
                    $('#divMsg').removeClass('hidden');
                    $('#divMsgAlert').removeClass('hidden');
                }
            })
            .fail(function(jqXHR) {
                window.location.href = base_url + 'ubicacion';
            });
        }
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'ubicacion/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                window.location.href = base_url + 'ubicacion';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'ubicacion';
        });
    });
});


function recargar() {
    window.location.href = base_url + 'ubicacion';
}