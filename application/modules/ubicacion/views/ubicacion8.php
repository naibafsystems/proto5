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
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-12">
                    <input type="hidden" id="direJson" value="<?=$direJson?>" class="hidden" />
                    <label>Ingrese la <strong>dirección de su vivienda</strong>, tenga en cuenta el siguiente ejemplo:</label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-12">
                    <table class="table table-direccion">
                        <tr>
                            <td>Calle</td>
                            <td>26</td>
                            <td>36A</td>
                            <td>BIS</td>
                            <td>98D</td>
                            <td>Sur</td>
                            <td class="label-numeral">#</td>
                            <td>Carrera</td>
                            <td>30</td>
                            <td>15A</td>
                            <td>Bis</td>
                            <td>14E</td>
                            <td>25</td>
                            <td>Norte</td>
                        </tr>
                        <tr>
                            <td class="label-bold border-right border-left-via">Tipo de via</td>
                            <td class="label-bold border-right">Número de vía</td>
                            <td class="label-bold border-right">Adición</td>
                            <td class="label-bold border-right">Sufijo</td>
                            <td class="label-bold border-right">Adición</td>
                            <td class="label-bold border-right-via">Cuadrante</td>
                            <td class="label-bold"> </td>
                            <td class="label-bold border-right border-left-via">Tipo de via</td>
                            <td class="label-bold border-right">Número de vía</td>
                            <td class="label-bold border-right">Adición</td>
                            <td class="label-bold border-right">Sufijo</td>
                            <td class="label-bold border-right">Adición</td>
                            <td class="label-bold border-right">Número</td>
                            <td class="label-bold border-right-via">Cuadrante</td>
                        </tr>
                        <tr>
                            <td class="border-left-via">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="border-right-via">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="border-left-via">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="border-right-via">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="label-via text-center">Vía principal</td>
                            <td> </td>
                            <td colspan="7" class="label-via text-center">Vía secundaria</td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php foreach ($var as $k => $v) {
                if($v['ID_PREGUNTA'] == 'direccion') { ?>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-12">
                        <h4 class="label-bold">Vía principal </h4>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label>Tipo de vía</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label>Número de vía</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <label>Adición</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label>Sufijo</label><br />
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <label>Adición</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label>Cuadrante</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <select name="tipo_via" id="tipo_via" class="form-control" autocomplete="off">
                            <option value="">Ejemplo: Calle</option>
                            <?php
                            foreach ($arrTipoVia as $data):
                                $tag = ($data['ID_VALOR'] == $tipo_via) ? 'selected' : '';
                                echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <select name="numero_via" id="numero_via" class="form-control" autocomplete="off">
                            <option value="">Ej: 26</option>
                            <?php
                            foreach ($arrNumeroVia as $data):
                                $tag = ($data['ID_VALOR'] == $numero_via) ? 'selected' : '';
                                echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <input type="text" id="letra_via" name="letra_via" placeholder="Ej. A" maxlength="3" size="3" value="<?=$letra_via?>" class="form-control" style="width: 80px;" />
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <select name="bis_via" id="bis_via" class="form-control" autocomplete="off">
                            <option value="">Ej. Bis</option>
                            <option value="bis">Bis</option>
                        </select>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <input type="text" id="letra_sufijo" name="letra_sufijo" placeholder="Ej. 22C" maxlength="3" size="3" value="<?=$letra_sufijo?>" class="form-control" style="width: 80px;" />
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <select name="cuadrante" id="cuadrante" class="form-control" autocomplete="off">
                            <option value="">Ej: Norte</option>
                            <?php
                            foreach ($arrCuadrante as $data):
                                $tag = ($data['ID_VALOR'] == $cuadrante) ? 'selected' : '';
                                echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-12">
                        <h4 class="label-bold"># Vía secundaria </h4>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label>Tipo de vía</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label>Número de vía</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <label>Adición</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label>Sufijo</label><br />
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <label>Adición</label>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1">
                        <label>Número</label>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-2">
                        <label>Cuadrante</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <select name="tipo_via2" id="tipo_via2" class="form-control" autocomplete="off">
                            <option value="">Ejemplo: Calle</option>
                            <?php
                            foreach ($arrTipoVia2 as $data):
                                $tag = ($data['ID_VALOR'] == $tipo_via2) ? 'selected' : '';
                                echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <select name="numero_via2" id="numero_via2" class="form-control" autocomplete="off">
                            <option value="">Ej: 26</option>
                            <?php
                            foreach ($arrNumeroVia as $data):
                                $tag = ($data['ID_VALOR'] == $numero_via2) ? 'selected' : '';
                                echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <input type="text" id="letra_via2" name="letra_via2" placeholder="Ej. B" maxlength="3" size="3" value="<?=$letra_via2?>" class="form-control" style="width: 80px;" />
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <select name="bis_via2" id="bis_via2" class="form-control" autocomplete="off">
                            <option value="">Ej. Bis</option>
                            <option value="bis">Bis</option>
                        </select>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-1">
                        <input type="text" id="letra_sufijo2" name="letra_sufijo2" placeholder="Ej. 22C" maxlength="3" size="3" value="<?=$letra_sufijo2?>" class="form-control" style="width: 80px;" />
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1">
                        <input type="text" id="numero_placa" name="numero_placa" placeholder="Ej. 45" maxlength="3" size="3" value="<?=$numero_placa?>" class="form-control" style="width: 80px;" />
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-2">
                        <select name="cuadrante2" id="cuadrante2" class="form-control" autocomplete="off">
                            <option value="">Seleccione</option>
                            <?php
                            foreach ($arrCuadrante2 as $data):
                                $tag = ($data['ID_VALOR'] == $cuadrante2) ? 'selected' : '';
                                echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                </div>
            <?php } ?>
                <div class="row">
                    <div id="<?= $v['ID_PREGUNTA']; ?>-col" class="col-xs-12 col-sm-12 col-md-12 <?php echo(!empty($v['HIDDEN']) && $v['HIDDEN'] == 'SI') ? 'hidden': '';?> ">
                        <div class="form-group">
                            <label id="<?= $v['ID_PREGUNTA']; ?>-lbl" class="control-label" for="<?= $v['ID_PREGUNTA'] ?>"> <?= $v['DESCRIPCION'];?>
                                <?php if (!empty($v['AYUDA'])) { ?>
                                    &nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="<?= $v['ID_PREGUNTA']; ?>-ayuda" data-tooltip="<?=$v['AYUDA']?>" aria-hidden="true"></span>
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
            <?php } ?>
            <div class="row">
                <div id="direccion-error-col" class="col-xs-2 col-sm-2 col-md-12 errorForm">
                    <ul id="direccion-error"></ul>
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