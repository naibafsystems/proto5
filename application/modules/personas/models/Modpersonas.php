<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del modulo de vivienda
 * @author oagarzond
 * @since  2017-02-21
 **/
class Modpersonas extends MY_model {

    public $msgError;
    public $msgSuccess;
    private $sufijoTabla;
    private $codiEncuesta;
    private $codiVivienda;
    private $codiHogar;
    private $codiPersona;
    private $numeroPersona;
    private $totalPaginas;

    public function __construct() {
        $this->msgError = '';
        $this->msgSuccess = '';
        $this->codiEncuesta = 0;
        $this->codiVivienda = 0;
        $this->codiHogar = 0;
        $this->codiPersona = 0;
        $this->numeroPersona = 0;
        $this->totalPaginas = 0;
        $this->sufijoTabla = 'ECP';
        if(in_array($this->config->item('tipoFormulario'), array('G', 'H'))) {
            $this->sufijoTabla = 'WCP';
        }
    }

    public function getMsgError() {
        return $this->msgError;
    }

    public function getCodiPersona() {
        return $this->codiPersona;
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

    public function setCodiPersona($codiPersona) {
        $this->codiPersona = $codiPersona;
    }

    public function setNumeroPersona($numeroPersona) {
        $this->numeroPersona = $numeroPersona;
    }

    public function setTotalPaginas($totalPaginas) {
        $this->totalPaginas = $totalPaginas;
    }

    /**
     * Consulta los datos de las personas
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarPersonas($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            if (is_int($arrDatos["codiEncuesta"]) && $arrDatos["codiEncuesta"] > 0) {
                $cond .= " AND PH.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
            } else if (is_string($arrDatos["codiEncuesta"])) {
                $cond .= " AND PH.COD_ENCUESTAS = '" . $arrDatos["codiEncuesta"] . "'";
            } else if (is_array($arrDatos["codiEncuesta"])) {
                $cond .= " AND PH.COD_ENCUESTAS IN (" . implode(",", $arrDatos["codiEncuesta"]) . ")";
            }
        }
        if (array_key_exists("codiVivienda", $arrDatos)) {
            $cond .= " AND PH.ID_VIVIENDA = '" . $arrDatos["codiVivienda"] . "'";
        }
        if (array_key_exists("codiHogar", $arrDatos)) {
            $cond .= " AND PH.ID_HOGAR = '" . $arrDatos["codiHogar"] . "'";
        }
        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR IN (" . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (array_key_exists("numePers", $arrDatos)) {
            if (is_int($arrDatos["numePers"])) {
                $cond .= " AND PH.P_NRO_PER = " . $arrDatos["numePers"];
            } else if (is_string($arrDatos["numePers"])) {
                $cond .= " AND PH.P_NRO_PER = '" . $arrDatos["numePers"] . "'";
            } else if (is_array($arrDatos["numePers"])) {
                $cond .= " AND PH.P_NRO_PER IN (" . implode(",", $arrDatos["numePers"]) . ")";
            }
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND PH.ID_ESTADO_PERS = " . $arrDatos["estado"];
        }
        if (array_key_exists("formulario", $arrDatos)) {
            $cond .= " AND PH.COD_ENCUESTAS = " . $arrDatos["formulario"];
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

        $sql = "SELECT PR.RA2_1NOMBRE, PR.RA3_2NOMBRE, PR.RA4_1APELLIDO, PR.RA5_2APELLIDO, PR.ID_PERSONA_RESIDENTE,
                PR.RA1_NRO_RESI, ACP.VALIDA_CEDULA, TO_CHAR(ACP.FECHA_EXPE_CC, 'DD/MM/YYYY') FECHAEXPE, ACP.FECHA_INI_PERS,
                ACP.FECHA_FIN_PERS, ACP.PAG_PERS, TO_CHAR(PH.PA1_FECHA_NAC, 'DD/MM/YYYY') FECHANACI, PH.*, ACU.ID_USUARIO REGISTRO, HO.H_ID_JEFE
                FROM " . $this->sufijoTabla . "_PERSONAS_HOGAR PH
                INNER JOIN " . $this->sufijoTabla . "_PERSONAS_RESIDENTES PR ON (PR.COD_ENCUESTAS = PH.COD_ENCUESTAS AND PR.ID_VIVIENDA = PH.ID_VIVIENDA AND PR.ID_HOGAR = PH.ID_HOGAR AND PR.ID_PERSONA_RESIDENTE = PH.ID_PERSONA_HOGAR)
                LEFT JOIN " . $this->sufijoTabla . "_ADMIN_CONTROL_PERSONAS ACP ON (ACP.COD_ENCUESTAS = PH.COD_ENCUESTAS AND ACP.ID_VIVIENDA = PH.ID_VIVIENDA AND ACP.ID_HOGAR = PH.ID_HOGAR AND ACP.ID_PERSONA_RESIDENTE = PH.ID_PERSONA_HOGAR)
                LEFT JOIN " . $this->sufijoTabla . "_ADMIN_USUARIOS ACU ON (ACU.ID_PERSONA_RESIDENTE = PH.ID_PERSONA_HOGAR)
                LEFT JOIN " . $this->sufijoTabla . "_HOGAR HO ON (HO.COD_ENCUESTAS = PH.COD_ENCUESTAS AND HO.ID_VIVIENDA = PH.ID_VIVIENDA AND HO.ID_HOGAR = PH.ID_HOGAR AND PH.PA1_NRO_DOC = HO.H_ID_JEFE)
                WHERE PH.ID_PERSONA_HOGAR IS NOT NULL " . $cond;

        $sql .= (array_key_exists("sidx", $arrDatos)) ? " ORDER BY " . $arrDatos["sidx"]: " ORDER BY PH.ID_PERSONA_HOGAR";
        $sql .= (array_key_exists("sord", $arrDatos)) ? " " . $arrDatos["sord"]: " ASC";

        //var_dump($sql); exit;
        // pr($sql); die();
        //$this->db->cache_on();
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $data[$i]["id"] = $row["ID_PERSONA_HOGAR"];
            $data[$i]["tipoDocu"] = $row["PA_TIPO_DOC"];
            $data[$i]["numeDocu"] = $row["PA1_NRO_DOC"];
            $data[$i]["sexo"] = $row["P_SEXO"];
            $data[$i]["nombres"] = $row["RA2_1NOMBRE"] . " " . $row["RA3_2NOMBRE"];
            $data[$i]["apellidos"] = $row["RA4_1APELLIDO"] . " " . $row["RA5_2APELLIDO"];
            $data[$i]["nombre"] = $row["RA2_1NOMBRE"];
            if (strlen($row["RA3_2NOMBRE"]) > 0) {
                $data[$i]["nombre"] .= ' ' . trim($row["RA3_2NOMBRE"]);
                $data[$i]["PC_2DO_NOMBRE"] = trim($row["RA3_2NOMBRE"]);
            }
            if (strlen($row["RA4_1APELLIDO"]) > 0) {
                $data[$i]["nombre"] .= ' ' . trim($row["RA4_1APELLIDO"]);
            }
            if (strlen($row["RA5_2APELLIDO"]) > 0) {
                $data[$i]["nombre"] .= ' ' . trim($row["RA5_2APELLIDO"]);
                $data[$i]["PD_2DO_APELLIDO"] = trim($row["RA3_2NOMBRE"]);
            }
            if(!empty($row["PA1_DIA_NAC"])) {
                $data[$i]["fechaNaci"] = str_pad($row["PA1_DIA_NAC"], 2, '0', STR_PAD_LEFT) . '/' . str_pad($row["PA2_MES_NAC"], 2, '0', STR_PAD_LEFT) . '/' . $row["PA3_ANO_NAC"];
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Consulta los datos de las personas residentes
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarPersonasResidentes($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND PR.ID_PERSONA_RESIDENTE = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND PR.ID_PERSONA_RESIDENTE = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND PR.ID_PERSONA_RESIDENTE IN (" . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (array_key_exists("noIdPers", $arrDatos)) {
            if (is_int($arrDatos["noIdPers"])) {
                $cond .= " AND PR.ID_PERSONA_RESIDENTE != " . $arrDatos["noIdPers"];
            } else if (is_string($arrDatos["noIdPers"])) {
                $cond .= " AND PR.ID_PERSONA_RESIDENTE != '" . $arrDatos["noIdPers"] . "'";
            } else if (is_array($arrDatos["noIdPers"])) {
                $cond .= " AND PR.ID_PERSONA_RESIDENTE NOT IN (" . implode(",", $arrDatos["noIdPers"]) . ")";
            }
        }
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND PR.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("codiVivienda", $arrDatos)) {
            $cond .= " AND PR.ID_VIVIENDA = '" . $arrDatos["codiVivienda"] . "'";
        }
        if (array_key_exists("codiHogar", $arrDatos)) {
            $cond .= " AND PR.ID_HOGAR = '" . $arrDatos["codiHogar"] . "'";
        }
        if (array_key_exists("numePers", $arrDatos)) {
            $cond .= " AND PR.RA1_NRO_RESI = '" . $arrDatos["numePers"] . "'";
        }


        $sql = "SELECT PR.*
                FROM " . $this->sufijoTabla . "_PERSONAS_RESIDENTES PR
                WHERE PR.ID_PERSONA_RESIDENTE IS NOT NULL " . $cond;

        $sql .= (array_key_exists("sidx", $arrDatos)) ? " ORDER BY " . $arrDatos["sidx"]: " ORDER BY PR.ID_PERSONA_RESIDENTE";
        $sql .= (array_key_exists("sord", $arrDatos)) ? " " . $arrDatos["sord"]: " ASC";

        //pr($sql); exit;
        //$this->db->cache_on();
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $data[$i]['nombre'] = $row['RA2_1NOMBRE'];
            if(!empty($row['RA3_2NOMBRE'])) {
                $data[$i]['nombre'] .= ' ' . $row['RA3_2NOMBRE'];
            }
            if(!empty($row['RA4_1APELLIDO'])) {
                $data[$i]['nombre'] .= ' ' . $row['RA4_1APELLIDO'];
            }
            if(!empty($row['RA5_2APELLIDO'])) {
                $data[$i]['nombre'] .= ' ' . $row['RA5_2APELLIDO'];
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Consulta los datos de las personas hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarPersonasHogar($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR IN (" . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (array_key_exists("noIdPers", $arrDatos)) {
            if (is_int($arrDatos["noIdPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR != " . $arrDatos["noIdPers"];
            } else if (is_string($arrDatos["noIdPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR != '" . $arrDatos["noIdPers"] . "'";
            } else if (is_array($arrDatos["noIdPers"])) {
                $cond .= " AND PH.ID_PERSONA_HOGAR NOT IN (" . implode(",", $arrDatos["noIdPers"]) . ")";
            }
        }
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND PH.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("codiVivienda", $arrDatos)) {
            $cond .= " AND PH.ID_VIVIENDA = '" . $arrDatos["codiVivienda"] . "'";
        }
        if (array_key_exists("codiHogar", $arrDatos)) {
            $cond .= " AND PH.ID_HOGAR = '" . $arrDatos["codiHogar"] . "'";
        }

        $sql = "SELECT PH.*
                FROM " . $this->sufijoTabla . "_PERSONAS_HOGAR PH
                WHERE PH.ID_PERSONA_HOGAR IS NOT NULL " . $cond;

        $sql .= (array_key_exists("sidx", $arrDatos)) ? " ORDER BY " . $arrDatos["sidx"]: " ORDER BY PH.ID_PERSONA_HOGAR";
        $sql .= (array_key_exists("sord", $arrDatos)) ? " " . $arrDatos["sord"]: " ASC";

        //pr($sql); exit;
        //$this->db->cache_on();
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $data[$i]['nombre'] = $row['PA_1ER_NOMBRE'];
            if(!empty($row['RA4_1APELLIDO'])) {
                $data[$i]['nombre'] .= ' ' . $row['PB_1ER_APELLIDO'];
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Consulta los datos de las personas fallecidas
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarPersonasFallecidas($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;

        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND PF.ID_PERSONA_FALLECIDA = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND PF.ID_PERSONA_FALLECIDA = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND PF.ID_PERSONA_FALLECIDA IN (" . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (array_key_exists("codiEncuesta", $arrDatos)) {
            $cond .= " AND PF.COD_ENCUESTAS = " . $arrDatos["codiEncuesta"];
        }
        if (array_key_exists("codiVivienda", $arrDatos)) {
            $cond .= " AND PF.ID_VIVIENDA = '" . $arrDatos["codiVivienda"] . "'";
        }
        if (array_key_exists("codiHogar", $arrDatos)) {
            $cond .= " AND PF.ID_HOGAR = '" . $arrDatos["codiHogar"] . "'";
        }

        $sql = "SELECT PF.*
                FROM " . $this->sufijoTabla . "_PERSONAS_FALLECIDAS PF
                WHERE PF.ID_PERSONA_FALLECIDA IS NOT NULL " . $cond .
                " ORDER BY PF.ID_PERSONA_FALLECIDA";
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
     * Consulta los datos de control de las personas
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultarControlPersonasResidentes($arrDatos) {
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
        if (array_key_exists("numePers", $arrDatos)) {
            if (is_int($arrDatos["numePers"])) {
                $cond .= " AND PR.RA1_NRO_RESI = " . $arrDatos["numePers"];
            } else if (is_string($arrDatos["numePers"])) {
                $cond .= " AND PR.RA1_NRO_RESI = '" . $arrDatos["numePers"] . "'";
            } else if (is_array($arrDatos["numePers"])) {
                $cond .= " AND PR.RA1_NRO_RESI IN (" . implode(",", $arrDatos["numePers"]) . ")";
            }
        }

        $sql = "SELECT PR.RA2_1NOMBRE, PR.RA3_2NOMBRE, PR.RA4_1APELLIDO, PR.RA5_2APELLIDO, PR.ID_PERSONA_RESIDENTE,
                PR.RA1_NRO_RESI, ACP.*
                FROM " . $this->sufijoTabla . "_ADMIN_CONTROL_PERSONAS ACP
                INNER JOIN " . $this->sufijoTabla . "_PERSONAS_RESIDENTES PR ON (ACP.ID_PERSONA_RESIDENTE = PR.ID_PERSONA_RESIDENTE)
                WHERE PR.ID_PERSONA_RESIDENTE IS NOT NULL " . $cond;

        $sql .= (array_key_exists("sidx", $arrDatos)) ? " ORDER BY " . $arrDatos["sidx"]: " ORDER BY ACP.ID_PERSONA_RESIDENTE";
        $sql .= (array_key_exists("sord", $arrDatos)) ? " " . $arrDatos["sord"]: " ASC";

        //pr($sql); exit;
        //$this->db->cache_on();
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            //$data[$i] = $row;
            foreach ($row as $kr => $vr) {
                $data[$i][$kr] = html_entity_decode($vr);
            }
            $data[$i]['nombre'] = $row['RA2_1NOMBRE'];
            if(!empty($row['RA3_2NOMBRE'])) {
                $data[$i]['nombre'] .= ' ' . $row['RA3_2NOMBRE'];
            }
            if(!empty($row['RA4_1APELLIDO'])) {
                $data[$i]['nombre'] .= ' ' . $row['RA4_1APELLIDO'];
            }
            if(!empty($row['RA5_2APELLIDO'])) {
                $data[$i]['nombre'] .= ' ' . $row['RA5_2APELLIDO'];
            }
            $i++;
        }
        $this->db->close();
        return $data;
    }

    /**
     * Agrega los datos de la persona por hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatosPers   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function agregarPersona($arrDatosPers) {
        // Se utiliza la misma secuencia para el ID de la persona en residente y hogar
        $idResidente = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_PERSONAS_RESIDENTES');

        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            if(!empty($arrDatosPers['P_JEFE_HOGAR']) && $arrDatosPers['P_JEFE_HOGAR'] == 1) {
                $numePers = 1;
                $arrDatosPers['P_PARENTESCO'] = $numePers;
            } else {
                $arrParamPers = array(
                    'codiEncuesta' => $this->codiEncuesta,
                    'codiVivienda' => $this->codiVivienda,
                    'codiHogar' => $this->codiHogar,
                    'sidx' => 'P_NRO_PER',
                    'sord' => 'DESC'
                );
                $arrPers = $this->consultarPersonas($arrParamPers);
                $arrPers = array_shift($arrPers);
                $numePers = $numePersAnte = intval($arrPers['P_NRO_PER']) + 1;
            }
            unset($arrDatosPers['P_JEFE_HOGAR']);
            // if(!empty($arrDatosPers['PC_2DO_NOMBRE'])) {
                $arrDatosResi['RA3_2NOMBRE'] = $arrDatosPers['PC_2DO_NOMBRE'];
                unset($arrDatosPers['PC_2DO_NOMBRE']);
            // }
            // if(!empty($arrDatosPers['PD_2DO_APELLIDO'])) {
                $arrDatosResi['RA5_2APELLIDO'] = $arrDatosPers['PD_2DO_APELLIDO'];
                unset($arrDatosPers['PD_2DO_APELLIDO']);
            // }

            $arrDatosResi['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrDatosResi['ID_VIVIENDA'] = $this->codiVivienda;
            $arrDatosResi['ID_HOGAR'] = $this->codiHogar;
            $arrDatosResi['ID_PERSONA_RESIDENTE'] = $idResidente;
            $arrDatosResi['R_NROHOG'] = '1';
            $arrDatosResi['RA1_NRO_RESI'] = $numePers;
            $arrDatosResi['RA2_1NOMBRE'] = $arrDatosPers['PA_1ER_NOMBRE'];
            $arrDatosResi['RA4_1APELLIDO'] = $arrDatosPers['PB_1ER_APELLIDO'];
            $arrDatosResi['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosResi['USUARIO_INSERCION'] = $this->session->userdata('id');
            // pr($arrDatosResi);die();
            if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosResi)) {
                throw new Exception("No se pudo agregar correctamente la información de la persona residente del hogar. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosPers['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrDatosPers['ID_VIVIENDA'] = $this->codiVivienda;
            $arrDatosPers['ID_HOGAR'] = $this->codiHogar;
            $arrDatosPers['ID_PERSONA_HOGAR'] = $idResidente;
            $arrDatosPers['P_NROHOG'] = '1';
            $arrDatosPers['P_NRO_PER'] = $numePers;
            $arrDatosPers['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosPers['USUARIO_INSERCION'] = $this->session->userdata('id');
            if(!empty($arrDatosPers['FECHA_EXPE_CC'])) {
                $arrDatosACP['VALIDA_CEDULA'] = '3'; // Estado si se conecto o no al ws registraduria
                $arrDatosACP['FECHA_EXPE_CC'] = $arrDatosPers['FECHA_EXPE_CC'];
                unset($arrDatosPers['FECHA_EXPE_CC']);
            }
            //pr($arrDatosPers); exit;
            if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPers)) {
                throw new Exception("No se pudo agregar correctamente la información de la persona del hogar. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosACP['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrDatosACP['ID_VIVIENDA'] = $this->codiVivienda;
            $arrDatosACP['ID_HOGAR'] = $this->codiHogar;
            $arrDatosACP['ID_PERSONA_RESIDENTE'] = $idResidente;
            // Se agrega la fecha de expedicion del documento
            //$arrDatosACP['FECHA_INSERCION'] = 'SYSDATE'; $fechaActual
            //$arrDatosACP['USUARIO_INSERCION'] = $this->session->userdata('id');

            if (!$this->ejecutar_insert($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP)) {
                throw new Exception("No se pudo agregar correctamente la información de control de la persona. SQL: " . $this->get_sql(), 1);
            }

            $this->codiPersona = $idResidente;
            if(!empty($arrDatosPers['P_JEFE_HOGAR']) && $arrDatosPers['P_JEFE_HOGAR'] == 1) {
                if($this->cambiarOrdenPersonas()) {
                    return true;
                } else {
                    return false;
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
     * Cambia el orden de las personas de residente y hogar para que el 1 sea el jefe
     * @access Public
     * @author oagarzond
     * @param   Int     codiPersona     Codigo de la persona que se debe excluir
     * @return  Boolean Cambio de orden de las personas
     */
    public function cambiarOrdenPersonas($codiPersona) {
        $this->msgError = '';

        try {
            $arrParamPers = array(
                'codiEncuesta' => $this->codiEncuesta,
                'codiVivienda' => $this->codiVivienda,
                'codiHogar' => $this->codiHogar,
                'noIdPers' => $codiPersona
            );

            $arrResi = $this->consultarPersonasResidentes($arrParamPers);
            if(count($arrResi) > 0) {
                $orden = 2;
                foreach ($arrResi as $kr => $vr) {
                    $arrDatosPR['RA1_NRO_RESI'] = $orden;
                    $arrWherePR['ID_PERSONA_RESIDENTE'] = $vr['ID_PERSONA_RESIDENTE'];
                    $arrWherePR['COD_ENCUESTAS'] = $this->codiEncuesta;
                    $arrWherePR['ID_VIVIENDA'] = $this->codiVivienda;
                    $arrWherePR['ID_HOGAR'] = $this->codiHogar;

                    if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosPR, $arrWherePR)) {
                        throw new Exception("No se pudo actualizar correctamente el orden de la persona residente del hogar. SQL: " . $this->get_sql(), 1);
                    }

                    $arrDatosPA['P_NRO_PER'] = $orden;
                    $arrWherePA['ID_PERSONA_HOGAR'] = $vr['ID_PERSONA_RESIDENTE'];
                    $arrWherePA['COD_ENCUESTAS'] = $this->codiEncuesta;
                    $arrWherePA['ID_VIVIENDA'] = $this->codiVivienda;
                    $arrWherePA['ID_HOGAR'] = $this->codiHogar;

                    if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPA, $arrWherePA)) {
                        throw new Exception("No se pudo actualizar correctamente el orden de la persona del hogar. SQL: " . $this->get_sql(), 1);
                    }

                    if($vr['RA1_NRO_RESI'] == '1'){
                        //Se elimina la fecha de finalización para la persona a la cual se le edita la información.
                        $arrDatosACP2['FECHA_INI_PERS'] = NULL;
                        $arrDatosACP2['FECHA_FIN_PERS'] = NULL;
                        $arrWhereACP2['COD_ENCUESTAS'] = $this->codiEncuesta;
                        $arrWhereACP2['ID_VIVIENDA'] = $this->codiVivienda;
                        $arrWhereACP2['ID_HOGAR'] = $this->codiHogar;
                        $arrWhereACP2['ID_PERSONA_RESIDENTE'] = $vr['ID_PERSONA_RESIDENTE'];
                        if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP2, $arrWhereACP2)) {
                            throw new Exception("No se pudo actualizar correctamente la información de la persona en admin control. SQL: " . $this->get_sql(), 1);
                        }
                        //Hasta aqui van los cambios.
                    }

                    $orden++;
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
     * Agrega los datos de la persona por hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatosPers   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function editarPersona($arrDatosPers) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);
        try {
            if(empty($this->codiPersona)) {
                throw new Exception("No se definió correctamente el ID de la persona del hogar", 1);
            }
            if(!empty($arrDatosPers['P_JEFE_HOGAR']) && $arrDatosPers['P_JEFE_HOGAR'] == 1) {
                $arrDatosResi['RA1_NRO_RESI'] = 1;
                $arrDatosPers['P_NRO_PER'] = 1;
            }
            unset($arrDatosPers['P_JEFE_HOGAR']);
            // if(!empty($arrDatosPers['PC_2DO_NOMBRE'])) {
                $arrDatosResi['RA3_2NOMBRE'] = $arrDatosPers['PC_2DO_NOMBRE'];
                unset($arrDatosPers['PC_2DO_NOMBRE']);
            // }
            // if(!empty($arrDatosPers['PD_2DO_APELLIDO'])) {
                $arrDatosResi['RA5_2APELLIDO'] = $arrDatosPers['PD_2DO_APELLIDO'];
                unset($arrDatosPers['PD_2DO_APELLIDO']);
            // }

            if(!empty($arrDatosPers['FECHA_EXPE_CC'])) {
                $arrDatosACP['VALIDA_CEDULA'] = '2';
                $arrDatosACP['FECHA_EXPE_CC'] = $arrDatosPers['FECHA_EXPE_CC'];
                $arrWhereACP['COD_ENCUESTAS'] = $this->codiEncuesta;
                $arrWhereACP['ID_VIVIENDA'] = $this->codiVivienda;
                $arrWhereACP['ID_HOGAR'] = $this->codiHogar;
                $arrWhereACP['ID_PERSONA_RESIDENTE'] = $this->codiPersona;

                if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP, $arrWhereACP)) {
                    throw new Exception("No se pudo actualizar correctamente la información de la persona en admin control. SQL: " . $this->get_sql(), 1);
                }
                unset($arrDatosPers['FECHA_EXPE_CC']);
            }

            $arrDatosResi['RA2_1NOMBRE'] = $arrDatosPers['PA_1ER_NOMBRE'];
            $arrDatosResi['RA4_1APELLIDO'] = $arrDatosPers['PB_1ER_APELLIDO'];
            $arrDatosResi['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosResi['USUARIO_MODIFICACION'] = $this->session->userdata('id');
            $arrWhereResi['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereResi['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWhereResi['ID_HOGAR'] = $this->codiHogar;
            $arrWhereResi['ID_PERSONA_RESIDENTE'] = $this->codiPersona;

            if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosResi, $arrWhereResi)) {
                throw new Exception("No se pudo actualizar correctamente la información de la persona residente del hogar. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosPers['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosPers['USUARIO_MODIFICACION'] = $this->session->userdata('id');
            $arrWherePers['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWherePers['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWherePers['ID_HOGAR'] = $this->codiHogar;
            $arrWherePers['ID_PERSONA_HOGAR'] = $this->codiPersona;

            if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPers, $arrWherePers)) {
                throw new Exception("No se pudo actualizar correctamente la información de la persona del hogar. SQL: " . $this->get_sql(), 1);
            }

            //Se elimina la fecha de finalización para la persona a la cual se le edita la información.
            $arrDatosACP2['FECHA_INI_PERS'] = NULL;
            $arrDatosACP2['FECHA_FIN_PERS'] = NULL;
            $arrWhereACP2['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereACP2['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWhereACP2['ID_HOGAR'] = $this->codiHogar;
            $arrWhereACP2['ID_PERSONA_RESIDENTE'] = $this->codiPersona;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP2, $arrWhereACP2)) {
                throw new Exception("No se pudo actualizar correctamente la información de la persona en admin control. SQL: " . $this->get_sql(), 1);
            }

            $arrDatosACP3['FECHA_FIN_PERSONAS'] = NULL;
            $arrWhereACP3['COD_ENCUESTAS'] = $this->codiEncuesta;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosACP3, $arrWhereACP3)) {
                throw new Exception("No se pudo actualizar correctamente la información de la persona en admin control. SQL: " . $this->get_sql(), 1);
            }
            //Hasta aqui van los cambios.

            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Elimina los datos de la persona por hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function eliminarPersona($arrWhereResi) {
        $this->msgError = '';

        try {
            $arrWhereACP['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereACP['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWhereACP['ID_HOGAR'] = $this->codiHogar;
            $arrWhereACP['ID_PERSONA_RESIDENTE'] = $arrWhereResi['ID_PERSONA_RESIDENTE'];

            if (!$this->ejecutar_delete($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrWhereACP)) {
                throw new Exception("No se pudo eliminar correctamente la información de control de la persona. SQL: " . $this->get_sql(), 1);
            }

            $arrWherePers['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWherePers['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWherePers['ID_HOGAR'] = $this->codiHogar;
            $arrWherePers['ID_PERSONA_HOGAR'] = $arrWhereResi['ID_PERSONA_RESIDENTE'];

            if (!$this->ejecutar_delete($this->sufijoTabla . '_PERSONAS_HOGAR', $arrWherePers)) {
                throw new Exception("No se pudo eliminar correctamente la información de la persona del hogar. SQL: " . $this->get_sql(), 1);
            }

            $arrWhereResi['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereResi['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWhereResi['ID_HOGAR'] = $this->codiHogar;

            if (!$this->ejecutar_delete($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrWhereResi)) {
                throw new Exception("No se pudo eliminar correctamente la información de la persona residente del hogar. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Agrega los datos de la persona fallecida por hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function agregarPersonaFallecida($arrDatosPers) {
        $idPersFall = $this->obtener_siguiente_id('SEQ_' . $this->sufijoTabla . '_PERSONAS_FALLECIDAS');
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            $arrDatosPers['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrDatosPers['ID_VIVIENDA'] = $this->codiVivienda;
            $arrDatosPers['ID_HOGAR'] = $this->codiHogar;
            $arrDatosPers['ID_PERSONA_FALLECIDA'] = $idPersFall;
            $arrDatosPers['F_NROHOG'] = '1';
            $arrDatosPers['FECHA_INSERCION'] = 'SYSDATE';
            $arrDatosPers['USUARIO_INSERCION'] = $this->session->userdata('id');
            if (!$this->ejecutar_insert($this->sufijoTabla . '_PERSONAS_FALLECIDAS', $arrDatosPers)) {
                throw new Exception("No se pudo agregar correctamente la información de la persona fallecida del hogar. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Edita los datos de la persona fallecida por hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatosPers   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function editarPersonaFallecida($arrDatosPers) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            if(empty($this->codiPersona)) {
                throw new Exception("No se definió correctamente el ID de la persona del hogar", 1);
            }

            //$arrDatosResi['FA1_NRO_FALL'] = $arrDatosPers['FA1_NRO_FALL'];
            $arrDatosResi['FA2_SEXO_FALL'] = $arrDatosPers['FA2_SEXO_FALL'];
            $arrDatosResi['FA3_EDAD_FALL'] = $arrDatosPers['FA3_EDAD_FALL'];
            $arrDatosResi['FA4_CERT_DEFUN'] = $arrDatosPers['FA4_CERT_DEFUN'];
            $arrDatosResi['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosResi['USUARIO_MODIFICACION'] = $this->session->userdata('id');
            $arrWhereResi['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereResi['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWhereResi['ID_HOGAR'] = $this->codiHogar;
            $arrWhereResi['ID_PERSONA_FALLECIDA'] = $this->codiPersona;

            if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_FALLECIDAS', $arrDatosResi, $arrWhereResi)) {
                throw new Exception("No se pudo actualizar correctamente la información de la persona residente del hogar. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Elimina los datos de la persona fallecida por hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para agregar
     * @return Array Registros devueltos por la consulta
     */
    public function eliminarPersonaFallecida($arrWherePers) {
        $this->msgError = '';

        try {
            $arrWherePers['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWherePers['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWherePers['ID_HOGAR'] = $this->codiHogar;

            if (!$this->ejecutar_delete($this->sufijoTabla . '_PERSONAS_FALLECIDAS', $arrWherePers)) {
                throw new Exception("No se pudo eliminar correctamente la información de la persona fallecida del hogar. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Actualiza los datos de la persona del hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarPersona($arrDatosPers) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            $arrDatosPers['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosPers['USUARIO_MODIFICACION'] = $this->session->userdata('id');

            if(isset($arrDatosPers['PA4_FECHA_NAC'])) {
                unset($arrDatosPers['PA4_FECHA_NAC']);
            }
            $arrWherePers['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWherePers['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWherePers['ID_HOGAR'] = $this->codiHogar;
            //$arrWherePers['ID_PERSONA_HOGAR'] = $this->codiPersona;
            $arrWherePers['P_NRO_PER'] = $this->numeroPersona;
            // pr($arrWherePers); pr($arrDatosPers); exit;
            if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $arrDatosPers, $arrWherePers)) {
                throw new Exception("No se pudo actualizar correctamente la información de la persona del hogar. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Actualiza los datos de la persona del hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarPersonaResidente($arrDatosPers) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            $arrDatosPers['FECHA_MODIFICACION'] = 'SYSDATE';
            $arrDatosPers['USUARIO_MODIFICACION'] = $this->session->userdata('id');

            $arrWherePers['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWherePers['ID_VIVIENDA'] = $this->codiVivienda;
            $arrWherePers['ID_HOGAR'] = $this->codiHogar;
            //$arrWherePers['ID_PERSONA_HOGAR'] = $this->codiPersona;

            $arrWherePers['RA1_NRO_RESI'] = $this->numeroPersona;


            if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_RESIDENTES', $arrDatosPers, $arrWherePers)) {
                throw new Exception("No se pudo actualizar correctamente la información de la persona residente. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
    }

    /**
     * Actualiza los datos de la persona del hogar
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos   Arreglo asociativo con los valores para actualizar
     * @return Array Registros devueltos por la consulta
     */
    public function actualizarACP($arrDatosACP) {
        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);

        try {
            $arrWhereACP['COD_ENCUESTAS'] = $this->codiEncuesta;
            $arrWhereACP['ID_PERSONA_RESIDENTE'] = $this->codiPersona;
            if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP, $arrWhereACP)) {
                throw new Exception("No se pudo actualizar correctamente la información de admin control persona. SQL: " . $this->get_sql(), 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': error:' . $e->getMessage() . '.');
            $this->msgError = '<strong>Se presentarón inconvenientes en el servidor.</strong>';
            return false;
        }
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
                case 1:
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 9;
                    }
                    $arrDatosAC['FECHA_INI_PERSONAS'] = 'SYSDATE';
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        if($estadoActual < 11) {
                            $this->session->set_userdata('estado', $arrDatosAC['ID_ESTADO_AC']);
                        }
                    }
                    break;
                case 2:
                    $arrDatosAC['FECHA_FIN_PERSONAS'] = 'SYSDATE';
                    if($estadoActual < 11) {
                        $arrDatosAC['ID_ESTADO_AC'] = 10;
                    }
                    $arrWhereAC['COD_ENCUESTAS'] = $this->codiEncuesta;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control. SQL: " . $this->get_sql(), 1);
                    } else {
                        $sessionData['fechaFinPers'] = $arrDatosAC['FECHA_FIN_PERSONAS'];
                        if($estadoActual < 11) {
                            $sessionData['estado'] = $arrDatosAC['ID_ESTADO_AC'];
                        }
                        if(!empty($sessionData)) {
                            $this->session->set_userdata($sessionData);
                        }
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
     * Actualiza la página del modulo por persona
     * @access Public
     * @author oagarzond
     * @param   Int     $estado Estado de la encuesta
     * @return Boolean
     */
    public function actualizarEstadoACP($estado = 0) {

        $this->msgError = '';
        //$fechaHoraActual = $this->consultar_fecha_hora();
        //$fechaActual = substr($fechaHoraActual, 0, 10);
        $estadoActual = $this->session->userdata('estado');

        try {
            switch ($estado) {
                case 2:
                    //if($estadoActual < 11) {
                        $arrDatosACP['FECHA_INI_PERS'] = 'SYSDATE';
                    //}
                    $arrDatosACP['PAG_PERS'] = $estado;
                    $arrWhereACP['COD_ENCUESTAS'] = $this->codiEncuesta;
                    $arrWhereACP['ID_PERSONA_RESIDENTE'] = $this->codiPersona;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP, $arrWhereACP)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control de la persona. SQL: " . $this->get_sql(), 1);
                    }
                    break;
                case 'f':
                    $arrDatosACP['FECHA_FIN_PERS'] = 'SYSDATE';
                    $arrDatosACP['PAG_PERS'] = $this->totalPaginas + 1;
                    $arrWhereACP['COD_ENCUESTAS'] = $this->codiEncuesta;
                    $arrWhereACP['ID_PERSONA_RESIDENTE'] = $this->codiPersona;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP, $arrWhereACP)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control de la persona. SQL: " . $this->get_sql(), 1);
                    }
                    break;
                default:
                    $arrDatosACP['PAG_PERS'] = $estado;
                    $arrWhereACP['COD_ENCUESTAS'] = $this->codiEncuesta;
                    $arrWhereACP['ID_PERSONA_RESIDENTE'] = $this->codiPersona;
                    if (!$this->ejecutar_update($this->sufijoTabla . '_ADMIN_CONTROL_PERSONAS', $arrDatosACP, $arrWhereACP)) {
                        throw new Exception("No se pudo actualizar correctamente la información de control de la persona. SQL: " . $this->get_sql(), 1);
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


    public function respuestasPersonas($codiEncuesta, $id_vivienda, $id_hogar, $id_persona) {
        $data = array();
        $cond = '';
        $i = 0;
        
        $sql = "SELECT *
                FROM " . $this->sufijoTabla . "_PERSONAS_HOGAR PH
                INNER JOIN  " . $this->sufijoTabla . "_PERSONAS_RESIDENTES PR ON PR.ID_PERSONA_RESIDENTE=PH.ID_PERSONA_HOGAR 
                WHERE PH.COD_ENCUESTAS =  " . $codiEncuesta. " AND PH.ID_VIVIENDA = " . $id_vivienda. " AND PH.ID_HOGAR = " . $id_hogar. " AND PH.ID_PERSONA_HOGAR = " . $id_persona;
        //echo $sql;exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        $this->db->close();
        return $data;
    }

    public function actualizarDatosPe($resp) {
        //echo "INGRESO A LA FUNCION UPDATE<br>";
        ini_set('max_execution_time', 13600);
        set_time_limit (13600);
        // PARTICIONAR LA PRIMERA
        $datosInsert['FECHA_MODIFICACION'] = "SYSDATE";
        $datosInsert['USUARIO_MODIFICACION'] = $this->session->userdata('id');
        $datosInsert['P_SEXO'] =           $resp["P_SEXO"];            
        $datosInsert['PA_SABE_FECHA'] =    $resp["PA_SABE_FECHA"];   
        $datosInsert['PA1_FECHA_NAC'] =    $resp["PA1_FECHA_NAC"];   
        $datosInsert['P_EDAD'] =           $resp["P_EDAD"];          
        $datosInsert['PA_TIPO_DOC'] =      $resp["PA_TIPO_DOC"];     
        $datosInsert['PA1_NRO_DOC'] =      $resp["PA1_NRO_DOC"];     
        $datosInsert['P_PARENTESCO'] =     $resp["P_PARENTESCO"];    
        $datosInsert['PA1_GRP_ETNIC'] =    $resp["PA1_GRP_ETNIC"];   
        $datosInsert['PA11_COD_ETNIA'] =   $resp["PA11_COD_ETNIA"];  
        $datosInsert['PA12_CLAN'] =        $resp["PA12_CLAN"];       
        $datosInsert['PA21_COD_VITSA'] =   $resp["PA21_COD_VITSA"];  
        $datosInsert['PA22_COD_KUMPA'] =   $resp["PA22_COD_KUMPA"];  
        $datosInsert['PA_HABLA_LENG'] =    $resp["PA_HABLA_LENG"];   
        $datosInsert['PA1_ENTIENDE'] =     $resp["PA1_ENTIENDE"];    
        $datosInsert['PB_OTRAS_LENG'] =    $resp["PB_OTRAS_LENG"];   
        $datosInsert['PA_LUG_NAC'] =       $resp["PA_LUG_NAC"];      
        $datosInsert['PA1_DPTO_NAC'] =     $resp["PA1_DPTO_NAC"];    
        $datosInsert['PA2_MPIO_NAC'] =     $resp["PA2_MPIO_NAC"];    
        
        $arrWhere['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $arrWhere['ID_VIVIENDA'] = $resp["id_vivienda"];
        $arrWhere['ID_PERSONA_HOGAR'] = $resp["id_persona"]; 
        //var_dump($datosInsert);exit;
        if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $datosInsert, $arrWhere)) {
            throw new Exception("No se pudo actualizar correctamente la información de la persona. SQL: " . $this->get_sql(), 1);
        }
        //echo "TERMINO EL UPDATE<br>";exit;
        return true;
    }

    public function actualizarDatosPe2($resp) {
        ini_set('max_execution_time', 13600);
        set_time_limit (13600);
        $datosInsert2['PA3_PAIS_NAC'] =     $resp["PA3_PAIS_NAC"];    
        $datosInsert2['PA31_ANO_LLEGO'] =   $resp["PA31_ANO_LLEGO"];  
        $datosInsert2['PA_VIVIA_5ANOS'] =   $resp["PA_VIVIA_5ANOS"];  
        $datosInsert2['PA1_DPTO_5ANOS'] =   $resp["PA1_DPTO_5ANOS"];  
        $datosInsert2['PA2_MPIO_5ANOS'] =   $resp["PA2_MPIO_5ANOS"];  
        $datosInsert2['PA21_CLASE_5ANOS'] = $resp["PA21_CLASE_5ANOS"];
        $datosInsert2['PA3_PAIS_5ANO'] =    $resp["PA3_PAIS_5ANO"];   
        $datosInsert2['PA31_ANO_LLEGA5'] =  $resp["PA31_ANO_LLEGA5"]; 
        $datosInsert2['PA_VIVIA_1ANO'] =    $resp["PA_VIVIA_1ANO"];   
        $datosInsert2['PA1_DPTO_1ANO'] =    $resp["PA1_DPTO_1ANO"];   
        $datosInsert2['PA2_MPIO_1ANO'] =    $resp["PA2_MPIO_1ANO"];   
        $datosInsert2['PA21_CLASE_1ANO'] =  $resp["PA21_CLASE_1ANO"]; 
        $datosInsert2['PA3_PAIS_1ANO'] =    $resp["PA3_PAIS_1ANO"];   
        $datosInsert2['P_ENFERMO'] =        $resp["P_ENFERMO"];       
        $datosInsert2['P_QUEHIZO_PPAL'] =   $resp["P_QUEHIZO_PPAL"];  
        $datosInsert2['PA_LO_ATENDIERON'] = $resp["PA_LO_ATENDIERON"];
        $datosInsert2['PA1_CALIDAD_SERV'] = $resp["PA1_CALIDAD_SERV"];
        $datosInsert2['CONDICION_FISICA'] = $resp["CONDICION_FISICA"];
        $datosInsert2['PA_OIR'] =           $resp["PA_OIR"];          
        $datosInsert2['PB_HABLAR'] =        $resp["PB_HABLAR"];       

        $arrWhere2['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $arrWhere2['ID_VIVIENDA'] = $resp["id_vivienda"];
        $arrWhere2['ID_PERSONA_HOGAR'] = $resp["id_persona"];

        if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $datosInsert2, $arrWhere2)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }
        return true;
    }

    public function actualizarDatosPe3($resp) {
        ini_set('max_execution_time', 13600);
        set_time_limit (13600);
        $datosInsert3['PC_VER'] =           $resp["PC_VER"];          
        $datosInsert3['PD_CAMINAR'] =       $resp["PD_CAMINAR"];      
        $datosInsert3['PE_COGER'] =         $resp["PE_COGER"];        
        $datosInsert3['PF_DECIDIR'] =       $resp["PF_DECIDIR"];      
        $datosInsert3['PG_COMER'] =         $resp["PG_COMER"];        
        $datosInsert3['PH_RELACION'] =      $resp["PH_RELACION"];     
        $datosInsert3['PI_TAREAS'] =        $resp["PI_TAREAS"];       
        $datosInsert3['P_LIM_PPAL'] =       $resp["P_LIM_PPAL"];      
        $datosInsert3['P_CAUSA_LIM'] =      $resp["P_CAUSA_LIM"];     
        $datosInsert3['PA_AYUDA_TEC'] =     $resp["PA_AYUDA_TEC"];    
        $datosInsert3['PB_AYUDA_PERS'] =    $resp["PB_AYUDA_PERS"];   
        $datosInsert3['PC_AYUDA_MED'] =     $resp["PC_AYUDA_MED"];    
        $datosInsert3['PD_AYUDA_ANCES'] =   $resp["PD_AYUDA_ANCES"];  
        $datosInsert3['P_CUIDA'] =          $resp["P_CUIDA"];         
        $datosInsert3['P_ALFABETA'] =       $resp["P_ALFABETA"];      
        $datosInsert3['PA_ASISTENCIA'] =    $resp["PA_ASISTENCIA"];   
        $datosInsert3['P_NIVEL_ANOS'] =     $resp["P_NIVEL_ANOS"];    
        $datosInsert3['P_TRABAJO'] =        $resp["P_TRABAJO"];       
        $datosInsert3['P_EST_CIVIL'] =      $resp["P_EST_CIVIL"];     
        $datosInsert3['PA_HNV'] =           $resp["PA_HNV"];          

        $arrWhere3['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $arrWhere3['ID_VIVIENDA'] = $resp["id_vivienda"];
        $arrWhere3['ID_PERSONA_HOGAR'] = $resp["id_persona"];

        if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $datosInsert3, $arrWhere3)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }
        return true;
    }

    public function actualizarDatosPe4($resp) {
        ini_set('max_execution_time', 13600);
        set_time_limit (13600);
        $datosInsert4['PA1_THNV'] =         $resp["PA1_THNV"];        
        $datosInsert4['PA2_HNVH'] =         $resp["PA2_HNVH"];        
        $datosInsert4['PA3_HNVM'] =         $resp["PA3_HNVM"];        
        $datosInsert4['PA_HNVS'] =          $resp["PA_HNVS"];         
        $datosInsert4['PA1_THSV'] =         $resp["PA1_THSV"];        
        $datosInsert4['PA2_HSVH'] =         $resp["PA2_HSVH"];        
        $datosInsert4['PA3_HSVM'] =         $resp["PA3_HSVM"];        
        $datosInsert4['PA_HFC'] =           $resp["PA_HFC"];          
        $datosInsert4['PA1_THFC'] =         $resp["PA1_THFC"];        
        $datosInsert4['PA2_HFCH'] =         $resp["PA2_HFCH"];        
        $datosInsert4['PA3_HFCM'] =         $resp["PA3_HFCM"];        
        $datosInsert4['PA_UHNV'] =          $resp["PA_UHNV"];         
        $datosInsert4['PA1_MES_UHNV'] =     $resp["PA1_MES_UHNV"];    
        $datosInsert4['PA2_ANO_UHNV'] =     $resp["PA2_ANO_UHNV"];    

        
        $arrWhere4['COD_ENCUESTAS'] = $resp["codi_encuesta"];
        $arrWhere4['ID_VIVIENDA'] = $resp["id_vivienda"];
        $arrWhere4['ID_PERSONA_HOGAR'] = $resp["id_persona"];

        if (!$this->ejecutar_update($this->sufijoTabla . '_PERSONAS_HOGAR', $datosInsert4, $arrWhere4)) {
            throw new Exception("No se pudo actualizar correctamente la información de la vivienda. SQL: " . $this->get_sql(), 1);
        }

        return true;
    }


}
//EOC