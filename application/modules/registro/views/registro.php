<div class="row">
    <div class="col-md-12 text-center section-title">
        <h1 class="title-ecenso"> Cree su cuenta / <span class="opensans"> Datos personales</span></h1>
    </div>
</div>
<div class="container-fluid separador"></div>
<div class="row">
    <div class="col-md-12 alimneacionvertical">&nbsp;</div>
</div>
<?php if(!empty($var)) { ?>
<div class="row">
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9">
            <?php if(!empty($URLVideo)) { ?>
                <iframe src="<?=$URLVideo?>" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmRegistro" name="frmRegistro" role="form" method="post">
            <?php if(isset($mensajeCedula)){ ?>
                <div class="alert alert-danger text-center" role="alert">
                    <label for=""> <bold> <?php echo $mensajeCedula; ?></bold></label>


                    </div>
            <?php } ?>
            <?php foreach ($var as $k => $v) { ?>
            <?php if($v['REFERENCIA_HTML'] == 'contrasena1') {?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label><strong>Para la creación de su cuenta, utilice una contraseña única y segura. Su contraseña debe tener como mínimo 8 caracteres y entre ellos, debe tener al menos una letra mayúscula, una letra minúscula, y un número o un caracter especial (#$%&?). <br>
                        <!--label class="control-label">Su contraseña debe contener al menos: una letra mayúscula, una letra minúscula, un número o carácter especial. con mínimo ocho (8) caracteres.</label-->
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div id="<?= $v['REFERENCIA_HTML']; ?>-col" class="col-xs-12 col-sm-12 col-md-12 <?php echo(!empty($v['HIDDEN']) && $v['HIDDEN'] == 'SI') ? 'hidden': '';?> ">
                    <fieldset>
                        <div class="form-group">
                            <label id="<?= $v['REFERENCIA_HTML']; ?>-lbl" class="control-label" for="<?= $v['REFERENCIA_HTML'] ?>"> <?= $v['DESCRIPCION'];?>
                                <?php if (!empty($v['AYUDA'])) { ?>
                                &nbsp;<span class="glyphicon glyphicon-question-sign font-help" id="<?= $v['REFERENCIA_HTML']; ?>-ayuda" data-tooltip="<?=$v['AYUDA']?>" aria-describedby="acc_ayuda_<?= $v['REFERENCIA_HTML']; ?>" aria-hidden="true"></span>
                                <div id="acc_ayuda_<?= $v['REFERENCIA_HTML']; ?>" class="acc-offscreen"><?= $v['AYUDA'] ?></div>
                                <?php } ?>
                                <?php if($v['REFERENCIA_HTML'] == 'fecha_expe') {?>
                                <span class="glyphicon glyphicon-question-sign font-help" id="fecha_expe-ayuda" alt="" data-hasqtip="3" aria-describedby="acc_ayuda_fecha_expe" aria-hidden="true"></span>
                                <?php } ?>
                            </label>
                            <div>
                                <?php if ($v['TIPO_CAMPO'] == "SELUNICA") {
                                    echo mostrar_select($v, $v["OPCIONES"]);
                                } else if ($v['TIPO_CAMPO'] == "SELUNICA_RAD") {
                                    echo mostrar_radios($v, $v["OPCIONES"]);
                                } else if ($v['TIPO_CAMPO'] == "FECHA") {
                                    echo mostrar_fecha($v);
                                } else if ($v['TIPO_CAMPO'] == "TEXTO") {
                                    echo mostrar_input_text($v);
                                } else if ($v['TIPO_CAMPO'] == "CLAVE") {
                                    echo mostrar_input_password($v);
                                } ?>
                                <?php if($v['REFERENCIA_HTML'] == 'correo_electronico') {?>
                                    <label id="<?=$v['REFERENCIA_HTML']?>-error" role="alert" for="<?=$v['REFERENCIA_HTML']?>"></label>
                                <?php } ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <?php if($v['REFERENCIA_HTML'] == 'contrasena3') {?>
            <div class="row">
                <div class="form-group">
                    <a name="terminosCondiciones"></a>
                    <div class="col-xs-12 col-sm-12 col-md-12">Al hacer clic en aceptar y siguiente está aceptando los términos y condiciones y podrá continuar con el proceso.
                        <a href="#terminosCondiciones" class="terminosCondiciones">Ver términos y condiciones.</a>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php  } ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>
            <div class="row <?php echo (strlen($msgSuccess) == 0 || strlen($msgError) == 0) ? 'hidden' : ''; ?>" id="divMsg">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div id="divMsgSuccess" class="alert alert-success <?php echo (strlen($msgSuccess) == 0) ? 'hidden' : ''; ?>">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong id="msgSuccess"><?= $msgSuccess ?></strong>
                        </div>
                        <div id="divMsgAlert" class="alert alert-danger <?php echo (strlen($msgError) == 0) ? 'hidden' : ''; ?>">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong id="msgError"><?= $msgError ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php if($mostrarAnterior == 'SI') { ?>
                        <button type="button" id="btnAnterior" name="btnAnterior" class="btn btn-back"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Anterior</button>
                        <?php } ?>
                        <button type="button" id="btnSiguiente" name="btnSiguiente" class="btn btn-dane-success">Guardar y continuar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>
<?php if(!empty($mensajeConfirmacion)) {?>
<div id="mensajeConfirmacion" class="hidden">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p><?=$mensajeConfirmacion?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="button" id="btnAnteriorConfirmacion" class="btn btn-back"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Anterior</button>
            <button type="button" id="btnSiguienteConfirmacion" class="btn btn-dane-success">Guardar y continuar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
        </div>
    </div>
</div>
<?php } ?>