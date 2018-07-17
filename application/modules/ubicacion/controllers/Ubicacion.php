<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de Ubicacion
 * @author oagarzond
 * @since 2017-05-02
 */
class Ubicacion extends MX_Controller {
    var $data;

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
        /*$this->arrDireccion = array('tipo_via', 'numero_via', 'letra_via', 'letra_sufijo', 'cuadrante', 'tipo_via2', 'numero_via2', 'letra_via2', 'letra_sufijo2', 'numero_placa', 'cuadrante2');*/

        if(empty($this->session->userdata('auth'))){
            redirect(base_url(), 'location', 301, 'refresh');
        }
    }

    /**
     * Controla el flujo de las paginas del modulo
     * @author oagarzond
     * @since 2017-05-02
     */
    public function index() {
        //pr($this->session->all_userdata()); exit;

        $this->data['title'] = 'Ubicación';
        $this->data['arrCss'][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data['arrJS'][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data['arrJS'][] = base_url_js('fillInFormTimer.js');
        $this->data['mostrarAnterior'] = 'NO';

        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('vivienda/modvivienda', 'mvivi');
        $this->load->model('hogar/modhogar', 'mhogar');

        $this->load->model('modform', 'mform');
        $page = $pageAC = '1';
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $arrAC['ID_ESTADO_AC'] = $this->session->userdata('estado');
        $arrAC['PAG_UBICACION'] = $this->session->userdata('paginaUbicacion');
        $arrAC['FECHA_FIN_UBICACION'] = $this->session->userdata('fechaFinUbi');
        $this->construirPreguntas();

        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //$arrAC = array_shift($arrAC);
        //pr($arrAC); exit;
        // Se debe revisar cuando ya este toda la encuesta completa
        if(!empty($arrAC['PAG_UBICACION'])) {
            $pageAC = $arrAC['PAG_UBICACION'];
        }

        if($arrAC['ID_ESTADO_AC'] == 12) {
            $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
            redirect(base_url('encuesta'));
        } else if($arrAC['ID_ESTADO_AC'] == 11) {
            if(!empty($arrAC['FECHA_FIN_UBICACION'])) {
                $this->data['mostrarAnterior'] = 'SI';
                if($arrAC['PAG_UBICACION'] == ($this->data['totalPaginas'] + 1)) {
                    $pageAC = 1;
                    $this->session->set_userdata('paginaUbicacion', $pageAC);
                }
                // Al completar la encuesta no debe cambiar el departamento y municipio
                if($arrAC['PAG_UBICACION'] == 1 || ($arrAC['PAG_UBICACION'] >= ($this->data['totalPaginas'] + 1))) {
                    //$pageAC = 2;
                    $pageAC = 1;
                    $this->session->set_userdata('paginaUbicacion', $pageAC);
                }
            }
        } else if($arrAC['ID_ESTADO_AC'] < 11) {
            if(!empty($arrAC['FECHA_FIN_UBICACION'])) {
                $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
                redirect(base_url('inicio'), '', 'refresh');
            }
        }

        $this->mostrar($pageAC);
    }

    /**
     * Muestra el contenido de las paginas del modulo
     * @author oagarzond
     * @param $page         Pagina que se va a mostrar
     * @since 2017-03-20
     */
    private function mostrar($page = 0) {
        // pr($page); exit;
        $this->data['breadcrumb'] = '<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
            <li class="breadcrumb-item active">Ubicación</li>
        </ol>';
        //$page = 4;
        $this->data['var'] = $this->data['URLVideo'] = '';
        $this->data['view'] = 'ubicacion';
        $this->data['avance'] = '0%';
        $arrCamposNE = array(
            'UVA11_NTER_IND' => 'UVA11_TER_IND',
            'UVA12_NPARC_IND' => 'UVA12_PARC_IND',
            'UVA13_NRES_IND' => 'UVA13_RES_IND',
            'UVA14_NANC_TCCN' => 'UVA14_ANC_TCCN',
            'UVA15_NANC_RAIZAL' => 'UVA15_ANC_RAIZAL'
        );
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $estadoActual = $this->session->userdata('estado');
        //pr($estadoActual); exit;
        $page = (empty($page)) ? $this->session->userdata('paginaUbicacion'): $page;

        if($page > 1) {
            $this->data['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']) . '%';
        }

        //$arrPreguntas = $this->mform->consultarPreguntas('ECP_UBICACION', $page);
        // Se consulta de nuevo la tabla vivienda debido a que casi todas las preguntas dependen
        // de la respuesta anterior
        //if($estadoActual >= 11) {
            $arrParam = array(
                'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda')
            );
            $arrVivi = $this->mvivi->consultarVivienda($arrParam);
            $arrHogar = $this->mhogar->consultarHogar($arrParam);

            // pr($arrVivi); die();
            if(count($arrVivi) > 0) {
                $arrVivi = array_shift($arrVivi);
                $arrHogar = array_shift($arrHogar);

                if(!empty($arrVivi['UVA1_TIPO_BAVERCO'])) {
                    $arrVivi['UVA_TIPO_CENTRO'] = $arrVivi['UVA_TIPO_RURAL'] = $arrVivi['UVA1_TIPO_BAVERCO'];
                }
                if(!empty($arrVivi['UVA2_CODTER'])) {
                    $arrVivi['UVA2_CODRESGU'] = $arrVivi['UVA2_CODTERRITO'] = $arrVivi['UVA2_CODTER'];
                }
                if(!empty($arrVivi['UVA_VIVTERETNICO'])) {
                    foreach ($arrCamposNE as $kne => $vne) {
                        $arrVivi[$vne] = 0;
                        if(!empty($arrVivi[$kne])) {
                            $arrVivi[$vne] = 1;
                        }
                    }
                }
                if(!empty($arrVivi['UVA2_COMPLE_CLASE1'])) {
                    $arrVivi['UVA1_DIRUND_CLASE2'] = $arrVivi['UVA2_COMPLE_CLASE1'];
                }
                if(!empty($arrVivi['UVA_DIRUND'])) {
                    $arrVivi['UVA1_DIRUND_CLASE3'] = $arrVivi['UVA_DIRUND'];
                }
                //$this->data['var'] = cambiar_campos_BD_HTML($arrPreguntas, $this->arrCampos[$page], $arrVivi);
                if(count($this->data['preguntas'][$page]) > 0 && empty($this->data['preguntas'][$page]['ubicacion_exitoso'])) {
                    $this->data['var'] = asignar_valor_pregunta($this->data['preguntas'][$page], $arrVivi);
                } else {
                    /*$this->data['msgError'] = 'No se encontraron las preguntas de la página ' . $page . ' en el módulo ' . $this->data['title'] . '.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->data['msgError']);
                    $this->session->set_flashdata('msgError', $this->data['msgError']);
                    redirect(base_url('inicio'));
                    return false;*/
                }
            }
        /*} else {
            if(count($this->data['preguntas'][$page]) > 0 && empty($this->data['preguntas'][$page]['ubicacion_exitoso'])) {
                $this->data['var'] = $this->data['preguntas'][$page];
            }
        }*/
        //pr($arrVivi); exit;
        // pr($this->data['var']); exit;
        if(!empty($this->data['var'])) {
            foreach ($this->data['var'] as $kv => $vv) {
                if(!empty($vv['ID_PREGUNTA_DEPEN'])) {
                    $this->data['var'][$kv]['HIDDEN'] = 'SI';
                    if(!empty($arrVivi[$vv['ID_PREGUNTA_DEPEN']]) && $arrVivi[$vv['ID_PREGUNTA_DEPEN']] == $vv['VALOR_DEPEN']) {
                        $this->data['var'][$kv]['HIDDEN'] = 'NO';
                    }
                }
                $this->data['var'][$kv]['VIDEO'] = '';
                if(!empty($vv['URL_VIDEO'])) {
                    $this->data['mostrarVideo'] = 'SI';
                    $this->data['var'][$kv]['VIDEO'] = $vv['URL_VIDEO'];
                    $this->data['URLVideo'] = $vv['URL_VIDEO'];
                }
                // pr($this->data['var']);
            }
            // die();
        }

        $codigoMostrar = $this->config->item('tipoFormulario') . $page;
        if(!empty($this->data['preguntas'][$page]['ubicacion_exitoso'])) {
            $codigoMostrar = 'completo';
        }

        switch ($codigoMostrar) {
            case 'E1':
            case 'A1':
            case 'B1':
            case 'G1':
            case 'H1':
                $this->data['arrCss'][] = base_url_plugins('select2/css/select2.min.css');
                $this->data['arrCss'][] = base_url_plugins('select2/css/select2-bootstrap.min.css');
                $this->data['arrJS'][] = base_url_plugins('select2/js/select2.min.js');
                $this->data['arrJS'][] = base_url_plugins('select2/js/i18n/es.js');
                $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE1.js');
                $this->data['mostrarAnterior'] = 'NO';
                // Para que se cree la llave dominio_D26 por primera vez
                // $arrTipoDocuPers = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'departamento') {
                        // $arrDepartamentos = $this->mform->consultarRespuestaDominio(array('idDominio' => $vv['FK_ID_DOMINIO']));
                        $arrDepartamentos = $this->config->item('departamentos');
                        // pr($arrDepartamentos); die();
                        foreach ($arrDepartamentos as $kd => $vd) {
                            $this->data['var'][$kv]['OPCIONES'][$kd] = array(
                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $vd['ID_VALOR'],
                                'DESCRIPCION_OPCION' => $vd['ETIQUETA'],
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $vd['ID_VALOR']
                            );
                        }
                    } else if($vv['REFERENCIA_HTML'] == 'municipio') {
                        //$arrVivi['U_DPTO'] = '';
                        if(!empty($arrVivi['U_DPTO'])) {
                            $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 1, 'valor' => $arrVivi['U_DPTO']));
                            // pr($this->config->item('municipios')[$padre[0]['ID']]); die();
                            if(count($padre) > 0) {
                                // $arrMunicipios = $this->mform->consultarRespuestaDominio(array('idDominio' => $vv['FK_ID_DOMINIO'], 'idPadre' => $padre[0]['ID']));
                                $arrMunicipios = $this->config->item('municipiosFiltro')[$padre[0]['ID']];
                            }
                        } else {
                            //$arrMunicipios = $this->mform->consultarRespuestaDominio(array('idDominio' => $vv['FK_ID_DOMINIO'], 'idPadre' => 11));
                            $arrMunicipios = array();
                        }
                        if(count($arrMunicipios) > 0) {
                            foreach ($arrMunicipios as $km => $vm) {
                                //$tmpEtiqueta = explode(' - ', $vm['ETIQUETA']);
                                //$descMuni = (!empty($tmpEtiqueta[1])) ? $tmpEtiqueta[1]: $vm['ETIQUETA'];
                                $tmpEtiqueta = $vm['ETIQUETA'];
                                $descMuni = $tmpEtiqueta;
                                $this->data['var'][$kv]['OPCIONES'][$km] = array(
                                    'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                    'ID_OPCION' => $vm['ID_VALOR'],
                                    'DESCRIPCION_OPCION' => $descMuni,
                                    'AYUDA' => '',
                                    'ORDEN_VISUAL' => $vm['ID_VALOR']
                                );
                            }
                        }
                    }
                }
                //pr($this->data['var']); exit;
                break;
            case 'E2':
            case 'A2':
            case 'B2':
            case 'G2':
            case 'H2':
                //pr($this->session->all_userdata()); exit;
                $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE2.js');
                //Se comenta esta linea para mostrar el botón regresar en la segunda vista.
                //$this->data['mostrarAnterior'] = 'NO';
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'clase') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($vv['OPCIONES'] as $ko => $vo) {
                                $this->data['var'][$kv]['OPCIONES'][$ko]['DESCRIPCION_OPCION'] = $this->mform->asignarValorEtiqueta($vo['DESCRIPCION_OPCION']);
                            }
                            //pr($this->data['var']); exit;
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'localidad') {
                                    if(!empty($arrVivi['U_MPIO'])) {
                                        $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
                                        if(count($padre) > 0) {
                                            $arrLocalidades = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO'], 'idPadre' => $padre[0]['ID']));
                                            if(count($arrLocalidades) > 0) {
                                                foreach ($arrLocalidades as $kl => $vl) {
                                                    $this->data['var'][$kp]['OPCIONES'][$kl] = array(
                                                        'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                                        'ID_OPCION' => $vl['ID_VALOR'],
                                                        'DESCRIPCION_OPCION' => $vl['ETIQUETA'],
                                                        'AYUDA' => '',
                                                        'ORDEN_VISUAL' => $vl['ID_VALOR']
                                                    );
                                                }
                                            }
                                        }
                                    }
                                    if(count($arrLocalidades) > 0) {
                                        $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    }
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'centro_poblado') {
                                    if(!empty($arrVivi['U_MPIO'])) {
                                        $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
                                        if(count($padre) > 0) {
                                            $arrPoblados = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO'], 'idPadre' => $padre[0]['ID']));
                                            if(count($arrPoblados) > 0) {
                                                foreach ($arrPoblados as $kpo => $vpo) {
                                                    $this->data['var'][$kp]['OPCIONES'][$kpo] = array(
                                                        'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                                        'ID_OPCION' => $vpo['ID_VALOR'],
                                                        'DESCRIPCION_OPCION' => $vpo['ETIQUETA'],
                                                        'AYUDA' => '',
                                                        'ORDEN_VISUAL' => $vpo['ID_VALOR']
                                                    );
                                                }
                                                $this->data['var'][$kp]['OPCIONES'][$kpo] = array(
                                                    'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                                    'ID_OPCION' => 888,
                                                    'DESCRIPCION_OPCION' => 'OTRO',
                                                    'AYUDA' => '',
                                                    'ORDEN_VISUAL' => 888
                                                );
                                            }
                                        }
                                    }
                                    if(count($arrPoblados) > 0) {
                                        $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    }
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'otro_centro_poblado') {
                                    // Queda en la segunda opcion de clase y se oculta si no tiene valor
                                    $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    if(empty($vp['VALOR'])) {
                                        //$this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][1]['HIDDEN'] = 'SI';
                                    }
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'tipo_centro') {
                                    $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                                if($vp['REFERENCIA_HTML'] == 'tipo_rural') {
                                    if($arrVivi['U_DPTO'] != 44) {
                                        unset($this->data['var'][$kp]['OPCIONES'][2]);
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                }
                            }
                        }
                    }
                }
                if(count($arrLocalidades) == 0) {
                    unset($this->data['var'][0]['OPCIONES'][0]['PREGUNTA']);
                }
                if(count($arrPoblados) == 0) {
                    unset($this->data['var'][0]['OPCIONES'][1]['PREGUNTA'][0]);
                }
                break;
            case 'E3':
            case 'A3':
            case 'B3':
            case 'G3':
            case 'H3':
                $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE3.js');
                //$arrVivi['UA_CLASE'] = 3;
                //$arrVivi['U_DPTO'] = 44;
                //$arrVivi['UVA1_TIPO_BAVERCO'] = 2;
                $arrTipoClase = array(
                    1 => 'Barrio',
                    2 => 'Corregimiento',
                    3 => 'Vereda',
                    4 => 'Ranchería',
                    5 => 'Comunidad'
                );
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'tipo_lugar') {
                        if(!empty($arrVivi['UA_CLASE'])) {
                            switch ($arrVivi['UA_CLASE']) {
                                case 1:
                                    unset($this->data['var'][$kv]);
                                    break;
                                case 2:
                                    unset($this->data['var'][$kv]['OPCIONES'][0], $this->data['var'][$kv]['OPCIONES'][3], $this->data['var'][$kv]['OPCIONES'][4]);
                                    break;
                                case 3:
                                    /*if($arrVivi['U_DPTO'] == 44) {
                                        unset($this->data['var'][$kv]);
                                    } else {
                                        unset($this->data['var'][$kv]['OPCIONES'][0]);
                                    }*/

                                    //Se modifican las opciones a mostrar al seleccionar el departamento de La Gaujira y ubicación rural.
                                    if($arrVivi['U_DPTO'] != 44) {
                                        unset($this->data['var'][$kv]['OPCIONES'][0]);
                                        unset($this->data['var'][$kv]['OPCIONES'][3]);
                                    } else {
                                        unset($this->data['var'][$kv]['OPCIONES'][0]);
                                    }
                                    break;
                            }
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'nombre_lugar') {
                        if(!empty($arrVivi['UA_CLASE'])) {
                            $nombreLugar = '';
                            switch ($arrVivi['UA_CLASE']) {
                                case 1:
                                    //$nombreLugar = 'Escriba el nombre de su ' . $arrTipoClase[1];
                                    $nombreLugar = '¿Cómo es el nombre del ' . $arrTipoClase[1] . ' donde vive?';
                                    break;
                                case 2:
                                    //$nombreLugar = 'Escriba el nombre de su Corrregimiento o Vereda';
                                    $nombreLugar = '¿Cómo es el nombre del Corrregimiento o Vereda donde vive?';
                                    /*if(!empty($arrVivi['UVA1_TIPO_BAVERCO'])) {
                                        switch ($arrVivi['UVA1_TIPO_BAVERCO']) {
                                            case 2:
                                                $nombreLugar = '¿Cómo es el nombre del ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
                                                break;
                                            case 3:
                                                $nombreLugar = '¿Cómo es el nombre de la ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
                                                break;
                                        }
                                    }*/
                                    break;
                                case 3:
                                    //$nombreLugar = 'Escriba el nombre de su Corrregimiento, Vereda o Comunidad';
                                    $nombreLugar = '¿Cómo es el nombre del Corrregimiento, Vereda o Comunidad donde vive?';
                                    if(!empty($arrVivi['UVA1_TIPO_BAVERCO'])) {
                                        switch ($arrVivi['UVA1_TIPO_BAVERCO']) {
                                            case 2:
                                                $nombreLugar = '¿Cómo es el nombre del ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
                                                break;
                                            case 3:
                                            case 5:
                                                $nombreLugar = '¿Cómo es el nombre de la ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
                                                break;
                                        }
                                    }
                                    if(!empty($arrVivi['UVA1_TIPO_BAVERCO'])) {
                                        $nombreLugar = 'Escriba el nombre de su ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']];
                                    }
                                    if($arrVivi['U_DPTO'] == 44) {
                                        $nombreLugar = 'Escriba el nombre de su ranchería';
                                    }
                                    break;
                            }

                            if(!empty($nombreLugar)) {
                                $this->data['var'][$kv]['DESCRIPCION'] = str_replace('#NOMBRE_LUGAR#', $nombreLugar, $this->data['var'][$kv]['DESCRIPCION']);
                            }
                        }
                    }
                }
                //pr($this->data['var']); exit;
                break;
            case 'E4':
            case 'A4':
            case 'B4':
            case 'G4':
            case 'H4':
                $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE4.js');
                //$arrVivi['U_MPIO'] = '413';

                foreach ($this->data['var'] as $kv => $vv) {
                    // pr($vv);
                    if($vv['REFERENCIA_HTML'] == 'tipo_territo') {
                        $this->data['var'][$kv]['HIDDEN'] = 'SI';
                        if(!empty($arrVivi['UVA_ESTATER']) && $arrVivi['UVA_ESTATER'] == 1) {
                            $this->data['var'][$kv]['HIDDEN'] = 'NO';
                        }
                        foreach ($this->data['var'] as $kp => $vp) {
                            $arrResguardos = $arrTerritorios = array();
                            if($vp['REFERENCIA_HTML'] == 'resguardo') {
                                $arrParam = array('idDominio' => $vp['FK_ID_DOMINIO']);
                                if(!empty($arrVivi['U_MPIO'])) {
                                    $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
                                    if (count($padre)>0)
                                        $arrParam['idPadre'] = $padre[0]['ID'];
                                }

                                $arrResguardos = $this->mform->consultarRespuestaDominio($arrParam);
                                unset($arrParam);
                                if(count($arrResguardos) > 0) {
                                    foreach ($arrResguardos as $kr => $vr) {
                                        $this->data['var'][$kp]['OPCIONES'][$kr] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vr['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vr['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vr['ID_VALOR']
                                        );
                                    }

                                    $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                } else {
                                    unset($this->data['var'][$kv]['OPCIONES'][0]);
                                }
                                unset($this->data['var'][$kp]);
                            }
                            if($vp['REFERENCIA_HTML'] == 'territorio') {
                                $arrParam = array('idDominio' => $vp['FK_ID_DOMINIO']);
                                if(!empty($arrVivi['U_MPIO'])) {
                                    $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
                                    if (count($padre)>0)
                                        $arrParam['idPadre'] = $padre[0]['ID'];
                                }

                                $arrTerritorios = $this->mform->consultarRespuestaDominio($arrParam);
                                unset($arrParam);
                                if(count($arrTerritorios) > 0) {
                                    foreach ($arrTerritorios as $kt => $vt) {
                                        $this->data['var'][$kp]['OPCIONES'][$kt] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $vt['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $vt['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $vt['ID_VALOR']
                                        );
                                    }
                                    $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                } else {
                                    unset($this->data['var'][$kv]['OPCIONES'][1]);
                                }
                                unset($this->data['var'][$kp]);
                            }
                        }
                        //pr($arrResguardos);
                        //pr($arrTerritorios); exit;
                        if((isset($arrResguardos) && count($arrResguardos) == 0)  || (isset($arrTerritorios) && count($arrTerritorios) == 0)) {
                            $arrKeys = array_keys($this->data['var']);
                            //$this->data['var'][$arrKeys[0]]['OPCIONES'][0]['BLOQ'] = 'SI'; // Por alguna razon $arrResguardos y $arrTerritorios llegan vacios
                            //pr($this->data['var']); exit;
                        }
                    }
                }
                break;
            case 'E5':
            case 'A5':
            case 'B5':
            case 'G5':
            case 'H5':
                $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE5.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'es_area') {
                        foreach ($this->data['var'] as $kp => $vp) {
                            $arrAreas = array();
                            if($vp['REFERENCIA_HTML'] == 'area_protegida') {
                                $arrParam = array('idDominio' => $vp['FK_ID_DOMINIO']);
                                if(!empty($arrVivi['U_MPIO'])) {
                                    $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
                                    $arrParam['idPadre'] = $padre[0]['ID'];
                                }
                                $arrAreas = $this->mform->consultarRespuestaDominio($arrParam);
                                unset($arrParam);
                                if(count($arrAreas) > 0) {
                                    foreach ($arrAreas as $ka => $va) {
                                        $this->data['var'][$kp]['OPCIONES'][$ka] = array(
                                            'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                            'ID_OPCION' => $va['ID_VALOR'],
                                            'DESCRIPCION_OPCION' => $va['ETIQUETA'],
                                            'AYUDA' => '',
                                            'ORDEN_VISUAL' => $va['ID_VALOR']
                                        );
                                    }
                                }

                                $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                unset($this->data['var'][$kp]);

                                if(count($arrAreas) == 0) {
                                    $arrKeys = array_keys($this->data['var']);
                                    $this->data['var'][$arrKeys[0]]['OPCIONES'][0]['BLOQ'] = 'SI';
                                    //pr($this->data['var']); exit;
                                }
                            }
                        }
                    }
                }
                break;
            case 'E6':
            case 'A6':
            case 'B6':
            case 'G6':
            case 'H6':
                $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE6.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    foreach ($arrCamposNE as $kne => $vne) {
                        if($vv['ID_PREGUNTA'] == $vne) {
                            if(!empty($vv['OPCIONES'])) {
                                foreach ($this->data['var'] as $kp => $vp) {
                                    if($vp['ID_PREGUNTA'] == $kne) {
                                        //Se agrega esta segmento de código para eliminar territorio raizal en municipios distitos a Archipielago de San Andrés
                                        if($vp['ID_PREGUNTA'] == 'UVA15_NANC_RAIZAL'){
                                            if($arrVivi['U_DPTO'] != 88){
                                                unset($this->data['var'][$kv]);
                                                unset($this->data['var'][$kp]);
                                            }else{
                                                $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                                unset($this->data['var'][$kp]);
                                            }
                                        }else{
                                        //Hasta aquí va el código
                                            $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                            unset($this->data['var'][$kp]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                break;
            case 'E7':
            case 'A7':
            case 'B7':
            case 'G7':
            case 'H7':
                if(!empty($arrVivi['UA_CLASE']) && $arrVivi['UA_CLASE'] == 1) {
                    $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE7C1.js');
                } else if(!empty($arrVivi['UA_CLASE']) && $arrVivi['UA_CLASE'] == 2) {
                    $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE7C23.js');
                } else if(!empty($arrVivi['UA_CLASE']) && $arrVivi['UA_CLASE'] == 3) {
                    //Se llama js para recolectar información exclusivamente del campo complemento para la dirección.
                    //Se genera un nuevo js para no realizar modificaciones fuertes en los archivos y sus correspondientes validaciones.
                    $this->data['arrJS'][] = base_url_js('ubicacion/ubicacionE7C23_1.js');
                }

                $this->data['view'] = 'ubicacion' . $page;
                $this->data['tipo_via'] = '-';
                $this->data['numero_via'] = $this->data['numero_via2'] = $this->data['numero_placa'] = '';
                $this->data['complementos'] = '';
                $this->data['mensajeConfirmacion'] = 'Si la dirección es <span class="label-bold" id="direccion-confirm"></span> por favor haga clic en Guardar y continuar, de lo contrario haga clic en Anterior.';

                //Se agrega variable tipo ubicacion, para tomar deciciones en la vista dependientemente del tipo ya sea urbano o rural
                $this->data['tipo_ubicacion'] = $arrVivi['UA_CLASE'];

                /*$this->data['clase'] = 1;
                if(!empty($arrVivi['UA_CLASE'])) {
                    $this->data['clase'] = $arrVivi['UA_CLASE'];
                }*/
                //$arrTiposVia = $this->mform->consultarRespuestaDominio(array('idDominio' => 901, 'noValor' => array('CL','KR','DG','TV','AV','AU')));
                //$arrComplementos = $this->mform->consultarRespuestaDominio(array('idDominio' => 914, 'noValor' => array('CS','LT','MZ','UN','AP','BL','IN','CJ','ED','URB','SM','ET')));
                //$this->data['arrOtroComple'] = array_merge($arrTiposVia, $arrComplementos);
                $this->data['arrTiposVia'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 901));
                if(!empty($arrVivi['UVA_DIRUND_JSON'])) {
                    //$direJson = str_replace("'", '"', $arrVivi['UVA_DIRUND_JSON']);
                    $direJson = json_decode($arrVivi['UVA_DIRUND_JSON'], true);
                    foreach ($direJson as $key => $value) {
                        $this->data[$key] = $value;
                    }
                }

                $this->data['U_CO'] = '';
                $this->data['U_AO'] = '';
                $this->data['U_UC'] = '';
                $this->data['U_EDIFICA'] = '';
                $this->data['UVA_USO_UNIDAD'] = '';
                $this->data['UVA1_COD_OTROUSO'] = '';
                $this->data['UVA2_UNDNORESI'] = '';
                $this->data['UVA2_UNDNORESI'] = '';
                $this->data['UVA_ECENSO'] = '';
                $this->data['H_CAMBIO_DIR'] = '';
                $this->data['UVA1_MASHOG'] = '';
                $this->data['UVA_ECENSO6'] = '';
                $this->data['U_VIVIENDA'] = '';
                $this->data['H_CAMBIO_DIR'] = '';
                $this->data['H_CERT_CENSAL'] = '';
                $this->data['UVA_COMPLEUND_JSON'] = '';
                $this->data['UVA1_MASHOG6'] = '';

                if(!empty($arrVivi['U_CO'])) {
                    $this->data['U_CO'] = $arrVivi['U_CO'];
                }else{}
                if(!empty($arrVivi['U_AO'])) {
                    $this->data['U_AO'] = $arrVivi['U_AO'];
                }
                if(!empty($arrVivi['U_UC'])) {
                    $this->data['U_UC'] = $arrVivi['U_UC'];
                }
                if(!empty($arrVivi['U_EDIFICA'])) {
                    $this->data['U_EDIFICA'] = $arrVivi['U_EDIFICA'];
                }
                if(!empty($arrVivi['UVA_USO_UNIDAD'])) {
                    $this->data['UVA_USO_UNIDAD'] = $arrVivi['UVA_USO_UNIDAD'];
                }
                if(!empty($arrVivi['UVA1_COD_OTROUSO'])) {
                    $this->data['UVA1_COD_OTROUSO'] = $arrVivi['UVA1_COD_OTROUSO'];
                }
                if(!empty($arrVivi['UVA2_UNDNORESI'])) {
                    $this->data['UVA2_UNDNORESI'] = $arrVivi['UVA2_UNDNORESI'];
                }
                if(!empty($arrVivi['UVA1_COD_OTROUSO'])) {
                    $this->data['UVA1_COD_OTROUSO'] = $arrVivi['UVA1_COD_OTROUSO'];
                }
                if(!empty($arrVivi['UVA2_UNDNORESI'])) {
                    $this->data['UVA2_UNDNORESI'] = $arrVivi['UVA2_UNDNORESI'];
                }
                if(!empty($arrVivi['UVA_ECENSO'])) {
                    $this->data['UVA_ECENSO'] = $arrVivi['UVA_ECENSO'];
                }
                if(!empty($arrVivi['UVA1_MASHOG'])) {
                    $this->data['UVA1_MASHOG'] = $arrVivi['UVA1_MASHOG'];
                }
                if(!empty($arrVivi['UVA_ECENSO6'])) {
                    $this->data['UVA_ECENSO6'] = $arrVivi['UVA_ECENSO6'];
                }
                if(!empty($arrVivi['UVA1_MASHOG6'])) {
                    $this->data['UVA1_MASHOG6'] = $arrVivi['UVA1_MASHOG6'];
                }
                if(!empty($arrVivi['U_VIVIENDA'])) {
                    $this->data['U_VIVIENDA'] = $arrVivi['U_VIVIENDA'];
                }
                if(!empty($arrVivi['UVA_COMPLEUND_JSON'])) {
                    $this->data['UVA_COMPLEUND_JSON'] = $arrVivi['UVA_COMPLEUND_JSON'];
                }
                if(!empty($arrHogar['H_CAMBIO_DIR'])) {
                    $this->data['H_CAMBIO_DIR'] = $arrHogar['H_CAMBIO_DIR'];
                }
                if(!empty($arrHogar['H_CERT_CENSAL'])) {
                    $this->data['H_CERT_CENSAL'] = $arrHogar['H_CERT_CENSAL'];
                }

                break;
            case 7:
                $this->data['arrJS'][] = base_url_js('ubicacion/ubicacion' . $codigoMostrar . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'clase_direccion') {
                        foreach ($this->data['var'] as $kp => $vp) {
                            if($vp['REFERENCIA_HTML'] == 'tipo_via_direccion') {
                                $arrParam = array('idDominio' => $vp['FK_ID_DOMINIO']);
                                $arrTipoVia = $this->mform->consultarRespuestaDominio($arrParam);
                                unset($arrParam);
                                if(count($arrTipoVia) > 0) {
                                    foreach ($arrTipoVia as $ktv => $vtv) {
                                        if(!empty($vtv['ID_VALOR'])) {
                                            $this->data['var'][$kp]['OPCIONES'][$ktv] = array(
                                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                                'ID_OPCION' => $vtv['ID_VALOR'],
                                                'DESCRIPCION_OPCION' => $vtv['ETIQUETA'],
                                                'AYUDA' => '',
                                                'ORDEN_VISUAL' => $vtv['ID_VALOR']
                                            );
                                        }
                                    }
                                }
                                $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                unset($this->data['var'][$kp]);
                            }
                            if($vp['REFERENCIA_HTML'] == 'comple_direccion') {
                                $arrParam = array('idDominio' => $vp['FK_ID_DOMINIO']);
                                $arrComplementos = $this->mform->consultarRespuestaDominio($arrParam);
                                unset($arrParam);
                                if(count($arrComplementos) > 0) {
                                    foreach ($arrComplementos as $ktv => $vtv) {
                                        if(!empty($vtv['ID_VALOR'])) {
                                            $this->data['var'][$kp]['OPCIONES'][$ktv] = array(
                                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                                'ID_OPCION' => $vtv['ID_VALOR'],
                                                'DESCRIPCION_OPCION' => $vtv['ETIQUETA'],
                                                'AYUDA' => '',
                                                'ORDEN_VISUAL' => $vtv['ID_VALOR']
                                            );
                                        }
                                    }
                                }
                                $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
                                unset($this->data['var'][$kp]);
                            }
                        }
                    }
                }
                //pr($this->data['var']); exit;
                break;
            case 8:
                $this->data['view'] = 'ubicacion' . $page;
                $this->data['tipo_via'] = $this->data['numero_via'] = $this->data['letra_via'] = '';
                $this->data['letra_sufijo'] = $this->data['cuadrante'] = $this->data['tipo_via2'] = '';
                $this->data['numero_via2'] = $this->data['letra_via2'] = $this->data['letra_sufijo2'] = '';
                $this->data['numero_placa'] = $this->data['cuadrante2'] = $this->data['direJson'] = '';
                $this->data['arrTipoVia'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 901));
                $this->data['arrLetraVia'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 903));
                $this->data['arrLetraSujifo'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 905));
                $this->data['arrCuadrante'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 906));
                $this->data['arrTipoVia2'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 907));
                $this->data['arrLetraVia2'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 909));
                $this->data['arrLetraSujifo2'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 911));
                $this->data['arrCuadrante2'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 913));

                for($i = 1; $i <= 300; $i++) {
                   $this->data['arrNumeroVia'][] = array(
                        'REFERENCIA_HTML' => 'numero_via',
                        'ID_VALOR' => $i,
                        'ETIQUETA' => $i
                    );
                }
                if(!empty($arrVivi['UVA1_TIPO_VIA_DIR'])) {
                    $this->data['tipo_via'] = $arrVivi['UVA1_TIPO_VIA_DIR'];
                }
                if(!empty($arrVivi['UVA_DIRUND_JSON'])) {
                    $this->data['direJson'] = str_replace("'", '"', $arrVivi['UVA_DIRUND_JSON']);
                    $direJson = json_decode($arrVivi['UVA_DIRUND_JSON'], true);
                    foreach ($direJson as $key => $value) {
                        $this->data[$key] = $value;
                    }
                }
                break;
            case 9:
            case 10:
                $this->data['view'] = 'ubicacion' . $page;
                $this->data['arrComplemento'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 914));
                $this->data['direccion'] = '';
                if(!empty($arrVivi['UVA1_DIRUND_CLASE1'])) {
                    $this->data['direccion'] = $arrVivi['UVA1_DIRUND_CLASE1'];
                }
                //pr($this->data['var']); exit;
                break;
            case 'completo':
                $this->data['view'] = 'moduloExitoso';
                $this->data['moduleName'] = strtolower($this->data['title']);
                $this->data['imageLogo'] = 'completo_ubicacion';
                //pr($this->data); exit;
                break;
            case 13:
                redirect(base_url('vivienda'));
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
        /*if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }*/

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $arrDireJson = $arrCompleJson = array();
        $postt = $this->input->post(NULL, TRUE);
        //pr($postt); die;;
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $this->load->model('modform', 'mform');
        $this->load->model('vivienda/modvivienda', 'mvivi');
        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('hogar/modhogar', 'mhogar');

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $page = (!empty($this->session->userdata('paginaUbicacion'))) ? $this->session->userdata('paginaUbicacion'): 1;
        //pr($page); exit;
        $this->construirPreguntas();
        $duracion = $postt['duracion'];
        unset($postt['duracion']);
        $this->mvivi->setCodiEncuesta($codiEncuesta);
        $this->mvivi->setCodiVivienda($this->session->userdata('codiVivienda'));

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
            /*if(in_array($key, $this->arrDireccion)) {
                $arrDireJson[$key] = $value;
            }*/
            if($key == 'tipo_via') {
                $this->data['form']['UVA_DIRUND'] = $value;
                $arrDireJson[$key] = $value;
            }
            if($key == 'numero_via') {
                $this->data['form']['UVA_DIRUND'] .= ' ' . $value;
                $arrDireJson[$key] = $value;
            }
            if($key == 'numero_via2') {
                $this->data['form']['UVA_DIRUND'] .= ' # ' . $value;
                $arrDireJson[$key] = $value;
            }
            if($key == 'numero_placa') {
                $this->data['form']['UVA_DIRUND'] .= ' - ' . $value;
                $arrDireJson[$key] = $value;
            }
            if($key == 'complementos') {
                $this->data['form']['UVA_DIRUND'] .= ' ' . $value;
                $arrDireJson[$key] = $value;
            }
            if($key == 'U_CO' && !empty($value)){
                $this->data['form']['U_CO'] = $value;
            }
            if($key == 'U_AO' && !empty($value)){
                $this->data['form']['U_AO'] = $value;
            }
            if($key == 'U_UC' && !empty($value)){
                $this->data['form']['U_UC'] = $value;
            }
            if($key == 'U_EDIFICA' && !empty($value)){
                $this->data['form']['U_EDIFICA'] = $value;
            }
            if($key == 'UVA_USO_UNIDAD' && !empty($value)){
                $this->data['form']['UVA_USO_UNIDAD'] = $value;
            }
            if($key == 'UVA1_COD_OTROUSO' && !empty($value)){
                $this->data['form']['UVA1_COD_OTROUSO'] = $value;
            }
            if($key == 'UVA2_UNDNORESI' && !empty($value)){
                $this->data['form']['UVA2_UNDNORESI'] = $value;
            }
            if($key == 'U_EDIFICA' && !empty($value)){
                $this->data['form']['U_EDIFICA'] = $value;
            }
            if($key == 'U_VIVIENDA' && !empty($value)){
                $this->data['form']['U_VIVIENDA'] = $value;
            }
            if($key == 'UVA_ECENSO' && !empty($value)){
                $this->data['form']['UVA_ECENSO'] = $value;
            }
            if($key == 'H_CAMBIO_DIR' && !empty($value)){
                $this->data['formTotal']['H_CAMBIO_DIR'] = $value;
            }
            if($key == 'H_CERT_CENSAL' && !empty($value)){
                $this->data['formTotal']['H_CERT_CENSAL'] = $value;
            }
            if($key == 'UVA1_MASHOG' && !empty($value)){
                $this->data['form']['UVA1_MASHOG'] = $value;
            }
            if($key == 'UVA_ECENSO6' && !empty($value)){
                $this->data['form']['UVA_ECENSO6'] = $value;
            }
            if($key == 'UVA1_MASHOG6' && !empty($value)){
                $this->data['form']['UVA1_MASHOG6'] = $value;
            }
            if($key == 'UVA1_MASHOG6' && !empty($value)){
                $this->data['form']['UVA1_MASHOG6'] = $value;
            }
            if($key == 'UVA_COMPLEUND_JSON' && !empty($value)){
                $this->data['form']['UVA_COMPLEUND_JSON'] = $value;
            }
            if(($key == 'complemento_ingresado' || $key == 'direccion_clase2') && !empty($value)) {
                foreach ($postt as $key => $value) {
                    if(substr_count($key, 'complemento') && !empty($value)) {
                        $arrCompleJson[$key] = $value;
                    } else if(substr_count($key, 'adicion') && !empty($value)) {
                        $arrCompleJson[$key] = $value;
                    }
                }
            }
        }


        if(!empty($arrDireJson)) {
            $this->data['form']['UVA_DIRUND_JSON'] = json_encode($arrDireJson);
        }
        if(!empty($arrCompleJson)) {
            $this->data['form']['UVA_COMPLEUND_JSON'] = json_encode($arrCompleJson);
        }

        //pr($this->data['form']); exit;
        if(!empty($page)) {
            $vacios = true;
            if(!empty($this->data['form']['U_DPTO']) && !empty($this->data['form']['U_MPIO'])) {
                $ejemplosCPob = '';
                $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $this->data['form']['U_MPIO']));
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
            }elseif ((isset($this->data['form']['U_MPIO']) && empty($this->data['form']['U_MPIO'])) || (isset($this->data['form']['U_DPTO']) && empty($this->data['form']['U_DPTO']))) {
                $vacios = false;
            }

            if(!empty($this->data['form']['UVA2_NOM_BAVERCO']) || !empty($this->data['form']['UVA2_COMPLE_CLASE1'])) {
                $arrParam = array(
                    'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                    'codiVivienda' => $this->session->userdata('codiVivienda')
                );
                $arrVivi = $this->mvivi->consultarVivienda($arrParam);
                //$arrVivi = array_shift($arrVivi);
                unset($arrParam);
                if($arrVivi[0]['U_DPTO'] == 44) {
                    $this->data['form']['UVA1_TIPO_BAVERCO'] = 4; //Rancheria
                }
                if($arrVivi[0]['UA_CLASE'] == 1) { // Cabecera municipal
                     $page = intval($page) + 3;
                } else {
                    foreach ($this->data['preguntas'][4] as $kp4 => $vp4) {
                        if($vp4['REFERENCIA_HTML'] == 'resguardo') {
                            $arrParam = array('idDominio' => $vp4['FK_ID_DOMINIO']);
                            if(!empty($arrVivi[0]['U_MPIO'])) {
                                $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi[0]['U_MPIO']));
                                $arrParam['idPadre'] = $padre[0]['ID'];
                            }
                            $arrResguardos = $this->mform->consultarRespuestaDominio($arrParam);
                        } else if($vp4['REFERENCIA_HTML'] == 'territorio') {
                            $arrParam = array('idDominio' => $vp4['FK_ID_DOMINIO']);
                            if(!empty($arrVivi[0]['U_MPIO'])) {
                                $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi[0]['U_MPIO']));
                                $arrParam['idPadre'] = $padre[0]['ID'];
                            }
                            $arrTerritorios = $this->mform->consultarRespuestaDominio($arrParam);
                        }
                    }
                    if(intval($this->session->userdata('paginaUbicacion')) == 3 && count($arrResguardos) == 0 && count($arrTerritorios) == 0) {
                        $this->data['form']['UVA_ESTATER'] = 2; // No
                        $page = intval($page) + 1;
                    }
                    foreach ($this->data['preguntas'][5] as $kp5 => $vp5) {
                        if($vp5['REFERENCIA_HTML'] == 'area_protegida') {
                            $arrParam = array('idDominio' => $vp5['FK_ID_DOMINIO']);
                            if(!empty($arrVivi[0]['U_MPIO'])) {
                                $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi[0]['U_MPIO']));
                                $arrParam['idPadre'] = $padre[0]['ID'];
                            }
                            $arrAreas = $this->mform->consultarRespuestaDominio($arrParam);
                        }
                    }
                    if(intval($this->session->userdata('paginaUbicacion')) == 4 && count($arrAreas) == 0) {
                        $this->data['form']['UVA_ESTA_AREAPROT'] = 2; // No
                        $page = intval($page) + 1;
                    }
                }
                /*if(!empty($this->data['form']['UVA2_COMPLE_CLASE1'])) {
                    $this->data['form']['UVA_DIRUND'] = $arrVivi[0]['UVA_DIRUND'];
                }*/
            }
            if($vacios && $this->mvivi->actualizarVivienda($this->data['form']) && $this->mhogar->actualizarHogar($this->data['formTotal'])) {
                // Registrar en el log que guardo correctamente
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. Guardo correctamente en Ubicación. Datos: ' . implode('|', $this->data['form']) . '.');
                $page = intval($page) + 1;
                if(!empty($this->data['form']['UVA_CLASE_DIRUND'])) {
                    if($this->data['form']['UVA_CLASE_DIRUND'] == 2) {
                        $page = intval($page) + 2;
                    } else if($this->data['form']['UVA_CLASE_DIRUND'] == 3) {
                        $page = intval($page) + 3;
                    }
                }
                if(!empty($this->data['form']['UVA2_COMPLE_CLASE1'])) {
                    $page = intval($page) + 2;
                }
                if(!empty($this->data['form']['UVA1_DIRUND_CLASE2'])) {
                    $page = intval($page) + 1;
                }
                if($this->mvivi->actualizarEstadoUbicacion($page)) {
                    if(!empty($this->data['form']['U_DPTO'])) {
                        $arrF1['U_DPTO'] = $this->data['form']['U_DPTO'];
                        if(!empty($this->data['form']['U_MPIO'])) {
                            $arrF1['U_MPIO'] = $this->data['form']['U_MPIO'];
                        }
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
                    if(!empty($this->data['form']['UA_CLASE'])) {
                        $arrF1['UA_CLASE'] = $this->data['form']['UA_CLASE'];
                        if(!empty($this->data['form']['UA1_LOCALIDAD'])) {
                            $arrF1['UA1_LOCALIDAD'] = $this->data['form']['UA1_LOCALIDAD'];
                        }
                        if(!empty($this->data['form']['UA2_CPOB'])) {
                            $arrF1['UA2_CPOB'] = $this->data['form']['UA2_CPOB'];
                        }
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
                    if($page > $this->data['totalPaginas']) {
                        $response['avance'] = '100%';
                    } else {
                        $response['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']) . '%';
                    }
                    if($this->mencu->registrarTiempo('ubicacion', $duracion)) {
                        $response['mensaje'] = 'Se guardó correctamente la(s) respuesta(s).';
                        $this->session->set_userdata('paginaUbicacion', $page);
                    } else {
                        $response['codiError'] = 3;
                        $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Ubicación.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                    }
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo actualizar el estado de la ubicación.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                if(!$vacios) {
                    $response['mensaje'] = 'Se ha presentadoun error de conexión, Por favor intente de nuevo.';
                } else {
                    $response['mensaje'] = 'No se pudo guardar los datos de la ubicación.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
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
        /*if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }*/

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $postt = $this->input->post(NULL, TRUE);
        $this->construirPreguntas();
        $duracion = $postt['duracion'];
        unset($postt['duracion']);
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('vivienda/modvivienda', 'mvivi');

        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //$arrAC = array_shift($arrAC);
        $page = $this->session->userdata('paginaUbicacion');

        if($page > 0) {
            $arrParam = array(
                'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda')
            );
            $arrVivi = $this->mvivi->consultarVivienda($arrParam);
            //pr($arrVivi); exit;
            if(count($arrVivi) > 0) {
                $arrVivi = array_shift($arrVivi);
            }

            switch ($page) {
                case 6:
                    $page = intval($page) - 1;
                    if($arrVivi['UVA_ESTA_AREAPROT'] == 2) {
                        $page = intval($page) - 1;
                    }
                    if($arrVivi['UVA_ESTATER'] == 2) {
                        $page = intval($page) - 1;
                    }
                    break;
                case 7:
                    if(!empty($arrVivi['UA_CLASE']) && $arrVivi['UA_CLASE'] == 1) {
                        $page = intval($page) - 4;
                    } else {
                        $page--;
                    }
                    break;
                case 10:
                    $page = intval($page) - 3;
                    break;
                case 11:
                    $page = intval($page) - 4;
                    break;
                default:
                    $page--;
                    break;
            }
            $this->mvivi->setCodiEncuesta($codiEncuesta);
            $this->mvivi->setCodiVivienda($this->session->userdata('codiVivienda'));

            if($this->mvivi->actualizarEstadoUbicacion($page)) {
                if($this->mencu->registrarTiempo('ubicacion', $duracion)) {
                    $response['mensaje'] = 'Se guardaron correctamente los datos de la ubicación.';
                    $response['avance'] = ceil(($page - 1) * 100/$this->data['totalPaginas']) . '%';
                    $this->session->set_userdata('paginaUbicacion', $page);
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Ubicación.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo actualizar el estado de la ubicación.';
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
        /*if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }*/

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        //$postt = $this->input->post(NULL, TRUE);
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $this->construirPreguntas();

        $this->load->model('vivienda/modvivienda', 'mvivi');
        $this->mvivi->setCodiEncuesta($codiEncuesta);
        $this->mvivi->setCodiVivienda($this->session->userdata('codiVivienda'));
        $this->mvivi->setTotalPaginas($this->data['totalPaginas']);
        if($this->mvivi->actualizarEstadoUbicacion('f')) {
            $response['mensaje'] = 'Se finalizó correctamente la sección Ubicación.';
            $response['avance'] = '100%';
            $this->session->set_userdata('paginaUbicacion', $this->data['totalPaginas'] + 1);
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se pudo actualizar el estado de la ubicación.';
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
    private function construirPreguntas($tabla = 'ECP_UBICACION', $pagina = '') {
        $this->load->model('modform', 'mform');

        $this->data['preguntas'] = $this->mform->extraerPreguntas($tabla);
        //$this->data['preguntas'] = $this->consultarPreguntas('ECP_UBICACION');
        $this->data['totalPaginas'] = count($this->data['preguntas']);
        $this->data['preguntas'][++$this->data['totalPaginas']]['ubicacion_exitoso'] = 'SI';
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
        $this->session->set_userdata('paginaUbicacion', $numero);
        redirect(base_url($this->data['module']));
    }

    public function formNew() {
        $this->load->model('vivienda/modvivienda', 'mvivi');

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $codiVivienda = $this->session->userdata('codiVivienda');
        $codiHogar = $this->session->userdata('codiHogar');
        echo $codiEncuesta."---".$codiVivienda."++".$codiHogar;

        $this->data['view'] = 'newForm';
        $this->load->view('layout', $this->data);
    }

    public function guardarUbicacion() {
        error_reporting(0);
        $this->load->model('vivienda/modvivienda', 'mvivi');

        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $codiVivienda = $this->session->userdata('codiVivienda');

        $resp["codi_encuesta"] = $codiEncuesta;
        $resp["id_vivienda"] = $codiVivienda;
        $resp["ub_nombre_depto"] = $_POST["ub1_nombre_depto"]; // NO SE GUARDA

        if($_POST["ub1_codigo_depto"] == 0){
            $resp["ub_codigo_depto"] = NULL;         
        }else{
            $resp["ub_codigo_depto"] = $_POST["ub1_codigo_depto"];    
        }        

        $resp["ub_nombre_mun"] = $_POST["ub1_nombre_mun"]; // NO SE GUARDA

        if($_POST["ub1_codigo_mun"] == 0){
            $resp["ub_codigo_mun"] = NULL;            
        }else{
            $resp["ub_codigo_mun"] = $_POST["ub1_codigo_mun"];
        }        

        
        $resp["ub_clase"] = $_POST["ub2_clase"]; 
        $resp["ub_nombre_clase"] = $_POST["ub2_nombre_clase"]; // NO SE GUARDA        
        
        if($_POST["ub2_codigo_clase_localidad"] == 0){
            $resp["ub_codigo_clase_localidad"] = NULL;
        }else{
            $resp["ub_codigo_clase_localidad"] = $_POST["ub2_codigo_clase_localidad"];
        }

        if($_POST["ub2_codigo_clase_localidad"] == 0){
            $resp["ub_codigo_clase_centro_poblado"] = NULL;    
        }else{
            $resp["ub_codigo_clase_centro_poblado"] = $_POST["ub2_codigo_clase_centro_poblado"];    
        }
        
        
        $resp["ub_territorio_etnico"] = $_POST["ub3_territorio"]; // NO SE GUARDA
        $resp["ub_tipo_territorio_etnico"] = $_POST["ub3_tipo_territorio"]; // NO SE GUARDA
        $resp["ub_nombre_territorio_etnico"] = $_POST["ub3_nombre_tipo_territorio"]; // NO SE GUARDA
        $resp["ub_codigo_territorio_etnico"] = $_POST["ub3_codigo_tipo_territorio"]; // NO SE GUARDA
        $resp["ub_area_protegida"] = $_POST["ub4_area_protegida"];
        $resp["ub_nombre_area_protegida"] = $_POST["ub4_nombre_area_protegida"]; // NO SE GUARDA
        $resp["ub_codigo_area_protegida"] = $_POST["ub4_codigo_area_protegida"];
        $resp["ub_area_coordinacion_operativa"] = $_POST["ub5_area_coordinacion_operativa"];
        $resp["ub_area_operativa"] = $_POST["ub5_area_operativa"];
        /*$resp["ub_codigo_cobertura_urbana"] = $_POST["ub6_codigo_unidad_cobertura_urbana"];
        $resp["ub_codigo_cobertura_rural"] = $_POST["ub6_codigo_unidad_cobertura_rural"];
        */
        $resp["ub_codigo_cobertura"] = $_POST["ub6_codigo_unidad_cobertura"];
        $resp["ub_numero_edificacion"] = $_POST["ub7_numero_edificacion"];
        $resp["ub_direccion"] = $_POST["ub8_direccion"];
        $resp["ub_opcion_direccion"] = $_POST["ub8_opcion"];
        $resp["ub_uso_unidad"] = $_POST["ub9_unidad"];
        $resp["ub_opcion_mixta"] = $_POST["ub9_opc_mixta"];
        $resp["ub_opcion_no_residencial"] = $_POST["ub9_opc_no_residencial"];
        $resp["ub_orden_vivienda"] = $_POST["ub10_numero_orden"];
        $resp["ub_diligencio_censo"] = $_POST["ub11_realizo"];
        $resp["ub_documento_jefe"] = $_POST["ub11_documento_jefe"];
        $resp["ub_cambio_hogar"] = $_POST["ub11_1_cambio"];
        $resp["ub_mas_hogares"] = $_POST["ub11_2_mas_hogar"];
        $resp["ub_visitado_censo"] = $_POST["ub12_visitado"];
        $resp["ub_certificado_censal"] = $_POST["ub12_numero_certificado"];
        $resp["ub12_1_mas_hogares"] = $_POST["ub12_1_mas_hogares"];
        $resp["ub_vivienda_territorio_etnico"] = $_POST["ub13_vivienda_etnico"];
        $resp["ub_vivienda_tipo_territorio_etnico"] = $_POST["ub13_territorio"]; // NO SE GUARDA
        $resp["ub_nombre_territorio_ancestral_indigena"] = $_POST["ub13_nombre_territorio_ancestral_indigena"];
        $resp["ub_nombre_territorio_asentamiento"] = $_POST["ub13_nombre_territorio_asentamiento"];
        $resp["ub_nombre_territorio_reserva"] = $_POST["ub13_nombre_territorio_reserva"];
        $resp["ub_nombre_territorio_ancestral_negros"] = $_POST["ub13_nombre_territorio_ancestral_negros"];
        $resp["ub_nombre_territorio_sanandres"] = $_POST["ub13_nombre_territorio_sanandres"];
        $resp["vv_tipo_vivienda"] = $_POST["vv14_tipo_vivienda"];
        $resp["vv_ocupacion_vivienda"] = $_POST["vv15_ocupacion_vivienda"];
        $resp["vv_total_hogares"] = $_POST["vv16_total_hogares"];
        $resp["vv_paredes"] = $_POST["vv17_material_vivienda"];
        $resp["vv_pisos"] = $_POST["vv18_material_vivienda"];
        $resp["vv_energia_electrica"] = $_POST["vv19_energia_electrica"];
        $resp["vv_estrato_energia_electrica"] = $_POST["vv19_estrato_energia_electrica"];
        $resp["vv_acueducto"] = $_POST["vv19_acueducto"];
        $resp["vv_alcantarillado"] = $_POST["vv19_alcantarillado"];
        $resp["vv_gas"] = $_POST["vv19_gas"];
        $resp["vv_basura"] = $_POST["vv19_basura"];
        $resp["vv_veces_basura"] = $_POST["vv19_basura_veces"];
        $resp["vv_internet"] = $_POST["vv19_internet"];
        $resp["vv_servicio_sanitario"] = $_POST["vv20_sanitario"];

        $resultadoUbVv = $this->mvivi->actualizarDatosUbVv($resp);
        if($resultadoUbVv){
            redirect(base_url('hogar/formNew'));            
        }
    }
}
//EOC
