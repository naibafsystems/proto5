<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del modulo de encuesta
 * @author oagarzond
 * @since  2017-03-08
 **/
class Modencuesta extends My_model {

	public $msgError;
    public $msgSuccess;
    private $sufijoTabla;
    private $codiEncuesta;
    private $codiVivienda;
    private $codiHogar;
    private $numeEntrevista;
    private $numeVisita;

    public function __construct() {
        $this->msgError = '';
        $this->msgSuccess = '';
        $this->codiEncuesta = 0;
        $this->numeEntrevista = 0;
        $this->numeVisita = 0;
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

    public function getNumeEntrevista() {
        return $this->numeEntrevista;
    }

    public function getNumeVisita() {
        return $this->numeVisita;
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

    /**
     * Actualiza el estado en que va el usuario
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Boolean
     */
    public function actualizarEncuestas($arrDatosE) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            if(!empty($arrDatosE['fin']) && $arrDatosE['fin'] == 'SI') {
                $arrDatosE['FECHA_FIN'] = 'SYSDATE';
                unset($arrDatosE['fin']);
            }
            $arrWhereE['COD_ENCUESTAS'] = $this->codiEncuesta;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ENCUESTAS', $arrDatosE, $arrWhereE)) {
                throw new Exception("No se pudo actualizar correctamente la información de la encuesta. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Consulta los datos de los registros del admin control
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarAdminControl($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;

        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND AC.FECHA_REGISTRO = '" . $arrDatos["fecha"] . "'";
        }
        if (array_key_exists("estado", $arrDatos)) {
            if (is_int($arrDatos["estado"])) {
                $cond .= " AND AC.ID_ESTADO_AC = " . $arrDatos["estado"];
            } else if (is_string($arrDatos["estado"])) {
                $cond .= " AND AC.ID_ESTADO_AC = '" . $arrDatos["estado"] . "'";
            } else if (is_array($arrDatos["estado"])) {
                $cond .= " AND AC.ID_ESTADO_AC IN (" . implode(",", $arrDatos["estado"]) . ")";
            }
        }
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND AC.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }

        $sql = "SELECT TO_CHAR(AC.FECHA_REGISTRO, 'DD/MM/YYYY') FECHA_INSCRIPCION, TO_CHAR(AC.FECHA_CERTI, 'DD/MM/YYYY') FECHA_CERTIFICADO,
            TO_CHAR(AC.FECHA_FIN_UBICACION, 'DD/MM/YYYY') FECHA_FIN_UBI, TO_CHAR(AC.FECHA_FIN_VIVIENDA, 'DD/MM/YYYY') FECHA_FIN_VIVI,
            TO_CHAR(AC.FECHA_FIN_HOGAR, 'DD/MM/YYYY') FECHA_FIN_HOG, TO_CHAR(AC.FECHA_FIN_PERSONAS, 'DD/MM/YYYY') FECHA_FIN_PERS, AC.*
            FROM " . $this->sufijoTabla . "_ADMIN_CONTROL AC
            WHERE AC.COD_ENCUESTAS IS NOT NULL " . $cond .
            " ORDER BY AC.COD_ENCUESTAS";
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
     * Actualiza los datos en admin_control
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Boolean
     */
    public function actualizarAdminControl($arrDatosAC) {
        $this->msgError = '';
        $fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            if(!empty($arrDatosAC['ID_ESTADO_AC']) && $arrDatosAC['ID_ESTADO_AC'] == 12) {
                $arrDatosAC['FECHA_CERTI'] = 'SYSDATE';
            }
            $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
            //pr($arrDatosAC);
            //pr($arrWhereAC); exit;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
            } else {
                if(!empty($arrDatosAC['ID_ESTADO_AC'])) {
                    $this->session->set_userdata('estado', $arrDatosAC['ID_ESTADO_AC']);
                }
                if(!empty($arrDatosAC['FECHA_CERTI'])) {
                    $this->session->set_userdata('fechaCertificado', $fechaHoraActual);
                }
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Consulta los datos de los registros del admin control personas
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarAdminControlPersonas($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND ACP.ID_PERSONA_RESIDENTE = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND ACP.ID_PERSONA_RESIDENTE = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND ACP.ID_PERSONA_RESIDENTE IN (" . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND ACP.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("codiVivienda", $arrDatos)) {
            $cond .= " AND ACP.ID_VIVIENDA = '" . $arrDatos["codiVivienda"] . "'";
        }
        if (array_key_exists("codiHogar", $arrDatos)) {
            $cond .= " AND ACP.ID_HOGAR = '" . $arrDatos["codiHogar"] . "'";
        }
        if (array_key_exists("fechaInicial", $arrDatos)) {
            $cond .= " AND ACP.FECHA_INI_PERS = '" . $arrDatos["fechaInicial"] . "'";
        }
        if (array_key_exists("fechaFinal", $arrDatos)) {
            $cond .= " AND ACP.FECHA_FIN_PERS = '" . $arrDatos["fechaFinal"] . "'";
        }

        $sql = "SELECT ACP.*
            FROM " . $this->sufijoTabla . "_ADMIN_CONTROL_PERSONAS ACP
            WHERE ACP.COD_ENCUESTAS IS NOT NULL " . $cond .
            " ORDER BY ACP.COD_ENCUESTAS";
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
     * Consulta los datos de los registros de los resultados de la entrevista
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarResultadosEntrevista($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND RE.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("codiVivienda", $arrDatos)) {
            $cond .= " AND RE.ID_VIVIENDA = '" . $arrDatos["codiVivienda"] . "'";
        }
        if (array_key_exists("codiHogar", $arrDatos)) {
            $cond .= " AND RE.ID_HOGAR = '" . $arrDatos["codiHogar"] . "'";
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND RE.CC_RES_ENC = " . $arrDatos["estado"];
        }

        $sql = "SELECT PV.DESC_VALOR_PARAM ESTADO_ENTREVISTA, TO_CHAR(RE.CC_FECHA_INI, 'DD/MM/YYYY HH:MM:SS') FECHAINI,
            TO_CHAR(RE.CC_FECHA_FIN, 'DD/MM/YYYY HH:MM:SS') FECHAFIN, RE.*
            FROM " . $this->sufijoTabla . "_RESULTADOS_ENTREVISTA RE
            INNER JOIN " . $this->sufijoTabla . "_PARAM_VALORES PV ON (PV.ID_PARAM_GENERAL = 5 AND PV.VALOR_PARAM = RE.CC_RES_ENC)
            WHERE RE.COD_ENCUESTAS IS NOT NULL " . $cond .
            " ORDER BY RE.COD_ENCUESTAS, RE.ID_RESULTADOS_ENTREVISTA";
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
	 * Obtiene el numero de la visita que está realizando el usuario
	 * @author dmdiazf
	 * @param Int 		$codiEncuesta 	Codigo de la encuesta
     * @return Int 		$visita 		Numero de la visita
	 */
	private function obtenerNumeroVisita($codiEncuesta) {
		$visita = 0;
		$sql = "SELECT COUNT(*) AS TOTAL
				FROM " . $this->sufijoTabla . "_RESULTADOS_ENTREVISTA
				WHERE COD_ENCUESTAS = $codiEncuesta";
        //pr($sql); exit;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$visita = $row->TOTAL + 1;
			}
		}
		$this->db->close();
		return $visita;
	}

    /**
     * Guarda los datos de la entrevista
     * @access Public
     * @author oagarzond
     * @param Array 	$arrDatos	Arreglo asociativo con los valores a insertar
     * @return Boolean
     */
    public function guardarEntrevista($arrDatos) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);
        //$horaActual = substr($fechaHoraActual, 11, 8);
        //$this->db->trans_begin();

        try {
            $arrRE = $this->consultarResultadosEntrevista(array('codiEncuesta' => $arrDatos['codiEncuesta']));
            $arrRE = array_pop($arrRE);
            $numeVisita = $this->obtenerNumeroVisita($arrDatos['codiEncuesta']);
            //@todo: Si llega al limite de 99 borrar registros en ECP_TIEMPOS_ENTREVISTA y ECP_RESULTADOS_ENTREVISTA (WCP_RESULTADOS_ENTREVISTA)
            if(ENVIRONMENT == 'dev') {
                $numeVisita = 1;
            }
            //pr($numeVisita); exit;
            if($numeVisita <= 0) {
            	throw new Exception("No se pudo consultar el número de la visita.", 0);
            } else if($numeVisita > 99) {
                throw new Exception("El número de la visita excede al número permitido en el sistema.", 1);
            }

            $idEntrevista = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_RESULTADOS_ENTREVISTA');
            /*$tmpFecha = explode('/', $fechaActual);
            $anioActual = $tmpFecha[2];
            $mesActual = $tmpFecha[1];
            $diaActual = $tmpFecha[0];
            $tmpFecha = explode(':', $horaActual);
            $horaActual = $tmpFecha[0];
            $minActual = $tmpFecha[1];
            $segActual = $tmpFecha[2];*/

            $arrDatosEntrevista['COD_ENCUESTAS'] = $arrDatos['codiEncuesta'];
            //@todo: preguntar porque no son obligatorios
            $arrDatosEntrevista['ID_VIVIENDA'] = $arrDatos['codiVivienda'];
            $arrDatosEntrevista['ID_HOGAR'] = $arrDatos['codiHogar'];
            $arrDatosEntrevista['ID_RESULTADOS_ENTREVISTA'] = $idEntrevista;
            $arrDatosEntrevista['CC_NROHOG'] = '1';
            $arrDatosEntrevista['CC_NRO_VIS'] = $numeVisita;
            //$arrDatosEntrevista['CC_HH_INI'] = $horaActual;
            //$arrDatosEntrevista['CC_MM_INI'] = $minActual;
            //$arrDatosEntrevista['CC_HH_FIN'] = '';
            //$arrDatosEntrevista['CC_MM_FIN'] = '';
            //$arrDatosEntrevista['CC_DIA_ENC'] = $diaActual;
            //$arrDatosEntrevista['CC_MES_ENC'] = $mesActual;
            //$arrDatosEntrevista['CC_ANO_ENC'] = $anioActual;
            $arrDatosEntrevista['CC_FECHA_INI'] = 'SYSDATE';
            if(!empty($arrRE['CC_RES_ENC'])) {
                $arrDatosEntrevista['CC_RES_ENC'] = $arrRE['CC_RES_ENC'];
            }
            //$arrDatosEntrevista['CC_COD_RECO'] = '';
            //$arrDatosEntrevista['CC_COD_SUPE'] = '';
            $arrDatosEntrevista['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosEntrevista['USUARIO_INSERCION'] = $arrDatos['idUsua'];

            if (!$this->ejecutar_insert($this->sufijoTabla . '_RESULTADOS_ENTREVISTA', $arrDatosEntrevista)) {
                throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
            }

            $arrDatosTiempos['COD_ENCUESTAS'] = $arrDatos['codiEncuesta'];
            $arrDatosTiempos['ID_RESULTADOS_ENTREVISTA'] = $idEntrevista;
            $arrDatosTiempos['CC_NROHOG'] = '1';
            $arrDatosTiempos['CC_NRO_VIS'] = $numeVisita;
            $arrDatosTiempos['FECHA_REGISTRO'] = 'SYSDATE';
            $arrDatosTiempos['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosTiempos['USUARIO_INSERCION'] = $arrDatos['idUsua'];

            if (!$this->ejecutar_insert($this->sufijoTabla . '_TIEMPOS_ENTREVISTA', $arrDatosTiempos)) {
                throw new Exception("No se pudo guardar correctamente la información de los tiempos la entrevista. SQL: " . $this->get_sql(), 3);
            }
            $this->numeEntrevista = $idEntrevista;
            $this->numeVisita = $numeVisita;
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }
	
	public function guardarEntrevistaResultado($arrDatos) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);
        //$horaActual = substr($fechaHoraActual, 11, 8);
        //$this->db->trans_begin();

        try {
            $arrRE = $this->consultarResultadosEntrevista(array('codiEncuesta' => $arrDatos['codiEncuesta']));
            $arrRE = array_pop($arrRE);
            $numeVisita = $this->obtenerNumeroVisita($arrDatos['codiEncuesta']);
            //@todo: Si llega al limite de 99 borrar registros en ECP_TIEMPOS_ENTREVISTA y ECP_RESULTADOS_ENTREVISTA (WCP_RESULTADOS_ENTREVISTA)
            if(ENVIRONMENT == 'dev') {
                $numeVisita = 1;
            }
            //pr($numeVisita); exit;
            if($numeVisita <= 0) {
            	throw new Exception("No se pudo consultar el número de la visita.", 0);
            } else if($numeVisita > 99) {
                throw new Exception("El número de la visita excede al número permitido en el sistema.", 1);
            }

            $idEntrevista = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_RESULTADOS_ENTREVISTA');
            /*$tmpFecha = explode('/', $fechaActual);
            $anioActual = $tmpFecha[2];
            $mesActual = $tmpFecha[1];
            $diaActual = $tmpFecha[0];
            $tmpFecha = explode(':', $horaActual);
            $horaActual = $tmpFecha[0];
            $minActual = $tmpFecha[1];
            $segActual = $tmpFecha[2];*/

            $arrDatosEntrevista['COD_ENCUESTAS'] = $arrDatos['codiEncuesta'];
            //@todo: preguntar porque no son obligatorios
            $arrDatosEntrevista['ID_VIVIENDA'] = $arrDatos['codiVivienda'];
            $arrDatosEntrevista['ID_HOGAR'] = $arrDatos['codiHogar'];            
            $arrDatosEntrevista['ID_RESULTADOS_ENTREVISTA'] = $idEntrevista;
			$arrDatosEntrevista['CC_NROHOG'] = $arrDatos['nroHogar'];
            $arrDatosEntrevista['CC_NRO_VIS'] = $arrDatos['nroVisita'];
            //$arrDatosEntrevista['CC_HH_INI'] = $horaActual;
            //$arrDatosEntrevista['CC_MM_INI'] = $minActual;
            //$arrDatosEntrevista['CC_HH_FIN'] = '';
            //$arrDatosEntrevista['CC_MM_FIN'] = '';
            //$arrDatosEntrevista['CC_DIA_ENC'] = $diaActual;
            //$arrDatosEntrevista['CC_MES_ENC'] = $mesActual;
            //$arrDatosEntrevista['CC_ANO_ENC'] = $anioActual;
            $arrDatosEntrevista['CC_FECHA_FIN'] = "TO_DATE('".$arrDatos['fechaFin']."', 'yyyy/mm/dd hh24:mi:ss')";
            $arrDatosEntrevista['CC_RES_ENC'] = $arrDatos['resuEntrevista'];
            
            $arrDatosEntrevista['CC_COD_RECO'] = $arrDatos['codCensista'];
            $arrDatosEntrevista['CC_COD_SUPE'] = $arrDatos['codSupervisor'];
            $arrDatosEntrevista['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosEntrevista['USUARIO_INSERCION'] = $arrDatos['idUsua'];

            if (!$this->ejecutar_insert($this->sufijoTabla . '_RESULTADOS_ENTREVISTA', $arrDatosEntrevista)) {
                throw new Exception("No se pudo guardar correctamente la información del resultado de la entrevista. SQL: " . $this->get_sql(), 2);
            }
			
            $this->numeEntrevista = $idEntrevista;
            $this->numeVisita = $numeVisita;
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }
	
	
	public function actualizarNumeCertificadoResultado($arrDatos) {
        
		$arrWhereRE['COD_ENCUESTAS'] = $arrDatos['codiEncuesta'];
		$arrWhereRE['ID_VIVIENDA'] = $arrDatos['codiVivienda'];
		$arrWhereRE['ID_HOGAR'] = $arrDatos['codiHogar'];            
		$arrDatosRE['H_CERT_CENSAL'] = $arrDatos['nume_certificado'];            
		
		
		if (!$this->ejecutar_update($this->sufijoTabla . '_HOGAR', $arrDatosRE, $arrWhereRE)) {
			throw new Exception("No se pudo actualizar correctamente la información del resultado entrevista. SQL: " . $this->get_sql(), 1);
		}
		return true;
    }

    /**
	 * Actualiza la tabla de resultados de la entrevista con la fecha y hora de salida
	 * @author dmdiazf
	 * @param 	Int $codiEncuesta 	Codigo de la encuesta
	 * @param 	Int $numeVisita 	Codigo de la visita
	 * @return 	Boolean
	 */
	public function registrarSalida($codiEncuesta, $numeVisita) {
		$this->msgError = '';

		try {
			if(empty($codiEncuesta)) {
				throw new Exception("No se definió el codigo de la encuesta.", 0);
			}
			if(empty($numeVisita)) {
				throw new Exception("No se definió el número de la visita.", 1);
			}

	        $fechaHoraActual = $this->consultar_fecha_hora();
            //$fechaActual = substr($fechaHoraActual, 0, 10);
	        //$horaActual = substr($fechaHoraActual, 11, 8);
	        //$tmpFecha = explode(':', $horaActual);
	        //$horaActual = $tmpFecha[0];
	        //$minActual = $tmpFecha[1];
	        //$segActual = $tmpFecha[2];

			$estadoVisita = $this->obtenerEstadoVisitaFormulario($codiEncuesta);

			//$arrDatosEntrevista['CC_HH_FIN'] = $horaActual;
			//$arrDatosEntrevista['CC_MM_FIN'] = $minActual;
            $arrDatosEntrevista['CC_FECHA_FIN'] = 'SYSDATE';
			$arrDatosEntrevista['CC_RES_ENC'] = $estadoVisita;
			$arrWhereEntrevista['COD_ENCUESTAS'] = $codiEncuesta;
			$arrWhereEntrevista['CC_NRO_VIS'] = $numeVisita;

			if (!$this->ejecutar_update($this->sufijoTabla . '_RESULTADOS_ENTREVISTA', $arrDatosEntrevista, $arrWhereEntrevista)) {
                throw new Exception("No se pudo guardar correctamente la información de la entrevista. SQL: " . $this->get_sql(), 2);
            }
		    return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
	}

	/**
	 * Obtiene el estado general de diligenciamiento del formulario para indicar si el formulario completo
	 * diligenciado fue completo o incompleto
	 * @author dmdiazf
	 * @param 	Int $codiEncuesta 	Codigo de la encuesta
	 * @return 	Int $estado 		Estado de la encuesta
	 */
	private function obtenerEstadoVisitaFormulario($codiEncuesta) {
		$estado = 2; //La encuesta está incompleta. VALOR POR DEFECTO
		// Falta que tenga la fecha fin de personas
		$sql = "SELECT FECHA_FIN_REGISTRO, FECHA_FIN_UBICACION, FECHA_FIN_VIVIENDA, FECHA_FIN_HOGAR, FECHA_FIN_PERSONAS
				FROM " . $this->sufijoTabla . "_ADMIN_CONTROL
				WHERE COD_ENCUESTAS = $codiEncuesta";
		//pr($sql); exit;
		$query = $this->db->query($sql);
		while ($row = $query->unbuffered_row('array')) {
			if(!empty($row['FECHA_FIN_UBICACION']) && !empty($row['FECHA_FIN_VIVIENDA']) && !empty($row['FECHA_FIN_HOGAR']) && !empty($row['FECHA_FIN_PERSONAS'])) {
				$estado = 1; //La encuesta está completa
			}
        }
        //pr($estado); exit;
		$this->db->close();
		return $estado;
	}

    /**
     * Guarda el tiempo total por modulo que se demora en responder
     * sumando los tiempos por cada pagina
     * @author oagarzond
     * @param   Int $modulo     Modulo en que se va a registrar
     * @param   Int $duracion   Tiempo que se demora entre la carga de pagina y envia a guardar
     */
    public function registrarTiempo($modulo = '', $duracion = '') {
        // Se deshabilita ya que no es necesario
        return true;
        $this->msgError = '';
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $codiHogar = $this->session->userdata('codiHogar');
        $numeEntrevista = $this->session->userdata('numeEntrevista');
        $numeVisita = $this->session->userdata('numeVisita');
        $arrTiempos = array(
            'registro' => 'TIEMPO_REGISTRO',
            'ubicacion' => 'TIEMPO_UBICACION',
            'vivienda' => 'TIEMPO_VIVIENDA',
            'hogar' => 'TIEMPO_HOGAR',
            'personas' => 'TIEMPO_PERSONAS'
        );

        try {
            $fechaHoraActual = $this->consultar_fecha_hora();
            $tiempo = $this->obtenerTiempo($arrTiempos[$modulo]);
            //pr($tiempo); exit;
            $arrWhereEntrevista['COD_ENCUESTAS'] = $codiEncuesta;
            //$arrWhereEntrevista['ID_RESULTADOS_ENTREVISTA'] = $numeEntrevista;
            $arrWhereEntrevista['CC_NRO_VIS'] = $numeVisita;
            if(empty($tiempo)) {
                $arrDatosEntrevista[$arrTiempos['hogar']] = $duracion;
                /*if (!$this->ejecutar_update('ECP_TIEMPOS_ENTREVISTA', $arrDatosEntrevista, $arrWhereEntrevista)) {
                    throw new Exception("No se pudo guardar correctamente la información de la entrevista. SQL: " . $this->get_sql(), 2);
                }*/
            } else {
                $arrTiempo = explode(":", $tiempo);
                $arrDuracion = explode(":", $duracion);
                // Actualiza únicamente los datos cuando la duracion es superior a la del dato anterior
                $segsTiempo = $arrTiempo[0] * 3600 + $arrTiempo[1] * 60 + $arrTiempo[2];
                $segsDuracion = $arrDuracion[0] * 3600 + $arrDuracion[1] * 60 + $arrDuracion[2];
                //@todo: Preguntar si el tiempo es acumulativo
                $duracion = (($arrTiempo[0] * 3600) + ($arrDuracion[0] * 3600)) . ':' . (($arrTiempo[1] * 60) + ($arrDuracion[1] * 60)) . ':' . ($arrTiempo[2] + $arrDuracion[2]);
                $arrDatosEntrevista[$arrTiempos[$modulo]] = $duracion;
                //if ($segsDuracion > $segsTiempo) {
                    /*if (!$this->ejecutar_update($this->sufijoTabla . '_TIEMPOS_ENTREVISTA', $arrDatosEntrevista, $arrWhereEntrevista)) {
                        throw new Exception("No se pudo guardar correctamente la información de la entrevista. SQL: " . $this->get_sql(), 2);
                    }*/
                //}
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Obtiene el tiempo actual que se ha empleado en una operacion de actualizacion
     * para unicamente guardar el mayor tiempo utilizado
     * @author dmdiazf
     * @since  2016-02-10
     */
    private function obtenerTiempo($campo) {
        $tiempo = '';
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        //$numeEntrevista = $this->session->userdata('numeEntrevista');
        $numeVisita = $this->session->userdata('numeVisita');

        $sql = "SELECT $campo
                FROM " . $this->sufijoTabla . "_TIEMPOS_ENTREVISTA
                WHERE COD_ENCUESTAS = $codiEncuesta
                AND CC_NRO_VIS = $numeVisita";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $tiempo = $row[$campo];
        }
        $this->db->close();
        return $tiempo;
    }

    /**
     * Actualiza el resultado de la entrevista
     * @access Public
     * @author oagarzond
     * @param   Int     $resultado  Resultado de la entrevista
     * @return Boolean
     */
    public function actualizarResultadoEntrevista($resultado = 0) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            $arrDatosRE['CC_RES_ENC'] = $resultado;
            if($resultado == 1) {
                $arrDatosRE['CC_FECHA_FIN'] = 'SYSDATE';
            }
            $arrDatosRE['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosRE['USUARIO_MODIFICACION'] = $this->session->userdata('id');
            $arrWhereRE['ID_RESULTADOS_ENTREVISTA'] = $this->session->userdata('numeEntrevista');
            $arrWhereRE['COD_ENCUESTAS'] = $this->codiEncuesta;

            if (!$this->ejecutar_update($this->sufijoTabla . '_RESULTADOS_ENTREVISTA', $arrDatosRE, $arrWhereRE)) {
                throw new Exception("No se pudo actualizar correctamente la información del resultado entrevista. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Actualiza los datos del formato 1
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarFormato1($arrDatosF1) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);
        //$horaActual = substr($fechaHoraActual, 11, 8);

        try {
            //$arrDatosF1['FECHA_MODIFICACION'] = 'SYSDATE';
            //$arrDatosF1['USUARIO_MODIFICACION'] = $this->session->userdata('id');

            //$arrWhereF1['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereF1['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWhereF1['ID_HOGAR'] = $this->codiHogar;
            if (!$this->ejecutar_update($this->sufijoTabla . '_FORMATO_1', $arrDatosF1, $arrWhereF1)) {
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
     * Consulta los datos de los tipos de solicitudes
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarTipoSolicitudes($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND PTS.ID_TIPO_SOLICITUD = " . $arrDatos["id"];
        }
        if (array_key_exists("desc", $arrDatos)) {
            $cond .= " AND PTS.DESC_TIPO_SOLICITUD LIKE '%" . $arrDatos["desc"] . "%'";
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND PTS.ESTADO_TIPO_SOLICITUD = " . $arrDatos["estado"];
        }

        $sql = "SELECT PTS.*
            FROM " . $this->sufijoTabla . "_PARAM_TIPO_SOLICITUD PTS
            WHERE PTS.ID_TIPO_SOLICITUD IS NOT NULL " . $cond .
            " ORDER BY PTS.ID_TIPO_SOLICITUD";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            //$data[$i][$kr] = html_entity_decode($vr);
            $data[$i]["ID_VALOR"] = $row["ID_TIPO_SOLICITUD"];
            $data[$i]["ETIQUETA"] = $row["DESC_TIPO_SOLICITUD"];
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Consulta los datos de las solicitudes
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarSolicitudes($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND FS.ID_SOLICITUD = " . $arrDatos["id"];
        }
        if (array_key_exists("respuesta", $arrDatos)) {
            $cond .= " AND FS.RESPUESTA LIKE '%" . $arrDatos["respuesta"] . "%'";
        }
        if (array_key_exists("observacion", $arrDatos)) {
            $cond .= " AND FS.OBSERVACION LIKE '%" . $arrDatos["observacion"] . "%'";
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND FS.ESTADO_SOLICITUD = " . $arrDatos["estado"];
        }
        if (array_key_exists("tipo", $arrDatos)) {
            $cond .= " AND FS.ID_TIPO_SOLICITUD = " . $arrDatos["tipo"];
        }

        $sql = "SELECT PTS.DESC_TIPO_SOLICITUD, FS.*
            FROM " . $this->sufijoTabla . "_FORM_SOLICITUD FS
            LEFT JOIN " . $this->sufijoTabla . "_PARAM_TIPO_SOLICITUD PTS ON (PTS.ID_TIPO_SOLICITUD = FS.ID_TIPO_SOLICITUD)
            WHERE FS.ID_SOLICITUD IS NOT NULL " . $cond .
            " ORDER BY FS.ID_SOLICITUD";
        //var_dump($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            //$data[$i][$kr] = html_entity_decode($vr);
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Agrega los datos de la solicitud
     * @access Public
     * @author oagarzond
     * @param Array $arrDatosSoli   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function agregarSolicitud($arrDatosSoli) {
        $this->msgError = '';
        $idSolicitud = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_FORM_SOLICITUD');

        try {
            $arrDatosSoli['ID_SOLICITUD'] = $idSolicitud;
            $arrDatosSoli['ESTADO_SOLICITUD'] = 1;
            //pr($arrDatosSoli); exit;
            if (!$this->ejecutar_insert($this->sufijoTabla . '_FORM_SOLICITUD', $arrDatosSoli)) {
                throw new Exception("No se pudo guardar correctamente la información de la solicitud. SQL: " . $this->get_sql(), 2);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /* metodo para actualizar la ip del usuario cuando se loguea */
    public function actualizarIp() {
        try {
            $codiEncuesta = $this->session->userdata('codiEncuesta');
            $tabla = $this->sufijoTabla . '_ENCUESTAS';
            $arrDatosEncuesta['DIRECCION_IP'] = getIp();
            $arrWhereEncuesta['COD_ENCUESTAS'] = $codiEncuesta;
            //pr($arrDatosSoli); exit;
            if (!$this->ejecutar_update($tabla, $arrDatosEncuesta, $arrWhereEncuesta)) {
                throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    public function consultaFechaFinFormulario($codiEncuesta) {
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

    public function actualizarFechaFinFormulario($codiEncuesta) {
        
        // PARTICIONAR LA PRIMERA
        $datosInsert['FECHA_CERTI'] = "SYSDATE";
        $arrWhere['COD_ENCUESTAS'] = $codiEncuesta;        

        if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }

        return true;
    }

    public function consultaVisita($codiEncuesta,$numero_visita) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_RESULTADOS_ENTREVISTA
                WHERE CC_NRO_VIS =  " . $numero_visita. " AND COD_ENCUESTAS =  " . $codiEncuesta ;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function actualizarEntrevistaResultado($arrDatos) {
        
        $arrWhereRE['COD_ENCUESTAS'] = $arrDatos['codiEncuesta'];
        $arrWhereRE['CC_NRO_VIS'] = $arrDatos['nroVisita'];
        $arrDatosEntrevista['CC_NRO_VIS'] = $arrDatos['nroVisita'];
        if($arrDatos['fechaFin']!=NULL){
            $arrDatosEntrevista['CC_FECHA_FIN'] = "TO_DATE('".$arrDatos['fechaFin']."', 'yyyy/mm/dd hh24:mi:ss')";
        }
        $arrDatosEntrevista['CC_RES_ENC'] = $arrDatos['resuEntrevista'];
        $arrDatosEntrevista['CC_COD_RECO'] = $arrDatos['codCensista'];
        $arrDatosEntrevista['CC_COD_SUPE'] = $arrDatos['codSupervisor'];
        
        
        if (!$this->ejecutar_update($this->sufijoTabla . '_RESULTADOS_ENTREVISTA', $arrDatosEntrevista, $arrWhereRE)) {
            throw new Exception("No se pudo actualizar correctamente la información del resultado entrevista. SQL: " . $this->get_sql(), 1);
        }
        return true;
    }

    public function respuestasEntrevistas($codiEncuesta) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_RESULTADOS_ENTREVISTA RE
                INNER JOIN  " . $this->sufijoTabla . "_HOGAR HG ON RE.COD_ENCUESTAS=HG.COD_ENCUESTAS 
                WHERE RE.COD_ENCUESTAS =  " . $codiEncuesta. " ORDER BY ID_RESULTADOS_ENTREVISTA DESC ";
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