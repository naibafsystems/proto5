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
    <div class="col-md-12">
        <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msgSuccess"><?= $msgSuccess ?></strong>
        </div>
        <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msgError"><?= $msgError ?></strong>
        </div>
    </div>
</div>
<form id="frmEncuesta" name="frmEncuesta" role="form" method="post">
    <div class="row">
        <div class="form-group">
            <label class="label-bold">Código de Diligenciamiento:<br><h3><b><?=$codiVerificacion?></b></h3></label>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 text-justify">
            <label>Apreciado <strong><?=$nombrePersona?></strong></label>
            <br />
            <label>Gracias por su participación en la construcción del Primer Censo Electrónico de Población y Vivienda del País. Con ello ha contribuido en la construcción de un país moderno e incluyente.</label>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="button" id="btnDescargar" name="btnDescargar" class="btn btn-dane-success">Ver constancia de diligenciamiento <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 text-justify">
                <p>Tenga en cuenta que con el código de diligenciamiento que aparece en la constancia (o el número de documento del jefe(a) de hogar) usted podrá evidenciar que su hogar fue eCensado.</p>
                <p>Para guardar o imprimir la constancia tendrá distintas alternativas: </p>
                <p>1. <label><strong>Hacer clic izquierdo sobre la imagen</strong></label> y seleccionar la opción de <label><strong>guardar como página web completa</strong></label>.</p>
                <p>2. <label><strong>Hacer clic izquierdo sobre la imagen</strong></label> y seleccionar la opción <label><strong>«imprimir»</strong></label>.</p>
                <p>3. <label><strong>Hacer clic izquierdo sobre la imagen</strong></label> y seleccione la opción <label><strong>«imprimir»</strong></label>; luego seleccionar la opción <label><strong>“Guardar”</strong></label>. </p>
                <p>4. <label><strong>Tomar un pantallazo</strong></label> con la tecla <label><strong>«Impr Pant»</strong></label> y guardar como <label>imagen</label>.</p>
            </div>
        </div>




    </div>
</form>