<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Formulario extends CI_Controller {

    public function index() {
        //pr($this->session->all_userdata()); exit;
        show_error('Usted no está autorizado para acceder.', 401, 'Acceso no autorizado');
        return false;
    }

    public function listaDesplegable() {
        $this->load->model("modform", "mf");
        $postt = $this->input->post(NULL, TRUE);
        // pr($postt); exit;
        $html = '';

        if (empty($postt) || count($postt) == 0) {
            show_error('Usted no está autorizado para acceder.', 401, 'Acceso no autorizado');
            return false;
        }

        switch ($postt['opc']) {
            case 'localidad':
                $padre = $this->mf->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $postt['id']));
                if(count($padre) > 0) {
                    $lista = $this->mf->consultarRespuestaDominio(array('idDominio' => 90, 'idPadre' => $padre[0]['ID']));
                    $html .= "<option value=''>Seleccione...</option>";
                    if ($lista) {
                        foreach ($lista as $fila) {
                            $html .= "<option value='" . $fila["ID_VALOR"] . "' >" . $fila["ETIQUETA"] . "</option>";
                        }
                    }
                }
                break;
            case 'poblado':
                $padre = $this->mf->consultarRespuestaDominio(array('idDominio' => 2, 'valor' => $postt['id']));
                if(count($padre) > 0) {
                    $lista = $this->mf->consultarRespuestaDominio(array('idDominio' => 91, 'idPadre' => $padre[0]['ID']));
                    $html .= "<option value=''>Seleccione...</option>";
                    if ($lista) {
                        foreach ($lista as $fila) {
                            $html .= "<option value='" . $fila["ID_VALOR"] . "' >" . $fila["ETIQUETA"] . "</option>";
                        }
                    }
                }
                break;
            case 'departamento':
                $padre = $this->mf->consultarRespuestaDominio(array('idDominio' => 1, 'valor' => $postt['id']));
                // pr($this->config->item('municipios')[$padre[0]['ID']]); die();
                if(count($padre) > 0) {
                    // $lista = $this->mf->consultarRespuestaDominio(array('idDominio' => 2, 'idPadre' => $padre[0]['ID']));
                    $lista = $this->config->item('municipiosFiltro')[$padre[0]['ID']];
                    $html .= "<option value=''>Seleccione...</option>";
                    if ($lista) {
                        foreach ($lista as $fila) {
                            //$tmpEtiqueta = explode(' - ', $fila["ETIQUETA"]);
                            //$descMuni = (!empty($tmpEtiqueta[1])) ? $tmpEtiqueta[1]: $vm["ETIQUETA"];
                            $tmpEtiqueta = $fila['ETIQUETA'];
                            $descMuni = $tmpEtiqueta;
                            $html .= "<option value='" . $fila["ID_VALOR"] . "' >" . $descMuni . "</option>";
                        }
                    }
                }
                break;
            case 'municipio':
                $padre = $this->mf->consultarRespuestaDominio(array('idDominio' => 1, 'valor' => $postt['id']));
                // pr($this->config->item('municipios')[$padre[0]['ID']]); die();
                if(count($padre) > 0) {
                    // $lista = $this->mf->consultarRespuestaDominio(array('idDominio' => 2, 'idPadre' => $padre[0]['ID']));
                    $lista = $this->config->item('municipiosFiltro')[$padre[0]['ID']];
                    $html .= "<option value=''>Seleccione...</option>";
                    if ($lista) {
                        foreach ($lista as $fila) {
                            //$tmpEtiqueta = explode(' - ', $fila["ETIQUETA"]);
                            //$descMuni = (!empty($tmpEtiqueta[1])) ? $tmpEtiqueta[1]: $vm["ETIQUETA"];
                            $tmpEtiqueta = $fila['ETIQUETA'];
                            $descMuni = $tmpEtiqueta;
                            $html .= "<option value='" . $fila["ID_VALOR"] . "' >" . $descMuni . "</option>";
                        }
                    }
                }
                break;
            case 'depto_nacimiento':
            case 'depto_5anios':
            case 'depto_1anio':
                $this->load->model("vivienda/modvivienda", "mvivi");
                $padre = $this->mf->consultarRespuestaDominio(array('idDominio' => 1, 'valor' => $postt['id']));
                if(count($padre) > 0) {
                    $arrParamVivi = array(
                        'codiEncuesta' => $this->session->userdata('codiEncuesta'),
                        'codiVivienda' => $this->session->userdata('codiVivienda')
                    );
                    $arrVivi = $this->mvivi->consultarVivienda($arrParamVivi);
                    // $lista = $this->mf->consultarRespuestaDominio(array('idDominio' => 2, 'idPadre' => $padre[0]['ID']));
                    $lista = $this->config->item('municipiosFiltro')[$padre[0]['ID']];
                    $html .= "<option value=''>Seleccione...</option>";
                    if ($lista) {
                        foreach ($lista as $fila) {
                            if($fila['ID_VALOR'] != $arrVivi[0]['U_MPIO']) {
                                //$tmpEtiqueta = explode(' - ', $fila["ETIQUETA"]);
                                //$descMuni = (!empty($tmpEtiqueta[1])) ? $tmpEtiqueta[1]: $vm["ETIQUETA"];
                                $tmpEtiqueta = $fila['ETIQUETA'];
                                $descMuni = $tmpEtiqueta;
                                $html .= "<option value='" . $fila["ID_VALOR"] . "' >" . $descMuni . "</option>";
                            }
                        }
                    }
                }
                break;
            case 'cuantos_hombres_vivos':
            case 'cuantas_mujeres_vivas':
            case 'hoy_cuantos_hombres_vivos':
            case 'hoy_cuantas_mujeres_vivas':
                $html .= "<option value=''>Seleccione...</option>";
                for($i = 0; $i <= $postt['id']; $i++) {
                    $html .= "<option value='" . $i . "' >" . $i . "</option>";
                }
                break;
            default:
                $html .= 'No se ha definido correctamente la opción.';
                break;
        }
        // pr();die();
        $this->output->set_content_type('text/plain', 'utf-8')->set_output($html);
    }

    // public static function getIp() {
    //     $ipCliente = false;
    //     $ipEncontrada = null;
    //     $ipEncontrada = null;
    //     $ipEncontrada = null;

    //     if (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) { // buscamos la ip en la vaiable server.
    //         $ipCliente = (! empty ( $_SERVER ['REMOTE_ADDR'] )) ? $_SERVER ['REMOTE_ADDR'] : ((! empty ( $_ENV ['REMOTE_ADDR'] )) ? $_ENV ['REMOTE_ADDR'] : "Sin Info");
    //         $ent = explode ( ", ", $_SERVER ['HTTP_X_FORWARDED_FOR'] );
    //         reset ( $ent );
    //         foreach ( $ent as $valor ) {
    //             $valor = trim ( $valor );
    //             if (preg_match ( "/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $valor, $lista_ips )) {
    //                 $ipsPrivadas = array (
    //                     '/^0\./',
    //                     '/^127\.0\.0\.1/',
    //                     '/^192\.168\..*/',
    //                     '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
    //                     '/^10\..*/'
    //                 );
    //                 $ipEncontrada = preg_replace ( $ipPrivadas, $ipCliente, $lista_ips [1] );
    //                 if ($ipCliente != $ipEncontrada) {
    //                     $ipCliente = $ipEncontrada;
    //                 }
    //             }
    //         }
    //     }
    //     if (! $ipCliente) {
    //         $headers = getallheaders ();
    //         if (! empty ( $headers ["X-Forwarded-For"] )) {
    //             $ipCliente = $headers ["X-Forwarded-For"];
    //             $ent = explode ( ", ", $headers ["X-Forwarded-For"] );
    //             reset ( $ent );
    //             $ipCliente = $ent [0];
    //         } else
    //         $ipCliente = (! empty ( $_SERVER ['REMOTE_ADDR'] )) ? $_SERVER ['REMOTE_ADDR'] : ((! empty ( $_ENV ['REMOTE_ADDR'] )) ? $_ENV ['REMOTE_ADDR'] : "Sin Informacion");
    //     }
    //     return $ipCliente;
    // }

    public function redis(){
        // die('hola desde formulario');
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

        // $this->redis->flushall();

        $varRedis = $this->redis->keys("*");
        pr($varRedis);
        $D1 = json_decode($this->redis->get('dominio_D1'),true);
        // pr($D1);

        $preguntas = json_decode($this->redis->get('preguntas'),true);
        pr($preguntas['ECP_UBICACION']);
        die();
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


    public function generarClave($usuario = null)
    {
        $clave = 'Dane1234';

        $clMd5 = md5($clave);

        if (!empty($usuario))
        {
            $us = str_replace('%22', '', $usuario);

            $this->load->library('danecrypt');
            $pass = $this->danecrypt->encode($clMd5, $us);

            pr($us);
            pr($clave);
            pr($pass);
        } else {
            pr('Debe ingresar un correo electronico');
        }



    }
}
//EOC