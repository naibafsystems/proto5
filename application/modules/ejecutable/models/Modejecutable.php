<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del modulo ejecutable
 * @author hhchavezv	
 * @since  2017oct18
 **/
class Modejecutable extends My_model {

	public $msgError;
	public $msgSuccess;
	private $sufijoTabla;

	public function __construct() {
		$this->msgError = '';
		$this->msgSuccess = '';
		$this->sufijoTabla = 'ECP';
		if(in_array($this->config->item('tipoFormulario'), array('G', 'H'))) {
			$this->sufijoTabla = 'WCP';
		}
	}

    /**
     * Elimina un formularo de todas las tablas 
     * @author hhchavezv
     * @param $numform - Codigo de la enceusta 
     * @return True, si elimina correctamente
     */
    public function eliminaEncuesta($numform) {
    	try {
    		if( isset($numform) && $numform > 0){
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_FORMATO_1 WHERE COD_ENCUESTAS = ". $numform; 
				//if( !$this->db->query($sql) ) throw new RuntimeException('Error al limpiar tablas.');
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_TIEMPOS_ENTREVISTA WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_RESULTADOS_ENTREVISTA WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_PERSONAS_FALLECIDAS WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_PERSONAS_HOGAR WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_ADMIN_CONTROL_PERSONAS WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_ADMIN_USUARIOS WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_PERSONAS_RESIDENTES WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_HOGAR WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_VIVIENDA WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_ADMIN_CONTROL WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM " . $this->sufijoTabla . "_NO_ACEPTO WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);
    			$sql = "DELETE FROM ENCUESTAS WHERE COD_ENCUESTAS = ". $numform; 
    			$this->db->query($sql);

    			$this->db->close();

    		}
    		return true;
    	}  catch (RuntimeException $e) {
            //$e->getMessage();
    		return false;
    	}

    }



}
//EOC