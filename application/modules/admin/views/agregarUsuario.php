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
<form id="formUsuario" name="formUsuario" class="form-horizontal" role="form" method="post">
	<div class="form-group">
        <label class="col-md-2 control-label">Primer nombre *::</label>
        <div class="col-md-4 control-option">
            <input type="text" name="nombre1Pers" id="nombre1Pers" class="form-control" maxlength="50" placeholder="Digite su primer nombre" />
        </div>
        <label class="col-md-2 control-label">Segundo nombre:</label>
        <div class="col-md-4 control-option">
            <input type="text" name="nombre2Pers" id="nombre2Pers" class="form-control" maxlength="50" placeholder="Digite su segundo nombre" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Primer apellido *:</label>
        <div class="col-md-4 control-option">
            <input type="text" name="apellido1Pers" id="apellido1Pers" class="form-control" maxlength="50" placeholder="Digite su primer apellido" />
        </div>
        <label class="col-md-2 control-label">Segundo apellido:</label>
        <div class="col-md-4 control-option">
            <input type="text" name="apellido2Pers" id="apellido2Pers" class="form-control" maxlength="50" placeholder="Digite su segundo apellido" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Correo electrónico *:</label>
        <div class="col-md-4 control-option">
            <input type="text" name="usuario" id="usuario" class="form-control" maxlength="50" placeholder="El formato debe ser usuario@ejemplo.com" />
        </div>
        <label class="col-md-2 control-label" for="estado_usua">Tipo *:</label>
        <div class="col-md-4 control-option">
            <select name="tipo" id="tipo" class="form-control" autocomplete="off">
                <option value="">Seleccione</option>
                <?php
                foreach ($arrTipoUsua as $data):
                    echo "<option value='" . $data['ID_VALOR'] . "'>" . $data['ETIQUETA'] . "</option>";
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Escriba una contraseña *:</label>
        <div class="col-md-4 control-option">
            <input type="password" name="contrasena1" id="contrasena1" class="form-control" maxlength="20" placeholder="Digite su contraseña" />
        </div>
        <label class="col-md-2 control-label">Escriba nuevamente su contraseña *:</label>
        <div class="col-md-4 control-option">
            <input type="password" name="contrasena2" id="contrasena2" class="form-control" maxlength="20" placeholder="Digite su contraseña" />
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
