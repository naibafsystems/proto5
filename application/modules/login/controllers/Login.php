<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de login
 * @author oagarzond
 * @since 2016-06-10
 */
class Login extends MX_Controller {
    var $data;
    private $redis;

    public function __construct() {
        parent::__construct();
        $this->removeCache();
        $this->data = array();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = $this->data['msgWelcome'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['footer'] = 'footer';
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    /**
     * Muestra la pagina login
     * @author oagarzond
     * @since 2016-06-10
     */
    public function index() {
        //pr($this->session->all_userdata());
        //exit;
        $this->session->unset_userdata("USUARIO");
        $this->session->unset_userdata("TOKEN");
        $this->session->unset_userdata("ID_USUARIO");

        $this->data["arrJS"][] = base_url_js('login/md5.js');

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
        $this->data['view'] = 'login';
        $this->data['title'] = 'Iniciar sesión';
        $this->data['classContainer'] = 'container-fluid';
        $this->load->library('danecrypt');
        $this->load->model('modform', 'mform');
        $this->load->model('usuarios/modusuarios', 'musua');
        // Se consulta para iniciarlizar los dominios que se usan en redis
        // Si se reinicia el servidor se debe ingresar al login por primera vez
        $arrDominiosRedis = explode(',', $this->config->item('redis_dominios'));
        foreach ($arrDominiosRedis as $vdr) {
            $this->mform->consultarRespuestaDominio(array('idDominio' => $vdr));
        }

        if(!empty($this->session->userdata("INTENTOS")) && $this->session->userdata("INTENTOS") >= 2){
           $this->data['arrJS'][] = 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit';
        }

        $this->data['recaptcha'] = '';
        $API_key = 'AIzaSyDgCdKZzuloyBrC26qh9f5HUIJOPnxI4sw';
        $channelID  = 'UCEyfvXnyHb4kh70fm2FenVA';
        $maxResults = 10;
        $API_URL = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=' . $channelID . '&maxResults=' . $maxResults . '&key=' . $API_key;
        //var_dump($API_URL); exit;
        //$videoList = json_decode(file_get_contents($API_URL));
        //pr($videoList); exit;

        $postt = $this->input->post(NULL, TRUE);
        if (!empty($postt) && count($postt) > 0) {
            // pr($postt); die();
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
            $encryptClave = $this->danecrypt->encode($this->data['contrasena'], $this->data['usuario']);

            $result = $this->validarUsuario(strtolower($this->data['usuario']), $encryptClave, $this->data['recaptcha']);
             if($result) {
                $this->load->model('encuesta/modencuesta', 'mencu');
                $this->mencu->actualizarIp();
                redirect($this->data['url']);
            }
        }
        $this->load->view('layout', $this->data);
    }

    /**
     * Validacion de usuario y creacion de variables de sesion
     * @author oagarzond
     * @since 2017-07-24
     */
    private function validarUsuario($usuario, $contrasena, $recaptcha = '') {
        if(!empty($usuario) && !empty($contrasena)) {
            try {
                $userAuth = $this->userAuth($usuario, $contrasena, $recaptcha);
                if($userAuth['result']) {

                    $this->session->unset_userdata('INTENTOS');

                    $this->load->model('encuesta/modencuesta', 'mencu');
                    $this->load->model('hogar/modhogar', 'mhogar');
                    $this->load->model('personas/modpersonas', 'mpers');
                    $this->data['idUsua'] = $this->session->userdata('id');
                    $this->data['codiEncuesta'] = $this->session->userdata('codiEncuesta');
                    $arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $this->data['codiEncuesta']));
                    if(count($arrAC) > 0) {
                        $sessionData['estado'] = $arrAC[0]['ID_ESTADO_AC'];
                        // Se almacena en sesion las paginas para no consultar cada vez que recarga la pagina
                        $sessionData['paginaUbicacion'] = (!empty($arrAC[0]['PAG_UBICACION'])) ? $arrAC[0]['PAG_UBICACION']: 1;
                        $sessionData['fechaFinUbi'] = $arrAC[0]['FECHA_FIN_UBI'];
                        $sessionData['paginaVivienda'] = (!empty($arrAC[0]['PAG_VIVIENDA'])) ? $arrAC[0]['PAG_VIVIENDA']: 1;
                        $sessionData['fechaFinVivi'] = $arrAC[0]['FECHA_FIN_VIVI'];
                        $sessionData['paginaHogar'] = (!empty($arrAC[0]['PAG_HOGAR'])) ? $arrAC[0]['PAG_HOGAR']: 1;
                        $sessionData['fechaFinHogar'] = $arrAC[0]['FECHA_FIN_HOG'];
                        $sessionData['fechaFinPers'] = $arrAC[0]['FECHA_FIN_PERS'];
                        $sessionData['fechaCertificado'] = $arrAC[0]['FECHA_CERTIFICADO'];
                        $fecha = $arrAC[0]['FECHA_INSCRIPCION'];
                        $fecha5Anios = date('Y-m-d', strtotime('-5 years', strtotime(formatear_fecha($fecha))));
                        $temp5Anios = explode('-', $fecha5Anios);
                        $fecha1Anio = date('Y-m-d', strtotime('-1 years', strtotime(formatear_fecha($fecha))));
                        $temp1Anio = explode('-', $fecha1Anio);
                        $sessionData['fechaInscripcion'] = $arrAC[0]['FECHA_INSCRIPCION'];
                        $sessionData['texto5Anios'] = obtener_texto_mes($temp5Anios[1]) . ' de ' . $temp5Anios[0];
                        $sessionData['texto1Anio'] = obtener_texto_mes($temp1Anio[1]) . ' de ' . $temp1Anio[0];
                    }
                    $arrHogar = $this->mhogar->consultarHogar(array('codiEncuesta' => $this->data['codiEncuesta']));
                    if(count($arrHogar) > 0) {
                        $this->data['codiVivienda'] = $sessionData['codiVivienda'] = $arrHogar[0]['ID_VIVIENDA'];
                        $this->data['codiHogar'] = $sessionData['codiHogar'] = $arrHogar[0]['ID_HOGAR'];
                    }
                    $arrPers = $this->mpers->consultarPersonasResidentes(array('codiEncuesta' => $this->data['codiEncuesta']));
                    if(count($arrPers) > 0) {
                        $sessionData['idPers'] = $arrPers[0]['ID_PERSONA_RESIDENTE'];
                        $sessionData['nombre'] = $arrPers[0]['nombre'];
                        if(empty($userAuth['codiResidente'])) {
                            $this->musua->setCodiUsuario($this->data['idUsua']);
                            if(!$this->musua->actualizarAdminUsuarios(array('idPers' => $arrPers[0]['ID_PERSONA_RESIDENTE']))) {
                                $this->data['msgError'] = 'No se pudo actualizar correctamente la información del usuario.';
                                throw new Exception($this->data['msgError'], 0);
                                log_message('error', 'Codigo de encuesta: ' . $this->data['codiEncuesta'] . '. ' . $this->musua->getMsgError());
                            }
                        }
                    }
                    if(!empty($sessionData)) {
                        $this->session->set_userdata($sessionData);
                    }
                    if(!$this->mencu->guardarEntrevista($this->data)) {
                        throw new Exception($this->mencu->getMsgError(), 1);
                    } else {
                        $sessionData = array(
                            'numeEntrevista' => $this->mencu->getNumeEntrevista(),
                            'numeVisita' => $this->mencu->getNumeVisita()
                        );
                        $this->session->set_userdata($sessionData);
                        $this->session->set_flashdata('msgWelcome', '¡Bienvenido(a) ' . mayuscula_inicial($this->session->userdata('nombre')) . ' al eCenso!');
                        log_message('error', 'Codigo de encuesta: ' . $this->data['codiEncuesta'] . '. Se logueo correctamente el usuario.');
                        $this->session->unset_userdata('mostrarFormRegistro');
                        $this->data['url'] = $userAuth['url'];
                        $this->consultarPreguntas();
                    }
                } else {
                    if(empty($this->session->userdata("INTENTOS"))){
                        $this->session->set_userdata("INTENTOS", 1);
                    }else{
                        $this->session->set_userdata("INTENTOS", $this->session->userdata("INTENTOS") + 1);
                    }
                    throw new Exception($userAuth['message'], 0);
                }
                return true;
            } catch (Exception $e) {
                //$this->data['msgError'] = 'Usuario: ' . $this->data['usuario'] . ', mensaje: ' . $e->getMessage();
                $this->data['msgError'] = $e->getMessage();
                log_message('error', 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . 'Usuario: ' . $this->data['usuario'] . ', mensaje: ' . $e->getMessage() . '</strong>');
                return false;
            }
        } else {
            $this->data['msgError'] = 'Usuario y/o contrase&ntilde;a errados.</strong> Intente nuevamente.';
            return false;
        }
    }

