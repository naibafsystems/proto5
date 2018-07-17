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
            <?php foreach ($var as $k => $v) { ?>
                <div class="row">
                    <div id="<?= $v['REFERENCIA_HTML']; ?>-col" class="col-xs-12 col-sm-12 col-md-12 <?php echo(!empty($v['HIDDEN']) && $v['HIDDEN'] == 'SI') ? 'hidden': '';?> ">
                        <div class="form-group">
                            <?php if(!empty($v['DESCRIPCION'])) { ?>
                            <label id="<?= $v['REFERENCIA_HTML']; ?>-lbl" class="control-label" for="<?= $v['REFERENCIA_HTML'] ?>"> <?= $v['DESCRIPCION']; ?>
                                <?php if (!empty($v['AYUDA'])) { ?>
                                    &nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="<?= $v['REFERENCIA_HTML']; ?>-ayuda" data-tooltip="<?= $v['AYUDA'] ?>" aria-hidden="true"></span
                                <?php } ?>
                            </label>
                            <?php }
                            if ($v['TIPO_CAMPO'] == "SELUNICA") {
                                echo mostrar_select($v, $v["OPCIONES"]);
                            } else if ($v['TIPO_CAMPO'] == "SELUNICA_RAD") {
                                if($v["REFERENCIA_HTML"] == "nivel_anios") {
                                    $htmlTemp = '<div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4 user-name-border text-center"><label>Grados</label></div>
                                            <div class="col-md-4"></div>
                                        </div>';
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>1. Preescolar</label></div>
                                        <div class="col-md-8">';
                                    for($i = 0; $i <= 2; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>2. Básica primaria</label></div>
                                        <div class="col-md-8">';
                                    for($i = 3; $i <= 7; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>3. Básica secundaria (bachillerato básico)</label></div>
                                        <div class="col-md-8">';
                                    for($i = 8; $i <= 11; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>4. Media acádemica o clásica (bachillerato clásico)</label></div>
                                        <div class="col-md-8">';
                                    for($i = 12; $i <= 13; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>5. Media técnica (bachillerato técnico)</label></div>
                                        <div class="col-md-8">';
                                    for($i = 14; $i <= 15; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>6. Normalista</label></div>
                                        <div class="col-md-8">';
                                    for($i = 16; $i <= 19; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    $htmlTemp .= '<div class="row">
                                            <div class="col-md-4"><label class="label-bold">SUPERIOR</label></div>
                                            <div class="col-md-4 user-name-border text-center"><label>Años</label></div>
                                            <div class="col-md-4"></div>
                                        </div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>7. Técnica profesional</label></div>
                                        <div class="col-md-8">';
                                    for($i = 20; $i <= 22; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>8. Tecnológica</label></div>
                                        <div class="col-md-8">';
                                    for($i = 23; $i <= 25; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>9. Universitario</label></div>
                                        <div class="col-md-8">';
                                    for($i = 26; $i <= 31; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    $htmlTemp .= '<div class="row">
                                            <div class="col-md-4"><label class="label-bold">POSTGRADO</label></div>
                                            <div class="col-md-4 user-name-border text-center"><label>Años</label></div>
                                            <div class="col-md-4"></div>
                                        </div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>10. Especialización</label></div>
                                        <div class="col-md-8">';
                                    for($i = 32; $i <= 35; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>11. Maestría</label></div>
                                        <div class="col-md-8">';
                                    for($i = 36; $i <= 38; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $htmlTemp .= '<div class="row">
                                        <div class="col-md-4"><label>12. Doctorado</label></div>
                                        <div class="col-md-8">';
                                    for($i = 39; $i <= 44; $i++) {
                                        $arrTemp[] = $v["OPCIONES"][$i];
                                    }
                                    $htmlTemp .= mostrar_radios_seguidos($v, $arrTemp);
                                    $htmlTemp .= '</div></div>';
                                    unset($arrTemp);
                                    $v["OPCIONES"][45]["ETIQUETA"] = '';
                                    $arrTemp[] = $v["OPCIONES"][45];
                                    $htmlTemp .= '<div class="row">
                                            <div class="col-md-4"><label>13. Ninguno</label></div>
                                            <div class="col-md-8">' . mostrar_radios_seguidos($v, $arrTemp) . '</div>
                                        </div>';
                                    unset($arrTemp);

                                    echo $htmlTemp;
                                } else {
                                    echo mostrar_radios($v, $v["OPCIONES"]);
                                }
                            } else if ($v['TIPO_CAMPO'] == "TEXTO") {
                                echo mostrar_input_text($v);
                            } ?>
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