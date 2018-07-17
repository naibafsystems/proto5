<div class="row">
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
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                        <button type="button" id="save" name="save" class="btn btn-dane-success">Guardar<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>