    /**
     * Validacion y autenticacion de usuarios
     * @author dmdiazf
     * @since 2015-11-10
     */
    private function userAuth($usuario = '', $contrasena = '', $recaptcha = '') {
        $this->data['message'] = '';
        $this->data['result'] = false;
        $this->data['url'] = base_url($this->data['module']);

        /*if(empty($recaptcha)) {
            $this->data['result'] = false;
            $this->data['message'] = utf8_encode('<strong>Por favor verifica que no eres un robot.</strong>');
            return $this->data;
        }*/

        $usua = trim(str_replace(array("<", ">", "[", "]", "^", "'"), "", $usuario));
        $pass = trim(str_replace(array("<", ">", "[", "]", "^", "'"), "", $contrasena));
        // $encrypt = $this->danecrypt->encode($pass);
        // if ($this->musua->validarUsuario($usua, $encrypt, 'C')) {

        if ($this->musua->validarUsuario($usua, $pass, 'C')) {
            $this->data['codiResidente'] = $this->musua->getCodiResidente();
            $this->data['result'] = true;
            if ($this->data['result']) {
                $this->data['url'] = base_url('inicio');
            }
        } else {
            $this->data['result'] = false;
            $this->data['message'] = 'Usuario y/o contrase&ntilde;a errados.</strong> Intente nuevamente.';
        }
        return $this->data;
    }

