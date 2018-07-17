<div class="row">
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9">
            <?php if(!empty($URLVideo)) { ?>
                <iframe src="<?=$URLVideo?>?rel=0&fs=0&showinfo=0&modestbranding=1" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmVivienda" name="frmVivienda" role="form" method="post">
            <?php foreach ($var as $k => $v) { ?>
                <?php if($v['REFERENCIA_HTML'] == 'energia_electrica') { ?>
                    <div class="alineacionverticaltexto_no">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label class="control-label">Las siguientes preguntas hacen referencia a la disponibilidad de servicios básicos en la vivienda que son prestados a través de redes administradas por empresas públicas, privadas o comunitarias.</label>
                                </div>
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
                                        &nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="<?= $v['REFERENCIA_HTML']; ?>-ayuda" data-tooltip="<?=$v['AYUDA']?>" aria-describedby="acc_ayuda_<?= $v['REFERENCIA_HTML']; ?>" aria-hidden="true"></span>
                                        <div id="acc_ayuda_<?= $v['REFERENCIA_HTML']; ?>" class="acc-offscreen"><?= $v['AYUDA'] ?></div>
                                    <?php } ?>
                                </label>
                                <div>
                                    <?php
                                    if ($v['TIPO_CAMPO'] == "SELUNICA") {
                                        echo mostrar_select($v, $v["OPCIONES"]);
                                    } else if ($v['TIPO_CAMPO'] == "SELUNICA_RAD") {
                                        echo mostrar_radios($v, $v["OPCIONES"]);
                                    } else if ($v['TIPO_CAMPO'] == "SELUNICA_SI_NO") {
                                        echo mostrar_si_no($v, $v["OPCIONES"]);
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

            <?php if(isset($condicion_hogar)) { ?>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Condición de ocupación de la vivienda</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin: 20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="V_CON_OCUP" id="con_conper" value="1" <?= ($V_CON_OCUP==1)?'checked':''; ?>>
                            <label class="form-check-label" for="mashogcon_conper_si">
                                Ocupado con personas presentes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="V_CON_OCUP" id="con_contod" value="2" <?= ($V_CON_OCUP==2)?'checked':''; ?>>
                            <label class="form-check-label" for="con_contod">
                                Ocupado con todas las personas ausentes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="V_CON_OCUP" id="con_contem" value="3" <?= ($V_CON_OCUP==3)?'checked':''; ?>>
                            <label class="form-check-label" for="con_contem">
                                Vivienda temporal (Para vacaciones, trabajo, etc.)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="V_CON_OCUP" id="con_condes" value="4" <?= ($V_CON_OCUP==3)?'checked':''; ?>>
                            <label class="form-check-label" for="con_contem">
                                desocupada
                            </label>
                        </div>
                    </div>
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