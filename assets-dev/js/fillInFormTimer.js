/**
 * Funciones para el control de tiempo del diligenciamiento del formulario
 * @author dmdiazf
 * @since  2016-01-22
 **/

var timer = new Date();
var horaIni = new Date(timer.getFullYear(), timer.getMonth(), timer.getDate(),  timer.getHours(), timer.getMinutes(), timer.getSeconds());
var horaFin = null;

$(function(){
	window.setInterval(setHoraFin, 1000); //cada segundo

	function setHoraFin() { 
		//Calcular la diferencia entre horas
		var timer = new Date();
		horaFin = new Date(timer.getFullYear(), timer.getMonth(), timer.getDate(),  timer.getHours(), timer.getMinutes(), timer.getSeconds());
	}
});

var duracionPagina = function() {
	var duracion = 0;
	var diff = horaFin - horaIni;
	var msec = diff;
	var hh = Math.floor(msec / 1000 / 60 / 60);
	msec -= hh * 1000 * 60 * 60;
	var mm = Math.floor(msec / 1000 / 60);
	msec -= mm * 1000 * 60;
	var ss = Math.floor(msec / 1000);
	msec -= ss * 1000;
	duracion = hh + ':' + mm + ':' + ss;
	return duracion;
};