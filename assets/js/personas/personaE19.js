function recargar(){window.location.href=base_url+"personas/persona"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1}),$('[data-tooltip!=""]').qtip({content:{attr:"data-tooltip"},position:{my:"top left"},style:{classes:"qtip-bootstrap qtip-DANE"}});new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"});$("#nombreDificultad2").text().length>0&&$(".nombre-dificultad").html($("#nombreDificultad2").text()),$("#limitacion_principal-col").html()&&$("input[type=radio][name=limitacion_principal]").is(":checked"),$("input[type=radio][name=limitacion_principal]").on("change",function(){$("#ayudas_permanentes-col").removeClass("hidden"),$("#ayuda_tecnica-col").removeClass("hidden"),$("#ayuda_personas-col").removeClass("hidden"),$("#ayuda_medicamentos-col").removeClass("hidden"),$("#ayuda_practicas-col").removeClass("hidden"),$(".nombre-dificultad").html($(this).parents(".radio").text().toLowerCase())}),$("input[type=radio][name=causa_limitacion]").on("change",function(){0==$(this).val()?($("#ayudas_permanentes-col").addClass("hidden"),$("#ayuda_tecnica-col").addClass("hidden"),$("#ayuda_personas-col").addClass("hidden"),$("#ayuda_medicamentos-col").addClass("hidden"),$("#ayuda_practicas-col").addClass("hidden")):($("#ayudas_permanentes-col").removeClass("hidden"),$("#ayuda_tecnica-col").removeClass("hidden"),$("#ayuda_personas-col").removeClass("hidden"),$("#ayuda_medicamentos-col").removeClass("hidden"),$("#ayuda_practicas-col").removeClass("hidden"))}),$("#frmPersona").validate({errorClass:"error-form",rules:{limitacion_principal:{required:!0},causa_limitacion:{required:!0}},messages:{limitacion_principal:{required:"ERROR: Debe seleccionar la dificultad que más afecta el desempeño diario a la persona."},causa_limitacion:{required:"ERROR: Debe seleccionar la causa de la dificultad que más afecta a la persona."}},onfocusout:function(a){$(a).valid()||$("#"+$(a).attr("id")).focus()},errorPlacement:function(a,e){$(e).parents(".form-group").first().append(a.attr("role","alert"))},highlight:function(a,e,s){$(a).parents(".form-group").first().addClass("has-error")},unhighlight:function(a,e,s){$(a).parents(".form-group").first().removeClass("has-error")},submitHandler:function(a){return!0}}),$("#btnSiguiente").on("click",function(){if($(".alert").addClass("hidden"),1==$("#frmPersona").valid()){var a=$("#frmPersona").serialize();$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"personas/persona/guardar",type:"POST",dataType:"json",data:a+"&numePers="+$("#frmPersona").data("nume_pers")+"&duracion="+duracionPagina(),beforeSend:function(){$("#msgSuccess").html("Guardando la(s) respuesta(s). Espere por favor..."),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden")}}).done(function(a){0==a.codiError?($("#msgSuccess").html(a.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden"),$("#progressbar").html(a.avance+" COMPLETADO").css("width",a.avance),setTimeout(recargar,2e3)):($("#msgError").html(a.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(a){window.location.href=base_url+"persona"})}}),$("#btnAnterior").on("click",function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"personas/persona/regresar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(a){0==a.codiError?($("#progressbar").html(a.avance+" COMPLETADO").css("width",a.avance),window.location.href=base_url+"personas/persona"):($("#msgError").html(a.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(a){window.location.href=base_url+"persona"})})});