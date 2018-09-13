<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de hogar
 * @author oagarzond
 * @since 2017-02-21
 */
class Hogar extends MX_Controller {
    private $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['header'] = 'breadcrumb';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['footer'] = 'progressBar';
        $this->data['numeroPagina'] = 1;
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        if(empty($this->session->userdata('auth'))){
            redirect(base_url(), 'location', 301, 'refresh');
        }
    }

    /**
     * Controla el flujo de las paginas del modulo
     * @author oagarzond
     * @since 2017-03-20
     */
    public function index() {
//    	echo $this->session->userdata('codiHogar');
        //pr($this->session->all_userdata()); exit;
        $this->data['title'] = 'Hogar';
        $this->data['arrCss'][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data['arrJS'][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data['arrJS'][] = base_url_js('fillInFormTimer.js');
        $this->data['mostrarAnterior'] = 'NO';
        $this->data['mostrarSituaciones'] = 'NO';

        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('modhogar', 'mhogar');
        $page = $pageAC = '1';
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $arrAC['ID_ESTADO_AC'] = $this->session->userdata('estado');
        $arrAC['PAG_HOGAR'] = $this->session->userdata('paginaHogar');
        $arrAC['FECHA_FIN_HOGAR'] = $this->session->userdata('fechaFinHogar');
        $this->construirPreguntas();

        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //$arrAC = array_shift($arrAC);
        //pr($arrAC); exit;
        // Se debe revisar cuando ya este toda la encuesta completa
        if(!empty($arrAC['PAG_HOGAR'])) {
            $pageAC = $arrAC['PAG_HOGAR'];
        }
        if($arrAC["ID_ESTADO_AC"] == 12) {
            $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
            redirect(base_url('encuesta'), '', 'refresh');
        } else if($arrAC["ID_ESTADO_AC"] == 11) {
            $this->data['mostrarAnterior'] = 'SI';
            if($arrAC['PAG_HOGAR'] >= ($this->data['totalPaginas'] + 1)) {
                $pageAC = 1;
            }
        } else if($arrAC["ID_ESTADO_AC"] < 11) {
            if(!empty($arrAC['FECHA_FIN_HOGAR'])) {
                $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
                redirect(base_url('inicio'), '', 'refresh');
            }
        }

        if($pageAC == 1) {
            $this->data['mostrarAnterior'] = 'NO';
            $this->session->set_userdata('paginaHogar', $pageAC);
        }
        $this->mostrar($pageAC);
    }

    private function esAdmin() {
        $esAdmin = $this->session->userdata('esAdmin');
        if(empty($esAdmin)) {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url('admin'), '', 'refresh');
        }
    }

    private function esAdminSoporte() {
        $esAdmin = $this->session->userdata('esAdmin');
        $esSoporte = $this->session->userdata('esSoporte');
        if(empty($esAdmin) && empty($esSoporte)) {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url('admin'), '', 'refresh');
        }
    }

    /**
     * Muestra el contenido de las paginas del modulo
     * @author oagarzond
     * @param $page         Pagina que se va a mostrar 
     * @since 2017-03-20
     */
    private function mostrar($page = 0) {
    	$this->load->model('modform', 'mform');
        $this->data['breadcrumb'] = '<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
            <li class="breadcrumb-item active">Hogar</li>
        </ol>';
        //$page = 4;
        //echo "CODIGO HOGAR: ".$this->session->userdata('codiHogar');
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $this->data['var'] = '';
        $this->data['hogares'] = $consultaHogares = $this->mhogar->consultarHogares($codiEncuesta);
        $this->data['numHogar'] = $this->session->userdata('nroHogar');
        //var_dump($this->data['hogares']);exit;
        $this->data['view'] = 'hogar';
        $this->data['avance'] = '0%';
        
        
        $estadoActual = $this->session->userdata('estado');

        if($page > 1) {
            $this->data['avance'] = ceil(($page -1) * 100/$this->data['totalPaginas']) . '%';
        }
        //$arrPreguntas = $this->mform->consultarPreguntas('ECP_HOGAR', $page);
        if($estadoActual >= 11) {
            $arrParam = array(
                'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda'),
                'codiHogar' => $this->session->userdata('codiHogar')
            );
            $arrHogar = $this->mhogar->consultarHogar($arrParam);
            if(count($arrHogar) > 0) {
                $arrHogar = array_shift($arrHogar);
                if(count($this->data['preguntas'][$page]) > 0 && empty($this->data['preguntas'][$page]['hogar_exitoso'])) {
                    //$this->data['var'] = cambiar_campos_BD_HTML($this->data['preguntas'], $this->arrCampos[$page], $arrHogar);
                    $this->data['var'] = asignar_valor_pregunta($this->data['preguntas'][$page], $arrHogar);
                }
            }
        } else {
            if(count($this->data['preguntas'][$page]) > 0 && empty($this->data['preguntas'][$page]['hogar_exitoso'])) {
                $this->data['var'] = $this->data['preguntas'][$page];
            }
        }
        //pr($arrHogar); exit;
        //pr($this->data['var']); exit;
        if(!empty($this->data['var'])) {
            foreach ($this->data["var"] as $kv => $vv) {
                if(!empty($vv['ID_PREGUNTA_DEPEN'])) {
                    $this->data["var"][$kv]['HIDDEN'] = 'SI';
                    if(!empty($arrHogar[$vv['ID_PREGUNTA_DEPEN']]) && $arrHogar[$vv['ID_PREGUNTA_DEPEN']] == $vv['VALOR_DEPEN']) {
                        $this->data["var"][$kv]['HIDDEN'] = 'NO';
                    }
                }
                $this->data["var"][$kv]['VIDEO'] = '';
                if(!empty($vv['URL_VIDEO'])) {
                    $this->data["mostrarVideo"] = 'SI';
                    $this->data["var"][$kv]['VIDEO'] = $vv['URL_VIDEO'];
                    $this->data['URLVideo'] = $vv['URL_VIDEO'];
                }
            }
        }
        //pr($this->data['var']); exit;
        $codigoMostrar = $this->config->item('tipoFormulario') . $page;
        if(!empty($this->data['preguntas'][$page]['hogar_exitoso'])) {
            $codigoMostrar = 'completo';
        }
        switch ($codigoMostrar) {
            case 'E1':
            case 'A1':
            case 'B1':
            case 'G1':
            case 'H1':
                //$numeroDormitorios = (!empty($arrHogar['H_NRO_CUARTOS'])) ? $arrHogar['H_NRO_CUARTOS']: 20;
                //$this->data["arrJS"][] = base_url_js('hogar/hogar' . $codigoMostrar . '.js');
                $this->data["arrJS"][] = base_url_js('hogar/hogarE' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    for($i = 1; $i <= 20; $i++) {
                        $this->data['var'][$kv]['OPCIONES'][$i - 1] = array(
                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                            'ID_OPCION' => $i,
                            'DESCRIPCION_OPCION' => $i,
                            'AYUDA' => '',
                            'ORDEN_VISUAL' => $i
                        );
                    }
                }
                break;
            case 'G2':
            case 'H2':
                $this->data["arrJS"][] = base_url_js('hogar/hogarH2.js');
                break;
            case 'E2':
            case 'A2':
            case 'B2':
            case 'G3':
            case 'H3':
                //$this->data["arrJS"][] = base_url_js('hogar/hogarE' . $page . '.js');
                $this->data["arrJS"][] = base_url_js('hogar/hogarE2.js');
                $this->load->model('vivienda/modvivienda', 'mvivi');
                $arrParamVivi = array(
                    'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                    'codiVivienda' => $this->session->userdata('codiVivienda')
                );
                $arrVivi = $this->mvivi->consultarVivienda($arrParamVivi);
                if(count($arrVivi) > 0) {
                    $arrVivi = array_shift($arrVivi);
                    $campo = 'VC_ACU';
                    if(in_array($codigoMostrar, array('G3', 'H3'))) {
                        $campo = 'VB_ACU';
                    }
                    if(!empty($arrVivi[$campo]) && $arrVivi[$campo] == 2) {
                        foreach ($this->data['var'] as $kv => $vv) {
                            if($vv['REFERENCIA_HTML'] == 'agua_cocina') {
                                unset($this->data['var'][$kv]['OPCIONES'][0]); // Se quita la opcion Acueducto publico
                            }
                        }
                    }
                }
                break;
            case 'E3':
            case 'A3':
            case 'B3':
            case 'G4':
            case 'H4':
                //$this->data['view'] = 'hogar' . $codigoMostrar;
                $this->data['view'] = 'hogarE3';
                $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
                $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');
                $this->data['mensajeConfirmacion'] = 'Si el total de personas que eran miembros de <strong>su hogar</strong> y fallecieron en el 2017 <span class="label-bold" id="total_fallecidas-confirm"></span> por favor haga clic en "Guardar y continuar", de lo contrario haga clic en "Anterior".';
                $this->data['numero_fallecidas'] = '';
                // Se ajusta la validacion de empty a is_null ya que empty considera 0 como cadena vacia.
                if(isset($arrHogar['HA_NRO_FALL']) && !is_null($arrHogar['HA_NRO_FALL'])) {
                    $this->data['numero_fallecidas'] = intval($arrHogar['HA_NRO_FALL']);
                }
                foreach ($this->data['var'] as $kv => $vv) {
                    //if($vv['REFERENCIA_HTML'] == 'numero_fallecidas') {
                        for($i = 0; $i <= 20; $i++) {
                            $this->data['arrTotal'][$i - 1] = array(
                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $i,
                                'DESCRIPCION_OPCION' => $i,
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $i
                            );
                        }
                    //}
                }
                $this->data['arrSexos'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 27, 'valor' => array(1, 2)));
                $this->data['arrCF'] = $this->mform->consultarOpciones('FA4_CERT_DEFUN');
                for($i = 0; $i <= 121; $i++) {
                    $this->data['arrEdades'][$i] = array(
                        'REFERENCIA_HTML' => 'edad_fallecida',
                        'ID_OPCION' => $i,
                        'DESCRIPCION_OPCION' => $i,
                        'AYUDA' => '',
                        'ORDEN_VISUAL' => $i
                    );
                }
                //pr($this->data); exit;
                break;
            case 'E4':
            case 'A4':
                $this->data["arrJS"][] = base_url_js('hogar/hogarE' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'cuantas_economica') {
                        for($i = 1; $i <= 60; $i++) {
                            $this->data['var'][$kv]['OPCIONES'][$i - 1] = array(
                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $i,
                                'DESCRIPCION_OPCION' => $i,
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $i
                            );
                        }
                    }
                }
                break;
            case 'E5':
            case 'A5':
            case 'E6':
            case 'A6':
            case 'E7':
            case 'A7':
                //$this->data["arrJS"][] = base_url_js('hogar/hogar' . $codigoMostrar . '.js');
                $this->data["arrJS"][] = base_url_js('hogar/hogarE' . $page . '.js');
                $this->data['mostrarSituaciones'] = 'SI';
                foreach ($this->data['var'] as $kv => $vv) {
                    if(in_array($vv['REFERENCIA_HTML'], array('anios_desplazado', 'anios_abandono', 'anios_despojo'))) {
                        for($i = date('Y'); $i >= 1985; $i--) {
                            $this->data['var'][$kv]['OPCIONES'][$i] = array(
                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $i,
                                'DESCRIPCION_OPCION' => $i,
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $i
                            );
                        }
                    }
                }
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'desplazado_forzado') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if(in_array($vp['REFERENCIA_HTML'], array('anios_desplazado', 'retorno_desplazado'))) {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    continue;
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'abandono_forzado') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if(in_array($vp['REFERENCIA_HTML'], array('anios_abandono', 'retorno_abandono'))) {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    continue;
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'despojo_tierras') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if(in_array($vp['REFERENCIA_HTML'], array('anios_despojo', 'retorno_despojo'))) {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    continue;
                                }
                            }
                        }
                    }
                }
                break;
            case 'E8':
            case 'A8':
                $this->data["arrJS"][] = base_url_js('hogar/hogarE' . $page . '.js');
                $this->data['mostrarSituaciones'] = 'SI';
                break;
            case 'E9':
            case 'A9':
            case 'B4':
            case 'G5':
            case 'H5':
                //$this->data['view'] = 'hogar' . $codigoMostrar;
                $this->data['view'] = 'hogarE9';
                //$this->data['preguntas'] = $this->mform->consultarPreguntas('ECP_PERSONAS_HOGAR_PERS');
                $this->data['var'] = $this->mform->extraerPreguntas('ECP_PERSONAS_HOGAR_PERS');
                $this->data['var'] = $this->data['var'][1];
                $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
                $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');
                $this->data["arrJS"][] = base_url_plugins('moment/js/moment.min.js');
                $this->data['mensajeConfirmacion'] = 'Si el total de personas que conforman el hogar es <span class="label-bold" id="total_personas-confirm"></span> por favor haga clic en Guardar y continuar, de lo contrario haga clic en Anterior.';
                $this->data['mensajeConfirmacion'] = 'Si está seguro que estos son todos los miembros de <strong>su hogar</strong>, por favor haga clic en "Guardar y continuar". De lo contrario haga clic en "Anterior" y corrija.<br /><br /><span id="lblPersonsList"></span>';
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'tipo_documento') {
                        $arrParamTDP = array(
                            'idDominio' => $vv['FK_ID_DOMINIO'],
                            'valor' => array(1,2,3,4),
                            //'sidx' => 'RD.VALOR_MINIMO',
                            //'sord' => 'ASC'
                        );

	$arrTipoDocuPers = [["VALOR_MIN" => "03", "ID_RESPUESTA_DOMINIO" => "29586", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "3", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Cédula de ciudadanía", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29586", "ID_VALOR" => "3", "ETIQUETA" => "Cédula de ciudadanía"], ["VALOR_MIN" => "04", "ID_RESPUESTA_DOMINIO" => "29587", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "4", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Cédula de extranjería", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29587", "ID_VALOR" => "4", "ETIQUETA" => "Cédula de extranjería"], ["VALOR_MIN" => "01", "ID_RESPUESTA_DOMINIO" => "29584", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "1", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Registro civil de nacimiento", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29584", "ID_VALOR" => "1", "ETIQUETA" => "Registro civil de nacimiento"], ["VALOR_MIN" => "02", "ID_RESPUESTA_DOMINIO" => "29585", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "2", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Tarjeta de identidad", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29585", "ID_VALOR" => "2", "ETIQUETA" => "Tarjeta de identidad"],["VALOR_MIN" => "05", "ID_RESPUESTA_DOMINIO" => "29588", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "5", "VALOR_MAXIMO" => null, "DESCRIPCION" => "No tiene documento de identidad", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29588", "ID_VALOR" => "5", "ETIQUETA" => "No tiene documento de identidad"],["VALOR_MIN" => "06", "ID_RESPUESTA_DOMINIO" => "29589", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "6", "VALOR_MAXIMO" => null, "DESCRIPCION" => "No sabe", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29589", "ID_VALOR" => "6", "ETIQUETA" => "No sabe"],["VALOR_MIN" => "07", "ID_RESPUESTA_DOMINIO" => "29590", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "7", "VALOR_MAXIMO" => null, "DESCRIPCION" => "No Responde", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29590", "ID_VALOR" => "7", "ETIQUETA" => "No Responde"] ]
;

//$this->mform->consultarRespuestaDominio($arrParamTDP);
                        foreach ($arrTipoDocuPers as $ktd => $vtd) {
                            $this->data['var'][$kv]['OPCIONES'][$vtd['ID_VALOR']] = array(
                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $vtd['ID_VALOR'],
                                'DESCRIPCION_OPCION' => $vtd['ETIQUETA'],
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $vtd['ID_VALOR']
                            );
                        }
                    }
                    /*if($vv['REFERENCIA_HTML'] == 'fecha_expe') {
                        $this->data["var"][$kv]['ANIO'] = date('Y');
                        $this->data["var"][$kv]['ID_PREGUNTA_ANIO'] = 'anio_expe';
                        $this->data["var"][$kv]['ID_PREGUNTA_MES'] = 'mes_expe';
                        $this->data["var"][$kv]['ID_PREGUNTA_DIA'] = 'dia_expe';
                        $this->data["var"][$kv]['VALOR_ANIO'] = '';
                        $this->data["var"][$kv]['VALOR_MES'] = '';
                        $this->data["var"][$kv]['VALOR_DIA'] = '';
                        $this->data['var'][$kv]['HIDDEN'] = 'SI';
                    }*/
                    if($vv['REFERENCIA_HTML'] == 'sexo_persona') {
                        $arrSexos = $this->mform->consultarRespuestaDominio(array('idDominio' => 27, 'sidx' => 'VALOR_MINIMO'));
                        foreach ($arrSexos as $ks => $vs) {
                            $this->data['var'][$kv]['OPCIONES'][$vs['ID_VALOR']] = array(
                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $vs['ID_VALOR'],
                                'DESCRIPCION_OPCION' => $vs['ETIQUETA'],
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $vs['ID_VALOR']
                            );
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'edad_persona') {
                        for($i = 0; $i <= 121; $i++) {
                            $this->data['var'][$kv]['OPCIONES'][$i] = array(
                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $i,
                                'DESCRIPCION_OPCION' => $i,
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $i
                            );
                        }
                    }
                }
                break;
            case 'completo':
                $this->data['view'] = 'moduloExitoso';
                $this->data['moduleName'] = strtolower($this->data['title']);
                $this->data['imageLogo'] = 'completo_hogar';
                //pr($this->data); exit;
                break;
            case 12:
                redirect(base_url('personas'));
                break;
        }
        //pr($this->data); exit;
        $this->load->view('layout', $this->data);
    }

    /**
     * Guarda el contenido de las paginas del modulo
     * @author oagarzond
     * @since 2017-03-24
     */
    public function guardar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $postt = $this->input->post(NULL, TRUE);
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $this->load->model('modhogar', 'mhogar');
        $this->load->model("encuesta/modencuesta", "mencu");

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $page = $this->session->userdata('paginaHogar');
        //pr($page); exit;
        $this->construirPreguntas();
        $duracion = $postt['duracion'];
        unset($postt['duracion']);
        //@todo: falta consultar y guardar el tiempo de entrevista - 2017-03-23
        $this->mhogar->setCodiEncuesta($codiEncuesta);
        $this->mhogar->setCodiVivienda($this->session->userdata('codiVivienda'));
        $this->mhogar->setCodiHogar($this->session->userdata('codiHogar'));
        foreach ($this->data['preguntas'][$page] as $kpage => $vpage) {
            $this->data['form'][$vpage['ID_PREGUNTA']] = 'NULL';
        }
        foreach ($postt as $key => $value) {
            foreach ($this->data['preguntas'][$page] as $kpage => $vpage) {
                if($vpage['REFERENCIA_HTML'] == $key) {
                    $this->data['form'][$vpage['ID_PREGUNTA']] = $value;
                    break;
                }
            }
        }
        //pr($this->data['form']); exit;
        if(!empty($page)) {
            if(isset($this->data['form']['HA_TOT_PER']) && !empty($this->data['form']['HA_TOT_PER'])) {
                $this->load->model("personas/modpersonas", "mpers");
                $arrParam = array(
                    'codiEncuesta' => $codiEncuesta,
                    'codiVivienda' => $this->session->userdata('codiVivienda'),
                    'codiHogar' => $this->session->userdata('codiHogar')
                );
                $arrPers = $this->mpers->consultarPersonasHogar($arrParam);
                $totalPers = count($arrPers);
                $IDJefe = '';
                if(count($totalPers) == 0) {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se encontró personas en el hogar.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '.');
                }

                $hayJefe = $noEdad = $noSexo = false;
                foreach ($arrPers as $kp => $vp) {
                    if($vp['P_NRO_PER'] == 1) {
                        $hayJefe = true;
                        $IDJefe = $vp['PA1_NRO_DOC'];
                    }
                    //if(empty($vp['P_EDAD'])) {
                    if(empty($vp['P_EDAD']) && $vp['P_EDAD'] !== '0'){
                        $noEdad = true;
                    }
                    if(empty($vp['P_SEXO'])) {
                        $noSexo = true;
                    }
                }

                if(!$hayJefe) {
                    $response['codiError'] = 3;
                    $response['mensaje'] = 'No se encontró el jefe del hogar.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '.');
                }

                if($noEdad) {
                    $response['codiError'] = 4;
                    $response['mensaje'] = 'No se ha definido la edad para algún miembro del hogar.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '.');
                }

                if($noSexo) {
                    $response['codiError'] = 5;
                    $response['mensaje'] = 'No se ha definido el sexo para algún miembro del hogar.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '.');
                }

                if( $response['codiError'] == 0) {
                    $page = intval($page) + 1;
                    //$this->data['formTotal']['HA_TOT_PER'] = $this->data['form']['HA_TOT_PER'];
                    $this->data['formTotal']['HA_TOT_PER'] = $totalPers;
                    $this->data['formTotal']['H_ID_JEFE'] = $IDJefe;
                    unset($this->data['form']);
                    if($this->mhogar->actualizarHogar($this->data['formTotal'])) {
                        if(!empty($this->data['formTotal']['HA_TOT_PER'])) {
                            $arrF1['HA_TOT_PER'] = $this->data['formTotal']['HA_TOT_PER'];
                            $this->mencu->setCodiEncuesta($codiEncuesta);
                            $this->mencu->setCodiVivienda($this->session->userdata('codiVivienda'));
                            $this->mencu->setCodiHogar($this->session->userdata('codiHogar'));
                            if(!$this->mencu->actualizarFormato1($arrF1)) {
                                $response['codiError'] = 2;
                                $response['mensaje'] = 'No se pudo actualizar los datos en el formato 1.';
                                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                                return false;
                            }
                        }
                        if($this->mhogar->actualizarEstadoAC($page)) {
                            $response['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']);
                            $this->load->model('encuesta/modencuesta', 'mencu');
                            if($this->mencu->registrarTiempo('hogar', $duracion)) {
                                $response['mensaje'] = 'Se guardaron correctamente los datos del hogar.';
                            } else {
                                $response['codiError'] = 8;
                                $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Hogar.';
                                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mhogar->getMsgError());
                            }
                        } else {
                            $response['codiError'] = 7;
                            $response['mensaje'] = 'No se pudo actualizar el estado del hogar en la encuesta.';
                            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mhogar->getMsgError());
                        }
                    } else {
                        $response['codiError'] = 6;
                        $response['mensaje'] = 'No se pudo guardar los datos del hogar.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mhogar->getMsgError());
                    }
                }
            } else {
                if($this->mhogar->actualizarHogar($this->data['form'])) {
                    $page = intval($page) + 1;
                    if(!empty($this->data['form']['H_DONDE_PREPALIM']) && $this->data['form']['H_DONDE_PREPALIM'] == 6) { // No preparan alimentos en la vivienda
                        $page = intval($page) + 1;
                    }
                    if($this->mhogar->actualizarEstadoAC($page)) {
                        if($page > $this->data['totalPaginas']) {
                            $response['avance'] = '100';
                        } else {
                            $response['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']);
                        }
                        $this->load->model('encuesta/modencuesta', 'mencu');
                        if($this->mencu->registrarTiempo('hogar', $duracion)) {
                            $response['mensaje'] = 'Se guardaron correctamente los datos del hogar.';
                        } else {
                            $response['codiError'] = 3;
                            $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Hogar.';
                            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mhogar->getMsgError());
                        }
                    } else {
                        $response['codiError'] = 2;
                        $response['mensaje'] = 'No se pudo actualizar el estado del hogar en la encuesta.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mhogar->getMsgError());
                    }
                } else {
                    $response['codiError'] = 1;
                    $response['mensaje'] = 'No se pudo guardar los datos del hogar.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mhogar->getMsgError());
                }
            }
        }
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Actualiza el numero de pagina a la anterior
     * @author oagarzond
     * @since 2017-05-15
     */
    public function regresar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $postt = $this->input->post(NULL, TRUE);
        $this->construirPreguntas();
        $duracion = $postt['duracion'];
        unset($postt['duracion']);
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('modhogar', 'mhogar');

        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //$arrAC = array_shift($arrAC);
        $page = $this->session->userdata('paginaHogar');

        if($page > 0) {
            $page--;
            $this->mhogar->setCodiEncuesta($codiEncuesta);
            $this->mhogar->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mhogar->setCodiHogar($this->session->userdata('codiHogar'));

            if($this->mhogar->actualizarEstadoAC($page)) {
                if($this->mencu->registrarTiempo('hogar', $duracion)) {
                    $response['mensaje'] = 'Se guardaron correctamente los datos del hogar.';
                    $response['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']);
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Hogar.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo actualizar el estado del hogar.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
            }
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    public function validarHogar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';

        $postt = $this->input->post(NULL, TRUE);
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        foreach ($postt as $nombre_campo => $valor) {
            $this->data[$nombre_campo] = $valor;
        }
        if(empty($this->data['encuesta'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el identificador del hogar.';
        }
        if($response['codiError'] == 0) {
            $this->load->model('modhogar', 'mhogar');

            $arrUsua = $this->mhogar->consultarHogar(array('codiEncuesta' => $this->data['encuesta']));
            if(count($arrUsua) > 0) {
                switch ($this->data['opc']) {
                    case 'verHogar':
                        $response['url'] = base_url('hogar/ver/' . $this->data['encuesta']);
                        break;
                }
            }
        }

        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    public function ver($id = 0) {
        $this->esAdminSoporte();
        $esAdmin = $this->session->userdata('esAdmin');
        $esSoporte = $this->session->userdata('esSoporte');
        $this->data['view'] = 'verHogar';
        $this->data['title'] = 'Ver hogar';
        $this->data['classContainer'] = 'container-fluid';
        $this->data['navbarLeftSide'] = '';
        if(!empty($esSoporte)) {
            $this->data['url'] = 'soporte/inicio';
            $this->data['header'] = 'navbarSoporte';
            $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item"><a href="' . base_url('soporte/inicio') . '">Soporte</a></li>
                <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
            </ol>';
        } else if(!empty($esAdmin)) {
            $this->data['url'] = 'admin/inicio';
            $this->data['header'] = 'navbarAdmin';
            //$this->data['header'] = 'navbarSoporte';
            $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item"><a href="' . base_url('admin/inicio') . '">Administración</a></li>
                <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
            </ol>';
        }
        $this->data['footer'] = 'footer';

        if(empty($id)) {
            $this->session->set_flashdata('msgError', 'No se definió correctamente el identificador del usuario.');
            redirect(base_url($this->data['url']));
        }

        $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
        $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');

        $this->load->model('usuarios/modusuarios', 'musua');
        $this->load->model("modform", "mform");

        $arrUsua = $this->musua->consultarInfoUsuarios(array('codiEncuesta' => $id));
        if(count($arrUsua) > 0) {
            $this->data['usua'] = array_shift($arrUsua);
            $this->data['usua']['modulo'] = $this->data['usua']['pagina'] = 0;
            $tablaAsociada = array('','ECP_UBICACION','ECP_VIVIENDA','ECP_HOGAR','ECP_PERSONAS_HOGAR','ECP_PERSONAS_HOGAR_PERS');
            if(!empty($this->data['usua']['ID_ESTADO_AC'])) {
                switch ($this->data['usua']['ID_ESTADO_AC']) {
                    case '3':
                        $this->data['usua']['modulo'] = '1';
                        $this->data['usua']['pagina'] = $this->data['usua']['PAG_UBICACION'];
                        break;
                    case '5':
                        $this->data['usua']['modulo'] = '2';
                        $this->data['usua']['pagina'] = $this->data['usua']['PAG_VIVIENDA'];
                        break;
                    case '7':
                        $this->data['usua']['modulo'] = '3';
                        $this->data['usua']['pagina'] = $this->data['usua']['PAG_HOGAR'];
                        break;
                    case '9':
                        /*$this->load->model('personas/modpersonas', 'mpers');
                        $arrParam = array(
                            'codiEncuesta' => $this->data['usua']['COD_ENCUESTAS'],
                            'sidx' => 'PR.RA1_NRO_RESI'
                        );
                        $arrACP = $this->mpers->consultarControlPersonasResidentes($arrParam);
                        //pr($arrACP); exit;
                        if(count($arrACP) > 0) {
                            foreach ($arrACP as $kACP => $vACP) {
                                if(!empty($vACP['FECHA_INI_PERS']) && empty($vACP['FECHA_FIN_PERS'])) {
                                    //pr($vACP); exit;
                                    $this->data['usua']['pagina'] = $vACP['nombre'] . ' - ' . $vACP['PAG_PERS'];
                                }
                            }
                        }*/
                        break;
                        breaK;
                }
                if(!empty($this->data['usua']['pagina'])) {
                    if($tablaAsociada[$this->data['usua']['modulo']] == 'ECP_HOGAR' && $this->data['usua']['pagina'] == 11) {
                        $this->data['usua']['modulo'] = '5';
                    }
                    $this->data['preguntas'] = $this->mform->consultarPreguntas($tablaAsociada[$this->data['usua']['modulo']], $this->data['usua']['pagina']);
                    if(count($this->data['preguntas']) == 0) {
                        $this->data['usua']['pagina'] = '';
                    }
                }
            }
        }

        //pr($this->data); exit;
        $this->load->view('layout', $this->data);
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
        $this->construirPreguntas();

        $this->load->model('modhogar', 'mhogar');
        $this->mhogar->setCodiEncuesta($codiEncuesta);
        $this->mhogar->setCodiVivienda($this->session->userdata('codiVivienda'));
        $this->mhogar->setCodiHogar($this->session->userdata('codiHogar'));
        $this->mhogar->setTotalPaginas($this->data["totalPaginas"]);
        if($this->mhogar->actualizarEstadoAC('f')) {
            $response['mensaje'] = 'Se finalizó correctamente la sección Hogar.';
            $response['avance'] = '100%';
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se pudo actualizar el estado del hogar.';
            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Se consulta y/o se construye el archivo de preguntas con sus opciones
     * y el total de paginas
     * @author oagarzond
     * @since 2017-08-14
     */
    private function construirPreguntas($tabla = 'ECP_HOGAR', $pagina = '') {
        $this->load->model('modform', 'mform');

        $this->data['preguntas'] = $this->mform->extraerPreguntas($tabla);
        //$this->data['preguntas'] = $this->consultarPreguntas('ECP_HOGAR');
        $this->data['totalPaginas'] = count($this->data['preguntas']);
        $this->data['preguntas'][++$this->data['totalPaginas']]['hogar_exitoso'] = 'SI';
    }

    /**
     * Se define la pagina que se envia como parametro
     * @author oagarzond
     * @since 2017-12-08
     */
    public function definirPagina($numero = 0) {
        if($numero <= 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $this->session->set_userdata('paginaHogar', $numero);
        redirect(base_url($this->data['module']));
    }

    public function seleccionHogar() {

    	$this->load->model('modhogar', 'mhogar');

    	$codiEncuesta = $this->session->userdata('codiEncuesta');
    	$codigo_vivienda = $this->session->userdata('codiVivienda');
    	
    	$codigo_hogar = $this->session->userdata('codiHogar');


    	$consultaHogares = $this->mhogar->consultarNumeroHogares($codiEncuesta);

    	$consultaHogaresConstruidos = $this->mhogar->consultarNumeroHogaresConstruidos($codiEncuesta);

    	
    	$numero_hogares = $consultaHogares[0]["V_TOT_HOG"];
    	//var_dump($consultaHogaresConstruidos);
    	$numero_hogaresConstruidos = $consultaHogaresConstruidos[0]["TOTAL"];
    	//echo "HOGARES CONST ".$numero_hogaresConstruidos." INGRESO FUNCION";exit;
    	//echo $numero_hogares."---".$numero_hogaresConstruidos;
    	if($numero_hogares>$numero_hogaresConstruidos){
    		$datosHogar['COD_ENCUESTAS'] = $codiEncuesta;
	        $datosHogar['ID_VIVIENDA'] = $codigo_vivienda;
	        $datosHogar['ID_HOGAR'] = "9999";
	        $datosHogar['H_NROHOG'] = $numero_hogaresConstruidos+1;
	        $datosHogar['FECHA_INSERCION'] = 'SYSDATE';
	        $datosHogar['USUARIO_INSERCION'] = "9898";
	        //date("d/m/Y");

	        $resultadoHogar = $this->mhogar->insertarDatosHogar($datosHogar);
	        if($resultadoHogar){

	        	$usuario_data = array(
				   'codiHogar' => $resultadoHogar,
				   'nroHogar' => $datosHogar['H_NROHOG']
				);
				$this->session->set_userdata($usuario_data);

				//echo $this->session->userdata('codiHogar');exit;

				//$this->session->userdata('codiHogar') = 9999999;
				redirect(base_url('inicio'));
	        }
    	}else{
    		//echo $this->session->userdata('codiHogar');exit;
    		redirect(base_url('inicio'));	        	
    	}

    	
    }

    public function edicionHogar($hogar) {

    	$this->load->model('modhogar', 'mhogar');

    	$codiEncuesta = $this->session->userdata('codiEncuesta');
    	$codigo_vivienda = $this->session->userdata('codiVivienda');

    	$consultaIdHogar = $this->mhogar->consultarIdHogar($codiEncuesta,$hogar);

    	
    	$usuario_data = array(
		   'codiHogar' => $consultaIdHogar[0]["ID_HOGAR"],
		   'nroHogar' => $consultaIdHogar[0]["H_NROHOG"]
		);
		$this->session->set_userdata($usuario_data);
    	redirect(base_url('inicio'));
    }

    public function formNew() {
        $this->load->model('vivienda/modvivienda', 'mvivi');
        $this->load->model('modhogar', 'mhogar');

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $id_vivienda = $this->session->userdata('codiVivienda');
        $id_hogar = $this->session->userdata('codiHogar');
        
        $arrFechaInicio = $this->mvivi->consultaFechaInicio($codiEncuesta);
        $fecha_inicio_hogar = $arrFechaInicio[0]["FECHA_INI_HOGAR"];

        if($fecha_inicio_hogar==""){
            $insertFechaInicioH = $this->mvivi->actualizarFechaInicioHogar($codiEncuesta);
        }

        $this->data['id_vivienda'] = $id_vivienda;
        $consultaHogares = $this->mvivi->consultarTotalHogares($id_vivienda);
        $consultaHogaresInsertados = $this->mvivi->consultarHogaresInsertados($id_vivienda);
        
        $this->data['total_hogares'] = $consultaHogares[0]["V_TOT_HOG"];
        $this->data['total_hogares_insertados'] = $consultaHogaresInsertados[0]["TOTAL"];

        
        $this->data['view'] = 'newForm';
        $this->load->view('layoutNew', $this->data);
        
    }

    public function edit() {
        error_reporting(E_ALL & ~E_NOTICE);
        $this->load->model('vivienda/modvivienda', 'mvivi');
        $this->load->model('modhogar', 'mhogar');

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $id_vivienda = $this->session->userdata('codiVivienda');
        $id_hogar = $this->session->userdata('codiHogar');
        
        $arrFechaInicio = $this->mvivi->consultaFechaInicio($codiEncuesta);
        $fecha_inicio_hogar = $arrFechaInicio[0]["FECHA_INI_HOGAR"];

        if($fecha_inicio_hogar==""){
            $insertFechaInicioH = $this->mvivi->actualizarFechaInicioHogar($codiEncuesta);
        }

        $this->data['respuestas'] = $this->mhogar->respuestas($codiEncuesta, $id_vivienda, $id_hogar);
        $this->data['respuestasPersonas'] = $this->mhogar->respuestasPersonas($codiEncuesta, $id_vivienda, $id_hogar);
        
        $this->data['respuestasPersonasFallecidas'] = $this->mhogar->respuestasPersonasFallecidas($codiEncuesta, $id_vivienda, $id_hogar);

        $this->data['id_vivienda'] = $id_vivienda;
        $consultaHogares = $this->mvivi->consultarTotalHogares($id_vivienda);
        $consultaHogaresInsertados = $this->mvivi->consultarHogaresInsertados($id_vivienda);
        
        $this->data['total_hogares'] = $consultaHogares[0]["V_TOT_HOG"];
        $this->data['total_hogares_insertados'] = $consultaHogaresInsertados[0]["TOTAL"];

        
        $this->data['view'] = 'editH';
        $this->load->view('layoutNew', $this->data);
        
    }

    public function guardarHogar() {
        error_reporting(0);
        $this->load->model('modhogar', 'mhogar');
        $this->load->model('vivienda/modvivienda', 'mvivi');

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $id_vivienda = $this->session->userdata('codiVivienda');
        $id_hogar = $this->session->userdata('codiHogar');

        $resp["codi_encuesta"] = $codiEncuesta;
        $resp["id_vivienda"] = $id_vivienda;
        $resp["id_hogar"] = $id_hogar;
        $resp["hg_numero_hogar"] = $_POST["hg21_numero_orden"];
        $resp["hg_numero_cuartos"] = $_POST["hg22_total_cuartos"];
        $resp["hg_cuartos_dormir"] = $_POST["hg23_total_cuartos_dormir"];
        $resp["hg_preparan_alimentos"] = $_POST["hg24_prepara_alimentos"];
        $resp["hg_obtiene_agua"] = $_POST["hg25_obtiene_agua"];
        $resp["hg_total_fallecieron"] = $_POST["hg26_total_fallecieron"];
        //var_dump($resp);exit;
        
        $resultadoHogar = $this->mhogar->actualizarDatosHogar($resp);
        //$resultadoHogar = TRUE;
        if($resultadoHogar){

            for($k=1;$k<=15;$k++){
                $persF["codi_encuesta"] = $codiEncuesta;
                $persF["id_vivienda"] = $id_vivienda;
                $persF["id_hogar"] = $id_hogar;
                $persF["F_NROHOG"] = $resp["hg_numero_hogar"];
                $persF["FA1_NRO_FALL"] = $_POST["hg26_numero_orden_$k"];
                $persF["FA2_SEXO_FALL"] = $_POST["hg26_sexo_$k"];
                $persF["FA3_EDAD_FALL"] = $_POST["hg26_edad_$k"];
                $persF["FA4_CERT_DEFUN"] = $_POST["hg26_certificado_defuncion_$k"];
                
                if( $persF["FA2_SEXO_FALL"]!="" && $persF["FA3_EDAD_FALL"]!="" && $persF["FA4_CERT_DEFUN"]!=""){
                    $arrPersonasFallecidas = $this->mhogar->consultarPersonaFallecida($codiEncuesta,$id_vivienda,$id_hogar,$persF["FA1_NRO_FALL"]);
                    if(count($arrPersonasFallecidas)>0){
                        $updateFallecidas = $this->mhogar->actualizarPersonasFallecidas($persF);  
                    }else{
                        $insertFallecidas = $this->mhogar->insertarPersonasFallecidas($persF);  
                    }
                }
            }
            
            for($k=1;$k<=15;$k++){
                $persR["codi_encuesta"] = $codiEncuesta;
                $persR["id_vivienda"] = $id_vivienda;
                $persR["id_hogar"] = $id_hogar;
                $persR["F_NROHOG"] = $_POST["hg21_numero_orden"];
                $persR["RA1_NRO_RESI"] = $_POST["hg27_numero_orden_$k"];
                $persR["RA2_1NOMBRE"] = strtoupper($_POST["hg27_primer_nombre_$k"]);
                $persR["RA3_2NOMBRE"] = strtoupper($_POST["hg27_segundo_nombre_$k"]);
                $persR["RA4_1APELLIDO"] = strtoupper($_POST["hg27_primer_apellido_$k"]);
                $persR["RA5_2APELLIDO"] = strtoupper($_POST["hg27_segundo_apellido_$k"]);
                $persR["P_EDAD"] = $_POST["hg27_edad_$k"];
                $persR["PA_TIPO_DOC"] = $_POST["hg27_tipoD_$k"];
                $persR["PA1_NRO_DOC"] = $_POST["hg27_documento_$k"];
            //    var_dump($persR);
                if( $persR["RA1_NRO_RESI"]!="" && $persR["RA2_1NOMBRE"]!="" && $persR["RA4_1APELLIDO"]!="")
                {
                    $arrPersonasResidentes = $this->mhogar->consultarPersonaResidente($codiEncuesta,$id_vivienda,$id_hogar,$persR["RA1_NRO_RESI"]);

                    if(count($arrPersonasResidentes)>0){
                        $insertResidentes = $this->mhogar->actualizarPersonasResidentes($persR);  
                    }else{
                        $insertResidentes = $this->mhogar->insertarPersonasResidentes($persR);  
                        if($insertResidentes){
                            $persC["codi_encuesta"] = $codiEncuesta;
                            $persC["id_vivienda"] = $id_vivienda;
                            $persC["id_hogar"] = $id_hogar;
                            $persC["id_persona"] = $insertResidentes;

                            $insertPersonasC = $this->mhogar->insertarPersonasC($persC);  
                        }
                    }
                }
            }
          //  echo "as";exit;

            $consultaHogares = $this->mvivi->consultarTotalHogares($id_vivienda);
            $consultaHogaresInsertados = $this->mvivi->consultarHogaresInsertados($id_vivienda);
            
            //$total_hogares = $consultaHogares[0]["V_TOT_HOG"];
            $total_hogares = 1;
            $total_hogares_insertados = $consultaHogaresInsertados[0]["TOTAL"];

            if($total_hogares>$total_hogares_insertados){
                $agrega_hogar["COD_ENCUESTAS"] = $codiEncuesta;
                $agrega_hogar["ID_VIVIENDA"] = $id_vivienda;
                $agrega_hogar["H_NROHOG"] = $total_hogares_insertados+1;
                $resultadoNuevoHogar = $this->mhogar->insertarDatosHogar($agrega_hogar);
                //echo $resultadoNuevoHogar;exit;
                //$resultadoNuevoHogar = TRUE;
                if($resultadoNuevoHogar){
                    $usuario_data = array(
                       'codiHogar' => $resultadoNuevoHogar,
                       'nroHogar' => $agrega_hogar["H_NROHOG"]
                    );    
                    $this->session->set_userdata($usuario_data);
                }
            }else{
                $arrFechaFin = $this->mvivi->consultaFechaInicio($codiEncuesta);
                $fecha_fin_hogar = $arrFechaFin[0]["FECHA_FIN_HOGAR"];

                if($fecha_fin_hogar==""){
                    $insertFechaFinH = $this->mvivi->actualizarFechaFinHogar($codiEncuesta);
                }
                redirect(base_url('inicio'));    
            }
            redirect(base_url('hogar/formNew'));
        }
    }
}
//EOC
