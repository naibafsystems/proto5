<?php
$msgSuccessFD = $this->session->flashdata('msgSuccess');
$msgErrorFD = $this->session->flashdata('msgError');
if(!empty($msgSuccessFD)) {
    $msgSuccess = $msgSuccessFD;
}
if(!empty($msgErrorFD)) {
    $msgError = $msgErrorFD;
}
?>
<div class="row">
    <div class="col-md-12 text-center">
        <h3>Datos del encuestado</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<form id="formCorreo" name="formCorreo" class="form-horizontal" role="form" method="post">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label class="control-label"><b>No. del formulario:</b></label>
                <div>
                    <label id="codigo_encuesta" data-encuesta="<?=$usua['COD_ENCUESTAS']?>"><?=$usua['COD_ENCUESTAS']?></label>
                    <input type="hidden" id="encuesta" name="encuesta" value="<?=$usua['COD_ENCUESTAS']?>"/>
                    <input type="hidden" id="usuario" name="usuario" value="<?=$usua['ID_PERSONA_RESIDENTE']?>"/>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label class="control-label"><b>Estado del formulario:</b></label>
                <div>
                    <label><?=$usua['ESTADO_FORM']?></label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="correo_electronico-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="correo_electronico-lbl" class="control-label" for="correo_electronico">Correo electrónico</label>
                    <div>
                        <div class="input-text"><input id="correo_electronico" name="correo_electronico" size="50" maxlength="50" placeholder="Correo electrónico" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" type="text" value="<?=$usua['USUARIO']?>">
                        </div>                               
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div id="tipo_documento-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="tipo_documento-lbl" class="control-label" for="tipo_documento"> Tipo de documento</label>
                    <div>
                        <div class="select"><select id="tipo_documento" name="tipo_documento" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control">
                            <option value="3" <?php echo ($usua['PA_TIPO_DOC'] == 3)? 'selected': '' ?>>Cédula de ciudadanía</option>
                            <option value="4" <?php echo ($usua['PA_TIPO_DOC'] == 4)? 'selected': '' ?>>Cédula de extranjería</option>
                        </select></div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div id="numero_documento-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="numero_documento-lbl" class="control-label" for="numero_documento"> Número de documento                                                                    </label>
                    <div>
                        <div class="input-text"><input id="numero_documento" name="numero_documento" size="12" maxlength="12" placeholder="Número de documento" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" type="text" value="<?=$usua['PA1_NRO_DOC']?>">
                        </div>                                
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div id="primer_nombre-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="primer_nombre-lbl" class="control-label" for="primer_nombre"> Primer nombre                                                                    </label>
                    <div>
                        <div class="input-text"><input id="primer_nombre" name="primer_nombre" size="30" maxlength="30" placeholder="Digite su primer nombre (ej José)" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" type="text" value="<?=$usua['RA2_1NOMBRE']?>">
                        </div>                               
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div id="segundo_nombre-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="segundo_nombre-lbl" class="control-label" for="segundo_nombre"> Segundo nombre                                                                    </label>
                    <div>
                        <div class="input-text"><input id="segundo_nombre" name="segundo_nombre" size="30" maxlength="30" placeholder="Digite su segundo nombre (ej Luis)" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" type="text" value="<?=$usua['RA3_2NOMBRE']?>">
                        </div>                               
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div id="primer_apellido-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="primer_apellido-lbl" class="control-label" for="primer_apellido"> Primer apellido                                                                    </label>
                    <div>
                        <div class="input-text"><input id="primer_apellido" name="primer_apellido" size="30" maxlength="30" placeholder="Digite su primer apellido (ej Rodríguez)" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" type="text" value="<?=$usua['RA4_1APELLIDO']?>">
                        </div>                               
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div id="segundo_apellido-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="segundo_apellido-lbl" class="control-label" for="segundo_apellido"> Segundo apellido                                                                    </label>
                    <div>
                        <div class="input-text"><input id="segundo_apellido" name="segundo_apellido" size="30" maxlength="30" placeholder="Digite su segundo apellido (ej Gómez)" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" type="text" value="<?=$usua['RA5_2APELLIDO']?>">
                        </div>                               
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div id="sexo_persona-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="sexo_persona-lbl" class="control-label" for="sexo_persona">Sexo </label>
                    <div>
                        <div class="select"><select id="sexo_persona" name="sexo_persona" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control">
                            <option value="1" <?php echo ($usua['P_SEXO'] == 1)? 'selected': '' ?>>Hombre</option>
                            <option value="2" <?php echo ($usua['P_SEXO'] == 2)? 'selected': '' ?>>Mujer</option>
                        </select></div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

<?php
    if($usua['ID_ESTADO_USUA'] != 1) {
?>

    <div class="row">
        <div id="estado_persona-col" class="col-xs-12 col-sm-12 col-md-12  ">
            <fieldset>
                <div class="form-group">
                    <label id="estado_persona-lbl" class="control-label" for="estado_persona">Estado</label>
                    <div>
                        <div class="select"><select id="estado_persona" name="estado_persona" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control">
                            <option value="1" <?php echo ($usua['ID_ESTADO_USUA'] == 1)? 'selected': '' ?>>Activo</option>
                            <option value="2" <?php echo ($usua['ID_ESTADO_USUA'] != 1)? 'selected': '' ?>>Inactivo</option>
                        </select></div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

<?php
    }
?>

    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <button type="button" id="btnGuardarCorreo" name="btnGuardarCorreo" class="btn btn-dane-success">Actualizar Información <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
            </div>
        </div>
    </div>
</form>

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