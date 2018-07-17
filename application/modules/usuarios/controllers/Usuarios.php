<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de inicio
 * @author oagarzond
 * @since 2016-06-10
 */
class Usuarios extends MX_Controller {
    var $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data["msgError"] = $this->data["msgSuccess"] = '';
        $this->data["module"] = (!empty($this->module)) ? $this->module: 'login';
    }

    /**
     * Regresa a la pagina del login
     * @author oagarzond
     * @since 2017-06-05
     */
    public function index() {
        $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
        redirect(base_url());
    }

    /**
     * Verifica que el usuario logueado es administrador
     * @author oagarzond
     * @since 2017-06-05
     */
    private function esAdmin() {
        $esAdmin = $this->session->userdata("esAdmin");
        if(empty($esAdmin)) {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url('admin'), '', 'refresh');
        }
    }

    /**
     * Verifica que el usuario logueado es administrador o de soporte
     * @author oagarzond
     * @since 2017-06-05
     */
    private function esAdminSoporte() {
        $esAdmin = $this->session->userdata("esAdmin");
        $esSoporte = $this->session->userdata("esSoporte");
        if(empty($esAdmin) && empty($esSoporte)) {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url('admin'), '', 'refresh');
        }
    }

    /**
     * Verifica que el usuario tiene permiso para editar
     * @author oagarzond
     * @since 2017-06-05
     */
    private function permisoEditar() {
        $this->esAdmin();
        if($this->data["esAdmin"] == 'NO') {
            $this->session->set_flashdata('msgError', 'No tiene suficientes permisos para ingresar a este módulo.');
            redirect(base_url('admin/inicio'), '', 'refresh');
        }
    }

    /**
     * Muestra la lista de usuarios del sistema
     * @author oagarzond
     * @since 2017-06-05
     */
    public function ver() {
        $this->load->model('modusuarios', 'musua');

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['data'][0]['usuario'] = '';
        $response['data'][0]['nume_docu'] = '';
        $response['data'][0]['nombre'] = '';
        $response['data'][0]['estado'] = '';
        $response['data'][0]['estado_form'] = '';
        $response['data'][0]['opciones'] = '';

        $arrParam['tieneCodiEncuesta'] = 'SI';
        $esAdmin = $this->session->userdata("esAdmin");
        $esSoporte = $this->session->userdata("esSoporte");
        $rol = 'S';
        for ($i = 1; $i < 20; $i++) {
            $valor = $this->uri->segment($i);
            if ($i == 3 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                $rol = $valor;
                if($valor == 'A'){
                    unset($arrParam['tieneCodiEncuesta']);
                }
            }
            if($rol == 'S') {
                if ($i == 4 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['formulario'] = urldecode($valor);
                }
                if ($i == 5 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['usuario'] = urldecode($valor);
                }
                if ($i == 6 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['tipoDocu'] = urldecode($valor);
                }
                if ($i == 7 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['numeDocu'] = urldecode($valor);
                }
                if ($i == 8 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['estadoForm'] = urldecode($valor);
                }
                if ($i == 9 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['nombre1'] = strtoupper(urldecode($valor));
                }
                if ($i == 10 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['nombre2'] = strtoupper(urldecode($valor));
                }
                if ($i == 11 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['apellido1'] = strtoupper(urldecode($valor));
                }
                if ($i == 12 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['apellido1'] = strtoupper(urldecode($valor));
                }
            } else if($rol == 'A') {
                if ($i == 4 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['formulario'] = urldecode($valor);
                }
                if ($i == 5 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['usuario'] = urldecode($valor);
                }
                if ($i == 6 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['tipoDocu'] = urldecode($valor);
                }
                if ($i == 7 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['numeDocu'] = urldecode($valor);
                }
                if ($i == 8 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['estadoForm'] = urldecode($valor);
                }
                if ($i == 9 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['nombre1'] = strtoupper(urldecode($valor));
                }
                if ($i == 10 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['nombre2'] = strtoupper(urldecode($valor));
                }
                if ($i == 11 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['apellido1'] = strtoupper(urldecode($valor));
                }
                if ($i == 12 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['apellido1'] = strtoupper(urldecode($valor));
                }
                if ($i == 13 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['tipo'] = urldecode($valor);
                }
                if ($i == 14 && !empty($valor) && ($valor != '-' && $valor != '0')) {
                    $arrParam['estado'] = urldecode($valor);
                }
            }
        }

        $arrUsua = $this->musua->consultarInfoUsuarios($arrParam);
        if(count($arrUsua) > 0) {
            foreach ($arrUsua as $ku => $vu) {
                $response['data'][$ku]['usuario'] = $vu['USUARIO'];
                $response['data'][$ku]['nume_docu'] = $vu['PA1_NRO_DOC'];
                $response['data'][$ku]['nombre'] = $vu['nombre'];
                $response['data'][$ku]['estado'] = $vu['ESTADO_USUA'];
                $response['data'][$ku]['estado_form'] = $vu['ESTADO_FORM'];
                $response['data'][$ku]['opciones'] = '<button class="verUsuario btn btn-sm btn-info" type="button" data-usua="' . $vu['ID_USUARIO'] . '" title="Ver encuestado">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>&nbsp;
                        <button class="verEntrevistas btn btn-sm btn-info" type="button" data-encuesta="' . $vu['COD_ENCUESTAS'] . '" title="Ver resultado entrevistas">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>&nbsp;
                        <button class="editarCorreo btn btn-sm btn-info" type="button" data-usua="' . $vu['ID_USUARIO'] . '" title="Actualizar información">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';
                    if($vu['ESTADO_FORM'] == 'Generó constancia de encuesta') {
                        $response['data'][$ku]['opciones'] .= '&nbsp;
                        <button class="editarUsuario btn btn-sm btn-info" type="button" data-usua="' . $vu['ID_USUARIO'] . '" title="Cambiar estado">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
                    }
                if(!empty($esAdmin) && $esAdmin == 'SI') {
                    if($vu['ID_ESTADO_USUA'] == 1) {
                        $response['data'][$ku]['opciones'] .= '&nbsp;
                        <button class="inactivarUsuario btn btn-sm btn-info" type="button" data-usua="' . $vu['ID_USUARIO'] . '" title="Inactivar usuario">
                        <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></button>';
                    } else if($vu['ID_ESTADO_USUA'] == 2) {
                        $response['data'][$ku]['opciones'] .= '&nbsp;
                        <button class="activarUsuario btn btn-sm btn-info" type="button" data-usua="' . $vu['ID_USUARIO'] . '" title="Activar usuario">
                        <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></button>';
                    }
                }
            }
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se encontró información de los usuarios.';
        }

        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Valida que el ID pasado sea de un usuario
     * @author oagarzond
     * @since 2017-06-05
     */
    public function validarUsuario() {
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
        if(empty($this->data['id'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el identificador del usuario.';
        }
        if($response['codiError'] == 0) {
            $this->load->model('modusuarios', 'musua');

            $arrUsua = $this->musua->consultarInfoUsuarios(array('id' => $this->data['id']));
            if(count($arrUsua) > 0) {
                switch ($this->data['opc']) {
                    case 'verUsuario':
                        $response['url'] = base_url('usuarios/verUsuario/' . $this->data['id']);
                        break;
                    case 'editarUsuario':
                        $response['url'] = base_url('usuarios/editarUsuario/' . $this->data['id']);
                        break;
                    case 'editarCorreo':
                        $response['url'] = base_url('usuarios/editarCorreo/' . $this->data['id']);
                        break;
                }
            }
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Muestra la informacion del usuario y personas del hogar
     * @author oagarzond
     * @since 2017-06-05
     */
    public function verUsuario($id = 0) {
        $this->esAdminSoporte();
        $esAdmin = $this->session->userdata("esAdmin");
        $esSoporte = $this->session->userdata("esSoporte");
        $this->data["view"] = 'verUsuario';
        $this->data["title"] = 'Ver encuestado';
        if(!empty($esSoporte)) {
            $this->data['url'] = 'soporte/inicio';
            $this->data["header"] = 'navbarSoporte';
            $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item"><a href="' . base_url('soporte/inicio') . '">Soporte</a></li>
                <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
            </ol>';
        } else if(!empty($esAdmin)) {
            $this->data['url'] = 'admin/inicio';
            $this->data["header"] = 'navbarAdmin';
            //$this->data["header"] = 'navbarSoporte';
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

        $this->data["arrCss"][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
        $this->data["arrJS"][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');

        $this->load->model('modusuarios', 'musua');
        $this->load->model("modform", "mform");

        $arrUsua = $this->musua->consultarInfoUsuarios(array('id' => $id));
        if(count($arrUsua) > 0) {
            $this->data["usua"] = array_shift($arrUsua);
            $this->data["usua"]['modulo'] = $this->data["usua"]['pagina'] = 0;
            $tablaAsociada = array('','ECP_UBICACION','ECP_VIVIENDA','ECP_HOGAR','ECP_PERSONAS_HOGAR','ECP_PERSONAS_HOGAR_PERS');
            if(!empty($this->data["usua"]['ID_ESTADO_AC'])) {
                switch ($this->data["usua"]['ID_ESTADO_AC']) {
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
                }

                if(!empty($this->data['usua']['pagina'])) {
                    if($tablaAsociada[$this->data['usua']['modulo']] == 'ECP_HOGAR' && $this->data['usua']['pagina'] == 7) {
                        $this->data['usua']['modulo'] = '5';
                    }
                    $arrPreguntas = $this->mform->consultarPreguntas($tablaAsociada[$this->data['usua']['modulo']], $this->data['usua']['pagina']);
                    if(count($arrPreguntas) == 0) {
                        $this->data['usua']['pagina'] = '';
                    }
                }
            }
            if(!empty($this->data["usua"]['CLAVE'])) {
                $this->load->library("danecrypt");
                //$this->data["usua"]['contrasena'] = $this->danecrypt->decode($this->data["usua"]['CLAVE']);
                unset($this->data["usua"]['CLAVE']);
            }
        }
        //pr($this->data); exit;
        $this->load->view("layout", $this->data);
    }

    /**
     * Crea el usuario en el sistema
     * @author oagarzond
     * @since 2017-06-02
     */
    public function agregar() {
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
        foreach ($postt as $nombre_campo => $valor) {
            $this->data[$nombre_campo] = $valor;
        }

        $this->load->model("modusuarios", "musua");
        if(!empty($this->data['usuario'])) {
            $arrUsua = $this->musua->consultarAdminUsuarios(array('usuario' => $this->data['usuario']));
            if(count($arrUsua) > 0) {
                $response["codiError"] = 2;
                $response["mensaje"] = "El correo electrónico ya está registrado en el sistema.";
            }
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió el correo electrónico del usuario.';
        }
        if($response['codiError'] == 0) {
            $this->load->library("danecrypt");
            $this->data["clave"] = $this->danecrypt->encode(md5($this->data['contrasena1']), $this->data['usuario']);
            //$this->data["clave"] = hash('sha512', md5($this->data['contrasena1']) . strtolower($this->data['usuario']));
            $this->data["estado_usua"] = 1;
            if(!empty($this->data["nombre1Pers"])) {
                $this->data["nombres"] = $this->data["nombre1Pers"];
            }
            if(!empty($this->data["nombre2Pers"])) {
                $this->data["nombres"] .= ' ' . $this->data["nombre2Pers"];
            }
            if(!empty($this->data["apellido1Pers"])) {
                $this->data["apellidos"] = $this->data["apellido1Pers"];
            }
            if(!empty($this->data["apellido2Pers"])) {
                $this->data["apellidos"] .= ' ' . $this->data["apellido2Pers"];
            }

            if(!empty($this->data)) {
                if($this->musua->agregarUsuario($this->data)) {
                    $response['mensaje'] = 'Se agregó correctamente el usuario.';
                } else {
                    $response['codiError'] = 4;
                    $response['mensaje'] = 'No se pudo agregar el usuario.';
                    log_message('error', $this->musua->getMsgError());
                }
            } else {
                $response["codiError"] = 3;
                $response["mensaje"] = "No se definió correctamente los datos para agregar el usuario.";
            }
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Muestra la pantalla que permite editar la informacion del usuario
     * @author oagarzond
     * @since 2017-06-05
     */
    public function editarUsuario($id = 0) {
        $this->esAdminSoporte();
        $esAdmin = $this->session->userdata("esAdmin");
        $esSoporte = $this->session->userdata("esSoporte");
        $this->data["view"] = 'editarUsuario';
        $this->data["title"] = 'Editar encuestado';
        $this->data['classContainer'] = 'container';
        $this->data['footer'] = 'footer';
        $this->data['opcionEstado'] = 'NO';

        if(!empty($esSoporte)) {
            $this->data['url'] = 'soporte/inicio';
            $this->data["header"] = 'navbarSoporte';
            $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item"><a href="' . base_url('soporte/inicio') . '">Soporte</a></li>
                <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
            </ol>';
        } else if(!empty($esAdmin)) {
            $this->data['url'] = 'admin/inicio';
            //$this->data["header"] = 'navbarAdmin';
            $this->data["header"] = 'navbarSoporte';
            $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item"><a href="' . base_url('admin/inicio') . '">Administración</a></li>
                <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
            </ol>';
            // Se muestra el campo de estado
            $this->data['opcionEstado'] = 'SI';
        }

        if(empty($id)) {
            $this->session->set_flashdata('msgError', 'No se definió correctamente el identificador del usuario.');
            redirect(base_url($this->data['url']));
        }

        $this->load->model('modusuarios', 'musua');
        $this->load->model("modform", "mform");

        $arrUsua = $this->musua->consultarInfoUsuarios(array('id' => $id));
        if(count($arrUsua) > 0) {
            $this->data["usua"] = array_shift($arrUsua);
            $this->data["usua"]['arrValores'] = $this->mform->consultarParamValores(array('idDominio' => 2));
            if(!empty($this->data["usua"]['CLAVE'])) {
                $this->load->library("danecrypt");
                //$this->data["usua"]['contrasena'] = $this->danecrypt->decode($this->data["usua"]['CLAVE']);
                unset($this->data["usua"]['CLAVE']);
            }
        }
        //pr($this->data); exit;
        $this->load->view("layout", $this->data);
    }

    /**
     * Actualiza la inforamcion del usuario
     * @author oagarzond
     * @since 2017-06-05
     */
    public function guardarUsuario() {
        $this->esAdminSoporte();
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
        if(empty($this->data['descripcion'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió las observaciones del cambio de estado del formulario.';
        }
        if($response['codiError'] == 0) {
            $this->load->model("modusuarios", "musua");
            if(!empty($this->data)) {
                $this->data['estado'] = 11;
                //pr($this->data); exit;
                if($this->musua->actualizarEstado($this->data))  {
                    $response["mensaje"] = "Se actualizó correctamente el estado del formulario.";
                } else {
                    $response['codiError'] = 3;
                    $response["mensaje"] = "No se pudo actualizar correctamente el estado del formulario.";
                    log_message('error', $response["mensaje"] . $this->musua->getMsgError());
                }
            } else {
                $response["codiError"] = 2;
                $response["mensaje"] = "No se definió correctamente los datos para actualizar el estado del formulario.";
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Activa o inactiva el usuario
     * @author oagarzond
     * @since 2017-12-06
     */
    public function activar() {
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
        foreach ($postt as $nombre_campo => $valor) {
            $this->data[$nombre_campo] = $valor;
        }
        if(empty($this->data['idUsua'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el identificador del usuario.';
        }
        if($response['codiError'] == 0) {
            $this->load->model('modusuarios', 'musua');

            switch ($this->data['opc']) {
                case 'ac':
                    $this->data['estado_usua'] = 1;
                    break;
                case 'in':
                    $this->data['estado_usua'] = 2;
                    break;
            }
            unset($this->data['opc']);

            if(!empty($this->data)) {
                $this->musua->setCodiUsuario($this->data['idUsua']);
                if($this->musua->actualizarAdminUsuarios($this->data))  {
                    $response["mensaje"] = "Se actualizó correctamente la información del usuario.";
                } else {
                    $response['codiError'] = 3;
                    $response["mensaje"] = "No se pudo actualizar correctamente la información del usuario.";
                    log_message('error', $response["mensaje"] . $this->musua->getMsgError());
                }
            } else {
                $response["codiError"] = 2;
                $response["mensaje"] = "No se definió correctamente los datos para editar el usuario.";
            }
        }

        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

     /**
     * Muestra la pantalla que permite editar el correo del usuario
     * @author aocubillosa
     * @since 2018-01-18
     */
    public function editarCorreo($id = 0) {
        $this->esAdminSoporte();
        $esAdmin = $this->session->userdata("esAdmin");
        $esSoporte = $this->session->userdata("esSoporte");
        $this->data["view"] = 'editarCorreo';
        $this->data["title"] = 'Editar correo';
        $this->data['classContainer'] = 'container';
        $this->data['footer'] = 'footer';
        $this->data['opcionEstado'] = 'NO';

        if(!empty($esSoporte)) {
            $this->data['url'] = 'soporte/inicio';
            $this->data["header"] = 'navbarSoporte';
            $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item"><a href="' . base_url('soporte/inicio') . '">Soporte</a></li>
                <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
            </ol>';
        } else if(!empty($esAdmin)) {
            $this->data['url'] = 'admin/inicio';
            //$this->data["header"] = 'navbarAdmin';
            $this->data["header"] = 'navbarSoporte';
            $this->data["breadcrumb"] = '<ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item"><a href="' . base_url('admin/inicio') . '">Administración</a></li>
                <li class="breadcrumb-item active">' . $this->data['title'] . '</li>
            </ol>';
            // Se muestra el campo de estado
            $this->data['opcionEstado'] = 'SI';
        }

        if(empty($id)) {
            $this->session->set_flashdata('msgError', 'No se definió correctamente el identificador del usuario.');
            redirect(base_url($this->data['url']));
        }

        $this->load->model('modusuarios', 'musua');
        $this->load->model("modform", "mform");

        $arrUsua = $this->musua->consultarInfoUsuarios(array('id' => $id));
        
        if(count($arrUsua) > 0) {
            $this->data["usua"] = array_shift($arrUsua);
            $this->data["usua"]['arrValores'] = $this->mform->consultarParamValores(array('idDominio' => 2));
            if(!empty($this->data["usua"]['CLAVE'])) {
                $this->load->library("danecrypt");
                //$this->data["usua"]['contrasena'] = $this->danecrypt->decode($this->data["usua"]['CLAVE']);
                unset($this->data["usua"]['CLAVE']);
            }
        }
        //pr($this->data); exit;
        $this->load->view("layout", $this->data);
    }

    /**
     * Actualiza el correo del usuario
     * @author aocubillosa
     * @since 2018-01-18
     */
    public function guardarCorreo() {
        $this->esAdminSoporte();
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
        if(empty($this->data['correo_electronico'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el correo electrónico del usuario.';
        }
        if(empty($this->data['tipo_documento'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el tipo de documento del usuario.';
        }
        if(empty($this->data['numero_documento'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el número de documento del usuario.';
        }
        if(empty($this->data['primer_nombre'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el nombre del usuario.';
        }
        if(empty($this->data['primer_apellido'])) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el apellido del usuario.';
        }

        if($response['codiError'] == 0) {
            $this->load->model("modusuarios", "musua");
            if(!empty($this->data)) {
                //pr($this->data); exit;
                if($this->musua->actualizarCorreo($this->data))  {
                    $response["mensaje"] = "Se actualizó correctamente la información del usuario.";
                } else {
                    $response['codiError'] = 3;
                    $response["mensaje"] = "No se pudo actualizar correctamente la información del usuario.";
                    log_message('error', $response["mensaje"] . $this->musua->getMsgError());
                }
            } else {
                $response["codiError"] = 2;
                $response["mensaje"] = "No se definió correctamente los datos para actualizar la información del usuario.";
            }
        }
        //pr($response); exit;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }
}
//EOC