<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH . 'libraries/predis/src/Autoloader.php';

/**
 * Modelo para el manejo de los formularios
 * @author oagarzond
 **/
class Modform extends CI_Model {

    private $redis;

    function __construct() {
        parent::__construct();
        $this->sufijoTabla = 'ECP';
        if(in_array($this->config->item('tipoFormulario'), array('G', 'H'))) {
            $this->sufijoTabla = 'WCP';
        }
        /*Predis\Autoloader::register();
        //$this->redis = new Predis\Client();
        $this->redis = new Predis\Client([
            'scheme' => $this->config->item('redis_scheme'),
            'host'   => $this->config->item('redis_host'),
            'port'   => $this->config->item('redis_port'),
            'password' => $this->config->item('redis_password')
        ]);*/
        /*$this->redis = new Redis();
        $this->redis->connect($this->config->item('redis_host'), $this->config->item('redis_port'));
        $this->redis->auth($this->config->item('redis_password'));
        $this->redis->select($this->config->item('redis_database'));*/
        //echo "Server is running: ".$this->redis->ping();
    }

    /**
     * Se consulta y/o se construye la llave en Redis de preguntas con sus opciones
     * y posterior consulta la tabla o pagina que se necesita
     * @author oagarzond
     * @param   String  $tabla      Tabla asociada de la pregunta
     * @param   String  $pagina     Pagina de la pregunta
     * @return Array    $preguntas Lista de preguntas con parametros
     * @since 2017-08-10
     */
    public function extraerPreguntas($tabla = '', $pagina = '') {
        $preguntas = array();
        $key = 'preguntas';
        //$this->redis->del('Preguntas', 'preguntas');
        //$this->redis->flushall();
        //return false;

        //@mientras se desarrolla los formularios se recrea la llave preguntas
        //if(!$this->redis->exists($key)) {
            $arrPreguntas = $this->consultarPreguntas();
            if(!empty($arrPreguntas)) {
                //$this->redis->set($key, json_encode($arrPreguntas));
            }
        //}

        /*if(!$this->redis->exists($key)) {
            return $preguntas;
        }*/

        //$preguntas = json_decode($this->redis->get($key), true);
	$preguntas = $arrPreguntas;
	 
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

    /**
     * Consulta las preguntas que hay en el pagina del modulo
     * @author oagarzond
     * @param   String  $tabla      Tabla asociada de la pregunta
     * @param   String  $pagina     Pagina de la pregunta
     * @return  Array   $data
     */
    public function consultarPreguntas($tabla = '', $pagina = '') {
        $data = array();
        $cond = '';
        $i = 0;

        if(!empty($tabla))
            $cond .= " AND PP.TABLA_ASOCIADA = '" . $tabla . "'";
        if(!empty($pagina))
            $cond .= " AND FP.NUMERO_PAGINA = '" . $pagina . "'";

        $sql = "SELECT FP.ID_PREGUNTA_FORMULARIO, FP.NUMERO_PAGINA, PP.ID_DOMINIO FK_ID_DOMINIO, PP.*
                FROM " . $this->sufijoTabla . "_FORMULARIO_PREGUNTAS FP
                INNER JOIN " . $this->sufijoTabla . "_PARAM_PREGUNTAS PP ON (PP.ID_PREGUNTA = FP.ID_PREGUNTA)
                WHERE FP.TIPO_FORMULARIO = '" . $this->config->item("tipoFormulario") . "'" . $cond .
                " ORDER BY PP.TABLA_ASOCIADA, FP.NUMERO_PAGINA, PP.ORDEN";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        //$this->db->reset_query();
        while ($row = $query->unbuffered_row('array')) {
            //$pregunta = $this->asignarValorEtiqueta($row["DESCRIPCION"]);
            //$row["DESCRIPCION"] = $pregunta;
            $data[$row["TABLA_ASOCIADA"]][$row["NUMERO_PAGINA"]][$i] = $row;
            $tempVal = $this->consultarOpciones($row["ID_PREGUNTA"]);
            if(count($tempVal) > 0) {
                $data[$row["TABLA_ASOCIADA"]][$row["NUMERO_PAGINA"]][$i]["OPCIONES"] = $tempVal;
            }
            $i++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Consulta las preguntas que hay en el pagina del modulo
     * @author oagarzond
     * @param   String  $tabla      Tabla asociada de la pregunta
     * @param   String  $pagina     Pagina de la pregunta
     * @return  Array   $data
     */
    public function consultarParamPreguntas($tabla = '', $pagina = '') {
        $data = array();
        $cond = '';
        $i = 0;

        if(!empty($tabla))
            $cond .= " AND TABLA_ASOCIADA = '" . $tabla . "'";
        if(!empty($pagina))
            $cond .= " AND NUME_PAGINA = '" . $pagina . "'";

        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_PARAM_PREGUNTAS WHERE ID_PREGUNTA IS NOT NULL " . $cond .
                " ORDER BY ORDEN";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        //$this->db->reset_query();
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            //$pregunta = $this->asignarSignificadosEtiqueta($row["DESCRIPCION"], $row["ID_PREGUNTA"]);
            //$data[$i]["DESCRIPCION"] = $pregunta;
            $pregunta = $this->asignarValorEtiqueta($row["DESCRIPCION"]);
            $data[$i]["DESCRIPCION"] = $pregunta;
            $tempVal = $this->consultarOpciones($row["ID_PREGUNTA"]);
            if(count($tempVal) > 0) {
                $data[$i]["OPCIONES"] = $tempVal;
            }
            $i++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Asigna el valor de la etiqueta por valores de sesion
     * @author oagarzond
     * @param   String  $texto      Descripcion de la pregunta
     * @return  String  $texto      Descripcion de la pregunta
     */
    public function asignarValorEtiqueta($texto) {
        preg_match_all('#\#(.*?)\##', $texto, $match);
        if (!empty($match) && is_array($match)) {
            foreach ($match[1] as $k => $variable) {
                $campo = $match[0][$k];
                if($variable == 'EJEMPLOS_CPOB') {
                    $ejemplosCPob = (!empty($this->session->userdata('ejemplosCPob'))) ? $this->session->userdata('ejemplosCPob'): '';
                    $texto = str_replace($campo, '<strong>' . $ejemplosCPob . '</strong>', $texto);
                }
                if($variable == 'NOMBRE_LUGAR') {
                    $nombreLugar = (!empty($this->session->userdata('nombreLugar'))) ? $this->session->userdata('nombreLugar'): '';
                    $texto = str_replace($campo, '<strong>' . $nombreLugar . '</strong>', $texto);
                }
                if($variable == 'NOMBRE_PERS') {
                    $texto = str_replace($campo, '<strong class="user-name-border">' . $this->session->userdata('nombrePersona') . '</strong>', $texto);
                }
                if($variable == 'FECHA_1ANIO') {
                    $texto = str_replace($campo, '<strong>' . $this->session->userdata('texto1Anio') . '</strong>', $texto);
                }
                if($variable == 'FECHA_5ANIOS') {
                    $texto = str_replace($campo, '<strong>' . $this->session->userdata('texto5Anios') . '</strong>', $texto);
                }
                if($variable == 'SEMANA_PASADA') {
                    $semana = calcular_ult_sem(date('Y-m-d'));
                    $texto = str_replace($campo, $semana, $texto);
                }
                if($variable == 'NOMBRE_DIFICULTAD') {
                    $nombreDificultad = (!empty($this->session->userdata('nombreDificultad'))) ? $this->session->userdata('nombreDificultad'): '';
                    $texto = str_replace($campo, $nombreDificultad, $texto);
                }
            }
        }
        return $texto;
    }

    /**
     * Consulta los posibles valores que tiene cada una de las preguntas
     * @author oagarzond
     * @param   String  $idPregunta     ID de la variable de la pregunta
     * @param   String  $idOpcion       IDs de las opciones
     * @return  Array   $data
     */
    public function consultarOpciones($idVariable = '', $idOpcion = '') {
        $data = array();
        $cond = '';
        $i = 0;

        if(!empty($idVariable)) {
            if (is_int($idVariable)) {
                $cond .= " AND ID_PREGUNTA = " . $idVariable;
            } else if (is_string($idVariable)) {
                $cond .= " AND ID_PREGUNTA = '" . $idVariable . "'";
            } else if (is_array($idVariable)) {
                $cond .= " AND ID_PREGUNTA IN (" . implode(",", $idVariable) . ")";
            }
        }
        if(!empty($idOpcion)) {
            if (is_int($idOpcion)) {
                $cond .= " AND ID_OPCION = " . $idOpcion;
            } else if (is_string($idOpcion)) {
                $cond .= " AND ID_OPCION = '" . $idOpcion . "'";
            } else if (is_array($idOpcion)) {
                $cond .= " AND ID_OPCION IN (" . implode(",", $idOpcion) . ")";
            }
        }

        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_PARAM_OPCIONES WHERE ID_PREGUNTA IS NOT NULL " . $cond .
                " ORDER BY ORDEN_VISUAL";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Reasignar datos en etiquetas del formulario
     * @author mayandar
     * @since 2016-03-19
     */
    public function asignarDatosEtiqueta($texto, $tabla, $idAC) {
        preg_match('#\#(.*?)\##', $texto, $match);
        $result = $texto;
        if (is_array($match) && !empty($match)) {
            $campo = $match[0];
            $variable = $match[1];
            $sql = "SELECT ". $variable ." FROM $tabla WHERE C0U1_ENCLEA = '". $idAC ."'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    if(substr_count($variable, 'MPIO') > 0) {
                        $arrMpio = $this->consultar_municipios();
                        foreach ($arrMpio as $km => $vm) {
                            if($vm["ID_VALOR"] == $row->$variable) {
                                $row->$variable = $vm["ETIQUETA"];
                                break;
                            }
                        }
                    }

                    $result = str_replace($campo, '<i>' . $row->$variable . '</i>', $texto);
                }

            }
            $this->db->close();
        }
        return $result;
    }

    /**
     * Funcion general para reasignar datos en etiquetas del formulario
     * @author Mario A. Yandar
     * @since  Marzo 19 / 2016
     */
    public function asignarDatosEtiquetaPersona($texto, $id_persona) {
        // Reformatea el texto de la pregunta con el contenido del formulario
        preg_match_all('#\#(.*?)\##', $texto, $match);
        $result = $texto;
        $tabla = $this->sufijoTabla . '_PERSONAS_HOGAR';
        if (is_array($match[0]) && !empty($match[0])) {
            $campo = $match[0];
            $variable = $match[1];
            $ids_var = implode("','", $variable);
            $sql = "SELECT ID_VARIABLE FROM " . $this->sufijoTabla . "_PARAM_PREGUNTAS WHERE ID_VARIABLE in ('$ids_var') AND TABLA_ASOCIADA='$tabla'";
            $query = $this->db->query($sql);
            $data = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row->ID_VARIABLE;
                }
                $sql2 = "SELECT ". implode(",", $data) ." FROM $tabla WHERE ID_PERSONA='". $id_persona ."'";
                $query2 = $this->db->query($sql2);
                if ($query2->num_rows() > 0) {
                    foreach ($query2->result() as $row2) {
                        for ($i=0; $i < count($match[0]); $i++)
                            $result = str_replace($campo[$i], '<i>'. $row2->$variable[$i] .'</i>', $result);
                    }
                }
            }
            $this->db->close();
        }
        return $result;
    }