    /**
     * Se loguea desde el registro para iniciar encuesta
     * @author oagarzond
     * @since 2017-07-24
     */
    public function iniciar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = $response['url'] = '';
        $codiEncuesta = 0;
        /*$postt = $this->input->post(NULL, TRUE);
        //pr($postt); exit;
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        } else {
            $codiEncuesta = $postt['encuesta'];
        }*/
        // pr($this->session->userdata()); exit;
        $codiEncuesta = (!empty($this->session->userdata('codiEncuesta'))) ? $this->session->userdata('codiEncuesta'): 0;
        if($codiEncuesta > 0) {
            $this->load->model('usuarios/modusuarios', 'musua');

            $arrUsua = $this->musua->consultarAdminUsuarios(array('codiEncuesta' => $this->session->userdata('codiEncuesta')));
            if(count($arrUsua) > 0) {
                $arrUsua = array_shift($arrUsua);
                //$this->load->library('danecrypt');
                //$clave = $this->danecrypt->decode($arrUsua['CLAVE']);
                $clave = $arrUsua['CLAVE'];
                $result = $this->validarUsuario($arrUsua['USUARIO'], $clave);
                if($result) {
                    $response['url'] = $this->data['url'];
                    $this->consultarPreguntas();
                }
            } else {
                $response['mensaje'] = 'No se encontró información del usuario para el código de encuesta.';
                $response['codiError'] = 2;
            }
        } else {
            $response['mensaje'] = 'No se encontró información para el código de la encuesta.';
            $response['codiError'] = 1;
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Valida si hay sesion activa
     * @author oagarzond
     * @since  2016-06-10
     */
    public function validaSesion() {
        //si no es una petición ajax mostramos un error 403
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $usuario = $this->session->userdata('id');
        $msg = (empty($usuario)) ? 'Error': '-ok-';
        $this->output->set_content_type('text/plain', 'utf-8')->set_output($msg);
    }

    /**
     * Valida si hay sesion activa
     * @author oagarzond
     * @since  2017-03-03
     */
    public function removeCache() {
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
    }

    /**
     * Borra las llaves del Redis
     * Se deben volver a crear al llamar el modulo de Login/index
     * @author oagarzond
     * @since  2017-12-04
     */
    public function removeRedis() {
        //require_once APPPATH . 'libraries/predis/src/Autoloader.php';

        //Predis\Autoloader::register();
        //$this->redis = new Predis\Client();
        /*$this->redis = new Predis\Client([
            'scheme' => $this->config->item('redis_scheme'),
            'host'   => $this->config->item('redis_host'),
            'port'   => $this->config->item('redis_port'),
            'password' => $this->config->item('redis_password')
        ]);*/
        $this->redis = new Redis();
        $this->redis->connect($this->config->item('redis_host'), $this->config->item('redis_port'));
        $this->redis->auth($this->config->item('redis_password'));
        $this->redis->select($this->config->item('redis_database'));
        //$this->redis->del('Preguntas', 'preguntas');

        $this->redis->flushall();

        // $varRedis = $this->redis->keys("*");
        // pr($varRedis);

        // Se consulta para iniciarlizar los dominios que se usan en redis
        // Si se reinicia el servidor se debe ingresar al login por primera vez
        $arrDominiosRedis = explode(',', $this->config->item('redis_dominios'));

        /*Se carga el modelo modelForm para las conultas*/
        $this->load->model('modform', 'mform');

        /*Carga de los dominios bases para la aplicación*/
        foreach ($arrDominiosRedis as $vdr) {
            // pr($vdr);
            $this->mform->redisConsultarRespuestaDominio(array('idDominio' => $vdr));
        }

        /*cargar la lista de departamentos desde redis y consultar sus municipios asociados para todos los departamentos*/
        $deptos = json_decode($this->redis->get('dominio_D1'));
        foreach ($deptos as $key => $value) {
            // pr($value->ID_RESPUESTA_DOMINIO);
            $lista = $this->mform->redisConsultarRespuestaDominio(array('idDominio' => 2, 'idPadre' => $value->ID));
        }

        // /*carga del dominio 90 localidades comunas // 91 centros poblados */
        // $this->mform->redisConsultarRespuestaDominio(array('idDominio' => '90'));
        // $this->mform->redisConsultarRespuestaDominio(array('idDominio' => '91'));

        // eliminar una key redis
        // $this->redis->delete('preguntas');

        // pr($this->redis->keys("*"));
    }

    /**
     * Cierra la sesion y sale del aplicativo
     * @author dmdiazf
     * @since 2015-10-22
     */
    public function salir() {
        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->data['codiEncuesta'] = $this->session->userdata('codiEncuesta');
        $this->data['numeVisita'] = $this->session->userdata('numeVisita');
        if(!$this->mencu->registrarSalida($this->data['codiEncuesta'], $this->data['numeVisita'])) {
            log_message('error', $this->mencu->getMsgError());
        }
        if ($this->session->userdata('auth')){
            $this->session->unset_userdata('auth');
            $this->session->sess_destroy();
            //session_destroy();
        }
        $this->session->sess_destroy();
        redirect(base_url(), 'location', 301);
    }

    /**
     * Muestra la pagina para recuperar la contrasena
     * @author oagarzond
     * @since 2016-07-06
     */
    public function recuperarContrasena($mensaje = '') {

        $this->data['title'] = 'Recordar contraseña';
        $this->data['view'] = 'reminder';

        if(!empty($this->session->userdata("INTENTOSRESTAURAR")) && $this->session->userdata("INTENTOSRESTAURAR") >= 3){
           $this->data['arrJS'][] = 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit';
        }

        if(empty($this->session->userdata("INTENTOSRESTAURAR"))){
            $this->session->set_userdata("INTENTOSRESTAURAR", 1);
        }else{
            $this->session->set_userdata("INTENTOSRESTAURAR", $this->session->userdata("INTENTOSRESTAURAR") + 1);
        }

        if($mensaje !== ''){
            $this->data['codiError'] = 1;
            $this->data['msgError'] = 'El enlace usado no es valido o ya ha sido utilizado, por favor genere uno nuevo.';
        }else{
            $this->data['codiError'] = 0;
        }

        $token = $this->obtenToken(15);

        $postt = $this->input->post();

        if (!empty($postt) && count($postt) > 0) {
            try {
                if (isset($postt['usuario']) && !empty($postt['usuario'])) {
                    $email = strtolower($postt['usuario']);
                }

                if(!empty($email)) {
                    $this->load->library('danecrypt');
                    $this->load->library('email');
                    $this->load->model('usuarios/modusuarios', 'musua');

                    $arrUsua = $this->musua->consultarAdminUsuarios(array('usuario' => $email));
                    if(count($arrUsua) == 0) {
                        $this->data['msgSuccess'] = '<strong>Mensaje enviado.</strong> El enlace de restauraci&oacute;n de contrase&ntilde;a ha sido enviado a la direcci&oacute;n de correo indicada.';
                        throw new Exception($this->data['msgError'], 0);
                    }
                } else {
                    $this->data['msgSuccess'] = '<strong>Mensaje enviado.</strong> El enlace de restauraci&oacute;n de contrase&ntilde;a ha sido enviado a la direcci&oacute;n de correo indicada.';
                    throw new Exception($this->data['msgError'], 1);
                }

                $nombre = '';
                $fechaHoraActual = $this->musua->consultar_fecha_hora();
                $fechaActual = substr($fechaHoraActual, 0, 10);
                $arrUsua = array_shift($arrUsua);
                if(!empty($arrUsua['ID_PERSONA_RESIDENTE'])) {
                    $this->load->model('personas/modpersonas', 'mpers');
                    $arrParam = array(
                        'codiEncuesta' => $arrUsua['COD_ENCUESTAS'],
                        'idPers' => $arrUsua['ID_PERSONA_RESIDENTE']
                    );
                    $arrPers = $this->mpers->consultarPersonasResidentes($arrParam);
                    if(count($arrPers) > 0) {
                        $arrPers = array_shift($arrPers);
                        $nombre = $arrPers['nombre'];
                    }
                } else {
                    $nombre = $arrUsua['NOMBRES'] . ' ' . $arrUsua['APELLIDOS'];
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
                //$this->data['baseURL'] = substr(base_url(), 0, -1);
                $this->data['nombreEntidad'] = $this->config->item('nombreEntidad');
                $this->data['nombreSistema'] = $this->config->item('nombreSistema');
                $this->data['correoContacto'] = $this->config->item('correoContacto');
                $this->data['email'] = $this->data['usuario'] = $arrUsua['USUARIO'];

                $this->data['baseURL'] = base_url() . "login/cambiarContrasena/" . md5($this->data['email'] . $token);

                // $this->data['password'] = '';
                //$this->data['password'] = $this->danecrypt->decode($arrUsua['CLAVE']);
                $this->data['nombreUsuario'] = $nombre;
                $this->data['fecha'] = obtener_texto_fecha(formatear_fecha($fechaActual));
                $this->email->from($this->config->item('correoContacto'), $this->config->item('nombreEntidad'));
                //$this->email->to('oagarzond@dane.gov.co');
                $this->email->to($email);
                $this->email->subject('Restaurar contraseña - ' . $this->config->item('nombreSistema') . ' - ' . $this->config->item('nombreEntidad'));
                $html = $this->load->view('mailRecordatorioUsua', $this->data, true);
                $this->email->message($html);
                //var_dump($this->email->print_debugger()); exit;
                if ($this->email->send()) {
                    $this->data['msgSuccess'] = '<strong>Mensaje enviado.</strong> El enlace de restauraci&oacute;n de contrase&ntilde;a ha sido enviado a la direcci&oacute;n de correo indicada.';

                    $this->load->model('registro/modregistro', 'mregis');

                    $this->mregis->almacenarToken(md5($arrUsua['USUARIO'] . $token), $arrUsua['ID_USUARIO']);

                } else {
                    //pr($this->email->print_debugger(array('headers'))); exit;
                    $this->data['codiError'] = 1;
                    $this->data['msgError'] = 'No se pudo enviar el correo electrónico. Por favor inténtelo más tarde.';
                    log_message('error', 'Usuario: ' . $email . '-' . $this->email->print_debugger(array('headers')));
                    throw new Exception($this->data['msgError'], 1);
                }
            } catch (Exception $e) {
                log_message('error', 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . $e->getMessage() . '</strong>');
            }
        }

        $this->load->view('layout', $this->data);
    }

    /**
     * Muestra la pagina para cambiar la contrasena
     * @author etabordac
     * @since 2016-07-06
     */
    public function actualizarContrasena() {

        $estado = false;

        $this->load->model('registro/modregistro', 'mregis');

        $postt = $this->input->post(NULL, TRUE);

        $usuario = $this->session->userdata('ID_USUARIO');
        $email = $this->session->userdata('USUARIO');
        $clave = $postt['contrasena1'];

        $this->load->library('danecrypt');
        $encryptClave = $this->danecrypt->encode($clave, $email);

        if($this->mregis->actualizarContrasena($usuario, $encryptClave)){
            $response['codiError'] = 0;
            $response['msgSuccess'] = 'Se cambio correctamente la contraseña.';
            $response['mensaje'] = 'Se cambio correctamente la contraseña.';
        }else{
            $response['codiError'] = 1;
            $response['msgError'] = 'No se pudo cambiar la contraseña, por favor intente de.';
            throw new Exception($this->data['msgError'], 1);
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Muestra la pagina para cambiar la contraseña
     * @author etabordac
     * @since 2016-07-06
     */
    public function CambiarContrasena($token = '') {
        $this->load->model('registro/modregistro', 'mregis');

        if($token == ''){
             redirect(base_url('login'));
        }

        $arrUsua = $this->mregis->consultarToken($token);

        if(count($arrUsua) > 0){
            $this->data["arrJS"][] = base_url_js('login/md5.js');
            $this->data['title'] = 'Cambiar contraseña';
            $this->data['view'] = 'cambiarContrasena';
            $this->data['codiError'] = 0;

            $arrUsua = array_shift($arrUsua);
            $this->session->set_userdata("ID_USUARIO", $arrUsua['ID_USUARIO']);
            $this->session->set_userdata("USUARIO", $arrUsua['USUARIO']);
        }else{
            $this->session->set_flashdata('msgError', 'El enlace usado no es valido o ya ha sido utilizado, por favor genere uno nuevo.');
            redirect(base_url('login/recuperarContrasena/'));
        }

        $this->load->view('layout', $this->data);
    }

    /**
     * Genera una serie de caracteres aleatorios para generar el token
     * @author etabordac
     * @since 2016-07-06
     */
    private function obtenCaracterAleatorio($arreglo) {
        $clave_aleatoria = array_rand($arreglo, 1); //obtén clave aleatoria
        return $arreglo[ $clave_aleatoria ];    //devolver ítem aleatorio
    }

    /**
     * Se codifica a md5 el arreglo de caracteres generado.
     * @author etabordac
     * @since 2018-01-013
     */
    private function obtenCaracterMd5($car) {
        $md5Car = md5($car.Time()); //Codificar el carácter y el tiempo POSIX (timestamp) en md5
        $arrCar = str_split(strtoupper($md5Car));   //Convertir a array el md5
        $carToken = $this->obtenCaracterAleatorio($arrCar);    //obtén un ítem aleatoriamente
        return $carToken;
    }

    /**
    * Se codifica a md5 el arreglo de caracteres generado.
    * @author etabordac
    * @since 2018-01-013
    */
    private function obtenToken($longitud) {
        //crear alfabeto
        $mayus = "ABCDEFGHIJKMNPQRSTUVWXYZ";
        $mayusculas = str_split($mayus);    //Convertir a array
        //crear array de numeros 0-9
        $numeros = range(0,9);
        //revolver arrays
        shuffle($mayusculas);
        shuffle($numeros);
        //Unir arrays
        $arregloTotal = array_merge($mayusculas,$numeros);
        $newToken = "";

        for($i=0;$i<=$longitud;$i++) {
                $miCar = $this->obtenCaracterAleatorio($arregloTotal);
                $newToken .= $this->obtenCaracterMd5($miCar);
        }
        return $newToken;
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
        if (!file_exists($path)) {
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
        }
        $preguntas = extraer_preguntas($tabla, $pagina);
        return $preguntas;
    }

    /*public function test() {
        $this->load->library('danecrypt');
        $password = 'hola';
        $test = $this->danecrypt->encode($password);
        var_dump($test);
    }*/

    /*public function send() {
        $this->load->library('email');

        $this->email->from('gaordial@gmail.com', 'Your Name');
        $this->email->to('gaordial@gmail.com.com');
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        //pr($this->email);
        if (!$this->email->send()) {
            echo $this->email->print_debugger(array('headers'));
        }
    }*/
}
//EOC