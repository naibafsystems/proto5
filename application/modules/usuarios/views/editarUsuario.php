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
<form id="formUsuario" name="formUsuario" class="form-horizontal" role="form" method="post">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label class="control-label"><b>No. del formulario:</b></label>
                <div>
                    <label id="codigo_encuesta" data-encuesta="<?=$usua['COD_ENCUESTAS']?>"><?=$usua['COD_ENCUESTAS']?></label>
                    <input type="hidden" id="hddEncuesta" name="hddEncuesta" value="<?=$usua['COD_ENCUESTAS']?>"/>
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
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label class="control-label"><b>Tipo de documento:</b></label>
                <div>
                    <label><?=$usua['DESCRIPCION']?></label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label class="control-label"><b>Número de documento:</b></label>
                <div>
                    <label><?=$usua['PA1_NRO_DOC']?></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label class="control-label"><b>Nombre:</b></label>
                <div>
                    <label><?=$usua['nombre']?></label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label class="control-label"><b>Correo electrónico:</b></label>
                <div>
                    <label><?=$usua['USUARIO']?></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label class="ccontrol-label" for="txtDescripcion"><b>Descripción del cambio de estado:</b></label>
                <div>
                    <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" style="font-weight: normal" maxlength="400" rows="5" required></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <button type="button" id="btnGuardarUsuario" name="btnGuardarUsuario" class="btn btn-dane-success">Cambiar Estado <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
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
<div class="row">
    <div class="col-md-12 before-footer">&nbsp;</div>
</div>