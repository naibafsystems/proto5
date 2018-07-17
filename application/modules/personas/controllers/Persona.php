<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de personas
 * @author oagarzond
 * @since 2017-02-21
 */
class Persona extends MX_Controller {
    private $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['header'] = 'breadcrumb';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['footer'] = 'progressBar';
        $this->data['fechaFinal'] = '';
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
     * Controla el flujo de la pagina principal de las persona
     * @author oagarzond
     * @since 2017-03-31
     */
    public function index() {
        $this->completar(0);
    }

    /**
     * Controla el flujo de la pagina principal de las persona
     * @author oagarzond
     * @since 2017-03-31
     */
    public function completar($numePers = 0) {
        $session = $this->session->all_userdata();
        foreach ($session as $ks => $vs) {
            $this->data[$ks] = $vs;
        }

        if(!empty($numePers)) {
            $this->session->set_userdata('numeroPersona', $numePers);
        }

        $this->data['title'] = 'Personas';
        $this->data['arrCss'][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data['arrJS'][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data['arrJS'][] = base_url_js('fillInFormTimer.js');
        $this->data['mostrarAnterior'] = 'NO';

        $this->load->model('personas/modpersonas', 'mpers');
        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->construirPreguntas();
        $pageAC = 1;
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $estadoActual = $this->session->userdata('estado');

        // Se debe revisar cuando ya este toda la encuesta completa
        if($estadoActual == 12) {
            $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
            redirect(base_url('encuesta'));
        }

        $arrParam = array(
            'codiEncuesta' => $this->session->userdata('codiEncuesta'),
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'numePers' => $this->session->userdata('numeroPersona')
        );

        $arrACP = $this->mpers->consultarControlPersonasResidentes($arrParam);
        // pr($arrACP);exit;

        if(count($arrACP) == 1) {
            $vACP = array_shift($arrACP);

            $this->data['codiPersona'] = $vACP['ID_PERSONA_RESIDENTE'];
            $this->data['nombrePersona'] = mayuscula_inicial($vACP['nombre']);
            if(!empty($vACP['PAG_PERS'])) {
                $pageAC = $vACP['PAG_PERS'];
                if($vACP['PAG_PERS'] == ($this->data['totalPaginas'] + 1)) {
                    $pageAC = 1;
                }
            }
            if(!empty($vACP['FECHA_FIN_PERS'])) {
                $this->data['mostrarAnterior'] = 'SI';
                if($estadoActual != 11) {
                    $this->session->set_flashdata('msgError', 'Ya se completó la información de esta persona.');
                    redirect(base_url('personas'));
                }
            }
            $this->session->set_userdata('codiPersona', $vACP['ID_PERSONA_RESIDENTE']);
            $this->session->set_userdata('nombrePersona', mayuscula_inicial($vACP['nombre']));
            $this->session->set_userdata('numeroPagina', $vACP['PAG_PERS']);
            $arrParam['idPers'] = $vACP['ID_PERSONA_RESIDENTE'];
            $arrPH = $this->mpers->consultarPersonas($arrParam);
            if(count($arrPH) > 0) {
                $arrPH = array_shift($arrPH);
                $this->session->set_userdata('edadPersona', $arrPH['P_EDAD']);
                $this->session->set_userdata('sexoPersona', $arrPH['P_SEXO']);
            }
            $this->construirPreguntas();
        } else if(count($arrACP) > 1) {
            // En caso que se tenga que decidir que persona debe continuar la encuesta
            //pr($arrACP); exit;
            foreach ($arrACP as $kACP => $vACP) {
                if(!empty($vACP['FECHA_INI_PERS']) && empty($vACP['FECHA_FIN_PERS'])) {
                    $this->data['codiPersona'] = $vACP['ID_PERSONA_RESIDENTE'];
                    $this->data['numeroPersona'] = $vACP['RA1_NRO_RESI'];
                    $this->data['nombrePersona'] = mayuscula_inicial($vACP['nombre']);
                    $pageAC = (!empty($vACP['PAG_PERS'])) ? $vACP['PAG_PERS']: 1;
                    $this->data['fechaFinal'] = $vACP['FECHA_FIN_PERS'];
                    $this->session->set_userdata('codiPersona', $vACP['ID_PERSONA_RESIDENTE']);
                    $this->session->set_userdata('numeroPersona', $vACP['RA1_NRO_RESI']);
                    $this->session->set_userdata('nombrePersona', mayuscula_inicial($vACP['nombre']));
                    $this->session->set_userdata('numeroPagina', $vACP['PAG_PERS']);
                    $arrParam['idPers'] = $vACP['ID_PERSONA_RESIDENTE'];
                    $arrPH = $this->mpers->consultarPersonas($arrParam);
                    if(count($arrPH) > 0) {
                        $arrPH = array_shift($arrPH);
                        $this->session->set_userdata('edadPersona', $arrPH['P_EDAD']);
                        $this->session->set_userdata('sexoPersona', $arrPH['P_SEXO']);
                    }
                    break;
                }
            }
        } else {
            if(!empty($numePers)) {
                $this->session->set_flashdata('msgError', 'La persona no existe en la encuesta.');
                redirect(base_url('inicio'));
            }
        }
        if($this->data['estado'] >= 9 && $pageAC == $this->data['totalPaginas'] + 1) {
            $pageAC = 1;
        }
        if($pageAC == 1) {
            $this->data['mostrarAnterior'] = 'NO';
        }


        if($pageAC == 1 || $pageAC == 2 ) {

            //Se agrega este Código para validar que el jefe de hogar no sea menor de 10 años

            $arrParam = array(
                    'codiEncuesta' => $codiEncuesta,
                    'codiVivienda' => $this->session->userdata('codiVivienda'),
                    'codiHogar' => $this->session->userdata('codiHogar')
             );

            $arrPers = $this->mpers->consultarPersonasHogar($arrParam);

            $this->data['esJefe'] = false;
            $this->data['tieneConyuge'] = false;

            foreach ($arrPers as $kp => $vp) {
                if($vp['P_NRO_PER'] == 1) {
                    if($vp['ID_PERSONA_HOGAR'] == $vACP["ID_PERSONA_RESIDENTE"]){
                        $this->data['esJefe'] = true;
                        $IDJefe = $vp['PA1_NRO_DOC'];
                    }
                }

                if($vp['P_PARENTESCO'] == 2){
                    if($vp['ID_PERSONA_HOGAR'] != $vACP["ID_PERSONA_RESIDENTE"]){
                        $this->data['tieneConyuge'] = true;
                        $IDConyugue = $vp['PA1_NRO_DOC'];
                    }
                }
            }
            //Hasta aquí va el código
        }

        $this->session->set_userdata('numeroPagina', $pageAC);
        //pr($this->session->all_userdata()); exit;
        //pr($this->data); exit;
        //pr($pageAC); exit;
        $this->mostrar($pageAC);
    }

     /**
     * Muestra el contenido de las paginas del modulo
     * @author oagarzond
     * @param $page         Pagina que se va a mostrar
     * @since 2017-04-05
     */
    private function mostrar($page = 0) {
        //pr($this->session->all_userdata());
        //exit;
        $this->load->model('modform', 'mform');
        $this->data['breadcrumb'] = '<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
            <li class="breadcrumb-item"><a href="' . base_url('personas') . '">Personas</a></li>
            <li class="breadcrumb-item active">' . $this->session->userdata('nombrePersona') . '</li>
        </ol>';
        $this->data['avance'] = '0%';
        $this->data['mostrarTituloLimitacion'] = 'NO';
        $this->data['mostrarTituloAyudas'] = 'NO';
        $this->data['mostrarTituloTrabajo'] = 'NO';
        $this->data['mensajeConfirmacion'] = '';
        // Se valida por edad, sexo que pagina se debe mostrar
        $numeroPersona = $this->data['numeroPersona'] = $this->session->userdata('numeroPersona');
        $codigoMostrar = $this->config->item('tipoFormulario') . $page;
        $edad = intval($this->session->userdata('edadPersona'));
        $sexo = intval($this->session->userdata('sexoPersona'));
        //pr($page);
        //pr($codigoMostrar);
        //pr($edad);
        //pr($sexo); exit;
        if(in_array($codigoMostrar, array('E2', 'A2', 'B2', 'G2', 'H2'))) {
            if($numeroPersona == 1) {
                $page = intval($page) + 1;
            }
        }
        if(in_array($codigoMostrar, array('E5', 'A5', 'B5', 'G5', 'H5'))) {
            if($edad < 5) {
                $page = intval($page) + 1;
            }
        }
        if($codigoMostrar == 'E6' || $codigoMostrar == 'A6') {
            if($edad < 1) {
                $page = intval($page) + 1;
            }
        }
        if($codigoMostrar == 'B6') {
            if($edad < 1) {
                $page = $this->data['totalPaginas'];
            }
        }
        if(in_array($codigoMostrar, array('E21', 'H20')) && $edad >= 5) {
            $page = intval($page) + 1;
        }
        if($codigoMostrar == 'E23') {
            if($edad < 5) {
                $page = intval($page) + 1;
            }
        } else if(in_array($codigoMostrar, array('A19', 'B8', 'G19', 'H22'))) {
            if($edad < 3) {
                $page = intval($page) + 1;
            }
        }
        if(in_array($codigoMostrar, array('E24', 'A20', 'B9'))) {
            if($edad < 10) {
                $page = $this->data['totalPaginas'];
            }

        }
        // Si no es mujer termina las preguntas
        if(in_array($codigoMostrar, array('E28', 'A22', 'B11', 'H26'))) {
            if($sexo != 2) {
                $page = intval($page) + 1;
            }
        } else if($codigoMostrar == 'B11') {
            if($sexo != 2) {
                $page = $this->data['totalPaginas'];
            }
        }

        if(in_array($codigoMostrar, array('E30', 'A24'))) {
            if($edad >= 18) {
                if($sexo != 1 && $sexo != 2) {
                    $page = intval($page) + 1;
                }
            } else {
                $page = intval($page) + 1;
            }
        }

        if($page > 1) {
            $this->data['avance'] = ceil(($page -1) * 100/$this->data['totalPaginas']) . '%';
        }

        /*if($page == 10){
            $arrParam = array(
                'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda'),
                'codiHogar' => $this->session->userdata('codiHogar'),
                'idPers' => $this->session->userdata('codiPersona')
            );
            $arrPersona = $this->mpers->consultarPersonas($arrParam);
            //pr($arrPersona); exit;
            if(count($arrPersona) > 0) {
                $arrPersona = array_shift($arrPersona);
                if($arrPersona['CONDICION_FISICA'] == 2){
                        if(intval($edad) <= 5) {
                            $page = 20;
                        } else {
                            $page = 21;
                        }

                }

            }
        }*/

        $this->data['var'] = '';
        $this->data['view'] = 'persona';
        if(count($this->data['preguntas']) > 0) {
            $arrParam = array(
                'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda'),
                'codiHogar' => $this->session->userdata('codiHogar'),
                'idPers' => $this->session->userdata('codiPersona')
            );
            $arrPersona = $this->mpers->consultarPersonas($arrParam);
            //pr($arrPersona); exit;
            if(count($arrPersona) > 0) {
                $arrPersona = array_shift($arrPersona);
                if($arrPersona['P_NIVEL_ANOS'] === '0') {
                    //Se comenta esta linea para eliminar el valor ninguno por defecto
                    $arrPersona['P_NIVEL_ANOS'] = 44;
                }
                if(count($this->data['preguntas'][$page]) > 0 && empty($this->data['preguntas'][$page]['persona_exitoso'])) {
                    $this->data['var'] = asignar_valor_pregunta($this->data['preguntas'][$page], $arrPersona);
                    //$this->data['var'] = cambiar_campos_BD_HTML($arrPreguntas, $this->arrCampos[$page], $arrPersona);
                } else {
                    /*$this->data['msgError'] = 'No se encontraron las preguntas de la página ' . $page . ' en el módulo ' . $this->data['title'] . '.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->data['msgError']);
                    $this->session->set_flashdata('msgError', $this->data['msgError']);
                    redirect(base_url('inicio'));
                    return false;*/
                }
            }
        }
        //pr($this->data['var']); exit;
        if(!empty($this->data['var'])) {
            foreach ($this->data['var'] as $kv => $vv) {
                if(!empty($vv['ID_PREGUNTA_DEPEN'])) {
                    $this->data['var'][$kv]['HIDDEN'] = 'SI';
                    if(!empty($vv['VALOR_DEPEN'])) {
                        if(substr_count($vv['VALOR_DEPEN'], ',') > 0) {
                            $arrValDepen = explode(',', $vv['VALOR_DEPEN']);
                            if(!empty($arrPersona[$vv['ID_PREGUNTA_DEPEN']]) && in_array($arrPersona[$vv['ID_PREGUNTA_DEPEN']], $arrValDepen)) {
                                $this->data['var'][$kv]['HIDDEN'] = 'NO';
                            }
                        } else {
                            if(!empty($arrPersona[$vv['ID_PREGUNTA_DEPEN']]) && $arrPersona[$vv['ID_PREGUNTA_DEPEN']] == $vv['VALOR_DEPEN']) {
                                $this->data['var'][$kv]['HIDDEN'] = 'NO';
                            }
                        }
                    } else {
                        if(!empty($arrPersona[$vv['ID_PREGUNTA_DEPEN']]) && $arrPersona[$vv['ID_PREGUNTA_DEPEN']] > 0) {
                            $this->data['var'][$kv]['HIDDEN'] = 'NO';
                        }
                    }
                }
                $this->data['var'][$kv]['VIDEO'] = '';
                if(!empty($vv['URL_VIDEO'])) {
                    $this->data['mostrarVideo'] = 'SI';
                    $this->data['var'][$kv]['VIDEO'] = $vv['URL_VIDEO'];
                    $this->data['URLVideo'] = $vv['URL_VIDEO'];
                }
            }
        }

        $codigoMostrar = $this->config->item('tipoFormulario') . $page;
        if(!empty($this->data['preguntas'][$page]['persona_exitoso'])) {
            $codigoMostrar = 'completo';
        }

        switch ($codigoMostrar) {
            case 'E1':
            case 'A1':
            case 'B1':
            case 'G1':
            case 'H1':
                $this->data['arrJS'][] = base_url_plugins('moment/js/moment.min.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'sabe_fecha') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'fecha_naci') {
                                    $this->data['var'][$kp]['ANIO'] = date('Y');
                                    $this->data['var'][$kp]['ID_PREGUNTA_ANIO'] = 'anio_naci';
                                    $this->data['var'][$kp]['ID_PREGUNTA_MES'] = 'mes_naci';
                                    $this->data['var'][$kp]['ID_PREGUNTA_DIA'] = 'dia_naci';
                                    $this->data['var'][$kp]['VALOR_ANIO'] = '';
                                    $this->data['var'][$kp]['VALOR_MES'] = '';
                                    $this->data['var'][$kp]['VALOR_DIA'] = '';
                                    if(!empty($arrPersona['PA3_ANO_NAC'])) {
                                        $this->data['var'][$kp]['VALOR_ANIO'] = $arrPersona['PA3_ANO_NAC'];
                                    }
                                    if(!empty($arrPersona['PA2_MES_NAC'])) {
                                        $this->data['var'][$kp]['VALOR_MES'] = $arrPersona['PA2_MES_NAC'];
                                    }
                                    if(!empty($arrPersona['PA1_DIA_NAC'])) {
                                        $this->data['var'][$kp]['VALOR_DIA'] = $arrPersona['PA1_DIA_NAC'];
                                    }

                                    if(!empty($arrPersona['FECHANACI'])) {
                                        $tmpFechaNaci = explode('/', $arrPersona['FECHANACI']);
                                        $this->data['var'][$kp]['VALOR_ANIO'] = $tmpFechaNaci[2];
                                        $this->data['var'][$kp]['VALOR_MES'] = $tmpFechaNaci[1];
                                        $this->data['var'][$kp]['VALOR_DIA'] = $tmpFechaNaci[0];
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
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
                //pr($this->data); exit;
                break;
            case 'E2':
            case 'A2':
            case 'B2':
            case 'G2':
            case 'H2':
                $this->data['arrJS'][] = base_url_js('personas/personaE' . $page . '.js');
                break;
            case 'E3':
            case 'A3':
            case 'B3':
            case 'G3':
            case 'H3':
                //$this->data['view'] = 'persona3';
                $this->data['arrJS'][] = base_url_js('personas/personaE' . $page . '.js');
                $this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'etnia_persona') {
                        if(!empty($vv['OPCIONES'])) {
                            // @todo: falta revisar el dominio de los pueblos indigenas
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'pueblo_indigena' || $vp['REFERENCIA_HTML'] == 'clan_indigena') {
                                    $arrIndigenas = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO']));
                                    foreach ($arrIndigenas as $ki => $vi) {
                                        $tmpEtiqueta = explode(' ', $vi['ETIQUETA']);
                                        $descIndigena = (!empty($tmpEtiqueta[1])) ? $tmpEtiqueta[1]: $vi['ETIQUETA'];
                                        $this->data['var'][$kp]['OPCIONES'][$vi['ID_VALOR']] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vi['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vi['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vi['ID_VALOR']
                                        );

                                    }
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'vitsa_gitano') {
                                    $arrIndigenas = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO']));
                                    foreach ($arrIndigenas as $kd => $vd) {
                                        $this->data['var'][$kp]['OPCIONES'][$vd['ID_VALOR']] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vd['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vd['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vd['ID_VALOR']
                                        );
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'kumpania') {
                                    $arrIndigenas = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO']));
                                    foreach ($arrIndigenas as $kd => $vd) {
                                        $this->data['var'][$kp]['OPCIONES'][$vd['ID_VALOR']] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vd['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vd['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vd['ID_VALOR']
                                        );
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'habla_lengua') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'entiende_lengua') {
                                    $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'otras_lenguas') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'cuantas_lenguas') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                }
                break;
            case 'E4':
            case 'A4':
            case 'B4':
            case 'G4':
            case 'H4':
            case 'E5':
            case 'A5':
            case 'B5':
            case 'G5':
            case 'H5':
            case 'E6':
            case 'A6':
            case 'B6':
            case 'G6':
            case 'H6':
                // pr($page);
                $this->data['arrCss'][] = base_url_plugins('select2/css/select2.min.css');
                $this->data['arrCss'][] = base_url_plugins('select2/css/select2-bootstrap.min.css');
                $this->data['arrJS'][] = base_url_plugins('select2/js/select2.min.js');
                $this->data['arrJS'][] = base_url_plugins('select2/js/i18n/es.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE' . $page . '.js');
                //@todo: falta agregar validaciones por edad que viene por sesion
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'lugar_nacimiento' || $vv['REFERENCIA_HTML'] == 'lugar_5anios' || $vv['REFERENCIA_HTML'] == 'lugar_1anio') {
                        if(!empty($vv['OPCIONES'])) {
                            // $arrMunicipios = $this->mform->consultarRespuestaDominio(array('idDominio' => 2));
                            $arrMunicipios = $this->config->item('municipios');
                            foreach ($vv['OPCIONES'] as $kop => $vop) {
                                if($vop['DESCRIPCION_OPCION'] == '#MUNICIPIO_REGISTRO#') {
                                    $this->load->model('vivienda/modvivienda', 'mvivi');
                                    $arrParamVivi = array(
                                        'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                                        'codiVivienda' => $this->session->userdata('codiVivienda')
                                    );
                                    $arrVivi = $this->mvivi->consultarVivienda($arrParamVivi);
                                    foreach ($arrMunicipios as $km => $vm) {
                                        if($vm['ID_VALOR'] == $arrVivi[0]['U_MPIO']) {
                                            $this->data['var'][$kv]['OPCIONES'][$kop]['DESCRIPCION_OPCION'] = $vm['ETIQUETA'];
                                            unset($arrMunicipios[$km]);
                                            break;
                                        }
                                    }
                                }
                            }
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'depto_nacimiento' || $vp['REFERENCIA_HTML'] == 'depto_5anios' || $vp['REFERENCIA_HTML'] == 'depto_1anio') {
                                    // $arrDepartamentos = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO']));
                                    $arrDepartamentos = $this->config->item('departamentos');
                                    $depto = '';
                                    foreach ($arrDepartamentos as $kd => $vd) {
                                        if (!empty($vp['VALOR']) && $vd['VALOR_MINIMO'] == $vp['VALOR']){
                                            $depto = $vd['ID'];
                                        }
                                        $this->data['var'][$kp]['OPCIONES'][$vd['ID_VALOR']] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vd['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vd['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vd['ID_VALOR']
                                        );
                                    }
                                    if($vv['REFERENCIA_HTML'] == 'lugar_nacimiento') {
                                        $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    } else if($vv['REFERENCIA_HTML'] == 'lugar_5anios' || $vp['REFERENCIA_HTML'] == 'depto_1anio') {
                                        $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    }
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'muni_nacimiento' || $vp['REFERENCIA_HTML'] == 'muni_5anios' || $vp['REFERENCIA_HTML'] == 'muni_1anio') {

                                    // Se hace el filtrado de los municipios asociados al departamento seleccionado solo si existe valor en la pregunta
                                    // $arrMpioDepto = array();
                                    foreach ($arrMunicipios as $km => $vm) {
                                        if (!empty($depto) && $vm['ID_RESPUESTA_DOMINIO_PADRE'] == $depto){ $arrMpioDepto[] = $vm; }
                                    }

                                    if (!empty($vp['VALOR'])){ $arrMunicipios = $arrMpioDepto;
                                    } else { $arrMunicipios = array(); }
                                    // fin del ajuste

                                    foreach ($arrMunicipios as $km => $vm) {
                                        $tmpEtiqueta = explode(' - ', $vm['ETIQUETA']);
                                        $descMuni = (!empty($tmpEtiqueta[1])) ? $tmpEtiqueta[1]: $vm['ETIQUETA'];
                                        $this->data['var'][$kp]['OPCIONES'][$vm['ID_VALOR']] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vm['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $descMuni,
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vm['ID_VALOR']
                                        );
                                    }
                                    if($vp['REFERENCIA_HTML'] == 'muni_nacimiento') {
                                        $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    } else if($vp['REFERENCIA_HTML'] == 'muni_5anios' || $vp['REFERENCIA_HTML'] == 'muni_1anio') {
                                        $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    }
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'pais_nacimiento' || $vp['REFERENCIA_HTML'] == 'pais_5anios' || $vp['REFERENCIA_HTML'] == 'pais_1anio') {
                                    $arrPaises = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO'], 'noValor' => 169));
                                    foreach ($arrPaises as $kpa => $vpa) {
                                        $this->data['var'][$kp]['OPCIONES'][$vpa['ID_VALOR']] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vpa['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vpa['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vpa['ID_VALOR']
                                        );
                                    }
                                    if($vp['REFERENCIA_HTML'] == 'pais_nacimiento') {
                                        $this->data['var'][$kv]['OPCIONES'][2]['PREGUNTA'][] = $this->data['var'][$kp];
                                    } else if($vp['REFERENCIA_HTML'] == 'pais_5anios' || $vp['REFERENCIA_HTML'] == 'pais_1anio') {
                                        $this->data['var'][$kv]['OPCIONES'][2]['PREGUNTA'][] = $this->data['var'][$kp];
                                    }
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'anio_llego') {
                                    //$anioLimite = (!empty($arrPersona['PA3_ANO_NAC'])) ? $arrPersona['PA3_ANO_NAC']: '1946';
                                    $anioLimite = '1904';
                                    if(!empty($arrPersona['FECHANACI'])) {
                                        $tmpFechaNaci = explode('/', $arrPersona['FECHANACI']);
                                        $anioLimite = $tmpFechaNaci[2];
                                    }
                                    for($i = date('Y'); $i >= $anioLimite; $i--) {
                                        $this->data['var'][$kp]['OPCIONES'][$i] = array(
                                            'REFERENCIA_HTML' => $vp['REFERENCIA_HTML'],
                                            'ID_OPCION' => $i,
                                            'DESCRIPCION_OPCION' => $i,
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $i
                                        );
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][2]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'anio_llego_5anios') {
                                    for($i = date('Y'); $i >= intval(date('Y') - 5); $i--) {
                                        $this->data['var'][$kp]['OPCIONES'][$i] = array(
                                            'REFERENCIA_HTML' => $vp['REFERENCIA_HTML'],
                                            'ID_OPCION' => $i,
                                            'DESCRIPCION_OPCION' => $i,
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $i
                                        );
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][2]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    } else if($vv['REFERENCIA_HTML'] == 'clase_5anios' || $vv['REFERENCIA_HTML'] == 'clase_1anio') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($vv['OPCIONES'] as $ko => $vo) {
                                $this->data['var'][$kv]['OPCIONES'][$ko]['DESCRIPCION_OPCION'] = $this->mform->asignarValorEtiqueta($vo['DESCRIPCION_OPCION']);
                            }
                        }
                    }
                }
                break;
            case 'E7':
                $this->data['arrJS'][] = base_url_js('personas/personaE' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'dias_no_comio') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'numero_no_comio') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    break;
                                }
                            }
                        }
                    }
                }
                break;
            case 'E8':
            case 'H7':
                // pr($this->session->userdata());
                $this->data['arrJS'][] = base_url_js('personas/personaE8.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'afiliado_salud') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'regimen_salud') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    break;
                                }
                            }
                        }
                    }
                }
                break;
            case 'E9':
            case 'H8':
                $this->data['arrJS'][] = base_url_js('personas/personaE9.js');

                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'enfermo') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'tratamiento') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    break;
                                }
                            }
                        }
                    }

                    if($vv['REFERENCIA_HTML'] == 'atencion') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'calidad') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    break;
                                }
                            }
                        }
                    }
                }

                break;
            case 'E10':
            case 'A7':
            case 'G7':
            case 'H9':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE10.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E11':
            case 'A8':
            case 'G8':
            case 'H10':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE11.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E12':
            case 'A9':
            case 'G9':
            case 'H11':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE12.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E13':
            case 'A10':
            case 'G10':
            case 'H12':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE13.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E14':
            case 'A11':
            case 'G11':
            case 'H13':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE14.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E15':
            case 'A12':
            case 'G12':
            case 'H14':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE15.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E16':
            case 'A13':
            case 'G13':
            case 'H15':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE16.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E17':
            case 'A14':
            case 'G14':
            case 'H16':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE17.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E18':
            case 'A15':
            case 'G15':
            case 'H17':
                //$this->data['mostrarTituloLimitacion'] = 'SI';
                $this->data['arrJS'][] = base_url_js('personas/personaE18.js');
                //$this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                break;
            case 'E19':
            case 'A16':
            case 'G16':
            case 'H18':
                //$this->data['arrJS'][] = base_url_js('personas/persona' . $codigoMostrar . '.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE19.js');
                $this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                $this->data['nombreDificultad'] = '';
                if(count($arrPersona) > 0) {
                    $keysVar = array_keys($this->data['var']);
                    if(!empty($arrPersona['P_LIM_PPAL'])) {
                        $arrOpcion = $this->mform->consultarOpciones('P_LIM_PPAL', $arrPersona['P_LIM_PPAL']);
                        $this->data['nombreDificultad'] = strtolower($arrOpcion[0]['DESCRIPCION_OPCION']);
                        $this->data['var'][$keysVar[0]]['DESCRIPCION'] = '';
                        $this->data['var'][$keysVar[0]]['HIDDEN'] = 'SI';
                    } else {
                        if(!empty($arrPersona['PA_OIR']) && $arrPersona['PA_OIR'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][0]);
                        }
                        if(!empty($arrPersona['PB_HABLAR']) && $arrPersona['PB_HABLAR'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][1]);
                        }
                        if(!empty($arrPersona['PC_VER']) && $arrPersona['PC_VER'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][2]);
                        }
                        if(!empty($arrPersona['PD_CAMINAR']) && $arrPersona['PD_CAMINAR'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][3]);
                        }
                        if(!empty($arrPersona['PE_COGER']) && $arrPersona['PE_COGER'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][4]);
                        }
                        if(!empty($arrPersona['PF_DECIDIR']) && $arrPersona['PF_DECIDIR'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][5]);
                        }
                        if(!empty($arrPersona['PG_COMER']) && $arrPersona['PG_COMER'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][6]);
                        }
                        if(!empty($arrPersona['PH_RELACION']) && $arrPersona['PH_RELACION'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][7]);
                        }
                        if(!empty($arrPersona['PI_TAREAS']) && $arrPersona['PI_TAREAS'] == 4) {
                            unset($this->data['var'][$keysVar[0]]['OPCIONES'][8]);
                        }
                    }
                }
                //pr($this->data); exit;
                break;
            case 'E20':
            case 'A17':
            case 'G17':
            case 'H19':
                //$this->data['arrJS'][] = base_url_js('personas/persona' . $codigoMostrar . '.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE20.js');
                $this->data['mostrarTituloAyudas'] = 'SI';
                $this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                $this->data['nombreDificultad'] = '';
                if(count($arrPersona) > 0) {
                    if(!empty($arrPersona['P_LIM_PPAL'])) {
                        $arrOpcion = $this->mform->consultarOpciones('P_LIM_PPAL', $arrPersona['P_LIM_PPAL']);
                        $this->data['nombreDificultad'] = strtolower($arrOpcion[0]['DESCRIPCION_OPCION']);
                    }
                }
                //pr($this->data); exit;
                break;
            case 'E21':
            case 'H20':
                $this->data['arrJS'][] = base_url_js('personas/personaE21.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'cuida') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'establecimiento') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                }
                break;
            case 'E22':
            case 'A18':
            case 'B7':
            case 'G18':
            case 'H21':
                //$this->data['arrJS'][] = base_url_js('personas/persona' . $codigoMostrar . '.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE22.js');
                break;
            case 'E23':
            case 'A19':
            case 'B8':
            case 'G19':
            case 'H22':
                //$this->data['view'] = 'persona' . $codigoMostrar;
                $this->data['view'] = 'personaE23';
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'principal_causa') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                $arrPreguntasCausas = array('causa_familiar', 'causa_economica', 'causa_instituto', 'causa_educativa', 'causa_entorno', 'causa_discriminacion', 'causa_personal');
                                foreach ($arrPreguntasCausas as $kpc => $vpc) {
                                    if($vp['REFERENCIA_HTML'] == $vpc) {
                                        $this->data['var'][$kv]['OPCIONES'][$kpc]['PREGUNTA'][] = $this->data['var'][$kp];
                                        unset($this->data['var'][$kp]);
                                    }
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'nivel_anios') {
                        if(count($vv['OPCIONES']) > 0) {
                            foreach ($vv['OPCIONES'] as $kvvo => $vvvo) {
                                $this->data['var'][$kv]['OPCIONES'][$kvvo]['REFERENCIA_HTML'] = 'nivel_anios';
                            }
                        }
                    }
                }
                // pr($this->data['var']); exit;
                break;
            case 'E24':
            case 'A20':
            case 'B9':
            case 'G20':
            case 'H23':
                //$this->data['arrJS'][] = base_url_js('personas/persona' . $codigoMostrar . '.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE24.js');
                break;
            case 'E25':
                //$this->data['view'] = 'persona' . $codigoMostrar;
                $this->data['arrJS'][] = base_url_js('personas/persona' . $codigoMostrar . '.js');
                $this->data['mostrarTituloTrabajo'] = 'SI';
                $this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                $this->data['semanaPasada'] = calcular_ult_sem(formatear_fecha($this->session->userdata('fechaInscripcion')));
                $this->data['nombreTrabajo'] = '';
                if(count($arrPersona) > 0) {
                    if(!empty($arrPersona['P_TRABAJO'])) {
                        $arrOpcion = $this->mform->consultarOpciones('P_TRABAJO', $arrPersona['P_TRABAJO']);
                        $this->data['nombreTrabajo'] = strtolower(substr($arrOpcion[0]['DESCRIPCION_OPCION'], 0));
                    }
                }
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['TIPO_CAMPO'] == 'SELUNICA') {
                        for($i = 1; $i <= 40; $i++) {
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

                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'negocio_familia') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_negocio_familia') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'venta_producto') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_venta_producto') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'elaboro_producto') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_elaboro_producto') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'otro_pago') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_otro_pago') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'trabajo_etnico') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_trabajo_etnico') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'labores_campo') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_labores_campo') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'voluntario') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_voluntario') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'cuido_ninos') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_cuido_ninos') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'otra_actividad') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'horas_otra_actividad') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                }
                break;
            case 'E26':
            case 'H24':
                $this->data['arrJS'][] = base_url_js('personas/personaE26.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'cotizando_pension') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'fondo_cotiza') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    break;
                                }
                            }
                        }
                    }
                }
                break;
            case 'E27':
            case 'A21':
            case 'B10':
            case 'G21':
            case 'H25':
                $this->data['arrJS'][] = base_url_js('personas/personaE27.js');
                break;
            //case 'E281': // Pregunta de religion
            case 'E28':
            case 'A22':
            case 'B11':
            case 'G22':
            case 'H26':
                //$this->data['view'] = 'persona' . $codigoMostrar;
                $this->data['view'] = 'personaE28';
                $this->data['mostrarTituloVivos'] = $this->data['mostrarTituloFuera'] = 'NO';
                if(count($arrPersona) > 0) {
                    if(!empty($arrPersona['PA2_HNVH']) || !empty($arrPersona['PA3_HNVM'])) {
                        $this->data['mostrarTituloVivos'] = $this->data['mostrarTituloFuera'] = 'SI';
                    }
                }
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'hijos_vivos') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'cuantos_vivos' || $vp['REFERENCIA_HTML'] == 'cuantos_hombres_vivos' || $vp['REFERENCIA_HTML'] == 'cuantas_mujeres_vivas') {
                                    for($i = 0; $i <= 24; $i++) {
                                        $this->data['var'][$kp]['OPCIONES'][$i - 1] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $i,
                                            'DESCRIPCION_OPCION' => $i,
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $i
                                        );
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                    $arrPreguntasNum = array('hoy_cuantos_hombres_vivos', 'hoy_cuantas_mujeres_vivas', 'fuera_cuantos_hombres', 'fuera_cuantas_mujeres');
                    if(in_array($vv['REFERENCIA_HTML'], $arrPreguntasNum)) {
                        for($i = 0; $i <= 24; $i++) {
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
            case 'E29':
            case 'A23':
            case 'B12':
            case 'G23':
            case 'H27':
                //$this->data['view'] = 'persona' . $codigoMostrar;
                //$this->data['arrJS'][] = base_url_js('personas/persona' . $codigoMostrar . '.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE29.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'sabe_fecha_ultimo') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'mes_ultimo_vivo') {
                                    $arrMeses = arreglo_meses();
                                    foreach ($arrMeses as $km => $vm) {
                                        $this->data['var'][$kp]['OPCIONES'][$km] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vm['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vm['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vm['ID_VALOR']
                                        );
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                } else if($vp['REFERENCIA_HTML'] == 'anio_ultimo_vivo') {
                                    //$edad = 30;
                                    if($edad > 10) {
                                        // Se definio que el anio debe ser el anio de nacimiento más 10 anios
                                        $edad = $edad - 10;
                                        $anioActual = intval(date('Y'));
                                        $inicio = $anioActual - $edad;
                                        $j = 0;
                                        for($i = $inicio; $i <= $anioActual; $i++) {
                                            $this->data['var'][$kp]['OPCIONES'][$j] = array(
                                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                                'ID_OPCION' => $i,
                                                'DESCRIPCION_OPCION' => $i,
                                                'AYUDA' => '',
                                                'ORDEN_VISUAL' => $j
                                            );
                                            $j++;
                                        }
                                        $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                        unset($this->data['var'][$kp]);
                                    }
                                }
                            }
                        }
                    }
                }
                break;
            case 'E30':
            case 'A24':
                //$this->data['arrJS'][] = base_url_js('personas/persona' . $codigoMostrar . '.js');
                $this->data['arrJS'][] = base_url_js('personas/personaE30.js');
                break;
            case 'completo':
                $this->data['view'] = 'personaExitoso';
                $this->data['nombrePersona'] = $this->session->userdata('nombrePersona');
                $this->data['imageLogo'] = 'completo_personas';
                //pr($this->data); exit;
                break;
            case 'E32':
                redirect(base_url('personas'));
                break;
        }
        // pr($this->data); exit;
        $this->load->view('layout', $this->data);
    }

    /**
     * Guarda el contenido de las paginas del modulo
     * @author oagarzond
     * @since 2017-03-24
     */
    public function guardar() {
        //pr($this->session->all_userdata()); exit;
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

        $this->load->model('modpersonas', 'mpers');

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $page = (!empty($this->session->userdata('numeroPagina'))) ? $this->session->userdata('numeroPagina'): 1;
        $this->construirPreguntas();
        $duracion = $postt['duracion'];
        unset($postt['duracion']);
        /*if(!empty($postt['numePers'])) {
            $this->session->set_userdata('numeroPersona', $postt['numePers']);
            unset($postt['numePers']);
        }*/
        //pr($this->session->all_userdata()); exit;
        //@todo: Si se cambio la fecha de nacimiento de mostrar mensaje de alerta
        //Debido al cambio de edad, por favor verifique el formulario de esta persona para rectificar la información diligenciada ante posibles cambios.
        //@todo: falta consultar y guardar el tiempo de entrevista - 2017-03-23
        $this->mpers->setCodiEncuesta($codiEncuesta);
        $this->mpers->setCodiVivienda($this->session->userdata('codiVivienda'));
        $this->mpers->setCodiHogar($this->session->userdata('codiHogar'));
        $this->mpers->setCodiPersona($this->session->userdata('codiPersona'));
        $this->mpers->setNumeroPersona($this->session->userdata('numeroPersona'));
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

        //Se agrega este código para saltearnos la pregunta N0. 7
        if($page == 6 || $page == 23){
            $page = $page + 1;
        }
        //Hasta aquí va el código

        // Se valida por edad, sexo que pagina se debe mostrar
        $edad = intval($this->session->userdata('edadPersona'));
        $sexo = $this->session->userdata('sexoPersona');
        $codigoMostrar = $this->config->item('tipoFormulario') . $page;
        switch ($codigoMostrar) {
            case 'E1':
            case 'A1':
            case 'B1':
            case 'G1':
            case 'H1':
                if(!empty($postt['anio_naci'])) {
                    $this->data['form']['PA1_FECHA_NAC'] = $postt['dia_naci'] . '/' . $postt['mes_naci'] . '/' . $postt['anio_naci'];
                }
                $numeroPersona = $this->session->userdata('numeroPersona');
                if($numeroPersona == 1) {
                    // Se actualiza para que defina la fecha en que inicio de completar la persona
                    if(!$this->mpers->actualizarEstadoACP($page + 1)) {
                        $response['codiError'] = 2;
                        $response['mensaje'] = 'No se pudo actualizar el estado de la persona en la encuesta.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                    }
                    $page = intval($page) + 2;
                } else {
                    $page = intval($page) + 1;
                }
                break;
        	case 'E4':
            case 'A4':
            case 'B4':
            case 'G4':
            case 'H4':
                // Se consulta los ejemplos de Centro Poblado por municipio
                $this->load->model('vivienda/modvivienda', 'mvivi');

                $arrParam = array(
                    'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                    'codiVivienda' => $this->session->userdata('codiVivienda')
                );
                $arrVivi = $this->mvivi->consultarVivienda($arrParam);
                if(!empty($arrVivi['U_MPIO'])) {
                    $ejemplosCPob = '';
                    $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
                    if(count($padre) > 0) {
                        $arrEjemplos = $this->mform->consultarRespuestaDominio(array('idDominio' => 96, 'idPadre' => $padre[0]['ID']));
                        if(count($arrEjemplos) > 0) {
                            foreach ($arrEjemplos as $kej => $vej) {
                                $ejemplosCPob .= $vej['ETIQUETA'] . ', ';
                            }
                            $ejemplosCPob = substr($ejemplosCPob, 0, -2);
                        }
                    }
                    $this->session->set_userdata('ejemplosCPob', $ejemplosCPob);
                }
        		if($edad < 5) {
        			$this->data['form']['PA_VIVIA_5ANOS'] = 1;
        			$this->data['form']['PA1_DPTO_5ANOS'] = $this->data['form']['PA2_MPIO_5ANOS'] = $this->data['form']['PA3_PAIS_5ANO'] = 'NULL';
        			$this->data['form']['PA31_ANO_LLEGA5'] = $this->data['form']['PA21_CLASE_5ANOS'] = 'NULL';
                    $page = intval($page) + 2;
                    if($edad < 1) {
                    	$this->data['form']['PA_VIVIA_5ANOS'] = 'NULL';
	        			$this->data['form']['PA_VIVIA_1ANO'] = 1;
	        			$this->data['form']['PA1_DPTO_1ANO'] = $this->data['form']['PA2_MPIO_1ANO'] = $this->data['form']['PA3_PAIS_1ANO'] = 'NULL';
	        			$this->data['form']['PA21_CLASE_1ANO'] = 'NULL';
                        if($codigoMostrar == 'B4') {
                            $page = $this->data['totalPaginas'];
                        } else {
                            $page = intval($page) + 1;
                        }
	                }
                } else {
                    $page = intval($page) + 1;
                }
        		break;
        	case 'E5':
            case 'A5':
            case 'B5':
            case 'G5':
            case 'H5':
                // Se consulta los ejemplos de Centro Poblado por municipio
                $this->load->model('vivienda/modvivienda', 'mvivi');

                $arrParam = array(
                    'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                    'codiVivienda' => $this->session->userdata('codiVivienda')
                );
                $arrVivi = $this->mvivi->consultarVivienda($arrParam);
                if(!empty($arrVivi['U_MPIO'])) {
                    $ejemplosCPob = '';
                    $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
                    if(count($padre) > 0) {
                        $arrEjemplos = $this->mform->consultarRespuestaDominio(array('idDominio' => 96, 'idPadre' => $padre[0]['ID']));
                        if(count($arrEjemplos) > 0) {
                            foreach ($arrEjemplos as $kej => $vej) {
                                $ejemplosCPob .= $vej['ETIQUETA'] . ', ';
                            }
                            $ejemplosCPob = substr($ejemplosCPob, 0, -2);
                        }
                    }
                    $this->session->set_userdata('ejemplosCPob', $ejemplosCPob);
                }
                if($edad < 5) {
            		if($edad < 1) {
            			$this->data['form']['PA_VIVIA_1ANO'] = 1;
            			$this->data['form']['PA1_DPTO_1ANO'] = $this->data['form']['PA2_MPIO_1ANO'] = $this->data['form']['PA3_PAIS_1ANO'] = 'NULL';
            			$this->data['form']['PA21_CLASE_1ANO'] = $this->data['form']['P_CAUSA_1ANO'] = 'NULL';
                    }
                    if($codigoMostrar == 'B5' || $codigoMostrar == 'G5') {
                        $page = $this->data['totalPaginas'];
                    } else {
                        $page = intval($page) + 1;
                    }
                } else {
                    $page = intval($page) + 1;
                }
        		break;
            case 'E18':
            case 'A15':
            case 'G15':
            case 'H17':
                $arrParam = array(
                    'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                    'codiVivienda' => $this->session->userdata('codiVivienda'),
                    'codiHogar' => $this->session->userdata('codiHogar'),
                    'idPers' => $this->session->userdata('codiPersona')
                );
                $arrPersona = $this->mpers->consultarPersonas($arrParam);
                //pr($arrPersona); exit;
                if(count($arrPersona) > 0) {
                    $arrPersona = array_shift($arrPersona);
                    $sinDificulad = $totalDificultad = $principalDificultad = 0;
                    if(isset($arrPersona['PA_OIR']) && !empty($arrPersona['PA_OIR'])) {
                        if($arrPersona['PA_OIR'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 1;
                        }
                    }
                    if(isset($arrPersona['PB_HABLAR']) && !empty($arrPersona['PB_HABLAR'])) {
                        if($arrPersona['PB_HABLAR'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 2;
                        }
                    }
                    if(isset($arrPersona['PC_VER']) && !empty($arrPersona['PC_VER'])) {
                        if($arrPersona['PC_VER'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 3;
                        }
                    }
                    if(isset($arrPersona['PD_CAMINAR']) && !empty($arrPersona['PD_CAMINAR'])) {
                        if($arrPersona['PD_CAMINAR'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 4;
                        }
                    }
                    if(isset($arrPersona['PE_COGER']) && !empty($arrPersona['PE_COGER'])) {
                        if($arrPersona['PE_COGER'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 5;
                        }
                    }
                    if(isset($arrPersona['PF_DECIDIR']) && !empty($arrPersona['PF_DECIDIR'])) {
                        if($arrPersona['PF_DECIDIR'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 6;
                        }
                    }
                    if(isset($arrPersona['PG_COMER']) && !empty($arrPersona['PG_COMER'])) {
                        if($arrPersona['PG_COMER'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 7;
                        }
                    }
                    if(isset($arrPersona['PH_RELACION']) && !empty($arrPersona['PH_RELACION'])) {
                        if($arrPersona['PH_RELACION'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 8;
                        }
                    }
                    if(isset($this->data['form']['PI_TAREAS']) && !empty($this->data['form']['PI_TAREAS'])) {
                        if($this->data['form']['PI_TAREAS'] == 4) {
                            $sinDificulad++;
                        } else {
                            $totalDificultad++;
                            $principalDificultad = 9;
                        }
                    }
                    // Si las dificultades son mas de 1 y ya se habia guardado P_LIM_PPAL
                    if(!empty($arrPersona['P_LIM_PPAL'])) {
                        $principalDificultad = $arrPersona['P_LIM_PPAL'];
                        $totalDificultad = 1;
                    }

                    // Se guarda el orden en que aparece las dificultades
                    if($totalDificultad == 1) {
                        $this->data['form']['P_LIM_PPAL'] = $principalDificultad;
                        $this->load->model('modform', 'mform');
                        $arrOpcion = $this->mform->consultarOpciones('P_LIM_PPAL', $principalDificultad);
                        $this->session->set_userdata('nombreDificultad', strtolower($arrOpcion[0]['DESCRIPCION_OPCION']));
                    }

                    // Se salta a la página que corresponde por edad
                    if($sinDificulad == 9) {
                        $this->data['form']['P_LIM_PPAL'] = $this->data['form']['P_CAUSA_LIM'] = 'NULL';
                        $this->data['form']['PA_AYUDA_TEC'] = $this->data['form']['PB_AYUDA_PERS'] = 'NULL';
                        $this->data['form']['PC_AYUDA_MED'] = $this->data['form']['PD_AYUDA_ANCES'] = 'NULL';
                        if($codigoMostrar == 'E18') {
                            if(intval($edad) < 3) {
                                $page = $this->data['totalPaginas'];
                            } else {
                                $page = intval($page) + 3;
                            }
                        } else if($codigoMostrar == 'H17') {
                            if(intval($edad) <= 5) {
                                $page = intval($page) + 3;
                            } else {
                                $page = intval($page) + 4;
                            }
                        } else if(in_array($codigoMostrar, array('A15','G15'))) {
                            if(intval($edad) <= 5) {
                                $page = $this->data['totalPaginas'];
                            } else {
                                $page = intval($page) + 3;
                            }
                        }
                    } else {
                        $page = intval($page) + 1;
                    }
                } else {
                    $page = intval($page) + 1;
                }
                break;
            case 'E20':
            case 'H19':
                // No se pregunta en alterno porque no tiene preguntas de menor 5
                if($edad >= 5) {
                    $page = intval($page) + 2;
                } else {
                    $page = intval($page) + 1;
                }
                break;
            case 'E21':
            case 'H20':
                if($codigoMostrar == 'E21') {
                    if(intval($edad) <= 3) {
                        $page = $this->data['totalPaginas'];
                    } else {
                        $page = intval($page) + 3;
                    }
                } else {
                    if(intval($edad) <= 5) {
                        $page = $this->data['totalPaginas'];
                    } else {
                        $page = intval($page) + 1;
                    }
                }
                break;
            case 'E22':
            case 'H21':
                /*if($edad < 5) {
                    $page = intval($page) + 1;
                } else {
                    $page = intval($page) + 1;
                }*/
                $page = intval($page) + 1;
                break;
            case 'E23':
            case 'A19':
            case 'B8':
            case 'G19':
            case 'H22':
                if($this->data['form']['P_NIVEL_ANOS'] == 44) {
                    $this->data['form']['P_NIVEL_ANOS'] = 0;
                }
                if($edad < 10) {
                    $page = $this->data['totalPaginas'];
                } else {
                    $page = intval($page) + 1;
                }
                break;
            case 'E24':
                if($edad < 10 || ($this->data['form']['P_TRABAJO'] == 1 || $this->data['form']['P_TRABAJO'] == 2)) {
                    $this->data['form']['PA_NEG_FLIA'] = $this->data['form']['PA1_QHORAS_NFLIA'] = 'NULL';
                    $this->data['form']['PB_VENT_PROD'] = $this->data['form']['PB1_QHORAS_VPROD'] = 'NULL';
                    $this->data['form']['PC_ELAB_PROD'] = $this->data['form']['PC1_QHORAS_NEGFLIC'] = 'NULL';
                    $this->data['form']['PD_OTROXPAGO'] = $this->data['form']['PD1_QHORAS_OPAGO'] = 'NULL';
                    $this->data['form']['PE_TRAB_ETNICO'] = $this->data['form']['PE1_QHORAS_TETNICO'] = 'NULL';
                    $this->data['form']['PF_LAB_CAMPO'] = $this->data['form']['PF1_QHORAS_LCAMPO'] = 'NULL';
                    $this->data['form']['PG_TRAB_VOLU'] = $this->data['form']['PG1_QHORAS_TVOLU'] = 'NULL';
                    $this->data['form']['PH_CUIDO_NINOS'] = $this->data['form']['PH1_QHORAS_CNINOS'] = 'NULL';
                    $this->data['form']['PI_OTRA_ACT'] = $this->data['form']['PI1_QHORAS_OACT'] = 'NULL';
                }
                if($edad < 10) {
                    $page = $this->data['totalPaginas'];
                } else if($this->data['form']['P_TRABAJO'] == 1 || $this->data['form']['P_TRABAJO'] == 2) {
                    $page = intval($page) + 2;
                } else {
                    $page = intval($page) + 1;
                }
                break;
            case 'E27':
            case 'A21':
            case 'B10':
            case 'G21':
            case 'H25':
                // Se debe validar si es diferente a mujer siga a la siguiente pagina
                if($sexo == 2) {
                    if($edad >= 10) {
                        $page = intval($page) + 1;
                    } else {
                        $page = $this->data['totalPaginas'];
                    }
                //Se realiza el ajuste para personas hermafroditas, dando un flujo igual al de los hombres.
                //} else if($sexo == 1) {
                } else if($sexo == 1 || $sexo == 3) {
                    if($edad >= 18) {
                        if($codigoMostrar == 'B10') {
                            $page = $this->data['totalPaginas'];
                        } else {
                            $page = intval($page) + 3;
                        }
                    } else {
                        //$page = intval($page) + 4;
                        $page = $this->data['totalPaginas'];
                    }
                } else {
                    //Se realiza el ajuste para personas hermafroditas, dando un flujo igual al de los hombres.
                    //En caso de que el sexo este en null (no deberia suceder) se lleva el flujo al final de las paginas.
                    //$page = intval($page) + 4;
                    $page = $this->data['totalPaginas'];
                }
                break;
            case 'E28':
            case 'A22':
            case 'B11':
            case 'G22':
            case 'H26':
                foreach ($this->data['form'] as $kform => $vform) {
                    if($vform == '-') {
                        $this->data['form'][$kform] = null;
                    }
                }
                if(!empty($this->data['form']['PA2_HNVH'])) {
                    $this->data['form']['PA1_THNV'] = $this->data['form']['PA2_HNVH'];
                    if(!empty($this->data['form']['PA3_HNVM'])) {
                        $this->data['form']['PA1_THNV'] = intval($this->data['form']['PA2_HNVH']) + intval($this->data['form']['PA3_HNVM']);
                    }
                } else {
                    if(!empty($this->data['form']['PA3_HNVM'])) {
                        $this->data['form']['PA1_THNV'] = $this->data['form']['PA3_HNVM'];
                    }
                }
                if(!empty($this->data['form']['PA2_HSVH'])) {
                    $this->data['form']['PA_HNVS'] = 1;
                    $this->data['form']['PA1_THSV'] = $this->data['form']['PA2_HSVH'];
                    if(!empty($this->data['form']['PA3_HSVM'])) {
                        $this->data['form']['PA1_THSV'] = intval($this->data['form']['PA2_HSVH']) + intval($this->data['form']['PA3_HSVM']);
                    }
                } else {
                    if(!empty($this->data['form']['PA3_HSVM'])) {
                        $this->data['form']['PA_HNVS'] = 1;
                        $this->data['form']['PA1_THSV'] = $this->data['form']['PA3_HSVM'];
                    } else {
                        $this->data['form']['PA_HNVS'] = 2;
                        $this->data['form']['PA1_THSV'] = 0;
                    }
                }
                if(!empty($this->data['form']['PA2_HFCH'])) {
                    $this->data['form']['PA_HFC'] = 1;
                    //$this->data['form']['PA1_THSV'] = $this->data['form']['PA2_HFCH'];
                    $this->data['form']['PA1_THFC'] = $this->data['form']['PA2_HFCH'];
                    if(!empty($this->data['form']['PA3_HFCM'])) {
                        $this->data['form']['PA1_THFC'] = intval($this->data['form']['PA2_HFCH']) + intval($this->data['form']['PA3_HFCM']);
                    }
                } else {
                    if(!empty($this->data['form']['PA3_HFCM'])) {
                        $this->data['form']['PA_HFC'] = 1;
                        $this->data['form']['PA1_THFC'] = $this->data['form']['PA3_HFCM'];
                    } else {
                        $this->data['form']['PA_HFC'] = 2;
                        $this->data['form']['PA1_THFC'] = 0;
                    }
                }
                if($sexo == 2) {
                    if($edad >= 10) {
                        $page = intval($page) + 1;
                    } else {
                        $page = $this->data['totalPaginas'];
                    }
                } else if($sexo == 1) {
                    if($edad >= 18) {
                        if($codigoMostrar == 'B11') {
                            $page = $this->data['totalPaginas'];
                        } else {
                            $page = intval($page) + 3;
                        }
                    } else {
                        $page = intval($page) + 4;
                    }
                } else {
                    $page = intval($page) + 4;
                }
                if($this->data['form']['PA_HNV'] == 2) {
                    if(in_array($codigoMostrar, array('B11','G22','H26'))) {
                        $page = $this->data['totalPaginas'];
                    }
                }
                break;
            case 'E29':
            case 'A23':
            case 'G23':
                if($edad >= 18) {
                    if($sexo != 1 && $sexo != 2) {
                        $page = intval($page) + 2;
                    } else {
                        $page = intval($page) + 1;
                    }
                } else {
                    $page = intval($page) + 2;
                }
                break;
            case 'H9':
                if($this->data['form']['CONDICION_FISICA'] == 2){
                    if(intval($edad) <= 5) {
                       $page = 20;
                    } else {
                        $page = 21;
                    }
                    $this->data['form']['PA_OIR'] = '';
                    $this->data['form']['PB_HABLAR'] = '';
                    $this->data['form']['PC_VER'] = '';
                    $this->data['form']['PD_CAMINAR'] = '';
                    $this->data['form']['PE_COGER'] = '';
                    $this->data['form']['PF_DECIDIR'] = '';
                    $this->data['form']['PG_COMER'] = '';
                    $this->data['form']['PH_RELACION'] = '';
                    $this->data['form']['PI_TAREAS'] = '';

                }else{
                    $page = intval($page) + 1;
                }
            break;
            default:

                $page = intval($page) + 1;
                break;
        }
        // pr($page); exit;
        // pr($this->data['totalPaginas']);
        // pr($this->data['form']);
        // die();

        if($this->mpers->actualizarPersona($this->data['form'])) {

            if($this->mpers->actualizarEstadoACP($page)) {
                if(($page - 1) == $this->data['totalPaginas']) {
                    $response['avance'] = '100%';
                } else {
                    $response['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']) . '%';
                }
                $this->load->model('encuesta/modencuesta', 'mencu');
                if($this->mencu->registrarTiempo('personas', $duracion)) {
                    $response['mensaje'] = 'Se guardaron correctamente los datos de la persona.';
                    $this->session->set_userdata('numeroPagina', $page);
                } else {
                    $response['codiError'] = 3;
                    $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Personas.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                }
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se pudo actualizar el estado de la persona en la encuesta.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
            }
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se pudo guardar los datos de la persona.';
            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
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

        $response['codiError'] = $page = 0;
        $response['mensaje'] = '';
        $postt = $this->input->post(NULL, TRUE);
        $duracion = $postt['duracion'];
        unset($postt['duracion']);
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $this->construirPreguntas();

        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('personas/modpersonas', 'mpers');

        $arrParam = array(
            'codiEncuesta' => $this->session->userdata('codiEncuesta'),
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'numePers' => $this->session->userdata('numeroPersona')
        );
        $arrACP = $this->mpers->consultarControlPersonasResidentes($arrParam);
        //pr($arrACP); exit;
        if(count($arrACP) > 0) {
            $arrACP = array_shift($arrACP);
            if(!empty($arrACP['PAG_PERS'])) {
                $page = $arrACP['PAG_PERS'];
            }
        }

        if($page > 0) {
            $edad = intval($this->session->userdata('edadPersona'));
            $sexo = $this->session->userdata('sexoPersona');
            $codigoMostrar = $this->config->item('tipoFormulario') . $page;

            switch ($codigoMostrar) {
                  //Se Agrega este código para saltar la página 7 de la cual se elimina la pregunta
                case 'H8':
                    $codigoMostrar = $codigoMostrar - 1;
                case 'H25':
                    $page = $page - 1;
                //Hasta aquí va el código
                case 'E3':
                case 'A3':
                case 'B3':
                case 'G3':
                case 'H3':
                    $numeroPersona = $this->session->userdata('numeroPersona');
                    if($numeroPersona == 1) {
                        $page = intval($page) - 2;
                    } else {
                        $page--;
                    }
                    break;
            	case 'E6':
                case 'A6':
                case 'B6':
                case 'G6':
                case 'H6':
            		if($edad < 5) {
                        $page = $page - 2;
                    } else {
                    	$page--;
                    }
                    break;
            	case 'E7':
                case 'B7':
                    if($edad < 1) {
                        $page = $page - 3;
                    } else {
                    	$page--;
                    }
                    break;
                case 'E22':
                case 'A18':
                case 'G18':
                case 'H20':
                    if($edad >= 5) {
                        $page = $page - 2;
                    } else {
                        $page--;
                    }
                    // Se verifica si tiene dificultad
                    $arrParam = array(
                        'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                        'codiVivienda' => $this->session->userdata('codiVivienda'),
                        'codiHogar' => $this->session->userdata('codiHogar'),
                        'idPers' => $this->session->userdata('codiPersona')
                    );
                    $arrPersona = $this->mpers->consultarPersonas($arrParam);
                    //pr($arrPersona); exit;
                    if(count($arrPersona) > 0) {
                        $arrPersona = array_shift($arrPersona);
                       $response['condicion'] = $arrPersona['CONDICION_FISICA'];

                        if(empty($arrPersona['P_LIM_PPAL'])) {
                            $page = $page - 2;
                        }

                         if($arrPersona['CONDICION_FISICA'] == 2){
                            $page = 9;
                        }

                    }
                    break;
                case 'H21':
                    if($edad >= 5) {
                        $page = $page - 2;
                    } else {
                        $page--;
                    }
                    // Se verifica si tiene dificultad
                    $arrParam = array(
                        'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                        'codiVivienda' => $this->session->userdata('codiVivienda'),
                        'codiHogar' => $this->session->userdata('codiHogar'),
                        'idPers' => $this->session->userdata('codiPersona')
                    );
                    $arrPersona = $this->mpers->consultarPersonas($arrParam);
                    //pr($arrPersona); exit;
                    if(count($arrPersona) > 0) {
                        $arrPersona = array_shift($arrPersona);
                       $response['condicion'] = $arrPersona['CONDICION_FISICA'];

                        if(empty($arrPersona['P_LIM_PPAL'])) {
                            $page = $page - 2;
                        }

                         if($arrPersona['CONDICION_FISICA'] == 2){
                            $page = 9;
                        }

                    }

                    //pr($page); exit;
                    break;
                case 'E26':
                    $arrParam = array(
                        'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                        'codiVivienda' => $this->session->userdata('codiVivienda'),
                        'codiHogar' => $this->session->userdata('codiHogar'),
                        'idPers' => $this->session->userdata('codiPersona')
                    );
                    $arrPersona = $this->mpers->consultarPersonas($arrParam);
                    //pr($arrPersona); exit;
                    if(count($arrPersona) > 0) {
                        $arrPersona = array_shift($arrPersona);
                        if($arrPersona['P_TRABAJO'] == 1 || $arrPersona['P_TRABAJO'] == 2) {
                            $page = $page - 2;
                        } else {
                            $page--;
                        }
                    }
                    break;
                case 'E30':
                case 'A24':
                    if($sexo != 2) {
                        $page = $page - 3;
                    } else {
                        $page--;
                    }
                    break;
                default:
                    $page--;
                    break;
            }
            $this->mpers->setCodiEncuesta($codiEncuesta);
            $this->mpers->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mpers->setCodiHogar($this->session->userdata('codiHogar'));
            $this->mpers->setCodiPersona($this->session->userdata('codiPersona'));
            $this->mpers->setNumeroPersona($this->session->userdata('numeroPersona'));

            if($this->mpers->actualizarEstadoACP($page)) {
                if($this->mencu->registrarTiempo('hogar', $duracion)) {
                    $response['mensaje'] = 'Se guardaron correctamente los datos de la persona.';
                    $response['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']) . '%';
                    $this->session->set_userdata('numeroPagina', $page);
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Persona.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo actualizar el estado de la persona.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
            }
        }

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
        $this->construirPreguntas();

        $this->load->model('personas/modpersonas', 'mpers');
        $this->mpers->setCodiEncuesta($this->session->userdata('codiEncuesta'));
        $this->mpers->setCodiVivienda($this->session->userdata('codiVivienda'));
        $this->mpers->setCodiHogar($this->session->userdata('codiHogar'));
        $this->mpers->setCodiPersona($this->session->userdata('codiPersona'));
        $this->mpers->setNumeroPersona($this->session->userdata('numeroPersona'));
        $this->mpers->setTotalPaginas($this->data['totalPaginas']);
        if($this->mpers->actualizarEstadoACP('f')) {
            $response['mensaje'] = 'Se finalizó correctamente las preguntas de la persona.';
            $response['avance'] = '100%';
            $this->session->set_userdata('numeroPagina', $this->data['totalPaginas'] + 1);
            $this->session->set_userdata('fechaFinPers','');
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se pudo actualizar el estado de la persona.';
            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Consulta los datos de las personas
     * @author oagarzond
     * @since 2017-03-31
     */
    public function consultarPersona() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $this->load->model('personas/modpersonas', 'mpers');
        $this->load->model('modform', 'mform');

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $arrCampos = array(
            'tipo_documento' => 'PA_TIPO_DOC',
            'numero_documento' => 'PA1_NRO_DOC',
            'primer_nombre' => 'RA2_1NOMBRE',
            'segundo_nombre' => 'RA3_2NOMBRE',
            'primer_apellido' => 'RA4_1APELLIDO',
            'segundo_apellido' => 'RA5_2APELLIDO',
            'sexo_persona' => 'P_SEXO',
            'edad_persona' => 'P_EDAD',
            'jefe_hogar' => 'P_JEFE_HOGAR',
            'idEditar' => 'ID_PERSONA_RESIDENTE'
        );
        $postt = $this->input->post(NULL, TRUE);
        //pr($postt); exit;
        if (empty($postt) || count($postt) == 0) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente los datos.';
        } else {
            $arrParam = array(
                'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda'),
                'codiHogar' => $this->session->userdata('codiHogar'),
                'idPers' => $postt['idPers']
            );
            $arrPersona = $this->mpers->consultarPersonas($arrParam);
            if(count($arrPersona) > 0) {
                $arrPersona = array_shift($arrPersona);
                $response['registro'] = $arrPersona['REGISTRO'];
                foreach ($arrPersona as $kp => $vp) {
                    if (in_array($kp, $arrCampos)){
                        $tmp = array_search($kp, $arrCampos);
                        $response['form'][$tmp] = $vp;
                    }
                }
                if(!empty($arrPersona['FECHAEXPE'])) {
                    $tmpExpe = explode('/', $arrPersona['FECHAEXPE']);
                    $response['form']['dia_expe'] = $tmpExpe[0];
                    $response['form']['mes_expe'] = $tmpExpe[1];
                    $response['form']['anio_expe'] = $tmpExpe[2];
                }
                $response['form']['jefe_hogar'] = ($arrPersona['P_NRO_PER'] == 1) ? '1': '2';
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se encontró la información de la persona.';
            }
        }
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Guarda los datos de las personas del hogar
     * @author oagarzond
     * @since 2017-03-29
     */
    public function guardarPersona() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['codiError'] = 0;
        $response['mensaje'] = '';
        // Se nombran con los campos reales en la tabla de personas_hogar
        $arrCampos = array(
            'tipo_documento' => 'PA_TIPO_DOC',
            'numero_documento' => 'PA1_NRO_DOC',
            'primer_nombre' => 'PA_1ER_NOMBRE',
            'segundo_nombre' => 'PC_2DO_NOMBRE',
            'primer_apellido' => 'PB_1ER_APELLIDO',
            'segundo_apellido' => 'PD_2DO_APELLIDO',
            'sexo_persona' => 'P_SEXO',
            'edad_persona' => 'P_EDAD',
            'jefe_hogar' => 'P_JEFE_HOGAR'
        );
        $postt = $this->input->post(NULL, TRUE);

        if (empty($postt) || count($postt) == 0) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente los datos.';
        } else {
            $this->load->model('personas/modpersonas', 'mpers');

            $codiEncuesta = $this->session->userdata('codiEncuesta');
            $this->mpers->setCodiEncuesta($codiEncuesta);
            $this->mpers->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mpers->setCodiHogar($this->session->userdata('codiHogar'));
            $accion = $postt['accion'];
            $idPersona = $postt['id'];

            $persona = $this->mpers->consultarPersonas(array('codiEncuesta' => $codiEncuesta, 'idPers' => $idPersona));
            $persona = array_shift($persona);

            if($persona['REGISTRO'] != '' && $accion == 'editar'){

                $postt['idEditar'] = $idPersona;
                $this->data['form'] = array(
                    'PA_TIPO_DOC' => $persona['PA_TIPO_DOC'],
                    'PA1_NRO_DOC' => $persona['PA1_NRO_DOC'],
                    'PA_1ER_NOMBRE' => $persona['RA2_1NOMBRE'],
                    'PC_2DO_NOMBRE' => $persona['RA3_2NOMBRE'],
                    'PB_1ER_APELLIDO' => $persona['RA4_1APELLIDO'],
                    'PD_2DO_APELLIDO' => $persona['RA5_2APELLIDO'],
                    'P_SEXO' => $persona['P_SEXO'],
                    'P_EDAD' => $persona['P_EDAD'],
                    'P_JEFE_HOGAR' => $postt['jefe_hogar'],
                );

            }else{

                foreach ($postt as $key => $value) {
                    if(array_key_exists($key, $arrCampos)) {
                        if((!empty($value) || $value == '0') && $value != '-') {
                            $this->data['form'][$arrCampos[$key]] = $value;
                        }

                        if(empty($value) && ($key == 'segundo_nombre' || $key == 'segundo_apellido')) {
                            $this->data['form'][$arrCampos[$key]] = '';
                        }
                    }
                    if($key == 'anio_expe' && !empty($postt['anio_expe'])) {
                        $this->data['form']['FECHA_EXPE_CC'] = $postt['dia_expe'] . '/' . $postt['mes_expe'] . '/' . $postt['anio_expe'];
                    }
                }
            }

            if(empty($this->data['form']['PA1_NRO_DOC'])) {
                $response['codiError'] = 3;
                $response['mensaje'] = 'No se definió el número de documento.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $response['mensaje']);
            }
            if(!empty($this->data['form']['P_JEFE_HOGAR']) && $this->data['form']['P_JEFE_HOGAR'] == 1) {
                if(!empty($this->data['form']['P_EDAD']) && $this->data['form']['P_EDAD'] < 10) {
                    $response['codiError'] = 4;
                    $response['mensaje'] = 'No puede ser jefe(a) del hogar si es menor de 10 años.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $response['mensaje']);
                }else{
                    $this->data['form']['P_PARENTESCO'] = 1;
                }
            }

            $param = array(
                'codiEncuesta' => $codiEncuesta,
                'tipoDocu' => $this->data['form']['PA_TIPO_DOC'],
                'numeDocu' => $this->data['form']['PA1_NRO_DOC']
            );
            $arrPersonaCodi = $this->mpers->consultarPersonas($param);
            $countPerHogar = count($arrPersonaCodi);

            // $arrPersona = $this->mpers->consultarPersonas(array('tipoDocu' => $this->data['form']['PA_TIPO_DOC'], 'numeDocu' => $this->data['form']['PA1_NRO_DOC']));

            if ($accion=='editar' && ($persona['PA1_NRO_DOC'] != $this->data['form']['PA1_NRO_DOC'] || $persona['PA_TIPO_DOC']
            != $this->data['form']['PA_TIPO_DOC'])) {
                /*Valida que el usuario no este registrado en la bd */
                // if(count($arrPersona) > 0) {
                //     $response['codiError'] = 4;
                //     $response['mensaje'] = 'Ya existe un usuario registrado con este tipo y número de documento.';
                //     log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $response['mensaje']);
                // }

                /*Valida que el usuario no este registrado en el hogar */
                if($countPerHogar > 0) {
                    $response['codiError'] = 4;
                    $response['mensaje'] = 'Ya existe un usuario registrado con este tipo y número de documento.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $response['mensaje']);
                }
            }

            if ($accion=='agregar') {
                /*Valida que el usuario no este registrado en la bd */
                // if(count($arrPersona) > 0) {
                //     $response['codiError'] = 4;
                //     $response['mensaje'] = 'Ya existe un usuario registrado con este tipo y número de documento.';
                //     log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $response['mensaje']);
                // }

                /*Valida que el usuario no este registrado en el hogar */
                if($countPerHogar > 0) {
                    $response['codiError'] = 4;
                    $response['mensaje'] = 'Ya existe un usuario registrado con este tipo y número de documento.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $response['mensaje']);
                }
            }

            if(!empty($this->data['form'])) {

                $this->session->unset_userdata('fechaFinPers');

                if($response['codiError'] == 0 && !empty($accion) && $accion == 'agregar') {
                    if($this->mpers->agregarPersona($this->data['form'])) {

                        $this->load->model("encuesta/modencuesta", "mencu");

                        $this->mencu->setCodiEncuesta($codiEncuesta);
                        $this->mencu->setCodiVivienda($this->session->userdata('codiVivienda'));
                        $this->mencu->setCodiHogar($this->session->userdata('codiHogar'));
                        if($this->mencu->actualizarAdminControl(array('FECHA_FIN_PERSONAS' => 'null'))) {
                            if(!empty($this->data['form']['P_JEFE_HOGAR']) && $this->data['form']['P_JEFE_HOGAR'] == 1) {
                                $idPersona = $this->mpers->getCodiPersona();
                                if($this->mpers->cambiarOrdenPersonas($idPersona)) {
                                    $response['mensaje'] = 'Se agregó correctamente la persona del hogar.';
                                } else {
                                    $response['codiError'] = 7;
                                    $response['mensaje'] = 'No se pudo cambiar el jefe del hogar.';
                                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                                }
                            } else {
                                //$response['mensaje'] = 'Se agregó correctamente la persona del hogar.';
                            }
                        } else {
                            $response['codiError'] = 6;
                            $response['mensaje'] = 'No se pudo borrar la fecha fin en Personas.';
                            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
                        }
                    } else {
                        $response['codiError'] = 5;
                        $response['mensaje'] = 'No se pudo agregar la persona del hogar.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                    }
                } else if($response['codiError'] == 0 && !empty($accion) && $accion == 'editar') {
                    if(!empty($postt['idEditar'])) {
                        //$this->mpers->setCodiPersona($postt['idEditar']);
                        $this->mpers->setCodiPersona($postt['idEditar']);
                        if($this->mpers->editarPersona($this->data['form'])) {
                            $this->load->model('encuesta/modencuesta', 'mencu');

                            $this->mencu->setCodiEncuesta($codiEncuesta);
                            $this->mencu->setCodiVivienda($this->session->userdata('codiVivienda'));
                            $this->mencu->setCodiHogar($this->session->userdata('codiHogar'));
                            if($this->mencu->actualizarAdminControl(array('FECHA_FIN_PERSONAS' => 'null'))) {
                                if(!empty($this->data['form']['P_JEFE_HOGAR']) && $this->data['form']['P_JEFE_HOGAR'] == 1) {
                                    if($this->mpers->cambiarOrdenPersonas($postt['idEditar'])) {
                                        //$response['mensaje'] = 'Se editó correctamente la persona del hogar.';
                                    } else {
                                        $response['codiError'] = 8;
                                        $response['mensaje'] = 'No se pudo cambiar el jefe del hogar.';
                                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                                    }
                                } else {
                                    $response['mensaje'] = 'Se editó correctamente la persona del hogar.';
                                }
                            } else {
                                $response['codiError'] = 7;
                                $response['mensaje'] = 'No se pudo borrar la fecha fin en Personas.';
                                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
                            }
                        } else {
                            $response['codiError'] = 6;
                            $response['mensaje'] = 'No se pudo editar la persona del hogar.';
                            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                        }
                    } else {
                        $response['codiError'] = 5;
                        $response['mensaje'] = 'No se definió el identificador de la persona del hogar.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $response['mensaje']);
                    }
                }
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se definió correctamente los datos para agregar la persona.';
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Elimina los datos de las personas del hogar
     * @author oagarzond
     * @since 2017-03-29
     */
    public function eliminarPersona() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $idPers = $this->input->post('idPers');
        if (empty($idPers)) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el identificador de la persona.';
        }

        $this->load->model('usuarios/modusuarios', 'musua');
        $arrUsua = $this->musua->consultarAdminUsuarios(array('idPers' => $idPers));
        if(count($arrUsua) > 0) {
            $response['codiError'] = 2;
            $response['mensaje'] = 'No se puede borrar la persona que se registró.';
        }

        if($response['codiError'] == 0) {
            $this->load->model('personas/modpersonas', 'mpers');

            $this->mpers->setCodiEncuesta($this->session->userdata('codiEncuesta'));
            $this->mpers->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mpers->setCodiHogar($this->session->userdata('codiHogar'));
            $this->data['form']['ID_PERSONA_RESIDENTE'] = $idPers;
            //@todo: falta agregar de fecha
            if($this->mpers->eliminarPersona($this->data['form'])) {
                $response['mensaje'] = 'Se borró correctamente la persona del hogar.';
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se pudo borrar la persona del hogar.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Consulta los datos de la persona fallecida
     * @author oagarzond
     * @since 2017-11-07
     */
    public function consultarFallecida() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $this->load->model('personas/modpersonas', 'mpers');
        $this->load->model('modform', 'mform');

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $arrCampos = array(
            'sexo_fallecida' => 'FA2_SEXO_FALL',
            'edad_fallecida' => 'FA3_EDAD_FALL',
            'certificado_fallecida' => 'FA4_CERT_DEFUN'
        );
        $postt = $this->input->post(NULL, TRUE);
        //pr($postt); exit;
        if (empty($postt) || count($postt) == 0) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente los datos.';
        } else {
            $arrParam = array(
                'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda'),
                'codiHogar' => $this->session->userdata('codiHogar'),
                'idPers' => $postt['idPers']
            );
            $arrPersona = $this->mpers->consultarPersonasFallecidas($arrParam);
            if(count($arrPersona) > 0) {
                $arrPersona = array_shift($arrPersona);
                foreach ($arrPersona as $kp => $vp) {
                    if (in_array($kp, $arrCampos)){
                        $tmp = array_search($kp, $arrCampos);
                        $response['form'][$tmp] = $vp;
                    }
                }
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se encontró la información de la persona.';
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Guarda los datos de las personas fallecidas del hogar
     * @author oagarzond
     * @since 2017-03-29
     */
    public function guardarFallecida() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $arrCampos = array(
            'sexo_fallecida' => 'FA2_SEXO_FALL',
            'edad_fallecida' => 'FA3_EDAD_FALL',
            'certificado_fallecida' => 'FA4_CERT_DEFUN'
        );
        $postt = $this->input->post(NULL, TRUE);
        if (empty($postt) || count($postt) == 0) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente los datos.';
        } else {
            $this->load->model('personas/modpersonas', 'mpers');

            $codiEncuesta = $this->session->userdata('codiEncuesta');
            $this->mpers->setCodiEncuesta($codiEncuesta);
            $this->mpers->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mpers->setCodiHogar($this->session->userdata('codiHogar'));
            $accion = $postt['accion'];
            foreach ($postt as $key => $value) {
                if(array_key_exists($key, $arrCampos)) {
                    //if(!empty($value) && $value != '-') {
                    if((!empty($value) || $value == '0') && $value != '-') {
                        $this->data['form'][$arrCampos[$key]] = $value;
                    }
                }
            }
            //pr($accion);
            //pr($this->data['form']); exit;
            if(!empty( $this->data['form'])) {
                if($response['codiError'] == 0 && !empty($accion) && $accion == 'agregar') {
                    if($this->mpers->agregarPersonaFallecida($this->data['form'])) {
                        $response['mensaje'] = 'Se guardó correctamente la persona fallecida del hogar.';
                    } else {
                        $response['codiError'] = 3;
                        $response['mensaje'] = 'No se pudo agregar la persona fallecida del hogar.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                    }
                } else if($response['codiError'] == 0 && !empty($accion) && $accion == 'editar') {
                    $this->mpers->setCodiPersona($postt['idEditar']);
                    if($this->mpers->editarPersonaFallecida($this->data['form'])) {
                        $response['mensaje'] = 'Se editó correctamente la persona del hogar.';
                    } else {
                        $response['codiError'] = 6;
                        $response['mensaje'] = 'No se pudo editar la persona del hogar.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
                    }
                }
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se definió correctamente los datos para agregar la persona fallecida.';
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Elimina los datos de las personas fallecidas del hogar
     * @author oagarzond
     * @since 2017-03-29
     */
    public function eliminarFallecida() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $idPers = $this->input->post('idPers');
        if (empty($idPers)) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el identificador de la persona.';
        } else {
            $this->load->model('personas/modpersonas', 'mpers');

            $this->mpers->setCodiEncuesta($this->session->userdata('codiEncuesta'));
            $this->mpers->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mpers->setCodiHogar($this->session->userdata('codiHogar'));
            $this->data['form']['ID_PERSONA_FALLECIDA'] = $idPers;
            if($this->mpers->eliminarPersonaFallecida($this->data['form'])) {
                $response['mensaje'] = 'Se borró correctamente la persona fallecida del hogar.';
                $response['total'] = count($this->mpers->consultarPersonasFallecidas(array('codiEncuesta' => $this->session->userdata('codiEncuesta'))));
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se pudo borrar la persona fallecida del hogar.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mpers->getMsgError());
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Se consulta y/o se construye el archivo de preguntas con sus opciones
     * y el total de paginas
     * @author oagarzond
     * @since 2017-08-14
     */
    private function construirPreguntas($tabla = 'ECP_PERSONAS_HOGAR', $pagina = '') {
        $this->load->model('modform', 'mform');

        $this->data['preguntas'] = $this->mform->extraerPreguntas($tabla);
        //$this->data['preguntas'] = $this->consultarPreguntas('ECP_UBICACION');
        $this->data['totalPaginas'] = count($this->data['preguntas']);
        $this->data['preguntas'][++$this->data['totalPaginas']]['persona_exitoso'] = 'SI';
    }

    public function definirPagina($numero = 0) {
        if($numero <= 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $this->session->set_userdata('paginaPersona', $numero);
        redirect(base_url($this->data['module']));
    }
}
//EOC