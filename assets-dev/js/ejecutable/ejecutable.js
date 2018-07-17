$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al mÃ³dulo de Internet Explorer
    redirectBrowser();
    
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

    // =========================== FORM DE DATOS
    
     $('[data-tooltip!=""]').qtip({
        content: { attr: 'data-tooltip' },
        position: { my: 'top left' },
        style: { classes: 'qtip-bootstrap qtip-DANE' }
    });

    var dialogo = new BootstrapDialog({
        title: 'Instancia del dialogo',
        message: 'Mensaje generico'
    });

    $('#fecha_expe-lbl').qtip({
      content: '<img src="http://cnpv4.dane.gov.co/dev/assets/images/cedula.jpg" alt="Owl" />',
      //content: { attr: 'data-tooltip' },
      position: { my: 'top right' },
      style: { classes: 'qtip-bootstrap qtip-DANE' }
    });

    var unicaCedula = function (idCampo, idCampo2) {
        var tipoDocu = $('#' + idCampo).val();
        var numeDocu = $('#' + idCampo2).val();
        
        if(tipoDocu.length == 0 || tipoDocu == '-') {
            $(this).val('').focus();
            return false;
        }

        /*if(tipoDocu != 3) {
            return true;
        }*/
        
        if(numeDocu.length == 0) {
            $(this).val('').focus();
            return false;
        }
            
        
 /* OK - ENVIAR CARGUE       
        $.ajax({
            type: 'POST',
            url: base_url + 'registro/completarPersona',
            data: {'tipoDocu': tipoDocu, 'numeDocu': numeDocu},
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                $('#animationload').fadeIn();
            },
            complete: function () {
                $('#animationload').fadeOut();
            },
            success: function (data) {
                if (data.codiError == 3) {
                    $('#' + idCampo2 + '-error').html('').removeClass('error-form');
                    return true;
                } else if (data.codiError == 0 || data.codiError == 1 || data.codiError == 2) {
                    //$('#' + idCampo2).parents('.form-group').first().addClass('has-error');
                    if(data.msgError.length > 0) {
                        //validator.showErrors({'nume_docu': data.msgError});
                        $('#' + idCampo2 + '-error').html(data.msgError).addClass('error-form');
                        $('#' + idCampo2).val('');
                    }
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                dialogo.setTitle('Validar nÃºmero de documento');
                dialogo.setType(BootstrapDialog.TYPE_DANGER);
                dialogo.setMessage(jqXHR.responseText);
                dialogo.open();
                return false;
            },
            timeout: 10000 // se define el timeout a 10 segundos
        });
        */
    };

    var longitudNumeDocu = function (tipoDocu, numeDocu) {
        switch (tipoDocu) {
            case '1':
                if (numeDocu.length < 12 && numeDocu.length > 5) {
                    return true;
                }
                break;
            case '2':
                if (numeDocu.length < 12 && numeDocu.length > 5) {
                    return true;
                }
                break;
            case '3':
                if (numeDocu.length < 12 && numeDocu.length > 1) {
                    return true;
                }
                break;
            case '4':
                if (numeDocu.length < 11 && numeDocu.length > 3) {
                    var regex = /[a-z]{2}\d{2,8}/;
                    if (numeDocu.match(regex)) {
                        return true;
                    }
                }
                break;
        }
        return false;
    };
    
    $('#primer_nombre').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#segundo_nombre').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#primer_apellido').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
    $('#segundo_apellido').soloNombre().maxlength(30).convertirMayuscula().verificaEspacios();
     $('#telefono_celular').soloNumeros();
    
    $.validator.addMethod('validaRC', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        var tipoDocu2 = $('#' + params[1]).val();
        if(tipoDocu == 6 && tipoDocu2.length == 0) {
            return false;
        } else if(tipoDocu2 == '1') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu2, value);
        }
        return true;
    });

    $.validator.addMethod('validaTI', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        var tipoDocu2 = $('#' + params[1]).val();
        if(tipoDocu == 6 && tipoDocu2.length == 0) {
            return false;
        } else if(tipoDocu2 == '2') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu2, value);
        }
        return true;
    });

    $.validator.addMethod('validaCC', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        if(tipoDocu.length == 0) {
            return false;
        } else if(tipoDocu == '3') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu, value);
        }
        return true;
    });

    $.validator.addMethod('validaCE', function (value, element, params) {
        var tipoDocu = $('#' + params[0]).val();
        if(tipoDocu.length == 0) {
            return false;
        } else if(tipoDocu == '4') {
            if(value.length == 0) {
                return false;
            }
            return longitudNumeDocu(tipoDocu, value);
        }
        return true;
    });

     $.validator.addMethod('validarCelular', function (value, element, params) {
        if(value.length > 0) {
            if(value.length < 10 || isNaN(value)) {
                return false;
            }
            if(value[0] != 3) {
                return false;
            }
        }
        return true;
    }); 
    $.validator.addMethod('emailValido2', function (value, element, params) {
        if (value.length > 0) {
            if (/^[a-zA-Z0-9_\-\.~]{2,}@[a-zA-Z0-9_\-\.~]{2,}\.[a-zA-Z]{2,4}$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    });
        
    $('#tipo_documento').on('change', function() {
        $('#numero_documento').val('');
        $('#tipo_documento option:selected').each(function () {
            if($(this).val() == 6) {
                $('#fecha_expe-col').addClass('hidden');
                $('#tipo_documento2-col').removeClass('hidden');
            } else {
                $('#tipo_documento2-col').addClass('hidden');
                $('#tipo_documento2').val('');
                if($(this).val() == 3) {
                    $('#fecha_expe-col').removeClass('hidden');
                } else {
                    $('#fecha_expe-col').addClass('hidden');
                    $('#anio_expe').val('');
                    $('#mes_expe').val('');
                    $('#dia_expe').val('');
                }
            }
        });
    });

    $('#tipo_documento2').on('change', function() {
        if($(this).val() == 5) {
            $('#nume_docu').val('').prop('readonly', true);
        } else {
            $('#nume_docu').val('').prop('readonly', false);
        }
    });

    $('#numero_documento').on('keypress', function(event) {
        var tipoDocu = $('#tipo_documento').val();
        
        if(tipoDocu.length == 0 || tipoDocu == '-') {
            $(this).val('').focus();   
        } else if(tipoDocu == 5) {
            tipoDocu = $('#tipo_documento2').val();
        }
        
        if (tipoDocu == 1 || tipoDocu == 2 || tipoDocu == 3) {
            if ((event.which == 8) || (event.which == 0))
                return true;
            if ((event.which >= 48) && (event.which <= 57))
                return true;
            else
                return false;
        } else if (tipoDocu == 4) {
            if (event.which == 0 || event.which == 8 || event.which == 13)
                return true;
            if ((event.which >= 48) && (event.which <= 57)) // Numeros
                return true;
            if ((event.which >= 65) && (event.which <= 90))  // Mayusculas
                return true;
            if ((event.which >= 97) && (event.which <= 122)) // Minusculas
                return true;
            else
                return false;
        }
    });

    $('#numero_documento').on('blur', function() {
        var tipoDocu = $('#tipo_documento').val();
        var numeDocu = $('#numero_documento').val();
        if(longitudNumeDocu(tipoDocu, numeDocu)) {
            return unicaCedula('tipo_documento', 'numero_documento');
        }
        return false;
    });

    //$('#ayudaSexo').hint('Intersexual', 'Cuerpo en el que la diferenciaciÃ³n sexual en cualquiera de los tipos de sexo (hombre â€“ mujer) no se alcanza en su totalidad; es decir, la persona nace con Ã³rganos sexuales, tanto internos como externos, de hombre y de mujer. Se denomina tambiÃ©n "hermafrodita" o "sexo indeterminado".');
    
    $('#frmCargar').validate({
        errorClass: 'error-form',
        rules: {
            tipo_documento: {selectVacio: true},
            tipo_documento2: {selectVacio: true},
            cargaArchivo: {required: true},
            numero_documento: {
                validaRC:['tipo_documento', 'tipo_documento2'], 
                validaTI:['tipo_documento', 'tipo_documento2'],
                validaCC:['tipo_documento'],
                validaCE:['tipo_documento']
            },
            primer_nombre: {required: true, maxlength: 30},
            segundo_nombre: {maxlength: 30},
            primer_apellido: {required: true, maxlength: 30},
            segundo_apellido: {maxlength: 30},
            telefono_celular: {required: true, validarCelular: true},
            correo_electronico: {required: true, emailValido2: true}
        },
        messages: {
            tipo_documento: {
                selectVacio: 'Error: Seleccione el tipo de identificaciÃ³n de la persona.'
            },
            tipo_documento2: {
                selectVacio: 'Error: Seleccione el tipo 2 de identificaciÃ³n de la persona.'
            },
            cargaArchivo: {required: 'Error: Seleccione el archivo comprimido(.zip) a cargar.'
            },
            numero_documento: {
                //required: 'Digite el nÃºmero de documento de la persona.',
                validaRC: 'Error: La longitud del nÃºmero de documento debe serRC de 11 caracteres.',
                validaTI: 'Error: La longitud del nÃºmero de documento debe serTI de 11 caracteres.',
                validaCC: 'Error: La longitud del nÃºmero de documento debe estar entre 6 a 11 caracteres.',
                validaCE: 'Error: El documento debe tener mÃ­nimo 2 letras y entre 5 a 7 dÃ­gitos.'
            },
             primer_nombre: {
                required: 'Digite el primer nombre de la persona.',
                maxlength: 'El primer nombre no debe tener mÃ¡s de 30 caracteres.'
            },
            segundo_nombre: { maxlength: 'El segundo nombre no debe tener mÃ¡s de 30 caracteres.' },
            primer_apellido: {
                required: 'Digita el primer apellido de la persona.',
                maxlength: 'El segundo apellido no debe tener mÃ¡s de 30 caracteres.'
            },
            segundo_apellido: { maxlength: 'El segundo apellido no debe tener mÃ¡s de 30 caracteres.' },
            telefono_celular: { required: 'Digite el nÃºmero de telÃ©fono celular',
                validarCelular: 'Error: El telÃ©fono celular debe iniciar por 3 y tener 10 dÃ­gitos.'
            },
             correo_electronico: {
                required: 'Error: Digite un correo electrÃ³nico vÃ¡lido.', 
                emailValido2: 'Error: No es una direcciÃ³n de correo electrÃ³nico vÃ¡lida.',
                validarEmail: 'Error: El correo electrÃ³nico ya esta registrado en el sistema'
            }
        },
        /*acc*/
        onfocusout: function (element) {   
            if(!$(element).valid()) {
                $('#' + $(element).attr('id')).focus();
            }
            //$(element).valid();
        },
        errorPlacement: function (error, element) {
            if (element.parents('.input-group').hasClass('input-group')){
                element.parents('.input-group').parent().append(error);
            } else {
                $(element).parents('.form-group').first().append(error.attr('role', 'alert'));
            }
        },
        highlight: function (element, errorClass, validClass) {
            if ($(element).parents('.input-group').hasClass('input-group')){
                //$(element).parents('.form-group').first().append(error.attr('role', 'alert'));
            } else {
                $(element).parent('.control-option').addClass('has-error');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if ($(element).parents('.input-group').hasClass('input-group') && $(element).attr('id')=='anioExpe'){
                $(element).parents('.input-group').parent().removeClass('has-error errorForm');
            } else {
                $(element).parents('.control-option').removeClass('has-error');
            }
        },
        submitHandler: function (form) {
            return true;
        }
    });

    $('#btnGuardar').on('click', function() {
        if ($('#frmCargar').valid() == true) {
            var validator = $('#frmCargar').validate();

         /*
            if(unicaCedula('tipo_documento', 'numero_documento') == false) {
                validator.showErrors({'nume_docu': 'Error: Ya existe un usuario registrado con este nÃºmero de documento.'});
                return false;
            }
        */

        /*var teleCelular=$('#telefono_celular').val();
        if(teleCelular.length == 0 ) {
                validator.showErrors({'telefono_celular': 'Error: Digite el telÃ©fono fijo de 7 dÃ­gitos o nÃºmero celular de 10 dÃ­gitos.'});
                return false;
            }*/
        
        // ==================Valida archivo a cargar ================== 
                // Detecta si es diferente a internet explorer, ya q la validacion de tamaÃ±o y tipo archivo no funciona en este. Se haria entonces desde PHP
                 var ua = window.navigator.userAgent;
                 var msie = ua.indexOf("MSIE ");
                 
                 if (msie <= 0) // Es diferente a Internet Explorer
                 {
                    var input, file, tamano, extension;
                    var permitida = false;
                    var extensiones_permitidas = new Array(".zip"); 
                            
                    input=file=tamano=extension='';
                    input = document.getElementById('cargaArchivo');
                    if(input.value)
                    {   
                        file = input.files[0];
                        
                        // ==================Valida la extension del archivo==================
                        extension = (file.name.substring(file.name.lastIndexOf("."))).toLowerCase();    
                        permitida = false;
                        for (var j = 0; j < extensiones_permitidas.length; j++) {
                            if (extensiones_permitidas[j] == extension) {
                            permitida = true;
                            break;
                            }
                        }
                        if (!permitida) {
                            //alert("Formato de archivo no v\u00E1lido. Debe tener extensiÃ³n .zip");
                            $('#msjArchivo').removeClass('hidden');
                            $("#msjArchivo").html("Error: Formato de archivo no v\u00E1lido. Debe tener extensiÃ³n .zip");
                            return false;   
                        }   
                        //====================Valida el tamaÃ±o del archivo========================
            /*          tamano= file.size;  
                        if(tamano > 3000000)//3Mb
                            {
                            $('#msjArchivo').removeClass('hidden');
                            $("#msjArchivo").html("El archivo "+file.name+" excede el tama\u00F1o permitido ( 3Mb).");
                            return false;   
                            }*/
                    }       
                    
                 }// msie
        
            /*var frm = $('#frmCargar').serializeArray();
            $.each(frm, function(key, value) {
                if ($('#' + value.name + '-confirm').length > 0) {
                    if($('#' + value.name).is('select')) {
                        $('#' + value.name + '-confirm').html($('#' + value.name + ' option[value="' + value.value + '"]').html());
                        if(value.name == 'tipo_documento' && value.value == 6) {
                            $('#' + value.name + '-confirm').html('');
                        }
                        if(value.name == 'tipo_documento2' && value.value != 6) {
                            $('#' + value.name + '-confirm').html('');
                        }
                    } else {
                        $('#' + value.name + '-confirm').html(value.value);
                    }
                }
            });
            $('#frmCargar').addClass('hidden');
            $('#mensajeConfirmacion').removeClass('hidden');
            */
            $('.glyphicon-refresh-animate').removeClass('hide');
            $('.glyphicon-save').addClass('hide');
            $(this).addClass('disabled');
            $(this).prop('disabled', true);
            $('#animationload').fadeIn();
            $('#frmCargar').submit();
            
        }
    });

     $('#btnRegresar').click(function () {
        $(location).attr('href', base_url);
    });
    
    $('#cargaArchivo').change(function () {
         $('#msjArchivo').addClass('hidden');
    });
    
     $('#btnDescargar').click(function () {
        //$(location).attr('href', base_url + 'encuesta/generarConstanciaPDF');
        window.open(base_url + 'ejecutable/generarConstancia','width=900,height=820,left=50,top=50,location=no,menubar=no,resizable=no,toolbar=no');
    });
});//EOC

/*
function limpia_file()
{
    $('#cargaArchivo').attr("value", "");
}*/