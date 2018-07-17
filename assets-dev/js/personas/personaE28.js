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

    $('[data-tooltip!=""]').qtip({
        content: { attr: 'data-tooltip' },
        position: { my: 'top right' },
        style: { classes: 'qtip-bootstrap qtip-DANE' },
        show: {
            event: 'load',
            ready: true
        },
        hide: function (event, api) {
            $(this).show();
        }
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    var totalHijos = function (idCampo, idCampo2) {
        var hombres = $('#' + idCampo).val();
        var mujeres = $('#' + idCampo2).val();

        if((parseInt(hombres) + parseInt(mujeres)) > 28) {
            return false;
        }
        return true;
    };

    $.validator.addMethod('validarTotalHijos', function (value, element, params) {
        return totalHijos(params[0], params[1]);
    });
    
    $('#cuantos_hombres_vivos').cargarCombo('cuantos_hombres_vivos', 'hoy_cuantos_hombres_vivos', base_url + 'formulario/listaDesplegable').cargarCombo('cuantos_hombres_vivos', 'fuera_cuantos_hombres', base_url + 'formulario/listaDesplegable');
    $('#cuantas_mujeres_vivas').cargarCombo('cuantas_mujeres_vivas', 'hoy_cuantas_mujeres_vivas', base_url + 'formulario/listaDesplegable').cargarCombo('cuantas_mujeres_vivas', 'fuera_cuantas_mujeres', base_url + 'formulario/listaDesplegable');
    $('#hoy_cuantos_hombres_vivos').cargarCombo('hoy_cuantos_hombres_vivos', 'fuera_cuantos_hombres', base_url + 'formulario/listaDesplegable');
    $('#hoy_cuantas_mujeres_vivas').cargarCombo('hoy_cuantas_mujeres_vivas', 'fuera_cuantas_mujeres', base_url + 'formulario/listaDesplegable');

    $('input[type=radio][name=hijos_vivos]').on('change', function() {
        if($(this).val() == 1) {
            $('#hijos_vivos-1-panel').removeClass('hidden');
        } else {
            $('#hijos_vivos-1-panel').addClass('hidden');
            $('#cuantos_hombres_vivos').val('');
            $('#cuantas_mujeres_vivas').val('');
            $('#hoy_cuantos_vivos').addClass('hidden');
            $('#hoy_cuantos_hombres_vivos-col').addClass('hidden');
            $('#hoy_cuantos_hombres_vivos').val('');
            $('#hoy_cuantas_mujeres_vivas-col').addClass('hidden');
            $('#hoy_cuantas_mujeres_vivas').val('');
            $('#fuera_cuantos').addClass('hidden');
            $('#fuera_cuantos_hombres-col').addClass('hidden');
            $('#fuera_cuantos_hombres').val('');
            $('#fuera_cuantas_mujeres-col').addClass('hidden');
            $('#fuera_cuantas_mujeres').val('');
        }
    });

    $('#cuantos_hombres_vivos').on('change', function() {
        if($(this).val() == '' || $(this).val() == 0) {
            var CMV = $('#cuantas_mujeres_vivas').val();
            $('#hoy_cuantos_vivos').addClass('hidden');
            $('#fuera_cuantos').addClass('hidden');
            if(CMV > 0) {
                $('#hoy_cuantos_vivos').removeClass('hidden');
                $('#fuera_cuantos').removeClass('hidden');
            }
            $('#hoy_cuantos_hombres_vivos-col').addClass('hidden');
            $('#hoy_cuantos_hombres_vivos').val('');
            
            $('#fuera_cuantos_hombres-col').addClass('hidden');
            $('#fuera_cuantos_hombres').val('');
        } else {
            $('#hoy_cuantos_vivos').removeClass('hidden');
            $('#hoy_cuantos_hombres_vivos-col').removeClass('hidden');
            $('#fuera_cuantos').removeClass('hidden');
            $('#fuera_cuantos_hombres-col').removeClass('hidden');
        }
    });

    $('#cuantas_mujeres_vivas').on('change', function() {
        if($(this).val() == '' || $(this).val() == 0) {
            var CHV = $('#cuantos_hombres_vivos').val();
            $('#hoy_cuantos_vivos').addClass('hidden');
            $('#fuera_cuantos').addClass('hidden');
            if(CHV > 0) {
                $('#hoy_cuantos_vivos').removeClass('hidden');
                $('#fuera_cuantos').removeClass('hidden');
            }
            $('#hoy_cuantas_mujeres_vivas-col').addClass('hidden');
            $('#hoy_cuantas_mujeres_vivas').val('');
            $('#fuera_cuantas_mujeres-col').addClass('hidden');
            $('#fuera_cuantas_mujeres').val('');
        } else {
            $('#hoy_cuantos_vivos').removeClass('hidden');
            $('#hoy_cuantas_mujeres_vivas-col').removeClass('hidden');
            $('#fuera_cuantos').removeClass('hidden');
            $('#fuera_cuantas_mujeres-col').removeClass('hidden');
        }
    });

    $('#frmPersona').validate({
        errorClass: 'error-form',
        rules: {
            hijos_vivos: {
                required: true,
                validarTotalHijos: ['cuantos_hombres_vivos', 'cuantas_mujeres_vivas']
            },
            cuantos_hombres_vivos: {selectVacio: true},
            cuantas_mujeres_vivas: {selectVacio: true},
            hoy_cuantos_hombres_vivos: {selectVacio: true},
            hoy_cuantas_mujeres_vivas: {selectVacio: true},
            fuera_cuantos_hombres: {selectVacio: true},
            fuera_cuantas_mujeres: {selectVacio: true}
        },
        messages: {
            hijos_vivos: {
                required: 'ERROR: Seleccione si la persona ha tenido algún hijo o hija que haya nacido vivo.',
                validarTotalHijos: 'ERROR: La suma de hombres y mujeres  que haya nacidos vivos no puede ser mayor a 28.'
            },
            cuantos_hombres_vivos: {selectVacio: 'ERROR: Seleccione cuántos hombres que haya nacidos vivos ha tenido la persona.'},
            cuantas_mujeres_vivas: {selectVacio: 'ERROR: Seleccione cuántas mujeres que haya nacidas vivas ha tenido la persona.'},
            hoy_cuantos_hombres_vivos: {selectVacio: 'ERROR: Seleccione actualmente cuántos hombres que haya nacidos vivos ha tenido la persona.'},
            hoy_cuantas_mujeres_vivas: {selectVacio: 'ERROR: Seleccione actualmente cuántas mujeres que haya nacidas vivas ha tenido la persona.'},
            fuera_cuantos_hombres: {selectVacio: 'ERROR: Seleccione cuántos hombres viven actualmente fuera de colombia.'},
            fuera_cuantas_mujeres: {selectVacio: 'ERROR: Seleccione cuántas mujeres viven actualmente fuera de colombia.'}
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
        if ($('#frmPersona').valid() == true) {
            var validator = $('#frmPersona').validate();

            var HNV = $('input:radio[name=hijos_vivos]:checked').val();
            var CHV = $('#cuantos_hombres_vivos').val();
            var CMV = $('#cuantas_mujeres_vivas').val();
            if(HNV == 1 && CHV == 0 && CMV == 0) {
                validator.showErrors({'cuantos_hombres_vivos': 'Seleccione el número de hijo(s) o hija(s) que haya nacido vivo.'});
                return false;
            }
            $(this).addClass('disabled').prop('disabled', true);
            var frm = $('#frmPersona').serialize();
            $.ajax({
                url: base_url + 'personas/persona/guardar',
                type: 'POST',
                dataType: 'json',
                data: frm + '&numePers=' + $('#frmPersona').data('nume_pers') + '&duracion=' + duracionPagina(),
                beforeSend: function () {
                    $('#msgSuccess').html('Guardando la(s) respuesta(s). Espere por favor...');
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
                window.location.href = base_url + 'persona'; 
            });
        }
    });

    $('#btnAnterior').on('click', function() {
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'personas/persona/regresar',
            type: 'POST',
            dataType: 'json',
            data: 'duracion=' + duracionPagina()
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
                window.location.href = base_url + 'personas/persona';
            } else {
                $('#msgError').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgAlert').removeClass('hidden');
            }
        })
        .fail(function(jqXHR) {
            window.location.href = base_url + 'persona';
        });
    });
});

function recargar() {
    window.location.href = base_url + 'personas/persona';
}