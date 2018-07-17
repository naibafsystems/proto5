<div class="row">
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9">
            <?php if(!empty($URLVideo)) { ?>
                <iframe src="<?=$URLVideo?>?rel=0&fs=0&showinfo=0&modestbranding=1" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmUbicacion" name="frmUbicacion" role="form" method="post">
            <?php foreach ($var as $k => $v) { ?>
                <div class="row">
                    <div id="<?= $v['ID_PREGUNTA']; ?>-col" class="col-xs-12 col-sm-12 col-md-12 <?php echo(!empty($v['HIDDEN']) && $v['HIDDEN'] == 'SI') ? 'hidden': '';?> ">
                        <div class="form-group">
                            <label id="<?= $v['ID_PREGUNTA']; ?>-lbl" class="control-label" for="<?= $v['ID_PREGUNTA'] ?>"> <?= $v['DESCRIPCION'];?>
                                <?php if (!empty($v['AYUDA'])) { ?>
                                    &nbsp;<span class="glyphicon glyphicon-question-sign font-help" id="<?= $v['ID_PREGUNTA']; ?>-ayuda" data-tooltip="<?=$v['AYUDA']?>" aria-hidden="true"></span>
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
                    </div>
                </div>
                <?php if($v['ID_PREGUNTA'] == 'tiene_comple_direccion') { ?>
                    <div id="plantilla_complemento" class="hidden">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-2 col-sm-2 col-md-offset-3 col-md-2">
                                    <label class="control-label">Complemento</label>
                                    <select name="complemento" data-field="complemento" class="form-control adicionarComple" autocomplete="off">
                                        <option value="">Ejemplo: Manzana</option>
                                        <?php
                                        foreach ($arrComplemento as $data):
                                            echo "<option value='" . $data['ID_VALOR'] . "'>" . $data['ETIQUETA'] . "</option>";
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <label class="control-label">Adición</label>
                                    <input type="text" name="adicion" data-field="adicion" class="form-control adicionarComple"  placeholder="Ejemplo 26A" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div id="otro_comple-col" class="col-xs-12 col-sm-12 col-md-12">
                                    <label id="otro_comple-lbl" class="control-label" for="otro_comple">¿Agregar otro complemento?</label>
                                    <div class="radio" id="radio_otro_comple_1">
                                        <label><input name="otro_comple" id="otro_comple_1" value="1" class="otro_comple" aria-describedby="acc_ayuda_1" type="radio"> Sí</label>
                                    </div>
                                    <div class="radio" id="radio_otro_comple1_2">
                                        <label><input name="otro_comple" id="otro_comple_2" value="2" aria-describedby="acc_ayuda_2" type="radio"> No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="agregar_comple">
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <p>Su dirección es <label class="label-bold"><?=$direccion ?></label></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
        </form>
    </div>
</div>