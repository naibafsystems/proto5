function recargar(){window.location.href=base_url+"hogar"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1}),$('[data-tooltip!=""]').qtip({content:{attr:"data-tooltip"},position:{my:"top left"},style:{classes:"qtip-bootstrap qtip-DANE"}});new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"});$.validator.addMethod("mayorNumeroCuartos",function(r,e,a){var o=$("#numero_cuartos").val(),s=$("#numero_dormitorios").val();return o.length>0&&!isNaN(o)&&s.length>0&&!isNaN(s)&&parseInt(s)<=parseInt(o)}),$("#frmHogar").validate({errorClass:"error-form",rules:{numero_cuartos:{required:!0,min:1},numero_dormitorios:{required:!0,min:1,mayorNumeroCuartos:!0}},messages:{numero_cuartos:{required:"ERROR: Debe seleccionar una de las opciones del hogar.",min:"ERROR: EL valor debe ser mayor a cero."},numero_dormitorios:{required:"ERROR: Debe seleccionar una de las opciones del hogar.",min:"ERROR: El valor debe ser mayor a cero.",mayorNumeroCuartos:"ERROR: la cantidad de cuartos para dormir debe ser menor o igual a la cantidad de cuartos disponibles."}},onfocusout:function(r){$(r).valid()||$("#"+$(r).attr("id")).focus()},errorPlacement:function(r,e){$(e).parents(".form-group").first().append(r.attr("role","alert"))},highlight:function(r,e,a){$(r).parents(".form-group").first().addClass("has-error")},unhighlight:function(r,e,a){$(r).parents(".form-group").removeClass("has-error")},submitHandler:function(r){return!0}}),$("#btnSiguiente").on("click",function(){if($(".alert").addClass("hidden"),1==$("#frmHogar").valid()){var r=$("#frmHogar").serialize();$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"hogar/guardar",type:"POST",dataType:"json",data:r+"&duracion="+duracionPagina(),beforeSend:function(){$("#msgSuccess").html("Guardando la(s) respuesta(s). Espere por favor..."),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden")}}).done(function(r){0==r.codiError?($("#msgSuccess").html(r.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden"),$("#progressbar").html(r.avance+"% COMPLETADO").css("width",r.avance+"%"),setTimeout(recargar,2e3)):($("#msgError").html(r.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(r){window.location.href=base_url+"hogar"})}}),$("#btnAnterior").on("click",function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"hogar/regresar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(r){0==r.codiError?($("#progressbar").html(r.avance+"% COMPLETADO").css("width",r.avance+"%"),window.location.href=base_url+"hogar"):($("#msgError").html(r.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(r){window.location.href=base_url+"hogar"})})});