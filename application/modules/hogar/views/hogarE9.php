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
                    <h3>Conformación del hogar</h3>

                    <p>Incluya en este listado a las personas de su hogar. Un hogar está conformado por una persona o un grupo de personas, que viven la mayor parte del tiempo en la misma vivienda que usted habita, sean parientes o no. Los miembros del hogar generalmente comparten los alimentos Se trata de personas que generalmente comen juntas y demandan bienes y servicios con un presupuesto compartido.</p>

                    <p>Incluya niños, ancianos, personas internadas en clínicas, personas secuestradas y personas que están fuera del hogar por vacaciones.</p>
                    <p>Tenga presente que, de manera automática, el sistema registra como jefe(a) de hogar a la persona que crea la cuenta. Si esa persona no es jefe(a) de hogar, diligencie los espacios de información a continuación, con los datos de la persona jefe(a) de hogar, y en la pregunta ¿Es el Jefe(a) de hogar? seleccione la opción SÍ.</p>

                    <!-- <p>Consulte con los miembros de su hogar si usted ya fue registrado.</p> -->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table id="tabla_personas" class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr class="success">
                                <th>Tipo Docu.</th>
                                <th>Número documento</th>
                                <th>Fecha expedición</th>
                                <th>Nombre</th>
                                <th>Jefe de hogar</th>
                                <th>Sexo</th>
                                <th>Años cumplidos</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h3>Agregar residente y/o miembro del hogar</h3>
                    <p>Si es necesario, utilice las siguientes casillas para ingresar la información de las personas que conforman su hogar. Al finalizar la información de cada persona dé clic en el botón "<b>AGREGAR</b>".</p>
                </div>
            </div>
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
                <div class="">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="button" id="btnGuardarPersona" name="btnGuardarPersona" data-accion="agregar" data-idpers="" class="btn btn-primary">Agregar</button>
                        <button type="button" id="btnLimpiarPersona" name="btnLimpiarPersona" class="btn btn-primary">Limpiar</button>
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