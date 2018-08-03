<?php
$msgSuccessFD = $this->session->flashdata('msgSuccess');
$msgErrorFD = $this->session->flashdata('msgError');
$msgWelcomeFD = $this->session->flashdata('msgWelcome');
if(!empty($msgSuccessFD)) {
    $msgSuccess = $msgSuccessFD;
}
if(!empty($msgErrorFD)) {
    $msgError = $msgErrorFD;
}
if(!empty($msgWelcomeFD)) {
    $msgWelcome = $msgWelcomeFD;
}
?>
<div class="row">
    <div class="col-md-12">
        <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msgSuccess"><?= $msgSuccess ?></strong>
        </div>
        <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msgError"><?= $msgError ?></strong>
        </div>
    </div>
</div>
<div id="divMsgWelcome" class="<?php echo (strlen($msgWelcome) > 0) ? 'row' : 'row hidden'; ?>" id="acc_title" tabindex="-1">
    <div class="col-md-12 text-center section-title">
        <h3 class="title-ecenso join-and-tell-us-title"><?= $msgWelcome ?></h3>
    </div>
</div>

<div class="alineacionverticaltexto">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-justify">
            <p>Es necesario que complete <strong>todas las preguntas de cada sección para poder avanzar a la siguiente</strong>. Puede guardar y retomar el eCenso cuantas veces lo requiera, sin perder la información ya diligenciada en las distintas secciones y desde cualquier equipo o lugar. Esto, siempre y cuando lo realice dentro del plazo establecido.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-justify">
            <p><strong>Iniciemos</strong></p>
        </div>
    </div>
    <div class="row estilosinicio">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
            <div id="panelUbicacion" class="panel panel-inicio-disabled">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center textobold">
                            <div class="huge"><p>Inicio De Formulario</p></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo base_url('ubicacion/formNew') ?>">Iniciar Formulario</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row estilosinicio">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
            <div id="panelUbicacion" class="panel panel-inicio-disabled">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center textobold">
                            <div class="huge"><p>Selecci&oacute;n De Hogar</p></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo base_url('hogar') ?>">Seleccione el hogar que desea completar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row estilosinicio">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
            <div id="panelUbicacion" class="panel panel-inicio-disabled">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center textobold">
                            <div class="huge"><p>Personas</p></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo base_url('personas') ?>">Complete las preguntas de personas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row estilosinicio">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
            <div id="panelUbicacion" class="panel panel-inicio-disabled">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center textobold">
                            <div class="huge"><p>Editar Hogar</p></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo base_url('hogar/edit') ?>">Editar Hogar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($descargarCertificado == 'SI') { ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
</div>
<!--<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="button" id="btnDescargar" name="btnDescargar" class="btn btn-dane-success">Ver constancia de diligenciamiento <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
    </div>
</div>-->
<?php } ?>
