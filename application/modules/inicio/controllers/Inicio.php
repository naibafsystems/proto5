<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de inicio
 * @author oagarzond
 * @since 2016-06-10
 */
class Inicio extends MX_Controller {
    var $data;
    
    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = $this->data['msgWelcome'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['header'] = 'breadcrumb';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['footer'] = 'progressBar';
    }

    public function index() {
        //pr($this->session->all_userdata()); 
        //exit;
        $arrFechasDili = $this->config->item('diligenciamiento');
        $restaIni = restar_fechas(date('Y-m-d'), $arrFechasDili['fechaIni']);
        $restaFin = restar_fechas($arrFechasDili['fechaFin'], date('Y-m-d'));
        /*if($restaIni < 0 || $restaFin < 0) {
            $this->data['view'] = 'finalizado';
            $this->data['title'] = 'Tiempo de diligenciamiento terminado';
            $this->load->view('layout', $this->data);
            return false;
        }*/
        
        $this->load->model('encuesta/modencuesta', 'mencu');
        $this->load->model('personas/modpersonas', 'mpers');
        //$this->load->helper('url');
        $this->data['view'] = 'inicio';
        $this->data['title'] = 'Inicio';
        $this->data['breadcrumb'] = '';
        $this->data['avance'] = '0%';
        //$this->data['breadcrumb'] = '<ol class='breadcrumb'><li class='breadcrumb-item active'>Inicio</li></ol>';
        $this->data['descargarCertificado'] = 'NO';
        
        $idPers = $this->session->userdata('idPers');
        $estado = $this->session->userdata('estado');
        $tipoUsua = $this->session->userdata('tipoUsua');
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        if($estado == 10) {
            // Se acutaliza el estado a terminó encuesta
            $this->mencu->setCodiEncuesta($codiEncuesta);
            if($this->mencu->actualizarAdminControl(array('ID_ESTADO_AC' => 11))) {
                redirect(base_url('encuesta'));
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se pudo guardar los datos de el Admin Control.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
            }
        } else if($estado == 11) {
            $this->data['descargarCertificado'] = 'SI';
        } else if($estado == 12) {
            redirect(base_url('encuesta'));
        }
        // Se verifica que todas las personas hayan terminado la encuesta para mostrar el boton del certificado
        $arrParam = array(
            'codiEncuesta' => $codiEncuesta,
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'sidx' => 'PR.RA1_NRO_RESI'
        );
        $arrACP = $this->mpers->consultarControlPersonasResidentes($arrParam);
        //pr($arrACP); exit;
        if(count($arrACP) > 0) {
            foreach ($arrACP as $kACP => $vACP) {
                if(empty($vACP['FECHA_FIN_PERS'])) {
                    $this->data['descargarCertificado'] = 'NO';
                    break;
                }
            }
        }
        //pr($this->data); exit;
        $this->load->view('layout', $this->data);
    }

    public function setVariables(){

        $this->load->model('soporte/Moddigitacion', 'digitacion');
        $cod_encuesta = $_POST['encuesta'];
        $ids = $this->digitacion->consultarId($cod_encuesta);

        $the_session = array("codiEncuesta" => $cod_encuesta, "estado" => "1", "codiVivienda" => $ids[0]['ID_VIVIENDA'], "codiHogar" => $ids[0]['ID_HOGAR']);
        $this->session->set_userdata($the_session);

         $this->load->model('encuesta/modencuesta', 'mencu');
         $this->load->model('hogar/modhogar', 'mhogar');
         $this->load->model('personas/modpersonas', 'mpers');
         $this->data['idUsua'] = $this->session->userdata('id');
         $this->data['codiEncuesta'] = $this->session->userdata('codiEncuesta');
         $arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $this->data['codiEncuesta']));
         if(count($arrAC) > 0) {
            $sessionData['estado'] = $arrAC[0]['ID_ESTADO_AC'];
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
        }

        $the_session = array("fechaInscripcion" => 'SYSDATE', "fechaFinUbi" => 'SYSDATE', "fechaFinVivi" => 'SYSDATE', "fechaFinHogar" => 'SYSDATE', "fechaFinPers" => 'SYSDATE', );
        $this->session->set_userdata($the_session);

    }

    public function consultarEstado() {
        //pr($this->session->all_userdata()); exit;
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['ubicacion'] = 1;
        $response['vivienda'] = $response['hogar'] = $response['personas'] = 2;
        $response['avance'] = '0%';
        //@todo: Se debe comentar para que inicie desde Ubicación
        /*$response['ubicacion'] = 2;
        $response['vivienda'] = 1;
        $response['avance'] = '25%';*/

        $this->load->model('encuesta/modencuesta', 'mencu');

        $idUsua = $this->session->userdata('id');

        $codiEncuesta = $this->session->userdata('codiEncuesta');

        try {
            $arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
            if(count($arrAC) > 0) {
                $arrAC = array_shift($arrAC);
                if(!empty($arrAC['FECHA_INI_UBICACION']) && !empty($arrAC['FECHA_FIN_UBICACION'])) {
                    $response['ubicacion'] = 2;
                    $response['vivienda'] = 1;
                    $response['hogar'] = 2;
                    $response['personas'] = 2;
                    $response['avance'] = '25%';
                }
                if(!empty($arrAC['FECHA_INI_VIVIENDA']) && !empty($arrAC['FECHA_FIN_VIVIENDA'])) {
                    $response['ubicacion'] = 2;
                    $response['vivienda'] = 2;
                    $response['hogar'] = 1;
                    $response['personas'] = 2;
                    $response['avance'] = '50%';
                }
                if(!empty($arrAC['FECHA_INI_HOGAR']) && !empty($arrAC['FECHA_FIN_HOGAR'])) {
                    $response['ubicacion'] = 2;
                    $response['vivienda'] = 2;
                    $response['hogar'] = 2;
                    $response['personas'] = 1;
                    $response['avance'] = '75%';
                }
                if(!empty($arrAC['FECHA_INI_PERSONAS']) && !empty($arrAC['FECHA_FIN_PERSONAS'])) {
                    $response['ubicacion'] = 2;
                    $response['vivienda'] = 2;
                    $response['hogar'] = 2;
                    $response['personas'] = 2;
                    $response['avance'] = '100%';
                }
            } else {
                $response['codiError'] = 1;
                $response['mensaje'] = 'No se encontro información de la encuesta.';
                throw new Exception($response['mensaje'], $response['codiError']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . $e->getMessage() . '</strong>');
            return false;
        }
        
        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }
}
//EOC