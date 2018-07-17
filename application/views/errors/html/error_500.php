<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>
        <meta charset="UTF-8">
        <title>Pagina no encontrada</title>
        <?php
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url .= "://" . $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
        ?>
        <link rel="stylesheet" type="text/css" href="<?= $base_url . 'assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?= $base_url . 'assets/css/errorDane.css'; ?>" />
    </head>
    <body>
    <div id="contenedor-error">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="texto-error1">Estimado usuario:</h2>
                    <h3 class="texto-error2">En este momento el eCenso no est&aacute; disponible. Por favor intente m&aacute;s tarde.  </h3>
                    <div class="border-texto-error center-block"></div>
                    <div>
                        <a href="javascript:history.go(-1)" class="regreso-inicio">Regresar a la p&aacute;gina anterior</a></div>
                    <div>
                        <a alt="Ir al inicio" href="<?= $base_url . 'inicio' ?>" class="regreso-inicio" title="Ir al inicio">Ir al inicio</a>
                        <div>
                            <p class="contacto-web">Si las dificultades persisten, p&oacute;ngase en contacto<br>
                                con el administrador de este sitio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php //include(APPPATH . 'views/template/footer.php'); ?>
    </body>
</html>
