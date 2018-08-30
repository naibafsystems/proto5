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

    $.ajax({
        type: 'POST',
        url: base_url + 'personas/avance',
        dataType: 'json',
        cache: false,
        success: function (data) {
            $('#progressbar').html(data.avance + ' COMPLETADO').css('width', data.avance);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            dialogo.setTitle('Consultar estado personas');
            dialogo.setType(BootstrapDialog.TYPE_DANGER);
            dialogo.setMessage(jqXHR.responseText);
            dialogo.open();
            return false;
        },
        timeout: 10000 // se define el timeout a 10 segundos
    });

    $('.completar-pers').on('click', function() {
        var $item = $(this);
        $.ajax({
            url: base_url + 'personas/iniciar',
            type: 'POST',
            data: {'numepers': $item.data('numepers')},
            dataType: 'json',
            beforeSend: function () {
                $('#msgSuccess').html('Cargando las preguntas. Espere por favor...');
                $('#divMsg').removeClass('hidden');
                $('#divMsgSuccess').removeClass('hidden');
            }
        })
        .done(function(data) {
            if(data.codiError == 0) {
                $('#msgSuccess').html(data.mensaje);
                $('#divMsg').removeClass('hidden');
                $('#divMsgSuccess').removeClass('hidden');
                window.location.href = base_url + 'personas/persona/completar/' + $item.data('numepers');
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
	
	$('#form_entrevista').validate({
        errorClass: 'error-form',
        rules: {
            numero_visita: {required: true},
            dia: {required: true, min:1, max:31},
            mes: {required: true, min:1, max:12},
            anio: {required: true, min:2018, max:2018},
            
            
            resultado_entrevista: {required: true},
            
            
            nume_certificado: {maxlength:9}
        },
        messages: {
            numero_visita: {required: 'Error: Seleccione el número de visita.'},
            dia: {required: 'Error: El campo día es obligatorio.'},
            mes: {required: 'Error: El campo mes es obligatorio.'},
            anio: {required: 'Error: El campo año es obligatorio.'},
            
            
            resultado_entrevista: {required: 'Error:  Seleccione el resultado de la entrevista.'},
            
            
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
            //return true;
			var $item = $(this);
			$.ajax({
				url: base_url + 'personas/guardarEntrevista',
				type: 'POST',
				data: {'numero_visita': $("#numero_visita").val(), 
						'dia': $("#dia").val(),
						'mes': $("#mes").val(),
						'anio': $("#anio").val(),
						'hora': $("#hora").val(),
						'minutos': $("#minutos").val(),
						'resultado_entrevista': $("#resultado_entrevista").val(),
						'cod_censita': $("#cod_censita").val(),
						'cod_supervisor': $("#cod_supervisor").val(),
						'nume_certificado': $("#nume_certificado").val()
						},
				dataType: 'json'
			}).done(function(data) {                
				alert(data.mensaje);
				window.location.href = base_url + 'personas/';            
			})
			.fail(function(jqXHR) {
				window.location.href = base_url + 'personas';
			});
        }
    });
		
});