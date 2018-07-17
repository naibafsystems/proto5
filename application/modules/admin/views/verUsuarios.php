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
        <h3>Búsqueda de usuarios</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-md-12">
        <form id="formUsuario" name="formUsuario" class="" role="form" method="post">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Correo electrónico</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Correo electronico" />
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Tipo de documento</label>
                    <select name="tipo_docu" id="tipo_docu" class="form-control" autocomplete="off">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($arrTipoDocuPers as $data):
                            echo "<option value='" . $data['ID_VALOR'] . "'>" . $data['ETIQUETA'] . "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Número de documento:</label>
                    <input type="text" id="nume_docu" name="nume_docu" class="form-control" placeholder="Número de documento" />
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Estado del formulario</label>
                    <select name="estado_form" id="estado_form" class="form-control" autocomplete="off">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($arrEstados as $data):
                            echo '<option value="' . $data['ID_VALOR'] . '">' . $data['ETIQUETA'] . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Primer nombre</label>
                    <input type="text" id="nombre1Pers" name="nombre1Pers" class="form-control" placeholder="Primer nombre" />
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Segundo Nombre</label>
                    <input type="text" id="nombre2Pers" name="nombre2Pers" class="form-control" placeholder="Segundo nombre" />
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Primer Apellido</label>
                    <input type="text" id="apellido1Pers" name="apellido1Pers" class="form-control" placeholder="Primer apellido" />
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Segundo Apellido</label>
                    <input type="text" id="apellido2Pers" name="apellido2Pers" class="form-control" placeholder="Segundo apellido" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label" for="tipo_usua">Tipo de usuario</label>
                    <select name="tipo_usua" id="tipo_usua" class="form-control" autocomplete="off">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($arrTipoUsua as $data):
                            echo "<option value='" . $data['ID_VALOR'] . "'>" . $data['ETIQUETA'] . "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label" for="tipo_usua">Estado del usuario</label>
                    <select name="estado_usua" id="estado_usua" class="form-control" autocomplete="off">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($arrEstadoUsua as $data):
                            echo "<option value='" . $data['ID_VALOR'] . "'>" . $data['ETIQUETA'] . "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 text-center">
                    <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-dane-success" 
                        data-loading-text="Buscar <span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> ">Buscar</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#estadoFormularioModal">Consultar estados <span class="glyphicon glyphicon-modal-window" aria-hidden="true"></span></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table id="tablaUsuarios" class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
            <thead>
                <tr class="success">
                    <th>Usuario (email)</th>
                    <th>Número docu.</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Estado formulario</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">&nbsp;</div>
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
<div class="modal fade" id="estadoFormularioModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Estados formulario</h4>
            </div>
            <div class="modal-body">
                <?php
                foreach ($arrEstados as $data):
                    echo '<p><label>' . $data['ID_VALOR'] . '</label>: ' . $data['ETIQUETA'] . '</p>';
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>