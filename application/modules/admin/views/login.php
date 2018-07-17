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
        <h3>Módulo de administración</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4 well">
        <h4>Usuario Registrado:</h4>
        <form id="frmIngreso" name="frmIngreso" class="form-signin" method="post">
            <input type="hidden" id="<?=$csrf['name']?>" name="<?=$csrf['name']?>" value="<?=$csrf['hash']?>" />
            <fieldset>
                <input type="text" id="usuario_admin" name="usuario_admin" class="form-control" placeholder="Correo electrónico" required />
                <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required />
                <br/>
                <div class="g-recaptcha" data-sitekey=""></div>
                <div id='html_element'></div>
                <br/>
                <button type="button" id="btnIngresar" name="btnIngresar" autofocus class="btn btn-dane-success" data-loading-text="Ingresar <span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> "> Ingresar</button>
                <div class="pull-right">
                    <a href="login/recuperarContrasena">¿Olvidó su contraseña?</a>
                </div>
            </fieldset>
        </form>
        <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msgSuccess"><?= $msgSuccess ?></strong>
        </div>
        <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msgError"><?= $msgError ?></strong>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>