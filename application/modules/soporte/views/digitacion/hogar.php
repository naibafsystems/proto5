<div class="row">
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmHogar" name="frmHogar" role="form" method="post">
            <?php if($mostrarSituaciones == 'SI') {?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="control-label">¿Algún miembro de su hogar ha vivido alguna de las siguientes situaciones entre 1985 y la fecha de hoy?</label>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php foreach ($var as $k => $v) { ?>
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
                                <?php if ($v['TIPO_CAMPO'] == "SELUNICA") {
                                    echo mostrar_select($v, $v["OPCIONES"]);
                                } else if ($v['TIPO_CAMPO'] == "SELUNICA_RAD") {
                                    echo mostrar_radios($v, $v["OPCIONES"]);
                                } else if ($v['TIPO_CAMPO'] == "TEXTO") {
                                    echo mostrar_input_text($v);
                                } ?>
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