$(function () {
    var $complementos = {};
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

    var agregarComplemento = function () {
        var name = '';
        var pc = $('#plantilla_complemento').clone();
        var cn = $('#agregar_comple').children().length;
        pc.attr('id', 'divComple'+cn);
        $complementos['divComple'+cn]={};
        pc.find('input, select').each(function(index, el) {
            name = $(el).attr('name');
            //$(el).attr('id',  name+cn);
            $(el).attr('name',  name+cn);
            //$complementos['divComple'+cn][name]='';
        });
        $('#agregar_comple').append(pc.removeClass('hidden'));
    };

    $('.adicion').soloNombre().maxlength(30).verificaEspacios();

    $('input[type=radio][name=tiene_comple_direccion]').on('change', function() {
        if($(this).val() == 1) {
            agregarComplemento();
        } else if($(this).val() == 2) {
            $('#agregar_comple').html('');
        }
    });

    $('#agregar_comple').on('change', '.otro_comple', function(event) {
        if($(this).val() == 1) {
            agregarComplemento();
        }
    });

    $('#agregar_comple').on('blur', 'input[type=text],select', function(event) {
        item = $(this);
        var div = '';
        var comple = '';
        if(item.attr('class').search('adicionarComple')) {
            div = item.parent().parent().parent().parent().attr('id');
            $complementos[div][item.data('field')]=item.val();
        }
        $.each($complementos, function(key, value) {
            $.each(value, function(key, value) {
                comple = comple + ' ' + value;
            });
        });
        $('#complemento_ingresado').val($.trim(comple));
    });

    $('#frmUbicacion').validate({
        errorClass: 'error-form',
        rules: {
            tiene_comple_direccion: {required: true}
        },
        messages: {
            tiene_comple_direccion: {required: 'ERROR: Seleccione si la dirección tiene o no complemto.' }
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
        //data: frm + '&duracion=' + duracionPagina() + '&jdire=' + JSON.stringify($direccion)
        if ($('#frmUbicacion').valid() == true) {
            // Validar si todos los select y input esta llenos
            var validator = $('#frmUbicacion').validate();
            var msgError = '';
            $('#agregar_comple').find('.adicionarComple').each(function(index) {
                if($(this).attr('name') == 'complemento' && $(this).val().length == 0) {
                    msgError += '<li>Seleccione todos los tipos de complemento.</li>';
                }
                if($(this).attr('name') == 'adicion' && $(this).val().length == 0) {
                    msgError += '<li>Digite todos los complementos.</li>';
                }
            });
            $('#agregar_comple').find('.otro_comple').each(function(index) {
                var nameRadio = $(this).attr('name');
                if(!$('input[type=radio][name='+nameRadio+']').is(':checked')) {
                    msgError += '<li>Seleccione si quiere agregar otro complemento.</li>';
                }
            });
            if(msgError.length > 0) {
                msgError = '<ul>' + msgError + '</ul>';
                validator.showErrors({'tiene_comple_direccion': msgError});
                return false;
            }

            var frm = $('#frmUbicacion').serialize();
            //$(':input').addClass('disabled').prop('disabled', true);
            //$(':button').addClass('disabled').prop('disabled', true);
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