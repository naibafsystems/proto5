function recargar(){window.location.href=base_url+"hogar"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1}),$('[data-tooltip!=""]').qtip({content:{attr:"data-tooltip"},position:{my:"top left"},style:{classes:"qtip-bootstrap qtip-DANE"}});var e=new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"}),a=function(e,a){switch(e){case"1":if(a.length<11&&a.length>1)return!0;break;case"2":if(a.length<13&&a.length>1)return!0;break;case"3":if(a.length<11&&a.length>1)return!0;break;case"4":if(a.length<11&&a.length>2){var r=/[a-zA-Z0-9]/;if(a.match(r))return!0}}return!1},r=function(e,a){switch(a){case"2":if(e>6)return!0;break;case"3":if(e>17)return!0}return!1},o=function(e){var a=$("#"+e).val();return 0==a.length?($("#"+e+"-error").html("Selecciona la fecha de nacimiento.").removeClass("hide").show(),$(this).val(""),!1):!(calculaEdad(formatearFecha(a),"")<18)};$.validator.addMethod("validaRC",function(e,r,o){var n=$("#"+o[0]).val();return 0!=n.length&&("1"!=n||0!=e.length&&a(n,e))}),$.validator.addMethod("validaTI",function(e,r,o){var n=$("#"+o[0]).val();return 0!=n.length&&("2"!=n||0!=e.length&&a(n,e))}),$.validator.addMethod("validaCC",function(e,r,o){var n=$("#"+o[0]).val();return 0!=n.length&&("3"!=n||0!=e.length&&a(n,e))}),$.validator.addMethod("validaCE",function(e,r,o){var n=$("#"+o[0]).val();return 0!=n.length&&("4"!=n||0!=e.length&&a(n,e))}),$.validator.addMethod("validarCamposFecha",function(e,a,r){if(3==$("#"+r[0]).val()){if(0==e.length||"-"==e)return!1;if(isNaN(e))return!1}return!0}),$.validator.addMethod("validarFecha",function(e,a,r){var o=$("#"+r[0]).val(),n=$("#"+r[1]).val(),i=$("#"+r[2]).val();if(o.length>0&&n.length>0&&i.length>0){return moment(o+"-"+n+"-"+i).isValid()}return!0}),$.validator.addMethod("validarMayorEdad",function(e,a,r){return o($(a).attr("id"))}),$.validator.addMethod("mayor121",function(e,a,r){return!(e>121)}),$.validator.addMethod("validarEdadTI",function(e,a,o){var n=$("#"+o[1]).val();if(2==n){var i=$("#"+o[0]).val();return r(i,n)}return!0}),$.validator.addMethod("validarEdadCC",function(e,a,o){var n=$("#"+o[1]).val();if(3==n){var i=$("#"+o[0]).val();return r(i,n)}return!0}),$.validator.addMethod("jefeMenorEdad",function(e,a,r){var o=$("#"+r[0]).val(),n=$("#"+r[1]).val();return o.length>0&&(!(1==n&&o<10)&&($("#"+r[0]+"-error").hide(),$("#"+r[1]+"-error").hide(),!0))}),$("#primer_nombre").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#segundo_nombre").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#primer_apellido").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#segundo_apellido").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#edad_persona").soloNumeros(),$("#tipo_documento").on("change",function(){$("#numero_documento").val("")}),$("#numero_documento").on("keypress",function(e){var a=$("#tipo_documento").val();return 0==a.length||"-"==a?($(this).val(""),!1):1==a||2==a||3==a?8==e.which||0==e.which||e.which>=48&&e.which<=57:4==a?0==e.which||8==e.which||13==e.which||(e.which>=48&&e.which<=57||(e.which>=65&&e.which<=90||e.which>=97&&e.which<=122)):void 0}),$("#numero_documento").on("blur",function(){var e=$("#tipo_documento").val(),r=$("#numero_documento").val();return!!a(e,r)});var n=$("#tabla_personas").DataTable({processing:!0,ajax:base_url+"personas/consultarGrilla",columns:[{data:"tipo_docu"},{data:"nume_docu"},{data:"fecha_expe"},{data:"nombre"},{data:"jefe"},{data:"sexo"},{data:"edad"},{data:"opciones"}],language:{url:base_url+"assets/plugins/DataTables/datatables.locale-es.json"},paging:!1,pageLength:100,bFilter:!0,ordering:!0,responsive:!0,searching:!1,info:!1});$("#frmHogar").validate({errorClass:"error-form",rules:{tipo_documento:{selectVacio:!0},numero_documento:{required:!0,validaRC:["tipo_documento"],validaTI:["tipo_documento"],validaCC:["tipo_documento"],validaCE:["tipo_documento"]},anio_expe:{validarCamposFecha:["tipo_documento"],validarFecha:["anio_expe","mes_expe","dia_expe"]},mes_expe:{validarCamposFecha:["tipo_documento"],validarFecha:["anio_expe","mes_expe","dia_expe"]},dia_expe:{validarCamposFecha:["tipo_documento"],validarFecha:["anio_expe","mes_expe","dia_expe"]},primer_nombre:{required:!0,maxlength:30},segundo_nombre:{maxlength:30},primer_apellido:{required:!0,maxlength:30},segundo_apellido:{maxlength:30},sexo_persona:{selectVacio:!0},edad_persona:{required:!0,validarEdadTI:["edad_persona","tipo_documento"],validarEdadCC:["edad_persona","tipo_documento"],mayor121:!0,jefeMenorEdad:["edad_persona","jefe_hogar"]},jefe_hogar:{required:!0,jefeMenorEdad:["edad_persona","jefe_hogar"]}},messages:{tipo_documento:{selectVacio:"ERROR: Selecciona el tipo de identificación de la persona."},numero_documento:{required:"ERROR: Digite el número de documento de la persona.",validaRC:"ERROR: La longitud del número de documento debe ser entre 3 a 10 caracteres.",validaTI:"ERROR: La longitud del número de documento debe ser  entre 2 a 12 caracteres.",validaCC:"ERROR: La longitud del número de documento debe ser entre 2 a 10 caracteres.",validaCE:"ERROR: El documento debe tener entre 2 a 10 dígitos y/o caracteres."},anio_expe:{validarCamposFecha:"ERROR: Seleccione el año de la fecha de expedición.",validarFecha:"ERROR: La fecha de expedición definida no es válida."},mes_expe:{validarCamposFecha:"ERROR: Seleccione el mes de la fecha de expedición.",validarFecha:"ERROR: La fecha de expedición definida no es válida."},dia_expe:{validarCamposFecha:"ERROR: Seleccione el día de la fecha de expedición.",validarFecha:"ERROR: La fecha de expedición definida no es válida."},primer_nombre:{required:"ERROR: Digite el primer nombre de la persona.",maxlength:"ERROR: El primer nombre no debe tener más de 30 caracteres."},segundo_nombre:{maxlength:"ERROR: El segundo nombre no debe tener más de 30 caracteres."},primer_apellido:{required:"ERROR: Digite el primer apellido de la persona.",maxlength:"ERROR: El segundo apellido no debe tener más de 30 caracteres."},segundo_apellido:{maxlength:"ERROR: El segundo apellido no debe tener más de 30 caracteres."},sexo_persona:{selectVacio:"ERROR: Selecciona el sexo de la persona."},edad_persona:{required:"ERROR: Digite la edad de la persona.",validarEdadTI:"ERROR: La persona con tarjeta de identidad debe ser mayor a 7 años",validarEdadCC:"ERROR: La persona con cédula de ciudadanía debe ser mayor a 18 años",mayor121:"ERROR: La edad no debe ser mayor de 121 años.",jefeMenorEdad:"ERROR: No puede ser jefe(a) del hogar si es menor de 10 años."},jefe_hogar:{required:"ERROR: Seleccione si la persona es o no jefe de hogar.",jefeMenorEdad:"ERROR: No puede ser jefe(a) del hogar si es menor de 10 años."}},onfocusout:function(e){$(e).valid()||$("#"+$(e).attr("id")).focus()},errorPlacement:function(e,a){$(a).parents(".form-group").first().append(e.attr("role","alert"))},highlight:function(e,a,r){$(e).parents(".form-group").first().addClass("has-error")},unhighlight:function(e,a,r){$(e).parents(".form-group").first().removeClass("has-error")},submitHandler:function(e){return!1}}),$("#btnGuardarPersona").on("click",function(){if(1==$("#frmHogar").valid()){var a=$("#frmHogar").serialize(),r=$("#hdnAccion").val(),o=$("#idEditar").val();$.ajax({url:base_url+"personas/persona/guardarPersona",type:"POST",dataType:"json",data:a+"&accion="+r+"&id="+o,beforeSend:function(){$("#animationload").fadeIn()},complete:function(){$("#animationload").fadeOut()}}).done(function(a){0==a.codiError?(n.ajax.reload(),$("#frmHogar").find("input,select").not("[type=hidden]").val("").prop({disabled:!1}),$("#hdnAccion").val("agregar"),$("#idEditar").val(""),$("#btnGuardarPersona").html("Agregar"),$("html, body").animate({scrollTop:0},600)):(e.setTitle("Error al guardar la persona"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(a.mensaje),e.open())}).fail(function(a){e.setTitle("Error al guardar la persona"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(a.responseText),e.open()})}}),$("#btnLimpiarPersona").on("click",function(){$(this).parents("form").find("input,select").not("[type=hidden]").val("").prop({disabled:!1}),$("#hdnAccion").val("agregar"),$("#idEditar").val(""),$("#btnGuardarPersona").html("Agregar residente"),$("html, body").animate({scrollTop:0},600)}),$("#tabla_personas").on("click",".editarPersona",function(){$(this).parents("form").find("input,select").not("[type=hidden]").val("");var a=$(this);$.ajax({url:base_url+"personas/persona/consultarPersona",type:"POST",dataType:"json",data:{idPers:a.data("idpers")}}).done(function(r){0==r.codiError?($.each(r.form,function(e,a){$("#"+e).val(a),""!=r.registro&&"jefe_hogar"!=e?$("#"+e).prop("disabled",!0):$("#"+e).prop("disabled",!1)}),$("html, body").animate({scrollTop:0},600),3==r.form.tipo_documento&&$("#fecha_expe-col").removeClass("hidden"),$("#hdnAccion").val("editar"),$("#idEditar").val(a.data("idpers")),$("#btnGuardarPersona").html("Guardar cambios")):(e.setTitle("Error al consultar la persona"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(r.mensaje),e.open())}).fail(function(e){window.location.href=base_url+"hogar"})}),$("#tabla_personas").on("click",".eliminarPersona",function(){if(n.data().count()<=1)return e.setTitle("Borrar persona"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage("Debe existir mínimo una persona."),e.open(),!1;var a=$(this);BootstrapDialog.show({title:"Borrar persona",message:"¿Está seguro que quiere borrar a la persona seleccionada?",type:BootstrapDialog.TYPE_WARNING,closable:!1,buttons:[{label:"Cancelar",cssClass:"btn-warning",action:function(e){e.close()}},{label:"Aceptar",cssClass:"btn-success",action:function(r){$.ajax({url:base_url+"personas/persona/eliminarPersona",type:"POST",dataType:"json",data:{idPers:a.data("idpers")}}).done(function(a){0==a.codiError?(n.ajax.reload(),r.close()):(e.setTitle("Error al eliminar la persona"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(a.mensaje),e.open())}).fail(function(a){e.setTitle("Error al eliminar la persona"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(a.responseText),e.open()})}}]})}),$("#btnSiguiente").on("click",function(){$("#divContent").addClass("hidden");var e="<ul>";$.each(n.rows().data(),function(a,r){e+="<li>"+r.nombre+"</li>"}),e+="</ul>",$("#lblPersonsList").html(e),$("#mensajeConfirmacion").removeClass("hidden")}),$("#btnAnteriorConfirmacion").on("click",function(){$("#divContent").removeClass("hidden"),$("#mensajeConfirmacion").addClass("hidden")}),$("#btnSiguienteConfirmacion").on("click",function(){$(".error-form").addClass("hidden");var e=n.data().count();$.ajax({url:base_url+"hogar/guardar",type:"POST",dataType:"json",data:"numero_personas="+e+"&duracion="+duracionPagina(),beforeSend:function(){$("#msgSuccessConfirm").html("Guardando las respuestas..."),$("#divMsgConfirm").removeClass("hidden"),$("#divMsgSuccessConfirm").removeClass("hidden")}}).done(function(e){0==e.codiError?($(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$("#msgSuccessConfirm").html(e.mensaje),$("#divMsgConfirm").removeClass("hidden"),$("#divMsgSuccessConfirm").removeClass("hidden"),$("#progressbar").html(e.avance+"% COMPLETADO").css("width",e.avance+"%"),setTimeout(recargar,2e3)):($("#msgErrorConfirm").html(e.mensaje),$("#divMsgConfirm").removeClass("hidden"),$("#divMsgAlertConfirm").removeClass("hidden"))}).fail(function(e){window.location.href=base_url+"hogar"})}),$("#btnAnterior").on("click",function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"hogar/regresar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(e){0==e.codiError?($("#progressbar").html(e.avance+"% COMPLETADO").css("width",e.avance+"%"),window.location.href=base_url+"hogar"):($("#msgError").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(e){window.location.href=base_url+"hogar"})})});