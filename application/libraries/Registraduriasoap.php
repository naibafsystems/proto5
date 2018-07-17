<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Clase de conexion y configuracion para utilizar la libreria NuSOAP
*/

/**
 * Convencion de los nombres de los servicios expuestos son:
 * tipo de servicio             nombre web services             metodo del web services
 *
 * Los metodos registrados para el consumo de servicios con arando son:
 * Nombre funcion expuesta                 Url de consumo                           Nombre metodo consumido
 * get_cedula()                            $_end_point['registraduria']             return
 *
 */

class Registraduriasoap {
    /* Parametros del la clase */
    private $_wsdl;
    private $_user = 'DANE';
    private $_password = 'password';
    private $_entidad = '';
    private $_cliente;
    private $_proxyhost;
    private $_proxyport;
    private $_proxyusername;
    private $_proxypassword;
    private $_end_point = array(
        'registraduria' => 'http://172.20.60.90:8080/aniws/WSConsultas?wsdl',
    );

    /**
     * Funcion que carga las librerias necesarias para el consumo del web service
     * @author dmdiazf
     * @since  15/02/2016
     */
    function __construct() {
        require_once("nusoap/lib/nusoap.php");
        $this->_proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
        $this->_proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
        $this->_proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
        $this->_proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
    }

    private function set_wsdl($_wsdl){
        $this->_wsdl = $_wsdl;
        $this->_cliente = new nusoap_client($this->_wsdl, true);
        // $this->_cliente->setCredentials("DANE","password","basic");
        // $this->_cliente->setDebugLevel(0);


        // $client = new nusoap_client($this->wsdl, 'wsdl', $this->proxyhost, $this->proxyport, $this->proxyusername, $this->proxypassword);

        $err = $this->_cliente->getError();
        if($err){
            pr('SE ENCONTRO UN FALLO EN LA CRECION DEL CLIENTE');
            pr($err);
            exit();
        }
    }

    private function validar_llamada($_result){
        $error = array();
        $error['success'] = false;
        if ($this->_cliente->fault) {
            $error['message'] = 'Error, Se presentaron dificultades en la consulta';
        } else {
            $err = $this->_cliente->getError();
            if ($err) {
                $error['message'] = 'Error, Se genero el error: ' . $err . ' en la consulta';
            } else {
                $error['success'] = true;
                $error['data'] = json_decode(json_encode((array) simplexml_load_string($_result["return"])), 1);
                // $error['data'] = json_decode(json_encode((array) simplexml_load_string($this->respuesta)), 1);
            }
        }
        return $error;
    }

    /**
     * metodo para consultar una cedula con la registraduria
     * @param  $_param      Numero de documento a consultar
     * @return [array]      [Array asociativo con la informacion retornada de la registraduria]
     */
    public function get_cedula($_param){
        //if (array_key_exists('id',$_param)){
            $this->set_wsdl($this->_end_point['registraduria']);
            $peticion['contrasena'] = $this->_password;
            $peticion['entidad'] = $this->_entidad;
            $peticion['usuario'] = $this->_user;
            if (isset($_param['DOCUMENTO'])){
                $peticion['cedulas'] = '<?xml version="1.0" encoding="utf-8"?> <solicitudConsultaEstadoCedula><NUIP>'.(integer)$_param['DOCUMENTO'].'</NUIP></solicitudConsultaEstadoCedula>';
            }
            $result = $this->validar_llamada($this->_cliente->call("consultarCedulas",$peticion));

            if ($result['success'] && isset($result['data'])){
                return $result['data'];
            }
        //}
        return false;
    }
}//EOC
