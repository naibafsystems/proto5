<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del modulo de registro
 * @author oagarzond
 * @since  2017-03-01
 **/
class Modregistro extends My_model{

    public $msgError;
    public $msgSuccess;
    private $sufijoTabla;
    private $codiEncuesta;
    private $codiVivienda;
    private $codiHogar;
    private $idUsuario;
    private $idPeticion;

    public function __construct() {
        $this->msgError = '';
        $this->msgSuccess = '';
        $this->codiEncuesta = 0;
        $this->codiVivienda = 0;
        $this->codiHogar = 0;
        $this->idUsuario = 0;
        $this->idPeticion = 0;
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

    public function getCodiEncuesta() {
        return $this->codiEncuesta;
    }

    public function getCodiVivienda() {
        return $this->codiVivienda;
    }

    public function getCodiHogar() {
        return $this->codiHogar;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdPeticion() {
        return $this->idPeticion;
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

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function guardarRegistro_old($arrDatos) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        //$this->db->trans_begin();
        try {
            //$idEncuesta = $this->obtener_siguiente_id('SEQ_ENCUESTAS');
            $idEncuesta = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_ENCUESTAS');
            $idVivienda = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_VIVIENDA');
            $idHogar = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_HOGAR');
            $idUsuario = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_ADMIN_USUARIOS');

            $tabla = 'ENCUESTAS';
            $arrDatosEncuesta['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosEncuesta['COD_OPERACIONESTADISTICAS'] = '200502';
            $arrDatosEncuesta['COD_FORMULARIOS'] = '1965';
            $arrDatosEncuesta['COD_USUARIOS'] = '1';
            $arrDatosEncuesta['ESTADO_OPERACION'] = 'Incompleta';
            $arrDatosEncuesta['FECHA_CREACION'] = 'SYSDATE';
            if(in_array($this->config->item('tipoFormulario'), array('G', 'H'))) {
                unset($arrDatosEncuesta);
                $arrDatosEncuesta['COD_ENCUESTAS'] = $idEncuesta;
                $arrDatosEncuesta['FECHA'] = 'SYSDATE';
                $arrDatosEncuesta['FECHA_CREACION'] = 'SYSDATE';
                $tabla = $this->sufijoTabla . '_ENCUESTAS';
            }

            if (!$this->ejecutar_insert($tabla, $arrDatosEncuesta)) {
                throw new Exception("No se pudo guardar correctamente la información de la encuesta. SQL: " . $this->get_sql(), 0);
            }

            $arrDatosVivienda['UID_ORIGEN'] = 3; // Web
            $arrDatosVivienda['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosVivienda['ID_VIVIENDA'] = $idVivienda;
            $arrDatosVivienda['U_UC'] = '1';
            $arrDatosVivienda['U_VIVIENDA'] = '1';
            $arrDatosVivienda['UVA_USO_UNIDAD'] = '1';
            $arrDatosVivienda['V_CON_OCUP'] = '1';
            //$arrDatosVivienda['V_TOT_HOG'] = '1';
            // Estos campos no se llenan debido que solamente los usa DMC
            //$arrDatosVivienda['UVA_ECENSO'] = NULL;
            //$arrDatosVivienda['UVA1_MASHOG'] = NULL;
            //$arrDatosVivienda['UVA_ECENSO6'] = NULL;
            //$arrDatosVivienda['UVA1_MASHOG6'] = NULL;
            $arrDatosVivienda['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosVivienda['USUARIO_INSERCION'] = $idUsuario;
            if (!$this->ejecutar_insert($this->sufijoTabla . '_VIVIENDA', $arrDatosVivienda)) {
                throw new Exception("No se pudo guardar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 3);
            }

            $arrDatosHogar['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosHogar['ID_VIVIENDA'] = $idVivienda;
            $arrDatosHogar['ID_HOGAR'] = $idHogar;
            $arrDatosHogar['H_NROHOG'] = '1';
            // Estos campos no se llenan debido que solamente los usa DMC
            //$arrDatosVivienda['H_MASHOG'] = NULL;
            $arrDatosHogar['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosHogar['USUARIO_INSERCION'] = $idUsuario;
            if (!$this->ejecutar_insert($this->sufijoTabla . '_HOGAR', $arrDatosHogar)) {
                throw new Exception("No se pudo guardar correctamente la información del hogar. SQL: " . $this->get_sql(), 4);
            }

            $arrDatosUsuario['ID_USUARIO'] = $idUsuario;
            $arrDatosUsuario['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosUsuario['FECHA_CREACION'] = 'SYSDATE';
            $arrDatosUsuario['ID_ESTADO_USUA'] = 1;
            //$arrDatosUsuario['USUARIO'] = $arrDatos['email'];
            //$arrDatosUsuario['CLAVE'] = $arrDatos['clave'];
            $arrDatosUsuario['ID_TIPO_USUARIO'] = 'C';
            //$arrDatosUsuario['ID_PERSONA_RESIDENTE'] = $idResidente;
            /*if(!empty($arrDatos['indiTeleFijo'])) {
                $arrDatosUsuario['INDICATIVO'] = $arrDatos['indiTeleFijo'];
            }*/
            /*if(!empty($arrDatos['teleFijo'])) {
                $arrDatosUsuario['TEL_FIJO'] = $arrDatos['teleFijo'];
            }*/
            /*if(!empty($arrDatos['teleCelular'])) {
                $arrDatosUsuario['TEL_CELULAR'] = $arrDatos['teleCelular'];
            }*/
            if (!$this->ejecutar_insert($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosUsuario)) {
                throw new Exception("No se pudo guardar correctamente la información del usuario. SQL: " . $this->get_sql(), 2);
            }

            $arrDatosAC['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosAC['FECHA_REGISTRO'] = 'SYSDATE';
            $arrDatosAC['ID_ESTADO_AC'] = '1';
            $arrDatosAC['FECHA_INI_REGISTRO'] = 'SYSDATE';
            $arrDatosAC['PAG_REGISTRO'] = '2'; // Se define la siguiente ya que al crear los registros solamente debe completar
            //$arrDatosAC['FECHA_FIN_REGISTRO'] = $fechaActual;
            $arrDatosAC['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosAC['USUARIO_INSERCION'] = $idUsuario;

            if (!$this->ejecutar_insert($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC)) {
                throw new Exception("No se pudo guardar correctamente la información de control. SQL: " . $this->get_sql(), 1);
            }

            $idResidente = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_PERSONAS_RESIDENTES');

            $arrDatosResidente['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosResidente['ID_VIVIENDA'] = $idVivienda;
            $arrDatosResidente['ID_HOGAR'] = $idHogar;
            $arrDatosResidente['ID_PERSONA_RESIDENTE'] = $idResidente;
            $arrDatosResidente['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosResidente['USUARIO_INSERCION'] = $idUsuario;
            //@todo: hay que preguntar  sobre estos campos
            $arrDatosResidente['R_NROHOG'] = '1';
            $arrDatosResidente['RA1_NRO_RESI'] = '1';
            //$arrDatosResidente['RA2_1NOMBRE'] = $arrDatos['nombre1Pers'];
            /*if(!empty($arrDatos['nombre2Pers'])) {
                $arrDatosResidente['RA3_2NOMBRE'] = $arrDatos['nombre2Pers'];
            }*/
            //$arrDatosResidente['RA4_1APELLIDO'] = $arrDatos['apellido1Pers'];
            /*if(!empty($arrDatos['apellido2Pers'])) {
                $arrDatosResidente['RA5_2APELLIDO'] = $arrDatos['apellido2Pers'];
            }*/

            if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosResidente)) {
                throw new Exception("No se pudo guardar correctamente la información de la persona residente. SQL: " . $this->get_sql(), 5);
            }

            // Se utiliza la misma secuencia de la persona, ya que en el formulario fisico residentes y hogar son modulos separados
            $arrDatosPersona['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosPersona['ID_VIVIENDA'] = $idVivienda;
            $arrDatosPersona['ID_HOGAR'] = $idHogar;
            $arrDatosPersona['ID_PERSONA_HOGAR'] = $idResidente;
            $arrDatosPersona['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosPersona['USUARIO_INSERCION'] = $idUsuario;
            //@todo: hay que preguntar  sobre estos campos
            $arrDatosPersona['P_NROHOG'] = '1';
            $arrDatosPersona['P_NRO_PER'] = '1';
            //$arrDatosPersona['PA_1ER_NOMBRE'] = $arrDatos['nombre1Pers'];
            //$arrDatosPersona['PB_1ER_APELLIDO'] = $arrDatos['apellido1Pers'];
            $arrDatosPersona['PA_TIPO_DOC'] = $arrDatos['R_TIPO_DOC'];
            if(!empty($arrDatos['R1_TIPO_DOC2']) && $arrDatos['R1_TIPO_DOC2'] != 'NULL') {
                $arrDatosPersona['PA_TIPO_DOC'] = $arrDatos['R1_TIPO_DOC2'];
                unset($arrDatos['R1_TIPO_DOC2']);
            }
            $arrDatosPersona['PA1_NRO_DOC'] = $arrDatos['R2_NRO_DOC'];
            //$arrDatosPersona['P_SEXO'] = $arrDatos['sexo'];
            /*if(!empty($arrDatos['fechaNaci'])) {
                $tmpFechaNaci = explode('/', $arrDatos['fechaNaci']);
                $arrDatosPersona['PA_SABE_FECHA'] = '1';
                $arrDatosPersona['PA1_DIA_NAC'] = $tmpFechaNaci[0];
                $arrDatosPersona['PA2_MES_NAC'] = $tmpFechaNaci[1];
                $arrDatosPersona['PA3_ANO_NAC'] = $tmpFechaNaci[2];
                $arrDatosPersona['P_EDAD'] = calcula_edad(formatear_fecha($arrDatos['fechaNaci']));;
            }*/

            if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPersona)) {
                throw new Exception("No se pudo guardar correctamente la información de la persona. SQL: " . $this->get_sql(), 5);
            }

            $arrDatosACP['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosACP['ID_VIVIENDA'] = $idVivienda;
            $arrDatosACP['ID_HOGAR'] = $idHogar;
            $arrDatosACP['ID_PERSONA_RESIDENTE'] = $idResidente;
            /* Se verifica si existen los datos de peticion del ws en session para anexarlos al control de usuarios */
            $arrDatosACP['VALIDA_CEDULA'] = '3'; // Estado si se conecto o no al ws registraduria

            $se = $this->session->userdata();
            if (isset($se['peticion']))
                $arrDatosACP['ID_PETICION'] = $se['peticion'];
            if (isset($se['numeroControl']))
                $arrDatosACP['NUMERO_CONTROL'] = $se['numeroControl'];

            // validación para el dato de
            if (isset($se['estadoWs']) && isset($se['estadoData'])){
                if ($se['estadoWs'] == 0 && $se['estadoData'] != 0){
                    $arrDatosACP['VALIDA_CEDULA'] = '2';
                }
                if ($se['estadoWs'] == 0 && $se['estadoData'] == 0){
                    $arrDatosACP['VALIDA_CEDULA'] = '1';
                }
            }
            unset($se);
            /* fin codigo */

            if(!empty($arrDatos['R3_FECHA_EXPE_CC']) && $arrDatos['R3_FECHA_EXPE_CC'] != 'NULL') {
                $arrDatosACP['FECHA_EXPE_CC'] = $arrDatos['R3_FECHA_EXPE_CC'];
            }




            if (!$this->ejecutar_insert($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP)) {
                throw new Exception("No se pudo guardar correctamente la información de control de la persona. SQL: " . $this->get_sql(), 6);
            }

            $arrDatosF1['UID_ORIGEN'] = 3; // Web
            $arrDatosF1['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosF1['FECHA_ENCUESTA'] = 'SYSDATE';
            $arrDatosF1['ID_VIVIENDA'] = $idVivienda;
            $arrDatosF1['ID_HOGAR'] = $idHogar;
            $arrDatosF1['U_EDIFICA'] = '1';
            $arrDatosF1['U_VIVIENDA'] = '1';
            $arrDatosF1['UVA_USO_UNIDAD_UVA2_UNDNORESI'] = '1';
            $arrDatosF1['V_CON_OCUP'] = '1';
            $arrDatosF1['H_NROHOG'] = '1';
            $arrDatosF1['CC_RES_ENC'] = '2'; // Actualizar a 1 cuando termine la encuesta
            //$arrDatosF1['CC_COMPLETA_VIA_WEB'] = ''; //@todo: que se debe actualizar
            //$arrDatosF1['FCC_FECHA_INI'] = $fechaActual; // Ya no es necesario
            if (!$this->ejecutar_insert($this->sufijoTabla . '_FORMATO_1', $arrDatosF1)) {
                throw new Exception("No se pudo guardar correctamente la información del formato 1. SQL: " . $this->get_sql(), 6);
            }

            /*if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
            }*/
            $this->codiEncuesta = $idEncuesta;
            $this->codiVivienda = $idVivienda;
            $this->codiHogar = $idHogar;
            $this->idUsuario = $idUsuario;
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }


 public function guardarRegistro($arrDatos) {
        $this->msgError = '';

        try {

            $this->db->trans_start(FALSE);

            $idEncuesta = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_ENCUESTAS');
            $idVivienda = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_VIVIENDA');
            $idHogar = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_HOGAR');
            $idUsuario = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_ADMIN_USUARIOS');

            $tabla = 'ENCUESTAS';
            $arrDatosEncuesta['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosEncuesta['COD_OPERACIONESTADISTICAS'] = '200502';
            $arrDatosEncuesta['COD_FORMULARIOS'] = '1965';
            $arrDatosEncuesta['COD_USUARIOS'] = '1';
            $arrDatosEncuesta['ESTADO_OPERACION'] = 'Incompleta';
            $arrDatosEncuesta['FECHA_CREACION'] = 'SYSDATE';
            if(in_array($this->config->item('tipoFormulario'), array('G', 'H'))) {
                unset($arrDatosEncuesta);
                $arrDatosEncuesta['COD_ENCUESTAS'] = $idEncuesta;
                $arrDatosEncuesta['FECHA'] = 'SYSDATE';
                $arrDatosEncuesta['FECHA_CREACION'] = 'SYSDATE';
                $arrDatosEncuesta['FECHA_FIN'] = 'SYSDATE';
                $arrDatosEncuesta['DIRECCION_IP'] = getIp();
                $tabla = $this->sufijoTabla . '_ENCUESTAS';
            }


            if (!$this->db->query($this->retornar_insert_transac($tabla, $arrDatosEncuesta))) {
              throw new Exception("No se pudo insertar la información de _ENCUESTAS en registro. SQL: " . $this->get_sql(), 1);
            }

           $arrDatosVivienda['UID_ORIGEN'] = 3; // Web
            $arrDatosVivienda['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosVivienda['ID_VIVIENDA'] = $idVivienda;
            $arrDatosVivienda['U_UC'] = '1';
            $arrDatosVivienda['U_VIVIENDA'] = '1';
            $arrDatosVivienda['UVA_USO_UNIDAD'] = '1';
            $arrDatosVivienda['V_CON_OCUP'] = '1';
            $arrDatosVivienda['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosVivienda['USUARIO_INSERCION'] = $idUsuario;
           
            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_VIVIENDA', $arrDatosVivienda))) {
              throw new Exception("No se pudo insertar la información de _VIVIENDA en registro. SQL: " . $this->get_sql(), 1);
            }
           
            $arrDatosHogar['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosHogar['ID_VIVIENDA'] = $idVivienda;
            $arrDatosHogar['ID_HOGAR'] = $idHogar;
            $arrDatosHogar['H_NROHOG'] = '1';
            $arrDatosHogar['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosHogar['USUARIO_INSERCION'] = $idUsuario;

            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_HOGAR', $arrDatosHogar))) {
              throw new Exception("No se pudo insertar la información de _HOGAR en registro. SQL: " . $this->get_sql(), 1);
            }
           
            $idResidente = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_PERSONAS_RESIDENTES');

            $arrDatosResidente['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosResidente['ID_VIVIENDA'] = $idVivienda;
            $arrDatosResidente['ID_HOGAR'] = $idHogar;
            $arrDatosResidente['ID_PERSONA_RESIDENTE'] = $idResidente;
            $arrDatosResidente['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosResidente['USUARIO_INSERCION'] = $idUsuario;
            $arrDatosResidente['R_NROHOG'] = '1';
            $arrDatosResidente['RA1_NRO_RESI'] = '1';

            if(!empty($arrDatos['RA2_1NOMBRE'])) {
                $arrDatosResidente['RA2_1NOMBRE'] = $arrDatos['RA2_1NOMBRE'];
                $arrDatosUsuario["NOMBRES"] = $arrDatosResidente["RA2_1NOMBRE"];
            }
            if(!empty($arrDatos['RA3_2NOMBRE'])) {
                $arrDatosResidente['RA3_2NOMBRE'] = $arrDatos['RA3_2NOMBRE'];
                $arrDatosUsuario["NOMBRES"] .=  " " . $arrDatosResidente["RA3_2NOMBRE"];
            }
            if(!empty($arrDatos['RA4_1APELLIDO'])) {
                $arrDatosResidente['RA4_1APELLIDO'] = $arrDatos['RA4_1APELLIDO'];
                $arrDatosUsuario["APELLIDOS"] = $arrDatosResidente["RA4_1APELLIDO"];
            }
            if(!empty($arrDatos['RA5_2APELLIDO'])) {
                $arrDatosResidente['RA5_2APELLIDO'] = $arrDatos['RA5_2APELLIDO'];
                $arrDatosUsuario["APELLIDOS"] .=  " " . $arrDatosResidente["RA5_2APELLIDO"];
            }


            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosResidente))) {
              throw new Exception("No se pudo insertar la información de _PERSONAS_RESIDENTES en registro. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosUsuario['ID_USUARIO'] = $idUsuario;
            $arrDatosUsuario['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosUsuario['FECHA_CREACION'] = 'SYSDATE';
            $arrDatosUsuario['ID_ESTADO_USUA'] = 1;
            $arrDatosUsuario['USUARIO'] = $arrDatos['R_USUARIO'];
            $arrDatosUsuario['CLAVE'] = $arrDatos['R_CLAVE'];
            $arrDatosUsuario['ID_TIPO_USUARIO'] = 'C';
            $arrDatosUsuario['ID_PERSONA_RESIDENTE'] = $idResidente;

            if(!empty($arrDatos['ID_ESTADO_USUA'])) {
                $arrDatosUsuario['ID_ESTADO_USUA'] = $arrDatos['ID_ESTADO_USUA'];
            }
            if(!empty($arrDatos['R_INDICATIVO'])) {
                $arrDatosUsuario['INDICATIVO'] = $arrDatos['R_INDICATIVO'];
            }
            if(!empty($arrDatos['R_TEL_FIJO'])) {
                $arrDatosUsuario['TEL_FIJO'] = $arrDatos['R_TEL_FIJO'];
            }
            if(!empty($arrDatos['R_TEL_CELULAR'])) {
                $arrDatosUsuario['TEL_CELULAR'] = $arrDatos['R_TEL_CELULAR'];
            }

            if(!empty($arrDatos['R_ES_SERVIDOR'])) {
                $arrDatosUsuario['ES_SERVIDOR'] = $arrDatos['R_ES_SERVIDOR'];
            }
             if(!empty($arrDatos['R_COD_ENTIDAD'])) {
                $arrDatosUsuario['COD_ENTIDAD'] = $arrDatos['R_COD_ENTIDAD'];
            }

            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosUsuario))) {
              throw new Exception("No se pudo insertar la información de _ADMIN_USUARIOS en registro. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosAC['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosAC['FECHA_REGISTRO'] = 'SYSDATE';
            $arrDatosAC['ID_ESTADO_AC'] = '1';
            $arrDatosAC['FECHA_INI_REGISTRO'] = 'SYSDATE';
            $arrDatosAC['PAG_REGISTRO'] = '2'; // Se define la siguiente ya que al crear los registros solamente debe completar
            $arrDatosAC['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosAC['USUARIO_INSERCION'] = $idUsuario;

            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC))) {
              throw new Exception("No se pudo insertar la información de _ADMIN_CONTROL en registro. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosPersona['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosPersona['ID_VIVIENDA'] = $idVivienda;
            $arrDatosPersona['ID_HOGAR'] = $idHogar;
            $arrDatosPersona['ID_PERSONA_HOGAR'] = $idResidente;
            $arrDatosPersona['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosPersona['USUARIO_INSERCION'] = $idUsuario;
            $arrDatosPersona['P_NROHOG'] = '1';
            $arrDatosPersona['P_NRO_PER'] = '1';
            $arrDatosPersona['PA_1ER_NOMBRE'] = $arrDatos['PA_1ER_NOMBRE'];
            $arrDatosPersona['PB_1ER_APELLIDO'] = $arrDatos['PB_1ER_APELLIDO'];
            $arrDatosPersona['PA_TIPO_DOC'] = $arrDatos['PA_TIPO_DOC'];
            if(!empty($arrDatos['R1_TIPO_DOC2']) && $arrDatos['PA1_NRO_DOC'] != 'NULL') {
                $arrDatosPersona['PA_TIPO_DOC'] = $arrDatos['PA1_NRO_DOC'];
                unset($arrDatos['PA1_NRO_DOC']);
            }
            $arrDatosPersona['PA1_NRO_DOC'] = $arrDatos['PA1_NRO_DOC'];
            $arrDatosPersona['P_SEXO'] = $arrDatos['P_SEXO'];
            $arrDatosPersona['PA_SABE_FECHA'] = $arrDatos['PA_SABE_FECHA'];
            $arrDatosPersona['PA1_FECHA_NAC'] = $arrDatos['PA1_FECHA_NAC'];
            $arrDatosPersona['P_EDAD'] = $arrDatos['P_EDAD'];
             $arrDatosPersona['P_PARENTESCO'] = 1;

            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPersona))) {
              throw new Exception("No se pudo insertar la información de _PERSONAS_HOGAR en registro. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosACP['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosACP['ID_VIVIENDA'] = $idVivienda;
            $arrDatosACP['ID_HOGAR'] = $idHogar;
            $arrDatosACP['ID_PERSONA_RESIDENTE'] = $idResidente;

            $se = $this->session->userdata();
            if (isset($se['peticion']))
                $arrDatosACP['ID_PETICION'] = $se['peticion'];
            if (isset($se['numeroControl']))
                $arrDatosACP['NUMERO_CONTROL'] = $se['numeroControl'];

            // validación para el dato de indicadores
            if (isset($se['estadoWs']) && isset($se['estadoData'])){
                $arrDatosACP['VALIDA_CEDULA'] = '3'; // Estado si se conecto o no al ws registraduria
                if ($se['estadoWs'] == 0 && $se['estadoData'] != 0){
                    $arrDatosACP['VALIDA_CEDULA'] = '2';
                }
                if ($se['estadoWs'] == 0 && $se['estadoData'] == 0){
                    $arrDatosACP['VALIDA_CEDULA'] = '1';
                }
            }
            unset($se);

            if(!empty($arrDatos['R3_FECHA_EXPE_CC']) && $arrDatos['R3_FECHA_EXPE_CC'] != 'NULL') {
                $arrDatosACP['FECHA_EXPE_CC'] = $arrDatos['R3_FECHA_EXPE_CC'];
            }

            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP))) {
              throw new Exception("No se pudo insertar la información de _ADMIN_CONTROL_PERSONAS en registro. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosF1['UID_ORIGEN'] = 3; // Web
            $arrDatosF1['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosF1['FECHA_ENCUESTA'] = 'SYSDATE';
            $arrDatosF1['ID_VIVIENDA'] = $idVivienda;
            $arrDatosF1['ID_HOGAR'] = $idHogar;
            $arrDatosF1['U_EDIFICA'] = '1';
            $arrDatosF1['U_VIVIENDA'] = '1';
            $arrDatosF1['UVA_USO_UNIDAD_UVA2_UNDNORESI'] = '1';
            $arrDatosF1['V_CON_OCUP'] = '1';
            $arrDatosF1['H_NROHOG'] = '1';
            $arrDatosF1['CC_RES_ENC'] = '2'; // Actualizar a 1 cuando termine la encuesta

            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_FORMATO_1', $arrDatosF1))) {
                throw new Exception("No se pudo insertar la información de _FORMATO_1 en registro. SQL: " . $this->get_sql(), 1);
            }
           
           $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();

                $this->codiEncuesta = $idEncuesta;
                $this->codiVivienda = $idVivienda;
                $this->codiHogar = $idHogar;
                $this->idUsuario = $idUsuario;

                return true;
            }
           
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Consulta los datos del registro de la encuesta
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarRegistro($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;

        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND AC.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("idHogar", $arrDatos)) {
            $cond .= " AND PH.ID_HOGAR = '" . $arrDatos["idHogar"] . "'";
        }
        if (array_key_exists("idVivienda", $arrDatos)) {
            $cond .= " AND PH.ID_VIVIENDA = '" . $arrDatos["idVivienda"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND H.FECHA_INSERCION = '" . $arrDatos["fecha"] . "'";
        }

        $sql = "SELECT PH.PA_TIPO_DOC R_TIPO_DOC, PH.PA1_NRO_DOC R2_NRO_DOC, TO_CHAR(PH.PA1_FECHA_NAC, 'DD/MM/YYYY') R_FECHA_NAC, PH.P_SEXO R_SEXO,
                PR.RA2_1NOMBRE RA_1ER_NOMBRE, PR.RA3_2NOMBRE RC_2DO_NOMBRE, PR.RA4_1APELLIDO RB_1ER_APELLIDO, PR.RA5_2APELLIDO RD_2DO_APELLIDO,
                AU.TEL_FIJO R_TEL_FIJO, AU.INDICATIVO R_INDICATIVO, AU.TEL_CELULAR R_TEL_CELULAR, AU.USUARIO R_USUARIO,
                ACP.VALIDA_CEDULA, TO_CHAR(ACP.FECHA_EXPE_CC, 'DD/MM/YYYY') R3_FECHA_EXPE_CC
                FROM " . $this->sufijoTabla . "_ADMIN_CONTROL AC
                INNER JOIN " . $this->sufijoTabla . "_ADMIN_USUARIOS AU ON (AU.COD_ENCUESTAS = AC.COD_ENCUESTAS)
                INNER JOIN " . $this->sufijoTabla . "_PERSONAS_HOGAR PH ON (PH.COD_ENCUESTAS = AC.COD_ENCUESTAS)
                INNER JOIN " . $this->sufijoTabla . "_PERSONAS_RESIDENTES PR ON (PR.COD_ENCUESTAS = AC.COD_ENCUESTAS)
                INNER JOIN " . $this->sufijoTabla . "_ADMIN_CONTROL_PERSONAS ACP ON (ACP.COD_ENCUESTAS = AC.COD_ENCUESTAS)
                WHERE AC.COD_ENCUESTAS IS NOT NULL " . $cond .
                " ORDER BY AC.COD_ENCUESTAS";
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
     * Actualiza el estado y la página en que va el usuario
     * @access Public
     * @author oagarzond
     * @param   Int     $estado Estado de la encuesta
     * @return Boolean
     */
    public function actualizarEstadoAC_old($estado = 0) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            switch ($estado) {
                case 1:
                    $arrDatosAC['FECHA_INI_REGISTRO'] = 'SYSDATE';
                    $arrDatosAC['PAG_REGISTRO'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    //pr($arrDatosAC); exit;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    }
                    break;
                case 10:
                    $arrDatosAC['FECHA_FIN_REGISTRO'] = 'SYSDATE';
                    $arrDatosAC['PAG_REGISTRO'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    }
                    break;
                default:
                    $arrDatosAC['PAG_REGISTRO'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
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

    /**
     * Actualiza la contraseña del usuario
     * @access Public
     * @author etabordac
     * @return Boolean
     */
    public function almacenarToken($token, $usuario) {
        $this->msgError = '';
        try {
            $arrDatosAC['TOKEN'] = $token;
            $arrDatosAC['ESTADO_TOKEN'] = 1;
            $arrDatosAC['EXPIRACION_TOKEN'] = 'SYSDATE';
            $arrWhereAC['ID_USUARIO'] = $usuario;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosAC, $arrWhereAC)) {
               //throw new Exception("No se pudo actualizar correctamente la contrasela. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            $this->msgError = 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . $e->getMessage() . '</strong>';
            return false;
        }
    }


    /**
     * Actualiza la contraseña del usuario
     * @access Public
     * @author etabordac
     * @return Boolean
     */
    public function actualizarContrasena($usuario, $contrasena) {
        $this->msgError = '';
        try {
            $arrDatosAC['CLAVE'] = $contrasena;
            $arrWhereAC['ID_USUARIO'] = $usuario;

            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosAC, $arrWhereAC)) {
               throw new Exception("No se pudo actualizar correctamente la contrasela. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
             log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }


    }




    /**
     * Actualiza la contraseña del usuario
     * @access Public
     * @author etabordac
     * @return Boolean
     */
    public function getUsuarios() {
        $data = array();
        $i = 0;

        $sql = "SELECT AU.ID_USUARIO, AU.USUARIO, AU.CLAVE
                FROM " . $this->sufijoTabla . "_ADMIN_USUARIOS AU";
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
     * Actualiza la contraseña del usuario
     * @access Public
     * @author etabordac
     * @return Boolean
     */
    public function consultarToken($token) {
       
        //pr($sql); exit;
        try {

            $data = array();
            
            $i = 0;

            $sql = "SELECT AU.ID_USUARIO, AU.TOKEN, AU.USUARIO
                    FROM " . $this->sufijoTabla . "_ADMIN_USUARIOS AU
                    WHERE AU.TOKEN = '" . $token . "' AND ESTADO_TOKEN = 1 AND " . 'EXTRACT(HOUR FROM (SYSDATE - "EXPIRACION_TOKEN")) < 2';

            $query = $this->db->query($sql);
            $this->db->close();
        
            while ($row = $query->unbuffered_row('array')) {
                $data[$i] = $row;
                $i++;
            }

            if(count($data) > 0){
                $arrDatosAC['ESTADO_TOKEN'] = 2;
                $arrWhereAC['ID_USUARIO'] = $data[0]['ID_USUARIO'];
                $arrWhereAC['TOKEN'] = $token;
                if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosAC, $arrWhereAC)) {
                    throw new Exception("No se pudo actualizar correctamente la información de LA contraseña. SQL: " . $this->get_sql(), 1);
                }
            }
            
            return $data;

        }catch(Exception $e){
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }

        //pr($data);die;
    }

     /**
     * Actualiza la fecha inicial de la persona en el control
     * @access Public
     * @author oagarzond
     * @param   Int     $estado Estado de la encuesta
     * @return Boolean
     */
     public function actualizarEstadoAC($estado = 0) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        $estadoActual = $this->session->userdata('estado');

        try {
            switch ($estado) {
                case 2:
                    $sessionData['FECHA_INI_REGISTRO'] = 'SYSDATE';
                    $sessionData['PAG_REGISTRO'] = $estado;
                    if(!empty($sessionData)) {
                        $this->session->set_userdata($sessionData);
                    }
                    break;
                case 10:
                    $sessionData['FECHA_FIN_REGISTRO'] = 'SYSDATE';
                    $sessionData['PAG_REGISTRO'] = $estado;
                    $sessionData['fechaFinPers'] = $sessionData['FECHA_FIN_REGISTRO'];
                    if(!empty($sessionData)) {
                        $this->session->set_userdata($sessionData);
                    }
                    break;
                default:
                    $sessionData['PAG_REGISTRO'] = $estado;
                    if(!empty($sessionData)) {
                        $this->session->set_userdata($sessionData);
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

    public function guardarNoCuenta($arrDatos) {
        $this->msgError = '';

        try {
            //$this->db->trans_begin();
            //$this->db->trans_start();

            $idNoAcepto = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_NO_ACEPTO');
            $arrDatosNA['ID_NO_ACEPTO'] = $idNoAcepto;
            $arrDatosNA['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrDatosNA['FECHA_REGISTRO'] = 'SYSDATE';
            $arrDatosNA['ID_OPCION'] = $arrDatos['razon'];
            if(!empty($arrDatos['observacion'])) {
                $arrDatosNA['OBSERVACION'] = $arrDatos['observacion'];
            }

            if (!$this->ejecutar_insert($this->sufijoTabla . '_NO_ACEPTO', $arrDatosNA)) {
                throw new Exception("No se pudo guardar correctamente la información del no acepto. SQL: " . $this->get_sql(), 1);
            }

            /*$tmpFecha = explode('/', $fechaActual);
            $anioActual = $tmpFecha[2];
            $mesActual = $tmpFecha[1];
            $diaActual = $tmpFecha[0];
            $tmpFecha = explode(':', $horaActual);
            $horaActual = $tmpFecha[0];
            $minActual = $tmpFecha[1];
            $segActual = $tmpFecha[2];*/
            $idEntrevista = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_RESULTADOS_ENTREVISTA');
            $arrDatosEntrevista['COD_ENCUESTAS'] = $this->codiEncuesta;
            //@todo: preguntar porque no son obligatorios
            $arrDatosEntrevista['ID_VIVIENDA'] = $this->codiVivienda;
            $arrDatosEntrevista['ID_HOGAR'] = $this->codiHogar;
            $arrDatosEntrevista['ID_RESULTADOS_ENTREVISTA'] = $idEntrevista;
            $arrDatosEntrevista['CC_NROHOG'] = '1';
            $arrDatosEntrevista['CC_NRO_VIS'] = '1';
            //$arrDatosEntrevista['CC_HH_INI'] = $horaActual;
            //$arrDatosEntrevista['CC_MM_INI'] = $minActual;
            //$arrDatosEntrevista['CC_DIA_ENC'] = $diaActual;
            //$arrDatosEntrevista['CC_MES_ENC'] = $mesActual;
            //$arrDatosEntrevista['CC_ANO_ENC'] = $anioActual;
            $arrDatosEntrevista['CC_FECHA_INI'] = 'SYSDATE';
            $arrDatosEntrevista['CC_FECHA_FIN'] = 'SYSDATE';
            $arrDatosEntrevista['CC_RES_ENC'] = 3;
            $arrDatosEntrevista['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosEntrevista['USUARIO_INSERCION'] = $this->idUsuario;
            //pr($arrDatosEntrevista); exit;
            if (!$this->ejecutar_insert($this->sufijoTabla . '_RESULTADOS_ENTREVISTA', $arrDatosEntrevista)) {
                throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
            }
            /*$this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                    // generate an error... or use the log_message() function to log your error
            }*/
            /*if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }*/
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    public function setConsultaRegistraduria($params){
        $this->msgError = '';

        try {
            $idPeticion = $this->obtener_siguiente_id('SEQ_'.$this->sufijoTabla . '_REGIS_PETICION');
            $params['ID_PETICION'] = $idPeticion;
            if (!$this->ejecutar_insert($this->sufijoTabla . '_REGIS_PETICION', $params)) {
                throw new Exception("No se pudo guardar correctamente la información del no acepto. SQL: " . $this->get_sql(), 1);
            }

            $this->idPeticion = $idPeticion;
            return true;

        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }
}
//EOC