<!DOCTYPE HTML>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Certificado Censo</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url_plugins("bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Roboto+Slab:100,300,400,700" rel="stylesheet">

<style type="text/css">
body {
  margin: 0;
  padding: 0;
  background: url(<?= base_url_images("constancia/footer.png"); ?>);
  background-repeat: repeat-x;
  background-attachment: fixed;
  background-position: bottom;
  height:100%;
  border:0;
}


    @media (min-width: 320px) {.logos{margin-top: 0;}}
    @media (min-width: 480px) {.logos{margin-top: 20px;}}
    @media (min-width: 768px) {.logos{margin-top: 25px;}}
    @media (min-width: 992px) {.logos{margin-top: 19px;}}
    @media (min-width: 1200px) {.logos{margin-top: 15px;}}

    ul {
        list-style-type: none;
    }

</style>

</head>

<body>


<div style="height:50px; background: url(<?= base_url_images("constancia/pattern-top.jpg"); ?>); background-repeat: repeat-x; background-position:center;"></div>

<div class="container">
    <div class="row" style="margin-top:40px;">
        <div class="col-sm-9 col-md-10 col-lg-10 hidden-xs logos"><img src="<?= base_url_images("constancia/logos-header.png"); ?>" border="0" width="100%"></div>
        <div class="col-sm-12 hidden-sm hidden-md hidden-lg"><img style="margin-bottom:40px;" src="<?= base_url_images("constancia/logos-phone.jpg"); ?>" alt="eCenso" border="0" width="100%"></div>
        <div class="col-sm-3 col-md-2 col-lg-2 codigocenso" style="background-color:#F0CCDB; font-family: 'Open Sans', sans-serif; font-size:13px; font-weight:600; color:#410F1A; text-align:center; ">
            <p style="padding:10px 20px 0 20px; margin:0 10px;">Código de<br>diligenciamiento:</p>
            <p style="padding:0 20px 10px 20px; margin:0 10px;">
            <!-- Campo Dinámico -->
            <span><?=$codiEncuesta;?></span>
            </p>
        </div>
    </div>
    <hr style="border-top: 1px solid #B2004C; margin-top:30px;">
</div>

<!-- Contenido -->
<div class="container">
    <div class="row text-center">
    <!-- Contenido del certificado -->
    <div style="margin:40px 0 80px 0;">
        <p style="font-family: 'Open Sans', sans-serif; font-size:18px; font-weight:800; color:#4D4D4D;">EL DEPARTAMENTO ADMINISTRATIVO<br>NACIONAL DE ESTADÍSTICA -DANE-</p>
        <p style="font-family: 'Open Sans', sans-serif; font-size:14px; font-weight:400; color:#333333; margin-bottom:40px;">Hace constar que el hogar conformado por:</p>
        <p style="font-family: 'Open Sans', sans-serif; font-size:16px; font-weight:400; color:#4D4D4D;">
            <!-- Campos Dinámicos -->
            <?=$listaPersonas?>
        </p>
        <p style="font-family: 'Open Sans', sans-serif; font-size:17px; font-weight:700; color:#B6014C; margin-bottom:0;">Se ha eCensado</p>
        <!-- Campo Dinámico -->
        <p style="font-family: 'Open Sans', sans-serif; font-size:14px; font-weight:400; color:#333333; margin-top:0;">Fecha de expedición: <span><?=$expedicion;?></span></p><br><br>
        <p style="font-family: 'Open Sans', sans-serif; font-size:16px; font-weight:800; color:#4D4D4D; margin-bottom:0;">Mauricio Perfetti del Corral</p>
        <p style="font-family: 'Open Sans', sans-serif; font-size:16px; font-weight:400; color:#4D4D4D; margin-top:0;">Director</p>

    </div>
    </div>
</div>

<div style=" position: absolute; bottom:0; left:50%;"></div>

</body>

</html>