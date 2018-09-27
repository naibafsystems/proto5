<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del modulo de hogar
 * @author oagarzond
 * @since  2017-02-21
 **/
class Modhogar extends My_model {

    public $msgError;
    public $msgSuccess;
    private $sufijoTabla;
    private $codiEncuesta;
    private $codiVivienda;
    private $codiHogar;
    private $totalPaginas;

    public function __construct() {
        $this->msgError = '';
        $this->msgSuccess = '';
        $this->codiEncuesta = 0;
        $this->codiVivienda = 0;
        $this->codiHogar = 0;
        $this->totalPaginas = 0;
        $this->sufijoTabla = 'ECP';
        if(in_array($this->config->item('tipoFormulario'), array('G', 'H'))) {
            $this->sufijoTabla = 'WCP';
        }
    }

    public function getMsgError() {
        return $this->msgError;
    }

    public function getMsgSuccess() {
        return $this->msgSuccess;
    }

    public function setCodiEncuesta($codiEncuesta) {
        $this->codiEncuesta = $codiEncuesta;
    }

    public function setCodiVivienda($codiVivienda) {
        $this->codiVivienda = $codiVivienda;
    }

    public function setCodiHogar($codiHogar) {
        $this->codiHogar = $codiHogar;
    }

    public function setTotalPaginas($totalPaginas) {
        $this->totalPaginas = $totalPaginas;
    }