    /**
     * Reasignar datos en etiquetas del formulario
     * @author mayandar
     * @since 2016-03-19
     */
    public function asignarSignificadosEtiqueta($texto, $idVariable) {
        // Reformatea el texto de la pregunta con el contenido del formulario
        preg_match_all('#\?(.*?)\?#', $texto, $match);
        $result = $texto;
        $tabla = 'CID_ADMIN_SIGNIFICADOS';
        if (is_array($match[0]) && !empty($match[0])) {
            $campo = $match[0];
            $variable = $match[1];
            $sql2 = "SELECT PALABRA_CLAVE, DESCRIPCION FROM $tabla WHERE ID_VARIABLE='" . $idVariable . "'";
            $query2 = $this->db->query($sql2);
            if ($query2->num_rows() > 0) {
                foreach ($query2->result() as $row2) {
                    $signi[$row2->PALABRA_CLAVE] = $row2->DESCRIPCION;
                }
                for ($i = 0; $i < count($match[0]); $i++)
                    $result = str_replace($campo[$i], "<a href='#' data-toggle='tooltip' title='" . $signi[$variable[$i]] . "'>" . $variable[$i] . "</a>", $result);
            }
            $this->db->close();
        }
        return $result;
    }

    /**
     * Consulta las fechas festivos por anio
     * @access Public
     * @author oagarzond
     * @return  Array   $data   Registros devueltos por la consulta
     */
    public function consultarFestivos($anios) {
        $data = array();
        $cond = '';
        $i = 0;
        if (!empty($anios)) {
            if (is_int($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') = " . $anios;
            } else if (is_string($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') = '" . $anios . "'";
            } else if (is_array($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') IN ('" . implode("','", $anios) . "')";
            }
        }
        $sql = "SELECT TO_CHAR(FECHA_FESTIVO, 'YYYY-MM-DD') FECHA
                FROM RH.RH_CALENDARIO
                WHERE 1 = 1 " . $cond;
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data[] = $row["FECHA"];
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Busca los valores del dominio seleccionado
     * @author oagarzond
     * @since 2016-07-15
     */
    public function consultarParamGeneral($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;

        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND PG.ID_PARAM = '" . $arrDatos["id"] . "'";
        }
        if (array_key_exists("tipo", $arrDatos)) {
            $cond .= " AND PG.TIPO_PARAM = '" . $arrDatos["tipo"] . "'";
        }
        if (array_key_exists("valor", $arrDatos)) {
            $cond .= " AND PG.VALOR_PARAM = '" . $arrDatos["valor"] . "'";
        }
        if (array_key_exists("descripcion", $arrDatos)) {
            $cond .= " AND PG.DESC_PARAM LIKE '%" . $arrDatos["descripcion"] . "%'";
        }

        $sql = "SELECT PG.*
              FROM CID_PARAM_GENERAL PG
              WHERE PG.ID_PARAM IS NOT NULL " . $cond .
              " ORDER BY PG.ID_PARAM, PG.VALOR_PARAM ASC";
        //pr($sql); exit;
        $query = $this->db->query($sql);

        while ($row = $query->unbuffered_row('array')) {
            $data[$i]["ID_VALOR"] = $row["VALOR_PARAM"];
            $data[$i]["ETIQUETA"] = $row["DESC_PARAM"];
            $i ++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Busca los valores del dominio seleccionado
     * Para usar Redis por dominio se debe definir el idDominio
     * @author oagarzond
     * @since 2016-07-15
     */
    public function consultarRespuestaDominio($arrDatos) {
        //$this->redis->flushall();
        //$this->redis->del('dominio_D26');
        //return false;
        $data = array();
        $cond = '';
        $key = "dominio";
        if (array_key_exists("idDominio", $arrDatos)) {
            $key .= "_D" . $arrDatos["idDominio"];
        }
        if (array_key_exists("idPadre", $arrDatos)) {
            $key .= "_P" . $arrDatos["idPadre"];
        }
        $i = 0;
        $bogo = false;

        /*if($this->redis->exists($key) && !array_key_exists("sidx", $arrDatos)) {
            $data = json_decode($this->redis->get($key), true);

            if (array_key_exists("valor", $arrDatos)) {
                //pr($arrDatos["valor"]); exit;
                $dataRedis = $data;
                unset($data);
                if (is_array($arrDatos["valor"])) {
                    foreach ($dataRedis as $keyr => $valuer) {
                        if(in_array($valuer['ID_VALOR'], $arrDatos["valor"])) {
                            $data[] = $dataRedis[$keyr];
                        }
                    }
                } else {
                    foreach ($dataRedis as $keyr => $valuer) {
                        if($valuer['ID_VALOR'] == $arrDatos["valor"]) {
                            $data[] = $dataRedis[$keyr];
                            break;
                        }
                    }
                }
            }
            if (array_key_exists("noValor", $arrDatos)) {
                //pr($arrDatos["noValor"]); exit;
                $dataRedis = $data;
                unset($data);
                if (is_array($arrDatos["noValor"])) {
                    foreach ($dataRedis as $keyr => $valuer) {
                        if(!in_array($valuer['ID_VALOR'], $arrDatos["noValor"])) {
                            $data[] = $dataRedis[$keyr];
                        }
                    }
                } else {
                    foreach ($dataRedis as $keyr => $valuer) {
                        if($valuer['ID_VALOR'] != $arrDatos["noValor"]) {
                            $data[] = $dataRedis[$keyr];
                        }
                    }
                }
            }
        }*/

        /* validación para verificar si existe data consultadad de redis, o esta es menor a 5 opciones para cargar dede base de datos */
        //if (!isset($data) || count($data) < 5)
            $bogo = true;

        if($bogo) {

            if (array_key_exists("id", $arrDatos)) {
                $cond .= " AND RD.ID_RESPUESTA_DOMINIO = '" . $arrDatos["id"] . "'";
            }
            if (array_key_exists("idDominio", $arrDatos)) {
                $cond .= " AND RD.ID_DOMINIO = '" . $arrDatos["idDominio"] . "'";
            }
            if (array_key_exists("idPadre", $arrDatos)) {
                $cond .= " AND RD.ID_RESPUESTA_DOMINIO_PADRE = '" . $arrDatos["idPadre"] . "'";
            }
            if (array_key_exists("valor", $arrDatos)) {
                if (is_int($arrDatos["valor"])) {
                    $cond .= " AND RD.VALOR_MINIMO = " . $arrDatos["valor"];
                } else if (is_string($arrDatos["valor"])) {
                    $cond .= " AND RD.VALOR_MINIMO = '" . $arrDatos["valor"] . "'";
                } else if (is_array($arrDatos["valor"])) {
                    $cond .= " AND RD.VALOR_MINIMO IN ('" . implode("','", $arrDatos["valor"]) . "')";
                }
            }
            if (array_key_exists("noValor", $arrDatos)) {
                if (is_int($arrDatos["noValor"])) {
                    $cond .= " AND RD.VALOR_MINIMO != " . $arrDatos["noValor"];
                } else if (is_string($arrDatos["noValor"])) {
                    $cond .= " AND RD.VALOR_MINIMO != '" . $arrDatos["noValor"] . "'";
                } else if (is_array($arrDatos["noValor"])) {
                    $cond .= " AND RD.VALOR_MINIMO NOT IN ('" . implode("','", $arrDatos["noValor"]) . "')";
                }
            }
            if (array_key_exists("descripcion", $arrDatos)) {
                $cond .= " AND RD.DESCRIPCION LIKE '%" . $arrDatos["descripcion"] . "%'";
            }

            $sql = "SELECT LPAD(RD.VALOR_MINIMO,2,'0') VALOR_MIN, RD.*
                  FROM " . $this->sufijoTabla . "_RESPUESTA_DOMINIO RD
                  WHERE RD.ID_DOMINIO IS NOT NULL " . $cond;

            $sql .= (array_key_exists("sidx", $arrDatos)) ? " ORDER BY " . $arrDatos["sidx"]: " ORDER BY RD.DESCRIPCION";
            $sql .= (array_key_exists("sord", $arrDatos)) ? " " . $arrDatos["sord"]: " ASC";
            //pr($sql); exit;
            $query = $this->db->query($sql);

            while ($row = $query->unbuffered_row('array')) {
                $data[$i] = $row;
                $data[$i]["ID"] = $row["ID_RESPUESTA_DOMINIO"];
                $data[$i]["ID_VALOR"] = $row["VALOR_MINIMO"];
                $data[$i]["ETIQUETA"] = $row["DESCRIPCION"];
                $i++;
            }
            // Se agrega a Redis definida si no existe
            // if(!$this->redis->exists($key)) {
            //     $this->redis->set($key, json_encode($data));
            // }
            $this->db->close();
        }
        if (!isset($data))
            $data = array();
        //pr($data); exit;
        return $data;
    }

    /**
     * Busca los paises para los combos
     * @author alrodriguezm
     * @since 2016-01-20
     */
    function consultarPaises() {
        $data = array();
        $i = 0;

        $sql = "SELECT VALOR_MINIMO, DESCRIPCION
               FROM CID_RESPUESTA_DOMINIO
               WHERE ID_DOMINIO = 38 AND VALOR_MINIMO <> '169'
               ORDER BY DESCRIPCION ASC";
        $query = $this->db->query($sql);

        while ($row = $query->unbuffered_row('array')) {
            $data[$i]["ID_VALOR"] = $row["VALOR_MINIMO"];
            $data[$i]["ETIQUETA"] = $row["DESCRIPCION"];
            $i ++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Busca los valores del parametro seleccionado
     * @author oagarzond
     * @since 2017-06-05
     */
    public function consultarParamValores($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;

        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND PV.ID_VALOR_PARAM = '" . $arrDatos["id"] . "'";
        }
        if (array_key_exists("idDominio", $arrDatos)) {
            $cond .= " AND PV.ID_PARAM_GENERAL = '" . $arrDatos["idDominio"] . "'";
        }
        if (array_key_exists("valor", $arrDatos)) {
            if (is_int($arrDatos["valor"])) {
                $cond .= " AND PV.VALOR_PARAM = " . $arrDatos["valor"];
            } else if (is_string($arrDatos["valor"])) {
                $cond .= " AND PV.VALOR_PARAM = '" . $arrDatos["valor"] . "'";
            } else if (is_array($arrDatos["valor"])) {
                $cond .= " AND PV.VALOR_PARAM IN (" . implode(",", $arrDatos["valor"]) . ")";
            }
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND PV.ESTADO_VALOR_PARAM = " . $arrDatos["estado"];
        }
        if (array_key_exists("descripcion", $arrDatos)) {
            $cond .= " AND RD.DESCRIPCION LIKE '%" . $arrDatos["descripcion"] . "%'";
        }

        $sql = "SELECT PV.*
              FROM " . $this->sufijoTabla . "_PARAM_VALORES PV
              WHERE PV.ID_VALOR_PARAM IS NOT NULL " . $cond .
              " ORDER BY PV.ORDEN_VALOR_PARAM ASC";
        //pr($sql); exit;
        $query = $this->db->query($sql);

        while ($row = $query->unbuffered_row('array')) {
            $data[$i]["ID"] = $row["ID_PARAM_GENERAL"];
            $data[$i]["ID_VALOR"] = $row["VALOR_PARAM"];
            $data[$i]["ETIQUETA"] = $row["DESC_VALOR_PARAM"];
            $i ++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    public function redisConsultarRespuestaDominio($arrDatos) {
        //$this->redis->flushall();
        //$this->redis->del('dominio_D26');
        //return false;
        $data = array();
        $cond = '';
        $key = "dominio";
        if (array_key_exists("idDominio", $arrDatos)) {
            $key .= "_D" . $arrDatos["idDominio"];
        }
        if (array_key_exists("idPadre", $arrDatos)) {
            $key .= "_P" . $arrDatos["idPadre"];
        }
        $i = 0;
        // if($this->redis->exists($key) && !array_key_exists("sidx", $arrDatos)) {
        //     $data = json_decode($this->redis->get($key), true);

        //     if (array_key_exists("valor", $arrDatos)) {
        //         //pr($arrDatos["valor"]); exit;
        //         $dataRedis = $data;
        //         unset($data);
        //         if (is_array($arrDatos["valor"])) {
        //             foreach ($dataRedis as $keyr => $valuer) {
        //                 if(in_array($valuer['ID_VALOR'], $arrDatos["valor"])) {
        //                     $data[] = $dataRedis[$keyr];
        //                 }
        //             }
        //         } else {
        //             foreach ($dataRedis as $keyr => $valuer) {
        //                 if($valuer['ID_VALOR'] == $arrDatos["valor"]) {
        //                     $data[] = $dataRedis[$keyr];
        //                     break;
        //                 }
        //             }
        //         }
        //     }
        //     if (array_key_exists("noValor", $arrDatos)) {
        //         //pr($arrDatos["noValor"]); exit;
        //         $dataRedis = $data;
        //         unset($data);
        //         if (is_array($arrDatos["noValor"])) {
        //             foreach ($dataRedis as $keyr => $valuer) {
        //                 if(!in_array($valuer['ID_VALOR'], $arrDatos["noValor"])) {
        //                     $data[] = $dataRedis[$keyr];
        //                 }
        //             }
        //         } else {
        //             foreach ($dataRedis as $keyr => $valuer) {
        //                 if($valuer['ID_VALOR'] != $arrDatos["noValor"]) {
        //                     $data[] = $dataRedis[$keyr];
        //                 }
        //             }
        //         }
        //     }
        // } else {
            if (array_key_exists("id", $arrDatos)) {
                $cond .= " AND RD.ID_RESPUESTA_DOMINIO = '" . $arrDatos["id"] . "'";
            }
            if (array_key_exists("idDominio", $arrDatos)) {
                $cond .= " AND RD.ID_DOMINIO = '" . $arrDatos["idDominio"] . "'";
            }
            if (array_key_exists("idPadre", $arrDatos)) {
                $cond .= " AND RD.ID_RESPUESTA_DOMINIO_PADRE = '" . $arrDatos["idPadre"] . "'";
            }
            if (array_key_exists("valor", $arrDatos)) {
                if (is_int($arrDatos["valor"])) {
                    $cond .= " AND RD.VALOR_MINIMO = " . $arrDatos["valor"];
                } else if (is_string($arrDatos["valor"])) {
                    $cond .= " AND RD.VALOR_MINIMO = '" . $arrDatos["valor"] . "'";
                } else if (is_array($arrDatos["valor"])) {
                    $cond .= " AND RD.VALOR_MINIMO IN ('" . implode("','", $arrDatos["valor"]) . "')";
                }
            }
            if (array_key_exists("noValor", $arrDatos)) {
                if (is_int($arrDatos["noValor"])) {
                    $cond .= " AND RD.VALOR_MINIMO != " . $arrDatos["noValor"];
                } else if (is_string($arrDatos["noValor"])) {
                    $cond .= " AND RD.VALOR_MINIMO != '" . $arrDatos["noValor"] . "'";
                } else if (is_array($arrDatos["noValor"])) {
                    $cond .= " AND RD.VALOR_MINIMO NOT IN ('" . implode("','", $arrDatos["noValor"]) . "')";
                }
            }
            if (array_key_exists("descripcion", $arrDatos)) {
                $cond .= " AND RD.DESCRIPCION LIKE '%" . $arrDatos["descripcion"] . "%'";
            }

            $sql = "SELECT LPAD(RD.VALOR_MINIMO,2,'0') VALOR_MIN, RD.*
                  FROM " . $this->sufijoTabla . "_RESPUESTA_DOMINIO RD
                  WHERE RD.ID_DOMINIO IS NOT NULL " . $cond;

            $sql .= (array_key_exists("sidx", $arrDatos)) ? " ORDER BY " . $arrDatos["sidx"]: " ORDER BY RD.DESCRIPCION";
            $sql .= (array_key_exists("sord", $arrDatos)) ? " " . $arrDatos["sord"]: " ASC";
            //pr($sql); exit;
            $query = $this->db->query($sql);

            while ($row = $query->unbuffered_row('array')) {
                $data[$i] = $row;
                $data[$i]["ID"] = $row["ID_RESPUESTA_DOMINIO"];
                $data[$i]["ID_VALOR"] = $row["VALOR_MINIMO"];
                $data[$i]["ETIQUETA"] = $row["DESCRIPCION"];
                $i++;

            }
            // Se agrega a Redis definida si no existe
            if(!$this->redis->exists($key) && count($data) > 0) {
                $this->redis->set($key, json_encode($data));
            }

            $this->db->close();
        // }
        if (!isset($data))
            $data = array();
        //pr($data); exit;
        return $data;
    }

}
// EOC