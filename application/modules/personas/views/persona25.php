<div class="row">
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9">
            <?php if(!empty($URLVideo)) { ?>
                <iframe src="<?=$URLVideo?>?rel=0&fs=0&showinfo=0&modestbranding=1" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmPersona" name="frmPersona" data-nume_pers="<?=$numeroPersona?>" role="form" method="post">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div id="acc_title" tabindex="-1" class="form-group">
                        <label class="control-label">Ya respondió que durante la semana pasada <strong class="user-name-border"><?= $nombrePersona ?></strong> <strong><?= $nombreTrabajo ?></strong> indique si <strong class="user-name-border"><?= $nombrePersona ?></strong> además realizó  alguna de las siguientes actividades la semana pasada:</label>
                    </div>
                </div>
            </div>
            <?php foreach ($var as $k => $v) { ?>
                <div class="row">
                    <div id="<?= $v['ID_PREGUNTA']; ?>-col" class="col-xs-12 col-sm-12 col-md-12 <?php echo(!empty($v['HIDDEN']) && $v['HIDDEN'] == 'SI') ? 'hidden': '';?> ">
                        <fieldset>
                            <div class="form-group">
                                <label id="<?= $v['ID_PREGUNTA']; ?>-lbl" class="control-label" for="<?= $v['ID_PREGUNTA'] ?>"> <?= $v['DESCRIPCION']; ?>
                                    <?php if (!empty($v['AYUDA'])) { ?>
                                        &nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="<?= $v['ID_PREGUNTA']; ?>-ayuda" data-tooltip="<?= $v['AYUDA'] ?>" aria-hidden="true"></span>
                                    <?php } ?>
                                </label>
                                <div>
                                    <?php
                                    if ($v['TIPO_CAMPO'] == "SELUNICA") {
                                        echo mostrar_select($v, $v["OPCIONES"]);
                                    } else if ($v['TIPO_CAMPO'] == "SELUNICA_RAD") {
                                        echo mostrar_radios($v, $v["OPCIONES"]);
                                    } else if ($v['TIPO_CAMPO'] == "TEXTO") {
                                        echo mostrar_input_text($v);
                                    }
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            <?php } ?>
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
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>
            <div class="row <?php echo (strlen($msgSuccess) == 0 || strlen($msgError) == 0) ? 'hidden' : ''; ?>" id="divMsg">
                <div class="form-group">
                    <div class="col-md-12">
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
        </form>
    </div>
</div>