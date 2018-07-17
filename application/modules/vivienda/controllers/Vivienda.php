<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de vivienda
 * @author oagarzond
 * @since 2017-03-08
 */
class Vivienda extends MX_Controller {
    private $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data["msgError"] = $this->data["msgSuccess"] = '';
        $this->data["module"] = (!empty($this->module)) ? $this->module: 'login';
        $this->data["header"] = "breadcrumb";
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['footer'] = 'progressBar';
        $this->data["numeroPagina"] = 1;
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
     * @since 2017-03-08
     */
    public function index() {
        //pr($this->session->all_userdata()); exit;
        $this->data["title"] = 'Vivienda';

        $this->data["arrCss"][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data["arrJS"][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data["arrJS"][] = base_url_js('fillInFormTimer.js');
        $this->data["mostrarAnterior"] = 'NO';

        $this->load->model("encuesta/modencuesta", "mencu");
        $this->load->model("modvivienda", "mvivi");
        $page = $pageAC = '1';
        $idUsua = $this->session->userdata('id');
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $arrAC['ID_ESTADO_AC'] = $this->session->userdata('estado');
        $arrAC['PAG_VIVIENDA'] = $this->session->userdata('paginaVivienda');
        $arrAC['FECHA_FIN_VIVIENDA'] = $this->session->userdata('fechaFinVivi');
        $this->construirPreguntas();

        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //$arrAC = array_shift($arrAC);
        //pr($arrAC); exit;
        // Se debe revisar cuando ya este toda la encuesta completa
        if(!empty($arrAC["PAG_VIVIENDA"])) {
            $pageAC = $arrAC["PAG_VIVIENDA"];
        }
        if($arrAC["ID_ESTADO_AC"] == 12) {
            $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
            redirect(base_url('encuesta'), '', 'refresh');
        } else if($arrAC["ID_ESTADO_AC"] == 11) {
            $this->data["mostrarAnterior"] = 'SI';
            if($arrAC["PAG_VIVIENDA"] >= $this->data["totalPaginas"] + 1) {
                $pageAC = 1;
            }
        } else if($arrAC["ID_ESTADO_AC"] < 11) {
            if(!empty($arrAC["FECHA_FIN_VIVIENDA"])) {
                $this->session->set_flashdata('msgError', 'Ya se completó la información de este módulo.');
                redirect(base_url('inicio'), '', 'refresh');
            }
        }

        if($pageAC == 1) {
            $this->data['mostrarAnterior'] = 'NO';
            $this->session->set_userdata('paginaVivienda', $pageAC);
        }
        $this->mostrar($pageAC);
    }

    /**
     * Muestra el contenido de las paginas del modulo
     * @author oagarzond
     * @param $page         Pagina que se va a mostrar
     * @since 2017-03-08
     */
    private function mostrar($page = 0) {
        //pr($page); exit;
        $this->data["breadcrumb"] = '<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
            <li class="breadcrumb-item active">Vivienda</li>
        </ol>';

        $this->data["var"] = '';
        $this->data["view"] = 'vivienda';
        $this->data["avance"] = '0%';
        $estadoActual = $this->session->userdata('estado');
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        if($page == 1) {
            $this->data["view"] = 'vivienda1';
            //@todo: Se debe cambiar la URL del vídeo que le corresponda
            $this->data['URLVideo'] = 'https://www.youtube.com/embed/0uzGFOZl1_A';
        } else if($page == $this->data["totalPaginas"]) {
            $this->data["view"] = 'moduloExitoso';
            $this->data['moduleName'] = strtolower($this->data['title']);
            $this->data['imageLogo'] = 'completo_vivienda';
            $this->data["avance"] = ceil(($page - 1) * 100/$this->data["totalPaginas"]) . '%';
        } else if($page > 1) {
            //$codigoMostrar = $this->config->item("tipoFormulario") . $page;
            //$this->data["arrJS"][] = base_url_js('vivienda/vivienda' . $codigoMostrar . '.js');
            $this->data["arrJS"][] = base_url_js('vivienda/viviendaE' . $page . '.js');
            $this->data["avance"] = ceil(($page - 1) * 100/$this->data["totalPaginas"]) . '%';
            if($page == $this->data["totalPaginas"] + 1) {
                redirect(base_url('hogar'));
            }


           //Para realizar las corrección de la validación de alcantarillado y servicio sanitario fue necesario eliminar algunos condicionales
            //A continuación se comenta el bloque de codigo original y se crea una copia con las modificaciones por si se requiere reversar los cambios.

            //$arrPreguntas = $this->mform->consultarPreguntas('ECP_VIVIENDA', $page);
            /*if($estadoActual >= 11) {
                $arrParam = array(
                    'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                    'codiVivienda' => $this->session->userdata('codiVivienda')
                );
                $arrVivi = $this->mvivi->consultarVivienda($arrParam);
                if(count($arrVivi) > 0) {
                    $arrVivi = array_shift($arrVivi);
                    if(!empty($this->data["preguntas"][$page]) && empty($this->data["preguntas"][$page]['vivienda_exitoso'])) {
                        //$this->data["var"] = cambiar_campos_BD_HTML($arrPreguntas, $this->arrCampos[$page], $arrVivi);
                        $this->data["var"] = asignar_valor_pregunta($this->data["preguntas"][$page], $arrVivi);
                    } else {
                        $this->data["msgError"] = 'No se encontraron las preguntas de la página ' . $page . ' en el módulo ' . $this->data["title"] . '.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->data["msgError"]);
                        $this->session->set_flashdata('msgError', $this->data["msgError"]);
                        redirect(base_url('inicio'));
                        return false;
                    }
                }
            } else {
                if(!empty($this->data["preguntas"][$page]) && empty($this->data["preguntas"][$page]['vivienda_exitoso'])) {
                    $this->data["var"] = $this->data["preguntas"][$page];
                }
            }*/


            $arrParam = array(
               'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                'codiVivienda' => $this->session->userdata('codiVivienda')
            );



            $arrVivi = $this->mvivi->consultarVivienda($arrParam);

           

            if(count($arrVivi) > 0) {
                $arrVivi = array_shift($arrVivi);
                if(!empty($this->data["preguntas"][$page]) && empty($this->data["preguntas"][$page]['vivienda_exitoso'])) {
                    //$this->data["var"] = cambiar_campos_BD_HTML($arrPreguntas, $this->arrCampos[$page], $arrVivi);
                    $this->data["var"] = asignar_valor_pregunta($this->data["preguntas"][$page], $arrVivi);
                } else {
                    $this->data["msgError"] = 'No se encontraron las preguntas de la página ' . $page . ' en el módulo ' . $this->data["title"] . '.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->data["msgError"]);
                    $this->session->set_flashdata('msgError', $this->data["msgError"]);
                    redirect(base_url('inicio'));
                    return false;
                }
            }

            if($page == 2){
                $this->data["condicion_hogar"] = true;
                $this->data["V_CON_OCUP"] = $arrVivi['V_CON_OCUP'];
            }

            if($estadoActual < 11) {
                if(!empty($this->data["preguntas"][$page]) && empty($this->data["preguntas"][$page]['vivienda_exitoso'])) {
                    $this->data["var"] = $this->data["preguntas"][$page];
                }
            }

            if(!empty($this->data['var'])) {
                //pr($this->data['var']); exit;
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
                }

                foreach ($this->data["var"] as $kv => $vv) {
                    if($vv["REFERENCIA_HTML"] == 'cuantos_hogares') {
                        for($i = 1; $i <= 20; $i++) {
                            $this->data["var"][$kv]['OPCIONES'][$i - 1] = array(
                                "ID_PREGUNTA" => $vv["ID_PREGUNTA"],
                                "ID_OPCION" => $i,
                                "DESCRIPCION_OPCION" => $i,
                                "AYUDA" => '',
                                "ORDEN_VISUAL" => $i
                            );
                        }
                    } else if($vv["REFERENCIA_HTML"] == 'energia_electrica') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'energia_estrato') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    break;
                                }
                            }
                        }
                    } else if($vv["REFERENCIA_HTML"] == 'basura') {
                        if(!empty($vv['OPCIONES'])) {
                            foreach ($this->data['var'] as $kp => $vp) {
                                if($vp['REFERENCIA_HTML'] == 'veces_basura') {
                                    $this->data['var'][$kv]['OPCIONES'][0]['PREGUNTA'][] = $this->data['var'][$kp];
                                    unset($this->data['var'][$kp]);
                                    break;
                                }
                            }
                        }
                    } else if($vv["REFERENCIA_HTML"] == 'sanitario') {
                        if(!empty($arrVivi['VC_ALC']) && $arrVivi['VC_ALC'] == 2) {
                            unset($this->data['var'][$kv]['OPCIONES'][0]);
                        }
                    //Se agrega esta validación para remover la opción de no tiene paredes, cuando se selecciona en tipo de vievienda casa, apartamento o tipo cuarto
                    } else if($vv['REFERENCIA_HTML'] == 'material_pared') {
                        if($arrVivi['V_TIPO_VIV'] < 4) {
                            unset($this->data['var'][$kv]['OPCIONES'][8]);
                        }
                    }
                }
            }
        }
        //pr($this->data); exit;
        $this->load->view("layout", $this->data);
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
        $response['codiError'] = $response['avance'] = 0;
        $response['mensaje'] = '';
        $postt = $this->input->post(NULL, TRUE);
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $this->load->model("modvivienda", "mvivi");

        $idUsua = $this->session->userdata('id');
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $page = $this->session->userdata('paginaVivienda');
        //pr($page); exit;
        $this->construirPreguntas();
        $duracion = $postt["duracion"];
        unset($postt["duracion"]);
        //@todo: falta consultar y guardar el tiempo de entrevista - 2017-03-23
        $this->mvivi->setCodiEncuesta($codiEncuesta);
        $this->mvivi->setCodiVivienda($this->session->userdata('codiVivienda'));
        if($page == 1) {
            $page = intval($page) + 1;
            if($this->mvivi->actualizarEstadoAC($page)) {
                $response["avance"] = ceil(($page - 1) * 100/$this->data["totalPaginas"]) . '%';
                $this->load->model("encuesta/modencuesta", "mencu");
                if($this->mencu->registrarTiempo('vivienda', $duracion)) {
                    $response['mensaje'] = 'Se guardaron correctamente los datos de la vivienda.';
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Vivienda.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo actualizar el estado de la vivienda en la encuesta.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
            }
        } else if($page > 1) {
            foreach ($this->data["preguntas"][$page] as $kpage => $vpage) {
                $this->data['form'][$vpage['ID_PREGUNTA']] = 'NULL';
            }
            foreach ($postt as $key => $value) {
                foreach ($this->data["preguntas"][$page] as $kpage => $vpage) {
                    if($vpage['REFERENCIA_HTML'] == $key) {
                        $this->data['form'][$vpage['ID_PREGUNTA']] = $value;
                        break;
                    }
                }
            }

            if($page == 2){
                $this->data['form']['V_CON_OCUP'] = $postt['V_CON_OCUP'];
            }

            $page = intval($page) + 1;
            //pr($page);
            //pr($this->data['form']); exit;
            if($this->mvivi->actualizarVivienda($this->data['form'])) {
                if($this->mvivi->actualizarEstadoAC($page)) {
                    if($page == $this->data["totalPaginas"] + 1) {
                        $response['avance'] = '100%';
                    } else {
                        $response['avance'] = ceil(($page - 1) * 100/$this->data["totalPaginas"]) . '%';
                    }
                    $this->load->model("encuesta/modencuesta", "mencu");
                    if($this->mencu->registrarTiempo('vivienda', $duracion)) {
                        $response['mensaje'] = 'Se guardaron correctamente los datos de la vivienda.';
                    } else {
                        $response['codiError'] = 3;
                        $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Vivienda.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                    }
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo actualizar el estado de la vivienda en la encuesta.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo guardar los datos de la vivienda.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
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
        $duracion = $postt["duracion"];
        unset($postt["duracion"]);
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $this->load->model("encuesta/modencuesta", "mencu");
        $this->load->model("modvivienda", "mvivi");

        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //$arrAC = array_shift($arrAC);
        $page = $this->session->userdata('paginaVivienda');

        if($page > 0) {
            $page--;
            $this->mvivi->setCodiEncuesta($codiEncuesta);
            $this->mvivi->setCodiVivienda($this->session->userdata('codiVivienda'));

            if($this->mvivi->actualizarEstadoAC($page)) {
                if($this->mencu->registrarTiempo('vivienda', $duracion)) {
                    $response['mensaje'] = 'Se guardaron correctamente los datos de la vivienda.';
                    $response['avance'] = ceil(($page - 1) * 100/$this->data["totalPaginas"]) . '%';
                } else {
                    $response['codiError'] = 2;
                    $response['mensaje'] = 'No se pudo actualizar el tiempo de diligenciamiento del módulo de Vivienda.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mvivi->getMsgError());
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo actualizar el estado de la vivienda.';
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

        $this->load->model("vivienda/modvivienda", "mvivi");
        $this->mvivi->setCodiEncuesta($codiEncuesta);
        $this->mvivi->setCodiVivienda($this->session->userdata('codiVivienda'));
        $this->mvivi->setTotalPaginas($this->data["totalPaginas"]);
        if($this->mvivi->actualizarEstadoAC('f')) {
            $response['mensaje'] = 'Se finalizó correctamente la sección Vivienda.';
            $response['avance'] = '100%';
        } else {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se pudo actualizar el estado de la vivienda.';
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
    private function construirPreguntas($tabla = 'ECP_VIVIENDA', $pagina = '') {
        $this->load->model('modform', 'mform');

        $preguntas = $this->mform->extraerPreguntas($tabla);
        //$preguntas = $this->consultarPreguntas($tabla);
        $this->data["preguntas"][0]['definicion_vivienda'] = 'SI';
        $this->data["preguntas"] = array_merge($this->data["preguntas"], $preguntas);
        foreach ($this->data["preguntas"] as $kpreg => $vpreg) {
            $this->data["preguntas"][$kpreg + 1] = $vpreg;
        }
        unset($this->data["preguntas"][0]);
        $this->data["totalPaginas"] = count($this->data["preguntas"]);
        $this->data["preguntas"][++$this->data["totalPaginas"]]['vivienda_exitoso'] = 'SI';
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
        $this->session->set_userdata('paginaVivienda', $numero);
        redirect(base_url($this->data['module']));
    }

    public function formNew() {
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $this->data['view'] = 'newForm';
        $this->load->view('layout', $this->data);
    }

    public function guardarVivienda() {
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $respuestas=$_POST;

        var_dump($respuestas);
        /*$resp[0]=

        $tipo_vivienda= $_POST["vv1_tipo_vivienda"];
        $ocupacion_vivienda= $_POST["vv2_ocupacion_vivienda"];
        $total_hogares= $_POST["vv3_total_hogares"];
        $material_paredes= $_POST["vv3_total_hogares"];
        $total_hogares= $_POST["vv3_total_hogares"];
        $total_hogares= $_POST["vv3_total_hogares"];
        $total_hogares= $_POST["vv3_total_hogares"];
        $total_hogares= $_POST["vv3_total_hogares"];
        $total_hogares= $_POST["vv3_total_hogares"];
        $total_hogares= $_POST["vv3_total_hogares"];
        */
       // var_dump($_POST);
    }
}
//EOC