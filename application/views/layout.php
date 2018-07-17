<!doctype html>
<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="es_co" version="HTML+RDFa 1.1"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="es_co" version="HTML+RDFa 1.1"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="es_co" version="HTML+RDFa 1.1"> <![endif]-->
<!--[if IE 9]>
<html class="no-js ie9" lang="es_co" version="HTML+RDFa 1.1"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="es-co" class="no-js" version="HTML+RDFa 1.1" xmlns="http://www.w3.org/1999/xhtml">
    <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="baseurl" content="<?php echo base_url() ?>" />
        <title><?php echo $title . ' - ' . $this->config->item("nombreSistema"); ?></title>
        <!-- Nuejos styles -->
        <link href="<?php echo base_url_images("favicon.ico"); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha384-VK/ia2DWrvtO05YDcbWI8WE3WciOH0RhfPNuRJGSa3dpAs5szXWQuCnPNv/yzpO4" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha384-WRu9pYyIOqqid8N7J6OSeS1TzFeAvmPD2O7idI6zgta6+9cVPdjOzu/2GTEKmC7E" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="<?php echo base_url_plugins('offline/offline-theme-dark.css'); ?>"  rel="stylesheet" />
        <link href="<?php echo base_url_plugins('offline/offline-language-spanish.css'); ?>"  rel="stylesheet" />
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php
        if (!empty($arrCss) && count($arrCss)) {
            foreach ($arrCss as $vcss) {
                echo "<link href='" . $vcss . "' rel='stylesheet' />\n\t\t";
            }
        }
        ?>
        <!--<link href="<?php //echo base_url_css("style.css");  ?>" rel="stylesheet" />-->
        <link href="<?php echo base_url_css("style-base.css"); ?>" rel="stylesheet" />
        <link href="<?php echo base_url_css("accesibilidad.css"); ?>" rel="stylesheet" />
        <link href="<?php echo base_url_css("boton-contacto.css"); ?>"  rel="stylesheet"/>
        <link href="<?php echo base_url_css("sticky-footer-navbar.css"); ?>"  rel="stylesheet" />
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-4720764-14', 'auto');
            ga('send', 'pageview');
        </script>
        <meta name="<?=$this->security->get_csrf_token_name();?>" content="<?=$this->security->get_csrf_hash();?>">
    </head>
    <body id="main_body" class="body-full-height">
        <noscript>
            <span class='warningjs'>Aviso: La ejecución de JavaScript está deshabilitada en su navegador. Es posible que no pueda responder todas las preguntas de la encuesta. Por favor, verifique la configuración de su navegador.</span>
        </noscript>
        <div id="animationload" class="animationload" style="display: none;">
            <div id="imageLoad"></div>
        </div>
        <?php
        $header = (isset($header) && !empty($header)) ? '/template/' . $header : '/template/header';
        $this->load->view($header);
        if(isset($navbarLeftSide) && !empty($navbarLeftSide)) {
            $this->load->view('/template/' . $navbarLeftSide);
        }
        $classContainer = (isset($classContainer) && !empty($classContainer)) ? $classContainer : 'container';
        ?>
        <div id="main_container" class="<?=$classContainer?>">

        <!-- Este div permite bloquear todos los controles de la vista hasta cuando finalice el cargue de todos los elementos de la vista (css y js). -->
        <div class="divoverlay"></div>
        <!-- Hasta aquí -->

        <?php
        if (isset($view) && !empty($view)) {
            $this->load->view($view);
        }
        ?>
        </div>
        <?php
        if(isset($footer) && !empty($footer)) {
            $this->load->view('/template/' . $footer);
        }
        ?>
        <a href="javascript:void(0)" class="scrollup">Ir arriba</a>
        <!--[if lt IE 10]>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js" integrity="sha384-6ePHh72Rl3hKio4HiJ841psfsRJveeS+aLoaEf3BWfS+gTF0XdAqku2ka8VddikM" crossorigin="anonymous"></script>
        <!--<![endif]-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
	    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-PtTRqvDhycIBU6x1wwIqnbDo8adeWIWP3AHmnrvccafo35E7oIvW7HPXn2YimvWu" crossorigin="anonymous"></script> -->

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="<?php echo base_url_plugins("bootstrap/js/ie-emulation-modes-warning.js"); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url_plugins("bootstrap/js/ie10-viewport-bug-workaround.js"); ?>" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.min.js" integrity="sha384-K0Xjh7BtHDkHTDCocS9yQCe9kGS5EoFcsERQGzcCKcgIgjgUgo1Zkt+4GvfPEePN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" integrity="sha384-rZfj/ogBloos6wzLGpPkkOr/gpkBNLZ6b6yLy4o+ok+t/SAKlL5mvXLr0OXNi1Hp" crossorigin="anonymous"></script>
        <script src="<?php echo base_url_plugins('jquery-validation/src/localization/messages_es.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url_plugins('offline/offline.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url_js("danevalidator.js"); ?>" type="text/javascript"></script>
        <!-- <script src="<?php // echo base_url_js("accesibilidad.js"); ?>" type="text/javascript"></script> -->
        <script src="<?php echo base_url_js("boton-contacto/boton-contacto.js"); ?>" type="text/javascript"></script>

        <?php
        if (!empty($arrJS) && count($arrJS)) {
            foreach ($arrJS as $vJS) {
                echo "<script src='" . $vJS . "' type='text/javascript'></script>\n\t\t";
            }
        }

        if (isset($view) && !empty($view)) {
            if (file_exists(base_dir_js("$module/$view.js"))) {
                echo "<script src='" . base_url_js("$module/$view.js") . "' type='text/javascript'></script>\n";
            }
        }
        ?>
    <div class="boton-chat btn btn-default">
       <a href="https://dane.agenti.com.co/chate/" target="blank">
            <div>
                <img class="contact-button-icon chat-icon-image chat-icon-image-logged-in src="<?=base_url_images('chat_blanco.png'); ?>" >
                </div>
             <div>CONTÁCTENOS</div>
        </a>
    </div>

    </body>
</html>
