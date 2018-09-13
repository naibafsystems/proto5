<?php
/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=nombredelfichero.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/ 
$csv = "USUARIO;NOMBRES;APELLIDOS;NUMERO FORMULARIO;DEPTO DIVIPOLA;MUNICIPIO DIVIPOLA;TOTAL HOGARES;FECHA INICIO DIGITACION;FECHA FIN DIGITACION;CANTIDAD PERSONAS;CANTIDAD PERSONAS DIGITADAS\r\n";
for($i=0;$i<count($respuestas);$i++){
    $csv.= $respuestas[$i]['USUARIO'].";".$respuestas[$i]['NOMBRES'].";".$respuestas[$i]['APELLIDOS'].";".$respuestas[$i]['NUMERO_FORMULARIO'].";".$respuestas[$i]['DEPTO_DIVIPOLA'].";".$respuestas[$i]['MUNICIPIO_DIVIPOLA'].";".$respuestas[$i]['TOTAL_HOGARES'].";".$respuestas[$i]['FECHA_INICIO_DIGITACION'].";".$respuestas[$i]['FECHA_FIN_DIGITACION'].";".$respuestas[$i]['CANTIDAD_PERSONAS'].";".$respuestas[$i]['CANTIDAD_PERSONAS_DIGITADAS']."\r\n";
}

echo $csv;
?>  
