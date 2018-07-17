<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home {

    private $ci;
    private $db;

    public function __construct() {
        $this->ci = & get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
        //$this->db = $this->ci->load->database('default', true);
    }

    public function check_login() {
        $error = FALSE;
        // Se debe quitar los palabras angular, home, inicio, exportarExcel ya que si se debe validar la sesion - 2017-02-07
        $arrModules = array('ejecutable', 'ieredirect', 'login', 'formulario', 'registro', 'welcome');
        if ($this->ci->uri->segment(1) == 'admin' || $this->ci->uri->segment(1) == 'soporte') {
            $arrControllers = array('index', 'login', 'salir', 'userAuth', 'validaSesion');
            if (!empty($this->ci->uri->segment(2)) && !in_array($this->ci->uri->segment(2), $arrControllers)) {
                if ($this->ci->session->userdata('id') == FALSE) {
                    $this->ci->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
                    redirect(base_url('soporte'));
                }
            }
        } else if ($this->ci->uri->segment(1) == 'encuesta') {
            // Se valida sesion si no se definio metodo
            $arrControllers = array('conocerCenso', 'conocerLey', 'terminosCondiciones', 'videoTutorial');
            if (empty($this->ci->uri->segment(2)) || !in_array($this->ci->uri->segment(2), $arrControllers)) {
                if ($this->ci->session->userdata('id') == FALSE) {
                    $this->ci->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
                    redirect(base_url('login'));
                }
            }
        } else {
            if (!in_array($this->ci->uri->segment(1), $arrModules) && $this->ci->uri->segment(1) != NULL) {
                if ($this->ci->session->userdata('id') == FALSE) {
                    $this->ci->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
                    //redirect(base_url('login'), 'auto', 403);
                    redirect(base_url('login'));
                }
            }
        }
    }
}
//EOC