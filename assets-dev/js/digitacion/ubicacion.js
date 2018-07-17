$(document).ready(function() {
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

    /*==========================================================================================================================================*/
    // $('#codi_depa').cargarCombo('codi_depa', 'codi_muni', base_url + 'formulario/listaDesplegable');

    // $('#ayudaDepa').hint('Departamento', 'Entidad territorial que goza de autonomía para la administración de los asuntos seccionales y la planificación y promoción del desarrollo económico y social dentro de su territorio en los términos establecidos por la Constitución y las leyes. Los departamentos ejercen funciones: administrativas, de coordinación, de complementariedad de la acción municipal, de intermediación entre la nación y los municipios y de prestación de los servicios que determinen la Constitución y las leyes.');
    // $('#ayudaMuni').hint('Municipio', 'Entidad territorial fundamental de la división político-administrativa del Estado, con autonomía política, fiscal y administrativa dentro de los límites que le señalen la Constitución y las leyes de la República.');
    // $('#ayudaRural').hint('Rural disperso', 'Es el área que se caracteriza por la disposición dispersa de viviendas y explotaciones agropecuarias. No cuenta con un trazado o nomenclatura de calles, carreteras, avenidas, y demás.  Dicha área hace parte del Resto municipal.');
    // $('#ayudaLocalidad').hint('Localidad o comuna', 'Es a una unidad administrativa de una ciudad media o principal del país que agrupa sectores o barrios determinados. El término localidad se emplea en las ciudades que corresponden a Distritos Especiales como Bogotá y Cartagena, para el resto de las ciudades se emplea el término comuna.');
    // $('#ayudaBarrio').hint('Barrio, corregimiento o vereda', 'Espacio geográfico en que se divide el área urbana, y donde se ubican un conjunto de manzanas.');
    // $('#ayudaResguardo').hint('Resguardo indígena', 'Institución legal y sociopolítica de carácter especial indivisible, inalienable, imprescriptible e inembargable; está conformada por una o varias comunidades o parcialidades de ascendencia amerindia, que con un título de propiedad colectiva o comunitaria, posee un territorio y se rige para el manejo de este y de su vida interna por una organización social ajustada al fuero indígena, el cabildo o a sus pautas y tradiciones culturales.');
    // $('#ayudaComunidadNegra').hint('Territorio colectivo de comunidad negra', 'Son los terrenos de ocupación histórica de comunidades negras sobre los cuales se ha reconocido el derecho a la propiedad y han sido adjudicados de manera colectiva mediante resolución del Instituto Colombiano de Reforma Agraria (INCORA) o por el Instituto Colombiano de Desarrollo Rural (INCODER), en la que habitan o realizan actividades sociales, económicas y culturales. Es un tipo de propiedad colectiva.');
    // $('#ayudaComplementoDire').hint('Complemento de dirección', 'Por favor ingrese los datos como Manzana, Bloque, Torre, Apartamento, Kilometro, etc.');
    // $('#ayudaRaizal').hint('Territorio raizal ancestral', 'Corresponde al territorio sobre el que reclaman autonomía los \'raizales\' que habitan los territorios insulares colombianos de San Andrés, Providencia y Santa Catalina desde 1624.');
    // $('#ayudaVereda').hint('Vereda', 'División territorial de carácter administrativo en el área rural de los municipios, establecida mediante acuerdo municipal. Se concibe como una agrupación comunitaria de base territorial y principal espacio de sociabilidad, caracterizada por la proximidad de residencia de sus miembros, el sentido de pertenencia e identidad común y el predominio de las relaciones vecinales.');
    // $('#ayudaRancheria').hint('Rancheria', 'Se refiere al espacio geográfico donde convive un grupo de personas que pertenece al pueblo indígena Wayuu.');

    // $('input[type=radio][name=codi_clase]').on('change', function() {
    //     if($(this).val() == 1) {
    //         $('#divLocalidad').removeClass('hidden');
    //         $('#divPoblado').addClass('hidden');
    //         $('#poblado').val('');
    //         $('#claseEtnica').removeAttr('checked').prop('disabled', true);
    //         $("#resguardo").hide();
    //         $('#nombreResguardo').val('');
    //         $('#comunidadNegra').hide();
    //         $('#nombreComunidadNegra').val('');
    //         $('#divResgTerri').hide();
    //         $("#frmUbicacion input[name='resgTerrit']").removeAttr('checked');
    //         $("#frmUbicacion input[name='territo']").removeAttr('checked');
    //     } else if ($(this).val() == 2) {
    //         $('#divLocalidad').addClass('hidden');
    //         $('#localidad').val('');
    //         $('#divPoblado').removeClass('hidden');
    //         $('#claseEtnica').prop('disabled', false);
    //     } else {
    //         $('#divLocalidad').addClass('hidden');
    //         $('#divPoblado').addClass('hidden');
    //         $('#localidad').val('');
    //         $('#poblado').val('');
    //         $('#claseEtnica').prop('disabled', false);
    //     }
    // });

    // $("#frmUbicacion input[name='vivienda_etnica']:radio").click(function () {
    //     if ($(this).val() == 1) {
    //         $('#divClaseEtnica').removeClass('hidden');
    //     } else if ($(this).val() == 2) {
    //         $('#divClaseEtnica').addClass('hidden');
    //         //@todo: hay que revisar porque no funciona
    //         $("#frmUbicacion input[name='vivienda_indigena']").removeAttr('checked');
    //         $("#frmUbicacion input[name='vivienda_indigena']").removeAttr('checked');
    //         $("#codi_vivi_indigena option[value='']").attr('selected', true);
    //         $("#codi_vivi_negra option[value='']").attr('selected', true);
    //     }
    // });

    // $("#frmUbicacion input[name='vivienda_etnica_si']:radio").click(function () {
    //     if ($(this).val() == 1) {
    //         $('#divViviendaIndigena').removeClass('hidden');
    //         $('#divComunidadNegra').addClass('hidden');
    //         $("#codi_vivi_negra").val('');
    //     } else if ($(this).val() == 2) {
    //         $('#divViviendaIndigena').addClass('hidden');
    //         $('#divComunidadNegra').removeClass('hidden');
    //         $("#codi_vivi_indigena").val('');
    //     }
    // });

    // $("#frmUbicacion input[name='vivienda_area_prot']:radio").click(function () {
    //     if ($(this).val() == 1) {
    //         $('#divViviendaAreaProt').removeClass('hidden');
    //     } else if ($(this).val() == 2) {
    //         $('#divViviendaAreaProt').addClass('hidden');
    //         $("#codi_area_prot option[value='']").attr('selected', true);
    //     }
    // });

    // $("#frmUbicacion input[name='territorioEtnico']:radio").click(function () {
    //     if ($(this).val() == 1) {
    //         $('#divTerritorio2Etnico').removeClass('hidden');
    //     } else if ($(this).val() == 2) {
    //         $('#divTerritorio2Etnico').addClass('hidden');
    //         $("#frmUbicacion input[name='territorio2Etnico']").removeAttr('checked');
    //     }
    // });

    // $("#frmUbicacion input[name='territorio2Etnico']:radio").click(function () {
    //     if ($(this).val() == 1) {
    //         $('#divTerritorio3Etnico').removeClass('hidden');
    //         $('#divTerritoIndi').removeClass('hidden');
    //         $('#divComuniNegra').addClass('hidden');
    //         $('#divSanAndres').addClass('hidden');
    //     } else if ($(this).val() == 2) {
    //         $('#divTerritorio3Etnico').addClass('hidden');
    //         $('#divTerritoIndi').addClass('hidden');
    //         $('#divComuniNegra').removeClass('hidden');
    //         $('#divSanAndres').addClass('hidden');
    //     } else if ($(this).val() == 3) {
    //         $('#divTerritorio3Etnico').addClass('hidden');
    //         $('#divTerritoIndi').addClass('hidden');
    //         $('#divComuniNegra').addClass('hidden');
    //         $('#divSanAndres').removeClass('hidden');
    //     }
    // });

    // $('#territorio3Etnico').click(function () {
    //     if ($(this).is(':checked')) {
    //         $('#divTerritorio4Etnico').removeClass('hidden');
    //     } else {
    //         $('#divTerritorio4Etnico').addClass('hidden');
    //     }
    // });

    // $.validator.addMethod('validaLocalidad', function (value, element, params) {
    //     var clase = $('input:radio[name=' + params[0] + ']:checked').val();
    //     if(value.length == 0 && clase == 1) {
    //         return false;
    //     }
    //     return true;
    // });

    // $.validator.addMethod('validaPoblado', function (value, element, params) {
    //     var clase = $('input:radio[name=' + params[0] + ']:checked').val();
    //     if(value.length == 0 && clase == 2) {
    //         return false;
    //     }
    //     return true;
    // });

    // $.validator.addMethod('validaTerrito', function (value, element, params) {
    //     if(value == undefined && $('#' + params[0]).is(':checked')) {
    //         return false;
    //     }
    //     return true;
    // });

    // $('#frmUbicacion').validate({
    //     rules: {
    //         codi_depa: {selectVacio: true},
    //         codi_muni: {selectVacio: true},
    //         codi_clase: {required: true},
    //         codi_localidad: {validaLocalidad: ['codi_clase']},
    //         codi_poblado: {validaPoblado: ['codi_clase']},
    //         vivienda_etnica: {required: true},
    //         vivienda_etnica_si: {required: true},
    //         codi_vivi_indigena: {required: true},
    //         codi_vivi_negra: {required: true},
    //         vivienda_area_prot: {required: true},
    //         codi_area_prot: {required: true},
    //         area_ubicacion: {required: true},
    //         //direccion: {required: true},
    //         nombre_ubicacion: {required: true},
    //         //territorioEtnico: {required: true},
    //         //territorio2Etnico: {required: true}
    //     },
    //     messages: {
    //         codi_depa: { selectVacio: 'ERROR: Departamento no puede estar vacio.' },
    //         codi_muni: { selectVacio: 'ERROR: Municipio no puede estar vacia.' },
    //         codi_clase: { required: 'ERROR: Selecciona el lugar donde resides.' },
    //         codi_localidad: {validaLocalidad: 'ERROR: Selecciona la localidad o comuna.'},
    //         codi_poblado: {validaPoblado: 'ERROR: Selecciona el centro poblado.'},
    //         vivienda_etnica: {required: 'ERROR: Selecciona si la vivienda en la cual reside habitualmente se encuentra en el interior de un territorio étnico.'},
    //         vivienda_etnica_si: {required: 'ERROR: Selecciona el territorio étnico.' },
    //         codi_vivi_indigena: {required: 'ERROR: Selecciona el resguardo indígena.' },
    //         codi_vivi_negra: {required: 'ERROR: Selecciona el territorio colectivo de comunidad negra.' },
    //         vivienda_area_prot: {required: 'ERROR: Selecciona si la vivienda en la cual reside habitualmente se encuentra en el interior de un área protegida.'},
    //         codi_area_prot: {required: 'ERROR: Selecciona el área protegida.' },
    //         direccion: { required: 'ERROR: Selecciona una dirección.' },
    //         area_ubicacion: { required: 'ERROR: Selecciona el área donde está ubicada la vivienda.' },
    //         nombre_ubicacion: { required: 'ERROR: Digita el nombre del área donde está ubicada la vivienda.' },
    //         territorioEtnico: { required: 'ERROR: Digita si la vivienda en la cual reside habitualmente se encuentra en el interior de un territorio étnico.' },
    //         territorio2Etnico: { required: 'ERROR: Selecciona el territorio étnico o reserva.' }
    //     },
    //     errorPlacement: function (error, element) {
    //         $(element).parents('.form-group').first().addClass('has-error');
    //         $(element).parents('.form-group').first().append(error.addClass('errorForm'));
    //     },
    //     highlight: function (element, errorClass, validClass) {
    //         $(element).parents('.form-group').first().addClass('has-error');
    //     },
    //     unhighlight: function (element, errorClass, validClass) {
    //         $(element).parents('.form-group').first().removeClass('has-error');
    //     },
    //     submitHandler: function (form) {
    //         return true;
    //     }
    // });
    /*==========================================================================================================================================*/


    /*==========================================================================================================================================*/
    // ubicacionE1.js
    $('#ayudaBarrio').hint('Barrio, corregimiento o vereda', 'Espacio geográfico en que se divide el área urbana, y donde se ubican un conjunto de manzanas.');
    $('#departamento').cargarCombo('departamento', 'municipio', base_url + 'formulario/listaDesplegable');

    $('#departamento').change(function() {
        $('option', '#municipio').remove();
    });

    $('#municipio').select2({
        allowClear: true,
        //containerCssClass: 'select2-container', // No funciona
        //dropdownCssClass: 'select2-container', // No funciona
        language: 'es',
        //minimumInputLength: 2,
        placeholder: 'Municipio o área no municipalizada',
        theme: 'bootstrap',
        width: '100%'
    });

    /*==========================================================================================================================================*/


    /*==========================================================================================================================================*/
    // ubicacionE2.js
    if($('#otro_centro_poblado-col').val().length == 0) {
        // $('#otro_centro_poblado-col').addClass('hidden');
        $('#clase-2-panel').addClass('hidden');
    }

    $('input[type=radio][name=clase]').on('change', function() {
        if($(this).val() == 1) {
            $('#otro_centro_poblado').val('');
            $('#clase-1-panel').removeClass('hidden');
            $('#clase-2-panel').addClass('hidden');
            $('#centro_poblado').val('');
            $('#clase-3-panel').addClass('hidden');
            $('input[name=tipo_centro]').prop('checked', false);
            $('input[name=tipo_rural]').prop('checked', false);
        } else if($(this).val() == 2) {
            $('#clase-1-panel').addClass('hidden');
            $('#localidad').val('');
            $('#clase-2-panel').removeClass('hidden');
            $('#clase-3-panel').addClass('hidden');
            $('input[name=tipo_rural]').prop('checked', false);
        } else if($(this).val() == 3) {
            $('#otro_centro_poblado').val('');
            $('#clase-1-panel').addClass('hidden');
            $('#localidad').val('');
            $('#clase-2-panel').addClass('hidden');
            $('#centro_poblado').val('');
            $('#clase-3-panel').removeClass('hidden');
            $('input[name=tipo_centro]').prop('checked', false);
        }
    });

    // $('#centro_poblado').on('change', function() {
    //     if($(this).val() == 888) {
    //         $('#otro_centro_poblado-col').removeClass('hidden');
    //     } else {
    //         $('#otro_centro_poblado-col').addClass('hidden');
    //         $('#otro_centro_poblado').val('');
    //     }
    // });
    /*==========================================================================================================================================*/


    /*==========================================================================================================================================*/
    // ubicacionE3.js.
    if(!$('input[type=radio][name=tipo_lugar]:checked').length){
        $('#nombre_lugar-lbl').parents('.form-group').addClass('hidden');
    }

    $('input[type=radio][name=tipo_lugar]').on('change', function() {
        $('#nombre_lugar-lbl').parents('.form-group').removeClass('hidden');
        var pregunta = '&iquest;Cómo es el nombre ';
        var tipoClase = ['', 'Barrio', 'Corregimiento', 'Vereda', 'Ranchería', 'Comunidad'];
        var val = $(this).val();
        switch(val) {
            case '1':
            case '2':
                pregunta += 'del ' + tipoClase[val];
            break;
            case '3':
            case '4':
            case '5':
                pregunta += 'de la ' + tipoClase[val];
            break;
        }
        pregunta += ' donde vive&#63;';
        $('#nombre_lugar-lbl').html(pregunta);
    });

    $('#nombre_lugar').textoDireccion().maxlength(40).verificaEspacios();
    /*==========================================================================================================================================*/


    /*==========================================================================================================================================*/
    // ubicacionE4.js.
    $('input[type=radio][name=es_resguardo_terri]').on('change', function() {
        if($(this).val() == 1) {
            $('#tipo_territo-col').removeClass('hidden');
        } else if($(this).val() == 2) {
            $('#tipo_territo-col').addClass('hidden');
            $('input[name=tipo_territo]').prop('checked', false);
            $('#tipo_territo-1-panel').addClass('hidden');
            $('#resguardo').val('');
            $('#tipo_territo-2-panel').addClass('hidden');
            $('#territorio').val('');
        }
    });

    $('input[type=radio][name=tipo_territo]').on('change', function() {
        if($(this).val() == 1) {
            $('#tipo_territo-1-panel').removeClass('hidden');
            $('#tipo_territo-2-panel').addClass('hidden');
            $('#territorio').val('');
        } else if($(this).val() == 2) {
            $('#tipo_territo-1-panel').addClass('hidden');
            $('#resguardo').val('');
            $('#tipo_territo-2-panel').removeClass('hidden');
        }
    });
    /*==========================================================================================================================================*/





































    var $frmUbicacion = $('#frmUbicacion');
    // $frmUbicacion.validate({
    //     // errorClass: 'error text-danger',
    //     rules: {
    //         nom_usuario: {required: true, maxlength:50, minlength:4},
    //         ape_usuario: {required: true, maxlength:50, minlength:4},
    //         num_ident: {required: true, number:true, maxlength:10},
    //         tel_usuario: {required: true, number: true, maxlength: 15},
    //         ext_usuario: {number: true, maxlength: 6},
    //         mail_usuario : {required: true, email: true, maxlength: 100},
    //         tipov_usuario: {selectVacio: true},
    //         despacho: {selectVacio: true},
    //         dependencia: {selectVacio: true},
    //         // dep_usuario: {selectVacio: true},
    //     },
    //     messages: {
    //         // nom_usuario: {required:'Campo oblogaorio siempre carajo',},
    //         num_ident: {number: 'Numero de documento no valido.',},
    //         tel_usuario: {number: 'Numero de teléfonno no valido.',},
    //         ext_usuario: {number: 'Numero de extencion no valido.',},
    //     },
    //     highlight: function(element, errorClass, validClass) {
    //         $(element).parent().addClass('has-error text-danger');
    //     },
    //     unhighlight: function(element, errorClass, validClass) {
    //         $(element).parent().removeClass('has-error text-danger');
    //     },
    // });
    $("#save").on('click', function(event) {
        event.preventDefault();
        var frm = $('#frmUbicacion').serializeArray();
        $(':input').addClass('disabled').prop('disabled', true);
        $(':button').addClass('disabled').prop('disabled', true);
        $.ajax({
            url: base_url + 'soporte/digitacion/saveUbica',
            type: 'POST',
            dataType: 'json',
            data: frm,
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
                        //$('#animationload').fadeIn();
                        // setTimeout(recargar, 2000);
                    } else {
                        $('#msgError').html(data.mensaje);
                        $('#divMsg').removeClass('hidden');
                        $('#divMsgAlert').removeClass('hidden');
                        // setTimeout(recargar, 5000);
                    }
                })
        .fail(function(jqXHR) {
            console.log(jqXHR.responseText);
            // window.location.href = base_url + 'ubicacion';
        });
    });
});

function recargar() {
    // window.location.href = base_url + 'ubicacion';
}