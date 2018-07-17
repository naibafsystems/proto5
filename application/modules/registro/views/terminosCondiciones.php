<div class="row">
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe src="https://www.youtube.com/embed/HQEo0OF1rNc" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
        </div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <div class="col-md-12 text-center section-title">
                <h1 class="title-ecenso"> Términos y Condiciones</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-justify alineacionverticaltexto">
                <p>
                    En cumplimiento de lo consagrado en el artículo 5&deg; de la Ley 79 de 1993, toda persona natural o jurídica con domicilio o residencia en el territorio nacional está obligada a suministrar al Departamento Administrativo Nacional de Estadística DANE, los datos solicitados en el desarrollo de Censos y Encuestas.
                </p>
                <p>
                    En consecuencia los datos y la información que se proporcione en el eCenso, debe ser completa, verídica, comprobable, exacta, actualizada y comprensible y debe ser suministrada por un mayor de edad.
                </p>
                <p>
                    Para su tranquilidad y por su seguridad, los datos suministrados al DANE, en desarrollo de los censos y/o encuestas, de conformidad con lo establecido en el parágrafo segundo del artículo 5&deg; de la Ley 79 de 1993, tienen carácter de reservados y no podrán ser utilizados con fines comerciales, de tributación fiscal o de investigación judicial; sólo podrán darse a conocer al público en resúmenes numéricos que no hagan posible deducir de ellos información alguna de carácter individual.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
</div>
<div class="row <?php echo (strlen($msgSuccess) == 0 || strlen($msgError) == 0) ? 'hidden' : ''; ?>" id="divMsg">
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12">
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
    <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="button" id="btnAnterior" name="btnAnterior" class="btn btn-back"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Anterior</button>
        <button type="button" id="btnNoAcepto" name="btnNoAcepto" class="btn btn-warning"/>No acepto</button>
        <button type="button" id="btnAcepto" name="btnAcepto" class="btn btn-dane-success">Acepto <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
    </div>
</div>