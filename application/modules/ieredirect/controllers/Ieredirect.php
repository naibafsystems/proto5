<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el módulo de IERedirect
 * Se redirecciona a los usuarios que utilizan Internet Explorer a otra página para que utilicen otro tipo de navegador.
 * @since  22/09/2015	   
 * @author dmdiazf
 */
class IERedirect extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->module = $this->uri->segment(1);
        $this->data["msgError"] = $this->data["msgSuccess"] = '';
        $this->data["module"] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
    }

    public function index() {
        $this->data["view"] = "ieredirect";
        $this->data["title"] = 'Cambie de navegador web';
        $this->load->view("layout", $this->data);
    }
}
//EOC