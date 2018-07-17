<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Author: Derek Allard
*/

/**
 * Metodo de helper para exportar archivos tipo excel
 * @param  [type] $sql      arreglo con los parametros query=>resultados de la consulta, fileds=>Campos del encabezado.
 * @param  string $filename [description]
 * @return [type]           [description]
 */
function to_excel($sql, $filename='exceloutput') {

    $headers = ''; // just creating the var for field headers to append to below
    $data = ''; // just creating the var for field data to append to below
    $export = '';

    $obj =& get_instance();

    if (isset($sql["query"]))
        $query = $sql["query"];
    if (isset($sql["fields"]))
        $fields = $sql["fields"];
// pr($query->result()); die();
    if (!isset($query) ) {
        $export = 'The table appears to have no data.';
    } else {
        if (isset($fields)){
            foreach ($fields as $field) {
                if(is_array($field))
                    $headers .= $field->name . "\t";
                if(is_string($field))
                    $headers .= $field . "\t";
            }
            $export .= $headers."\n";
        }

        foreach ($query->result() as $row) {
            $line = '';
            foreach($row as $value) {
                if ((!isset($value)) OR ($value == "")) {
                    $value = "\t";
                } else {
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line)."\n";
        }

        $export .= str_replace("\r","",$data);

    }
    header("Content-type: application/x-msdownload");
    header("Content-Disposition: attachment; filename=$filename.xls");
    echo mb_convert_encoding("$export",'utf-16','utf-8');
}
?>