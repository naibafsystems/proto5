<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_Model extends CI_Model {
    
    private $sql;
    protected $exepcion;
    protected $msgError;
    
    public function construct() {
        parent::__construct();
        $this->sql = 'qwerty';
    }

    /**
     * 
     * @access public
     * @author oagarzond
     * @return  String  Comando de SQL
     */
    public function get_sql() {
        return $this->sql;
    }

     /**
     * Metodo que retorna todas las sentencias INSERT para posteriormente ejecutarlas en modos transacción
     * @access public
     * @author etabordac
     * @param   String  $tabla      Nombre de la tabla   
     * @param   Array   $arrValores Arreglo asociativo con los valores a insertar
     * @return  Bool                dependiendo de si se realizo correctamente la operación o no
     */
    public function retornar_insert_transac($tabla, $arrValores) {
        $this->sql = '';
        
        $this->sql = "INSERT INTO " . $tabla . " (" . implode(",", array_keys($arrValores)) . ") VALUES (";
        $i = 0;
        foreach ($arrValores as $campo => $valor) {
            $arrExp = array("nextval", "sysdate", "to_timestamp", "to_date");
            foreach ($arrExp as $ie => $ve) {
                if (substr_count(strtolower($valor), $ve) > 0) {
                    $this->sql .= $valor;
                    $valor = array('0');
                    break;
                }
            }
            if ($valor == NULL) {
                $this->sql .= "NULL";
            } else if (is_string($valor)) {
                if(strtolower($valor) == "null") {
                    $this->sql .= "NULL";
                } else if(strlen($valor) == 19 && es_fecha_hora_valida($valor)) {
                    $this->sql .= "TO_DATE('" . $valor . "', 'DD/MM/YYYY HH24:MI:SS')";
                } else if(strlen($valor) == 10 && es_fecha_valida($valor)) {
                    $this->sql .= "TO_DATE('" . $valor . "', 'DD/MM/YYYY')";
                } else {
                    $this->sql .= "'" . str_replace("'", "''", satinizar_valor($valor)) . "'";
                }
            } else if (is_int($valor)) {
                $this->sql .= satinizar_valor($valor);
            }
            $this->sql .= (count($arrValores) != ($i + 1)) ? ", " : ")";
            $i++;
        }
        
        return $this->sql . "";
    }

    
    /**
     * Metodo que ejecuta todas las sentencias INSERT en la Base de Datos
     * @access public
     * @author oagarzond
     * @param   String  $tabla      Nombre de la tabla   
     * @param   Array   $arrValores Arreglo asociativo con los valores a insertar
     * @return  Bool                dependiendo de si se realizo correctamente la operación o no
     */
    public function ejecutar_insert($tabla, $arrValores) {
        $this->sql = '';
        try {
            $this->sql = "INSERT INTO " . $tabla . " (" . implode(",", array_keys($arrValores)) . ") VALUES (";
            $i = 0;
            foreach ($arrValores as $campo => $valor) {
                $arrExp = array("nextval", "sysdate", "to_timestamp", "to_date");
                foreach ($arrExp as $ie => $ve) {
                    if (substr_count(strtolower($valor), $ve) > 0) {
                        $this->sql .= $valor;
                        $valor = array('0');
                        break;
                    }
                }
                if ($valor == NULL) {
                    $this->sql .= "NULL";
                } else if (is_string($valor)) {
                    if(strtolower($valor) == "null") {
                        $this->sql .= "NULL";
                    } else if(strlen($valor) == 19 && es_fecha_hora_valida($valor)) {
                        //$this->sql .= "TO_TIMESTAMP('" . $valor . "', 'DD/MM/YYYY HH24:MI:SS')";
                        $this->sql .= "TO_DATE('" . $valor . "', 'DD/MM/YYYY HH24:MI:SS')";
                    } else if(strlen($valor) == 10 && es_fecha_valida($valor)) {
                        $this->sql .= "TO_DATE('" . $valor . "', 'DD/MM/YYYY')";
                    } else {
                        $this->sql .= "'" . str_replace("'", "''", satinizar_valor($valor)) . "'";
                    }
                } else if (is_int($valor)) {
                    $this->sql .= satinizar_valor($valor);
                }
                $this->sql .= (count($arrValores) != ($i + 1)) ? ", " : ")";
                $i++;
            }
           //pr($this->sql); exit;
            //return $this->sql . ";";
            $query = $this->db->query($this->sql);
            $this->db->close();
            return $query;
            //return true;
        } catch (PDOException $e) {
            $this->exepcion = $e;
            return false;
        }
    }

    public function ejecutar_update($tabla, $arrValores, $arrWhere) {
        $this->sql = $sql = '';
        try {
            $this->sql = "UPDATE " . $tabla . " SET ";
            if (is_array($arrValores)) {
                foreach ($arrValores as $campo => $valor) {
                    $arrExp = array("nextval", "sysdate");
                    foreach ($arrExp as $ie => $ve) {
                        if (substr_count(strtolower($valor), $ve) > 0) {
                            $sql .= $campo . " = " . $valor . ", ";
                            $valor = array('0');
                            break;
                        }
                    }
                    if (is_null($valor)) {
                        $sql .= $campo . " = NULL, ";
                    } else if (is_string($valor)) {
                        if (strtolower($valor) == "null") {
                            $sql .= $campo . " = NULL, ";
                        } else if(strlen($valor) == 19 && es_fecha_hora_valida($valor)) {
                            //$sql .= $campo . " = " . "TO_TIMESTAMP('" . $valor . "', 'YYYY-MM-DD HH24:MI:SS'), ";
                            $sql .= $campo . " = " . "TO_DATE('" . $valor . "', 'DD/MM/YYYY HH24:MI:SS'), ";
                        } else if(strlen($valor) == 10 && es_fecha_valida($valor)) {
                            $sql .= $campo . " = " . "TO_DATE('" . $valor . "', 'DD/MM/YYYY'), ";
                        } else {
                            $sql .= $campo . " = " . "'" . str_replace("'", "''", satinizar_valor($valor)) . "', ";
                        }
                    } else if (is_int($valor)) {
                        $sql .= $campo . " = " . satinizar_valor($valor) . ", ";
                    }
                }
                $sql = substr($sql, 0, -2);
            }
            $i = 0;
            if (is_array($arrWhere)) {
                $sql .= " WHERE ";
                foreach ($arrWhere as $campo => $valor) {
                    if ($i != 0) {
                        $sql .= " AND ";
                    }
                    if ($valor == NULL) {
                        $sql .= $campo . " IS NULL";
                    } else if (strtolower($valor) == "null") {
                        $sql .= $campo . " IS NULL";
                    } elseif (is_string($valor)) {
                        $sql .= $campo . " = " . "'" . str_replace("'", "''", $valor) . "'";
                    } else {
                        $sql .= $campo . " = " . $valor;
                    }
                    $i++;
                }
            }
            $this->sql .= $sql;
            //pr($this->sql); exit;
            //return $this->sql . ";";
            //log_message('error', 'Codigo de encuesta: ' . $this->session->userdata('codiEncuesta') . '. SQL: ' . $this->sql . '.');
            $query = $this->db->query($this->sql);
            $this->db->close();
            return $query;
            //return true;
        } catch (PDOException $e) {
            $this->exepcion = $e;
            return false;
        }
    }

    public function ejecutar_delete($tabla, $arrWhere) {
        $this->sql = $sql = '';
        try {
            $this->sql = "DELETE " . $tabla;
            $i = 0;
            if (is_array($arrWhere)) {
                $this->sql .= " WHERE ";
                foreach ($arrWhere as $campo => $valor) {
                    if ($i != 0) {
                        $this->sql .= " AND ";
                    }
                    if ($valor == NULL) {
                        $this->sql .= $campo . " IS NULL";
                    } else if (strtolower($valor) == "null") {
                        $this->sql .= $campo . " IS NULL";
                    } elseif (is_string($valor)) {
                        $this->sql .= $campo . " = " . "'" . str_replace("'", "''", $valor) . "'";
                    } else {
                        $this->sql .= $campo . " = " . $valor;
                    }
                    $i++;
                }
            }
            //pr($this->sql); exit;
            //return $this->sql . ";";
            $query = $this->db->query($this->sql);
            $this->db->close();
            return $query;
            //return true;
        } catch (PDOException $e) {
            $this->exepcion = $e;
            return false;
        }
    }
    
    /**
     * Consulta la fecha y hora actual
     * @access Public
     * @author oagarzond
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_fecha_hora() {
        $data = array();
        $sql = "SELECT TO_CHAR(SYSDATE , 'DD/MM/YYYY HH24:MI:SS') TODAY FROM DUAL";
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data = $row;
        }
        //pr($data); exit;
        $this->db->close();
        return $data["TODAY"];
    }
    
    /**
     * Metodo que obtiene el ultimo id insertado en la BD en una tabla con campo 
     * serial o autoincremento
     * @author oagarzond
     * @param   String  $tabla  Nombre de la tabla
     * @param   String  $seq    Nombre de la secuencia
     * @return int|bool Retorna el ultimo id insertado o false dependiendo de si se 
     * realizo correctamente la operacion o no
     */
    public function obtener_ultimo_id_revisar($tabla, $seq) {
        if ($this->db) {
            $data = array();
            $sql = "SELECT $seq.currval MAXIMO $tabla FROM DUAL'";
            pr($sql); exit;
            $query = $this->db->query($sql);
            while ($row = $query->unbuffered_row('array')) {
                $data["MAX"] = $row["MAXIMO"];
            }
            return $data["MAX"];
            //return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    /**
     * Metodo que obtiene el ultimo id insertado en la BD en una tabla con campo 
     * serial o autoincremento
     * @author oagarzond
     * @return int|bool Retorna el ultimo id insertado o false dependiendo de si se 
     * realizo correctamente la operacion o no
     */
    public function obtener_ultimo_id($tabla, $id) {
        if ($this->db) {
            $data = array();
            $sql = "SELECT MAX($id) MAXIMO FROM $tabla";
            //pr($sql); exit;
            $query = $this->db->query($sql);
            while ($row = $query->unbuffered_row('array')) {
                $data["MAX"] = $row["MAXIMO"];
            }
            return $data["MAX"];
            //return $this->db->insert_id();
        } else {
            $this->msgError = "No hay conexion";
            return false;
        }
    }

    /**
     * Metodo que obtiene el siguiente id de una secuencia 
     * @author oagarzond
     * @return int|bool Retorna el ultimo id insertado o false dependiendo de si se 
     * realizo correctamente la operacion o no
     */
    public function obtener_siguiente_id($seq) {
        if ($this->db) {
            $data = array();
            $sql = "SELECT $seq.NEXTVAL FROM DUAL";
            //pr($sql); exit;
            $query = $this->db->query($sql);
            while ($row = $query->unbuffered_row('array')) {
                $data["MAX"] = $row["NEXTVAL"];
            }
            return $data["MAX"];
            //return $this->db->insert_id();
        } else {
            $this->msgError = "No hay conexion";
            return false;
        }
    }

    /**
     * Metodo que consulta si un valor es unico en una tabla
     * @author oagarzond
     * @param   $str    Valor que se va a comparar en la tabla
     * @param   $field  Nombre de la tabla.campo en la que se va a hacer la comparacion
     * @return  bool    Retorna si es unico o no
     */
    public function es_unico($str, $field) {
        if(substr_count($field, '.') == 1) {
            list($table, $field) = explode('.', $field);
            $query = $this->db->limit(1)->get_where($table, array($field => $str)); 
            return $query->num_rows() === 0;
        }
    }
}
//EOC