    /**
     * Consulta los datos de la vivienda de la encuesta
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarHogar($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND H.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("idHogar", $arrDatos)) {
            $cond .= " AND H.ID_HOGAR = '" . $arrDatos["idHogar"] . "'";
        }
        if (array_key_exists("idVivienda", $arrDatos)) {
            $cond .= " AND H.ID_VIVIENDA = '" . $arrDatos["idVivienda"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND H.FECHA_INSERCION = '" . $arrDatos["fecha"] . "'";
        }

        $sql = "SELECT H.*
                FROM " . $this->sufijoTabla . "_HOGAR H
                WHERE H.ID_HOGAR IS NOT NULL " . $cond .
                " ORDER BY H.COD_ENCUESTAS, H.ID_VIVIENDA, H.ID_HOGAR";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Actualiza los datos del hogar de la encuesta
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarHogar($arrDatosHogar) {
        $this->msgError = '';

        try {
            $arrDatosHogar['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosHogar['USUARIO_MODIFICACION'] = $this->session->userdata('id');
            $arrWhereHogar['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereHogar['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWhereHogar['ID_HOGAR'] = $this->codiHogar;

            if (!$this->ejecutar_update($this->sufijoTabla . '_HOGAR', $arrDatosHogar, $arrWhereHogar)) {
                throw new Exception("No se pudo actualizar correctamente la información del hogar. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Actualiza el estado y la página en que va el usuario
     * @access Public
     * @author oagarzond
     * @param   Int     $estado Estado de la encuesta
     * @return Boolean
     */
    public function actualizarEstadoAC($estado = 0) {
        $this->msgError = '';
        $estadoActual = $this->session->userdata('estado');

        try {
            switch ($estado) {
                case 2:
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 7;
                    }
                    $arrDatosAC['FECHA_INI_HOGAR'] = 'SYSDATE';
                    $arrDatosAC['PAG_HOGAR'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $sessionData['paginaHogar'] = $arrDatosAC['PAG_HOGAR'];
                        if($estadoActual < 11) {
                            $sessionData['estado'] = $arrDatosAC['ID_ESTADO_AC'];
                        }
                        if(!empty($sessionData)) {
                            $this->session->set_userdata($sessionData);
                        }
                    }
                    break;
                case 'f':
                    $arrDatosAC['FECHA_FIN_HOGAR'] = 'SYSDATE';
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 8;
                    }
                    $arrDatosAC['PAG_HOGAR'] = $this->totalPaginas + 1;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $sessionData['paginaHogar'] = $arrDatosAC['PAG_HOGAR'];
                        $sessionData['fechaFinHogar'] = $arrDatosAC['FECHA_FIN_HOGAR'];
                        if($estadoActual < 11) {
                            $sessionData['estado'] = $arrDatosAC['ID_ESTADO_AC'];
                        }
                        if(!empty($sessionData)) {
                            $this->session->set_userdata($sessionData);
                        }
                    }
                    break;
                default:
                    $arrDatosAC['PAG_HOGAR'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $this->session->set_userdata('paginaHogar', $arrDatosAC['PAG_HOGAR']);
                    }
                    break;
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }


    public function consultarNumeroHogares($codigo_encuesta) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT V_TOT_HOG
                FROM " . $this->sufijoTabla . "_VIVIENDA
                WHERE COD_ENCUESTAS =  " . $codigo_encuesta ;
        
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function consultarNumeroHogaresConstruidos($codigo_encuesta) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT count(*) AS total
                FROM " . $this->sufijoTabla . "_HOGAR
                WHERE COD_ENCUESTAS =  " . $codigo_encuesta ;
        
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }


    public function insertarDatosHogar($param) {
        //var_dump($param);exit;

        $id_hogar = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_HOGAR');

        $datosHogar['COD_ENCUESTAS'] = $param["COD_ENCUESTAS"];
        $datosHogar['ID_VIVIENDA'] = $param["ID_VIVIENDA"];
        $datosHogar['ID_HOGAR'] = $id_hogar;
        $datosHogar['H_NROHOG'] = $param["H_NROHOG"];
        $datosHogar['FECHA_INSERCION'] = 'SYSDATE';
        $datosHogar['USUARIO_INSERCION'] = $this->session->userdata('id');;

        
        if (!$this->ejecutar_insert($this->sufijoTabla . '_HOGAR', $datosHogar)) {
            throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
        }
        return $id_hogar;
    }

    public function consultarHogares($codigo_encuesta) {  
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT H_NROHOG 
                FROM " . $this->sufijoTabla . "_HOGAR
                WHERE COD_ENCUESTAS =  " . $codigo_encuesta ;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function consultarIdHogar($codigo_encuesta,$hogar) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT ID_HOGAR, H_NROHOG 
                FROM " . $this->sufijoTabla . "_HOGAR
                WHERE COD_ENCUESTAS =  " . $codigo_encuesta. " AND H_NROHOG= " .$hogar ;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function actualizarDatosHogar($resp) {
        
        
        $datosInsert['FECHA_MODIFICACION'] = "SYSDATE";
        $datosInsert['USUARIO_MODIFICACION'] = $this->session->userdata('id');
        $datosInsert['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $datosInsert['ID_VIVIENDA'] = $resp["id_vivienda"];
        $datosInsert['H_NRO_CUARTOS'] = $resp["hg_numero_cuartos"];
        $datosInsert['H_NRO_DORMIT'] = $resp["hg_cuartos_dormir"];
        $datosInsert['H_DONDE_PREPALIM'] = $resp["hg_preparan_alimentos"];
        $datosInsert['H_AGUA_COCIN'] = $resp["hg_obtiene_agua"];
        $datosInsert['HA_NRO_FALL'] = $resp["hg_total_fallecieron"];
            
        $arrWhere['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $arrWhere['ID_HOGAR'] = $resp["id_hogar"];
        $arrWhere['ID_VIVIENDA'] = $resp["id_vivienda"];

        if (!$this->ejecutar_update($this->sufijoTabla . '_HOGAR', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }
        return true;
/*
        $this->db->trans_start();
        $this->db->insert('WCP_HOGAR', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;*/
    }

    public function insertarPersonasFallecidas($param) {
        //var_dump($param);exit;

        $id_persona_fallecida = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_PERSONAS_FALLECIDAS');

        $persF['FECHA_INSERCION'] = "SYSDATE";
        $persF['USUARIO_INSERCION'] = $this->session->userdata('id');
        $persF['COD_ENCUESTAS'] = $param["codi_encuesta"];
        $persF['ID_VIVIENDA'] = $param["id_vivienda"];
        $persF['ID_HOGAR'] = $param["id_hogar"];
        $persF['ID_PERSONA_FALLECIDA'] = $id_persona_fallecida;
        $persF["F_NROHOG"] = $param["F_NROHOG"];
        $persF["FA1_NRO_FALL"] = $param["FA1_NRO_FALL"];
        $persF["FA2_SEXO_FALL"] = $param["FA2_SEXO_FALL"];
        $persF["FA3_EDAD_FALL"] = $param["FA3_EDAD_FALL"];
        $persF["FA4_CERT_DEFUN"] = $param["FA4_CERT_DEFUN"];

        
        if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_FALLECIDAS', $persF)) {
            throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
        }
        return $id_persona_fallecida;
    }

    public function actualizarPersonasFallecidas($param) {
        //var_dump($param);exit;

        $persF['FECHA_MODIFICACION'] = "SYSDATE";
        $persF['USUARIO_MODIFICACION'] = $this->session->userdata('id');
        $whereF['COD_ENCUESTAS'] = $param["codi_encuesta"];
        $whereF['ID_VIVIENDA'] = $param["id_vivienda"];
        $whereF['ID_HOGAR'] = $param["id_hogar"];
        $whereF["FA1_NRO_FALL"] = $param["FA1_NRO_FALL"];
        $persF["FA2_SEXO_FALL"] = $param["FA2_SEXO_FALL"];
        $persF["FA3_EDAD_FALL"] = $param["FA3_EDAD_FALL"];
        $persF["FA4_CERT_DEFUN"] = $param["FA4_CERT_DEFUN"];

        
        if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_FALLECIDAS', $persF, $whereF)) {
                throw new Exception("No se pudo actualizar correctamente la información del hogar. SQL: " . $this->get_sql(), 1);
            }

        return $id_persona_fallecida;
    }

    public function insertarPersonasResidentes($param) {
        //var_dump($param);exit;

        $id_persona_residente = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_PERSONAS_RESIDENTES');

        $persR['FECHA_INSERCION'] = "SYSDATE";
        $persR['USUARIO_INSERCION'] = $this->session->userdata('id');
        $persR['COD_ENCUESTAS'] = $param["codi_encuesta"];
        $persR['ID_VIVIENDA'] = $param["id_vivienda"];
        $persR['ID_HOGAR'] = $param["id_hogar"];
        $persR['ID_PERSONA_RESIDENTE'] = $id_persona_residente;
        $persR["R_NROHOG"] = $param["F_NROHOG"];
        $persR["RA1_NRO_RESI"] = $param["RA1_NRO_RESI"];
        $persR["RA2_1NOMBRE"] = $param["RA2_1NOMBRE"];
        $persR["RA3_2NOMBRE"] = $param["RA3_2NOMBRE"];
        $persR["RA4_1APELLIDO"] = $param["RA4_1APELLIDO"];
        $persR["RA5_2APELLIDO"] = $param["RA5_2APELLIDO"];

        
        if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_RESIDENTES', $persR)) {
            throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
        }

        $persH['FECHA_INSERCION'] = "SYSDATE";
        $persH['USUARIO_INSERCION'] = $this->session->userdata('id');
        $persH['COD_ENCUESTAS'] = $param["codi_encuesta"];
        $persH['ID_VIVIENDA'] = $param["id_vivienda"];
        $persH['ID_HOGAR'] = $param["id_hogar"];
        $persH['ID_PERSONA_HOGAR'] = $id_persona_residente;
        $persH["P_NROHOG"] = $param["F_NROHOG"];
        $persH["P_NRO_PER"] = $param["RA1_NRO_RESI"];
        $persH["PA_1ER_NOMBRE"] = $param["RA2_1NOMBRE"];
        $persH["PB_1ER_APELLIDO"] = $param["RA4_1APELLIDO"];
        $persH["P_EDAD"] = $param["P_EDAD"];
        $persH["PA_TIPO_DOC"] = $param["PA_TIPO_DOC"];
        $persH["PA1_NRO_DOC"] = $param["PA1_NRO_DOC"];

        if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_HOGAR', $persH)) {
            throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
        }

        if($persR["RA1_NRO_RESI"]=="1"){
            $arrDatosJefeHogar['H_ID_JEFE'] = $persH["PA1_NRO_DOC"];
            $arrWhereHogar['COD_ENCUESTAS'] = $param["codi_encuesta"];
            $arrWhereHogar['ID_VIVIENDA'] = $param["id_vivienda"];
            $arrWhereHogar['ID_HOGAR'] = $param["id_hogar"];

            if (!$this->ejecutar_update($this->sufijoTabla . '_HOGAR', $arrDatosJefeHogar, $arrWhereHogar)) {
                throw new Exception("No se pudo actualizar correctamente la información del hogar. SQL: " . $this->get_sql(), 1);
            }
            //$jefeHogar['H_ID_JEFE'] = "SYSDATE";
        }

        return $id_persona_residente;
    }

    public function actualizarPersonasResidentes($param) {
        //var_dump($param);exit;

        $persR['FECHA_MODIFICACION'] = "SYSDATE";
        $persR['USUARIO_MODIFICACION'] = $this->session->userdata('id');
        $whereR['COD_ENCUESTAS'] = $param["codi_encuesta"];
        $whereR['ID_VIVIENDA'] = $param["id_vivienda"];
        $whereR['ID_HOGAR'] = $param["id_hogar"];
        $whereR["RA1_NRO_RESI"] = $param["RA1_NRO_RESI"];
        $persR["RA2_1NOMBRE"] = $param["RA2_1NOMBRE"];
        $persR["RA3_2NOMBRE"] = $param["RA3_2NOMBRE"];
        $persR["RA4_1APELLIDO"] = $param["RA4_1APELLIDO"];
        $persR["RA5_2APELLIDO"] = $param["RA5_2APELLIDO"];

        
        if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_RESIDENTES', $persR, $whereR)) {
                throw new Exception("No se pudo actualizar correctamente la información del hogar. SQL: " . $this->get_sql(), 1);
            }

        $persH['FECHA_MODIFICACION'] = "SYSDATE";
        $persH['USUARIO_MODIFICACION'] = $this->session->userdata('id');
        $whereH['COD_ENCUESTAS'] = $param["codi_encuesta"];
        $whereH['ID_VIVIENDA'] = $param["id_vivienda"];
        $whereH['ID_HOGAR'] = $param["id_hogar"];
        $whereH["P_NRO_PER"] = $param["RA1_NRO_RESI"];
        $persH["PA_1ER_NOMBRE"] = $param["RA2_1NOMBRE"];
        $persH["PB_1ER_APELLIDO"] = $param["RA4_1APELLIDO"];
        $persH["P_EDAD"] = $param["P_EDAD"];
        $persH["PA_TIPO_DOC"] = $param["PA_TIPO_DOC"];
        $persH["PA1_NRO_DOC"] = $param["PA1_NRO_DOC"];

        if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $persH, $whereH)) {
                throw new Exception("No se pudo actualizar correctamente la información del hogar. SQL: " . $this->get_sql(), 1);
            }

        if($persR["RA1_NRO_RESI"]=="1"){
            $arrDatosJefeHogar['H_ID_JEFE'] = $persH["PA1_NRO_DOC"];
            $arrWhereHogar['COD_ENCUESTAS'] = $param["codi_encuesta"];
            $arrWhereHogar['ID_VIVIENDA'] = $param["id_vivienda"];
            $arrWhereHogar['ID_HOGAR'] = $param["id_hogar"];

            if (!$this->ejecutar_update($this->sufijoTabla . '_HOGAR', $arrDatosJefeHogar, $arrWhereHogar)) {
                throw new Exception("No se pudo actualizar correctamente la información del hogar. SQL: " . $this->get_sql(), 1);
            }
            //$jefeHogar['H_ID_JEFE'] = "SYSDATE";
        }

        return $id_persona_residente;
    }

    public function insertarPersonasC($param) {
        //var_dump($param);exit;

        $persC["COD_ENCUESTAS"] = $param["codi_encuesta"];
        $persC["ID_VIVIENDA"] = $param["id_vivienda"];
        $persC["ID_HOGAR"] = $param["id_hogar"];
        $persC["ID_PERSONA_RESIDENTE"] = $param["id_persona"];
        
        if (!$this->ejecutar_insert($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $persC)) {
            throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
        }

        return true;
    }

    public function respuestas($codiEncuesta, $id_vivienda, $id_hogar) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_HOGAR
                WHERE COD_ENCUESTAS =  " . $codiEncuesta. "AND ID_VIVIENDA = " . $id_vivienda. "AND ID_HOGAR = " . $id_hogar;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function respuestasPersonas($codiEncuesta, $id_vivienda, $id_hogar) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_PERSONAS_HOGAR PH
                INNER JOIN  " . $this->sufijoTabla . "_PERSONAS_RESIDENTES PR ON PR.ID_PERSONA_RESIDENTE=PH.ID_PERSONA_HOGAR 
                WHERE PH.COD_ENCUESTAS =  " . $codiEncuesta. " AND PH.ID_VIVIENDA = " . $id_vivienda. " AND PH.ID_HOGAR = " . $id_hogar;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function respuestasPersonasFallecidas($codiEncuesta, $id_vivienda, $id_hogar) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_PERSONAS_FALLECIDAS 
                WHERE COD_ENCUESTAS =  " . $codiEncuesta. " AND ID_VIVIENDA = " . $id_vivienda. " AND ID_HOGAR = " . $id_hogar;
        
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function consultarPersonaFallecida($codiEncuesta,$id_vivienda,$id_hogar,$numero_persona_fallecida) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_PERSONAS_FALLECIDAS 
                WHERE COD_ENCUESTAS =  " . $codiEncuesta. " AND ID_VIVIENDA = " . $id_vivienda. " AND ID_HOGAR = " . $id_hogar. " AND FA1_NRO_FALL = " . $numero_persona_fallecida;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function consultarPersonaResidente($codiEncuesta,$id_vivienda,$id_hogar,$numero_persona_residente) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_PERSONAS_RESIDENTES  
                WHERE COD_ENCUESTAS =  " . $codiEncuesta. " AND ID_VIVIENDA = " . $id_vivienda. " AND ID_HOGAR = " . $id_hogar. " AND RA1_NRO_RESI = " . $numero_persona_residente;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function reporte() {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT admusu.USUARIO, admusu.NOMBRES, admusu.APELLIDOS, viv.UI1_NROFOR AS numero_formulario, viv.U_DPTO AS depto_divipola, viv.U_MPIO AS municipio_divipola, viv.V_TOT_HOG as total_hogares, ctrl.FECHA_REGISTRO as fecha_inicio_digitacion, ctrl.FECHA_CERTI AS fecha_fin_digitacion, ctrl.FECHA_CERTI, 
            (SELECT count(*) FROM WCP_PERSONAS_HOGAR pshog WHERE viv.COD_ENCUESTAS=pshog.COD_ENCUESTAS) AS cantidad_personas,
            (SELECT count(*) FROM WCP_PERSONAS_HOGAR pshog WHERE viv.COD_ENCUESTAS=pshog.COD_ENCUESTAS AND pshog.P_SEXO is not null) AS cantidad_personas_digitadas
            FROM wcp_vivienda viv
            INNER JOIN wcp_admin_usuarios admusu ON viv.USUARIO_INSERCION = admusu.ID_USUARIO
            INNER JOIN wcp_admin_control ctrl ON viv.COD_ENCUESTAS=ctrl.COD_ENCUESTAS
            WHERE ctrl.FECHA_REGISTRO BETWEEN TO_TIMESTAMP('30/08/2018','dd/mm/yyyy') AND SYSDATE ";
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

}
//EOC