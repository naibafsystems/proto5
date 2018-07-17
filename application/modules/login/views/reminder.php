<form id="frmReminder" name="frmReminder" method="post">
    <input type="hidden" id="<?=$csrf['name']?>" name="<?=$csrf['name']?>" value="<?=$csrf['hash']?>" />
    <div class="row text-center">
        <div class="col-md-12">
            <h3><label class="titulos">Olvidó sus datos</label></h3>
            <div class="container-fluid separador"></div>
        </div>
    </div>
    <div class="row alineacionverticaltexto">
        <div class="col-md-12">
            <label class="text-justify">Por favor escriba la <strong> dirección de correo electrónico</strong> que usó para crear su cuenta:</label>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label for="txtReminder"></label>
            <input type="email" id="usuario" name="usuario" class="form-control" placeholder="Escriba el correo electr&oacute;nico que us&oacute; para crear su cuenta en el eCenso" required autofocus />
        </div>
    </div></br>

    <div id='html_element'></div><br>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p>Le enviaremos un c&oacute;digo de verificaci&oacute;n a la direcci&oacute;n de correo electr&oacute;nico registrado, con el cual podr&aacute; restaurar su contraseña.</p>
        </div>
    </div>
    <div class="row" style="padding-top: 20px;">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="button" class="btn btn-back" id="btnRegresar" name="btnRegresar"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </button>
            <button type="button" class="btn btn-dane-success" id="btnReminder" name="btnReminder">Restaurar mi contrase&ntilde;a <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgSuccess"><?= $msgSuccess ?></strong>
    </div>
    <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgError"><?= $msgError ?></strong>
    </div>

    <div id="divMsgAlertRest" class="alert alert-danger" <?php echo (strlen($this->session->flashdata('msgError')) == 0) ? 'style="display: none;"' : ''; ?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgErrorRest"><?= $this->session->flashdata('msgError') ?></strong>
    </div>
</form>