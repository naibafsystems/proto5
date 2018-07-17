<?php
$msgSuccessFD = $this->session->flashdata('msgSuccess');
$msgErrorFD = $this->session->flashdata('msgError');
if (!empty($msgSuccessFD)) {
    $msgSuccess = $msgSuccessFD;
}
if (!empty($msgErrorFD)) {
    $msgError = $msgErrorFD;
}
?>


<div class="row">
    <div class="support col-md-4">
        <div id="divVideo" class="hidden">
            <div class="embed-responsive embed-responsive-16by9 video-login">
                <iframe src="https://www.youtube.com/embed/xoPkWOKu6UU" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
            </div>
        </div>
        <!--Carrusel de fotos-->
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                <img class="img-carrusel-login" src="<?=base_url_images('REF1_CHICA1.jpg') ?>" alt="imagen promocional: Tan sencillo como el eCenso">
                </div>
            </div>
        </div>
        <!--Termina carrusel-->
    </div>
    <div class="col-md-7">
        <section id="login" class="login">
            <div class="row mobile-login-fields-container">
                <div class="col-md-5 sin_cuenta" id="sin_cuenta">
                    <button type="button" id="btnRegistrar" name="btnRegistrar" class="btn btn-default btn-register" ><p class="create-my-account-button-text">CREE SU CUENTA</p></button></br>
                    <!-- <a href="#" id="btnConocer"><p class="font-size-14-pt">Saber más sobre el Censo</p></a> -->
                    <a href="https://censo2018.dane.gov.co/" target="_blank" id="btnConocer"><p class="font-size-14-pt">Saber más sobre el Censo</p></a>
                    <div id="privacidad">
                        <h4><p class="font-roboto-slab">Todos los datos están protegidos</p></h4>
                        <a href="#" id="btnLey"><p class="font-size-14-pt">Ver Ley de Reserva Estadística</p></a>
                        <a href="#" id="btnTC"><p class="font-size-14-pt">Ver Términos y condiciones</p></a>
                        <p></p><p><br></p>
                        <p>Para la correcta visualización del eCenso, recomendamos usar navegadores con estándares web como Chrome o Firefox.</p>
                    </div>
                </div>
                <div class="col-md-7 col-sm-12" id="con_cuenta">
                    <h3 id="has-account-title" class="font-roboto-slab">Si ya tiene una cuenta ingrese aquí</h3>
                    <form id="frmIngreso" name="frmIngreso" class="form-signin" method="post">
                        <input type="hidden" id="<?=$csrf['name']?>" name="<?=$csrf['name']?>" value="<?=$csrf['hash']?>" />
                        <div class="form-group">
                            <label for="email">Escriba su correo electrónico</label>
                            <input type="email" class="form-control" id="usuario" name="usuario" placeholder="Correo electrónico" aria-required="true">
                        <!--<p>@</p>
                        <input type="email" class="form-control" id="compemail" placeholder="correo.com">-->
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Escriba su contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" onkeypress="login(event)">
                        </div>

                        <div id='html_element'></div><br>

                        <button type="button" id="btnIngresar" name="btnIngresar" class="btn btn-default btn-ingresar" data-loading-text="Ingresar <span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span>">INGRESAR</button>
                        <div id="ingreso">
                            <a href="#" id="btnRecordar" class="font-size-14-pt">¿Olvidó su contraseña?</a>
                        </div>
                    </form>
                    <br /><br><br><br>
                    <div id="divMsgSuccess" class="alert alert-success <?=(strlen($msgSuccess) == 0) ? "hidden" : ""; ?>">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong id="msgSuccess"><?= $msgSuccess ?></strong>
                    </div>
                    <div id="divMsgAlert" tabindex="-1" role="alert" class="alert alert-danger <?=(strlen($msgError) == 0) ? "hidden" : ""; ?>">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong id="msgError"><?= $msgError ?></strong>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>