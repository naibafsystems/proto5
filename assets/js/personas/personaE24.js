function recargar(){window.location.href=base_url+"personas/persona"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1}),$('[data-tooltip!=""]').qtip({content:{attr:"data-tooltip"},position:{my:"top left"},style:{classes:"qtip-bootstrap qtip-DANE"}});new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"});$("input[type=radio][name=trabajo]").on("change",function(){1==$(this).val()||2==$(this).val()?($("#donde_trabajo-col").removeClass("hidden"),$("#tipo_trabajo-col").removeClass("hidden")):($("#donde_trabajo-col").addClass("hidden"),$("#tipo_trabajo-col").addClass("hidden"),$("input[name=donde_trabajo]").prop("checked",!1),$("input[name=tipo_trabajo]").prop("checked",!1))}),$("#frmPersona").validate({errorClass:"error-form",rules:{trabajo:{required:!0},donde_trabajo:{required:!0},tipo_trabajo:{required:!0}},messages:{trabajo:{required:"ERROR: Debe seleccionar que hizo la semana pasada la persona."},donde_trabajo:{required:"ERROR: Debe seleccionar a qué se dedica principalmente donde la persona trabajó."},tipo_trabajo:{required:"ERROR: Debe seleccionar el tipo de trabajador de la persona."}},onfocusout:function(e){$(e).valid()||$("#"+$(e).attr("id")).focus()},errorPlacement:function(e,a){$(a).parents(".form-group").first().append(e.attr("role","alert"))},highlight:function(e,a,r){$(e).parents(".form-group").first().addClass("has-error")},unhighlight:function(e,a,r){$(e).parents(".form-group").first().removeClass("has-error")},submitHandler:function(e){return!0}}),$("#btnSiguiente").on("click",function(){if($(".alert").addClass("hidden"),1==$("#frmPersona").valid()){$(this).addClass("disabled").prop("disabled",!0);var e=$("#frmPersona").serialize();$.ajax({url:base_url+"personas/persona/guardar",type:"POST",dataType:"json",data:e+"&numePers="+$("#frmPersona").data("nume_pers")+"&duracion="+duracionPagina(),beforeSend:function(){$("#msgSuccess").html("Guardando la(s) respuesta(s). Espere por favor..."),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden")}}).done(function(e){0==e.codiError?($("#msgSuccess").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden"),$("#progressbar").html(e.avance+" COMPLETADO").css("width",e.avance),setTimeout(recargar,2e3)):($("#msgError").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(e){window.location.href=base_url+"persona"})}}),$("#btnAnterior").on("click",function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"personas/persona/regresar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(e){0==e.codiError?($("#progressbar").html(e.avance+" COMPLETADO").css("width",e.avance),window.location.href=base_url+"personas/persona"):($("#msgError").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(e){window.location.href=base_url+"persona"})})});