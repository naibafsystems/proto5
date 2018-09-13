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
        
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        
        
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
        
        <meta name="<?=$this->security->get_csrf_token_name();?>" content="<?=$this->security->get_csrf_hash();?>">
    </head>
    <body id="main_body" class="body-full-height">
        
        
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
        
        <!--[if lt IE 10]>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js" integrity="sha384-6ePHh72Rl3hKio4HiJ841psfsRJveeS+aLoaEf3BWfS+gTF0XdAqku2ka8VddikM" crossorigin="anonymous"></script>
        <!--<![endif]-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
	    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-PtTRqvDhycIBU6x1wwIqnbDo8adeWIWP3AHmnrvccafo35E7oIvW7HPXn2YimvWu" crossorigin="anonymous"></script> -->

        
        
        
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" integrity="sha384-rZfj/ogBloos6wzLGpPkkOr/gpkBNLZ6b6yLy4o+ok+t/SAKlL5mvXLr0OXNi1Hp" crossorigin="anonymous"></script>
        
        
        <script src="<?php echo base_url_js("danevalidator.js"); ?>" type="text/javascript"></script>
        <!-- <script src="<?php // echo base_url_js("accesibilidad.js"); ?>" type="text/javascript"></script> -->
        

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

    </body>
</html>
