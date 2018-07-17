

<form id="frmChange" name="frmChange" method="post">
    <input type="hidden" id="<?=$csrf['name']?>" name="<?=$csrf['name']?>" value="<?=$csrf['hash']?>" />
    <div class="row text-center">
        <div class="col-md-12">
            <h3><label class="titulos">Cambiar Contraseña</label></h3>
            <div class="container-fluid separador"></div>
        </div>
    </div>
    <div class="row alineacionverticaltexto">
        <div class="col-md-12">
            <label class="text-justify">Por favor ingrese la nueva contraseña para su cuenta:</label>
        </div>
    </div>

   <div class="form-group">
        <label id="contrasena1-lbl" class="control-label" for="contrasena1">Escriba su nueva contraseña</label>
        <div>
            <div class="input-text"><input type="password" id="contrasena1" name="contrasena1" size="20" maxlength="20" placeholder="Escriba su nueva contraseña" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" aria-invalid="false">
            </div>
        </div>
        <label id="contrasena1-error" class="error-form" role="alert" for="contrasena1" style="display: none;"></label>
    </div>

    <div class="form-group">
        <label id="contrasena2-lbl" class="control-label" for="contrasena2">Confirme su nueva contraseña</label>
        <div>
            <div class="input-text"><input type="password" id="contrasena2" name="contrasena2" size="20" maxlength="20" placeholder="Confirme su nueva contraseña" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" aria-invalid="false">
            </div>
        </div>
        <label id="contrasena2-error" class="error-form" role="alert" for="contrasena2" style="display: none;"></label>
    </div>

    <div class="row" style="padding-top: 20px;">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="button" class="btn btn-dane-success" id="btnSiguiente" name="btnSiguiente">Cambiar mi contrase&ntilde;a <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <div id="divMsgSuccess" class="alert alert-success hidden">
        <strong id="msgSuccess"><?= $msgSuccess ?></strong>
    </div>
    <div id="divMsgAlert" class="alert alert-success hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgError"><?= $msgError ?></strong>
    </div>
</form>