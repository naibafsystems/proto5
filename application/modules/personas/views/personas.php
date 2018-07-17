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
<p>Seleccione cada uno de los intregrantes de su hogar para diligenciar su información.</p>
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
    <div class="col-md-12">&nbsp;</div>
</div>
<form id="frmPersona" name="frmPersona" role="form" method="post">
    <?php foreach ($personas as $kp => $vp) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <?php if($vp['completo'] == 'SI') {?>
                        <button type="button" name="completar-<?=$kp?>" data-numepers="<?=$kp?>" class="btn btn-completed completar-pers"><?=$vp['nombre']?> <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> </button>
                    <?php } else if($vp['completo'] == 'NO') { ?>
                        <button type="button" name="completar-<?=$kp?>" data-numepers="<?=$kp?>" class="btn btn-dane-success completar-pers"><?=$vp['nombre']?> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</form>



<?php 
/*
  $bandera = 0;
  $si = 0;
  for($i=1;$i<=count($personas);$i++){
      if($personas[$i]['completo'] == 'SI'){
        $si++;
      }
  }
  
  if($si == count($personas)){*/
    ?>    
    <form id="frmPersona" name="frmPersona" role="form" method="post">
    <a type="button" href="<?php echo base_url('personas/resultadoEntrevista/')?>" class="btn btn-dane-success">Resultado de la entrevista<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </a> 
    </form>
    <?php
  //}

?>