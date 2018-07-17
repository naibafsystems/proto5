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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h2 class=""><?= $title ?></h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
    <div class="row">    
        <div class="col-xs-12 col-sm-12 col-md-12 text-justify">
            <label>Muchas Gracias a todos los colombianos y colombianas que se sumaron a la innovación y participaron en el Censo Nacional de Población y Vivienda. Gracias a su participación podremos seguir avanzado en la consolidación del esquema de recolección virtual que se dispondrá a los ciudadanos en el próximo Censo de Población y Vivienda.</label>
        </div>
    </div>
</div>