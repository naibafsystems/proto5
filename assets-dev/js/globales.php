<?php
header("Content-Type: application/javascript");
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
//$base_url = substr($base_url, 0, -10); // Para quitar el assets/js/
echo "var base_url = '" .$base_url . "';\n";
?>
