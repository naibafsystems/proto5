<?php
$msgSuccessFD = $this->session->flashdata('msgSuccess');
$msgErrorFD = $this->session->flashdata('msgError');
if (!empty($msgSuccessFD)) {
    $msgSuccess = $msgSuccessFD;
}
if (!empty($msgErrorFD)) {
    $msgError = $msgErrorFD;
}
?>

<div class="row text-center">
    <div class="col-md-12">
        <h3><label class="titulos">ECENSO OFFLINE</label></h3>
        <div class="container-fluid separador"></div>
    </div>
</div>
<!--
<div id="divMsgSuccess" class="alert alert-success" <?php echo (empty($msgSuccess)) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgSuccess"><?= $msgSuccess ?></strong>
</div>
<div id="divMsgAlert" class="alert alert-danger" <?php echo (empty($msgError)) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgError"><?= $msgError ?></strong>
</div>
-->
<?php if($mostrar_msgSuccess==1){?>
<div class="row <?php echo (strlen($msgSuccess) == 0 && strlen($msgError) == 0) ? 'hidden' : ''; ?>" id="divMsg">
    <div class="form-group">
        <div class="col-md-12">
            <div id="" class="alert alert-success <?php echo (strlen($msgSuccess) == 0) ? 'hidden' : ''; ?>">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgSuccess"><?= $msgSuccess ?></strong>
            </div>
            <div id="" style="text-align: center;" class="alert alert-danger <?php echo (strlen($msgError) == 0) ? 'hidden' : ''; ?>">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgError"><?= $msgError ?></strong>
            </div>
        </div>
    </div>
</div>
</br>
<div class="row">
 <div class="col-md-12 text-justify ">
        <label>
           Gracias por su participación en la construcción del Primer Censo Electrónico de Población y Vivienda del País. Con ello ha contribuido en la construcción de un país moderno e incluyente.				
		</label>
		</br></br>
		 <label>
           En el siguiente botón podrá descargar el certificado de participación en el eCenso.
		</label><br>
</div>
</div>
</br>
<div class="row">
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="button" id="btnDescargar" name="btnDescargar" class="btn btn-dane-success">Descargar certificado <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
            </div>
        </div>
</div>

<?php }?>


<div class="row">
    <div class="col-md-12 before-footer">&nbsp;</div>
</div>
