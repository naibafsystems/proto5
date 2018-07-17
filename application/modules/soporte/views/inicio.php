<?php
$msgSuccessFD = $this->session->flashdata('msgSuccess');
$msgErrorFD = $this->session->flashdata('msgError');
$msgWelcomeFD = $this->session->flashdata('msgWelcome');
if(!empty($msgSuccessFD)) {
    $msgSuccess = $msgSuccessFD;
}
if(!empty($msgErrorFD)) {
    $msgError = $msgErrorFD;
}
if(!empty($msgWelcomeFD)) {
    $msgWelcome = $msgWelcomeFD;
}
?>
<div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgSuccess"><?= $msgSuccess ?></strong>
</div>
<div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgError"><?= $msgError ?></strong>
</div>
<div id="divMsgWelcome" class="<?php echo (strlen($msgWelcome) > 0) ? '' : 'hidden'; ?>">
	<div class="row">
		<div class="col-md-12">
	    	<h3 id="msgWelcome"><?= $msgWelcome ?></h3>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-12">&nbsp;</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>Por favor seleccione una opción del menú izquierdo superior.</p>
    </div>
</div>