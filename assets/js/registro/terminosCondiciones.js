function recargar(){window.location.href=base_url+"registro"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1});var e=new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"});$("#btnNoAcepto").click(function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$(location).attr("href",base_url+"registro/noAcepto")}),$("#btnAcepto").on("click",function(){$(".alert").addClass("hidden"),$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"registro/guardar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(e){0==e.codiError?($("#msgSuccess").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden"),$("#progressbar").html(e.avance+"% COMPLETADO").css("width",e.avance+"%"),setTimeout(recargar,2e3)):BootstrapDialog.show({title:"Alerta",message:e.mensaje,closable:!1,buttons:[{label:"Aceptar",action:function(e){$(location).attr("href",base_url+"/registro")}}]})}).fail(function(a){e.setTitle("Error al guardar"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(a.responseText),e.open()})}),$("#btnAnterior").on("click",function(){$(":input").addClass("disabled").prop("disabled",!0),$(":button").addClass("disabled").prop("disabled",!0),$.ajax({url:base_url+"registro/regresar",type:"POST",dataType:"json",data:"duracion="+duracionPagina()}).done(function(e){0==e.codiError?($("#progressbar").html(e.avance+"% COMPLETADO").css("width",e.avance+"%"),window.location.href=base_url+"registro"):($("#msgError").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(a){e.setTitle("Error al regresar"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(a.responseText),e.open()})})});