<div class="container-fluid container-header not-affect-container">
    <header class="container header">
        <div class="header_main-content container row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">                       
                <a href="">
                    <img alt="Este es un link que direcciona a la pagina principal del Dane, logo del dane informacion estrategica. logo de todos por un nuevo pais, paz, equidad, educacion" class="img-responsive logo-censo-image" src="<?=base_url_images('logocenso_header.png') ?>" />
                </a>
            </div>
            <div class="hidden-xs col-sm-7 col-md-7 col-lg-5">
                <a href="http://www.dane.gov.co" target="_blank">
                    <img class="img-responsive logo-dane-image" alt="imagen corporativa del DANE" src="<?=base_url_images('logodane_header.png') ?>" />
                </a>
            </div>
        </div>
    </header>
</div>

<div class="container-fluid container-navbar">
    <nav class="navbar">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="<?php echo base_url("admin/inicio"); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Inicio</a>
                </li>
                <li>
                    <a href="<?php echo base_url("admin/verUsuarios"); ?>">Ver encuestados</a>
                </li>
                <li>
                    <a href="<?php echo base_url("admin/agregarUsuario"); ?>">Agregar usuario</a>
                </li>
                <li>
                    <a href="<?php echo base_url("admin/agregarSolicitud"); ?>">Agregar solicitud</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url("admin/salir"); ?>">Salir</a></li>
            </ul>
        </div>
    </nav>
</div>

<div class="container-fluid">
    <div class="row">
       <div class="col-xs-12 col-sm-12 col-md-12">
            <?= $breadcrumb ?>
        </div>
    </div>
</div>
<!-- <div class="clearfix"></div> -->
