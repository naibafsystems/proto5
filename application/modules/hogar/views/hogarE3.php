<div class="row" id="divContent">
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9">
            <?php if(!empty($URLVideo)) { ?>
                <iframe src="<?=$URLVideo?>?rel=0&fs=0&showinfo=0&modestbranding=1" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmHogar" name="frmHogar" role="form" method="post">
            <input type="hidden" name="hdnAccion" id="hdnAccion" value="agregar" />
            <input type="hidden" name="idEditar" id="idEditar" />
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <label id="numero_fallecidas-lbl" class="control-label" for="numero_fallecidas">¿Cuántas personas que eran miembros de su hogar <strong>fallecieron en el 2017</strong>?<br />Total&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="numero_cuartos-ayuda" data-tooltip="Incluya las personas que al momento de morir hacían parte de su hogar (vivían con usted)." aria-describedby="qtip-85" aria-hidden="true" data-hasqtip="85"></span>
                        <div id="acc_ayuda_numero_cuartos" class="acc-offscreen">Incluya las personas que al momento de morir hacían parte de su hogar (vivían con usted).</div></label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <select name="numero_fallecidas" id="numero_fallecidas" class="form-control" autocomplete="off" aria-required="true">
                            <option value="">Total fallecidos</option>
                            <?php
                            foreach ($arrTotal as $data):
                                $tag = ($data['ID_OPCION'] === $numero_fallecidas) ? 'selected' : '';
                                echo '<option value="' . $data['ID_OPCION'] . '"' . $tag .'>' . $data['DESCRIPCION_OPCION'] . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div id="grillaFallecidas" class="<?=($numero_fallecidas == 0) ? 'hidden': ''; ?>">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label for="sexo_fallecida" class="control-label">Sexo</label>
                            <select name="sexo_fallecida" id="sexo_fallecida" class="form-control" autocomplete="off" aria-required="true">
                                <option value="">Seleccione</option>
                                <?php
                                foreach ($arrSexos as $data):
                                    echo '<option value="' . $data['ID_VALOR'] . '">' . $data['ETIQUETA'] . '</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label for="edad_fallecida" class="control-label">Edad al morir</label>&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="edad_fallecida-ayuda" data-tooltip="Para menores de 1 año escriba 0." aria-describedby="qtip-84" aria-hidden="true" data-hasqtip="84"></span>
                            <select name="edad_fallecida" id="edad_fallecida" class="form-control" autocomplete="off" aria-required="true">
                                <option value="">Seleccione</option>
                                <?php
                                foreach ($arrEdades as $data):
                                    echo '<option value="' . $data['ID_OPCION'] . '">' . $data['DESCRIPCION_OPCION'] . '</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label for="certificado_fallecida" class="control-label">¿Se expidi&oacute; certificado de defunci&oacute;n?</label>&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="certificado_fallecida-ayuda" data-tooltip="Certificado de defunción: documento destinado a acreditar la defunción de todo individuo nacido vivo o nacido muerto, según el caso." aria-describedby="qtip-84" aria-hidden="true" data-hasqtip="84"></span>
                            <select id="certificado_fallecida" name="certificado_fallecida" class="form-control" autocomplete="off" aria-required="true">
                                <option value="">Seleccione</option>
                                <?php
                                foreach ($arrCF as $data):
                                    echo '<option value="' . $data['ID_OPCION'] . '">' . $data['DESCRIPCION_OPCION'] . '</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <button type="button" id="btnGuardarFallecida" name="btnGuardarFallecida" class="btn btn-primary">Agregar</button>
                            <button type="button" id="btnLimpiarFallecida" name="btnLimpiarFallecida" class="btn btn-primary">Limpiar</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <table id="tabla_fallecidas" class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr class="success">
                                    <th>Sexo</th>
                                    <th>Edad</th>
                                    <th>Certificado</th>
                                    <th>Opción</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
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
<?php if(!empty($mensajeConfirmacion)) {?>
<div id="mensajeConfirmacion" class="hidden">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p><?=$mensajeConfirmacion?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <div class="row <?php echo (strlen($msgSuccess) == 0 || strlen($msgError) == 0) ? 'hidden' : ''; ?>" id="divMsgConfirm">
        <div class="form-group">
            <div class="col-md-12">
                <div id="divMsgSuccessConfirm" class="alert alert-success <?php echo (strlen($msgSuccess) == 0) ? 'hidden' : ''; ?>">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong id="msgSuccessConfirm"><?= $msgSuccess ?></strong>
                </div>
                <div id="divMsgAlertConfirm" class="alert alert-danger <?php echo (strlen($msgError) == 0) ? 'hidden' : ''; ?>">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong id="msgErrorConfirm"><?= $msgError ?></strong>
                </div>
            </div>
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