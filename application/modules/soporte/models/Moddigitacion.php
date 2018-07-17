<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH . 'libraries/predis/src/Autoloader.php';

/**
 * Modelo para el manejo de los formularios
 * @author oagarzond
 **/
class Moddigitacion extends My_model {

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
        $this->redis = new Redis();
        $this->redis->connect($this->config->item('redis_host'), $this->config->item('redis_port'));
        $this->redis->auth($this->config->item('redis_password'));
        $this->redis->select($this->config->item('redis_database'));
        //echo "Server is running: ".$this->redis->ping();
    }

    public function getMsgError() {
        return $this->msgError;
    }

    public function getEncuesta() {
        return $this->codiEncuesta;
    }

    public function getEncuestas(Array $params = []){
        $this->db->select('AC.*, VI.UI1_NROFOR');
        $this->db->from('WCP_ADMIN_CONTROL AC');
        $this->db->join('WCP_VIVIENDA VI','AC.COD_ENCUESTAS = VI.COD_ENCUESTAS');
        $this->db->where('VI.UID_ORIGEN', $this->config->item('UID_ORIGEN_DMC_WEB'));
        $this->db->where('AC.USUARIO_INSERCION', $this->session->id);

        if(isset($params['encuesta'])){
            $this->db->where('AC.COD_ENCUESTAS', $params['encuesta']);
        }

        $query = $this->db->get();
        $this->db->close();

        return $query->result_array();
    }

    /**
     * Metodo para agregar una encuesta vacia en la base de datos
     * NOTA: metodo modificado de Modregistro->guardarRegistro()
     * se retira la
     */
    public function addEncuesta($arrDatos = 'Hola desde el modelo') {
        $this->msgError = '';
        // pr($arrDatos); die();
        try {

            $this->db->trans_start(FALSE);

            $idEncuesta = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_ENCUESTAS');
            $idVivienda = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_VIVIENDA');
            $idHogar = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_HOGAR');
            $idUsuario = $this->session->id; // usuario que tiene la sesion iniciada
            // $idUsuario = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_ADMIN_USUARIOS');


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

            $arrDatosAC['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosAC['FECHA_REGISTRO'] = 'SYSDATE';
            $arrDatosAC['ID_ESTADO_AC'] = '11';
            $arrDatosAC['FECHA_INI_REGISTRO'] = 'SYSDATE';
            $arrDatosAC['PAG_REGISTRO'] = '2'; // Se define la siguiente ya que al crear los registros solamente debe completar
            $arrDatosAC['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosAC['USUARIO_INSERCION'] = $idUsuario;

            if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC))) {
              throw new Exception("No se pudo insertar la información de _ADMIN_CONTROL en registro. SQL: " . $this->get_sql(), 1);
            }

            // $arrDatosVivienda['UID_ORIGEN'] = 3; // Web
            $arrDatosVivienda['UID_ORIGEN'] = $this->config->item('UID_ORIGEN_DMC_WEB'); // 99 se modifica a 17; // Web por digitacion
            $arrDatosVivienda['COD_ENCUESTAS'] = $idEncuesta;
            $arrDatosVivienda['ID_VIVIENDA'] = $idVivienda;
            $arrDatosVivienda['U_UC'] = '1';
            $arrDatosVivienda['U_VIVIENDA'] = '1';
            $arrDatosVivienda['UVA_USO_UNIDAD'] = '1';
            $arrDatosVivienda['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosVivienda['USUARIO_INSERCION'] = $idUsuario;
            $arrDatosVivienda['UI1_NROFOR'] = $arrDatos['numForm'];

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

            // $idResidente = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_PERSONAS_RESIDENTES');

            // $arrDatosResidente['COD_ENCUESTAS'] = $idEncuesta;
            // $arrDatosResidente['ID_VIVIENDA'] = $idVivienda;
            // $arrDatosResidente['ID_HOGAR'] = $idHogar;
            // $arrDatosResidente['ID_PERSONA_RESIDENTE'] = $idResidente;
            // $arrDatosResidente['FECHA_INSERCION'] = 'SYSDATE';
            // $arrDatosResidente['USUARIO_INSERCION'] = $idUsuario;
            // $arrDatosResidente['R_NROHOG'] = '1';
            // $arrDatosResidente['RA1_NRO_RESI'] = '1';

            // if(!empty($arrDatos['RA2_1NOMBRE'])) {
            //     $arrDatosResidente['RA2_1NOMBRE'] = $arrDatos['RA2_1NOMBRE'];
            //     $arrDatosUsuario["NOMBRES"] = $arrDatosResidente["RA2_1NOMBRE"];
            // }
            // if(!empty($arrDatos['RA3_2NOMBRE'])) {
            //     $arrDatosResidente['RA3_2NOMBRE'] = $arrDatos['RA3_2NOMBRE'];
            //     $arrDatosUsuario["NOMBRES"] .=  " " . $arrDatosResidente["RA3_2NOMBRE"];
            // }
            // if(!empty($arrDatos['RA4_1APELLIDO'])) {
            //     $arrDatosResidente['RA4_1APELLIDO'] = $arrDatos['RA4_1APELLIDO'];
            //     $arrDatosUsuario["APELLIDOS"] = $arrDatosResidente["RA4_1APELLIDO"];
            // }
            // if(!empty($arrDatos['RA5_2APELLIDO'])) {
            //     $arrDatosResidente['RA5_2APELLIDO'] = $arrDatos['RA5_2APELLIDO'];
            //     $arrDatosUsuario["APELLIDOS"] .=  " " . $arrDatosResidente["RA5_2APELLIDO"];
            // }


            // if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosResidente))) {
            //   throw new Exception("No se pudo insertar la información de _PERSONAS_RESIDENTES en registro. SQL: " . $this->get_sql(), 1);
            // }

            // $arrDatosUsuario['ID_USUARIO'] = $idUsuario;
            // $arrDatosUsuario['COD_ENCUESTAS'] = $idEncuesta;
            // $arrDatosUsuario['FECHA_CREACION'] = 'SYSDATE';
            // $arrDatosUsuario['ID_ESTADO_USUA'] = 1;
            // $arrDatosUsuario['USUARIO'] = $arrDatos['R_USUARIO'];
            // $arrDatosUsuario['CLAVE'] = $arrDatos['R_CLAVE'];
            // $arrDatosUsuario['ID_TIPO_USUARIO'] = 'C';
            // $arrDatosUsuario['ID_PERSONA_RESIDENTE'] = $idResidente;

            // if(!empty($arrDatos['ID_ESTADO_USUA'])) {
            //     $arrDatosUsuario['ID_ESTADO_USUA'] = $arrDatos['ID_ESTADO_USUA'];
            // }
            // if(!empty($arrDatos['R_INDICATIVO'])) {
            //     $arrDatosUsuario['INDICATIVO'] = $arrDatos['R_INDICATIVO'];
            // }
            // if(!empty($arrDatos['R_TEL_FIJO'])) {
            //     $arrDatosUsuario['TEL_FIJO'] = $arrDatos['R_TEL_FIJO'];
            // }
            // if(!empty($arrDatos['R_TEL_CELULAR'])) {
            //     $arrDatosUsuario['TEL_CELULAR'] = $arrDatos['R_TEL_CELULAR'];
            // }

            // if(!empty($arrDatos['R_ES_SERVIDOR'])) {
            //     $arrDatosUsuario['ES_SERVIDOR'] = $arrDatos['R_ES_SERVIDOR'];
            // }
            //  if(!empty($arrDatos['R_COD_ENTIDAD'])) {
            //     $arrDatosUsuario['COD_ENTIDAD'] = $arrDatos['R_COD_ENTIDAD'];
            // }

            // if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_ADMIN_USUARIOS', $arrDatosUsuario))) {
            //   throw new Exception("No se pudo insertar la información de _ADMIN_USUARIOS en registro. SQL: " . $this->get_sql(), 1);
            // }



            // $arrDatosPersona['COD_ENCUESTAS'] = $idEncuesta;
            // $arrDatosPersona['ID_VIVIENDA'] = $idVivienda;
            // $arrDatosPersona['ID_HOGAR'] = $idHogar;
            // $arrDatosPersona['ID_PERSONA_HOGAR'] = $idResidente;
            // $arrDatosPersona['FECHA_INSERCION'] = 'SYSDATE';
            // $arrDatosPersona['USUARIO_INSERCION'] = $idUsuario;
            // $arrDatosPersona['P_NROHOG'] = '1';
            // $arrDatosPersona['P_NRO_PER'] = '1';
            // $arrDatosPersona['PA_1ER_NOMBRE'] = $arrDatos['PA_1ER_NOMBRE'];
            // $arrDatosPersona['PB_1ER_APELLIDO'] = $arrDatos['PB_1ER_APELLIDO'];
            // $arrDatosPersona['PA_TIPO_DOC'] = $arrDatos['PA_TIPO_DOC'];
            // if(!empty($arrDatos['R1_TIPO_DOC2']) && $arrDatos['PA1_NRO_DOC'] != 'NULL') {
            //     $arrDatosPersona['PA_TIPO_DOC'] = $arrDatos['PA1_NRO_DOC'];
            //     unset($arrDatos['PA1_NRO_DOC']);
            // }
            // $arrDatosPersona['PA1_NRO_DOC'] = $arrDatos['PA1_NRO_DOC'];
            // $arrDatosPersona['P_SEXO'] = $arrDatos['P_SEXO'];
            // $arrDatosPersona['PA_SABE_FECHA'] = $arrDatos['PA_SABE_FECHA'];
            // $arrDatosPersona['PA1_FECHA_NAC'] = $arrDatos['PA1_FECHA_NAC'];
            // $arrDatosPersona['P_EDAD'] = $arrDatos['P_EDAD'];
            //  $arrDatosPersona['P_PARENTESCO'] = 1;

            // if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPersona))) {
            //   throw new Exception("No se pudo insertar la información de _PERSONAS_HOGAR en registro. SQL: " . $this->get_sql(), 1);
            // }

            // $arrDatosACP['COD_ENCUESTAS'] = $idEncuesta;
            // $arrDatosACP['ID_VIVIENDA'] = $idVivienda;
            // $arrDatosACP['ID_HOGAR'] = $idHogar;
            // $arrDatosACP['ID_PERSONA_RESIDENTE'] = $idResidente;

            // $se = $this->session->userdata();
            // if (isset($se['peticion']))
            //     $arrDatosACP['ID_PETICION'] = $se['peticion'];
            // if (isset($se['numeroControl']))
            //     $arrDatosACP['NUMERO_CONTROL'] = $se['numeroControl'];

            // // validación para el dato de indicadores
            // if (isset($se['estadoWs']) && isset($se['estadoData'])){
            //     $arrDatosACP['VALIDA_CEDULA'] = '3'; // Estado si se conecto o no al ws registraduria
            //     if ($se['estadoWs'] == 0 && $se['estadoData'] != 0){
            //         $arrDatosACP['VALIDA_CEDULA'] = '2';
            //     }
            //     if ($se['estadoWs'] == 0 && $se['estadoData'] == 0){
            //         $arrDatosACP['VALIDA_CEDULA'] = '1';
            //     }
            // }
            // unset($se);

            // if(!empty($arrDatos['R3_FECHA_EXPE_CC']) && $arrDatos['R3_FECHA_EXPE_CC'] != 'NULL') {
            //     $arrDatosACP['FECHA_EXPE_CC'] = $arrDatos['R3_FECHA_EXPE_CC'];
            // }

            // if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP))) {
            //   throw new Exception("No se pudo insertar la información de _ADMIN_CONTROL_PERSONAS en registro. SQL: " . $this->get_sql(), 1);
            // }

            // $arrDatosF1['UID_ORIGEN'] = 3; // Web
            // $arrDatosF1['COD_ENCUESTAS'] = $idEncuesta;
            // $arrDatosF1['FECHA_ENCUESTA'] = 'SYSDATE';
            // $arrDatosF1['ID_VIVIENDA'] = $idVivienda;
            // $arrDatosF1['ID_HOGAR'] = $idHogar;
            // $arrDatosF1['U_EDIFICA'] = '1';
            // $arrDatosF1['U_VIVIENDA'] = '1';
            // $arrDatosF1['UVA_USO_UNIDAD_UVA2_UNDNORESI'] = '1';
            // $arrDatosF1['V_CON_OCUP'] = '1';
            // $arrDatosF1['H_NROHOG'] = '1';
            // $arrDatosF1['CC_RES_ENC'] = '2'; // Actualizar a 1 cuando termine la encuesta

            // if(!$this->db->query($this->retornar_insert_transac($this->sufijoTabla . '_FORMATO_1', $arrDatosF1))) {
            //     throw new Exception("No se pudo insertar la información de _FORMATO_1 en registro. SQL: " . $this->get_sql(), 1);
            // }

           $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $this->msgError = '<strong>No se creo la encuesta satisfactoriamente.</strong>';
                return false;
            }else{
                $this->db->trans_commit();

                $this->codiEncuesta = $idEncuesta;
                $this->codiVivienda = $idVivienda;
                $this->codiHogar = $idHogar;
                $this->idUsuario = $idUsuario;
                $this->msgError = '<strong>Se creo la encuesta satisfactoriamente.</strong>';
                return true;
            }

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

     public function consultarId($codiEncuesta) {
        $data = array();
        $cond = '';
        $i = 0;

        $sql = "SELECT COD_ENCUESTAS, ID_VIVIENDA, ID_HOGAR
                FROM " . $this->sufijoTabla . "_HOGAR
                WHERE COD_ENCUESTAS = " . $codiEncuesta ;
                
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }
}







