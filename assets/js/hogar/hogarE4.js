function recargar(){window.location.href=base_url+"hogar"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1}),$('[data-tooltip!=""]').qtip({content:{attr:"data-tooltip"},position:{my:"top left"},style:{classes:"qtip-bootstrap qtip-DANE"}});new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"});$("input[type=radio][name=hogar_economica]").on("change",function(){1==$(this).val()?($("#cual_economica-col").removeClass("hidden"),$("#cuantas_economica-col").removeClass("hidden")):($("#cual_economica-col").addClass("hidden"),$("#cuantas_economica-col").addClass("hidden"),$("input[name=cual_economica]").prop("checked",!1),$("#cuantas_economica").val(""))}),$("#frmHogar").validate({errorClass:"error-form",rules:{hogar_economica:{required:!0},cual_economica:{required:!0},cuantas_economica:{required:!0}},messages:{hogar_economica:{required:"Debes seleccionar una de las opciones del hogar."},cual_economica:{required:"Debes seleccionar una de las opciones del hogar."},cuantas_economica:{required:"Debes seleccionar una de las opciones del hogar."}},onfocusout:function(a){$(a).valid()||$("#"+$(a).attr("id")).focus()},errorPlacement:function(a,e){$(e).parents(".form-group").first().append(a.attr("role","alert"))},highlight:function(a,e,o){$(a).parents(".form-group").first().addClass("has-error")},unhighlight:function(a,e,o){$(a).parents(".form-group").first().removeClass("has-error")},submitHandler:function(a){return!0}}),$("#btnSiguiente").on("click",function(){if($(".alert").addClass("hidden"),1==$("#frmHogar").valid()){var a=$("#frmHogar").serialize();$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"hogar/guardar",type:"POST",dataType:"json",data:a+"&duracion="+duracionPagina(),beforeSend:function(){$("#msgSuccess").html("Guardando las respuestas..."),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden")}}).done(function(a){0==a.codiError?($("#msgSuccess").html(a.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden"),$("#progressbar").html(a.avance+"% COMPLETADO").css("width",a.avance+"%"),setTimeout(recargar,2e3)):($("#msgError").html(a.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(a){window.location.href=base_url+"hogar"})}}),$("#btnAnterior").on("click",function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"hogar/regresar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(a){0==a.codiError?($("#progressbar").html(a.avance+"% COMPLETADO").css("width",a.avance+"%"),window.location.href=base_url+"hogar"):($("#msgError").html(a.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(a){window.location.href=base_url+"hogar"})})});