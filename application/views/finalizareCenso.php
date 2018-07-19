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
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9"></div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmFormulario" name="frmFormulario" data-nume_pers="2" role="form" method="post">
            <input type="hidden" id="<?=$csrf['name']?>" name="<?=$csrf['name']?>" value="<?=$csrf['hash']?>" />
            <div class="row">
                <div id="finalizar_ecenso-col" class="col-xs-12 col-sm-12 col-md-12  ">
                    <fieldset>
                        <legend class="acc-offscreen">Ya terminó todo el formulario. ¿Desea dar por finalizado el eCenso? Si lo finaliza ya no podrá modificar los datos.</legend>
                        <div class="form-group">
                            <label id="finalizar_ecenso-lbl" class="control-label" for="finalizar_ecenso">Ya terminó todo el formulario. ¿Desea dar por finalizado el eCenso?<p size="50px" style="color:red;font-size:120%;">Si lo finaliza ya no podrá modificar los datos, ni diligenciar información de otros hogares.</p></label>
                            <div>
                                <div class='radio' id='radio_finalizar_ecenso_1'>
                                    <label>
                                        <input type='radio' name='finalizar_ecenso' id='finalizar_ecenso_1' value='1' aria-describedby='acc_ayuda_1' /> <span>Sí</span>
                                    </label>
                                </div>
                                <div id='acc_ayuda_1' class='acc-offscreen'></div>
                                <div class='radio' id='radio_finalizar_ecenso_2'>
                                    <label>
                                        <input type='radio' name='finalizar_ecenso' id='finalizar_ecenso_2' value='2' aria-describedby='acc_ayuda_2' /> <span>No</span>
                                    </label>
                                </div>
                                <div id='acc_ayuda_2' class='acc-offscreen'></div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" id="btnSiguiente" name="btnSiguiente" class="btn btn-dane-success">Guardar y continuar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>
            <div class="row hidden" id="divMsg">
                <div class="form-group">
                    <div class="col-md-12">
                        <div id="divMsgSuccess" class="alert alert-success hidden">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong id="msgSuccess"></strong>
                        </div>
                        <div id="divMsgAlert" class="alert alert-danger hidden">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong id="msgError"></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>
        </form>
    </div>
</div>