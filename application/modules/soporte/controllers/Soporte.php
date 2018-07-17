<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de soporte para logistica
 * @author oagarzond
 * @since 2017-06-02
 */
class Soporte extends MX_Controller {
    private $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = $this->data['msgWelcome'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['header'] = 'navbarSoporte';
        $this->data['classContainer'] = 'container-fluid';
        $this->data['footer'] = 'footer';
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->db->close();
        $this->db = $this->load->database('soporte', true);
    }

    public function index() {
        $arrFechasDili = $this->config->item('diligenciamiento');
        $restaIni = restar_fechas(date('Y-m-d'), $arrFechasDili['fechaIni']);
        $restaFin = restar_fechas($arrFechasDili['fechaFin'], date('Y-m-d'));
        // if($restaIni < 0 || $restaFin < 0) {
        //     $this->data['view'] = 'finalizado';
        //     $this->data['header'] = 'header';
        //     $this->data['footer'] = 'footer';
        //     $this->data['title'] = 'Tiempo de diligenciamiento terminado';
        //     $this->load->view('layout', $this->data);
        //     return false;
        // }


        if($this->session->userdata('auth') == 'OK'){
            redirect('soporte/digitacion');
        }else{
            $this->login();
        }
    }

    /**
     * Valida si el usuario actual es administrador o de soporte
     * @author oagarzond
     * @since 2017-06-08
     */
    private function esAdminSoporte() {
        $esAdmin = $this->session->userdata('esAdmin');
        $esSoporte = $this->session->userdata('esSoporte');
        if(empty($esAdmin) && empty($esSoporte)) {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url('admin'), '', 'refresh');
        }
    }

    /**
     * Muestra la pagina de login del modulo
     * @author oagarzond
     * @since 2017-06-02
     */
    public function login() {
        //pr($this->session->all_userdata()); exit;
        //$this->data['arrJS'][] = 'http://192.168.1.200/dimpe/cnpv_v3/js/bootstrap/jquery-1.11.3.min.js';
        //$this->data['arrJS'][] = 'http://192.168.1.200/dimpe/cnpv_v3/js/jqueryui/jquery-ui.min.js';
        //$this->data['arrJS'][] = 'http://192.168.1.200/dimpe/cnpv_v3/js/bootstrap/bootstrap.min.js';
        //$this->data['arrJS'][] = 'http://192.168.1.200/dimpe/cnpv_v3/js/jquery.validator/jquery.validate.min.js';

        $this->data['view'] = 'login';
        $this->data['title'] = 'Módulo de soporte';
        //$this->data['classContainer'] = 'container';
        $this->data['header'] = 'header';
        $this->load->library('danecrypt');
        $this->load->model('modform', 'mf');
        $this->load->model('personas/modpersonas', 'mpers');
        $this->load->model('usuarios/modusuarios', 'musua');
        $this->data['arrJS'][] = 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit';
        $this->data["arrJS"][] = base_url_js('login/md5.js');

        //$this->data['arrJS'][] = 'https://www.google.com/recaptcha/api.js?hl=es';

        $this->data['recaptcha'] = '';
        $tipoUsua = $this->session->userdata('tipoUsua');
        if(!empty($tipoUsua) && !in_array($tipoUsua, array('A', 'S'))) {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url(), '', 'refresh');
        }

        $postt = $this->input->post(null, true);
        //var_dump($postt);die;
        if (!empty($postt) && count($postt) > 0) {
            // die();
            foreach ($postt as $nombre_campo => $valor) {
                if($nombre_campo == 'g-recaptcha-response' && !empty($postt['g-recaptcha-response'])) {
                    $this->data['recaptcha'] = $postt['g-recaptcha-response'];
                    continue;
                }
                if (!is_array($postt[$nombre_campo])) {
                    $this->data[$nombre_campo] = $valor;
                }
            }
            //$userAuth = $this->userAuth($this->data['usuario_soporte'], $this->data['contrasena'], $this->data['recaptcha']);
            $userAuth = $this->userAuth(strtolower($this->data['usuario_soporte']), hash('sha512', ($this->data['contrasena']) . strtolower($this->data['usuario_soporte'])) , $this->data['recaptcha']);
            if($userAuth['result']) {
                $this->session->set_flashdata('msgWelcome', 'Bienvenido(a) ' . mayuscula_inicial($this->session->userdata('nombre')));
                if (strcmp($this->session->tipoUsua, 'D') === 0){
                    redirect('soporte/digitacion');
                }
                redirect($userAuth['url']);
            } else {
                $this->data['msgError'] = $userAuth['message'];
            }
            $this->load->view('layout', $this->data);
        } else {
            $this->load->view('layout', $this->data);
        }
    }

    /**
     * Validacion y autenticacion de usuarios
     * @author dmdiazf
     * @since 2015-11-10
     */
    public function userAuth($usuario, $contrasena, $recaptcha) {
        $this->data['message'] = '';
        $this->data['result'] = false;
        $this->data['url'] = base_url('soporte');

        /*if(empty($recaptcha)) {
            $this->data['result'] = false;
            $this->data['message'] = utf8_encode('<strong>Por favor verifica que no eres un robot.</strong>');
            return $this->data;
        }*/

        $usua = trim(str_replace(array("<", ">", "[", "]", "^", "'"), "", $usuario));
        $pass = trim(str_replace(array("<", ">", "[", "]", "^", "'"), "", $contrasena));
        // $encrypt = $this->danecrypt->encode($pass);
        // if ($this->musua->validarUsuario($usua, $encrypt, array('A', 'S'))) {
        if ($this->musua->validarUsuario($usua, $pass, array('A', 'S', 'D'))) {
            $this->data['result'] = true;
            if ($this->data['result']) {
                $this->data['url'] = base_url($this->data['module'] . '/inicio');
            }
        } else {
            $this->data['result'] = false;
            $this->data['message'] = 'Usuario y/o contrase&ntilde;a errados.</strong> Intente nuevamente.';
        }
        return $this->data;
    }

    /**
     * Muestra la pagina de inicio del modulo
     * @author oagarzond
     * @since 2016-06-02
     */
    public function inicio() {
        //pr($this->session->all_userdata()); exit;
        //$this->esSoporte();
        $this->data['view'] = 'inicio';
        $this->data['title'] = 'Inicio';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item active">Soporte</li>
        </ol>';
        $this->load->view('layout', $this->data);
    }

    /**
     * Cierra la sesion y sale del aplicativo
     * @author dmdiazf
     * @since 2015-10-22
     */
    public function salir() {
        $this->load->model('encuesta/modencuesta', 'mencu');
        if ($this->session->userdata('auth')) {
            $this->session->unset_userdata('auth');
            $this->session->sess_destroy();
            session_destroy();
        }
        redirect(base_url($this->data['module']), 'location', 301);
    }

    /**
     * Permite crear usuarios para el modulo de soporte
     * @author oagarzond
     * @since 2016-06-02
     */
    public function verUsuarios() {
        $this->data['view'] = 'verUsuarios';
        $this->data['title'] = 'Ver encuestados';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item"><a href="' . base_url('soporte/inicio') . '">Soporte</a></li>
            <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
        </ol>';
        $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
        $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');

        $this->load->model('modform', 'mform');

        $this->data['arrTipoDocuPers'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
        $this->data['arrEstados'] = $this->mform->consultarParamValores(array('idDominio' => 1));
        $this->load->view('layout', $this->data);
    }

    /**
     * Permite crear usuarios para el modulo de soporte
     * @author oagarzond
     * @since 2016-06-02
     */
    public function verPersonas() {
        $this->data['view'] = 'verPersonas';
        $this->data['title'] = 'Ver personas';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item"><a href="' . base_url('soporte/inicio') . '">Soporte</a></li>
            <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
        </ol>';
        $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
        $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');

        $this->load->model('modform', 'mform');

        $this->data['arrTipoDocuPers'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
        $this->load->view('layout', $this->data);
    }

    /**
     * Permite crear usuarios para el modulo de soporte
     * @author oagarzond
     * @since 2016-06-02
     */
    public function faq() {
        $this->data['view'] = 'faq';
        $this->data['title'] = 'Preguntas frecuentes';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item"><a href="' . base_url('soporte/inicio') . '">Soporte</a></li>
            <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
        </ol>';

        $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
        $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');

        $this->load->model('encuesta/modencuesta', 'mencu');

        $this->data['arrTipoSolicitudes'] = $this->mencu->consultarTipoSolicitudes(array());
        $this->load->view('layout', $this->data);
    }

    /**
     * Muestra la lista de solicitudes
     * @author oagarzond
     * @since 2017-06-15
     */
    public function verSolicitudes() {
        $this->load->model("encuesta/modencuesta", "mencu");

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['data'][0]['tipo'] = '';
        $response['data'][0]['respuesta'] = '';
        $response['data'][0]['observacion'] = '';

        $arrParam['estado'] = 1;
        for ($i = 1; $i < 20; $i++) {
            $valor = $this->uri->segment($i);
            if ($i == 3 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                if($valor == 'A'){
                    //unset($arrParam['tieneCodiEncuesta']);
                }
            }
            if ($i == 4 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $arrParam['tipo'] = urldecode($valor);
            }
        }

        $arrSolicitudes = $this->mencu->consultarSolicitudes($arrParam);
        if(count($arrSolicitudes) > 0) {
            foreach ($arrSolicitudes as $ks => $vs) {
                $response['data'][$ks]['tipo'] = $vs['DESC_TIPO_SOLICITUD'];
                $response['data'][$ks]['respuesta'] = $vs['RESPUESTA'];
                $response['data'][$ks]['observacion'] = $vs['OBSERVACION'];
            }
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se encontraron solicitudes.';
        }

        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Se consulta y/o se construye el archivo de preguntas con sus opciones
     * @author oagarzond
     * @param   String  $tabla      Tabla asociada de la pregunta
     * @param   String  $pagina     Pagina de la pregunta
     * @return Array    $preguntas Lista de preguntas con parametros
     * @since 2017-08-10
     */
    private function consultarPreguntas($tabla = '', $pagina = '') {
        $preguntas = array();

        $base_dir = substr(base_dir(), 0, -1) . '//files/';
        $filename = 'preguntas_' . $this->config->item("tipoFormulario");
        $extension = '.json';
        $path = $base_dir . $filename . $extension;
        //if (!file_exists($path)) {
            $this->load->model("modform", "mform");
            $arrPreguntas = $this->mform->consultarPreguntas();
            if(!empty($arrPreguntas) > 0) {
                $fp = fopen($path, 'w');
                fwrite($fp, json_encode($arrPreguntas));
                fclose($fp);
                if(!empty($tabla)) {
                    if(!empty($pagina)) {
                        $preguntas = $arrPreguntas[$tabla][$pagina];
                    } else {
                        $preguntas = $arrPreguntas[$tabla];
                    }
                } else {
                    $preguntas = $arrPreguntas;
                }
            }
        //}
        $preguntas = extraer_preguntas($tabla, $pagina);
        return $preguntas;
    }
}
//EOC