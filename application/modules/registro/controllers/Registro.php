<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controlador para el modulo de registrese
 * @author oagarzond
 * @since 2017-02-20
 */
class Registro extends MX_Controller {

    private $data;
    private $redis;
    private $campos = [
        1 => [
            'tipo_documento' => 'R_TIPO_DOC',
            'numero_documento' => 'R2_NRO_DOC',
            'fecha_expe' => 'R3_FECHA_EXPE_CC',
        ],
        2 => [
            'primer_nombre' => 'RA_1ER_NOMBRE',
            'primer_apellido' => 'RB_1ER_APELLIDO',
            'segundo_nombre' => 'RC_2DO_NOMBRE',
            'segundo_apellido' => 'RD_2DO_APELLIDO',
        ],
        3 => ['fecha_nacimiento' => 'R_FECHA_NAC',],
        4 => ['sexo' => 'R_SEXO',],
        5 => [
            'es_servidor' => 'R_ES_SERVIDOR',
            '(entidad)' => 'R_COD_ENTIDAD',
        ],
        6 => [
            'indicativo_fijo' => 'R_INDICATIVO',
            'telefono_celular' => 'R_TEL_CELULAR',
            'telefono_fijo' => 'R_TEL_FIJO',
        ],
        7 => [
            'correo_electronico' => 'R_USUARIO',
        ],
        8 => [
            'contrasena1' => 'R_CLAVE',
            'contrasena2' => 'R_CLAVE2',
        ]
    ];

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module : 'home';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['footer'] = 'progressBar';
        if (!isset($this->data['csrf'])) {
            $this->data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
        }
    }

    /**
     * Muestra el formulario de inscripcion
     * @author oagarzond
     * @since 2017-02-27
     */
    public function index() {
        $arrFechasDili = $this->config->item('diligenciamiento');
        $restaIni = restar_fechas(date('Y-m-d'), $arrFechasDili['fechaIni']);
        $restaFin = restar_fechas($arrFechasDili['fechaFin'], date('Y-m-d'));
        /*if($restaIni < 0 || $restaFin < 0) {
            $this->data['view'] = 'finalizado';
            $this->data['header'] = 'header';
            $this->data['footer'] = 'footer';
            $this->data['title'] = 'Tiempo de diligenciamiento terminado';
            $this->load->view('layout', $this->data);
            return false;
        }*/
        $this->data['arrCss'][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data['arrJS'][] = base_url_plugins('moment/js/moment.min.js');
        $this->data['arrJS'][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data['arrJS'][] = base_url_js('fillInFormTimer.js');

        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('modregistro', 'mregis');
        $this->load->model('modform', 'mform');

        $page = $pageAC = '1';

        if((!empty($this->session->userdata('mostrarFormRegistro')))) {

            if(!empty($this->session->all_userdata()['PAG_REGISTRO'])) {
                    $pageAC = $this->session->all_userdata()['PAG_REGISTRO'];
            }

            $this->session->set_userdata('numeroPagina', $pageAC);
            $this->mostrar($pageAC);
        } else {
            $this->mostrarTutorial();
        }
    }

    /**
     * Se consulta y/o se construye el archivo de preguntas con sus opciones
     * y el total de paginas
     * @author oagarzond
     * @since 2017-08-14
     */
    private function construirPreguntas($tabla = 'ECP_REGISTRO', $pagina = '') {
        $this->load->model('modform', 'mform');

        $this->data['preguntas'] = $this->mform->extraerPreguntas($tabla);
        //$this->data['preguntas'] = $this->consultarPreguntas('ECP_REGISTRO');
        $this->data['totalPaginas'] = count($this->data['preguntas']);
        $this->data['preguntas'][++$this->data['totalPaginas']]['terminos_condiciones'] = 'SI';
        $this->data['preguntas'][++$this->data['totalPaginas']]['registro_exitoso'] = 'SI';
    }

    /**
     * Muestra el contenido de las paginas del tutarial
     * del registro
     * @author oagarzond
     * @since 2017-07-17
     */
    private function mostrarTutorial() {
        //pr($this->session->all_userdata()); exit;
        $this->data['breadcrumb'] = '';
        $this->data['title'] = 'Registro';
        $this->data['view'] = 'registro0';
        $this->data['avance'] = '0%';
        //pr($this->data); exit;
        $this->load->view('layout', $this->data);
    }

    /**
     * Muestra el contenido de las paginas del modulo
     * @author oagarzond
     * @param $page         Pagina que se va a mostrar
     * @since 2017-03-20
     */
    private function mostrar($page = 0) {

        //pr($this->session->all_userdata());

        $this->data['breadcrumb'] = '';
        $this->data['title'] = 'Registro';
        $this->data['view'] = 'registro';
        $this->data['var'] = '';
        $this->data['mostrarAnterior'] = 'NO';
        $this->data['mensajeConfirmacion'] = 'NO';
        $this->construirPreguntas();
        $this->data['avance'] = '0%';
        $this->data['URLVideo'] = '';

        if($page > 1) {
            $this->data['avance'] = ceil($page * 100/$this->data['totalPaginas']) . '%';
        }

        if($page < ($this->data['totalPaginas'] - 1)) {
            //$arrPreguntas = $this->consultarPreguntas('ECP_REGISTRO', $page);
            //$this->data['var'] = cambiar_campos_BD_HTML($arrPreguntas, $this->arrCampos[$page]);
            $this->data['var'] = $this->data['preguntas'][$page];
        }

        if(!empty($this->data['var'])) {

            if(!empty($this->session->userdata()['page'])){
                $arrRegistro = $this->session->userdata()['page'];
            }else{
                $arrRegistro = array();
            }

            if(count($arrRegistro) > 0) {
                if(count($this->data['preguntas'][$page]) > 0 && empty($this->data['preguntas'][$page]['ubicacion_exitoso'])) {
                   $this->data['var'] = asignar_valor_pregunta($this->data['preguntas'][$page], $arrRegistro);
                }
            }

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
                if(!is_null($vv['URL_VIDEO'])){
                    $this->data['URLVideo'] = $vv['URL_VIDEO'];
                }
            }
        }

        $this->data['mostrarAnterior'] = 'SI';
        switch ($page) {
            case 1:
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                $this->data['mostrarAnterior'] = 'NO';
                $this->data['mensajeConfirmacion'] = 'Si su tipo de documento es <span class="label-bold" id="tipo_documento-confirm"></span><span class="label-bold" id="tipo_documento2-confirm"></span> y su número de documento es <span class="label-bold" id="numero_documento-confirm"></span> por favor haga clic en "Guardar y continuar", de lo contrario haga clic en "Anterior".';
                $this->data['mensajeCedula'] = "Digite la información como aparece en su documento de identificación";
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'tipo_documento') {
                        $arrParamTDP = array(
                            'idDominio' => $vv['FK_ID_DOMINIO'],
                            'valor' => array(3, 4),
                            'sidx' => 'RD.VALOR_MINIMO',
                            'sord' => 'ASC'
                        );
                        // $arrTipoDocuPers = $this->mform->consultarRespuestaDominio($arrParamTDP);
                        $arrTipoDocuPers = [["VALOR_MIN" => "03", "ID_RESPUESTA_DOMINIO" => "29586", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "3", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Cédula de ciudadanía", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29586", "ID_VALOR" => "3", "ETIQUETA" => "Cédula de ciudadanía"], ["VALOR_MIN" => "04", "ID_RESPUESTA_DOMINIO" => "29587", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "4", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Cédula de extranjería", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29587", "ID_VALOR" => "4", "ETIQUETA" => "Cédula de extranjería"], ["VALOR_MIN" => "06", "ID_RESPUESTA_DOMINIO" => "29588", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "6", "VALOR_MAXIMO" => null, "DESCRIPCION" => "No tiene cédula", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29588", "ID_VALOR" => "6", "ETIQUETA" => "No tiene cédula"]];
                        foreach ($arrTipoDocuPers as $ktd => $vtd) {
                            $this->data['var'][$kv]['OPCIONES'][$vtd['ID_VALOR']] = array(
                                'ID_PREGUNTA' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $vtd['ID_VALOR'],
                                'DESCRIPCION_OPCION' => $vtd['ETIQUETA'],
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $vtd['ID_VALOR']
                            );
                        }
                        // $this->data['var'][$kv]['OPCIONES'][2]['ID_PREGUNTA'] = $vv['REFERENCIA_HTML'];
                        // $this->data['var'][$kv]['OPCIONES'][2]['ID_OPCION'] = '6';
                        // $this->data['var'][$kv]['OPCIONES'][2]['DESCRIPCION_OPCION'] = 'No tiene cédula';
                        // $this->data['var'][$kv]['OPCIONES'][2]['ORDEN_VISUAL'] = '6';
                    }
                    if($vv['REFERENCIA_HTML'] == 'tipo_documento2') {
                        $arrParamTDP2 = array(
                            'idDominio' => $vv['FK_ID_DOMINIO'],
                            'valor' => array(1, 2, 5),
                            'sidx' => 'RD.VALOR_MINIMO',
                            'sord' => 'ASC'
                        );
                        // $arrTipoDocuPers = $this->mform->consultarRespuestaDominio($arrParamTDP2);
                        $arrTipoDocuPers = [["VALOR_MIN" => "03", "ID_RESPUESTA_DOMINIO" => "29586", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "3", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Cédula de ciudadanía", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29586", "ID_VALOR" => "3", "ETIQUETA" => "Cédula de ciudadanía"], ["VALOR_MIN" => "04", "ID_RESPUESTA_DOMINIO" => "29587", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "4", "VALOR_MAXIMO" => null, "DESCRIPCION" => "Cédula de extranjería", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29587", "ID_VALOR" => "4", "ETIQUETA" => "Cédula de extranjería"], ["VALOR_MIN" => "06", "ID_RESPUESTA_DOMINIO" => "29588", "ID_DOMINIO" => "26", "VALOR_MINIMO" => "6", "VALOR_MAXIMO" => null, "DESCRIPCION" => "No tiene cédula", "ID_RESPUESTA_DOMINIO_PADRE" => null, "ID" => "29588", "ID_VALOR" => "6", "ETIQUETA" => "No tiene cédula"]];
                        foreach ($arrTipoDocuPers as $ktd => $vtd) {
                            $this->data['var'][$kv]['OPCIONES'][$vtd['ID_VALOR']] = array(
                                'ID_PREGUNTA' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $vtd['ID_VALOR'],
                                'DESCRIPCION_OPCION' => $vtd['ETIQUETA'],
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $vtd['ID_VALOR']
                            );
                        }
                    }
                    if($vv['REFERENCIA_HTML'] == 'fecha_expe') {
                        $this->data['var'][$kv]['ANIO'] = date('Y');
                        $this->data['var'][$kv]['ID_PREGUNTA_ANIO'] = 'anio_expe';
                        $this->data['var'][$kv]['ID_PREGUNTA_MES'] = 'mes_expe';
                        $this->data['var'][$kv]['ID_PREGUNTA_DIA'] = 'dia_expe';
                        $this->data['var'][$kv]['VALOR_ANIO'] = '';
                        $this->data['var'][$kv]['VALOR_MES'] = '';
                        $this->data['var'][$kv]['VALOR_DIA'] = '';
                        //$this->data['var'][$kv]['HIDDEN'] = 'SI';
                        if(!empty($arrRegistro['R3_FECHA_EXPE_CC']) && $arrRegistro['R3_FECHA_EXPE_CC'] != "NULL") {
                            $tmpFecha = explode('/', $arrRegistro['R3_FECHA_EXPE_CC']);
                            $this->data['var'][$kv]['VALOR_ANIO'] = $tmpFecha[2];
                            $this->data['var'][$kv]['VALOR_MES'] = $tmpFecha[1];
                            $this->data['var'][$kv]['VALOR_DIA'] = $tmpFecha[0];
                            $this->data['var'][$kv]['HIDDEN'] = 'NO';
                        }
                    }
                }
                // pr($this->data['var']); die();
                break;
            case 2:
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                break;
            case 3:
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'fecha_nacimiento') {
                        $this->data['var'][$kv]['ANIO'] = intval(date('Y') - 18);
                        $this->data['var'][$kv]['ID_PREGUNTA_ANIO'] = 'anio_naci';
                        $this->data['var'][$kv]['ID_PREGUNTA_MES'] = 'mes_naci';
                        $this->data['var'][$kv]['ID_PREGUNTA_DIA'] = 'dia_naci';
                        $this->data['var'][$kv]['VALOR_ANIO'] = '';
                        $this->data['var'][$kv]['VALOR_MES'] = '';
                        $this->data['var'][$kv]['VALOR_DIA'] = '';
                        //$this->data['var'][$kv]['HIDDEN'] = 'SI';
                        if(!empty($arrRegistro['R_FECHA_NAC']) > 0) {
                            $tmpFecha = explode('/', $arrRegistro['R_FECHA_NAC']);
                            $this->data['var'][$kv]['VALOR_ANIO'] = $tmpFecha[2];
                            $this->data['var'][$kv]['VALOR_MES'] = $tmpFecha[1];
                            $this->data['var'][$kv]['VALOR_DIA'] = $tmpFecha[0];
                        }
                    }
                }
                /*for ($i = (intval(date('Y')) - 18); $i >= 1900; $i--) {
                    $this->data['arrAnios'][] = $i;
                }
                for ($i = 1; $i <= 12; $i++) {
                    $this->data['arrMeses'][] = str_pad($i, 2, '0', STR_PAD_LEFT);
                }
                for ($i = 1; $i <= 31; $i++) {
                    $this->data['arrDias'][] = str_pad($i, 2, '0', STR_PAD_LEFT);
                }*/
                break;
            case 4:
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'sexo') {
                        $arrParam = array(
                            'idDominio' => $vv['FK_ID_DOMINIO'],
                            'sidx' => 'RD.VALOR_MINIMO',
                            'sord' => 'ASC'
                        );
                        $arrSexos = $this->mform->consultarRespuestaDominio($arrParam);
                        unset($arrParam);
                        foreach ($arrSexos as $ks => $vs) {
                            $this->data['var'][$kv]['OPCIONES'][$vs['ID']] = array(
                                'ID_PREGUNTA' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $vs['ID_VALOR'],
                                'DESCRIPCION_OPCION' => $vs['ETIQUETA'],
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $vs['ID_VALOR']
                            );
                            if($vs['ID_VALOR'] == 3) {
                                $this->data['var'][$kv]['OPCIONES'][$vs['ID']]['AYUDA'] = 'Persona que biológicamente nace con los órganos sexuales de hombre y de mujer.';
                            }
                        }
                    }
                }
                break;
            case 5:
                $this->data['arrCss'][] = base_url_plugins('select2/css/select2.min.css');
                $this->data['arrCss'][] = base_url_plugins('select2/css/select2-bootstrap.min.css');
                $this->data['arrJS'][] = base_url_plugins('select2/js/select2.min.js');
                $this->data['arrJS'][] = base_url_plugins('select2/js/i18n/es.js');
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'es_servidor') {
                        foreach ($this->data['var'] as $kp => $vp) {
                            if($vp['REFERENCIA_HTML'] == 'entidad') {
                                $arrParam = array('idDominio' => $vp['FK_ID_DOMINIO']);
                                $arrEntidades = $this->mform->consultarRespuestaDominio($arrParam);
                                unset($arrParam);
                                if(count($arrEntidades) > 0) {
                                    foreach ($arrEntidades as $ken => $ven) {
                                        if(!empty($ven['ID_VALOR'])) {
                                            $this->data['var'][$kp]['OPCIONES'][$ken] = array(
                                                'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                                                'ID_OPCION' => $ven['ID_VALOR'],
                                                'DESCRIPCION_OPCION' => $ven['ETIQUETA'],
                                                'AYUDA' => '',
                                                'ORDEN_VISUAL' => $ven['ID_VALOR']
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
                break;
            case 6:
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                foreach ($this->data['var'] as $kv => $vv) {
                    if($vv['REFERENCIA_HTML'] == 'indicativo_fijo') {
                        $arrIndicativos = $this->mform->consultarRespuestaDominio(array('idDominio' => $vv['FK_ID_DOMINIO']));
                        foreach ($arrIndicativos as $ki => $vi) {
                            $this->data['var'][$kv]['OPCIONES'][$vi['ID']] = array(
                                'ID_PREGUNTA' => $vv['REFERENCIA_HTML'],
                                'ID_OPCION' => $vi['ID_VALOR'],
                                'DESCRIPCION_OPCION' => $vi['ETIQUETA'] . ' - ' . $vi['ID_VALOR'],
                                'AYUDA' => '',
                                'ORDEN_VISUAL' => $vi['ID_VALOR']
                            );
                        }
                    }
                }
                break;
            case 7:
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                $this->data['mensajeConfirmacion'] = 'Si su correo electrónico es <span class="label-bold" id="correo_electronico-confirm"></span> por favor haga clic en "Guardar y continuar", de lo contrario haga clic en "Anterior".';
                break;
            case 8:
                $this->data['arrJS'][] = base_url_js('login/md5.js');
                $this->data['arrJS'][] = base_url_js('registro/registro' . $page . '.js');
                break;
            case 9:
                $this->data['view'] = 'terminosCondiciones';
                break;
            case 10:
                $this->data['view'] = 'registroExitoso';
                $this->data['correoElectronico'] = $this->data['clave'] = '';
                $this->load->model('usuarios/modusuarios', 'musua');

                $codiEncuesta = (!empty($this->session->userdata('codiEncuesta'))) ? $this->session->userdata('codiEncuesta'): 0;
                if($codiEncuesta > 0) {
                    $arrUsua = $this->musua->consultarAdminUsuarios(array('codiEncuesta' => $this->session->userdata('codiEncuesta')));
                    if(count($arrUsua) > 0) {
                        $this->data['correoElectronico'] = $arrUsua[0]['USUARIO'];
                        //$this->load->library('danecrypt');
                        //$this->data['clave'] = $this->danecrypt->decode($arrUsua[0]['CLAVE']);
                        $this->load->library('danecrypt');
                        $encryptClave = $this->danecrypt->encode($arrUsua[0]['CLAVE'], $arrUsua[0]['USUARIO']);
                        $this->data['clave'] =  $encryptClave;
                    }
                }
                break;
            case 11:
                redirect(base_url());
                break;
        }
        // pr($this->data); exit;
        $this->load->view('layout', $this->data);
    }
    /**
     * Valida y completa la información de la persona
     * @author oagarzond
     * @since 2017-02-27
     */
    public function empezar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['codiError'] = 0;
        $response['msgError'] = '';
        $this->session->set_userdata('mostrarFormRegistro', 'SI');
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }


    /**
     * Valida y completa la información de la persona
     * @author oagarzond
     * @since 2017-02-27
     */
    public function completarPersona() {
        // Si no es una petición ajax mostramos un error 403
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['codiError'] = 0;
        $response['msgError'] = '';
        $response['tooo'] = $this->data['csrf'];
        $response['primerNombre'] = $response['segundoNombre'] = $response['primerApellido'] = $response['segundoApellido'] = '';

        $postt = $this->input->post(NULL, TRUE);
        if (!empty($postt) && count($postt) > 0) {
            $tipoDocu = $this->input->post('tipoDocu', TRUE);
            $numeDocu = $this->input->post('numeDocu', TRUE);
            $peticion = $this->input->post('peticion', TRUE);
        } else {
            $response['codiError'] = 1;
            $response['msgError'] = 'No se definió correctamente los parametros.';
        }

        if (empty($response['msgError'])) {
            if (empty($tipoDocu)) {
                $response['codiError'] = 2;
                $response['msgError'] = 'Por favor defina el tipo de documento.';
            }

            if (empty($numeDocu)) {
                $response['codiError'] = 3;
                $response['msgError'] = 'Por favor defina el número de documento.';
            }
        }

        if (empty($response['msgError'])) {
            $this->load->model('personas/modpersonas', 'mpers');

            $arrPers = $this->mpers->consultarPersonas(array('tipoDocu' => $tipoDocu, 'numeDocu' => $numeDocu));
            if(count($arrPers) > 0) {
                $response['codiError'] = 4;
                $response['msgError'] = 'Ya existe un usuario registrado con este número de documento.';
            }
        }

        if ($response['codiError'] == 0 && $tipoDocu == 3 && $peticion=="1"){
            $response['registraduria'] = $this->wsValidaCedula($numeDocu, true);
        }
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Valida si el correo ingresado ya existe en el sistema
     * @author oagarzond
     * @since 2017-02-27
     */
    public function validarCorreo() {
        // Si no es una petición ajax mostramos un error 403
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['codiError'] = 0;
        $response['msgError'] = '';

        $postt = $this->input->post(NULL, TRUE);
        if (!empty($postt) && count($postt) > 0) {
            $emailPers = strtolower($this->input->post('email'));
            if (empty($emailPers)) {
                $response['codiError'] == 1;
                $response['msgError'] = 'No se definió correctamente los parametros.';
            }
        } else {
            $response['codiError'] = 1;
            $response['msgError'] = 'Por favor defina el correo electrónico.';
        }

        if (empty($response['msgError'])) {
            $this->load->model('usuarios/modusuarios', 'musua');

            $this->sufijoTabla = 'ECP';
            if(in_array($this->config->item('tipoFormulario'), array('G', 'H'))) {
                $this->sufijoTabla = 'WCP';
            }

            $arrUsua = $this->musua->consultarAdminUsuarios(array('usuario' => $emailPers));

            if (count($arrUsua)>0){
                $response['codiError'] = 1;
                $response['msgError'] = 'El usuario ya esta registrado';

            } else if(!$this->musua->es_unico($emailPers, $this->sufijoTabla . '_ADMIN_USUARIOS.USUARIO')) {
                $response['codiError'] = 2;
                $response['msgError'] = 'El correo electrónico ya está registrado en el sistema.';
            }

            // pr($this->session->userdata());
            // pr($arrUsua);
            // pr($postt);
            // pr($response);
            // die();

        }
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

     /**
     * Guarda la informacion del registro en la base de datos
     * @author oagarzond
     * @since 2017-02-27
     */
    public function guardar() {
        /*if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }*/

        $this->load->model('modregistro', 'mregis');

        $sessionData = array(
            'codiEncuesta' => 0,
            'codiVivienda' => 0,
            'codiHogar' => 0,
            'id' => 0,
            'numeVisita' => 1
            );

        $this->session->set_userdata($sessionData);

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

        if(!empty($this->data['numero_documento'])) {
            if(empty($this->session->userdata('mostrarFormRegistro'))) {
                $this->load->model('personas/modpersonas', 'mpers');
                $arrPers = $this->mpers->consultarPersonas(array('numeDocu' => $this->data['numero_documento']));
                if(count($arrPers) > 0) {
                    $response['codiError'] = 1;
                    $response['mensaje'] = 'Ya existe un usuario registrado con este número de documento.';
                }
            }
        } else {
            //$response['codiError'] = 3;
            //$response['mensaje'] = 'No se definió el número de documento.';
        }

        if(!empty($this->data['correo_electronico'])) {
            if(empty($this->session->userdata('mostrarFormRegistro'))) {
                $this->load->model('usuarios/modusuarios', 'musua');
                $arrUsua = $this->musua->consultarAdminUsuarios(array('usuario' => $this->data['correo_electronico']));
                if(count($arrUsua) > 0) {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'El correo electrónico ya está registrado en el sistema.';
                }
            }
        } else {
            //$response['codiError'] = 5;
            //$response['mensaje'] = 'No se definió el correo electrónico del usuario.';
        }

        if($response['codiError'] == 0) {
            $this->load->model('modregistro', 'mregis');
            $this->load->model('modform', 'mform');

            $this->construirPreguntas();
            $page = (!empty($this->session->userdata('numeroPagina'))) ? $this->session->userdata('numeroPagina'): 0;
            if(!empty($postt['duracion'])) {
                $duracion = $postt['duracion'];
                unset($postt['duracion']);
            }

            $arrKeys = array_keys($this->data['preguntas'][$page]);
            if(count($this->data['preguntas'][$page]) > 0  && !empty($this->data['preguntas'][$page][$arrKeys[0]]['ID_PREGUNTA'])) {
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
            }
            if(!empty($postt['anio_expe'])) {
                $this->data['form']['R3_FECHA_EXPE_CC'] = $this->data['dia_expe'] . '/' . $this->data['mes_expe'] . '/' . $this->data['anio_expe'];
            }

            if(!empty($postt['anio_naci'])) {
                $this->data['form']['R_FECHA_NAC'] = $this->data['dia_naci'] . '/' . $this->data['mes_naci'] . '/' . $this->data['anio_naci'];
            }

            if(!empty($postt['edad'])) {
                $this->data['form']['R_EDAD'] = $this->data['edad'];
            }

            if(!empty($postt['correo_electronico'])){
                $this->data['form']['R_USUARIO'] =  strtolower($this->data['correo_electronico']);
            }
            //pr($this->data['form']); exit;
            $codiEncuesta = (!empty($this->session->userdata('codiEncuesta'))) ? $this->session->userdata('codiEncuesta'): 0;

            //$page = intval($page) + 1;

            if($page < 9){
                 //Aquí se asocia el número de página con su respectivo contenido del formulario.
                $info['page'] = $this->data['form'];

                //Se valida que se hay inicializado el arreglo de paginas en la sesión
                if(!empty($this->session->all_userdata()['page'])){
                    //Si existe el arreglo page dentro de las variables de sesión se hace un merge entre el valor existente y el nuevo item
                    $this->session->set_userdata(array_merge($this->session->all_userdata(), array('page' =>  $info['page'] + $this->session->all_userdata()['page'])));
                }else{
                    //Si no existe el arreglo page dentro de las variables de sesión, se agrega a la sesión
                    $this->session->set_userdata($info);
                }

                $datosRegistro = $this->session->all_userdata()['page'];
                $contador = 0;
                $contador2 = 0;

                switch ($page) {
                    case '1':
                        if (empty($datosRegistro['R_TIPO_DOC']) || (intval($datosRegistro['R_TIPO_DOC']) === 3 && empty($datosRegistro['R3_FECHA_EXPE_CC']))){
                            $contador++;
                        }
                        break;
                    case '2':
                        if (empty($datosRegistro['RA_1ER_NOMBRE']) || empty($datosRegistro['RB_1ER_APELLIDO'])) {
                            $contador++;
                        }
                        break;
                    case '3':
                        if(empty($datosRegistro['R_FECHA_NAC'])){
                            $contador++;
                        }

                        if (intval($datosRegistro['R_TIPO_DOC']) === 3){
                            if($this->session->userdata('estadoWs') != 0 || $this->session->userdata('estadoData') != 0) {
                                $contador2++;
                            }
                            if(intval($datosRegistro['R2_NRO_DOC']) != intval($this->session->userdata('NUIP'))) {
                                $contador2++;
                            }
                            if($datosRegistro['R3_FECHA_EXPE_CC'] != $this->session->userdata('fechaExpedicion')['completa']) {
                                $contador2++;
                            }
                            if($datosRegistro['R_FECHA_NAC'] != $this->session->userdata('fechaNacimiento')) {
                                $contador2++;
                            }
                            if($datosRegistro['RB_1ER_APELLIDO'] != $this->session->userdata('primerApellido')) {
                                $contador2++;
                            }
                            if($datosRegistro['RD_2DO_APELLIDO'] != $this->session->userdata('segundoApellido')) {
                                $contador2++;
                            }
                            // if($datosRegistro['RA_1ER_NOMBRE'] != $this->session->userdata('primerNombre')) {
                            //     $contador2++;
                            // }
                            // if($datosRegistro['RC_2DO_NOMBRE'] != $this->session->userdata('segundoNombre')) {
                            //     $contador2++;
                            // }
                        }
                        break;
                    case '4':
                        if(empty($datosRegistro['R_SEXO'])){
                            $contador++;
                        }
                        break;
                    case '5':
                        if(empty($datosRegistro['R_ES_SERVIDOR']) || ($datosRegistro['R_ES_SERVIDOR'] === 1 && empty($datosRegistro['R_COD_ENTIDAD']))){
                                $contador++;
                        }
                        break;
                    case '6':
                        if(empty($datosRegistro['R_TEL_CELULAR'])){
                            if(empty($datosRegistro['R_INDICATIVO']) || empty($datosRegistro['R_TEL_FIJO'])){
                                 $contador++;
                            }
                        }
                        break;
                    case '7':
                        if(empty($datosRegistro['R_USUARIO'])){
                            $contador++;
                        }
                        break;
                    case '8':
                        if(empty($datosRegistro['R_CLAVE'])){
                            $contador++;
                        }
                        break;
                }

                if($contador == 0){
                    $page = intval($page) + 1;
                }

                if($contador2 !== 0){
                    $page = 1;
                    $this->session->unset_userdata('peticion');
                    $this->session->unset_userdata('numeroControl');
                    $this->session->unset_userdata('estadoWs');
                    $this->session->unset_userdata('estadoData');
                    $this->session->unset_userdata('NUIP');
                    $this->session->unset_userdata('fechaExpedicion');
                    $this->session->unset_userdata('fechaNacimiento');
                    $this->session->unset_userdata('primerApellido');
                    $this->session->unset_userdata('segundoApellido');
                    $this->session->unset_userdata('primerNombre');
                    $this->session->unset_userdata('segundoNombre');
                    $this->session->unset_userdata('page');
                }

                if($this->mregis->actualizarEstadoAC($page)) {
                    if($page == $this->data['totalPaginas']) {
                        $response['avance'] = '100%';
                    } else {
                        $response['avance'] = ceil($page * 100/$this->data['totalPaginas']) . '%';
                    }
                    $this->load->model('encuesta/modencuesta', 'mencu');
                    if($this->mencu->registrarTiempo('registro', $duracion)) {
                        $response['mensaje'] = 'Se guardó correctamente los datos del registro.';
                    } else {
                        $response['codiError'] = 6;
                        $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                    }
                    if($contador2 > 0){
                        $response['codiError'] = 5;
                        $response['mensaje'] = 'La información ingresada no coincide con la registrada en su documento de identidad, por favor intente de nuevo.';
                    }
                } else {
                    $response['codiError'] = 5;
                    $response['mensaje'] = 'No se pudo actualizar el estado de la encuesta.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }

            }else{

                $page = intval($page) + 1;

                if($this->mregis->actualizarEstadoAC($page)) {
                    if($page == $this->data['totalPaginas']) {
                        $response['avance'] = '100%';
                    } else {
                        $response['avance'] = ceil($page * 100/$this->data['totalPaginas']) . '%';
                    }
                    $this->load->model('encuesta/modencuesta', 'mencu');
                    if($this->mencu->registrarTiempo('registro', $duracion)) {
                        $response['mensaje'] = 'Se guardó correctamente los datos del registro.';
                    } else {
                        $response['codiError'] = 6;
                        $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                    }
                } else {
                    $response['codiError'] = 5;
                    $response['mensaje'] = 'No se pudo actualizar el estado de la encuesta.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }

                $this->load->model('personas/modpersonas', 'mpers');
                $this->load->model('usuarios/modusuarios', 'musua');

                $this->data['form'] = $this->session->all_userdata()['page'];

                $arrDatos['RA2_1NOMBRE'] = $this->data['form']['RA_1ER_NOMBRE'];
                $arrDatos['RA4_1APELLIDO'] = $this->data['form']['RB_1ER_APELLIDO'];
                if(!empty($this->data['form']['RC_2DO_NOMBRE'])){
                    $arrDatos['RA3_2NOMBRE'] = $this->data['form']['RC_2DO_NOMBRE'];
                }
               if(!empty($this->data['form']['RD_2DO_APELLIDO'])){
                    $arrDatos['RA5_2APELLIDO'] = $this->data['form']['RD_2DO_APELLIDO'];
                }

                $arrDatos['PA_1ER_NOMBRE'] = $this->data['form']['RA_1ER_NOMBRE'];
                $arrDatos['PB_1ER_APELLIDO'] = $this->data['form']['RB_1ER_APELLIDO'];

                if(!empty($this->data['form']['R_TIPO_DOC'])){
                    $arrDatos['PA_TIPO_DOC'] = $this->data['form']['R_TIPO_DOC'];
                }
                if(!empty($this->data['form']['R1_TIPO_DOC2'])){
                    $arrDatos['PA_TIPO_DOC'] = $this->data['form']['R1_TIPO_DOC2'];
                }
                if(!empty($this->data['form']['R2_NRO_DOC'])){
                    $arrDatos['PA1_NRO_DOC'] = $this->data['form']['R2_NRO_DOC'];
                }

                $arrDatos['PA_SABE_FECHA'] = '1';
                $arrDatos['PA1_FECHA_NAC'] =  $this->data['form']['R_FECHA_NAC'];
                $arrDatos['P_EDAD'] = $this->data['form']['R_EDAD'];
                $arrDatos['P_SEXO'] = $this->data['form']['R_SEXO'];

                if(!empty($this->data['form']['R3_FECHA_EXPE_CC'])){
                    $arrDatosACP['VALIDA_CEDULA'] = '3';
                    $arrDatosACP['FECHA_EXPE_CC'] = $this->data['form']['R3_FECHA_EXPE_CC'];
                }

                $arrDatos['R_ES_SERVIDOR'] = $this->data['form']['R_ES_SERVIDOR'];
                $arrDatos['R_COD_ENTIDAD'] = $this->data['form']['R_COD_ENTIDAD'];

                $arrDatos['R_INDICATIVO'] = $this->data['form']['R_INDICATIVO'];
                $arrDatos['R_TEL_FIJO'] = $this->data['form']['R_TEL_FIJO'];
                $arrDatos['R_TEL_CELULAR'] = $this->data['form']['R_TEL_CELULAR'];

                $arrDatos['R_USUARIO'] = strtolower($this->data['form']['R_USUARIO']);


                $arrDatos['R3_FECHA_EXPE_CC'] = $this->data['form']['R3_FECHA_EXPE_CC'];

                //$this->load->library('danecrypt');
                //$this->data['R_CLAVE'] = $this->danecrypt->encode($this->data['form']['R_CLAVE']);
                $this->data['R_CLAVE'] = $this->data['form']['R_CLAVE'];
                //$arrDatos['R_CLAVE'] = hash('sha512', $this->data['R_CLAVE'] . $arrDatos['R_USUARIO']);
                $this->load->library('danecrypt');
                $encryptClave = $this->danecrypt->encode($this->data['R_CLAVE'], $arrDatos['R_USUARIO']);
                $arrDatos['R_CLAVE'] =  $encryptClave;

                $estadoVariables = false;

                if($this->data['form']['RA_1ER_NOMBRE'] != '' &&
                    $this->data['form']['RB_1ER_APELLIDO'] != '' &&
                    $this->data['form']['R_USUARIO'] != '' &&
                    $this->data['form']['R_CLAVE'] != '' &&
                    $this->data['form']['R2_NRO_DOC'] != '' &&
                    $this->data['form']['R_FECHA_NAC'] != '' &&
                    $this->data['form']['R_EDAD'] != '' &&
                    $this->data['form']['R_SEXO'] != '' &&
                    $this->data['form']['R_ES_SERVIDOR'] != '' &&
                    $this->data['form']['R_TIPO_DOC'] != ''
                  ){

                    $estadoVariables = true;

                    if($this->data['form']['R_ES_SERVIDOR'] == '1' && $this->data['form']['R_COD_ENTIDAD'] == ''){
                        $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
                        $estadoVariables = false;
                    }
                    if($this->data['form']['R_TEL_CELULAR'] == ''){
                        if(empty($this->data['form']['R_INDICATIVO']) || empty($this->data['form']['R_TEL_FIJO'])){
                            $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
                            $estadoVariables = false;
                        }
                    }
                    if($this->data['form']['R_TIPO_DOC'] == '3' && $this->data['form']['R3_FECHA_EXPE_CC'] == ''){
                        $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
                        $estadoVariables = false;
                    }
                    $arrPers = $this->mpers->consultarPersonas(array('numeDocu' => $this->data['form']['R2_NRO_DOC']));
                    if(count($arrPers) > 0) {
                        $response['mensaje'] = 'Ya existe un usuario registrado con este número de documento.';
                        $estadoVariables = false;
                    }
                    $arrUsua = $this->musua->consultarAdminUsuarios(array('usuario' => $this->data['form']['R_USUARIO']));
                    if(count($arrUsua) > 0) {
                        $response['mensaje'] = 'El correo electrónico ya está registrado en el sistema.';
                        $estadoVariables = false;
                    }

                }else{
                    $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
                }

                if($estadoVariables){
                    if($this->mregis->guardarRegistro($arrDatos)) {

                        $this->load->model('encuesta/modencuesta', 'mencu');
                        $sessionData = array(
                            'codiEncuesta' => $this->mregis->getCodiEncuesta(),
                            'codiVivienda' => $this->mregis->getCodiVivienda(),
                            'codiHogar' => $this->mregis->getCodiHogar(),
                            'id' => $this->mregis->getIdUsuario(),
                            'numeVisita' => 1
                        );
                        $this->session->set_userdata($sessionData);

                        $this->mpers->setCodiEncuesta($this->mregis->getCodiEncuesta());
                        $this->mpers->setCodiVivienda($this->mregis->getCodiVivienda());
                        $this->mpers->setCodiHogar($this->mregis->getCodiHogar());
                        $this->mpers->setCodiPersona($this->mregis->getIdUsuario());


                        $codiEncuesta = $this->mregis->getCodiEncuesta();

                        $response['mensaje'] = 'Se guardó correctamente las respuestas.';

                    } else {
                       $estadoVariables = false;
                    }
                }

                if(!$estadoVariables){
                    $page = 1;

                    $response['codiError'] = 1;

                    if($this->mregis->actualizarEstadoAC($page)) {
                        if($page == $this->data['totalPaginas']) {
                            $response['avance'] = '100%';
                        } else {
                            $response['avance'] = ceil($page * 100/$this->data['totalPaginas']) . '%';
                        }
                    } else {
                        //$response['codiError'] = 5;
                        //$response['mensaje'] = 'No se pudo actualizar el estado de la vivienda en la encuesta.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                    }

                    log_message('error', $this->mregis->getMsgError());
                }

                if($response['avance'] == '100%') {

                    $nombre = $correoElectronico = '';
                    $fechaHoraActual = $this->mregis->consultar_fecha_hora();
                    $fechaActual = substr($fechaHoraActual, 0, 10);
                    $this->load->library('email');
                    $this->load->library('danecrypt');
                    $this->load->model('personas/modpersonas', 'mpers');
                    $this->load->model('usuarios/modusuarios', 'musua');

                    $arrUsua = $this->musua->consultarAdminUsuarios(array('codiEncuesta' => $codiEncuesta));

                    if(count($arrUsua) > 0) {
                        $arrUsua = array_shift($arrUsua);
                        $correoElectronico = $arrUsua['USUARIO'];
                        $contrasena = $arrUsua['CLAVE'];
                    }
                    $arrPers = $this->mpers->consultarPersonasResidentes(array('codiEncuesta' => $codiEncuesta));
                    if(count($arrPers) > 0) {
                        $arrPers = array_shift($arrPers);
                        $nombre = $arrPers['nombre'];
                    }
                    $config = array(
                        'protocol' => 'smtp',
                        'smtp_host' => $this->config->item('smtp_host'),
                        'smtp_port' => $this->config->item('smtp_port'),
                        'smtp_crypto' => $this->config->item('smtp_crypto'),
                        'smtp_user' => $this->config->item('smtp_user'),
                        'smtp_pass' => $this->config->item('smtp_pass'),
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'newline' => "\r\n"
                    );
                    $this->email->initialize($config);
                    $this->email->set_mailtype('html');
                    $this->email->set_newline('rn');
                    $this->data['baseURL'] = substr(base_url(), 0, -1);
                    $this->data['nombreEntidad'] = $this->config->item('nombreEntidad');
                    $this->data['nombreSistema'] = $this->config->item('nombreSistema');
                    $this->data['correoContacto'] = $this->config->item('correoContacto');
                    $this->data['emailPers'] = $correoElectronico;
                    //$this->data['contrasenaPers'] = $this->danecrypt->decode($contrasena);
                    $this->data['nombrePers'] = $nombre;
                    $this->data['nombreUsuario'] = $nombre;
                    $this->data['fecha'] = obtener_texto_fecha(formatear_fecha($fechaActual));
                    $this->email->from($this->config->item('correoContacto'), $this->config->item('nombreEntidad'));
                    $this->email->to($correoElectronico);
                    $this->email->subject('Inscripcion al ' . $this->config->item('nombreSistema') . ' - ' . $this->config->item('nombreEntidad'));
                    $html = $this->load->view('mailSolicitudUsua', $this->data, true);
                    $this->email->message($html);
                    //@todo: Se debe deshabilitar si se esta ejecutando en local
                    if ($this->email->send()) {
                        $response['mensaje'] .= ' y se envió correctamente el correo electrónico a ' . $correoElectronico . ' para recordarle su usuario y contraseña.';
                    } else {
                        $response['codiError'] = 2;
                        $response['mensaje'] .= ' pero no se pudo enviar el correo electrónico a ' . $correoElectronico;
                        log_message('error', $this->mregis->getCodiEncuesta() . '-' . $this->email->print_debugger(array('headers')));
                    }
                    $response['mensaje'] .= '.';

                    $this->session->unset_userdata('page');
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
        $duracion = $postt['duracion'];
        unset($postt['duracion']);
        $this->construirPreguntas();
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('modregistro', 'mregis');

        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //$arrAC = array_shift($arrAC);

        $arrAC = $this->session->userdata();

        if(!empty($arrAC['PAG_REGISTRO'])) {
            $page = $arrAC['PAG_REGISTRO'];
        }

        if($page > 0) {
            $page--;

            if($this->mregis->actualizarEstadoAC($page)) {
                $response['mensaje'] = '';
                $response['avance'] = ceil($page * 100/$this->data['totalPaginas']) . '%';
                $this->session->set_userdata('numeroPagina', $page);
            }
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }


    /**
     * Guarda la informacion del no acepto
     * @author oagarzond
     * @since 2017-02-27
     */
    public function guardarNoAcepto() {
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

        $this->load->model('modregistro', 'mregis');
        $this->load->model('personas/modpersonas', 'mpers');
        $this->load->model('usuarios/modusuarios', 'musua');

        $this->data['form'] = $this->session->all_userdata()['page'];

        $arrDatos['RA2_1NOMBRE'] = $this->data['form']['RA_1ER_NOMBRE'];
        $arrDatos['RA4_1APELLIDO'] = $this->data['form']['RB_1ER_APELLIDO'];
        if(!empty($this->data['form']['RC_2DO_NOMBRE'])){
            $arrDatos['RA3_2NOMBRE'] = $this->data['form']['RC_2DO_NOMBRE'];
        }
        if(!empty($this->data['form']['RD_2DO_APELLIDO'])){
            $arrDatos['RA5_2APELLIDO'] = $this->data['form']['RD_2DO_APELLIDO'];
        }

        $arrDatos['PA_1ER_NOMBRE'] = $this->data['form']['RA_1ER_NOMBRE'];
        $arrDatos['PB_1ER_APELLIDO'] = $this->data['form']['RB_1ER_APELLIDO'];

        if(!empty($this->data['form']['R_TIPO_DOC'])){
            $arrDatos['PA_TIPO_DOC'] = $this->data['form']['R_TIPO_DOC'];
        }
        if(!empty($this->data['form']['R1_TIPO_DOC2'])){
            $arrDatos['PA_TIPO_DOC'] = $this->data['form']['R1_TIPO_DOC2'];
        }
        if(!empty($this->data['form']['R2_NRO_DOC'])){
            $arrDatos['PA1_NRO_DOC'] = $this->data['form']['R2_NRO_DOC'];
        }

        $arrDatos['PA_SABE_FECHA'] = '1';
        $arrDatos['PA1_FECHA_NAC'] =  $this->data['form']['R_FECHA_NAC'];
        $arrDatos['P_EDAD'] = $this->data['form']['R_EDAD'];
        $arrDatos['P_SEXO'] = $this->data['form']['R_SEXO'];

        if(!empty($this->data['form']['R3_FECHA_EXPE_CC'])){
            $arrDatosACP['VALIDA_CEDULA'] = '3';
            $arrDatosACP['FECHA_EXPE_CC'] = $this->data['form']['R3_FECHA_EXPE_CC'];
        }

        $arrDatos['R_ES_SERVIDOR'] = $this->data['form']['R_ES_SERVIDOR'];
        $arrDatos['R_COD_ENTIDAD'] = $this->data['form']['R_COD_ENTIDAD'];

        $arrDatos['R_INDICATIVO'] = $this->data['form']['R_INDICATIVO'];
        $arrDatos['R_TEL_FIJO'] = $this->data['form']['R_TEL_FIJO'];
        $arrDatos['R_TEL_CELULAR'] = $this->data['form']['R_TEL_CELULAR'];

        $arrDatos['R_USUARIO'] = strtolower($this->data['form']['R_USUARIO']);

        $arrDatos['ID_ESTADO_USUA'] = 2;

        $arrDatos['R3_FECHA_EXPE_CC'] = $this->data['form']['R3_FECHA_EXPE_CC'];

        $this->load->library('danecrypt');
        $encryptClave = $this->danecrypt->encode($this->data['form']['R_CLAVE'], $arrDatos['R_USUARIO']);
        $arrDatos['R_CLAVE'] =  $encryptClave;

        $estadoVariables = false;

        if($this->data['form']['RA_1ER_NOMBRE'] != '' &&
            $this->data['form']['RB_1ER_APELLIDO'] != '' &&
            $this->data['form']['R_USUARIO'] != '' &&
            $this->data['form']['R_CLAVE'] != '' &&
            $this->data['form']['R2_NRO_DOC'] != '' &&
            $this->data['form']['R_FECHA_NAC'] != '' &&
            $this->data['form']['R_EDAD'] != '' &&
            $this->data['form']['R_SEXO'] != '' &&
            $this->data['form']['R_ES_SERVIDOR'] != '' &&
            $this->data['form']['R_TIPO_DOC'] != ''
        ){
            $estadoVariables = true;

            if($this->data['form']['R_ES_SERVIDOR'] == '1' && $this->data['form']['R_COD_ENTIDAD'] == ''){
                $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
                $estadoVariables = false;
            }
            if($this->data['form']['R_TEL_CELULAR'] == ''){
                if(empty($this->data['form']['R_INDICATIVO']) || empty($this->data['form']['R_TEL_FIJO'])){
                    $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
                    $estadoVariables = false;
                }
            }
            if($this->data['form']['R_TIPO_DOC'] == '3' && $this->data['form']['R3_FECHA_EXPE_CC'] == ''){
                $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
                $estadoVariables = false;
            }

            $arrPers = $this->mpers->consultarPersonas(array('numeDocu' => $this->data['form']['R2_NRO_DOC']));
            if(count($arrPers) > 0) {
                $response['mensaje'] = 'Ya existe un usuario registrado con este número de documento.';
                $estadoVariables = false;
            }
            $arrUsua = $this->musua->consultarAdminUsuarios(array('usuario' => $this->data['form']['R_USUARIO']));
            if(count($arrUsua) > 0) {
                $response['mensaje'] = 'El correo electrónico ya está registrado en el sistema.';
                $estadoVariables = false;
            }
            }else{
                $response['mensaje'] = 'Se ha presentado un error de conexión. Por favor intente de nuevo.';
            }

        $this->construirPreguntas();

        if($estadoVariables){
            if($this->mregis->guardarRegistro($arrDatos)) {

                $this->load->model('encuesta/modencuesta', 'mencu');
                $sessionData = array(
                    'codiEncuesta' => $this->mregis->getCodiEncuesta(),
                    'codiVivienda' => $this->mregis->getCodiVivienda(),
                    'codiHogar' => $this->mregis->getCodiHogar(),
                    'id' => $this->mregis->getIdUsuario(),
                    'numeVisita' => 1
                );
                $this->session->set_userdata($sessionData);

                $this->mpers->setCodiEncuesta($this->mregis->getCodiEncuesta());
                $this->mpers->setCodiVivienda($this->mregis->getCodiVivienda());
                $this->mpers->setCodiHogar($this->mregis->getCodiHogar());
                $this->mpers->setCodiPersona($this->mregis->getIdUsuario());


                $codiEncuesta = $this->mregis->getCodiEncuesta();

                $response['mensaje'] = 'Se guardó correctamente las respuestas.';

            } else {
               $estadoVariables = false;
            }
        }

        if(!$estadoVariables){
            $page = 1;

            $response['codiError'] = 1;

            if($this->mregis->actualizarEstadoAC($page)) {
                if($page == $this->data['totalPaginas']) {
                    $response['avance'] = '100%';
                } else {
                    $response['avance'] = ceil($page * 100/$this->data['totalPaginas']) . '%';
                }
            } else {
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
            }

            log_message('error', $this->mregis->getMsgError());

            $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));

        }else{
            $this->load->model('modregistro', 'mregis');
            $this->mregis->setCodiEncuesta($this->session->userdata('codiEncuesta'));
            $this->mregis->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mregis->setCodiHogar($this->session->userdata('codiHogar'));
            $this->mregis->setIdUsuario($this->session->userdata('id'));
            if($this->mregis->guardarNoCuenta($this->data)) {
                $response['mensaje'] = 'Gracias por indicarnos la razón por la que no deseas participar.';
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo guardar la razón por la que no deseas participar.';
                log_message('error', 'Codigo de encuesta: ' . $this->mregis->getCodiEncuesta() . '. ' . $this->mregis->getMsgError());
            }

            $this->session->sess_destroy();

            $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
        }
    }

    /**
     * Muestra la pantalla de no acepto las condiciones de la encuesta
     * @author oagarzond
     * @since 2017-02-27
     */
    public function noAcepto() {
        //pr($this->session->all_userdata()); exit;
        $this->data['title'] = 'No acepto';
        $this->data['view'] = 'noAcepto';
        $this->data['avance'] = '0%';
        $this->load->view('layout', $this->data);
    }


   /**
     * Metodo para consultar la información del WS Registraduria y cargar la fecha de expedicion del documento a sesión
     * @author nfforeror
     * @since 2017-02-27
     */
    private function wsValidaCedula($docu=null, $r=false){
        $this->load->model('modregistro', 'mregis');
        $this->load->library('registraduriasoap');
        $this->session->unset_userdata('peticion');
        $this->session->unset_userdata('numeroControl');
        $this->session->unset_userdata('estadoWs');
        $this->session->unset_userdata('estadoData');
        $this->session->unset_userdata('NUIP');
        $this->session->unset_userdata('fechaExpedicion');
        $this->session->unset_userdata('fechaNacimiento');
        $this->session->unset_userdata('primerApellido');
        $this->session->unset_userdata('segundoApellido');
        $this->session->unset_userdata('primerNombre');
        $this->session->unset_userdata('segundoNombre');

        $registro = $this->registraduriasoap->get_cedula(array('DOCUMENTO'=>$docu));
        if (empty($registro)){
            $registro = array();
            $registro['estadoConsulta']['codError'] = '8';
            $registro['estadoConsulta']['descripcion_error'] = 'No hay conexion al WS';
            $registro['datosCedulas']['datos']['codError'] = '8';
        }

        $estadoWs = $registro['estadoConsulta'];
        $data = $registro['datosCedulas']['datos'];
        $ws = array();
        $ws['estadoWs'] = $estadoWs['codError'];
        $ws['estadoData'] = $data['codError'];
        if ($ws['estadoWs'] == 0 && $ws['estadoData'] == 0){
                $ws['NUIP'] = $data['NUIP'];
                $fecha = $data['fechaExpedicion'];
                $ws['fechaExpedicion'] = preg_split('[/]', $fecha);
                $ws['fechaExpedicion']['completa'] = $fecha;
                $ws['fechaNacimiento'] = $data['fechaNacimiento'];
                $ws['primerApellido'] = $data['primerApellido'];
                $particula = is_array($data['particula'])?'':$data['particula'] . ' ';
                $segundoApellido = empty($data['segundoApellido'])?'': $data['segundoApellido'];
                $ws['segundoApellido'] = empty($particula)?$segundoApellido:$particula . $segundoApellido;
                $ws['primerNombre'] = $data['primerNombre'];
                $ws['segundoNombre'] = empty($data['segundoNombre'])?'':$data['segundoNombre'];
        }

        $persistir['NUMERO_DOCUMENTO'] = $docu;
        foreach ($estadoWs as $key => $value) {
            if ($key=='codError')
                $key='codError_ws';
            $persistir[strtoupper($key)] = $value;
        }
        foreach ($data as $key => $value) {
            if(is_array($value)){
                $value = array_shift($value);
            }
            if ($key=='codError')
                $key='codError_dt';
            $persistir[strtoupper($key)] = $value;
        }

        $persistir['NUMERO_DOCUMENTO'] = $docu;
        if ($this->mregis->setConsultaRegistraduria($persistir))
            $ws['peticion'] = $this->mregis->getIdPeticion();
            $ws['numeroControl'] = $estadoWs['numero_control'];
        $this->session->set_userdata($ws);
        if ($r)
            // return $registro;
            if ($ws['estadoWs'] != 0)
                return $ws['estadoWs'];
            return $ws['estadoData'];
    }
}
//EOC