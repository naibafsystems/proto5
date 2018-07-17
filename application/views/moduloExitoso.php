<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-offset-3 col-md-6 text-center">
        <p>
            <h2>¡La sección <strong><?=$moduleName?></strong> ha finalizado con éxito!</h2>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-offset-3 col-md-6 text-center">
        <p class="success-circle">
            <img id="imgUbicacion" src="<?= base_url_images("completo/" . $imageLogo . ".png"); ?>" height="50%" width="50%" />
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-offset-3 col-md-6 text-center">
        <button type="button" id="btnContinuar" name="btnContinuar" class="btn btn-dane-success">Continuar</button>
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
