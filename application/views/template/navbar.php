<div class="container-fluid container-header">
    <header class="container header">
        <div class="header_main-content container row">
            <div class="left-content col-xs-12 col-sm-6 col-md-6 col-lg-5">
                <div class="logo_dane-2017">
                    <a href="http://www.dane.gov.co" target="_blank">
                        <img class="img-responsive hidden-xs" src="https://s3-us-west-1.amazonaws.com/danecolombia/resources/images/logo_dane-presidencia.png" />
                        <img class="img-responsive hidden-sm hidden-md hidden-lg" src="<?=base_url_images('logo_dane-presidencia_v.png') ?>" />
                    </a>
                </div>
            </div>
            <div class="right-content col-xs-12 col-sm-6 col-md-6 col-lg-7">
                <div class="titulo-formulario">
                    <span class="normal-weight"><?= $this->config->item("titulo"); ?></span>
                    <span class="bold-weight"><?= $this->config->item("subtitulo"); ?></span>
                </div>
            </div>
        </div>
        <div class="pattern-line">
            <img class="img-responsive hidden-xs hidden-sm" src="https://s3-us-west-1.amazonaws.com/danecolombia/resources/images/linea-dane.png" />
            <img class="img-responsive hidden-xs hidden-md hidden-lg" src="https://s3-us-west-1.amazonaws.com/danecolombia/resources/images/linea-dane_750.png" />
            <img class="img-responsive hidden-sm hidden-md hidden-lg" src="https://s3-us-west-1.amazonaws.com/danecolombia/resources/images/linea-dane_450.png" />
        </div>
    </header>
</div>