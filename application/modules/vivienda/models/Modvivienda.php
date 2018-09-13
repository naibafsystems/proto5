<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del modulo de vivienda
 * @author oagarzond
 * @since  2017-03-13
 **/
class Modvivienda extends My_model {

	public $msgError;
    public $msgSuccess;
    private $sufijoTabla;
    private $codiEncuesta;
    private $codiVivienda;
    private $totalPaginas;

	public function __construct() {
        $this->msgError = '';
        $this->msgSuccess = '';
        $this->codiEncuesta = 0;
        $this->codiVivienda = 0;
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
    public function consultarVivienda($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND VIVI.COD_ENCUESTAS = '" . $arrDatos["codiEncuesta"] . "'";
        }
        if (array_key_exists("codiVivienda", $arrDatos)) {
            $cond .= " AND VIVI.ID_VIVIENDA = '" . $arrDatos["codiVivienda"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND VIVI.FECHA_INSERCION = '" . $arrDatos["fecha"] . "'";
        }

        $sql = "SELECT VIVI.*
                FROM " . $this->sufijoTabla . "_VIVIENDA VIVI
                WHERE VIVI.ID_VIVIENDA IS NOT NULL " . $cond .
                " ORDER BY VIVI.COD_ENCUESTAS, VIVI.ID_VIVIENDA";
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
     * Actualiza los datos de la vivienda de la encuesta
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarVivienda($arrDatosVivi) {
        $this->msgError = '';

        try {
            $arrDatosVivi['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosVivi['USUARIO_MODIFICACION'] = $this->session->userdata('id');

            if(!empty($arrDatosVivi['UA1_LOCALIDAD'])) {
                if($arrDatosVivi['UA1_LOCALIDAD'] == '-') {
                    unset($arrDatosVivi['UA1_LOCALIDAD']);
                } else {
                    //$arrDatosVivi['UVA1_TIPO_BAVERCO'] = 1;
                }
            }
            if(!empty($arrDatosVivi['UA2_CPOB'])) {
                if($arrDatosVivi['UA2_CPOB'] == '-') {
                    unset($arrDatosVivi['UA2_CPOB']);
                }
            }
            if(!empty($arrDatosVivi['UVA_TIPO_CENTRO']) && strtolower($arrDatosVivi['UVA_TIPO_CENTRO']) != 'null') {
                $arrDatosVivi['UVA1_TIPO_BAVERCO'] = $arrDatosVivi['UVA_TIPO_CENTRO'];
            }
            unset($arrDatosVivi['UVA_TIPO_CENTRO']);
            if(!empty($arrDatosVivi['UVA_TIPO_RURAL']) && strtolower($arrDatosVivi['UVA_TIPO_RURAL']) != 'null') {
                $arrDatosVivi['UVA1_TIPO_BAVERCO'] = $arrDatosVivi['UVA_TIPO_RURAL'];
            }
            unset($arrDatosVivi['UVA_TIPO_RURAL']);
            // Se valida si es una cabecera no se deberia definir TIPO_BAVERCO
            if(!empty($arrDatosVivi['UA_CLASE']) && $arrDatosVivi['UA_CLASE'] == 1) {
                $arrDatosVivi['UVA1_TIPO_BAVERCO'] = 1;
                $arrDatosVivi['UVA_ESTATER'] = $arrDatosVivi['UVA1_TIPOTER'] = $arrDatosVivi['UVA2_CODTER'] = 'NULL';
                $arrDatosVivi['UVA_ESTA_AREAPROT'] = $arrDatosVivi['UVA1_COD_AREAPROT'] = $arrDatosVivi['UVA_USO_UNIDAD'] = 'NULL';
                $arrDatosVivi['UVA_VIVTERETNICO'] = $arrDatosVivi['UVA1_TER_ETNICO'] = $arrDatosVivi['UVA11_NTER_IND'] = 'NULL';
                $arrDatosVivi['UVA12_NPARC_IND'] = $arrDatosVivi['UVA13_NRES_IND'] = $arrDatosVivi['UVA14_NANC_TCCN'] = 'NULL';
                $arrDatosVivi['UVA15_NANC_RAIZAL'] = 'NULL';
            }
            if(!empty($arrDatosVivi['UVA2_CODRESGU']) && strtolower($arrDatosVivi['UVA2_CODRESGU']) != 'null') {
                $arrDatosVivi['UVA2_CODTER'] = $arrDatosVivi['UVA2_CODRESGU'];
            }
            unset($arrDatosVivi['UVA2_CODRESGU']);
            if(!empty($arrDatosVivi['UVA2_CODTERRITO']) && strtolower($arrDatosVivi['UVA2_CODTERRITO']) != 'null') {
                $arrDatosVivi['UVA2_CODTER'] = $arrDatosVivi['UVA2_CODTERRITO'];
            }
            unset($arrDatosVivi['UVA2_CODTERRITO']);
            // Se construye y valida los datos de territorios etnicos
            if(!empty($arrDatosVivi['UVA11_TER_IND'])) {
                if($arrDatosVivi['UVA11_TER_IND'] == '2' || strtolower($arrDatosVivi['UVA11_TER_IND']) == 'null') {
                    $arrDatosVivi['UVA11_TER_IND'] = '0';
                    $arrDatosVivi['UVA11_NTER_IND'] = 'NULL';
                }
            }
            if(!empty($arrDatosVivi['UVA12_PARC_IND'])) {
                if($arrDatosVivi['UVA12_PARC_IND'] == '2' || strtolower($arrDatosVivi['UVA12_PARC_IND']) == 'null') {
                    $arrDatosVivi['UVA12_PARC_IND'] = '0';
                    $arrDatosVivi['UVA12_NPARC_IND'] = 'NULL';
                }
            }
            if(!empty($arrDatosVivi['UVA13_RES_IND'])) {
                if($arrDatosVivi['UVA13_RES_IND'] == '2' || strtolower($arrDatosVivi['UVA13_RES_IND']) == 'null') {
                    $arrDatosVivi['UVA13_RES_IND'] = '0';
                    $arrDatosVivi['UVA13_NRES_IND'] = 'NULL';
                }
            }
            if(!empty($arrDatosVivi['UVA14_ANC_TCCN'])) {
                if($arrDatosVivi['UVA14_ANC_TCCN'] == '1') {
                    $arrDatosVivi['UVA14_ANC_TCCN'] = '2';
                } else if($arrDatosVivi['UVA14_ANC_TCCN'] == '2' || strtolower($arrDatosVivi['UVA14_ANC_TCCN']) == 'null') {
                    $arrDatosVivi['UVA14_ANC_TCCN'] = '0';
                    $arrDatosVivi['UVA14_NANC_TCCN'] = 'NULL';
                }
            }
            if(!empty($arrDatosVivi['UVA15_ANC_RAIZAL'])) {
                if($arrDatosVivi['UVA15_ANC_RAIZAL'] == '1') {
                    $arrDatosVivi['UVA15_ANC_RAIZAL'] = '3';
                } else if($arrDatosVivi['UVA15_ANC_RAIZAL'] == '2' || strtolower($arrDatosVivi['UVA15_ANC_RAIZAL']) == 'null') {
                    $arrDatosVivi['UVA15_ANC_RAIZAL'] = '0';
                    $arrDatosVivi['UVA15_NANC_RAIZAL'] = 'NULL';
                }
            }
            if(isset($arrDatosVivi['UVA11_TER_IND']) && isset($arrDatosVivi['UVA15_ANC_RAIZAL'])) {
                if(empty($arrDatosVivi['UVA11_TER_IND'])) {
                    $arrDatosVivi['UVA11_TER_IND'] = '0';
                }
                if(empty($arrDatosVivi['UVA12_PARC_IND'])) {
                    $arrDatosVivi['UVA12_PARC_IND'] = '0';
                }
                if(empty($arrDatosVivi['UVA13_RES_IND'])) {
                    $arrDatosVivi['UVA13_RES_IND'] = '0';
                }
                if(empty($arrDatosVivi['UVA14_ANC_TCCN'])) {
                    $arrDatosVivi['UVA14_ANC_TCCN'] = '0';
                }
                if(empty($arrDatosVivi['UVA15_ANC_RAIZAL'])) {
                    $arrDatosVivi['UVA15_ANC_RAIZAL'] = '0';
                }
                $arrDatosVivi['UVA1_TER_ETNICO'] = $arrDatosVivi['UVA11_TER_IND'] . $arrDatosVivi['UVA12_PARC_IND'] . $arrDatosVivi['UVA13_RES_IND'] . $arrDatosVivi['UVA14_ANC_TCCN'] . $arrDatosVivi['UVA15_ANC_RAIZAL'];
                unset($arrDatosVivi['UVA11_TER_IND'], $arrDatosVivi['UVA12_PARC_IND'], $arrDatosVivi['UVA13_RES_IND'], $arrDatosVivi['UVA14_ANC_TCCN'], $arrDatosVivi['UVA15_ANC_RAIZAL']);
            }
            // Se construye los datos que componen la direccion
            if(!empty($arrDatosVivi['UVA2_COMPLE_CLASE1']) && strtolower($arrDatosVivi['UVA2_COMPLE_CLASE1']) != 'null') {
                $arrDatosVivi['UVA_DIRUND'] .= ' ' . $arrDatosVivi['UVA2_COMPLE_CLASE1'];
            }
            if(!empty($arrDatosVivi['UVA1_DIRUND_CLASE2']) && strtolower($arrDatosVivi['UVA1_DIRUND_CLASE2']) != 'null') {
                $arrDatosVivi['UVA_DIRUND'] = $arrDatosVivi['UVA1_DIRUND_CLASE2'];
                unset($arrDatosVivi['UVA1_DIRUND_CLASE2']);
            }
            if(!empty($arrDatosVivi['UVA1_DIRUND_CLASE2']) && strtolower($arrDatosVivi['UVA1_DIRUND_CLASE2']) != 'null') {
                $arrDatosVivi['UVA_DIRUND'] = $arrDatosVivi['UVA1_DIRUND_CLASE2'];
                unset($arrDatosVivi['UVA1_DIRUND_CLASE2']);
            }
            if(!empty($arrDatosVivi['UVA1_DIRUND_CLASE3']) && strtolower($arrDatosVivi['UVA1_DIRUND_CLASE3']) != 'null') {
                $arrDatosVivi['UVA_DIRUND'] = $arrDatosVivi['UVA1_DIRUND_CLASE3'];
                unset($arrDatosVivi['UVA1_DIRUND_CLASE3']);
            }
            $arrWhereVivi['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereVivi['ID_VIVIENDA'] = $this->codiVivienda;

            //pr($arrDatosVivi);
            //pr($arrWhereVivi); exit;
            if (!$this->ejecutar_update($this->sufijoTabla . '_VIVIENDA', $arrDatosVivi, $arrWhereVivi)) {
                throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
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
     * @param 	Int 	$estado Estado de la encuesta
     * @return Boolean
     */
    public function actualizarEstadoAC($estado = 0) {
    	$this->msgError = '';
        $estadoActual = $this->session->userdata('estado');

		try {
			switch ($estado) {
	    		case 2:
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 5;
                    }
                    $arrDatosAC['FECHA_INI_VIVIENDA'] = 'SYSDATE';
		            $arrDatosAC['PAG_VIVIENDA'] = $estado;
		            $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
		            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
		                throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
		            } else {
                        $sessionData['paginaVivienda'] = $arrDatosAC['PAG_VIVIENDA'];
                        if($estadoActual < 11) {
                            $sessionData['estado'] = $arrDatosAC['ID_ESTADO_AC'];
                        }
                        if(!empty($sessionData)) {
                            $this->session->set_userdata($sessionData);
                        }
                    }
	    			break;
	    		case 'f':
                    $arrDatosAC['FECHA_FIN_VIVIENDA'] = 'SYSDATE';
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 6;
                    }
                    $arrDatosAC['PAG_VIVIENDA'] = $this->totalPaginas + 1;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $sessionData['paginaVivienda'] = $arrDatosAC['PAG_VIVIENDA'];
                        $sessionData['fechaFinVivi'] = $arrDatosAC['FECHA_FIN_VIVIENDA'];
                        if($estadoActual < 11) {
                            $sessionData['estado'] = $arrDatosAC['ID_ESTADO_AC'];
                        }
                        if(!empty($sessionData)) {
                            $this->session->set_userdata($sessionData);
                        }
                    }
	    			break;
                default:
                    $arrDatosAC['PAG_VIVIENDA'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $this->session->set_userdata('paginaVivienda', $arrDatosAC['PAG_VIVIENDA']);
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
     * Actualiza el estado de la ubicacion
     * @access Public
     * @author oagarzond
     * @param   Int     $estado Estado de la encuesta
     * @return Boolean
     */
    public function actualizarEstadoUbicacion($estado = 0) {
        $this->msgError = '';
        $estadoActual = $this->session->userdata('estado');

        try {
            switch ($estado) {
                case 2:
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 3;
                    }
                    $arrDatosAC['FECHA_INI_UBICACION'] = 'SYSDATE';
                    $arrDatosAC['PAG_UBICACION'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $sessionData['paginaUbicacion'] = $arrDatosAC['PAG_UBICACION'];
                        if($estadoActual < 11) {
                            $sessionData['estado'] = $arrDatosAC['ID_ESTADO_AC'];
                        }
                        if(!empty($sessionData)) {
                            $this->session->set_userdata($sessionData);
                        }
                    }
                    break;
                case 'f':
                    $arrDatosAC['FECHA_FIN_UBICACION'] = 'SYSDATE';
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 4;
                    }
                    $arrDatosAC['PAG_UBICACION'] = $this->totalPaginas + 1;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $sessionData['paginaUbicacion'] = $arrDatosAC['PAG_UBICACION'];
                        $sessionData['fechaFinUbi'] = $arrDatosAC['FECHA_FIN_UBICACION'];
                        if($estadoActual < 11) {
                            $sessionData['estado'] = $arrDatosAC['ID_ESTADO_AC'];
                        }
                        if(!empty($sessionData)) {
                            $this->session->set_userdata($sessionData);
                        }
                    }
                    break;
                default:
                    $arrDatosAC['PAG_UBICACION'] = $estado;
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $this->session->set_userdata('paginaUbicacion', $arrDatosAC['PAG_UBICACION']);
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

    public function actualizarDatosUbVv($resp) {
        
        // PARTICIONAR LA PRIMERA
        $datosInsert['FECHA_MODIFICACION'] = "SYSDATE";
        $datosInsert['USUARIO_MODIFICACION'] = $this->session->userdata('id');
        $datosInsert['U_DPTO'] = $resp["ub_codigo_depto"];
        $datosInsert['U_MPIO'] = $resp["ub_codigo_mun"];
        $datosInsert['UA_CLASE'] = $resp["ub_clase"];
        $datosInsert['UA2_CPOB'] = $resp["ub_codigo_clase_centro_poblado"];
        $datosInsert['UA1_LOCALIDAD'] = $resp["ub_codigo_clase_localidad"];
        $datosInsert['UVA1_TIPOTER'] = $resp["ub_territorio_etnico"];
        //$datosInsert['UVA1_TIPOTER'] = $resp["ub_tipo_territorio_etnico"]; 
        $datosInsert['UVA2_CODTER'] = $resp["ub_codigo_territorio_etnico"];
        $datosInsert['UVA_ESTA_AREAPROT'] = $resp["ub_area_protegida"];
        $datosInsert['UVA1_COD_AREAPROT'] = $resp["ub_codigo_area_protegida"];
        $datosInsert['U_CO'] = $resp["ub_area_coordinacion_operativa"];
        $datosInsert['U_AO'] = $resp["ub_area_operativa"];
        $datosInsert['U_UC'] = $resp["ub_codigo_cobertura"];
        $datosInsert['U_EDIFICA'] = $resp["ub_numero_edificacion"];
        $datosInsert['UVA_DIRUND'] = $resp["ub_direccion"];
        $datosInsert['UVA1_TIPO_BAVERCO'] = $resp["ub_opcion_direccion"];
        $datosInsert['UVA_USO_UNIDAD'] = $resp["ub_uso_unidad"];
        $datosInsert['UVA1_COD_OTROUSO'] = $resp["ub_opcion_mixta"];
        $datosInsert['UVA2_UNDNORESI'] = $resp["ub_opcion_no_residencial"];
        $datosInsert['U_VIVIENDA'] = $resp["ub_orden_vivienda"];
        $datosInsert['UVA_ECENSO'] = $resp["ub_diligencio_censo"];
        //$datosInsert['H_ID_JEFE'] = $resp["ub_documento_jefe"];
        //$datosInsert['H_CAMBIO_DIR'] = $resp["ub_cambio_hogar"];
        $arrWhere['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $arrWhere['ID_VIVIENDA'] = $resp["id_vivienda"];

        if (!$this->ejecutar_update($this->sufijoTabla . '_VIVIENDA', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }

        $datosInsert2['UVA1_MASHOG'] = $resp["ub_mas_hogares"];
        $datosInsert2['UVA_ECENSO6'] = $resp["ub_visitado_censo"];
        //$datosInsert['H_CERT_CENSAL'] = $resp["ub_certificado_censal"];
        $datosInsert2['UVA1_MASHOG6'] = $resp["ub12_1_mas_hogares"];
        $datosInsert2['UVA_VIVTERETNICO'] = $resp["ub_vivienda_territorio_etnico"];
        $datosInsert2['UVA11_NTER_IND'] = $resp["ub_nombre_territorio_ancestral_indigena"];
        $datosInsert2['UVA12_NPARC_IND'] = $resp["ub_nombre_territorio_asentamiento"];
        $datosInsert2['UVA13_NRES_IND'] = $resp["ub_nombre_territorio_reserva"];
        $datosInsert2['UVA14_NANC_TCCN'] = $resp["ub_nombre_territorio_ancestral_negros"];
        $datosInsert2['UVA15_NANC_RAIZAL'] = $resp["ub_nombre_territorio_sanandres"];        
        $datosInsert2['V_TIPO_VIV'] = $resp["vv_tipo_vivienda"];
        $datosInsert2['V_CON_OCUP'] = $resp["vv_ocupacion_vivienda"];
        $datosInsert2['V_TOT_HOG'] = $resp["vv_total_hogares"];
        $datosInsert2['V_MAT_PARED'] = $resp["vv_paredes"];
        $datosInsert2['V_MAT_PISO'] = $resp["vv_pisos"];
        $datosInsert2['VA_EE'] = $resp["vv_energia_electrica"];
        $datosInsert2['VA1_ESTRATO'] = $resp["vv_estrato_energia_electrica"];
        $datosInsert2['VB_ACU'] = $resp["vv_acueducto"];
        $datosInsert2['VC_ALC'] = $resp["vv_alcantarillado"];
        $datosInsert2['VD_GAS'] = $resp["vv_gas"];
        $datosInsert2['VE_RECBAS'] = $resp["vv_basura"];
        $datosInsert2['VE1_QSEM'] = $resp["vv_veces_basura"];
        $datosInsert2['VF_INTERNET'] = $resp["vv_internet"];
        $datosInsert2['V_TIPO_SERSA'] = $resp["vv_servicio_sanitario"];
            
        $arrWhere2['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $arrWhere2['ID_VIVIENDA'] = $resp["id_vivienda"];

        //pr($arrDatosVivi);
        //pr($arrWhereVivi); exit;
        if (!$this->ejecutar_update($this->sufijoTabla . '_VIVIENDA', $datosInsert2, $arrWhere2)) {
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

    public function consultarTotalHogares($id_vivienda) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT V_TOT_HOG 
                FROM " . $this->sufijoTabla . "_VIVIENDA
                WHERE ID_VIVIENDA =  " . $id_vivienda;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function consultarHogaresInsertados($id_vivienda) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT count(*) AS TOTAL 
                FROM " . $this->sufijoTabla . "_HOGAR
                WHERE ID_VIVIENDA =  " . $id_vivienda;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function respuestas($codiEncuesta) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_VIVIENDA
                WHERE COD_ENCUESTAS =  " . $codiEncuesta;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function consultaFechaInicio($codiEncuesta) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_ADMIN_CONTROL
                WHERE COD_ENCUESTAS =  " . $codiEncuesta;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }


    public function actualizarFechaInicio($codiEncuesta) {
        
        // PARTICIONAR LA PRIMERA
        $datosInsert['FECHA_INI_UBICACION'] = "SYSDATE";
        $datosInsert['FECHA_INI_VIVIENDA'] = "SYSDATE";
        $arrWhere['COD_ENCUESTAS'] = $codiEncuesta;        

        if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }

        return true;
    }

    public function actualizarFechaInicioHogar($codiEncuesta) {
        
        // PARTICIONAR LA PRIMERA
        $datosInsert['FECHA_INI_HOGAR'] = "SYSDATE";
        $arrWhere['COD_ENCUESTAS'] = $codiEncuesta;        

        if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }

        return true;
    }

     public function actualizarFechaFin($codiEncuesta) {
        
        // PARTICIONAR LA PRIMERA
        $datosInsert['FECHA_FIN_UBICACION'] = "SYSDATE";
        $datosInsert['FECHA_FIN_VIVIENDA'] = "SYSDATE";
        $arrWhere['COD_ENCUESTAS'] = $codiEncuesta;        

        if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }

        return true;
    }

    public function actualizarFechaFinHogar($codiEncuesta) {
        
        // PARTICIONAR LA PRIMERA
        $datosInsert['FECHA_FIN_HOGAR'] = "SYSDATE";
        $arrWhere['COD_ENCUESTAS'] = $codiEncuesta;        

        if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }

        return true;
    }

}
//EOC