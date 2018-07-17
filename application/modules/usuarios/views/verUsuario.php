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
        <h3>Ver datos del encuestado</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <label class="control-label"><b>No. del formulario:</b></label>
            <div>
                <label id="codigo_encuesta" data-encuesta="<?=$usua['COD_ENCUESTAS']?>"><?=$usua['COD_ENCUESTAS']?></label>
                <input type="hidden" id="hddEncuesta" name="hddEncuesta" value="<?=$usua['COD_ENCUESTAS']?>"/>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <label class="control-label"><b>Estado del formulario:</b></label>
            <div>
                <label><?=$usua['ESTADO_FORM']?></label>
            </div>
        </div>
    </div>
     <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <?//php if(!empty($usua['pagina'])) { ?>
                <label class="control-label"><b>Página:</b></label>
                <button class="verPreguntas btn btn-sm btn-primary" type="button" data-modulo="<?=$usua['modulo']?>" data-pagina="<?=$usua['pagina']?>" title="<?=$usua['pagina']?>"><?=$usua['pagina']?></button>
            <?//php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <label class="control-label"><b>Tipo de documento:</b></label>
            <div>
                <label><?=$usua['DESCRIPCION']?></label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <label class="control-label"><b>Número de documento:</b></label>
            <div>
                <label><?=$usua['PA1_NRO_DOC']?></label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <?//php if(empty($usua['ESTADO_USUA'])) { ?>
                <label class="control-label"><b>Estado:</b></label>
                <div>
                    <label><?=$usua['ESTADO_USUA']?></label>
                </div>
            <?//php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <label class="control-label"><b>Usuario:</b></label>
            <div>
                <label><?=$usua['USUARIO']?></label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="form-group">
            <label class="control-label"><b>Nombre:</b></label>
            <div>
                <label><?=$usua['nombre']?></label>
            </div>
        </div>
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