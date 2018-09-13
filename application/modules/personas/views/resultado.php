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
<p>RESULTADO DE LA ENTREVISTA POR HOGAR.</p>
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
<form class="form" name="form_entrevista2" id="form_entrevista2" method="POST" action="<?php echo base_url('personas/guardarEntrevista') ?>">
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
          <div class="form-label">Visita N&uacute;mero:</div>
          <select id="numero_visita" name="numero_visita" class="form-control">
            <option value="">Seleccione...</option>
            <option value="1" <?php if( $respuestas[0]["CC_NRO_VIS"]==1 ) { ?>selected="selected"<?php }?> >1</option>
            <option value="2" <?php if( $respuestas[0]["CC_NRO_VIS"]==2 ) { ?>selected="selected"<?php }?> >2</option>
            <option value="3" <?php if( $respuestas[0]["CC_NRO_VIS"]==3 ) { ?>selected="selected"<?php }?> >3</option>
          </select>
      </div>
  </div>
</div>
<div id="div_form_visita" class="row">
	<div class="form-group">
		<div class="form-label">Fecha:</div>
		<div class="form-inline">
			D&iacute;a: <input type="text" class="form-control" name="dia" id="dia" placeholder="D&iacute;a">
			Mes: <input type="text" class="form-control" name="mes" id="mes" placeholder="Mes">
			A&ntilde;o: <input type="text" class="form-control" name="anio" id="anio"  placeholder="A&ntilde;o">
		</div>		
	</div>
	<div class="form-group">
		<div class="form-label">Hora (Fin de la entrevista):</div>
		<div class="form-inline">
			Hora: <input type="text" class="form-control" name="hora" id="hora" placeholder="Hora Militar">
			Minutos: <input type="text" class="form-control" name="minutos" id="minutos" placeholder="Minutos">
		</div>		
	</div>
	<div class="form-group">
		<div class="form-label">Resultado de la entrevista:</div>
			<select id="resultado_entrevista" name="resultado_entrevista" class="form-control">
			<option value="">Seleccione...</option>
			<option value="1" <?php if( $respuestas[0]["CC_RES_ENC"]==1 ) { ?>selected="selected"<?php }?> >Completa</option>
			<option value="2" <?php if( $respuestas[0]["CC_RES_ENC"]==2 ) { ?>selected="selected"<?php }?> >Incompleta</option>
			<option value="3" <?php if( $respuestas[0]["CC_RES_ENC"]==3 ) { ?>selected="selected"<?php }?> >Rechazo</option>
			<option value="9" <?php if( $respuestas[0]["CC_RES_ENC"]==9 ) { ?>selected="selected"<?php }?> >Sin Información</option>
			</select>
	</div>
	<div class="form-group">
		<div class="form-label">N&uacute;mero del certificado censal expedido:</div>
		<div class="form-inline">
			<input type="text" class="form-control" name="nume_certificado" id="nume_certificado" placeholder="N&uacute;mero del certificado" value="<?php echo $respuestas[0]["H_CERT_CENSAL"]; ?>">
		</div>		
	</div>
	<div class="form-group">
		<div class="form-label">C&oacute;digo del censista:</div>
		<div class="form-inline">
			<input type="text" class="form-control" name="cod_censita" id="cod_censita" maxlength="13" placeholder="C&oacute;digo" value="<?php echo $respuestas[0]["CC_COD_RECO"]; ?>">
		</div>		
	</div>
	<div class="form-group">
		<div class="form-label">C&oacute;digo del supervisor:</div>
		<div class="form-inline">
			<input type="text" class="form-control" name="cod_supervisor" id="cod_supervisor" maxlength="9" placeholder="C&oacute;digo" value="<?php echo $respuestas[0]["CC_COD_SUPE"]; ?>">
		</div>		
	</div>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
	<button type="submit" class="btn btn-success">Guardar</button>
</div>
</form>