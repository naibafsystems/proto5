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
        <h3>Lista de preguntas frecuentes</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-md-12">
        <form id="formSolicitudes" name="formSolicitudes" class="" role="form" method="post">
            <div class="row">
                <div class="form-group col-md-offset-3 col-md-6">
                    <label class="control-label" for="tipoSolicitud">Tipo de solicitud</label>
                    <select name="tipoSolicitud" id="tipoSolicitud" class="form-control" autocomplete="off">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($arrTipoSolicitudes as $data):
                            echo '<option value="' . $data['ID_VALOR'] . '">' . $data['ETIQUETA'] . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 text-center">
                    <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-dane-success" 
                        data-loading-text="Buscar <span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> ">Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table id="tablaSolicitudes" class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
            <thead>
                <tr class="success">
                    <th>Tipo</th>
                    <th>Respuesta</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
        </table>
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
