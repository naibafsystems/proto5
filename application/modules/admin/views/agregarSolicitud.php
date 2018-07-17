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
        <h3><?=$title?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<form id="formSolicitud" name="formSolicitud" class="form-horizontal" role="form" method="post">
	<div class="form-group">
        <div class="col-md-6">
            <div for="tipoSolicitud"><label class="control-label">Tipo *:</label></div>
            <select name="tipoSolicitud" id="tipoSolicitud" class="form-control" autocomplete="off">
                <option value="">Seleccione</option>
                <?php
                foreach ($arrTipoSolicitudes as $data):
                    echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                endforeach;
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <div for="descripcion"><label class="control-label">Descripción *:</label></div>
            <textarea name="descripcion" id="descripcion" class="form-control" cols="60" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <div for="respuesta"><label class="control-label">Respuesta *:</label></div>
            <textarea name="respuesta" id="respuesta" class="form-control" cols="60" rows="4"></textarea>
        </div>
        <div class="col-md-6">
            <div for="observacion"><label class="control-label">Observación:</label></div>
            <textarea name="observacion" id="observacion" class="form-control" cols="60" rows="4"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="button" id="btnAgregar" name="btnAgregar" class="btn btn-dane-success">Agregar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
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
