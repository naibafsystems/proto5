<form id="frmRegistro" name="frmRegistro" role="form" method="post">
    <div class="row">
       <div class="col-xs-12 col-sm-6 col-md-6 row-eq-height">

            <div id="register-explanation-container"  class="row lineaseparadora">
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <h3 class="titles-register2" id="create-myAccount-title">Cree su cuenta</h3>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h3 id="has-doubts-title" class="titles-explanation-register">¿Cómo eCensarse?</h3>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p class="subtitle-register-video">Consulte nuestro video explicativo</p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="https://www.youtube.com/embed/1NC3jmS23JA" frameborder="0" width="100%" ></iframe>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <br>
                    <p><b>Para crear su cuenta: </b></p>
                    <p><span class="register-nummeral alineacionverticalnum">1</span> Ingrese sus <label class="label-bold">datos personales</label>. (Tenga a la mano su documento de identidad)</p>
                    <p><span class="register-nummeral alineacionverticalnum">2</span> Cree su <label class="label-bold">usuario y contraseña</label>.</p>
                    <p><span class="register-nummeral alineacionverticalnum">3</span> Guarde   <label class="label-bold">sus datos.</label></p>
                    <p><button type="button" id="btnEmpezar" name="btnEmpezar" class="btn btn-dane-success">Empezar</button></p>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 row-eq-height">
            <div class="row alineacionvertical">

                <div class="col-xs-12 col-sm-12 col-md-12 register-nummeral-container">
                <p class="alineacionverticaltexto" align="justify"><h3 id="has-doubts-title" class="titles-explanation-register">Tenga en cuenta que:</h3></p>
                <p class="alineacionverticaltexto" align="justify"><li>El eCenso <b>debe ser diligenciado por un mayor de edad</b> que conozca y <b>tenga a la mano toda la información</b> sobre los miembros del hogar y su vivienda.</li>
                <p class="alineacionverticaltexto" align="justify"><li>La información que registre debe ser <b>ver&iacute;dica, exacta, actualizada, comprensible y completa.</b></li>
                <p class="alineacionverticaltexto" align="justify"><li><b>El tiempo promedio de diligenciamiento del eCenso es de 25 minutos,</b> pero siempre depender&aacute; del tama&ntilde;o del hogar, es decir, de cu&aacute;ntas personas lo                                                               conformen. <b>Lo invitamos a diligenciarlo en una sola sesi&oacute;n.</b></li>
                <p class="alineacionverticaltexto" align="justify"><li>Al lado derecho de la pantalla encontrar&aacute; el <b>men&uacute; de configuraci&oacute;n</b> en el que podr&aacute; hacer uso de <b>herramientas de accesibilidad</b> en caso de <b>dificultad                                                          auditiva y visual.</b></li>
                <p class="alineacionverticaltexto" align="justify"><li>El eCenso cuenta con la <b>funcionalidad de autoguardado</b> que le permitir&aacute; cerrar la sesi&oacute;n y retomarla m&aacute;s adelante en el punto en donde la dej&oacute;.</li>
                <p class="alineacionverticaltexto" align="justify"><li>El eCenso solo se dar&aacute; por finalizado en el momento en que usted acepte terminarlo y reciba la <b>constancia de diligenciamiento de su hogar,</b> con el respectivo <b>c&oacute;digo                                                        de diligenciamiento.</b></li>
                <p class="alineacionverticaltexto" align="justify"><li>Durante el proceso de diligenciamiento contar&aacute; con los siguientes <b>canales de atenci&oacute;n:</b> Chat, l&iacute;nea telef&oacute;nica en Bogot&aacute;: (571) 597 8300, L&iacute;nea gratuita nacional: 01 8000 912002 en el horario: de 6:00 a.m. a 10:00 p.m. y correo electr&oacute;nico: ecenso@dane.gov.co.</li>
                <p class="alineacionverticaltexto" align="justify"><li>El eCenso solo estar&aacute; disponible <b>a partir del 9 de enero y hasta el 8 de marzo de 2018.</b></li>
                </br>


            </div>
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
</form>