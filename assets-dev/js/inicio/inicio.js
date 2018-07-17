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

    $('.scrollup').on('click', function() {
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $.fn.activarPanel = function (modulo, color) {
        $('#panel' + modulo).removeClass('panel-inicio-disabled').addClass('panel-inicio-activo');
        $('#subtitulo' + modulo).html('<a class="link-section-inicio" href="' + base_url + modulo.toLowerCase() + '" alt="Este es un link que direcciona a la sección de '+modulo+'">EMPEZAR <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>');
        
        $('#panel' + modulo).on('click', function() {
            if(modulo.toLowerCase() == "ubicacion" || modulo.toLowerCase() == "vivienda" || modulo.toLowerCase() == "hogar"){
                $(location).attr('href', base_url + modulo.toLowerCase() + "/formNew");
                //$(location).attr('href', base_url + modulo.toLowerCase());
            }else{
                $(location).attr('href', base_url + modulo.toLowerCase());
            }
        });
    };

    $.fn.panelCOMPLETADO = function (modulo, color) {
        $('#panel' + modulo).removeClass('panel-inicio-disabled').addClass('panel-inicio-completado');
        $('#subtitulo' + modulo).html('COMPLETADO <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>');
        
    };

    $.fn.activarPanelCOMPLETADO = function (modulo, color) {
        $('#panel' + modulo).removeClass('panel-inicio-disabled').addClass('panel-inicio-completado panel-inicio-habilitado');
        $('#subtitulo' + modulo).html('COMPLETADO <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>');
        
        $('#panel' + modulo).on('click', function() {
            if(modulo.toLowerCase() == "ubicacion" || modulo.toLowerCase() == "vivienda" || modulo.toLowerCase() == "hogar"){
                $(location).attr('href', base_url + modulo.toLowerCase() + "/formNew");
                //$(location).attr('href', base_url + modulo.toLowerCase());
            }else{
                $(location).attr('href', base_url + modulo.toLowerCase());
            }
        });
    };

    //acc
    $('#acc_title').focus();
    $.ajax({
        type: 'POST',
        url: base_url + 'inicio/consultarEstado',
        dataType: 'json',
        cache: false,
        success: function (data) {
            if(data.ubicacion == 1) {
                $('#panelUbicacion').activarPanel('Ubicacion');
            }
            if(data.vivienda == 1) {
                $('#panelUbicacion').panelCOMPLETADO('Ubicacion');
                $('#panelVivienda').activarPanel('Vivienda');
            }
            if(data.hogar == 1) {
                $('#panelUbicacion').panelCOMPLETADO('Ubicacion');
                $('#panelUbicacion').panelCOMPLETADO('Vivienda');
                $('#panelHogar').activarPanel('Hogar');
            }
            if(data.personas == 1) {
                $('#panelUbicacion').panelCOMPLETADO('Ubicacion');
                $('#panelUbicacion').panelCOMPLETADO('Vivienda');
                $('#panelUbicacion').panelCOMPLETADO('Hogar');
                $('#panelPersonas').activarPanel('Personas');
            }
            if(data.avance == '100%') {
                $('#panelUbicacion').activarPanelCOMPLETADO('Ubicacion');
                $('#panelUbicacion').activarPanelCOMPLETADO('Vivienda');
                $('#panelUbicacion').activarPanelCOMPLETADO('Hogar');
                $('#panelUbicacion').activarPanelCOMPLETADO('Personas');
            }
            $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            dialogo.setTitle('Consultar estado encuesta');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
            return false;
        },
        timeout: 10000 // se define el timeout a 10 segundos
    });

    $('#btnDescargar').click(function () {
        //$(location).attr('href', base_url + 'encuesta/generarConstancia');
        window.open(base_url + 'encuesta/generarConstancia','','width=600,height=400,left=50,top=50,toolbar=yes');
    });
});