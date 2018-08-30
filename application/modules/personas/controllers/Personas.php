<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de personas
 * @author oagarzond
 * @since 2017-02-21
 */
class Personas extends MX_Controller {
    var $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data["msgError"] = $this->data["msgSuccess"] = '';
        $this->data["module"] = (!empty($this->module)) ? $this->module: 'login';
        $this->data["header"] = "breadcrumb";
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['footer'] = 'progressBar';
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

    }

    /**
     * Controla el flujo de la pagina principal de las personas
     * @author oagarzond
     * @since 2017-03-31
     */
    public function index() {
        //pr($this->session->all_userdata()); exit;
        $this->data["title"] = 'Personas';
        $this->data["view"] = 'personas';
        $this->data["avance"] = '0%';
        $this->data["breadcrumb"] = '<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
            <li class="breadcrumb-item active">Personas</li>
        </ol>';

        $this->load->model("modpersonas", "mpers");
        $this->load->model("encuesta/modencuesta", "mencu");
        $total = '0';
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $estado = $this->session->userdata('estado');
        if($estado == 12) {
            $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
            redirect(base_url('encuesta'));
        }
        $arrParam = array(
            'codiEncuesta' => $codiEncuesta,
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'sidx' => 'PR.RA1_NRO_RESI'
        );
        $arrACP = $this->mpers->consultarControlPersonasResidentes($arrParam);
        //pr($arrACP); exit;
        if(count($arrACP) > 0) {
            $totalACP = count($arrACP);
            foreach ($arrACP as $kACP => $vACP) {
                $arrACP[$kACP]['completo'] = 'NO';
                if(!empty($vACP['FECHA_INI_PERS'])) {
                	if(!empty($vACP['FECHA_FIN_PERS'])) {
                		$total++;
                	} else {
                        //pr($vACP); exit;
                		$this->data["fechaFinal"] = $vACP["FECHA_FIN_PERS"];
                		$this->session->set_userdata('codiPersona', $vACP['ID_PERSONA_RESIDENTE']);
                		$this->session->set_userdata('numeroPersona', $vACP['RA1_NRO_RESI']);
                		$this->session->set_userdata('nombrePersona', mayuscula_inicial($vACP['nombre']));
                		$this->session->set_userdata('numeroPagina', $vACP['PAG_PERS']);
                        $arrParam['idPers'] = $vACP['ID_PERSONA_RESIDENTE'];
                        $arrParam['sidx'] = 'PH.ID_PERSONA_HOGAR';
                        $arrPH = $this->mpers->consultarPersonas($arrParam);
                        if(count($arrPH) > 0) {
                            $arrPH = array_shift($arrPH);
                            $this->session->set_userdata('edadPersona', $arrPH['P_EDAD']);
                            $this->session->set_userdata('sexoPersona', $arrPH['P_SEXO']);
                        }
                		redirect(base_url('personas/persona/completar/' . $vACP['RA1_NRO_RESI']));
                	}
                }
            }
        }
        // Se debe revisar cuando ya este toda la encuesta completa
        if($total == $totalACP) {
            $this->data['codiError'] = 0;
            //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
            //pr($arrAC); exit;
            $fechaFinPers = $this->session->userdata('fechaFinPers');
            if(empty($fechaFinPers)) {
                //$this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
                //redirect(base_url('inicio'));
                $this->data['view'] = 'moduloExitoso';
                $this->data['moduleName'] = strtolower($this->data['title']);
                $this->data['imageLogo'] = 'completo_personas';
            }
        }

        if(count($arrACP) > 0) {
            //var_dump($arrACP);
            foreach ($arrACP as $kACP => $vACP) {
                $this->data['personas'][$vACP['RA1_NRO_RESI']]['nombre'] = mayuscula_inicial($vACP['nombre']);
                $this->data['personas'][$vACP['RA1_NRO_RESI']]['id_persona'] = $vACP['ID_PERSONA_RESIDENTE'];
                $this->data['personas'][$vACP['RA1_NRO_RESI']]['completo'] = 'NO';
                if(!empty($vACP['FECHA_INI_PERS']) && !empty($vACP['FECHA_FIN_PERS'])) {
                    $this->data['personas'][$vACP['RA1_NRO_RESI']]['completo'] = 'SI';
                }
            }
        }
        //pr($this->data); //exit;
        $this->load->view("layout", $this->data);
    }

    /**
     * Guarda la fecha y hora en que inicio el modulo
     * @author oagarzond
     * @since 2017-04-06
     */
    public function avance() {
        //pr($this->session->all_userdata()); exit;
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['avance'] = '0%';
        $total = '0';
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $this->load->model("modpersonas", "mpers");

        try {
            $arrParam = array(
                'codiEncuesta' => $codiEncuesta,
                'codiVivienda' => $this->session->userdata('codiVivienda'),
                'codiHogar' => $this->session->userdata('codiHogar'),
                'sidx' => 'PR.RA1_NRO_RESI'
            );
            $arrACP = $this->mpers->consultarControlPersonasResidentes($arrParam);
            $totalACP = count($arrACP);
            if($totalACP > 0) {
                foreach ($arrACP as $kACP => $vACP) {
                    if(!empty($vACP['FECHA_INI_PERS']) && !empty($vACP['FECHA_FIN_PERS'])) {
                        $total++;
                    }
                }
                $response['avance'] = ceil(($total * 100) / $totalACP) . '%';
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se encontro información de la(s) persona(s).';
                throw new Exception($response['mensaje'], $response['codiError']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . $e->getMessage() . '</strong>');
            return false;
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Guarda la fecha y hora en que inicio el modulo
     * @author oagarzond
     * @since 2017-04-06
     */
    public function iniciar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $postt = $this->input->post(NULL, TRUE);
        // pr($postt); exit;
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $numePers = $postt['numepers'];
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $this->load->model("encuesta/modencuesta", "mencu");
        $arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //pr($arrAC); exit;
        if(count($arrAC) > 0 && empty($arrAC[0]['FECHA_INI_PERSONAS'])) {
            $this->load->model("personas/modpersonas", "mpers");
            $this->mpers->setCodiEncuesta($codiEncuesta);
            if($this->mpers->actualizarEstadoAC(1)) {
                $arrParamPH = array(
                    'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                    'codiVivienda' => $this->session->userdata('codiVivienda'),
                    'codiHogar' => $this->session->userdata('codiHogar'),
                    'numePers' => $numePers
                );
                $arrPH = $this->mpers->consultarPersonas($arrParamPH);
                $this->mpers->setCodiPersona($arrPH[0]['ID_PERSONA_HOGAR']);
                if($this->mpers->actualizarEstadoACP(1)) {
                    $response['mensaje'] = 'Se guardó correctamente la fecha de inicio del módulo.';
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo guardar correctamente el estado de control de la persona.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo guardar correctamente el estado de control.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
            }
        }
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Consulta los datos de las personas para la grilla
     * @author oagarzond
     * @since 2017-03-31
     */
    public function consultarGrilla() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $this->load->model("personas/modpersonas", "mpers");
        $this->load->model("modform", "mform");

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['data'][0]['tipo_docu'] = '';
        $response['data'][0]['nume_docu'] = '';
        $response['data'][0]['fecha_expe'] = '';
        $response['data'][0]['nombre'] = '';
        $response['data'][0]['jefe'] = '';
        $response['data'][0]['sexo'] = '';
        $response['data'][0]['edad'] = '';
        $response['data'][0]['opciones'] = '';
        $arrParam = array(
            'codiEncuesta' => $this->session->userdata('codiEncuesta'),
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'sidx' => 'PH.P_NRO_PER'
        );
        $arrPers = $this->mpers->consultarPersonas($arrParam);
        //pr($arrPers); exit;
        if(count($arrPers) > 0) {
            $arrTipoDocuPers = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
            $arrSexos = $this->mform->consultarRespuestaDominio(array('idDominio' => 27));
            $arrCF = $this->mform->consultarOpciones('P_JEFE_HOGAR');
            foreach ($arrPers as $kp => $vp) {
                $tipoDocu = $sexo = '';
                $jefe = 'No';
                foreach ($arrTipoDocuPers as $ktd => $vtd) {
                    if($vtd['ID_VALOR'] == $vp['PA_TIPO_DOC']) {
                        $tipoDocu = $vtd['ETIQUETA'];
                    }
                }
                foreach ($arrSexos as $kse => $vse) {
                    if($vse['ID_VALOR'] == $vp['P_SEXO']) {
                        $sexo = $vse['ETIQUETA'];
                    }
                }
                if(!empty($vp['P_NRO_PER']) && $vp['P_NRO_PER'] == 1) {
                    $jefe = 'Sí';
                }
                $response['data'][$kp]['tipo_docu'] = $tipoDocu;
                $response['data'][$kp]['nume_docu'] = $vp['PA1_NRO_DOC'];
                $response['data'][$kp]['fecha_expe'] = $vp['FECHAEXPE'];
                $response['data'][$kp]['nombre'] = $vp['nombre'];
                $response['data'][$kp]['jefe'] = $jefe;
                $response['data'][$kp]['sexo'] = $sexo;
                $response['data'][$kp]['edad'] = $vp['P_EDAD'];
                $response['data'][$kp]['opciones'] = '
                    <button class="editarPersona btn btn-sm btn-primary" type="button" data-idpers="' . $vp['ID_PERSONA_HOGAR'] . '" title="Editar">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                    &nbsp;<button class="eliminarPersona btn btn-sm btn-danger" type="button" data-idpers="' . $vp['ID_PERSONA_HOGAR'] . '" title="Eliminar">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Consulta los datos de las personas fallecidas del hogar seleccionado
     * @author oagarzond
     * @since 2017-03-29
     */
    public function consultarPersonasFallecidas() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $this->load->model("personas/modpersonas", "mpers");
        $this->load->model("modform", "mform");

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['data'][0]['sexo'] = '';
        $response['data'][0]['edad'] = '';
        $response['data'][0]['certificado'] = '';
        $response['data'][0]['opciones'] = '';
        $arrParam = array(
            'codiEncuesta' => $this->session->userdata('codiEncuesta'),
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar')
        );
        $arrPers = $this->mpers->consultarPersonasFallecidas($arrParam);
        if(count($arrPers) > 0) {
            $i = 0;
            $arrSexos = $this->mform->consultarRespuestaDominio(array('idDominio' => 27));
            $arrCF = $this->mform->consultarOpciones('FA4_CERT_DEFUN');
            foreach ($arrPers as $kp => $vp) {
                $sexo = $certificado = '';
                foreach ($arrSexos as $kse => $vse) {
                    if($vse['ID_VALOR'] == $vp['FA2_SEXO_FALL']) {
                        $sexo = $vse['ETIQUETA'];
                    }
                }
                foreach ($arrCF as $kcf => $vcf) {
                    if($vcf['ID_OPCION'] == $vp['FA4_CERT_DEFUN']) {
                        $certificado = $vcf['DESCRIPCION_OPCION'];
                    }
                }
                $response['data'][$kp]['sexo'] = $sexo;
                $response['data'][$kp]['edad'] = $vp['FA3_EDAD_FALL'];
                $response['data'][$kp]['certificado'] = $certificado;
                $response['data'][$kp]['opciones'] = '
                    <button class="editarFallecida btn btn-sm btn-primary" type="button" data-idpers="' . $vp['ID_PERSONA_FALLECIDA'] . '" title="Editar">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                    &nbsp;<button class="eliminarFallecida btn btn-sm btn-danger" type="button" data-idpers="' . $vp['ID_PERSONA_FALLECIDA'] . '" title="Eliminar">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                $i++;
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Consulta los datos de las personas para la grilla
     * @author oagarzond
     * @since 2017-06-05
     */
    public function consultarGrillaEncuesta($codigoEncuesta = 0) {
        if(empty($codigoEncuesta)) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $this->load->model("personas/modpersonas", "mpers");
        $this->load->model("encuesta/modencuesta", "mencu");
        $this->load->model("modform", "mform");

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['data'][0]['tipo_docu'] = '';
        $response['data'][0]['nume_docu'] = '';
        $response['data'][0]['nombre'] = '';
        $response['data'][0]['jefe'] = '';
        $response['data'][0]['sexo'] = '';
        $response['data'][0]['edad'] = '';
        $response['data'][0]['pagina'] = '';
        $arrParam = array(
            'codiEncuesta' => $codigoEncuesta,
            'sidx' => 'PH.P_NRO_PER'
        );
        $arrPers = $this->mpers->consultarPersonas($arrParam);
        //pr($arrPers); exit;
        if(count($arrPers) > 0) {
            $arrTipoDocuPers = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
            $arrSexos = $this->mform->consultarRespuestaDominio(array('idDominio' => 27));
            $arrCF = $this->mform->consultarOpciones('P_JEFE_HOGAR');
            foreach ($arrPers as $kp => $vp) {
                // pr($vp);
                $tipoDocu = $sexo = '';
                $jefe = 'No';
                foreach ($arrTipoDocuPers as $ktd => $vtd) {
                    if($vtd['ID_VALOR'] == $vp['PA_TIPO_DOC']) {
                        $tipoDocu = $vtd['ETIQUETA'];
                    }
                }
                foreach ($arrSexos as $kse => $vse) {
                    if($vse['ID_VALOR'] == $vp['P_SEXO']) {
                        $sexo = $vse['ETIQUETA'];
                    }
                }
                // if(!empty($vp['P_NRO_PER']) && $vp['P_NRO_PER'] == 1) {
                if(!empty($vp['H_ID_JEFE'])) {
                    $jefe = 'Sí';
                }
                $response['data'][$kp]['tipo_docu'] = $tipoDocu;
                $response['data'][$kp]['nume_docu'] = $vp['PA1_NRO_DOC'];
                $response['data'][$kp]['nombre'] = $vp['nombre'];
                $response['data'][$kp]['jefe'] = $jefe;
                $response['data'][$kp]['sexo'] = $sexo;
                $response['data'][$kp]['edad'] = $vp['P_EDAD'];
                $response['data'][$kp]['pagina'] = '';
                if(!empty($vp['PAG_PERS'])) {
                    $arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codigoEncuesta));
                    if(count($arrAC) > 0) {
                        $fecha = $arrAC[0]['FECHA_INSCRIPCION'];
                        $fecha5Anios = date("Y-m-d", strtotime("-5 years", strtotime(formatear_fecha($fecha))));
                        $temp5Anios = explode('-', $fecha5Anios);
                        $fecha1Anio = date("Y-m-d", strtotime("-1 years", strtotime(formatear_fecha($fecha))));
                        $temp1Anio = explode('-', $fecha1Anio);
                        $sessionData['texto5Anios'] = obtener_texto_mes($temp5Anios[1]) . ' de ' . $temp5Anios[0];
                        $sessionData['texto1Anio'] = obtener_texto_mes($temp1Anio[1]) . ' de ' . $temp1Anio[0];
                    }
                    $sessionData['nombrePersona'] = $vp['nombre'];
                    $this->session->set_userdata($sessionData);
                    $arrPreguntas = $this->mform->consultarPreguntas('ECP_PERSONAS_HOGAR', $vp['PAG_PERS']);
                    if(count($arrPreguntas) > 0) {
                        //$vp['PAG_PERS'] = 5;
                        $response['data'][$kp]['pagina'] = '<button class="verPreguntas btn btn-sm btn-primary" type="button" data-idpers="' . $vp['ID_PERSONA_RESIDENTE'] . '" data-pagina="' . $vp['PAG_PERS'] . '" title="' . $vp['PAG_PERS'] . '">' . $vp['PAG_PERS'] . '</button>';
                    }
                }

            }
        }
        // pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Consulta los datos de las personas para la grilla
     * @author oagarzond
     * @since 2017-06-05
     */
    public function consultarGrillaSoporte() {
        $this->load->model("personas/modpersonas", "mpers");
        $this->load->model("modform", "mform");

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['data'][0]['tipo_docu'] = '';
        $response['data'][0]['nume_docu'] = '';
        $response['data'][0]['nombre'] = '';
        $response['data'][0]['jefe'] = '';
        $response['data'][0]['sexo'] = '';
        $response['data'][0]['edad'] = '';
        $response['data'][0]['opciones'] = '';

        $arrParam = array();
        for ($i = 1; $i < 20; $i++) {
            $valor = $this->uri->segment($i);
            if ($i == 3 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['formulario'] = urldecode($valor);
            }
            if ($i == 4 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['tipoDocu'] = urldecode($valor);
            }
            if ($i == 5 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['numeDocu'] = urldecode($valor);
            }
            if ($i == 6 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['nombre1'] = strtoupper(urldecode($valor));
            }
            if ($i == 7 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['nombre2'] = strtoupper(urldecode($valor));
            }
            if ($i == 8 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['apellido1'] = strtoupper(urldecode($valor));
            }
            if ($i == 9 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['apellido1'] = strtoupper(urldecode($valor));
            }
        }

        $arrPers = $this->mpers->consultarPersonas($arrParam);
        //pr($arrPers); exit;
        if(count($arrPers) > 0) {
            $arrTipoDocuPers = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
            $arrSexos = $this->mform->consultarRespuestaDominio(array('idDominio' => 27));
            $arrCF = $this->mform->consultarOpciones('P_JEFE_HOGAR');
            foreach ($arrPers as $kp => $vp) {
                $tipoDocu = $sexo = '';
                $jefe = 'No';
                foreach ($arrTipoDocuPers as $ktd => $vtd) {
                    if($vtd['ID_VALOR'] == $vp['PA_TIPO_DOC']) {
                        $tipoDocu = $vtd['ETIQUETA'];
                    }
                }
                foreach ($arrSexos as $kse => $vse) {
                    if($vse['ID_VALOR'] == $vp['P_SEXO']) {
                        $sexo = $vse['ETIQUETA'];
                    }
                }
                // if(!empty($vp['P_NRO_PER']) && $vp['P_NRO_PER'] == 1) {
                if(!empty($vp['H_ID_JEFE'])) {
                    $jefe = 'Sí';
                }
                $response['data'][$kp]['tipo_docu'] = $tipoDocu;
                $response['data'][$kp]['nume_docu'] = $vp['PA1_NRO_DOC'];
                $response['data'][$kp]['nombre'] = $vp['nombre'];
                $response['data'][$kp]['jefe'] = $jefe;
                $response['data'][$kp]['sexo'] = $sexo;
                $response['data'][$kp]['edad'] = $vp['P_EDAD'];
                $response['data'][$kp]['opciones'] = '<button class="verHogar btn btn-sm btn-info" type="button" data-encuesta="' . $vp['COD_ENCUESTAS'] . '" title="Ver hogar">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span></button>&nbsp;
                        <button class="verEntrevistas btn btn-sm btn-info" type="button" data-encuesta="' . $vp['COD_ENCUESTAS'] . '" title="Ver resultado entrevistas">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>';
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Actualiza la ultima pagina mas uno y define fecha final
     * @author oagarzond
     * @since 2017-07-31
     */
    public function finalizar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        //$postt = $this->input->post(NULL, TRUE);
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $this->load->model("modpersonas", "mpers");
        $this->mpers->setCodiEncuesta($codiEncuesta);
        if($this->mpers->actualizarEstadoAC(2)) {
            $response['mensaje'] = 'Se finalizó correctamente la sección Personas.';
        } else {
            $this->data['codiError'] = 1;
            $response['mensaje'] = 'No se pudo actualizar el estado de la sección Personas.';
            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }
    
    
    public function resultadoEntrevista() {
        $this->data["title"] = 'Resultado Entrevista';
        $this->data["view"] = 'resultado';
        $this->data["avance"] = '100%';
        $this->data["breadcrumb"] = '<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
            <li class="breadcrumb-item active">Resultado Entrevista</li>
        </ol>';
		
		$this->data['arrJS'][] = base_url_js('personas/personas.js?n='.date('is'));
        
        $this->load->view("layout", $this->data);
    }
	
	public function guardarEntrevista(){ 
		
		$numero_visita = $this->input->post('numero_visita');
		$dia = $this->input->post('dia');
		$mes = $this->input->post('mes');
		$anio = $this->input->post('anio');
		$hora = $this->input->post('hora');
		$minutos = $this->input->post('minutos');
		$resultado_entrevista = $this->input->post('resultado_entrevista');
		$cod_censita = $this->input->post('cod_censita');
		$cod_supervisor = $this->input->post('cod_supervisor');
		$nume_certificado = $this->input->post('nume_certificado');
		
		$date = new DateTime($anio.'-'.$mes.'-'.$dia.' '.$hora.':'.$minutos.':00');
		
		$this->load->model('encuesta/modencuesta', 'mencu');
       
		$this->data['idUsua'] = $this->session->userdata('id');
        $this->data['codiEncuesta'] = $this->session->userdata('codiEncuesta');
        $this->data['codiVivienda'] = $this->session->userdata('codiVivienda');
        $this->data['codiHogar'] = $this->session->userdata('codiHogar');
		if($this->session->userdata('nroHogar') != '' && $this->session->userdata('nroHogar')>0){
			$this->data['nroHogar'] = $this->session->userdata('nroHogar');
		}else{
			$this->data['nroHogar'] = 1;
		}
        
        $this->data['nroVisita'] = $numero_visita;
        $this->data['fechaFin'] = $date->format('Y-m-d H:i:s');
        $this->data['resuEntrevista'] = $resultado_entrevista;
        $this->data['codCensista'] = $cod_censita;
        $this->data['codSupervisor'] = $cod_supervisor;
		$this->data['nume_certificado'] = $nume_certificado;
		
		
		if($this->data['nume_certificado'] != '' ){
			$this->mencu->actualizarNumeCertificadoResultado($this->data);
		}
        
         
        if(!$this->mencu->guardarEntrevistaResultado($this->data)) {
            $response['codiError'] = 1;
			$response['mensaje'] = 'Error al guardar la información de la entrevista';
        } else {
			$response['codiError'] = 0;
			$response['mensaje'] = 'Se guardo la información de la entrevista';
		}
		
		$this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
	}

    public function formNew($id_persona) {
        error_reporting(E_ALL & ~E_NOTICE);
        $this->load->model('vivienda/modvivienda', 'mvivi');
        $this->load->model('hogar/modhogar', 'mhogar');
        $this->load->model("modpersonas", "mpers");

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $id_vivienda = $this->session->userdata('codiVivienda');
        $id_hogar = $this->session->userdata('codiHogar');
        $id_persona = $id_persona;
        
        /*$arrFechaInicio = $this->mvivi->consultaFechaInicio($codiEncuesta);
        $fecha_inicio_hogar = $arrFechaInicio[0]["FECHA_INI_HOGAR"];

        if($fecha_inicio_hogar==""){
            $insertFechaInicioH = $this->mvivi->actualizarFechaInicioHogar($codiEncuesta);
        }

        $this->data['id_vivienda'] = $id_vivienda;
        $consultaHogares = $this->mvivi->consultarTotalHogares($id_vivienda);
        $consultaHogaresInsertados = $this->mvivi->consultarHogaresInsertados($id_vivienda);
        
        $this->data['total_hogares'] = $consultaHogares[0]["V_TOT_HOG"];
        $this->data['total_hogares_insertados'] = $consultaHogaresInsertados[0]["TOTAL"];
        */
        $this->data['id_persona'] = $id_persona;
        $this->data['respuestas'] = $this->mpers->respuestasPersonas($codiEncuesta, $id_vivienda, $id_hogar, $id_persona);
        //var_dump($this->data['respuestas']);
        
        $this->data['view'] = 'newForm';
        $this->load->view('layout', $this->data);
        
    }

    public function guardarPersona() {
        //echo "INGRESO A GUARDAR";exit;
     //   error_reporting(0);
        ini_set('max_execution_time', 13600);
        error_reporting(E_ALL & ~E_NOTICE);
        $this->load->model('vivienda/modvivienda', 'mvivi');
        $this->load->model("modpersonas", "mpers");

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $codiVivienda = $this->session->userdata('codiVivienda');

        $resp["codi_encuesta"] = $codiEncuesta;
        $resp["id_vivienda"] = $codiVivienda;
        $resp["id_persona"] = $_POST["id_persona"];

        $resp["P_SEXO"] = $_POST["p32_sexo"]; 
        $resp["PA_SABE_FECHA"] = $_POST["p33_sabe_fecha"];
        if($_POST["p33_dia"]!="" && $_POST["p33_mes"]!="" && $_POST["p33_anio"]!=""){
            $resp["PA1_FECHA_NAC"] = $_POST["p33_dia"]."/".$_POST["p33_mes"]."/".$_POST["p33_anio"];
        }else{
            // $resp["PA1_FECHA_NAC"] = NULL;   
        }
        $resp["P_EDAD"] = $_POST["p34_anios_cumplidos"];
        $resp["PA_TIPO_DOC"] = $_POST["p35_tipo_documento"];
        $resp["PA1_NRO_DOC"] = $_POST["p35_nro_doc"];
        $resp["P_PARENTESCO"] = $_POST["p36_parentesco_jefe"];
        $resp["PA1_GRP_ETNIC"] = $_POST["p37_reconoce_como"];
        $resp["PA11_COD_ETNIA"] = $_POST["p37_codigo_pueblo_indigena"];
        $resp["PA12_CLAN"] = $_POST["p37_codigo_clan_indigena"];
        $resp["PA21_COD_VITSA"] = $_POST["p37_codigo_vitsa"];
        $resp["PA22_COD_KUMPA"] = $_POST["p37_codigo_kumpania"];
        $resp["PA_HABLA_LENG"] = $_POST["p38_lengua_nativa"];
        $resp["PA1_ENTIENDE"] = $_POST["p38_entiende"];
        $resp["PB_OTRAS_LENG"] = $_POST["p38-1_habla_lengua_nativa"];
        $resp["PA_LUG_NAC"] = $_POST["p39_donde_nacio"];
        $resp["PA1_DPTO_NAC"] = $_POST["p39_codigo_departamento"];
        if(strlen($_POST["p39_codigo_municipio"])>3){
            $resp["PA2_MPIO_NAC"] = $_POST["p39_codigo_municipio"];
        }else{
            $resp["PA2_MPIO_NAC"] = $_POST["p39_codigo_departamento"].$_POST["p39_codigo_municipio"];
        }
        
        $resp2["codi_encuesta"] = $codiEncuesta;
        $resp2["id_vivienda"] = $codiVivienda;
        $resp2["id_persona"] = $_POST["id_persona"];
        $resp2["PA3_PAIS_NAC"] = $_POST["p39_codigo_pais"];
        $resp2["PA31_ANO_LLEGO"] = $_POST["p39-1_llego_colombia"];
        $resp2["PA_VIVIA_5ANOS"] = $_POST["p40_hace5_anios"];
        $resp2["PA1_DPTO_5ANOS"] = $_POST["p40_codigo_departamento"];
        if(strlen($_POST["p40_codigo_municipio"])>3){
            $resp2["PA2_MPIO_5ANOS"] = $_POST["p40_codigo_municipio"];
        }else{
            $resp2["PA2_MPIO_5ANOS"] = $_POST["p40_codigo_departamento"].$_POST["p40_codigo_municipio"];
        }
        $resp2["PA21_CLASE_5ANOS"] = $_POST["p40-1_vivia"];
        $resp2["PA3_PAIS_5ANO"] = $_POST["p40_codigo_pais"];
        $resp2["PA31_ANO_LLEGA5"] = $_POST["p40-2_llego_colombia"];
        $resp2["PA_VIVIA_1ANO"] = $_POST["p41_hace12_meses"];
        $resp2["PA1_DPTO_1ANO"] = $_POST["p41_codigo_departamento"]; // NO SE GUARDA
        if(strlen($_POST["p41_codigo_municipio"])>3){
            $resp2["PA2_MPIO_1ANO"] = $_POST["p41_codigo_municipio"];
        }else{
            $resp2["PA2_MPIO_1ANO"] = $_POST["p41_codigo_departamento"].$_POST["p41_codigo_municipio"];
        }
        $resp2["PA21_CLASE_1ANO"] = $_POST["p41-1_vivia"];
        $resp2["PA3_PAIS_1ANO"] = $_POST["p41_codigo_pais"];
        $resp2["P_ENFERMO"] = $_POST["p42_enfermedad"];
        $resp2["P_QUEHIZO_PPAL"] = $_POST["p43_tratar_enfermedad"];
        $resp2["PA_LO_ATENDIERON"] = $_POST["p43-1_atendieron"];
        $resp2["PA1_CALIDAD_SERV"] = $_POST["p43-2_calidad_servicio"];
        $resp2["CONDICION_FISICA"] = $_POST["p44_tiene_dificultades"];
        $resp2["PA_OIR"] = $_POST["p44-1-1_tiene_dificultades"];
        $resp2["PB_HABLAR"] = $_POST["p44-1-2_tiene_dificultades"];

        $resp3["codi_encuesta"] = $codiEncuesta;
        $resp3["id_vivienda"] = $codiVivienda;
        $resp3["id_persona"] = $_POST["id_persona"];
        $resp3["PC_VER"] = $_POST["p44-1-3_tiene_dificultades"];
        $resp3["PD_CAMINAR"] = $_POST["p44-1-4_tiene_dificultades"];
        $resp3["PE_COGER"] = $_POST["p44-1-5_tiene_dificultades"];
        $resp3["PF_DECIDIR"] = $_POST["p44-1-6_tiene_dificultades"];
        $resp3["PG_COMER"] = $_POST["p44-1-7_tiene_dificultades"];
        $resp3["PH_RELACION"] = $_POST["p44-1-8_tiene_dificultades"];
        $resp3["PI_TAREAS"] = $_POST["p44-1-9_tiene_dificultades"];
        $resp3["P_LIM_PPAL"] = $_POST["p45_mas_dificultad"];
        $resp3["P_CAUSA_LIM"] = $_POST["p46_ocasionada"];
        $resp3["PA_AYUDA_TEC"] = $_POST["p47-1_utiliza"];
        $resp3["PB_AYUDA_PERS"] = $_POST["p47-2_utiliza"];
        $resp3["PC_AYUDA_MED"] = $_POST["p47-3_utiliza"];
        $resp3["PD_AYUDA_ANCES"] = $_POST["p47-4_utiliza"];
        $resp3["P_CUIDA"] = $_POST["p48_permanece"];
        $resp3["P_ALFABETA"] = $_POST["p49_sabe"];
        $resp3["PA_ASISTENCIA"] = $_POST["p50_asiste"];
        $resp3["P_NIVEL_ANOS"] = $_POST["p51_nivel"];
        $resp3["P_TRABAJO"] = $_POST["p52_semana"];
        $resp3["P_EST_CIVIL"] = $_POST["p53_estado_civil"];
        $resp3["PA_HNV"] = $_POST["p54_hijos"];


        $resp4["codi_encuesta"] = $codiEncuesta;
        $resp4["id_vivienda"] = $codiVivienda;
        $resp4["id_persona"] = $_POST["id_persona"];
        $resp4["PA1_THNV"] = $_POST["p54_cuantos"];
        $resp4["PA2_HNVH"] = $_POST["p54_cuantosH"];
        $resp4["PA3_HNVM"] = $_POST["p54_cuantosM"];
        $resp4["PA_HNVS"] = $_POST["p55_hijos_vivos"];
        $resp4["PA1_THSV"] = $_POST["p55_cuantos"];
        $resp4["PA2_HSVH"] = $_POST["p55_cuantosH"];
        $resp4["PA3_HSVM"] = $_POST["p55_cuantosM"];
        $resp4["PA_HFC"] = $_POST["p56_hijos_fuera"];
        $resp4["PA1_THFC"] = $_POST["p56_cuantos"];
        $resp4["PA2_HFCH"] = $_POST["p56_cuantosH"];
        $resp4["PA3_HFCM"] = $_POST["p56_cuantosM"];
        $resp4["PA_UHNV"] = $_POST["p57_sabe_mes"];
        $resp4["PA1_MES_UHNV"] = $_POST["p57_mes"];
        $resp4["PA2_ANO_UHNV"] = $_POST["p57_anio"];

        //var_dump($resp);exit;
        $resultadoPe = $this->mpers->actualizarDatosPe($resp);
        if($resultadoPe){
            $resultadoPe2 = $this->mpers->actualizarDatosPe2($resp2);
            if($resultadoPe2){
                $resultadoPe3 = $this->mpers->actualizarDatosPe3($resp3);
                if($resultadoPe3){
                    $resultadoPe4 = $this->mpers->actualizarDatosPe4($resp4);
                    if($resultadoPe4){
                        redirect(base_url('personas'));
                    }
                }
            }                        
        }
    }

}
//EOC