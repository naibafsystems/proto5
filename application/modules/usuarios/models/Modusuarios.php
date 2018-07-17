<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo para la validación de ingreso de usuarios a la aplicacion
 * @author oagarzond
 * @since  2016-06-10
 **/
class Modusuarios extends My_model{
    public $msgError;
    public $msgSuccess;
    private $sufijoTabla;
    private $codiEncuesta;
    private $codiUsuario;
    private $codiResidente;

    public function __construct() {
        $this->msgError = '';
        $this->msgSuccess = '';
        $this->codiEncuesta = 0;
        $this->codiUsuario = 0;
        $this->codiResidente = 0;
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

    public function getCodiResidente() {
        return $this->codiResidente;
    }

    public function setCodiEncuesta($codiEncuesta) {
        $this->codiEncuesta = $codiEncuesta;
    }

    public function setCodiUsuario($codiUsuario) {
        $this->codiUsuario = $codiUsuario;
    }

    /**
     * Valida que el usuario y clave de un usuario sea autentico y que se encuentre
     * registrado en la base de datos
     * @author oagarzond
     * @param   String  $usuario    Login del usuario
     * @param   String  $clave      Clave del usuario
     * @param   String  $tipo       Tipo de usuario
     * @return boolean
     */
    public function validarUsuario($usuario, $clave, $tipo = '') {
        $this->load->library('danecrypt');
        $result = false;
        $sql = "SELECT TO_CHAR(FU.FECHA_CREACION, 'DD/MM/YYYY') FECHAC, TO_CHAR(FU.FECHA_EXPIRACION, 'DD/MM/YYYY') FECHAE, FU.CLAVE, FU.ID_USUARIO, FU.USUARIO, FU.ID_TIPO_USUARIO, FU.COD_ENCUESTAS, FU.ID_PERSONA_RESIDENTE, FU.NOMBRES, FU.APELLIDOS, FU.ID_TIPO_USUARIO FROM " . $this->sufijoTabla . "_ADMIN_USUARIOS FU
            WHERE FU.ID_ESTADO_USUA = 1 AND USUARIO = '" . $usuario . "'";
        if(!empty($tipo)) {
            if(is_string($tipo)) {
                $sql .= " AND FU.ID_TIPO_USUARIO = '" . $tipo . "'";
            } else if(is_array($tipo)) {
                $sql .= " AND FU.ID_TIPO_USUARIO IN ('" . implode("','", $tipo) . "')";
            }
        }
        // pr($sql); exit;
        //$this->db->cache_on();
        $query = $this->db->query($sql);
        // pr($query->result_array()); die();
        while (!$result && $row = $query->unbuffered_row('array')) {
            // if(strtolower($row["USUARIO"]) == strtolower($usuario) && strcmp($row["CLAVE"], $clave) === 0) {

            if(strtolower($row["USUARIO"]) == strtolower($usuario) ){
                //if (strcmp($this->danecrypt->decode($row["CLAVE"]), $clave) === 0) {

                if (strcmp($row["CLAVE"], $clave) === 0) {

                    $sessionData = array(
                        "auth" => "OK",
                        "id" => $row["ID_USUARIO"],
                        "usuario" => $row["USUARIO"],
                        "tipoUsua" => $row["ID_TIPO_USUARIO"]
                    );
                    if(!empty($row["COD_ENCUESTAS"])) {
                        $sessionData["codiEncuesta"] = $row["COD_ENCUESTAS"];
                    }
                    if(!empty($row["ID_PERSONA_RESIDENTE"])) {
                        $this->codiResidente = $row["ID_PERSONA_RESIDENTE"];
                    }
                    if(!empty($row["NOMBRES"])) {
                        $sessionData['nombre'] = $row["NOMBRES"];
                        if(!empty($row["APELLIDOS"])) {
                            $sessionData['nombre'] .= ' ' . $row["APELLIDOS"];
                        }
                    }
                    if($row["ID_TIPO_USUARIO"] == 'A') {
                        $sessionData["esAdmin"] = 'SI';
                    } else if($row["ID_TIPO_USUARIO"] == 'S') {
                        $sessionData["esSoporte"] = 'SI';
                    }
                    $this->session->set_userdata($sessionData);
                    $result = true;
                }
            }
        }
        $this->db->close();
        return $result;
    }

    /**
     * Consulta los datos de los registros del admin usuarios
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarAdminUsuarios($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND AU.ID_USUARIO = '" . $arrDatos["id"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND AU.FECHA_CREACION = '" . $arrDatos["fecha"] . "'";
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND AU.ID_ESTADO_USUA = '" . $arrDatos["estado"] . "'";
        }
        if (array_key_exists("usuario", $arrDatos)) {
            $cond .= " AND AU.USUARIO = '" . $arrDatos["usuario"] . "'";
        }
        if (array_key_exists("usuarioParte", $arrDatos)) {
            $cond .= " AND AU.USUARIO LIKE '%" . $arrDatos["usuarioParte"] . "%'";
        }
        if (array_key_exists("idPers", $arrDatos)) {
            $cond .= " AND AU.ID_PERSONA_RESIDENTE = '" . $arrDatos["idPers"] . "'";
        }
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND AU.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }

        $sql = "SELECT AU.*
                FROM " . $this->sufijoTabla . "_ADMIN_USUARIOS AU
                WHERE AU.ID_USUARIO IS NOT NULL " . $cond .
                " ORDER BY AU.ID_USUARIO";
        //pr($sql); exit;
        //$this->db->cache_on();
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Consulta los datos de los usuarios y la persona asociada
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarInfoUsuarios($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND AU.ID_USUARIO = '" . $arrDatos["id"] . "'";
        }
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND AC.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("tieneCodiEncuesta", $arrDatos)) {
            if ($arrDatos["tieneCodiEncuesta"] == 'SI') {
                $cond .= " AND AC.COD_ENCUESTAS IS NOT NULL";
            } else if ($arrDatos["tieneCodiEncuesta"] == 'NO') {
                $cond .= " AND AC.COD_ENCUESTAS IS NULL";
            }
        }
        if (array_key_exists("idVivienda", $arrDatos)) {
            $cond .= " AND PH.ID_VIVIENDA = '" . $arrDatos["idVivienda"] . "'";
        }
        if (array_key_exists("idHogar", $arrDatos)) {
            $cond .= " AND PH.ID_HOGAR = '" . $arrDatos["idHogar"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND AU.FECHA_CREACION = '" . $arrDatos["fecha"] . "'";
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND AU.ID_ESTADO_USUA = '" . $arrDatos["estado"] . "'";
        }
        if (array_key_exists("tipo", $arrDatos)) {
            $cond .= " AND AU.ID_TIPO_USUARIO = '" . $arrDatos["tipo"] . "'";
        }
        if (array_key_exists("formulario", $arrDatos)) {
            $cond .= " AND AC.COD_ENCUESTAS = " . $arrDatos["formulario"];
        }
        if (array_key_exists("usuario", $arrDatos)) {
            $cond .= " AND AU.USUARIO LIKE '%" . $arrDatos["usuario"] . "%'";
        }
        if (array_key_exists("estadoForm", $arrDatos)) {
            $cond .= " AND AC.ID_ESTADO_AC = " . $arrDatos["estadoForm"];
        }
        if (array_key_exists("tipoDocu", $arrDatos)) {
            $cond .= " AND PH.PA_TIPO_DOC = '" . $arrDatos["tipoDocu"] . "'";
        }
        if (array_key_exists("numeDocu", $arrDatos)) {
            $cond .= " AND PH.PA1_NRO_DOC = '" . $arrDatos["numeDocu"] . "'";
        }
        if (array_key_exists("nombre1", $arrDatos)) {
            $cond .= " AND PR.RA2_1NOMBRE LIKE '%" . $arrDatos["nombre1"] . "%'";
        }
        if (array_key_exists("nombre2", $arrDatos)) {
            $cond .= " AND PR.RA3_2NOMBRE LIKE '%" . $arrDatos["nombre2"] . "%'";
        }
        if (array_key_exists("apellido1", $arrDatos)) {
            $cond .= " AND PR.RA4_1APELLIDO LIKE '%" . $arrDatos["apellido1"] . "%'";
        }
        if (array_key_exists("apellido2", $arrDatos)) {
            $cond .= " AND PR.RA5_2APELLIDO LIKE '%" . $arrDatos["apellido2"] . "%'";
        }
        if (array_key_exists("nombre", $arrDatos)) {
            $cond .= " AND (PR.RA2_1NOMBRE || PR.RA3_2NOMBRE || PR.RA4_1APELLIDO || PR.RA5_2APELLIDO) LIKE '%" . $arrDatos["nombre"] . "%'";
        }

        $sql = "SELECT AC.ID_ESTADO_AC, PV.DESC_VALOR_PARAM ESTADO_FORM, PV2.DESC_VALOR_PARAM ESTADO_USUA,
            PR.RA2_1NOMBRE, PR.RA3_2NOMBRE, PR.RA4_1APELLIDO, PR.RA5_2APELLIDO,
            PH.PA_TIPO_DOC, PH.PA1_NRO_DOC, PH.P_SEXO, RD.DESCRIPCION, AC.*, AU.*
            FROM " . $this->sufijoTabla . "_ADMIN_USUARIOS AU
            LEFT JOIN " . $this->sufijoTabla . "_ADMIN_CONTROL AC ON (AC.COD_ENCUESTAS = AU.COD_ENCUESTAS)
            LEFT JOIN " . $this->sufijoTabla . "_PARAM_VALORES PV ON(PV.ID_PARAM_GENERAL = 1 AND PV.VALOR_PARAM = AC.ID_ESTADO_AC)
            LEFT JOIN " . $this->sufijoTabla . "_PARAM_VALORES PV2 ON(PV2.ID_PARAM_GENERAL = 2 AND PV2.VALOR_PARAM = AU.ID_ESTADO_USUA)
            LEFT JOIN " . $this->sufijoTabla . "_PERSONAS_RESIDENTES PR ON (PR.ID_PERSONA_RESIDENTE = AU.ID_PERSONA_RESIDENTE)
            LEFT JOIN " . $this->sufijoTabla . "_PERSONAS_HOGAR PH ON (PH.ID_PERSONA_HOGAR = AU.ID_PERSONA_RESIDENTE)
            LEFT JOIN " . $this->sufijoTabla . "_RESPUESTA_DOMINIO RD ON (RD.ID_DOMINIO = 26 AND RD.VALOR_MINIMO = PH.PA_TIPO_DOC)
            WHERE AU.ID_USUARIO IS NOT NULL " . $cond;

        $sql .= (array_key_exists("sidx", $arrDatos)) ? " ORDER BY " . $arrDatos["sidx"]: " ORDER BY AU.ID_USUARIO";
        $sql .= (array_key_exists("sord", $arrDatos)) ? " " . $arrDatos["sord"]: " ASC";
        //var_dump($sql); exit;
        //$this->db->cache_on();
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $data[$i]["nombre"] = '';
            if (strlen($row["RA2_1NOMBRE"]) > 0) {
                $data[$i]["nombre"] = $row["RA2_1NOMBRE"];
            }
            if (strlen($row["RA3_2NOMBRE"]) > 0) {
                $data[$i]["nombre"] .= ' ' . trim($row["RA3_2NOMBRE"]);
            }
            if (strlen($row["RA4_1APELLIDO"]) > 0) {
                $data[$i]["nombre"] .= ' ' . trim($row["RA4_1APELLIDO"]);
            }
            if (strlen($row["RA5_2APELLIDO"]) > 0) {
                $data[$i]["nombre"] .= ' ' . trim($row["RA5_2APELLIDO"]);
            }
            if(empty($data[$i]["nombre"])) {
                $data[$i]["nombre"] = trim($row["NOMBRES"]) . ' ' . trim($row["APELLIDOS"]);
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Consulta los datos del log de usuarios
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarLogUsuarios($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND LU.ID_LOG_USUARIO = '" . $arrDatos["id"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND LU.FECHA_LOG = '" . $arrDatos["fecha"] . "'";
        }
        if (array_key_exists("accion", $arrDatos)) {
            $cond .= " AND LU.ID_ACCION = '" . $arrDatos["accion"] . "'";
        }
        if (array_key_exists("idUsua", $arrDatos)) {
            $cond .= " AND LU.ID_USUARIO = '" . $arrDatos["idUsua"] . "'";
        }

        $sql = "SELECT LU.*
            FROM CID_LOG_USUARIOS LU
            WHERE LU.ID_USUARIO IS NOT NULL " . $cond .
            " ORDER BY LU.ID_LOG_USUARIO";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Consulta los datos del log de usuarios
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarInfoLogUsuarios($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND LU.ID_LOG_USUARIO = '" . $arrDatos["id"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND LU.FECHA_LOG = '" . $arrDatos["fecha"] . "'";
        }
        if (array_key_exists("accion", $arrDatos)) {
            $cond .= " AND LU.ID_ACCION = '" . $arrDatos["accion"] . "'";
        }
        if (array_key_exists("idUsua", $arrDatos)) {
            $cond .= " AND LU.ID_USUARIO = '" . $arrDatos["idUsua"] . "'";
        }

        $sql = "SELECT LU.ID_LOG_USUARIO, PG.DESC_PARAM, LU.*
            FROM CID_LOG_USUARIOS LU
            INNER JOIN CID_FORM_USUARIOS FU ON (FU.ID_USUARIO = LU.ID_USUARIO)
            LEFT JOIN CID_PARAM_GENERAL PG ON (PG.TIPO_PARAM = 'ID_ACCION' AND PG.VALOR_PARAM = LU.ID_ACCION)
            WHERE LU.ID_USUARIO IS NOT NULL " . $cond .
            " ORDER BY LU.ID_LOG_USUARIO";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Agrega los datos del usuario
     * @access Public
     * @author oagarzond
     * @param Array $arrDatosUsua   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function agregarUsuario($arrDatosUsua) {
        $this->msgError = '';
        $idUsuario = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_ADMIN_USUARIOS');

        try {
            $arrDatosUsuario['ID_USUARIO'] = $idUsuario;
            //$arrDatosUsuario['COD_ENCUESTAS'] = '1';
            $arrDatosUsuario['FECHA_CREACION'] = 'SYSDATE';
            $arrDatosUsuario['ID_ESTADO_USUA'] = $arrDatosUsua['estado_usua'];
            $arrDatosUsuario['USUARIO'] = $arrDatosUsua['usuario'];
            $arrDatosUsuario['CLAVE'] = $arrDatosUsua['clave'];
            $arrDatosUsuario['ID_TIPO_USUARIO'] = $arrDatosUsua['tipo'];
            //$arrDatosUsuario['ID_PERSONA_RESIDENTE'] = $idResidente;
            if(!empty($arrDatosUsua['indiTeleFijo'])) {
                $arrDatosUsuario['INDICATIVO'] = $arrDatosUsua['indiTeleFijo'];
                unset($arrDatosUsua['indiTeleFijo']);
            }
            if(!empty($arrDatosUsua['teleFijo'])) {
                $arrDatosUsuario['TEL_FIJO'] = $arrDatosUsua['teleFijo'];
                unset($arrDatosUsua['teleFijo']);
            }
            if(!empty($arrDatosUsua['teleCelular'])) {
                $arrDatosUsuario['TEL_CELULAR'] = $arrDatosUsua['teleCelular'];
                unset($arrDatosUsua['teleCelular']);
            }
            if(!empty($arrDatosUsua['nombres'])) {
                $arrDatosUsuario['NOMBRES'] = $arrDatosUsua['nombres'];
                unset($arrDatosUsua['nombres']);
            }
            if(!empty($arrDatosUsua['apellidos'])) {
                $arrDatosUsuario['APELLIDOS'] = $arrDatosUsua['apellidos'];
                unset($arrDatosUsua['apellidos']);
            }
            //pr($arrDatosUsuario); exit;
            if (!$this->ejecutar_insert($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosUsuario)) {
                throw new Exception("No se pudo guardar correctamente la información del usuario. SQL: " . $this->get_sql(), 2);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Actualiza los datos del usuario
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarAdminUsuarios($arrDatosUsua) {
        $this->msgError = '';

        try {
            if(!empty($arrDatosUsua['email_usua'])) {
                $arrDatosUsuario['USUARIO'] = $arrDatosUsua['email_usua'];
            }
            if(!empty($arrDatosUsua['estado_usua'])) {
                $arrDatosUsuario['ID_ESTADO_USUA'] = $arrDatosUsua['estado_usua'];
            }
            if(!empty($arrDatosUsua['clave'])) {
                $arrDatosUsuario['CLAVE'] = $arrDatosUsua['clave'];
            }
            if(!empty($arrDatosUsua['tipo'])) {
                $arrDatosUsuario['ID_TIPO_USUARIO'] = $arrDatosUsua['tipo'];
            }
            if(!empty($arrDatosUsua['indiTeleFijo'])) {
                $arrDatosUsuario['INDICATIVO'] = $arrDatosUsua['indiTeleFijo'];
            }
            if(!empty($arrDatosUsua['teleFijo'])) {
                $arrDatosUsuario['TEL_FIJO'] = $arrDatosUsua['teleFijo'];
            }
            if(!empty($arrDatosUsua['teleCelular'])) {
                $arrDatosUsuario['TEL_CELULAR'] = $arrDatosUsua['teleCelular'];
            }
            if(!empty($arrDatosUsua['nombres'])) {
                $arrDatosUsuario['NOMBRES'] = $arrDatosUsua['nombres'];
            }
            if(!empty($arrDatosUsua['apellidos'])) {
                $arrDatosUsuario['APELLIDOS'] = $arrDatosUsua['apellidos'];
            }
            if(!empty($arrDatosUsua['idPers'])) {
                $arrDatosUsuario['ID_PERSONA_RESIDENTE'] = $arrDatosUsua['idPers'];
            }
            if(!empty($arrDatosUsua['esServidor'])) {
                $arrDatosUsuario['ES_SERVIDOR'] = $arrDatosUsua['esServidor'];
            }
            if(!empty($arrDatosUsua['codigoEntidad'])) {
                $arrDatosUsuario['COD_ENTIDAD'] = $arrDatosUsua['codigoEntidad'];
            }
            $arrWhereUsuario['ID_USUARIO'] = $this->codiUsuario;

            //pr($arrDatosUsuario);
            //pr($arrWhereUsuario); exit;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosUsuario, $arrWhereUsuario)) {
                throw new Exception("No se pudo actualizar correctamente la informacion del usuario. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Actualiza el estado de la encuesta
     * @access Public
     * @author aocubillosa
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarEstado($arrDatos) {
        $this->msgError = '';
        try {
            if(!empty($arrDatos['descripcion'])) {
                $arrDatosEncu['OBSERVACIONES'] = $arrDatos['descripcion'];
            }
            if(!empty($arrDatos['estado'])) {
                $arrDatosEncu['ID_ESTADO_AC'] = $arrDatos['estado'];
            }
            $arrDatosEncu['FECHA_CAMBIO'] = 'SYSDATE';
            $arrWhereEncu['COD_ENCUESTAS'] = $arrDatos['encuesta'];
            //pr($arrDatosEncu);
            //pr($arrWhereEncu); exit;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosEncu, $arrWhereEncu)) {
                throw new Exception("No se pudo actualizar correctamente el estado del formulario. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            $this->msgError = 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . $e->getMessage() . '</strong>';
            return false;
        }
    }

    /**
     * Actualiza el correo del usuario
     * @access Public
     * @author aocubillosa
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarCorreo($arrDatos) {
        $this->msgError = '';
        try {

            $arrWhereEncu['COD_ENCUESTAS'] = $arrDatos['encuesta'];

            if(!empty($arrDatos['primer_nombre'])) {
                $arrDatosResidente['RA2_1NOMBRE'] = $arrDatos['primer_nombre'];
                $arrDatosUsuario["NOMBRES"] = $arrDatos["primer_nombre"];
                $arrDatosPersona['PA_1ER_NOMBRE'] = $arrDatos['primer_nombre'];
            }
            if(!empty($arrDatos['segundo_nombre'])) {
                $arrDatosResidente['RA3_2NOMBRE'] = $arrDatos['segundo_nombre'];
                $arrDatosUsuario["NOMBRES"] .=  " " . $arrDatos["segundo_nombre"];
            }else{
                 $arrDatosResidente['RA3_2NOMBRE'] = "";
            }
            if(!empty($arrDatos['primer_apellido'])) {
                $arrDatosResidente['RA4_1APELLIDO'] = $arrDatos['primer_apellido'];
                $arrDatosUsuario["APELLIDOS"] = $arrDatos["primer_apellido"];
                $arrDatosPersona['PB_1ER_APELLIDO'] = $arrDatos['primer_apellido'];
            }
            if(!empty($arrDatos['segundo_apellido'])) {
                $arrDatosResidente['RA5_2APELLIDO'] = $arrDatos['segundo_apellido'];
                $arrDatosUsuario["APELLIDOS"] .=  " " . $arrDatos["segundo_apellido"];
            }else{
                $arrDatosResidente['RA5_2APELLIDO'] = "";
            }
            if(!empty($arrDatos['estado_persona']) && $arrDatos['estado_persona'] == 1) {
                $arrDatosNoAcepto['ID_OPCION'] = "99";
                $arrDatosUsuario['ID_ESTADO_USUA'] =  $arrDatos['estado_persona'];
                $arrDatosAdminControl['ID_ESTADO_AC'] =  $arrDatos['estado_persona'];

                if(!$this->ejecutar_update($this->sufijoTabla . '_NO_ACEPTO', $arrDatosNoAcepto, $arrWhereEncu)) {
                    throw new Exception("No se pudo actualizar la información de _NO_ACEPTO en registro. SQL: " . $this->get_sql(), 1);
                }

                if(!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAdminControl, $arrWhereEncu)) {
                    throw new Exception("No se pudo actualizar la información de _ADMIN_CONTROL en registro. SQL: " . $this->get_sql(), 1);
                }
            }

            $arrWhereEncu['ID_PERSONA_RESIDENTE'] = $arrDatos['usuario'];

            if(!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosResidente, $arrWhereEncu)) {
              throw new Exception("No se pudo actualizar la información de _PERSONAS_RESIDENTES en registro. SQL: " . $this->get_sql(), 1);
            }

            if(!empty($arrDatos['correo_electronico'])) {
                $arrDatosUsuario['USUARIO'] = $arrDatos['correo_electronico'];
            }

            if(!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosUsuario, $arrWhereEncu)) {
              throw new Exception("No se pudo actualizar la información de _ADMIN_USUARIOS en registro. SQL: " . $this->get_sql(), 1);
            }

            if(!empty($arrDatos['tipo_documento'])) {
                $arrDatosPersona['PA_TIPO_DOC'] = $arrDatos['tipo_documento'];
            }

            if(!empty($arrDatos['tipo_documento']) && !empty($arrDatos['numero_documento'])) {
                $arrDatosPersona['PA1_NRO_DOC'] = $arrDatos['numero_documento'];
            }

            if(!empty($arrDatos['sexo_persona'])) {
                $arrDatosPersona['P_SEXO'] = $arrDatos['sexo_persona'];
            }

            $arrWhereEncu['ID_PERSONA_HOGAR'] = $arrDatos['usuario'];
            unset($arrWhereEncu['ID_PERSONA_RESIDENTE']);

            if(!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPersona, $arrWhereEncu)) {
              throw new Exception("No se pudo actualizar la información de _PERSONAS_HOGAR en registro. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            $this->msgError = 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . $e->getMessage() . '</strong>';
            return false;
        }
    }

}
//EOC