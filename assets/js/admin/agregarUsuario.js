function recargar(){window.location.href=base_url+"admin/inicio"}$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1});var e=new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"});$("#nombre1Pers").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#nombre2Pers").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#apellido1Pers").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#apellido2Pers").soloNombre().maxlength(30).convertirMayuscula().verificaEspacios(),$("#formUsuario").validate({errorClass:"error-form",rules:{nombre1Pers:{required:!0},apellido1Pers:{required:!0},usuario:{required:!0,emailValido2:!0},tipo:{selectVacio:!0},contrasena1:{required:!0,maxlength:20,minlength:8,validarPass:!0},contrasena2:{required:!0,maxlength:20,minlength:8,validarPass:!0,equalTo:"#contrasena1"}},messages:{nombre1Pers:{required:"Digite el primer nombre del usuario."},apellido1Pers:{required:"Digite el primer apellido del usuario."},usuario:{required:"Digite un correo electrónico válido.",validarEmail:"El correo electrónico ya esta registrado en el sistema"},tipo:{selectVacio:"Seleccione el tipo de usuario."},contrasena1:{required:"Digite una contraseña válida.",maxlength:"La contraseña debe ser máximo de {0} caracteres.",minlength:"La contraseña debe ser mínimo de {0} caracteres."},contrasena2:{required:"Digite una contraseña válida.",maxlength:"La contraseña debe ser máximo de {0} caracteres.",minlength:"La contraseña debe ser mínimo de {0} caracteres.",equalTo:"La segunda contraseña debe ser igual a la primera contraseña."}},focusCleanup:!0,onfocusout:function(e){$(e).valid()||$("#"+$(e).attr("id")).focus()},errorPlacement:function(e,r){r.after(e.attr("role","alert"))},highlight:function(e,r,a){$(e).parent().addClass("has-error")},unhighlight:function(e,r,a){$(e).parent().removeClass("has-error")},submitHandler:function(e){return!0}}),$("#btnAgregar").click(function(){if(!0===$("#formUsuario").valid()){var r=$("#formUsuario").serialize();$.ajax({url:base_url+"usuarios/agregar",type:"POST",dataType:"json",data:r}).done(function(e){0===e.codiError?($("#msgSuccess").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgSuccess").removeClass("hidden"),setTimeout(recargar,2e3)):($("#msgError").html(e.mensaje),$("#divMsg").removeClass("hidden"),$("#divMsgAlert").removeClass("hidden"))}).fail(function(r){e.setTitle("Error al guardar"),e.setType(BootstrapDialog.TYPE_DANGER),e.setMessage(r.responseText),e.open()})}})});