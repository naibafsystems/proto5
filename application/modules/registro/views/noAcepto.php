<div class="row">
    <div class="col-md-12 text-center section-title">
        <h1 class="title-ecenso"> Crear mi cuenta / <span class="opensans"> No acepto</span></h1>
    </div>
</div>
<div class="container-fluid separador"></div>
<div class="row">
    <div class="col-md-12 alimneacionvertical">&nbsp;</div>
</div>
<div class="row">
<div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
    <div class="embed-responsive embed-responsive-16by9">
        <iframe src="<?=$URLVideo?>" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
    </div>
</div>
<div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
    <form id="frmNoAcepto" name="frmNoAcepto" class="form-horizontal" role="form" method="post" action="">
        <div class="row">
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <label>Apreciado ciudadano(a), para nosotros es muy importante conocer la raz&oacute;n por la que no desea participar
                        de este gran proyecto para el pa&iacute;s.</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <div class="radio">
                        <label><input type="radio" id="razon1" name="razon" value="1" /> Los t&eacute;rminos y condiciones son confusos y demasiado largos</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" id="razon2" name="razon" value="2" /> No est&aacute;s interesado(a)</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" id="razon3" name="razon" value="3" /> No tienes tiempo</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" id="razon4" name="razon" value="4" /> No conf&iacute;as en este medio para entregar informaci&oacute;n personal</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" id="razon5" name="razon" value="5" /> Otra, &iquest;cu&aacute;l?</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <div class="input-text">
                        <!-- <label id="contadorTaComentario">0/2000</label> -->
                        <textarea name="observacion" id="observacion" rows="3" cols="60" class="form-control" maxlength="2000" disabled></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="button" id="btnRegresar" name="btnRegresar" class="btn btn-back"><span class="glyphicon glyphicon-chevron-left"
                aria-hidden="true"></span> Regresar</button>
                <button type="button" id="btnNoAcepto" name="btnNoAcepto" class="btn btn-dane-success">Guardar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
            </div>
        </div>
    </form>
</div>