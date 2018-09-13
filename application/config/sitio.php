<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//Configura el texto para el title del sitio
$config['nombreEntidad'] = "Departamento Administrativo Nacional de Estadística - DANE";

//Configura el texto para el title del sitio
$config['titulo'] = "Censo Nacional";

//Configura el texto para el title del sitio
$config['subtitulo'] = "de Población y Vivienda";

//Configura el nombre abreviado del sistema
$config['nombreSistema'] = "eCenso";

//Configura el nombre del sitio
$config['header'] = "Sistema";

// Nombre de dependencia
$config['dependencia'] = "Oficina de Sistemas";

//Texto para el footer del sitio
$config['footer'] = "<p>DANE: Carrera 59 No. 26-70 Interior I - CAN. Conmutador (571) 5978300 - Fax (571) 5978399<br/>L&iacute;nea gratuita de atenci&oacute;n 01-8000-912002. &oacute; (571) 5978300 Exts. 2532 - 2605</p>";

// Buzon de correo para la oficina
$config['correoContacto'] = "ecenso@dane.gov.co";

// Define el tipo de formuario que se va a mostrar [E Extendido; A Ampliado; B Básico; G Basico alterno; H 58P]
//$config['tipoFormulario'] = 'E';
//$config['tipoFormulario'] = 'A';
//$config['tipoFormulario'] = 'B';
//$config['tipoFormulario'] = 'G';
$config['tipoFormulario'] = 'H';

//Configuracion de fechas de inicio y fin del diligenciamiento del formulario
$config["diligenciamiento"]["fechaIni"] = "2017-01-01"; //"2016-03-01"
$config["diligenciamiento"]["fechaFin"] = "2018-03-15"; //"2016-03-19"

// Configuracion del servidor de correo
//$config['smtp_host'] = '192.168.1.98';
//$config['smtp_host'] = '192.168.0.109';
$config['smtp_host'] = 'mail.dane.gov.co';
$config['smtp_port'] = '25';
//$config['smtp_port'] = '465';
$config['smtp_crypto'] = 'tls';
//$config['smtp_crypto'] = 'ssl';
$config['smtp_user'] = 'aplicaciones@dane.gov.co';
//$config['smtp_user'] = 'ecenso@dane.gov.co';
$config['smtp_pass'] = 'Ou67UtapW3v';
//$config['smtp_pass'] = 'C01DNT';

$config['redis_scheme'] = 'tcp';
//$config['redis_host'] = '127.0.0.1';
$config['redis_host'] = '127.0.0.1';
$config['redis_port'] = '6379';
$config['redis_password'] = 'M6YlPcCe6uDZx4c';
$config['redis_timeout'] = '43200'; // 12 horas, por defecto 24 horas
$config['redis_database'] = '2';
if ($_SERVER['HTTP_HOST'] == 'cnpv4.dane.gov.co') {
	$config['redis_password'] = '9aj2#59Ftc35';
}
$config['redis_dominios'] = '1,2,3,26,27,38,43,44,45,92,93,94,95,97,98,901,914';

$config['UID_ORIGEN_DMC_WEB'] = 18;