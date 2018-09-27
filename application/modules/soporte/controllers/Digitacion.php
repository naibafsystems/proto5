<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de soporte para logistica
 * @author oagarzond
 * @since 2017-06-02
 */
class Digitacion extends MX_Controller {
    private $data;
    private $url = '/soporte/digitacion';
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
        $this->load->model("Moddigitacion", "mdigita");

        $tabs = array(
            // 'formulario' => array('name' => 'Formulario', 'link' => base_url('soporte/digitacion/formulario'),  'template' => 'digitacion/formulario'),
            'ubicacion' => array('name' => 'Ubicacion', 'link' => base_url('soporte/digitacion/ubicacion'), 'template' => 'digitacion/ubicacion'),
            'vivienda' => array('name' => 'Vivienda', 'link' => base_url('soporte/digitacion/vivienda'), 'template' => 'digitacion/vivienda'),
            'hogar' => array('name' => 'Hogar', 'link' => base_url('soporte/digitacion/hogar'), 'template' => 'digitacion/hogar'),
            // 'personas' => array('name' => 'Personas', 'link' => base_url('soporte/digitacion/personas'), 'template' => 'digitacion/personas'),
        );

        $urll = $this->uri->segment(3);
        if ($urll!=NULL && array_key_exists($urll,$tabs)){
            $this->data['view'] = 'digitacion/principal';
            $this->data["tab_panel"] = $tabs[$urll]['template'];
            $tabs[$urll]['class'] = 'active';
        }

        // if ($urll==NULL || $urll == 'formulario' ){
        //     $this->data["tab_panel"] = $tabs['formulario']['template'];
        //     $tabs['formulario']['class'] = 'active';
        // }
        $this->data['tabs'] = $tabs;

