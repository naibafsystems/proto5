$(function(){redirectBrowser(),$(window).scroll(function(){$(this).scrollTop()>400?$(".scrollup").fadeIn():$(".scrollup").fadeOut()}),$(".scrollup").on("click",function(){return $("html, body").animate({scrollTop:0},600),!1});var a=(new BootstrapDialog({title:"Instancia del dialogo",message:"Mensaje generico"}),$("#tablaSolicitudes").DataTable({processing:!0,ajax:base_url+"soporte/verSolicitudes/S",columns:[{data:"tipo"},{data:"respuesta"},{data:"observacion"}],language:{url:base_url+"assets/plugins/DataTables/datatables.locale-es.json"},paging:!0,pageLength:50,bFilter:!0,bInfo:!1,ordering:!1,responsive:!0,searching:!1,info:!1}));$.fn.buscarSolicitudes=function(){for(var e=generarURLserialize("formSolicitudes"),o=0;o<e.length;o++)isNaN(e[o])&&e[o].indexOf("%2F")>0&&(e[o]=formatearFecha(e[o]));$("#btnBuscar").button("loading"),a.ajax.url(base_url+"soporte/verSolicitudes/S/"+e.join("/")).load()},$("#formSolicitudes").on("submit",function(a){a.preventDefault(),$(this).buscarSolicitudes()}),$("#tablaSolicitudes").on("draw.dt",function(){$("#btnBuscar").button("reset")})});