function recargar(){window.location.href=base_url+"personas/persona"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1}),$('[data-tooltip!=""]').qtip({content:{attr:"data-tooltip"},position:{my:"top left"},style:{classes:"qtip-bootstrap qtip-DANE"}});new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"});$("input[type=radio][name=condicion]").on("change",function(){1==$(this).val()?$("#limitacion_oir-col").removeClass("hidden"):2==$(this).val()&&($("#limitacion_oir-col").addClass("hidden"),$("input[name=limitacion_oir]").prop("checked",!1))}),$("#frmPersona").validate({errorClass:"error-form",rules:{limitacion_oir:{required:!0}},messages:{limitacion_oir:{required:"ERROR: Debe seleccionar si la persona tiene dificultad para oír la voz o los sonidos."}},onfocusout:function(e){$(e).valid()||$("#"+$(e).attr("id")).focus()},errorPlacement:function(e,a){$(a).parents(".form-group").first().append(e.attr("role","alert"))},highlight:function(e,a,r){$(e).parents(".form-group").first().addClass("has-error")},unhighlight:function(e,a,r){$(e).parents(".form-group").first().removeClass("has-error")},submitHandler:function(e){return!0}}),$("#btnSiguiente").on("click",function(){if($(".alert").addClass("hidden"),1==$("#frmPersona").valid()){var e=$("#frmPersona").serialize();$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"personas/persona/guardar",type:"POST",dataType:"json",data:e+"&numePers="+$("#frmPersona").data("nume_pers")+"&duracion="+duracionPagina(),beforeSend:function(){$("#msgSuccess").html("Guardando la(s) respuesta(s). Espere por favor..."),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden")}}).done(function(e){0==e.codiError?($("#msgSuccess").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden"),$("#progressbar").html(e.avance+" COMPLETADO").css("width",e.avance),setTimeout(recargar,2e3)):($("#msgError").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(e){window.location.href=base_url+"persona"})}}),$("#btnAnterior").on("click",function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"personas/persona/regresar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(e){0==e.codiError?($("#progressbar").html(e.avance+" COMPLETADO").css("width",e.avance),window.location.href=base_url+"personas/persona"):($("#msgError").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(e){window.location.href=base_url+"persona"})})});