        $this->data['arrCss'][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data['arrJS'][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data['arrJS'][] = base_url_js('fillInFormTimer.js');
        // pr($this->data);die();
    }

    public function index() {

        //pr($this->session->userdata());

        $this->session->unset_userdata(['encuesta', 'control', 'codiEncuesta', 'codiVivienda', 'codiHogar' , 'fechaFinPers', 'paginaUbicacion', 'ejemplosCPob', 'paginaVivienda', 'numeroPersona', 'paginaHogar', 'estado', 'fechaCertificado', 'fechaFinUbi', 'fechaFinVivi', 'fechaFinHogar', 'codiPersona', 'nombrePersona', 'numeroPagina', 'edadPersona', 'sexoPersona', 'fechaInscripcion', 'texto5Anios', 'texto1Anio', 'numeEntrevista', 'numeVisita']);

        $this->data['view'] = 'digitacion/index';
        $this->data['header'] = 'header';
        $this->data['footer'] = 'footer';
        $this->data['title'] = 'Digitacion';

        $this->data['arrCss'][] = base_url_plugins('DataTables/media/css/jquery.dataTables.min.css');
        $this->data['arrJS'][] = base_url_plugins('DataTables/media/js/jquery.dataTables.min.js');

        $this->data['arrJS'][] = base_url_js('digitacion/digitacion.js');

        $this->load->view('layout', $this->data);
    }

    /**
     * Metodo para la carga el listado de encuestas creadas por usuario digitador
     */
    public function getEncuestas(){
        // die('hola encuestados');
        $data = [];
        foreach ($this->mdigita->getEncuestas() as $k => $v) {

            $diligencia = '<button class="dg btn btn-success btn-small" data-encuesta="'.$v['COD_ENCUESTAS'].'">Diligenciar</button>';
            $diligencia = '<a class="dg btn btn-link btn-small" data-encuesta="'.$v['COD_ENCUESTAS'].'">Diligenciar</a>';
            // if ($v['ID_ESTADO_AC'] < 3 || $v['ID_ESTADO_AC'] > 10) {
            //     $diligencia = '<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>';
            // }

            $data[$k]['encuesta'] = $v['COD_ENCUESTAS'];
            $data[$k]['formulario'] = $v['UI1_NROFOR'];
            $data[$k]['estado'] = $v['ID_ESTADO_AC'];
            $data[$k]['ubicacion'] = $v['FECHA_INI_UBICACION'] . '<br>' . $v['FECHA_FIN_UBICACION'];
            $data[$k]['vivienda'] = $v['FECHA_INI_VIVIENDA'] . '<br>' . $v['FECHA_FIN_VIVIENDA'];
            $data[$k]['hogar'] = $v['FECHA_INI_HOGAR'] . '<br>' . $v['FECHA_FIN_HOGAR'];
            $data[$k]['personas'] = $v['FECHA_CERTI'];
            $data[$k]['diligenciar'] = $diligencia ;
        }
        $response['data'] = $data;
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Metodo para la creaacion encuestas por el usuario digitador
     */
    public function addEncuesta(){
        $response['error'] = false;
        $response['message'] = '';

        // $tipoUsuario = $this->session->tipoUsua;
        // $estSession = $this->session->auth;
        $postt = $this->input->post(NULL, TRUE);
        $response['data'] = $postt;

        if($this->mdigita->addEncuesta($response['data'])){
            $response['error'] = true;
        }

        $response['message'] = $this->mdigita->getMsgError();
        $response['encuesta'] = $this->mdigita->getEncuesta();

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }


    public function form(){
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $response['error'] = true;
        $inputs = $this->input->post('encuesta', true);
        // if (!$this->session->has_userdata('encuesta') ||
        //     ($this->session->has_userdata('encuesta') && strcmp($this->session->encuesta, $inputs) !== 0)) {
            $this->session->unset_userdata(['encuesta', 'control']);
            $this->session->set_userdata('encuesta', $inputs);
            $control = $this->mdigita->getEncuestas(['encuesta' => $inputs]);
            $this->session->set_userdata('control', array_shift($control));
        // }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

/* =========================================================================================================== */

    public function formulario(){
        $encuesta = $this->session->encuesta;
        $control = $this->session->control;
        // $url = '/soporte/digitacion';
        // die();
        if (strcmp($control['ID_ESTADO_AC'], 3) === 0){
             redirect( $this->url.'/ubicacion');
        }

        if (strcmp($control['ID_ESTADO_AC'], 5) === 0){
             redirect( $this->url.'/vivienda');
        }

        if (strcmp($control['ID_ESTADO_AC'], 7) === 0){
             redirect( $this->url.'/hogar');
        }

        if ($control['ID_ESTADO_AC'] < 3 || $control['ID_ESTADO_AC'] > 10){
             redirect( $this->url, 'refresh');
        }
    }

    public function ubicacion(){
        pr($this->session->encuesta);
        // if (strcmp($this->session->control['ID_ESTADO_AC'], 3) !== 0){
        //     redirect( $this->url.'/formulario');
        // }

        $this->data['header'] = 'header';
        $this->data['footer'] = 'footer';
        $this->data['title'] = 'Digitacion';
        $this->data['arrJS'][] = base_url_plugins('moment/js/moment.min.js');
        $this->data['arrCss'][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data['arrJS'][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data['arrCss'][] = base_url_plugins('select2/css/select2.min.css');
        $this->data['arrCss'][] = base_url_plugins('select2/css/select2-bootstrap.min.css');
        $this->data['arrJS'][] = base_url_plugins('select2/js/select2.min.js');
        $this->data['arrJS'][] = base_url_plugins('select2/js/i18n/es.js');
        $this->data['arrJS'][] = base_url_js('digitacion/ubicacion.js');

        $this->construirPreguntas($tabla = 'ECP_UBICACION');
        // pr($this->data['preguntas']);die();
        $this->data['var'] = $this->data['preguntas'];

        foreach ($this->data['var'] as $kv => $vv) {
            /*Fin caga pregunta departamento y municipio*/
            if($vv['REFERENCIA_HTML'] == 'departamento') {
                $arrDepartamentos = $this->config->item('departamentos');
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
                if(!empty($arrVivi['U_DPTO'])) {
                    $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 1, 'valor' => $arrVivi['U_DPTO']));
                    if(count($padre) > 0) {
                        $arrMunicipios = $this->config->item('municipiosFiltro')[$padre[0]['ID']];
                    }
                } else {
                    $arrMunicipios = array();
                }
                if(count($arrMunicipios) > 0) {
                    foreach ($arrMunicipios as $km => $vm) {
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
            /*Fin caga pregunta departamento y municipio*/

            // if($vv['REFERENCIA_HTML'] == 'clase') {
            //     if(!empty($vv['OPCIONES'])) {
            //         // pr($vv['OPCIONES']);die();
            //         foreach ($vv['OPCIONES'] as $ko => $vo) {
            //             $this->data['var'][$kv]['OPCIONES'][$ko]['DESCRIPCION_OPCION'] = $this->mform->asignarValorEtiqueta($vo['DESCRIPCION_OPCION']);
            //         }
            //         // pr($this->data['var'][$kv]['OPCIONES']); die();
            //         foreach ($this->data['var'] as $kp => $vp) {
            //             if($vp['REFERENCIA_HTML'] == 'localidad') {
            //                 if(!empty($arrVivi['U_MPIO'])) {
            //                     $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
            //                     if(count($padre) > 0) {
            //                         $arrLocalidades = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO'], 'idPadre' => $padre[0]['ID']));
            //                         if(count($arrLocalidades) > 0) {
            //                             foreach ($arrLocalidades as $kl => $vl) {
            //                                 $this->data['var'][$kp]['OPCIONES'][$kl] = array(
            //                                     'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
            //                                     'ID_OPCION' => $vl['ID_VALOR'],
            //                                     'DESCRIPCION_OPCION' => $vl['ETIQUETA'],
            //                                     'AYUDA' => '',
            //                                     'ORDEN_VISUAL' => $vl['ID_VALOR']
            //                                 );
            //                             }
            //                         }
            //                     }
            //                 }
            //                 if(count($arrLocalidades) > 0) {
            //                     $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
            //                 }
            //                 unset($this->data['var'][$kp]);
            //             }
            //             if($vp['REFERENCIA_HTML'] == 'centro_poblado') {
            //                 if(!empty($arrVivi['U_MPIO'])) {
            //                     $padre = $this->mform->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $arrVivi['U_MPIO']));
            //                     if(count($padre) > 0) {
            //                         $arrPoblados = $this->mform->consultarRespuestaDominio(array('idDominio' => $vp['FK_ID_DOMINIO'], 'idPadre' => $padre[0]['ID']));
            //                         if(count($arrPoblados) > 0) {
            //                             foreach ($arrPoblados as $kpo => $vpo) {
            //                                 $this->data['var'][$kp]['OPCIONES'][$kpo] = array(
            //                                     'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
            //                                     'ID_OPCION' => $vpo['ID_VALOR'],
            //                                     'DESCRIPCION_OPCION' => $vpo['ETIQUETA'],
            //                                     'AYUDA' => '',
            //                                     'ORDEN_VISUAL' => $vpo['ID_VALOR']
            //                                 );
            //                             }
            //                             $this->data['var'][$kp]['OPCIONES'][$kpo] = array(
            //                                 'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
            //                                 'ID_OPCION' => 888,
            //                                 'DESCRIPCION_OPCION' => 'OTRO',
            //                                 'AYUDA' => '',
            //                                 'ORDEN_VISUAL' => 888
            //                             );
            //                         }
            //                     }
            //                 }
            //                 if(count($arrPoblados) > 0) {
            //                     $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
            //                 }
            //                 unset($this->data['var'][$kp]);
            //             }
            //             if($vp['REFERENCIA_HTML'] == 'otro_centro_poblado') {
            //                         // Queda en la segunda opcion de clase y se oculta si no tiene valor
            //                 $this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][] = $this->data['var'][$kp];
            //                 if(empty($vp['VALOR'])) {
            //                             //$this->data['var'][$kv]['OPCIONES'][1]['PREGUNTA'][1]['HIDDEN'] = 'SI';
            //                 }
            //                 unset($this->data['var'][$kp]);
            //             }
            //             if($vp['REFERENCIA_HTML'] == 'tipo_centro') {
            //                 $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
            //                 unset($this->data['var'][$kp]);
            //             }
            //             if($vp['REFERENCIA_HTML'] == 'tipo_rural') {
            //                 if($arrVivi['U_DPTO'] != 44) {
            //                     unset($this->data['var'][$kp]['OPCIONES'][2]);
            //                 }
            //                 $this->data['var'][$kv]['OPCIONES'][$vp['VALOR_DEPEN'] - 1]['PREGUNTA'][] = $this->data['var'][$kp];
            //                 unset($this->data['var'][$kp]);
            //             }
            //         }
            //     }
            // }

            // if($vv['REFERENCIA_HTML'] == 'tipo_lugar') {
            //     if(!empty($arrVivi['UA_CLASE'])) {
            //         switch ($arrVivi['UA_CLASE']) {
            //             case 1:
            //             unset($this->data['var'][$kv]);
            //             break;
            //             case 2:
            //             unset($this->data['var'][$kv]['OPCIONES'][0], $this->data['var'][$kv]['OPCIONES'][3], $this->data['var'][$kv]['OPCIONES'][4]);
            //             break;
            //             case 3:
            //             /*if($arrVivi['U_DPTO'] == 44) {
            //                 unset($this->data['var'][$kv]);
            //             } else {
            //                 unset($this->data['var'][$kv]['OPCIONES'][0]);
            //             }*/

            //             //Se modifican las opciones a mostrar al seleccionar el departamento de La Gaujira y ubicación rural.
            //             if($arrVivi['U_DPTO'] != 44) {
            //                 unset($this->data['var'][$kv]['OPCIONES'][0]);
            //                 unset($this->data['var'][$kv]['OPCIONES'][3]);
            //             } else {
            //                 unset($this->data['var'][$kv]['OPCIONES'][0]);
            //             }
            //             break;
            //         }
            //     }
            // }

            // if($vv['REFERENCIA_HTML'] == 'nombre_lugar') {
            //     if(!empty($arrVivi['UA_CLASE'])) {
            //         $nombreLugar = '';
            //         switch ($arrVivi['UA_CLASE']) {
            //             case 1:
            //             //$nombreLugar = 'Escriba el nombre de su ' . $arrTipoClase[1];
            //             $nombreLugar = '¿Cómo es el nombre del ' . $arrTipoClase[1] . ' donde vive?';
            //             break;
            //             case 2:
            //             //$nombreLugar = 'Escriba el nombre de su Corrregimiento o Vereda';
            //             $nombreLugar = '¿Cómo es el nombre del Corrregimiento o Vereda donde vive?';
            //             /*if(!empty($arrVivi['UVA1_TIPO_BAVERCO'])) {
            //                 switch ($arrVivi['UVA1_TIPO_BAVERCO']) {
            //                     case 2:
            //                         $nombreLugar = '¿Cómo es el nombre del ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
            //                         break;
            //                     case 3:
            //                         $nombreLugar = '¿Cómo es el nombre de la ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
            //                         break;
            //                 }
            //             }*/
            //             break;
            //             case 3:
            //             //$nombreLugar = 'Escriba el nombre de su Corrregimiento, Vereda o Comunidad';
            //             $nombreLugar = '¿Cómo es el nombre del Corrregimiento, Vereda o Comunidad donde vive?';
            //             if(!empty($arrVivi['UVA1_TIPO_BAVERCO'])) {
            //                 switch ($arrVivi['UVA1_TIPO_BAVERCO']) {
            //                     case 2:
            //                     $nombreLugar = '¿Cómo es el nombre del ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
            //                     break;
            //                     case 3:
            //                     case 5:
            //                     $nombreLugar = '¿Cómo es el nombre de la ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']] . ' donde vive?';
            //                     break;
            //                 }
            //             }
            //             if(!empty($arrVivi['UVA1_TIPO_BAVERCO'])) {
            //                 $nombreLugar = 'Escriba el nombre de su ' . $arrTipoClase[$arrVivi['UVA1_TIPO_BAVERCO']];
            //             }
            //             if($arrVivi['U_DPTO'] == 44) {
            //                 $nombreLugar = 'Escriba el nombre de su ranchería';
            //             }
            //             break;
            //         }

            //         if(!empty($nombreLugar)) {
            //             $this->data['var'][$kv]['DESCRIPCION'] = str_replace('#NOMBRE_LUGAR#', $nombreLugar, $this->data['var'][$kv]['DESCRIPCION']);
            //         }
            //     }
            // }
        }
        // if(!empty($this->data['var'])) {
        //     foreach ($this->data['var'] as $kv => $vv) {
        //         if(!empty($vv['ID_PREGUNTA_DEPEN'])) {
        //             $this->data['var'][$kv]['HIDDEN'] = 'SI';
        //             if(!empty($arrVivi[$vv['ID_PREGUNTA_DEPEN']]) && $arrVivi[$vv['ID_PREGUNTA_DEPEN']] == $vv['VALOR_DEPEN']) {
        //                 $this->data['var'][$kv]['HIDDEN'] = 'NO';
        //             }
        //         }
        //         // pr($this->data['var']);
        //     }
        //     // die();
        // }
        // die();

        // $postt = $this->input->post(null, true);
        // if (!empty($postt) && count($postt) > 0) {}
        // pr($this->data);
        // die();
        $this->load->view('layout', $this->data);
    }

    public function saveUbica(){
        // if(!$this->input->is_ajax_request()) {
        //     show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
        //     return false;
        // }

        $response['error'] = false;
        $response['message'] = '';

        $postt = $this->input->post(null, true);
        if (!empty($postt) && count($postt) > 0) {
            pr($postt);

            die();
        }


        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }
    public function vivienda(){
        pr($this->session->encuesta);

        $this->data['header'] = 'header';
        $this->data['footer'] = 'footer';
        $this->data['title'] = 'Digitacion';
        $this->data['arrJS'][] = base_url_js('digitacion/vivienda.js');
        // if (strcmp($this->session->control['ID_ESTADO_AC'], 5) !== 0){
        //     redirect( $this->url.'/formulario');
        // }

        $this->construirPreguntas($tabla = 'ECP_VIVIENDA');
        // pr($this->data['preguntas']);die();
        $this->data['var'] = $this->data['preguntas'];

        // foreach ($this->data['var'] as $kv => $vv) {
        //     if(!empty($vv['ID_PREGUNTA_DEPEN'])) {
        //         $this->data['var'][$kv]['HIDDEN'] = 'SI';
        //         if(!empty($arrVivi[$vv['ID_PREGUNTA_DEPEN']]) && $arrVivi[$vv['ID_PREGUNTA_DEPEN']] == $vv['VALOR_DEPEN']) {
        //             $this->data['var'][$kv]['HIDDEN'] = 'NO';
        //         }
        //     }
        // }

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
                // if(!empty($arrVivi['VC_ALC']) && $arrVivi['VC_ALC'] == 2) {
                //     unset($this->data['var'][$kv]['OPCIONES'][0]);
                // }
                    //Se agrega esta validación para remover la opción de no tiene paredes, cuando se selecciona en tipo de vievienda casa, apartamento o tipo cuarto
            } else if($vv['REFERENCIA_HTML'] == 'material_pared') {
                // if($arrVivi['V_TIPO_VIV'] < 4) {
                //     unset($this->data['var'][$kv]['OPCIONES'][8]);
                // }
            }
        }

        $this->load->view('layout', $this->data);
    }

    public function hogar(){
        pr($this->session->encuesta);

        $this->data['header'] = 'header';
        $this->data['footer'] = 'footer';
        $this->data['title'] = 'Digitacion';
        $this->data['arrJS'][] = base_url_js('digitacion/hogar.js');
        $this->data['mostrarSituaciones'] = 'NO';
        // if (strcmp($this->session->control['ID_ESTADO_AC'], 7) !== 0){
        //     redirect( $this->url.'/formulario');
        // }

        $this->construirPreguntas($tabla = 'ECP_HOGAR');
        // pr($this->data['preguntas']);die();
        $this->data['var'] = $this->data['preguntas'];

        if(!empty($this->data['var'])) {
            foreach ($this->data["var"] as $kv => $vv) {
                if(!empty($vv['ID_PREGUNTA_DEPEN'])) {
                    $this->data["var"][$kv]['HIDDEN'] = 'SI';
                    if(!empty($arrHogar[$vv['ID_PREGUNTA_DEPEN']]) && $arrHogar[$vv['ID_PREGUNTA_DEPEN']] == $vv['VALOR_DEPEN']) {
                        $this->data["var"][$kv]['HIDDEN'] = 'NO';
                    }
                }
                $this->data["var"][$kv]['VIDEO'] = '';
                if(!empty($vv['URL_VIDEO'])) {
                    $this->data["mostrarVideo"] = 'SI';
                    $this->data["var"][$kv]['VIDEO'] = $vv['URL_VIDEO'];
                    $this->data['URLVideo'] = $vv['URL_VIDEO'];
                }
            }
        }

        foreach ($this->data['var'] as $kv => $vv) {
            if($vv["REFERENCIA_HTML"] == 'numero_cuartos' || $vv["REFERENCIA_HTML"] == 'numero_dormitorios' || $vv["REFERENCIA_HTML"] ==  'numero_fallecidas') {
                for($i = 1; $i <= 20; $i++) {
                    $this->data['var'][$kv]['OPCIONES'][$i - 1] = array(
                        'REFERENCIA_HTML' => $vv['REFERENCIA_HTML'],
                        'ID_OPCION' => $i,
                        'DESCRIPCION_OPCION' => $i,
                        'AYUDA' => '',
                        'ORDEN_VISUAL' => $i
                    );
                }
            }

            if($vv['ID_PREGUNTA_FORMULARIO'] == 607){
                unset($this->data['var'][$kv]);
            }
        }
        $this->load->view('layout', $this->data);
    }



/* =========================================================================================================== */
    /**
     * Se consulta y/o se construye el archivo de preguntas con sus opciones
     * y el total de paginas
     * @author oagarzond
     * @since 2017-08-14
     */
    private function construirPreguntas($tabla = '', $pagina = '') {
        $this->load->model('modform', 'mform');

        $preguntas = $this->mform->extraerPreguntas($tabla);

        $pt = [];
        foreach ($preguntas as $key => $value) {
            $pt = array_merge($pt, $value);
        }

        $this->data['preguntas'] = $pt;
        // $this->data['totalPaginas'] = count($this->data['preguntas']);
        // $this->data['preguntas'][++$this->data['totalPaginas']]['ubicacion_exitoso'] = 'SI';
    }

/* =========================================================================================================== */

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