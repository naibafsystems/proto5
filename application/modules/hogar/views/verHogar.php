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
        <h3>Ver datos del hogar</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label class="control-label"><b>No. formulario</b></label>
        <p id="codigo_encuesta" data-encuesta="<?=$usua['COD_ENCUESTAS']?>"><?=$usua['COD_ENCUESTAS']?></p>
    </div>
    <div class="form-group col-md-4">
        <label class="control-label"><b>Estado formulario</b></label>
        <p><?=$usua['ESTADO_FORM']?></p>
    </div>
    <?php if(!empty($usua['pagina'])) { ?>
        <div class="form-group col-md-4">
            <label class="control-label"><b>Página</b></label>
            <button class="verPreguntas btn btn-sm btn-primary" type="button" data-modulo="<?=$usua['modulo']?>" data-pagina="<?=$usua['pagina']?>" title="<?=$usua['pagina']?>"><?=$usua['pagina']?></button>
        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label class="control-label"><b>Usuario</b></label>
        <p><?=$usua['USUARIO']?></p>
    </div>
    <div class="form-group col-md-4">
        <label class="control-label"><b>Estado</b></label>
        <p><?=$usua['ESTADO_USUA']?></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label class="control-label"><b>Tipo de documento</b></label>
        <p><?=$usua['DESCRIPCION']?></p>
    </div>
    <div class="form-group col-md-4">
        <label class="control-label"><b>Número de documento</b></label>
        <p><?=$usua['PA1_NRO_DOC']?></p>
    </div>
    <div class="form-group col-md-4">
        <label class="control-label"><b>Nombre</b></label>
        <p><?=$usua['nombre']?></p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table id="tabla_personas" class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
            <thead>
                <tr class="success">
                    <th>Tipo Docu.</th>
                    <th>Número documento</th>
                    <th>Nombre</th>
                    <th>Jefe de hogar</th>
                    <th>Sexo</th>
                    <th>Años cumplidos</th>
                    <th>Página</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-md-12">
        <button type="button" id="btnRegresar" name="btnRegresar" class="btn btn-back"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar</button>
    </div>
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
<div class="row">
    <div class="col-md-12 before-footer">&nbsp;</div>
</div>