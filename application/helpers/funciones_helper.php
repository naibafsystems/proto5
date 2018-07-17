<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author oagarzond
 * @param	String	$ruta	Ruta relativa
 * @return	Ruta absoluta deseada
 */
if (!function_exists("base_dir")) {

    function base_dir($ruta = '') {
        return FCPATH . $ruta;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta	Ruta relativa
 * @return	Ruta absoluta deseada
 */
if (!function_exists("base_app")) {

    function base_app($ruta = '') {
        return APPPATH . $ruta;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo
 * @return	Ruta absoluta del archivo deseado
 */
if (!function_exists("base_dir_plugins")) {

    function base_dir_plugins($ruta_archivo = '') {
        $dir = FCPATH . 'assets/plugins/';
        // $dir = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/plugins/';
        if (strlen($ruta_archivo) > 0) {
            $dir .= $ruta_archivo;
        }
        return $dir;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo
 * @return	URL absoluta del archivo deseado
 */
if (!function_exists("base_url_plugins")) {

    function base_url_plugins($ruta_archivo = '') {
        $CI = & get_instance();
        $url = $CI->config->base_url('assets/plugins/');
        // $url = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/plugins/';
        if (strlen($ruta_archivo) > 0) {
            $url .= $ruta_archivo;
        }
        return $url;
    }

}


/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo
 * @return	Ruta absoluta del archivo deseado
 */
if (!function_exists("base_dir_css")) {

    function base_dir_css($ruta_archivo = '') {
        $CI = & get_instance();
        $dir = FCPATH . 'assets/css/';
        if(!empty(ENVIRONMENT) && (ENVIRONMENT === 'dev' || ENVIRONMENT === 'hotfix')) {
            $dir = FCPATH . 'assets-dev/css/';
        }
        // $dir = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/css/';
        if (strlen($ruta_archivo) > 0) {
            $dir .= $ruta_archivo;
        }
        return $dir;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo
 * @return	URL absoluta del archivo deseado
 */
if (!function_exists("base_url_css")) {

    function base_url_css($ruta_archivo = '') {
        $CI = & get_instance();
        $url= $CI->config->base_url('assets/css/');
        if(!empty(ENVIRONMENT) && (ENVIRONMENT === 'dev' || ENVIRONMENT === 'hotfix')) {
            $url= $CI->config->base_url('assets-dev/css/');
        }
        // $url = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/css/';
        if (strlen($ruta_archivo) > 0) {
            $url .= $ruta_archivo;
        }
        return $url;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo
 * @return	Ruta absoluta del archivo deseado
 */
if (!function_exists("base_dir_js")) {

    function base_dir_js($ruta_archivo = '') {
        $dir = FCPATH . 'assets/js/';
        if(!empty(ENVIRONMENT) && (ENVIRONMENT === 'dev' || ENVIRONMENT === 'hotfix')) {
            $dir = FCPATH . 'assets-dev/js/';
        }
        // $dir = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/js/';
        if (strlen($ruta_archivo) > 0) {
            $dir .= $ruta_archivo;
        }
        return $dir;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo
 * @return	URL absoluta del archivo deseado
 */
if (!function_exists("base_url_js")) {

    function base_url_js($ruta_archivo = '') {
        $CI = & get_instance();
        $url = $CI->config->base_url('assets/js/');
        if(!empty(ENVIRONMENT) && (ENVIRONMENT === 'dev' || ENVIRONMENT === 'hotfix')) {
            $url= $CI->config->base_url('assets-dev/js/');
        }
        // $url = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/js/';
        if (strlen($ruta_archivo) > 0) {
            $url .= $ruta_archivo;
        }
        return $url;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_imagen	Ruta relativa con el nombre de la imagen y su extension
 * @return	Ruta absoluta de la imagen deseada
 */
if (!function_exists("base_dir_images")) {

    function base_dir_images($ruta_imagen = '') {
        $dir_images = FCPATH . 'assets/images/';
        // $dir_images = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/images/';
        if (strlen($ruta_imagen) > 0) {
            $dir_images .= $ruta_imagen;
        }
        return $dir_images;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_imagen	Ruta relativa con el nombre de la imagen y su extension
 * @return	URL absoluta de la imagen deseada
 */
if (!function_exists("base_url_images")) {

    function base_url_images($ruta_imagen = '') {
        $CI = & get_instance();
        $url_images = $CI->config->base_url('assets/images/');
        // $url_images = 'https://s3-us-west-1.amazonaws.com/danecolombia/resources/images/';
        if (strlen($ruta_imagen) > 0) {
            $url_images .= $ruta_imagen;
        }
        return $url_images;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	Ruta absoluta del archivo deseado
 */
if (!function_exists("base_dir_files")) {

    function base_dir_files($ruta_archivo = '') {
        $dir_files = FCPATH . 'files/';
        if (strlen($ruta_archivo) > 0) {
            $dir_files .= $ruta_archivo;
        }
        return $dir_files;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	URL absoluta del archivo deseado
 */
if (!function_exists("base_url_files")) {

    function base_url_files($ruta_archivo = '') {
        $CI = & get_instance();
        $url_files = $CI->config->base_url() . 'files/';
        if (strlen($ruta_archivo) > 0) {
            $url_files .= $ruta_archivo;
        }
        return $url_files;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	Ruta absoluta del archivo deseado
 */
if (!function_exists("base_dir_tmp")) {

    function base_dir_tmp($ruta_archivo = '') {
        //@todo: Se debe cambiar a tmp/ cuando este en servidor unix
        //@todo: Se debe cambiar a tmp\\ cuando este en servidor windows
        $dir_tmp = FCPATH . 'tmp/';
        if (strlen($ruta_archivo) > 0) {
            $dir_tmp .= $ruta_archivo;
        }
        return $dir_tmp;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	URL absoluta del archivo deseado
 */
if (!function_exists("base_url_tmp")) {

    function base_url_tmp($ruta_archivo = '') {
        $CI = & get_instance();
        $url_tmp = $CI->config->base_url() . 'tmp/';
        if (strlen($ruta_archivo) > 0) {
            $url_tmp .= $ruta_archivo;
        }
        return $url_tmp;
    }

}

if (!function_exists("validarSesion")) {

    function validarSesion() {
        $CI = & get_instance();
        $CI->load->helper("url");
        $CI->load->library("session");
        if (!$CI->session->userdata("auth")) {
            redirect('/login', 'refresh');
        }
    }

}

/**
 * Cargar controlador de otro modulo con PHP normal
 * e instanciar objeto de dicho controlador
 * @author oagarzond
 * @since 2016-03-11
 */
if (!function_exists('load_controller')) {

    function load_controller($module, $controller) {
        if (!file_exists(APPPATH . 'modules/' . $module . '/controllers/' . ucfirst(strtolower($controller)) . '.php')) {
            exit('Unable to locate the controller you have specified: ' . $model);
        }

        require_once(APPPATH . 'modules/' . $module . '/controllers/' . ucfirst(strtolower($controller)) . '.php');
        if (class_exists($controller, FALSE)) {
            $controller = new $controller();
            //$controller->$method();
            return $controller;
        } else {
            exit('Unable to open the controller you have specified: ' . $model);
        }
    }

}

/**
 * Cargar modelo de otro modulo con PHP normal
 * e instanciar objeto de dicho modelo
 * @author oagarzond
 * @since 2016-03-11
 */
if (!function_exists('load_model')) {

    function load_model($module, $model) {
        if (!file_exists(APPPATH . 'modules/' . $module . '/models/' . ucfirst(strtolower($model)) . '.php')) {
            exit('Unable to locate the model you have specified: ' . $model);
        }

        if (!@include(APPPATH . 'modules/' . $module . '/models/' . ucfirst(strtolower($model)) . '.php')) {
            exit("Failed to require " . APPPATH . 'modules/' . $module . '/models/' . ucfirst(strtolower($model)) . '.php');
        }

        if (class_exists($model, FALSE)) {
            $model = new $model();
            return $model;
        } else {
            exit('Unable to open the model you have specified: ' . $model);
        }
    }

}

/**
 * Imprimir arreglos de una forma mas legible
 * @author oagarzond
 * @param mixed $objVar Arreglo o cadena para mostrar por pantalla con formato
 */
if (!function_exists("pr")) {

    function pr($objVar) {
        echo "<div align='left'>";
        if (is_array($objVar) or is_object($objVar)) {
            echo "<pre>";
            print_r($objVar);
            echo "</pre>";
        } else {
            echo str_replace("\n", "<br>", $objVar);
        }
        echo "</div><hr>";
    }

}


/**
 * Convierte a mayuscula la primera letra de cada palabra de la frase
 * @author oagarzond
 * @param   String  $texto  Texto a convertir
 * @return  String  $texto
 */
if (!function_exists("mayuscula_inicial")) {

    function mayuscula_inicial($texto) {
        if (strlen($texto)) {
            $texto = strtolower($texto);
            if (substr_count($texto, "@") == 0) {
                if (substr_count($texto, ".")) {
                    $arrTexto = explode(".", $texto);
                    $texto = "";
                    foreach ($arrTexto as $indTexto => $valTexto) {
                        if (strlen($valTexto) > 0) {
                            $texto .= ucwords($valTexto) . ".";
                        }
                    }
                } else {
                    $texto = ucwords($texto);
                }
            }
        }
        return $texto;
    }

}

/**
 * Funci�n para validar si una fecha es valida.
 *
 * Esta funci�n se utiliza para validar si la fecha pasada por parametro es valida o no Ej. 2011-02-29 no es una fecha valida.
 * @author oagarzond
 * @param string $fecha     Cadena para validar en formato DD/MM/YYYY o YYYY-MM-DD
 * @return string Retorna la cadena formateada o escapada.
 */
if (!function_exists("es_fecha_valida")) {

    function es_fecha_valida($fecha) {
        if (!empty($fecha) && is_string($fecha)) {
            if (substr_count($fecha, "-") == 2) {
                $data = explode("-", $fecha);
                if (strlen($data[0]) != 4)
                    return false;
                return(@checkdate(intval($data[1]), intval($data[2]), intval($data[0])));
            }
            elseif (substr_count($fecha, "/") == 2) {
                $data = explode("/", $fecha);
                if (strlen($data[2]) != 4)
                    return false;
                return(@checkdate(intval($data[1]), intval($data[0]), intval($data[2])));
            }
        } else {
            return false;
        }
    }

}

/**
 * Valida si la fecha y hora pasada por parametro es valida o no Ej. 2011-02-29 34:00:67 no es una fecha valida
 * @author oagarzond
 * @param   String  $cadena cadena para validar en formato DD/MM/YYYY HH:MM:SS
 * @return  String  Retorna la cadena formateada o escapada
 */
if (!function_exists("es_fecha_hora_valida")) {

    function es_fecha_hora_valida($fechaHora) {
        if (strstr($fechaHora, "/") && strstr($fechaHora, ":")) {
            $temp = explode(" ", $fechaHora);
            $data = explode("/", $temp[0]);
            $tempo = explode(":", $temp[1]);
            if (strlen($data[2]) != 4)
                return false;
            else {
                if (checkdate(intval($data[1]), intval($data[0]), intval($data[2]))) {
                    if (intval($tempo[0]) >= 0 && intval($tempo[0]) <= 23) {
                        if (intval($tempo[1]) >= 0 && intval($tempo[1]) <= 59) {
                            if (intval($tempo[2]) >= 0 && intval($tempo[2]) <= 59) {
                                return true;
                            }
                            return false;
                        }
                        return false;
                    }
                    return false;
                }
                return false;
            }
        }
        return false;
    }

}


/**
 * Esta funcion se utiliza para darle formato a la fecha pasada por parametro,
 * es decir si se pasa el formato YYYY-MM-DD se retorna la fecha en formato DD/MM/YYYY y viceversa.
 * @author oagarzond
 * @param	date	$fecha	Fecha
 * @return	string	Retorna la fecha formateada o vacio si la fecha no es valida
 */
if (!function_exists("formatear_fecha")) {

    function formatear_fecha($fecha) {
        if (es_fecha_valida($fecha)) {
            if (strstr($fecha, "-")) {
                $data = explode("-", $fecha);
                return $data[2] . "/" . $data[1] . "/" . $data[0];
            } elseif (strstr($fecha, "/")) {
                $data = explode("/", $fecha);
                return $data[2] . "-" . $data[1] . "-" . $data[0];
            }
        } else
            return "";
    }

}

/**
 * Retorna el texto de una fecha a partir de una fecha valida
 * @author  oagarzond
 * @param   $fecha  String  Fecha al cual se va sumar los dias, debe estar en formato YYYY-MM-DD
 * @param   $dias   Integer Numero de dias que se van a sumar
 * @return  Fecha de venc. final o vacio si no se pudo sumar
 */
if (!function_exists("obtener_texto_fecha")) {

    function obtener_texto_fecha($fecha) {
        if (es_fecha_valida($fecha)) {
            $fechatexto = "";
            $unixMark = strtotime($fecha);
            $mes = intval(date("m", $unixMark));
            $textosMes = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
            foreach ($textosMes as $key => $value) {
                if ($key == $mes)
                    $mes = $textosMes[$key];
            }
            $fechatexto = date("d", $unixMark) . " de " . $mes . " de " . date("Y", $unixMark);
            return $fechatexto;
        }
    }

}

/**
 * Funcion para agregar los ceros en el dia y/o mes de la fecha
 * @author oagarzond
 * @param	$fecha	Texto de la fecha en formato YYYY-MM-DD o DD/MM/YYYY
 * @return	Fecha completa de logitud 10
 */
if (!function_exists("completar_fecha")) {

    function completar_fecha($fecha) {
        if (strlen($fecha) > 0) {
            if (strstr($fecha, "-")) {
                $data = explode("-", $fecha);
                return str_pad($data[0], 4, "0", STR_PAD_LEFT) . "-" . str_pad($data[1], 2, "0", STR_PAD_LEFT) . "-" . str_pad($data[2], 2, "0", STR_PAD_LEFT);
            } elseif (strstr($fecha, "/")) {
                $data = explode("/", $fecha);
                return str_pad($data[0], 2, "0", STR_PAD_LEFT) . "/" . str_pad($data[1], 2, "0", STR_PAD_LEFT) . "/" . str_pad($data[2], 4, "0", STR_PAD_LEFT);
            }
        }
    }

}

/**
 * Retorna el texto del mes
 * @author oagarzond
 * @param	$mes	Numero del mes que se quiere mostrar
 * @return	Nombre del mes
 */
if (!function_exists("obtener_texto_mes")) {

    function obtener_texto_mes($mes = 0) {
        $textosMes = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        foreach ($textosMes as $key => $value) {
            if ($key == $mes)
                $mes = $textosMes[$key];
        }
        return $mes;
    }

}

/**
 * Retorna el texto de una fecha a partir de una fecha valida
 * @author  oagarzond
 * @param   $fecha  String  Fecha al cual se va sumar los dias, debe estar en formato YYYY-MM-DD
 * @param   $dias   Integer Numero de dias que se van a sumar
 * @return  Fecha de venc. final o vacio si no se pudo sumar
 */
if (!function_exists("obtener_texto_dia_mes")) {

    function obtener_texto_dia_mes($fecha) {
        if (es_fecha_valida($fecha)) {
            $fechatexto = "";
            $unixMark = strtotime($fecha);
            $mes = intval(date("m", $unixMark));
            $textosMes = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
            foreach ($textosMes as $key => $value) {
                if ($key == $mes)
                    $mes = $textosMes[$key];
            }
            $fechatexto = date("d", $unixMark) . " de " . $mes;
            return $fechatexto;
        }
    }

}

/**
 * Obtiene el tipo y la descripcion del tipo de documento
 * @author oagarzond
 * @param	Int		codi_tipo_docu	Codigo del tipo de documento
 * @return	Array	tipo_docu		Tipo y descripcion del documento
 */
if (!function_exists("descripcion_tipo_docu")) {

    function descripcion_tipo_docu($codi_tipo_docu = 0) {
        $tipo_docu = array();
        if (!empty($codi_tipo_docu)) {
            switch ($codi_tipo_docu) {
                case "1":
                    $tipo_docu["tipo"] = "RC";
                    $tipo_docu["desc"] = "Registro Civil";
                    break;
                case "2":
                    $tipo_docu["tipo"] = "TI";
                    $tipo_docu["desc"] = "Tarjeta de Identidad";
                    break;
                case "3":
                    $tipo_docu["tipo"] = "CC";
                    $tipo_docu["desc"] = "C&eacute;dula de Ciudadan&aicute;a";
                    break;
                case "4":
                    $tipo_docu["tipo"] = "CE";
                    $tipo_docu["desc"] = "C&eacute;dula de Extranjer&iacute;a";
                    break;
                case "5":
                    $tipo_docu["tipo"] = "NT";
                    $tipo_docu["desc"] = "NT";
                    break;
            }
        }
        return $tipo_docu;
    }

}

if (!function_exists("descripcion_genero")) {

    function descripcion_genero($codi_genero = 0) {
        $desc_genero = "";
        if (!empty($codi_genero)) {
            switch ($codi_genero) {
                case "1": $desc_genero = "Hombre";
                    break;
                case "2": $desc_genero = "Mujer";
                    break;
            }
        }
        return $desc_genero;
    }

}

/**
 * Retorna el texto de los textos separados por comas, excepto el ultimo texto que se separa con una y
 * @author oagarzond
 * @param	$arr_val	Valores que se van a contatenar
 * @return	$str_val	Texto con los valores concatenados
 */
if (!function_exists("mostrar_texto_comas")) {

    function mostrar_texto_comas($arr_val) {
        $str_val = '';
        $total = count($arr_val);
        if ($total == 1)
            $str_val = $arr_val[0];
        else if ($total > 1) {
            foreach ($arr_val as $k => $v) {
                if ($k == 0) {
                    $str_val = $arr_val[$k];
                } else if ($k <= ($total - 2)) {
                    $str_val .= ", " . $arr_val[$k];
                } else if ($k == ($total - 1)) {
                    $str_val .= " y " . $arr_val[$k];
                }
            }
        }
        return $str_val;
    }

}

/**
 * Valida si la fecha es dia es habil
 * @author oagarzond
 * @param	String	fecha       Fecha que se va a validar
 * @param	Array	$festivos   Fechas festivos, debe estar en formato YYYY-MM-DD
 * @return	Bool    Es o no habil
 */
if (!function_exists("es_dia_habil")) {

    function es_dia_habil($fecha, $festivos = array()) {
        $es_habil = true;
        $num_dia = date("w", strtotime($fecha));
        // 0 - domingo, 6 - sabado
        if($num_dia == 0 || $num_dia == 6) {
            $es_habil = false;
        } else {
            if(in_array($fecha, $festivos)) {
                $es_habil = false;
            }
        }
        return $es_habil;
    }
}

/**
 * Retorna los dias habiles entre un rango de fechas
 * @author oagarzond
 * @param	String	fecha_ini		Fecha inicial, debe estar en formato YYYY-MM-DD
 * @param	String	fecha_fin		Fecha final, debe estar en formato YYYY-MM-DD
 * @return	Array	dias_habiles	Dias habiles entre el rango de fechas
 */
if (!function_exists("calcular_dias_habiles")) {

    function calcular_dias_habiles($fecha_ini, $fecha_fin, $dias_festivos = array()) {
        $dias_habiles = array();
        $num_dia = date("w", strtotime($fecha_ini));
        if ($num_dia != 0 && $num_dia != 6) {
            $dias_habiles[] = $fecha_ini;
        }
        if ($fecha_ini != $fecha_fin) {
            $fecha = $fecha_ini;
            while ($fecha != $fecha_fin) {
                $fecha = date("Y-m-d", strtotime("+1 day", strtotime($fecha)));
                $num_dia = date("w", strtotime($fecha));
                if (!in_array($fecha, $dias_festivos)) {
                    if ($num_dia != 0 && $num_dia != 6) {
                        $dias_habiles[] = $fecha;
                    }
                }
            }
        }
        return $dias_habiles;
    }

}

/**
 * Retorna el segundo y cuarto viernes de cada mes de ano
 * @author oagarzond
 * @param	Array	$anios	Anio(s) en que se va a buscar los viernes Perfetti
 * @return	Array	$dias	Viernes segundo y cuarto de cada mes del anio
 */
if (!function_exists("calcular_viernes_perfetti")) {

    function calcular_viernes_perfetti($anios) {
        $dias = array();
        foreach ($anios AS $iabio => $vanio) {
            for ($i = 1; $i <= 12; $i++) {
                $fecha = completar_fecha($vanio . "-" . $i . "-" . "1");
                $num_dia = date("w", strtotime($fecha));
                switch ($num_dia) {
                    case "0": // domingo
                        $dias[] = date("Y-m-d", strtotime("+12 day", strtotime($fecha)));
                        break;
                    case "1": // lunes
                        $dias[] = date("Y-m-d", strtotime("+11 day", strtotime($fecha)));
                        break;
                    case "2": // martes
                        $dias[] = date("Y-m-d", strtotime("+10 day", strtotime($fecha)));
                        break;
                    case "3": // miercoles
                        $dias[] = date("Y-m-d", strtotime("+9 day", strtotime($fecha)));
                        break;
                    case "4": // jueves
                        $dias[] = date("Y-m-d", strtotime("+8 day", strtotime($fecha)));
                        break;
                    case "5": // viernes
                        $dias[] = date("Y-m-d", strtotime("+7 day", strtotime($fecha)));
                        break;
                    case "6": // sabado
                        $dias[] = date("Y-m-d", strtotime("+13 day", strtotime($fecha)));
                        break;
                }
                $mes_temp = intval(date("m", strtotime("+14 day", strtotime($dias[count($dias) - 1]))));
                $dias[] = date("Y-m-d", strtotime("+14 day", strtotime($dias[count($dias) - 1])));
                if ($mes_temp > $i) {
                    unset($dias[count($dias) - 1]);
                }
            }
        }
        //pr($dias); exit;
        return $dias;
    }
}

/**
 * Retorna el texto de la ultima semana de la fecha parametrizada
 * @author oagarzond
 * @param   $fecha      Fecha en la que se va a calcular el dia y la semana en que estaba
 * @return  $txt_fecha  Texto de la semana que precede inmediatamente a la fecha
 */
if (!function_exists("calcular_ult_sem")) {

    function calcular_ult_sem($fecha) {
        $txt_fecha = '';
        $num_dia = date("w", strtotime($fecha));
        switch ($num_dia) {
            case "0": // domingo
                $fecha_ini = date("Y-m-d", strtotime("-6 day", strtotime($fecha)));
                $fecha_fin = $fecha;
                break;
            case "1": // lunes
                $fecha_ini = date("Y-m-d", strtotime("-7 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-1 day", strtotime($fecha)));
                break;
            case "2": // martes
                $fecha_ini = date("Y-m-d", strtotime("-8 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-2 day", strtotime($fecha)));
                break;
            case "3": // miercoles
                $fecha_ini = date("Y-m-d", strtotime("-9 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-3 day", strtotime($fecha)));
                break;
            case "4": // jueves
                $fecha_ini = date("Y-m-d", strtotime("-10 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-4 day", strtotime($fecha)));
                break;
            case "5": // viernes
                $fecha_ini = date("Y-m-d", strtotime("-11 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-5 day", strtotime($fecha)));
                break;
            case "6": // sabado
                $fecha_ini = date("Y-m-d", strtotime("-12 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-6 day", strtotime($fecha)));
                break;
        }

        $year = date("Y", strtotime($fecha_ini));

        $txt_fecha = obtener_texto_dia_mes($fecha_ini) . " al " . obtener_texto_dia_mes($fecha_fin) . " de " . $year;
        return $txt_fecha;
    }

}

/**
 * Retorna el contenido del archivo que se ve desde la URL
 * @author oagarzond
 * @param	String  $url    URL del archivo
 * @return	String  $data   Contenido del archivo
 */
if (!function_exists("curl_get_contents")) {

    function curl_get_contents($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}

/**
 * Retorna una cadena de caracteres aleatoria
 * @author oagarzond
 * @param	String  $longitud   Longitud que se quiere la cadena de carac
 * @return	String  $password   Cadena de caracteres aleatoria
 */
if (!function_exists("generar_contrasena")) {

    function generar_contrasena($longitud = '8') {
        //Caracteres para la contrasena
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password = '';
        //Reconstruimos la contrasena segun la longitud que se quiera
        for ($i = 0; $i < $longitud; $i++) {
            //obtenemos un caracter aleatorio escogido de la cadena de caracteres
            $password .= substr($str, rand(0, 62), 1);
        }
        return $password;
    }

}

/**
 * Valida si es un directorio, si no lo crea con permisos 777
 * @author oagarzond
 * @param   String  $pathname   Ruta de directorio
 * @return  Boolen  Crea o no el directorio
 */
if (!function_exists("crear_dir")) {

    function crear_dir($pathname) {
        if (!is_dir($pathname)) {
            if (!mkdir($pathname, 0777)) {
                die('Fallo al crear el directorio' . $pathname);
                return false;
            } else {
                if (!chmod($pathname, 0777)) {
                    die('Fallo al cambiar los permisos en el directorio ' . $pathname);
                    return false;
                }
            }
        }
        return true;
    }

}

/**
 * Obtiene el nombre del documento del expediente
 * @author oagarzond
 * @param   String  $filename   Nombre del archivo
 * @return  String  Nombre de la extension del archivo
 */
if (!function_exists("obtener_nombre_expe")) {

    function obtener_nombre_expe($anioExpe, $numeExpe) {
        $tmp = str_pad($numeExpe, 3, '0', STR_PAD_LEFT) . '-' . $anioExpe;
        return $tmp;
    }

}

/**
 * Obtiene el nombre del documento del expediente
 * @author oagarzond
 * @param   String  $filename   Nombre del archivo
 * @return  String  Nombre de la extension del archivo
 */
if (!function_exists("obtener_nombre_docu")) {

    function obtener_nombre_docu($anioExpe, $numeExpe, $consDocu = '1') {
        $tmp = 'd' . $anioExpe . str_pad($numeExpe, 3, '0', STR_PAD_LEFT) . str_pad($consDocu, 3, '0', STR_PAD_LEFT);
        return $tmp;
    }

}

/**
 * Obtiene la extension de un archivo
 * @author oagarzond
 * @param   String  $filename   Nombre del archivo
 * @return  String  Nombre de la extension del archivo
 */
if (!function_exists("obtener_extension")) {

    function obtener_extension($filename) {
        $tmp = (explode(".", $filename));
        return end($tmp);
    }

}

/**
 * Se guarda el valor satinizados
 * @author oagarzond
 * @param   String  $data   Texto plano a satinizar
 * @return  String  $data   Texto satinizado
 */
if (!function_exists("satinizar_valor")) {

    function satinizar_valor($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlentities($data);
        $arrSymbol = array('#');
        $arrSymHTML = array('&num;');
        /*foreach ($arrSymbol as $ks => $vs) {
            if (substr_count($data, $vs) > 0) {
                $data = str_replace($vs, $arrSymHTML[$ks], $data);
            }
        }*/
        return $data;
    }

}

/**
 * Resta dos fechas
 * @author oagarzond
 * @return  String  $fechaFin   Fecha final en formato YYYY-MM-DD
 * @param   String  $fechaIni   Fecha incial en formato YYYY-MM-DD
 * @return  Int     $dias       Numeros de dias que hay entre las fechas
 */
if (!function_exists("restar_fechas")) {

    function restar_fechas($fechaFin, $fechaIni) {
        $tmpFechaFin = explode('-', $fechaFin);
        $tmpFechaIni = explode('-', $fechaIni);
        $timestampFin = mktime(0,0,0,$tmpFechaFin[1],$tmpFechaFin[2],$tmpFechaFin[0]);
        $timestampIni = mktime(0,0,0,$tmpFechaIni[1],$tmpFechaIni[2],$tmpFechaIni[0]);
        $dias = ((($timestampFin - $timestampIni) / 60) / 60) / 24;
        return $dias;
    }

}

/**
 * Calcula la edad a partir de la fecha de nacimiento
 * @author oagarzond
 * @return  String  $fecha      Fecha final en formato YYYY-MM-DD
 * @return  Int     $ano        Numero de edad
 */
if (!function_exists("calcula_edad")) {

    function calcula_edad($fecha) {
        list($ano,$mes,$dia) = explode("-", $fecha);
        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }

}


/**
 * Retorna el html para mostrar un campo input text
 * @author mayandarl
 * @author oagarzond
 * @param	$arr_var	Variables que componen la estructura del input
 * @return	$html		Texto en html
 */
if (!function_exists("mostrar_input_text")) {

    function mostrar_input_text($arr_var) {
        $html = '';
        if (count($arr_var) > 0) {
            /*if (!empty($arr_var['FECHA']) && $arr_var['FECHA'] == 'SI') {
                $html .= '<div class="datePicker">';
                $arr_var['REFERENCIA_HTML'] .= '_fecha';
            }*/
            $html .= "<div class='input-text'><input type='text' id='" . $arr_var['REFERENCIA_HTML'] . "' name='" . $arr_var['REFERENCIA_HTML'] . "' size='" . $arr_var['LONGITUD_TEXTO'] . "' maxlength='" . $arr_var['LONGITUD_TEXTO'] . "' placeholder='" . $arr_var['ETIQUETA'] . "'";
            if (!empty($arr_var['VALOR_DEFECTO']))
                $html .= " value='" . $arr_var['VALOR_DEFECTO'] ."'";
            if (!empty($arr_var['VALOR']))
                $html .= " value='" . $arr_var['VALOR'] ."'";
            $html .= " data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />\n";
            /*if (!empty($arr_var['FECHA']) && $arr_var['FECHA'] == 'SI') {
                $html .= "</div>";
            }*/
            $html .= "</div>";
        }
        return $html;
    }

}

/**
 * Retorna el html para mostrar un campo input text
 * @author mayandarl
 * @author oagarzond
 * @param   $arr_var    Variables que componen la estructura del input
 * @return  $html       Texto en html
 */
if (!function_exists("mostrar_input_password")) {

    function mostrar_input_password($arr_var) {
        $html = '';
        if (count($arr_var) > 0) {
            /*if (!empty($arr_var['FECHA']) && $arr_var['FECHA'] == 'SI') {
                $html .= '<div class="datePicker">';
                $arr_var['REFERENCIA_HTML'] .= '_fecha';
            }*/
            $html .= "<div class='input-text'><input type='password' id='" . $arr_var['REFERENCIA_HTML'] . "' name='" . $arr_var['REFERENCIA_HTML'] . "' size='" . $arr_var['LONGITUD_TEXTO'] . "' maxlength='" . $arr_var['LONGITUD_TEXTO'] . "' placeholder='" . $arr_var['ETIQUETA'] . "'";
            if (!empty($arr_var['VALOR_DEFECTO']))
                $html .= " value='" . $arr_var['VALOR_DEFECTO'] ."'";
            if (!empty($arr_var['VALOR']))
                $html .= " value='" . $arr_var['VALOR'] ."'";
            $html .= " data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />\n";
            /*if (!empty($arr_var['FECHA']) && $arr_var['FECHA'] == 'SI') {
                $html .= "</div>";
            }*/
            $html .= "</div>";
        }
        return $html;
    }

}

/**
 * Retorna el html para mostrar un campo select
 * @author mayandarl
 * @author oagarzond
 * @param	$arr_var	Variables que componen la estructura del select
 * @param	$arr_opc	Opciones que tiene el select
 * @return	$html		Texto en html
 */
if (!function_exists("mostrar_select")) {

    function mostrar_select($arr_var, $arr_opc = array()) {
        $html = $disa = $style = '';
        $classSelect = 'select';
        if (count($arr_var) > 0) {
            if (!empty($arr_var['BLOQ']) && $arr_var['BLOQ'] == 'SI')
                $disa = 'disabled';
            if (!empty($arr_var['LONGITUD'])) {
                $style = 'style="width: ' . (20 * intval($arr_var['LONGITUD'])) . 'px"';
            }
            if (!empty($arr_var['TIPO']) && $arr_var['TIPO'] == 'FECHA') {
                $classSelect = 'select-date';
            }
            $html = "<div class='" . $classSelect . "'><select id='" . $arr_var['REFERENCIA_HTML'] . "' name='" . $arr_var['REFERENCIA_HTML'] . "' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' $disa $style>\n";
            $html .= "<option value=''>" . $arr_var['ETIQUETA'] . "</option>\n";
            if(count($arr_opc) > 0) {
                foreach ($arr_opc as $k1 => $v1) {
                    $sel = "";
                    if (isset($arr_var['VALOR']) && (!empty($arr_var['VALOR']) || $arr_var['VALOR'] == 0) && $arr_var['VALOR'] == $v1['ID_OPCION'])
                        $sel = 'selected';
                    if (!empty($arr_var['VALOR_DEFECTO']) && $arr_var['VALOR_DEFECTO'] == $v1['ID_OPCION'])
                        $sel = 'selected';
                    $html .= "<option value='" . $v1['ID_OPCION'] . "' $sel>" . $v1['DESCRIPCION_OPCION'] . "</option>\n";
                }
            }
            $html .= "</select></div>\n";
            if (!empty($v1['AYUDA']))
                $html .= '&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="' . $v1['REFERENCIA_HTML'] . '-ayuda" data-tooltip="' . $v1['AYUDA'] . '"  aria-hidden="true"></span>';
        }
        return $html;
    }

}

/**
 * Retorna el html para mostrar varios radios
 * @author mayandarl
 * @author oagarzond
 * @param	$arr_var	Variables que componen la estructura de los radios
 * @param	$arr_opc	Opciones que tiene cada radio
 * @return	$html		Texto en html
 */
if (!function_exists("mostrar_radios")) {

    function mostrar_radios($arr_var, $arr_opc) {
        //pr($arr_opc); exit;
        $html = "";
        if (count($arr_var) > 0) {
            if(count($arr_opc) > 0) {
                foreach ($arr_opc as $k1 => $v1) {
                    $sel = "";
                    if (!empty($arr_var['VALOR']) && ($arr_var['VALOR'] == $v1['ID_OPCION']))
                        $sel = 'checked';
                    if ($arr_var['VALOR_DEFECTO'] == $v1['ID_OPCION']) {
                        $sel = 'checked';
                    } else if (!empty($arr_var['BLOQ']) && $arr_var['BLOQ'] == 'SI') {
                        $sel = 'disabled';
                    } else if (!empty($v1['BLOQ']) && $v1['BLOQ'] == 'SI') {
                        $sel = 'disabled';
                    }
                    $html .= "<div class='radio' id='radio_" . $arr_var['REFERENCIA_HTML'] . "_" . $v1['ID_OPCION'] . "'>
                    <label>
                    <input type='radio' name='" . $arr_var['REFERENCIA_HTML'] . "' id='" . $arr_var['REFERENCIA_HTML'] . "_" . $v1['ID_OPCION'] . "' value='" . $v1['ID_OPCION'] . "'" . " $sel aria-describedby='acc_ayuda_".$v1['ID_OPCION']."' /> "
                    . "<span>" . $v1['DESCRIPCION_OPCION'] . "</span>";

                    if (!empty($v1['AYUDA']))
                        $html .= '&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="' . $arr_var['REFERENCIA_HTML'] . '-ayuda" data-tooltip="' . $v1['AYUDA'] . '"  aria-hidden="true"></span>';
                    if (isset($v1['HTML']) && strlen($v1['HTML']) > 0) {
                        $html .= $v1['HTML'];
                    }
                    $html .= "</label></div>\n";

                    if(isset($v1['PREGUNTA']) && count($v1['PREGUNTA']) > 0) {
                        $html .= '<div id="' . $arr_var['REFERENCIA_HTML'] . "-" . $v1['ID_OPCION'] .'-panel" class="';
                        // Se quita porque solamente ocultar por pregunta y no todas las preguntas juntas
                        foreach ($v1['PREGUNTA'] as $k2 => $v2) {
                            if(!empty($v2['HIDDEN']) && $v2['HIDDEN'] == 'SI') {
                               $html .= ' hidden';
                            }
                        }
                        $html .= '"><div class="">';
                        foreach ($v1['PREGUNTA'] as $k2 => $v2) {
                            $html .= '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 panel-padding-left"><div class="form-group';
                            /*if(!empty($v2['HIDDEN']) && $v2['HIDDEN'] == 'SI') {
                               $html .= ' hidden';
                            }*/
                            $html .= '" id="' .$v2['REFERENCIA_HTML'] .'-col">';
                            if(!empty($v2['DESCRIPCION'])) {
                                $html .= '<label id="' . $v2['REFERENCIA_HTML'] .'-lbl" class="control-label" for="'. $v2['REFERENCIA_HTML'] . '"> ' .$v2['DESCRIPCION'];
                                if (!empty($v2['AYUDA'])) {
                                    $html .= '&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="' . $v2['REFERENCIA_HTML'] . '-ayuda" data-tooltip="' . $v2['AYUDA'] . '" aria-hidden="true"></span>';
                                }
                                $html .= '</label>';
                            }
                            if ($v2['TIPO_CAMPO'] == "SELUNICA") {
                                if(!empty($v2["OPCIONES"]) && count($v2["OPCIONES"]) > 0) {
                                    $html.= mostrar_select($v2, $v2["OPCIONES"]);
                                } else {
                                    $html.= mostrar_select($v2);
                                }
                            } else if ($v2['TIPO_CAMPO'] == "SELUNICA_RAD") {
                                $html.= mostrar_radios($v2, $v2["OPCIONES"]);
                            } else if ($v2['TIPO_CAMPO'] == "FECHA") {
                                $html.= mostrar_fecha($v2);
                            } else if ($v2['TIPO_CAMPO'] == "TEXTO") {
                                $html.= mostrar_input_text($v2);
                            }
                            $html .= "</div></div></div>";
                        }
                        $html .= "</div></div>\n";
                    }
                    $html .= "<div id='acc_ayuda_".$v1['ID_OPCION']."' class='acc-offscreen'>" . $v1['AYUDA'] . "</div>";
                }
            }
        }
        return $html;
    }

}

/**
 * Retorna el html para mostrar varios radios
 * @author mayandarl
 * @author oagarzond
 * @param	$arr_var	Variables que componen la estructura de los radios
 * @param	$arr_opc	Opciones que tiene cada radio
 * @return	$html		Texto en html
 */
if (!function_exists("mostrar_radios_seguidos")) {

    function mostrar_radios_seguidos($arr_var, $arr_opc) {
        //pr($arr_opc); exit;
        $html = "";
        if (count($arr_var) > 0) {
            $html .= "<div class='radio radio-followed'>";
            foreach ($arr_opc as $k1 => $v1) {
                $sel = "";
                if (!empty($arr_var['VALOR']) && ($arr_var['VALOR'] == $v1['ID_OPCION']))
                    $sel = 'checked';
                if ($arr_var['VALOR_DEFECTO'] == $v1['ID_OPCION']) {
                    $sel = 'checked';
                } else if (!empty($arr_var['BLOQ']) && $arr_var['BLOQ'] == 'SI') {
                    $sel = 'disabled';
                } else if (!empty($v1['BLOQ']) && $v1['BLOQ'] == 'SI') {
                    $sel = 'disabled';
                }
                $html .= "<label><input type='radio' name='" . $v1['REFERENCIA_HTML'] . "' id='" . $arr_var['REFERENCIA_HTML'] . "." . $v1['ID_OPCION'] . "' value='" .
                        $v1['ID_OPCION'] . "'" . " $sel aria-describedby='acc_ayuda_".$v1['ID_OPCION']."' /> <span>" . $v1['DESCRIPCION_OPCION'] . "</span>";
                if (!empty($v1['AYUDA']))
                        $html .= '&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="' . $v1['REFERENCIA_HTML'] . '-ayuda" data-tooltip="' . $v1['AYUDA'] . '"  aria-hidden="true"></span>';
                if (isset($v1['HTML']) && strlen($v1['HTML']) > 0) {
                    $html .= $v1['HTML'];
                }
                $html .= "</label>&nbsp;&nbsp;";
            }
            $html .= "</div>\n";
        }
        return $html;
    }

}

/**
 * Retorna el html para mostrar varios radios en forma de matriz
 * @author mayandarl
 * @author oagarzond
 * @param   $arr_var    Variables que componen la estructura de los radios
 * @param   $arr_opc    Opciones que tiene cada radio
 * @return  $html       Texto en html
 */
if (!function_exists("mostrar_radios_matriz")) {

    function mostrar_radios_matriz($arr_var, $arr_opc) {
        //pr($arr_opc); exit;
        $html = "";
        if (count($arr_var) > 0) {
            $html .= "<div class='radio'>";
            foreach ($arr_opc as $k1 => $v1) {
                $sel = "";
                if (!empty($arr_var['VALOR']) && ($arr_var['VALOR'] == $v1['ID_OPCION']))
                    $sel = 'checked';
                if ($arr_var['VALOR_DEFECTO'] == $v1['ID_OPCION'])
                    $sel = 'checked';
                if (!empty($arr_var['BLOQ']) && $arr_var['BLOQ'] == 'SI')
                    $sel = 'disabled';
                $html .= "<td class='text-center'><input type='radio' name='" . $v1['REFERENCIA_HTML'] . "' id='" . $arr_var['REFERENCIA_HTML'] . "." . $v1['ID_OPCION'] . "' value='" .
                        $v1['ID_OPCION'] . "'" . " $sel aria-describedby='acc_ayuda_".$v1['ID_OPCION']."' /> ";
                $html .= "</td>";
            }
            $html .= "</div>";
        }
        return $html;
    }

}

/**
 * Retorna el html para mostrar varios radios
 * @author mayandarl
 * @author oagarzond
 * @param   $arr_var    Variables que componen la estructura de los radios
 * @param   $arr_opc    Opciones que tiene cada radio
 * @return  $html       Texto en html
 */
if (!function_exists("mostrar_si_no")) {

    function mostrar_si_no($arr_var, $arr_opc) {
        //pr($arr_opc); exit;
        $html = "";
        if (count($arr_var) > 0) {
            if(count($arr_opc) > 0) {
                foreach ($arr_opc as $k1 => $v1) {
                    $sel = "";
                    if (!empty($arr_var['VALOR']) && ($arr_var['VALOR'] == $v1['ID_OPCION']))
                        $sel = 'checked';
                    if ($arr_var['VALOR_DEFECTO'] == $v1['ID_OPCION']) {
                        $sel = 'checked';
                    } else if (!empty($arr_var['BLOQ']) && $arr_var['BLOQ'] == 'SI') {
                        $sel = 'disabled';
                    } else if (!empty($v1['BLOQ']) && $v1['BLOQ'] == 'SI') {
                        $sel = 'disabled';
                    }
                    $html .= "<label class='radio-inline' id='radio_" . $arr_var['REFERENCIA_HTML'] . "_" . $v1['ID_OPCION'] . "'>
                    <input type='radio' name='" . $arr_var['REFERENCIA_HTML'] . "' id='" . $arr_var['REFERENCIA_HTML'] . "_" . $v1['ID_OPCION'] . "' value='" . $v1['ID_OPCION'] . "'" . " $sel aria-describedby='acc_ayuda_".$v1['ID_OPCION']."' /> " . $v1['DESCRIPCION_OPCION'];

                    if (!empty($v1['AYUDA']))
                        $html .= '&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="' . $arr_var['REFERENCIA_HTML'] . '-ayuda" data-tooltip="' . $v1['AYUDA'] . '"  aria-hidden="true"></span>';
                    if (isset($v1['HTML']) && strlen($v1['HTML']) > 0) {
                        $html .= $v1['HTML'];
                    }
                    $html .= "</label>\n";
                    $html .= "<div id='acc_ayuda_".$v1['ID_OPCION']."' class='acc-offscreen'>" . $v1['AYUDA'] . "</div>";
                }
            }
        }
        return $html;
    }

}

/**
 * Retorna el html para mostrar un campo fecha con tres select en formato YYYY-MM-DD
 * @author oagarzond
 * @param   $arr_var    Variables que componen la estructura de cada select
 * @return  $html       Texto en html
 */
if (!function_exists("mostrar_fecha")) {

    function mostrar_fecha($arr_var) {
        $html = '';
        //pr($arr_var); exit;
        if (count($arr_var) > 0) {
            $html .= '<div class="input-group">';
           
            $arr_var["REFERENCIA_HTML"] = $arr_var["ID_PREGUNTA_DIA"];
            $arr_var["ETIQUETA"] = 'DD';
            //$arr_var["LONGITUD"] = '4';
            $arr_var["VALOR"] = $arr_var["VALOR_DIA"];
            $j = 0;
            for($i = 1; $i <= 31; $i++) {
                $arr_opc[$j] = array(
                    "REFERENCIA_HTML" => $arr_var["REFERENCIA_HTML"],
                    "ID_OPCION" => str_pad($i, 2, '0', STR_PAD_LEFT),
                    "DESCRIPCION_OPCION" => str_pad($i, 2, '0', STR_PAD_LEFT),
                    "AYUDA" => '',
                    "ORDEN_VISUAL" => $i
                );
                $j++;
            }
            $html .= '<span class="input-group-addon input-combobox-date">Día:</span>';
            $html .= mostrar_select($arr_var, $arr_opc);
            unset($arr_opc);

            $arr_var["REFERENCIA_HTML"] = $arr_var["ID_PREGUNTA_MES"];
            $arr_var["ETIQUETA"] = 'MM';
            //$arr_var["LONGITUD"] = '4';
            $arr_var["VALOR"] = $arr_var["VALOR_MES"];
            $j = 0;
            for($i = 1; $i <= 12; $i++) {
                $arr_opc[$j] = array(
                    "REFERENCIA_HTML" => $arr_var["REFERENCIA_HTML"],
                    "ID_OPCION" => str_pad($i, 2, '0', STR_PAD_LEFT),
                    "DESCRIPCION_OPCION" => str_pad($i, 2, '0', STR_PAD_LEFT),
                    "AYUDA" => '',
                    "ORDEN_VISUAL" => $i
                );
                $j++;
            }
            $html .= '<span class="input-group-addon input-combobox-date">Mes:</span>';
            $html .= mostrar_select($arr_var, $arr_opc);
            unset($arr_opc);
            
            $arr_var["REFERENCIA_HTML"] = $arr_var["ID_PREGUNTA_ANIO"];
            $arr_var["ETIQUETA"] = 'AAAA';
            $arr_var["TIPO"] = 'FECHA';
            //$arr_var["LONGITUD"] = '6';
            $arr_var["VALOR"] = $arr_var["VALOR_ANIO"];
            $j = 0;
            //for($i = $arr_var['ANIO']; $i >= '1878'; $i--) {
            for($i = $arr_var['ANIO']; $i >= intval(date('Y') - 121); $i--) {
                $arr_opc[$j] = array(
                    "REFERENCIA_HTML" => $arr_var["REFERENCIA_HTML"],
                    "ID_OPCION" => $i,
                    "DESCRIPCION_OPCION" => $i,
                    "AYUDA" => '',
                    "ORDEN_VISUAL" => $i
                );
                $j++;
            }
            $html .= '<span class="input-group-addon input-combobox-date">Año:</span>';
            $html .= mostrar_select($arr_var, $arr_opc);
            unset($arr_opc);
            $html .= '</div>';
        }
        return $html;
    }

}

/**
 * Cambia los nombres de los campos de las preguntas y opciones del nombre
 * de la BD a la del formulario
 * @author nfforeror
 * @author oagarzond
 * @param   Array   $arr_var    Variables que componen el formulario
 * @param   Array   $arr_campos Array asociativo de nombres de formulario con nombres de campos en la BD
 * @param   Array   $arr_val    Array asociativo con los valores de los campos en la BD
 * @return  Array   $arr_var    Array con los nombres cambiados de las variables
 */
if (!function_exists("cambiar_campos_BD_HTML")) {

    function cambiar_campos_BD_HTML($arr_var, $arr_campos, $arr_val = array()) {
        foreach ($arr_var as $key => $value) {
            if (in_array($value['ID_PREGUNTA'], $arr_campos)){
                $tmp = array_search($value['ID_PREGUNTA'], $arr_campos);
                $arr_var[$key]['ID_PREGUNTA'] = $tmp;
                $arr_var[$key]['VALOR'] = '';
                if(!empty($arr_val[$value['ID_PREGUNTA']])) {
                    $arr_var[$key]['VALOR'] = $arr_val[$value['ID_PREGUNTA']];
                }
            }
            if(isset($value['OPCIONES'])){
                foreach ($value['OPCIONES'] as $k => $v) {
                    $arr_var[$key]['OPCIONES'][$k]['ID_PREGUNTA'] = $tmp;
                }
            }
        }
        return $arr_var;
    }

}

/**
 * Retorna el texto de los meses del anio
 * @author oagarzond
 * @return  Array   meses Codigo y nombres de los meses del anio
 */
if (!function_exists("arreglo_meses")) {

    function arreglo_meses() {
        $meses[0]["ID_VALOR"] = "1";
        $meses[0]["ETIQUETA"] = "Enero";
        $meses[1]["ID_VALOR"] = "2";
        $meses[1]["ETIQUETA"] = "Febrero";
        $meses[2]["ID_VALOR"] = "3";
        $meses[2]["ETIQUETA"] = "Marzo";
        $meses[3]["ID_VALOR"] = "4";
        $meses[3]["ETIQUETA"] = "Abril";
        $meses[4]["ID_VALOR"] = "5";
        $meses[4]["ETIQUETA"] = "Mayo";
        $meses[5]["ID_VALOR"] = "6";
        $meses[5]["ETIQUETA"] = "Junio";
        $meses[6]["ID_VALOR"] = "7";
        $meses[6]["ETIQUETA"] = "Julio";
        $meses[7]["ID_VALOR"] = "8";
        $meses[7]["ETIQUETA"] = "Agosto";
        $meses[8]["ID_VALOR"] = "9";
        $meses[8]["ETIQUETA"] = "Septiembre";
        $meses[9]["ID_VALOR"] = "10";
        $meses[9]["ETIQUETA"] = "Octubre";
        $meses[10]["ID_VALOR"] = "11";
        $meses[10]["ETIQUETA"] = "Noviembre";
        $meses[11]["ID_VALOR"] = "12";
        $meses[11]["ETIQUETA"] = "Diciembre";
        return $meses;
    }

}

/**
 * Retorna el texto de los meses del anio
 * @author oagarzond
 * @return  Array   meses Codigo y nombres de los meses del anio
 */
if (!function_exists("tildesToHtml")) {

    function tildesToHtml($content){
        $acentos = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ','¿');
        $acenCon = array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&ntilde;','&Ntilde;','&iquest;');
        return str_replace($acentos, $acenCon, $content);
    }
}

/**
 * Se consulta y/o se construye el archivo de preguntas con sus opciones
 * @author oagarzond
 * @param   String  $tabla      Tabla asociada de la pregunta
 * @param   String  $pagina     Pagina de la pregunta
 * @return Array    $preguntas Lista de preguntas con parametros
 * @since 2017-08-10
 */
if (!function_exists("extraer_preguntas")) {

    function extraer_preguntas($tabla = '', $pagina = '') {
        $preguntas = array();
        $base_dir = substr(base_dir(), 0, -1) . '//files/';
        $CI = & get_instance();
        $filename = 'preguntas_' . $CI->config->item("tipoFormulario");
        $extension = '.json';
        $path = $base_dir . $filename . $extension;

        $file = @file_get_contents($path);

        if($file == false) {
            return $preguntas;
        } else {
            $preguntas = json_decode(file_get_contents($path), true);
        }

        //pr($preguntas); exit;
        if(!empty($tabla)) {
            foreach ($preguntas[$tabla] as $kpt => $vpt) {
                foreach ($vpt as $kptv => $vptv) {
                    $pregunta = asignar_valor_etiqueta($vptv["DESCRIPCION"]);
                    $preguntas[$tabla][$kpt][$kptv]['DESCRIPCION'] = $pregunta;
                }
            }
            if(!empty($pagina)) {
                $preguntas = $preguntas[$tabla][$pagina];
            } else {
                $preguntas = $preguntas[$tabla];
            }
        }
        return $preguntas;
    }

}

/**
 * Asigna las respuesta que tiene cada pregunta
 * @author oagarzond
 * @param   Array   $arr_var    Variables que componen el formulario
 * @param   Array   $arr_val    Array asociativo con los valores de los campos en la BD
 * @return  Array   $arr_var    Array con los nombres cambiados de las variables
 */
if (!function_exists("asignar_valor_pregunta")) {

    function asignar_valor_pregunta($arr_var, $arr_val) {
        foreach ($arr_var as $key => $value) {
            $arr_var[$key]['VALOR'] = '';
            if(!empty($arr_val[$value['ID_PREGUNTA']])) {
                $arr_var[$key]['VALOR'] = $arr_val[$value['ID_PREGUNTA']];
                continue;
            }
        }
        return $arr_var;
    }

}

/**
 * Asigna el valor de la etiqueta por valores de sesion
 * @author oagarzond
 * @param   String  $texto      Descripcion de la pregunta
 * @return  String  $texto      Descripcion de la pregunta
 */
if (!function_exists("asignar_valor_etiqueta")) {

    function asignar_valor_etiqueta($texto) {
        preg_match_all('#\#(.*?)\##', $texto, $match);
        if (!empty($match) && is_array($match)) {
            foreach ($match[1] as $k => $variable) {
                $campo = $match[0][$k];
                $CI = & get_instance();
                if($variable == 'EJEMPLOS_CPOB') {
                    $ejemplosCPob = (!empty($CI->session->userdata('ejemplosCPob'))) ? $CI->session->userdata('ejemplosCPob'): '';
                    $texto = str_replace($campo, '<strong>' . $ejemplosCPob . '</strong>', $texto);
                }
                /*if($variable == 'NOMBRE_LUGAR') {
                    $nombreLugar = (!empty($CI->session->userdata('nombreLugar'))) ? $CI->session->userdata('nombreLugar'): '';
                    $texto = str_replace($campo, '<strong>' . $nombreLugar . '</strong>', $texto);
                }*/
                if($variable == 'NOMBRE_PERS') {
                    $texto = str_replace($campo, '<strong class="user-name-border">' . $CI->session->userdata('nombrePersona') . '</strong>', $texto);
                }
                if($variable == 'FECHA_1ANIO') {
                    $texto = str_replace($campo, '<strong>' . $CI->session->userdata('texto1Anio') . '</strong>', $texto);
                }
                if($variable == 'FECHA_5ANIOS') {
                    $texto = str_replace($campo, '<strong>' . $CI->session->userdata('texto5Anios') . '</strong>', $texto);
                }
                if($variable == 'SEMANA_PASADA') {
                    $semana = calcular_ult_sem(date('Y-m-d'));
                    $texto = str_replace($campo, $semana, $texto);
                }
                if($variable == 'NOMBRE_DIFICULTAD') {
                    $nombreDificultad = (!empty($CI->session->userdata('nombreDificultad'))) ? $CI->session->userdata('nombreDificultad'): '';
                    $texto = str_replace($campo, $nombreDificultad, $texto);
                }
            }
        }
        return $texto;
    }
}

/**
 * Asigna el valor de la etiqueta por valores de sesion
 * @author oagarzond
 * @param   String  $texto      Descripcion de la pregunta
 * @param   String  $valores    Valores que van a ser reemplazados
 * @return  String  $texto      Descripcion de la pregunta
 */
if (!function_exists("asignar_valor_etiqueta_valor")) {

    function asignar_valor_etiqueta_valor($texto, $valores = '') {
        preg_match_all('#\#(.*?)\##', $texto, $match);
        if (!empty($match) && is_array($match)) {
            foreach ($match[1] as $k => $variable) {
                $campo = $match[0][$k];
                if(array_key_exists($campo, $valores) && !empty($valores[$campo])) {
                    $texto = str_replace($campo, '<strong>' . $valores[$campo] . '</strong>', $texto);
                }
            }
        }
        return $texto;
    }
}

/**
 * Funcion para validar si una fecha que viene de MySQL es valida
 *
 * @author hhchavezv
 * @param string $fecha     Cadena para validar en formato YYYY-MM-DD
 * @return string Retorna true si es fecha valida
 */
if (!function_exists("es_fecha_valida_mysql")) {

    function es_fecha_valida_mysql($fecha) {
        if (!empty($fecha) && is_string($fecha)) {
            if ( (substr_count($fecha, "-") == 2) &&  (substr_count($fecha, ":") == 0) ) {
                $data = explode("-", $fecha);
                if (strlen($data[0]) != 4)
                    return false;
                return true;
            }
            else
				return false;
        } else {
            return false;
        }
    }

}

/**
 * Esta funcion se utiliza para darle formato a la fecha mysql,
 * es decir si se pasa el formato YYYY-MM-DD se retorna la fecha en formato oracle DD/MM/YYYY
 * @author hhchavezv
 * @param	date	$fecha	Fecha
 * @return	string	Retorna la fecha formateada o vacio si la fecha no es valida
 */
if (!function_exists("formatear_fecha_mysql")) {

     function formatear_fecha_mysql($fecha) {
        if($fecha != "0000-00-00"){
			if (es_fecha_valida_mysql($fecha)) {

					$data = explode("-", $fecha);
					return $data[2] . "/" . $data[1] . "/" . $data[0];

			} else
				return "";
		}else
			return "";
    }

}

/**
 * Funcion para validar si una fecha hora que viene de MySQL es valida
 *
 * @author hhchavezv
 * @param string $fecha     Cadena para validar en formato YYYY-MM-DD HH:MI:SS
 * @return string Retorna true si es fecha valida
 */
if (!function_exists("es_fecha_hora_valida_mysql")) {

    function es_fecha_hora_valida_mysql($fecha) {
        if (!empty($fecha) && is_string($fecha)) {
            if ( (substr_count($fecha, "-") == 2) &&  (substr_count($fecha, ":") == 2) ) {
                $data = explode("-", $fecha);
                if (strlen($data[0]) != 4)
                    return false;
                return true;
            }
            else
				return false;
        } else {
            return false;
        }
    }

}

/**
 * Esta funcion se utiliza para darle formato a la fecha hora mysql ,
 * es decir si se pasa el formato YYYY-MM-DD HH:MI:SS se retorna la fecha en formato oracle DD/MM/YYYY HH:MI:SS .
 * @author hhchavezv
 * @param	date	$fecha	Fecha
 * @return	string	Retorna la fecha formateada o vacio si la fecha no es valida
 */
if (!function_exists("formatear_fecha_hora_mysql")) {

   function formatear_fecha_hora_mysql($fecha) {
        if($fecha != "0000-00-00 00:00:00"){
			if (es_fecha_hora_valida_mysql($fecha)) {
					$data = explode(" ", $fecha);
					$ff=$data[0];
					$data_h=$data[1];
					$data_f = explode("-", $ff);
					return $data_f[2] . "/" . $data_f[1] . "/" . $data_f[0]. " " . $data_h;


			} else
				return "";
		} else {
           return "";
		}
    }
}

/* Funcion para consultar los headers de apache */
if (!function_exists('getallheaders')) {
    function getallheaders() {
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
    }
}

/* Funcion para capturar las ips de la cadena de conexion */
if (!function_exists("getIp")) {
    function getIp() {
        $ipCliente = false;
        $ipClientea = false;
        $ipEncontrada = null;
        $ipchain="";

        if (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) { // buscamos la ip en la vaiable server.
            $ipCliente = (! empty ( $_SERVER ['REMOTE_ADDR'] )) ? $_SERVER ['REMOTE_ADDR'] : ((! empty ( $_ENV ['REMOTE_ADDR'] )) ? $_ENV ['REMOTE_ADDR'] : "Sin Info");
            $ent = explode ( ", ", $_SERVER ['HTTP_X_FORWARDED_FOR'] );
            reset ( $ent );
            foreach ( $ent as $valor ) {
                $valor = trim ( $valor );
                if (preg_match ( "/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $valor, $lista_ips )) {
                    $ipsPrivadas = array (
                        '/^0\./',
                        '/^127\.0\.0\.1/',
                        '/^192\.168\..*/',
                        '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                        '/^10\..*/'
                    );
                    $ipEncontrada = preg_replace ( $ipsPrivadas, $ipCliente, $lista_ips [1] );
                    if ($ipCliente != $ipEncontrada) {
                        $ipClientea = $ipEncontrada;
                    }
                }
            }
            $ipchain .="/".$_SERVER ['HTTP_X_FORWARDED_FOR'];
        }
        if (! $ipCliente) {
            $headers = getallheaders();
            if (! empty ( $headers ["X-Forwarded-For"] )) {
                $ipCliente = $headers ["X-Forwarded-For"];
                $ent = explode ( ", ", $headers ["X-Forwarded-For"] );
                reset ( $ent );
                $ipCliente = $ent [0];
            } else
            $ipCliente = (! empty ( $_SERVER ['REMOTE_ADDR'] )) ? $_SERVER ['REMOTE_ADDR'] : ((! empty ( $_ENV ['REMOTE_ADDR'] )) ? $_ENV ['REMOTE_ADDR'] : "Sin Informacion");
        }
        return  $ipCliente.$ipchain;
    }
}
// EOC
