<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de administración para logistica
 * @author oagarzond
 * @since 2017-06-02
 */
class Admin extends MX_Controller {
    private $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = $this->data['msgWelcome'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['header'] = 'navbarAdmin';
        //$this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['classContainer'] = 'container-fluid';
        $this->data['footer'] = 'footer';
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    public function index() {
        $arrFechasDili = $this->config->item('diligenciamiento');
        $restaIni = restar_fechas(date('Y-m-d'), $arrFechasDili['fechaIni']);
        $restaFin = restar_fechas($arrFechasDili['fechaFin'], date('Y-m-d'));
        if($restaIni < 0 || $restaFin < 0) {
            $this->data['view'] = 'finalizado';
            $this->data['header'] = 'header';
            $this->data['footer'] = 'footer';
            $this->data['title'] = 'Tiempo de diligenciamiento terminado';
            $this->load->view('layout', $this->data);
            return false;
        }
        $this->login();
    }

    /**
     * Valida si el usuario actual es administrador
     * @author oagarzond
     * @since 2017-06-08
     */
    private function esAdmin() {
        $esAdmin = $this->session->userdata('esAdmin');
        if(empty($esAdmin)) {
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
        $this->data['view'] = 'login';
        $this->data['title'] = 'Módulo de administración';
        //$this->data['classContainer'] = 'container';
        $this->data['header'] = 'header';
        $this->load->library('danecrypt');
        $this->load->model('modform', 'mf');
        $this->load->model('personas/modpersonas', 'mpers');
        $this->load->model('usuarios/modusuarios', 'musua');
        $this->data['arrJS'][] = 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit';
        //$this->data['arrJS'][] = 'https://www.google.com/recaptcha/api.js?hl=es';

        $this->data['recaptcha'] = '';
        $tipoUsua = $this->session->userdata('tipoUsua');
        if(!empty($tipoUsua) && $tipoUsua != 'A') {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url(), '', 'refresh');
        }

        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if($nombre_campo == 'g-recaptcha-response' && !empty($postt['g-recaptcha-response'])) {
                    $this->data['recaptcha'] = $postt['g-recaptcha-response'];
                    continue;
                }
                if (!is_array($postt[$nombre_campo])) {
                    $this->data[$nombre_campo] = $valor;
                }
            }

            $this->load->library('danecrypt');
            $encryptClave = $this->danecrypt->encode(md5($this->data['contrasena']), $this->data['usuario_admin']);

            $userAuth = $this->userAuth(strtolower($this->data['usuario_admin']), $encryptClave , $this->data['recaptcha']);
            // $userAuth = $this->userAuth(strtolower($this->data['usuario_soporte']), hash('sha512', md5($this->data['contrasena']) . strtolower($this->data['usuario_soporte'])) , $this->data['recaptcha']);
            if($userAuth['result']) {
                $this->session->set_flashdata('msgWelcome', 'Bienvenido(a) ' . mayuscula_inicial($this->session->userdata('nombre')));

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
     * @author oagarzond
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
        // if ($this->musua->validarUsuario($usua, $encrypt, 'A')) {
        if ($this->musua->validarUsuario($usua, $pass, 'A')) {
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
     * @since 2017-06-02
     */
    public function inicio() {
        //pr($this->session->all_userdata()); exit;
        $this->esAdmin();
        $this->data['view'] = 'inicio';
        $this->data['title'] = 'Inicio';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item active">Administración</a></li>
        </ol>';
        $this->load->view('layout', $this->data);
    }

    /**
     * Cierra la sesion y sale del aplicativo
     * @author dmdiazf
     * @author oagarzond
     * @since 2015-10-22
     */
    public function salir() {
        $this->load->model('encuesta/modencuesta', 'mencu');
        if ($this->session->userdata('auth')){
            $this->session->unset_userdata('auth');
            $this->session->sess_destroy();
            session_destroy();
        }
        redirect(base_url($this->data['module']), 'location', 301);
    }

    /**
     * Permite crear usuarios para el modulo de soporte
     * @author oagarzond
     * @since 2017-06-02
     */
    public function verUsuarios() {
        $this->data['view'] = 'verUsuarios';
        $this->data['title'] = 'Ver encuestados';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item"><a href="' . base_url('admin/inicio') . '">Administración</a></li>
            <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
        </ol>';
        $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
        $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');

        $this->load->model('modform', 'mform');

        $this->data['arrTipoDocuPers'] = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
        $this->data['arrTipoUsua'] = $this->mform->consultarParamValores(array('idDominio' => 3));
        $this->data['arrEstadoUsua'] = $this->mform->consultarParamValores(array('idDominio' => 2));
        $this->load->view('layout', $this->data);
    }

    /**
     * Permite crear usuarios para el modulo de soporte
     * @author oagarzond
     * @since 2017-06-02
     */
    public function agregarUsuario() {
        $this->esAdmin();
        $this->data['view'] = 'agregarUsuario';
        $this->data['title'] = 'Agregar usuario';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item"><a href="' . base_url('admin/inicio') . '">Administración</a></li>
            <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
        </ol>';
        $this->load->model("modform", "mform");
        $this->data['arrTipoUsua'] = $this->mform->consultarParamValores(array('idDominio' => 3, 'estado' => 1));
        $this->load->view('layout', $this->data);
    }

    /**
     * Permite agregar solicitud para la lista de solicitudes
     * @author oagarzond
     * @since 2017-06-17
     */
    public function agregarSolicitud() {
        $this->esAdmin();
        $this->data['view'] = 'agregarSolicitud';
        $this->data['title'] = 'Agregar solicitud';
        $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item"><a href="' . base_url('admin/inicio') . '">Administración</a></li>
            <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
        </ol>';
        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->data['arrTipoSolicitudes'] = $this->mencu->consultarTipoSolicitudes(array());
        //pr($this->data); exit;
        $this->load->view('layout', $this->data);
    }

    /**
     * Guarda la solicitud del soporte
     * @author oagarzond
     * @since 2017-06-15
     */
    public function guardarSolicitud() {
        $this->esAdmin();
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
        $arrCampos = array(
            'tipoSolicitud' => 'ID_TIPO_SOLICITUD',
            'descripcion' => 'DESC_SOLICITUD',
            'respuesta' => 'RESPUESTA',
            'observacion' => 'OBSERVACION'
        );
        foreach ($postt as $nombre_campo => $valor) {
            $this->data['form'][$arrCampos[$nombre_campo]] = $valor;
        }

        if(empty($this->data['form']['ID_TIPO_SOLICITUD'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió el tipo de solicitud.';
        }
        //pr($this->data['form']); exit;
        if($response['codiError'] == 0) {
            $this->load->model("encuesta/modencuesta", "mencu");
            if(!empty($this->data['form'])) {
                if($this->mencu->agregarSolicitud($this->data['form']))  {
                    $response["mensaje"] = "Se guardó correctamente la información de la solicitud.";
                } else {
                    $response['codiError'] = 3;
                    $response["mensaje"] = "No se pudo guardar correctamente la información de la solicitud.";
                    log_message('error', $response["mensaje"] . $this->mencu->getMsgError());
                }
            } else {
                $response["codiError"] = 2;
                $response["mensaje"] = "No se definió correctamente los datos para agregar la solicitud.";
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }
}
//EOC