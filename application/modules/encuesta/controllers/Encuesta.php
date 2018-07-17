<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de encuesta
 * @author oagarzond
 * @since 2017-03-08
 */
class Encuesta extends MX_Controller {
    var $data;

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = '';
        $this->data['module'] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    public function index() {
        //pr($this->session->all_userdata()); exit;
        $this->constancia();
    }

    /**
     * Verifica que el usuario logueado es administrador
     * @author oagarzond
     * @since 2017-06-05
     */
    private function esAdmin() {
        $esAdmin = $this->session->userdata('esAdmin');
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
        $esAdmin = $this->session->userdata('esAdmin');
        $esSoporte = $this->session->userdata('esSoporte');
        if(empty($esAdmin) && empty($esSoporte)) {
            $this->session->set_flashdata('msgError', 'No puede ingresar a este módulo.');
            redirect(base_url('admin'), '', 'refresh');
        }
    }

    /**
     * Muestra la ventana con el tutorial en video
     * @author oagarzond
     * @since 2017-06-30
     */
    public function conocerCenso() {
        $this->data['title'] = 'Conozca sobre CNPV';
        $this->data['view'] = 'conocerCenso';
        if(!$this->input->is_ajax_request()) {
            $this->data['title1'] = $this->data['title'];
            $this->load->view('layout', $this->data);
        } else {
            $vista['title'] = $this->data['title'];
            $vista['view'] = $this->load->view( $this->data['view'], $this->data, true);
            $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($vista));
        }
    }

    /**
     * Muestra el texto de los terminos y condiciones
     * @author oagarzond
     * @since 2017-06-30
     */
    public function conocerLey() {
        $this->data['title'] = 'Conozca la ley de reserva estadística';
        $this->data['view'] = 'reservaEstadistica';
        if(!$this->input->is_ajax_request()) {
            $this->data['title1'] = $this->data['title'];
            $this->load->view('layout', $this->data);
        } else {
            $vista['title'] = $this->data['title'];
            $vista['view'] = $this->load->view( $this->data['view'], $this->data, true);
            $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($vista));
        }
    }

    /**
     * Muestra el texto de los terminos y condiciones
     * @author oagarzond
     * @since 2017-02-27
     */
    public function terminosCondiciones() {
        $this->data['title'] = 'Términos y condiciones';
        $this->data['view'] = 'terminosCondiciones';
        if(!$this->input->is_ajax_request()) {
            $this->data['title1'] = $this->data['title'];
            $this->load->view('layout', $this->data);
        } else {
            $vista['title'] = $this->data['title'];
            $vista['view'] = $this->load->view( $this->data['view'], $this->data, true);
            $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($vista));
        }
    }

    /**
     * Muestra la ventana con el tutorial en video
     * @author oagarzond
     * @since 2017-02-27
     */
    public function videoTutorial() {
        $this->data['title'] = 'Video tutorial de la inscripción';
        $this->data['view'] = 'video';
        if(!$this->input->is_ajax_request()) {
            $this->data['title1'] = $this->data['title'];
            $this->load->view('layout', $this->data);
        } else {
            $vista['title'] = $this->data['title'];
            $vista['view'] = $this->load->view( $this->data['view'], $this->data, true);
            $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($vista));
        }
    }

    /**
     * Termina la encuesta y actualiza los estados
     * @author oagarzond
     * @since 2017-12-04
     */
    private function terminar() {
        $this->load->model('modencuesta', 'mencu');
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        $arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        //pr($arrAC); exit;
        if(count($arrAC) > 0) {
            if(in_array($arrAC[0]['ID_ESTADO_AC'], array(10, 11))) {
                $this->mencu->setCodiEncuesta($codiEncuesta);
                $this->mencu->setCodiVivienda($this->session->userdata('codiVivienda'));
                $this->mencu->setCodiHogar($this->session->userdata('codiHogar'));
                if($this->mencu->actualizarAdminControl(array('ID_ESTADO_AC' => 12))) {
                    if($this->mencu->actualizarEncuestas(array('fin' => 'SI'))) {
                        if($this->mencu->actualizarResultadoEntrevista(1)) {
                            if(!$this->mencu->actualizarFormato1(array('CC_RES_ENC' => 1))) {
                                $this->data['msgError'] = 'No se pudo actualizar los datos del Formato 1.';
                                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
                                return false;
                            }
                        } else {
                            $this->data['msgError'] = 'No se pudo guardar los datos del Resultados entrevista.';
                            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
                            return false;
                        }
                    } else {
                        $this->data['msgError'] = 'No se pudo guardar los datos de la encuesta.';
                        log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
                        return false;
                    }
                } else {
                    $this->data['msgError'] = 'No se pudo guardar los datos de el Admin Control.';
                    log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
                    return false;
                }
            } else if($arrAC[0]['ID_ESTADO_AC'] == 12) {
                return true;
            } else {
                $this->data['msgError'] = 'No se ha completado toda las secciones.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->data['msgError']);
                return false;
            }
        } else {
            $this->data['msgError'] = 'No se encontraron datos de el Admin Control.';
            log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->data['msgError']);
            return false;
        }
        return true;
    }

    /**
     * Envia el correo electronico al finalizar correctamente la encuesta
     * @author oagarzond
     * @since 2017-12-09
     */
    private function enviarCorreoFinalizar() {
        try {
            $this->load->library('email');
            $this->load->model('modform', 'mform');
            $this->load->model('usuarios/modusuarios', 'musua');
            $this->load->model('personas/modpersonas', 'mpers');

            $codiEncuesta = $this->session->userdata('codiEncuesta');
            $arrUsua = $this->musua->consultarAdminUsuarios(array('codiEncuesta' => $codiEncuesta));
            if(count($arrUsua) == 0) {
                //$response['codiError'] = 2;
                $this->data['msgError'] = ' No se encontró información del usuario para la encuesta ' . $codiEncuesta . '.';
                throw new Exception($response['mensaje'], 0);
            }

            $nombre = '';
            $listaPersonas = '';
            $fechaHoraActual = $this->musua->consultar_fecha_hora();
            $fechaActual = substr($fechaHoraActual, 0, 10);
            $arrPers = array();
            $arrUsua = array_shift($arrUsua);
            $arrParam = array(
                'codiEncuesta' => $arrUsua['COD_ENCUESTAS'],
                'sidx' => 'PR.RA1_NRO_RESI',
                'sord' => 'ASC'
            );
            $arrPersResi = $this->mpers->consultarPersonas($arrParam);
            if(count($arrPersResi) > 0) {
                $arrTipoDocus = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
                foreach ($arrPersResi as $kpers => $vpers) {
                    $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['nombre'] = $vpers['nombre'];
                    $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['jefe'] = 'NO';
                    $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['numero_docu'] = $vpers['PA1_NRO_DOC'];
                    if($vpers['RA1_NRO_RESI'] == 1) {  // Es el jefe(a) del hogar
                        $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['jefe'] = 'SI';
                    }
                    if(!empty($arrUsua['ID_PERSONA_RESIDENTE']) && $vpers['ID_PERSONA_RESIDENTE'] == $arrUsua['ID_PERSONA_RESIDENTE']) {
                        $nombre = $vpers['nombre'];
                    }
                    foreach ($arrTipoDocus as $ktd => $vtd) {
                        if($vtd['ID_VALOR'] == $vpers['PA_TIPO_DOC']) {
                            $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['tipo_docu'] = $vtd['DESCRIPCION'];
                        }
                    }
                }
            }
            if(empty($nombre)) {
                $nombre = $arrUsua['NOMBRES'] . ' ' . $arrUsua['APELLIDOS'];
            }

            if(count($arrPers) > 0) {
                $listaPersonas = '<ul>';
                foreach ($arrPers as $kpers => $vpers) {
                    $listaPersonas .= '<li>' . $vpers['nombre'] . ' - ' . $vpers['tipo_docu'] . ' - ' . $vpers['numero_docu'];
                    if($vpers['jefe'] == 'SI') {
                        $listaPersonas .= ' (Jefe(a) del hogar)';
                    }
                    $listaPersonas .= '</li>';
                }
                $listaPersonas .= '</ul>';
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
            $this->data['email'] = $arrUsua['USUARIO'];
            $this->data['nombreUsuario'] = $nombre;
            $this->data['fecha'] = obtener_texto_fecha(formatear_fecha($fechaActual));
            $this->data['codiEncuesta'] = $codiEncuesta;
            $this->data['listaPersonas'] = $listaPersonas;
            $this->email->from($this->config->item('correoContacto'), $this->config->item('nombreEntidad'));
            //$this->email->to('oagarzond@dane.gov.co');
            $this->email->to($this->data['email']);
            $this->email->subject('Ha finalizado el eCenso - ' . $this->config->item('nombreEntidad'));
            $html = $this->load->view('mailFinalizadoeCenso', $this->data, true);
            //pr($html); exit;
            $this->email->message($html);
            //var_dump($this->email->print_debugger()); exit;
            if ($this->email->send()) {
                $this->data['msgSuccess'] = '<strong>Mensaje enviado.</strong> Su contrase&ntilde;a ha sido enviada a la direcci&oacute;n de correo indicada.';
            } else {
                //pr($this->email->print_debugger(array('headers'))); exit;
                //$response['codiError'] = 1;
                $this->data['msgError'] = 'No se pudo enviar el correo electrónico. Por favor inténtelo más tarde.';
                log_message('error', 'Usuario: ' . $this->data['email'] . '-' . $this->email->print_debugger(array('headers')));
                throw new Exception($this->data['msgError'], 1);
            }
            return true;
        } catch (Exception $e) {
            log_message('error', 'Error en la línea ' . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <strong>' . $e->getMessage() . '</strong>');
            return false;
        }
    }

    /**
     * Muestra la ventana con la pregunta para finalizar el eCenso
     * @author oagarzond
     * @since 2017-12-04
     */
    public function finalizareCenso() {
        $this->data['title'] = 'Finalizar eCenso';
        $this->data['view'] = 'finalizareCenso';
        if(!$this->input->is_ajax_request()) {
            $this->data['header'] = 'breadcrumb';
            $this->data['breadcrumb'] = '<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
                <li class="breadcrumb-item active">Finalizar eCenso</li>
            </ol>';
            $this->data['title1'] = $this->data['title'];
            $this->data['footer'] = 'footer';
            $this->load->view('layout', $this->data);
        } else {
            $vista['title'] = $this->data['title'];
            $vista['view'] = $this->load->view( $this->data['view'], $this->data, true);
            $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($vista));
        }
    }

    /**
     * Finaliza la encuesta
     * @author oagarzond
     * @since 2017-12-04
     */
    public function finalizar() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $postt = $this->input->post(NULL, TRUE);
        //pr($postt); exit;
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }
        $codiEncuesta = $this->session->userdata('codiEncuesta');

        if($postt['finalizar_ecenso'] == 1) {
            if(!$this->terminar()) {
                $response['codiError'] = 1;
                $response['mensaje'] = $this->data['msgError'];
            } else {
                $response['mensaje'] = 'Se finalizó correctamente la encuesta.';
                /*if($this->enviarCorreoFinalizar()) {
                    $response['mensaje'] .= ' ' . '<strong>Mensaje enviado.</strong> Su contrase&ntilde;a ha sido enviada a la direcci&oacute;n de correo indicada.';
                } else {
                    $response['mensaje'] .= ' ' . 'No se pudo enviar el correo electrónico. Por favor inténtelo más tarde.';
                }*/
            }
        } else if($postt['finalizar_ecenso'] == 2) {
            $this->load->model('modencuesta', 'mencu');

            $this->mencu->setCodiEncuesta($codiEncuesta);
            $this->mencu->setCodiVivienda($this->session->userdata('codiVivienda'));
            $this->mencu->setCodiHogar($this->session->userdata('codiHogar'));
            if($this->mencu->actualizarAdminControl(array('ID_ESTADO_AC' => 11))) {
                $response['mensaje'] = 'Se guardó correctamente la encuesta.';
            } else {
                $response['codiError'] = 1;
                $this->data['mensaje'] = 'No se pudo guardar los datos de el Admin Control.';
                log_message('error', 'Codigo de encuesta: ' . $codiEncuesta . '. ' . $this->mencu->getMsgError());
                return false;
            }
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Permite consultar la constancia de diligenciamiento desde QR o enlace directo
     * @author oagarzond
     * @since 2017-04-27
     */
    public function constancia() {
        //pr($this->session->all_userdata()); exit;
        $this->data['view'] = 'constancia';
        $this->data['header'] = 'breadcrumb';
        $this->data['title'] = 'Constancia de diligenciamiento';
        $this->data['breadcrumb'] = '<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . base_url('inicio') . '">Inicio</a></li>
            <li class="breadcrumb-item active">Constancia</li>
        </ol>';
        $this->load->model('modencuesta', 'mencu');

        $idUsua = $this->session->userdata('id');
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $estadoActual = $this->session->userdata('estado');
        $fechaCertificado = $this->session->userdata('fechaCertificado');
        $this->data['nombrePersona'] = mayuscula_inicial($this->session->userdata('nombre'));
        $this->data['imagenQR'] = '';
        $this->data['codiVerificacion'] = $codiEncuesta;
        //$arrAC = $this->mencu->consultarAdminControl(array('codiEncuesta' => $codiEncuesta));
        if($estadoActual == 12) {
            $this->data['imagenQR'] = '<img src="' . base_url('encuesta/finalizadoQR/' . $codiEncuesta) . '" alt="Código QR para descargar la constancia de diligenciamiento" class="img-responsive img-QR" />';
        } else {
            if($estadoActual < 11) {
                $this->session->set_flashdata('msgError', 'No se ha completado la totalidad de la encuesta.');
            }
            redirect(base_url('inicio'));
            return false;
        }
        //pr($this->data); exit;
        $this->load->view('layout', $this->data);
    }

    /**
     * Genera imágenes QR a partir del código que se recibe por parámetro
     * @author dmdiazf
     * @author oagarzond
     * @since 2017-04-27
     */
    public function finalizadoQR($codigo) {
        $this->load->library('phpqrcode');

        $this->phpqrcode->setCode($codigo);
        $this->phpqrcode->setLink(base_url('encuesta/generarConstancia'));
        $this->phpqrcode->generateQRImage($codigo);
        Header('Content-type: image/png');
        echo file_get_contents(base_dir_files('QR/' . $codigo . '.png'));
    }

    /**
     * Genera la constancia de diligenciamiento en HTML
     * @author oagarzond
     * @since 2017-12-09
     */
    public function generarConstancia() {
        if(!$this->terminar()) {
            echo $this->data['msgError'];
            return false;
        }
        //pr($this->session->all_userdata()); exit;
        $this->load->model('modform', 'mform');
        $this->load->model('personas/modpersonas', 'mpers');
        $codiEncuesta = $this->data['codiEncuesta'] = $this->session->userdata('codiEncuesta');
        $estadoActual = $this->session->userdata('estado');
        $fechaCertificado = $this->session->userdata('fechaCertificado');
        if(!empty($fechaCertificado)) {
            $fechaCertificado = date('d/m/Y');
        }

        $this->data['view'] = 'constanciaHTML';
        $this->data['title'] = 'Constancia';
        $this->data['ecensoHeader'] = '<img src="' . base_url_images('certificateHeader.png') . '" />';
        //$this->data['ecensoHeader'] = '';
        $this->data['ecensoFooter'] = '<img src="' . base_url_images('certificateFooter.png') . '" />';
        //$this->data['ecensoFooter'] = '';
        $this->data['expedicion'] = obtener_texto_fecha(formatear_fecha($fechaCertificado));

        $arrParam = array(
            'codiEncuesta' => $codiEncuesta,
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'idPers' => $this->session->userdata('idPers')
        );
        $arrPersona = $this->mpers->consultarPersonas($arrParam);
        $arrParam = array(
            'codiEncuesta' => $codiEncuesta,
            'sidx' => 'PR.RA1_NRO_RESI',
            'sord' => 'ASC'
        );
        $arrPersResi = $this->mpers->consultarPersonas($arrParam);
        if(count($arrPersResi) > 0) {
            $arrTipoDocus = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
            foreach ($arrPersResi as $kpers => $vpers) {
                $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['nombre'] = $vpers['nombre'];
                $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['jefe'] = 'NO';
                $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['numero_docu'] = $vpers['PA1_NRO_DOC'];
                if($vpers['RA1_NRO_RESI'] == 1) {  // Es el jefe(a) del hogar
                    $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['jefe'] = 'SI';
                }
                if(!empty($arrUsua['ID_PERSONA_RESIDENTE']) && $vpers['ID_PERSONA_RESIDENTE'] == $arrUsua['ID_PERSONA_RESIDENTE']) {
                    $nombre = $vpers['nombre'];
                }
                foreach ($arrTipoDocus as $ktd => $vtd) {
                    if($vtd['ID_VALOR'] == $vpers['PA_TIPO_DOC']) {
                        $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['tipo_docu'] = $vtd['DESCRIPCION'];
                    }
                }
            }
        }

        if(count($arrPers) > 0) {
            $this->data['listaPersonas'] = '<ul>';
            foreach ($arrPers as $kpers => $vpers) {
                $this->data['listaPersonas'] .= '<li><span style="font-weight:700;">' . $vpers['nombre'] . '</span> ' . $vpers['tipo_docu'] . '  <span>' . $vpers['numero_docu'] .  '</span>';
                if($vpers['jefe'] == 'SI') {
                    //$this->data['listaPersonas'] .= ' (Jefe(a) del hogar)';
                }

                if ($vpers !== end($arrPers)) {
                    $this->data['listaPersonas'] .= ',';
                }

                $this->data['listaPersonas'] .= '</li>';
            }
            $this->data['listaPersonas'] .= '</ul>';
        }
        //pr($this->data); exit;
        $html = $this->load->view($this->data['view'], $this->data, true);
        echo $html; exit;
    }

    /**
     * Genera el PDF de la constancia de diligenciamiento
     * @author dmdiazf
     * @author oagarzond
     * @since 2017-04-27
     */
    public function generarConstanciaPDF() {
        if(!$this->terminar()) {
            echo $this->data['msgError'];
            return false;
        }
        //pr($this->session->all_userdata()); exit;
        $this->load->model('personas/modpersonas', 'mpers');
        $codiEncuesta = $this->session->userdata('codiEncuesta');
        $estadoActual = $this->session->userdata('estado');
        $fechaCertificado = $this->session->userdata('fechaCertificado');
        if(!empty($fechaCertificado)) {
            $fechaCertificado = date('d/m/Y');
        }
        $this->data['view'] = 'constanciaPDF';
        $this->data['ecensoHeader'] = '<img src="' . base_dir_images('certificateHeader.png') . '" />';
        //$this->data['ecensoHeader'] = '';
        $this->data['ecensoFooter'] = '<img src="' . base_dir_images('certificateFooter.png') . '" />';
        //$this->data['ecensoFooter'] = '';
        $this->data['expedicion'] = obtener_texto_fecha(formatear_fecha($fechaCertificado));


        $this->load->library('html2pdf');
        $this->html2pdf->folder(base_dir_files()); // Cambiar a tmp/
        $this->html2pdf->filename('constancia_cnpv-' . $codiEncuesta . '.pdf');
        $this->html2pdf->paper('letter', 'landscape');

        $arrParam = array(
            'codiEncuesta' => $codiEncuesta,
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'idPers' => $this->session->userdata('idPers')
        );
        $arrPersona = $this->mpers->consultarPersonas($arrParam);
        //pr($arrPersona); exit;
        if(count($arrPersona) > 0) {
            $arrPersona = array_shift($arrPersona);
            $this->data['nombrePersona'] = $arrPersona['nombre'];
            $this->data['cedula'] = $arrPersona['PA1_NRO_DOC'];
        }
        //pr($this->data); exit;
        $html = $this->load->view($this->data['view'], $this->data, true);
        //echo $html; exit;
        $this->html2pdf->html($html);
        $this->html2pdf->html("<div>herp</div><div>derp</div>");
        $this->html2pdf->create('');
    }

    /**
     * Muestra las preguntas que existe por pagina
     * @author oagarzond
     * @since 2017-06-12
     */
    public function verPreguntasPagina() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['view'] = '';
        $modulo = $idPers = $pagina = 0;
        $moduloAsociado = array('','Ubicación','Vivienda','Hogar','Personas','Personas Hogar');
        $tablaAsociada = array('','ECP_UBICACION','ECP_VIVIENDA','ECP_HOGAR','ECP_PERSONAS_HOGAR','ECP_PERSONAS_HOGAR_PERS');
        $postt = $this->input->post(NULL, TRUE);
        //pr($postt); exit;
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        } else {
            $modulo = $postt['modulo'];
            $pagina = $postt['pagina'];
            if(!empty($postt['idPers'])) {
                $idPers = $postt['idPers'];
            }
        }

        if(empty($modulo)) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el módulo.';
        }
        /*if(empty($idPers)) {
            $response['codiError'] = 2;
            $response['mensaje'] = 'No se definió correctamente la persona.';
        }*/
        if(empty($pagina)) {
            $response['codiError'] = 3;
            $response['mensaje'] = 'No se definió correctamente el número de la página.';
        }
        //$modulo = 3;
        //$pagina = 7;
        if($response['codiError'] == 0) {
            $this->load->model('modform', 'mform');
            $this->load->model('personas/modpersonas', 'mpers');
            if($tablaAsociada[$modulo] == 'ECP_HOGAR' && $pagina == 7) {
                $modulo = '5';
            }
            $arrPreguntas = $this->mform->consultarPreguntas($tablaAsociada[$modulo], $pagina);
            //pr($arrPreguntas); exit;
            if(count($arrPreguntas[$tablaAsociada[$modulo]][$pagina]) > 0) {
                $response['title'] = 'Preguntas de la página ' . $pagina . ' del módulo ' . $moduloAsociado[$modulo];
                if(!empty($idPers)) {
                    $arrPers = $this->mpers->consultarPersonasResidentes(array('idPers' => $idPers));
                    if(count($arrPers) > 0) {
                        $arrValores['#NOMBRE_PERS#'] = $arrPers[0]['nombre'];
                    }
                } else if($modulo == '5') {
                    $response['view'] .= '<label>Preguntas asociadas a la conformación del hogar</label><br />';
                }
                $response['view'] .= '<ul class="list-group">';
                foreach ($arrPreguntas[$tablaAsociada[$modulo]][$pagina] as $kp => $vp) {
                    if(!empty($vp['DESCRIPCION'])) {
                        if(!empty($arrValores)) {
                            $vp['DESCRIPCION'] = asignar_valor_etiqueta_valor($vp['DESCRIPCION'], $arrValores);
                        }
                        $response['view'] .= '<li class="list-group-item">' . $vp['DESCRIPCION'] . '</li>';
                    }
                }
                $response['view'] .= '</ul>';
            } else {
                $response['codiError'] = 4;
                $response['mensaje'] = 'No se encontraron preguntas para el número de la página ' . $pagina . '.';
            }
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Muestra la tabla de las fechas y hora de resultado de la entrevista
     * @author oagarzond
     * @since 2017-06-14
     */
    public function verResultadoEntrevistas() {
        if(!$this->input->is_ajax_request()) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        }

        $response['codiError'] = 0;
        $response['mensaje'] = '';
        $response['view'] = '';
        $codiEncuesta = 0;
        $postt = $this->input->post(NULL, TRUE);
        //pr($postt); exit;
        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 403, 'Acceso no autorizado');
            return false;
        } else {
            $codiEncuesta = $postt['encuesta'];
        }

        if(empty($codiEncuesta)) {
            $response['codiError'] = 1;
            $response['mensaje'] = 'No se definió correctamente el código de la encuesta.';
        }

        if($response['codiError'] == 0) {
            $this->load->model('modencuesta', 'mencu');
            $arrDatosEntrevista = $this->mencu->consultarResultadosEntrevista(array('codiEncuesta' => $codiEncuesta));
            //pr($arrDatosEntrevista); exit;
            if(count($arrDatosEntrevista) > 0) {
                $response['view'] .= '<table name="tabla_entrevistas" class="table table-bordered table-striped table-hover tabla_entrevistas" width="100%" cellspacing="0">
                        <thead>
                            <tr class="success">
                                <th>No.</th>
                                <th>Fecha inicio</th>
                                <th>Fecha final</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>';
                foreach ($arrDatosEntrevista as $kde => $vde) {
                    //'<td>' . completar_fecha($vde['CC_DIA_ENC'] . '/' . $vde['CC_MES_ENC'] . '/' . $vde['CC_ANO_ENC']) . '</td>';
                    $response['view'] .= '<tr>
                        <td>' . $vde['CC_NRO_VIS'] . '</td>
                        <td>' . $vde['FECHAINI'] . '</td>
                        <td>' . $vde['FECHAFIN'] . '</td>';
                        /*if(!empty($vde['CC_HH_INI']) && !empty($vde['CC_MM_INI'])) {
                            $response['view'] .= '<td>' . $vde['CC_HH_INI'] . ':' . $vde['CC_MM_INI'] . '</td>';
                        } else {
                            $response['view'] .= '<td></td>';
                        }
                        if(!empty($vde['CC_HH_FIN']) && !empty($vde['CC_MM_FIN'])) {
                            $response['view'] .= '<td>' . $vde['CC_HH_FIN'] . ':' . $vde['CC_MM_FIN'] . '</td>';
                        } else {
                            $response['view'] .= '<td></td>';
                        }*/
                        $response['view'] .= '<td>' . $vde['ESTADO_ENTREVISTA'] . '</td>
                    </tr>';
                }
                $response['view'] .= '</tbody></table>';
            } else {
                $response['codiError'] = 2;
                $response['mensaje'] = 'No se encontró información de respuestas de entrevista para este usuario.';
            }
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response));
    }

    /**
     * Convierte la lista de ejemplos por centro poblados en json
     * Solamente se debe ejecutar cuando se quiera recrear la lista,
     * porque se debe revisar a mano los centros poblados faltantes
     * Por ahora no se usa por el problema de codificacion de array a json con tildes
     * @author oagarzond
     * @since 2017-07-10
     */
    public function lista() {
        // El archivo .csv se debe guardar con codificacion UTF-8
        $fichero = fopen(FCPATH . 'assets/fonts/ejemplosxclase.csv', 'a+');
        $nombre_archivo = FCPATH . 'assets/fonts/ejemplosPoblado.json';
        $codigoMunicipio = '';
        $arrLista = array();
        while($linea = fgetcsv($fichero, 0, ";")){
            if(!empty($linea[0]) && strlen($linea[0]) == 8) {
                if(empty($codigoMunicipio)) {
                    $codigoMunicipio = substr($linea[0], 0, 5);
                } else {
                    $codigoMunicipio = ($codigoMunicipio == substr($linea[0], 0, 5)) ? $codigoMunicipio: substr($linea[0], 0, 5);
                }
                if(!empty($linea[1])) {
                    $arrLista[$codigoMunicipio][] = $linea[1];
                    //$arrLista[$codigoMunicipio][substr($linea[0], 5, 3)] = $linea[1];
                }
            }
        }
        //pr($arrLista); exit;
        //  Se convierte el contenido del array en json
        foreach ($arrLista as $k => $v) {
            $arr2[$k] = json_encode($v, JSON_UNESCAPED_UNICODE);
        }
        // Se guarda el contenido en un archivo json
        if (is_writable($nombre_archivo)) {
            if (!$gestor = fopen($nombre_archivo, 'a')) {
                 echo "No se puede abrir el archivo ($nombre_archivo)";
                 exit;
            }

            // Escribir $contenido a nuestro archivo abierto.
            if (fwrite($gestor, json_encode($arr2)) === FALSE) {
                echo "No se puede escribir en el archivo ($nombre_archivo)";
                exit;
            }
            //echo "Éxito, se escribió ($contenido) en el archivo ($nombre_archivo)";
            fclose($gestor);
        } else {
            echo "El archivo $nombre_archivo no es escribible";
        }

        $this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($arr2));
    }
}
//EOC