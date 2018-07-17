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

<div class="row text-center">
    <div class="col-md-12">
        <h3><label class="titulos">eCenso Offline</label></h3>
        <div class="container-fluid separador"></div>
    </div>
</div>
<!--
<div id="divMsgSuccess" class="alert alert-success" <?php echo (empty($msgSuccess)) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgSuccess"><?= $msgSuccess ?></strong>
</div>
<div id="divMsgAlert" class="alert alert-danger" <?php echo (empty($msgError)) ? 'style="display: none;"' : ''; ?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong id="msgError"><?= $msgError ?></strong>
</div>
-->

<div class="row <?php echo (strlen($msgSuccess) == 0 && strlen($msgError) == 0) ? 'hidden' : ''; ?>" id="divMsg">
    <div class="form-group">
        <div class="col-md-12">
            <div id="divMsgSuccess" class="alert alert-success <?php echo (strlen($msgSuccess) == 0) ? 'hidden' : ''; ?>">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgSuccess"><?= $msgSuccess ?></strong>
            </div>
            <div id="divMsgAlert" style="text-align: center;" class="alert alert-danger <?php echo (strlen($msgError) == 0) ? 'hidden' : ''; ?>">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgError"><?= $msgError ?></strong>
            </div>
        </div>
    </div>
</div>

<div class="row" style=""><!-- 
<div class="col-md-12">

<div class="">-->
    <div class="col-md-12 text-justify ">
        <p> 
            Si desea diligenciar la encuesta pero tiene problemas de conexión a Internet, puede descargar la aplicación del eCenso fuera de línea, la cual puede llevar e instalar en el computador de su casa, 
			y luego proceder a subir la información a este sistema. Debe seguir los siguientes pasos:					
		</p><br>	
		<p><span class="register-nummeral alineacionverticalnum">1</span>Descargue la aplicación del eCenso fuera de l&iacute;nea. Para esto haga clic  <a class="label-bold" href="#">AQU&Iacute;</a></p> 
		<p><span class="register-nummeral alineacionverticalnum">2</span><span class="label-bold">Lleve el archivo descargado a su computador,</span> ejecútelo e instálelo siguiendo los pasos del instalador (Debe tener sistema Operativo Windows y el usuario(a) deberá tener permisos de administrador).</p> 
		<p><span class="register-nummeral alineacionverticalnum">3</span>Una vez instalada la aplicación, <span class="label-bold">diligencie la encuesta.</span> Al finalizarla, se generará un archivo comprimido (.zip) que debe subir en este sistema por internet.</p> 
		<p><span class="register-nummeral alineacionverticalnum">4</span>Finalmente, deberá <span class="label-bold">acceder a un computador con conexión a Internet, para subir el archivo generado (.zip).</span> Para esto, haga clic en el siguiente enlace para que suba la información, finalice la encuesta, y obtenga el certificado de participación:</p>
		
		<span class="glyphicons glyphicons-circle-arrow-down"></span>
		<div class="panel-group">
		  <div class="panel-default">
			<div class="btn-back">
			  <h4 class="texto-enlace-collapse panel-title" style="text-align: center;">
				<a data-toggle="collapse" href="#collapse1">Cargue de Encuesta <span class="glyphicon glyphicon-download"></span> </a> <!--style="color: white;" -->
			  </h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse">
			  <div class="panel-body">
					<form id="frmCargar" name="frmCargar" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
					<div class="row" style="width: 80%;margin-left: 5em;">
						
						 <div class="row">
						<div id="tipo_documento-col" class="col-xs-12 col-sm-12 col-md-12  ">
							<div class="form-group">
							<label class="control-label"> Por favor digite los datos de identificación de la persona que carga el archivo:</strong>                                                                                            </label>
							</div>
						</div>
						<div id="tipo_documento-col" class="col-xs-12 col-sm-12 col-md-12  ">
						<fieldset>
							<div class="form-group">
							<label id="tipo_documento-lbl" class="control-label" for="tipo_documento"> Seleccione su tipo de documento de identidad                                                                                            </label>
							<div>
							<div class="select">
							<select id="tipo_documento" name="tipo_documento" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" aria-invalid="false">
								<option value="">Seleccione su tipo de documento</option>
								<option value="3">Cédula De Ciudadanía</option>
								<option value="4">Cédula De Extranjería</option>
								<option value="6">No Tiene Cédula</option>
							</select></div>
							</div>
							</div>
						</fieldset>
						</div>	
						</div>	
						
						<div class="row">
							<div id="tipo_documento2-col" class="col-xs-12 col-sm-12 col-md-12 hidden ">
							<fieldset>
								<div class="form-group">
								<label id="tipo_documento2-lbl" class="control-label" for="tipo_documento2"></label>
								<div>
									<div class='select'>
									<select id='tipo_documento2' name='tipo_documento2' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control'  >
									<option value=''>Seleccione su tipo de documento</option>
									<option value='5' >No Tiene Documento De Identidad</option>
									<option value='1' >Registro Civil De Nacimiento</option>
									<option value='2' >Tarjeta De Identidad</option>
									</select>
									</div>
								</div>
								</div>
							</fieldset>
							</div>
						</div>
						
						  <div class="row">
							<div id="numero_documento-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
										<label id="numero_documento-lbl" class="control-label" for="numero_documento"> Escriba el número de su documento de identidad </label>
										<div>
											<div class='input-text'>
											<input type='text' id='numero_documento' name='numero_documento' size='11' maxlength='11' placeholder='Seleccione su número de documento' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />
										</div>
										</div>
									</div>
								</fieldset>
							</div>
						</div>	
						<div class="row">
							<div id="primer_nombre-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
										<label id="primer_nombre-lbl" class="control-label" for="primer_nombre"> Primer nombre</label>
										<div>
										<div class='input-text'><input type='text' id='primer_nombre' name='primer_nombre' size='30' maxlength='30' placeholder='Primer nombre' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />
										</div>                               
										</div>
									</div>
								</fieldset>
							</div>
						</div>
                        <div class="row">
							<div id="segundo_nombre-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
										<label id="segundo_nombre-lbl" class="control-label" for="segundo_nombre"> Segundo nombre</label>
										<div>
										<div class='input-text'><input type='text' id='segundo_nombre' name='segundo_nombre' size='30' maxlength='30' placeholder='Segundo nombre' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />
										</div>                                
									</div>
									</div>
								</fieldset>
							</div>
						</div>
                       <div class="row">
							<div id="primer_apellido-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
										<label id="primer_apellido-lbl" class="control-label" for="primer_apellido"> Primer apellido</label>
										<div>
										<div class='input-text'><input type='text' id='primer_apellido' name='primer_apellido' size='30' maxlength='30' placeholder='Primer apellido' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />
										</div>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
                       <div class="row">
							<div id="segundo_apellido-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
										<label id="segundo_apellido-lbl" class="control-label" for="segundo_apellido"> Segundo apellido</label>
										<div>
										<div class='input-text'>
										<input type='text' id='segundo_apellido' name='segundo_apellido' size='30' maxlength='30' placeholder='Segundo apellido' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />
										</div>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
					
						 <div class="row">
							<div id="telefono_celular-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
										<label id="telefono_celular-lbl" class="control-label" for="telefono_celular">Teléfono celular</label>
										<div>
											<div class='input-text'>
											<input type='text' id='telefono_celular' name='telefono_celular' size='10' maxlength='10' placeholder='Ej. 3001234567' data-toggle='popover' data-trigger='focus hover' data-content='' class='form-control' />
										</div>
										</div>
									</div>
								</fieldset>
							</div>
						</div>	
						 <div class="row">
							<div id="correo_electronico-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
										<label id="correo_electronico-lbl" class="control-label" for="correo_electronico">Correo electr&oacute;nico</label>
										<div>
										<div class='input-text'><input id="correo_electronico" name="correo_electronico" size="50" maxlength="50" placeholder="Ej. usuario@ejemplo.com" data-toggle="popover" data-trigger="focus hover" data-content="" class="form-control" type="text">
										</div>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						
						<div class="row">
							<div id="tipo_documento-col" class="col-xs-12 col-sm-12 col-md-12  ">
								<fieldset>
									<div class="form-group">
									<label id="tipo_documento-lbl" class="control-label" for="tipo_documento" style="text-align: left;">Por favor seleccione el archivo comprimido(.zip) que se generó al finalizar el eCenso fuera de línea.</strong>                                                                                            </label>
									<br>
									<div>
										<?php /*<input name="cargaArchivo" id="cargaArchivo" type="file" class="form-control-file" data-show-preview="false" /> &nbsp;<a href="javascript:limpia_file();" >Limpiar</a> */ ?>
										<input name="cargaArchivo" id="cargaArchivo" type="file" class="file" />
									</div>
									<div id="msjArchivo" name="msjArchivo" class="error-form hidden"></div>
									</div>
								</fieldset>
							</div>	
						</div>	
						<br>
						<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12  ">
						<fieldset>
						<div class="form-group">
							<button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-dane-success">Guardar<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						</div>
						</fieldset>
						</div>
						</div>
					</div>
				</form>
			  
			  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <br />
        <p>Gracias por su participación en la construcción del Primer Censo Electrónico de Población y Vivienda del País. Con ello ha contribuido en la construcción de un país moderno e incluyente.</p>
    </div>
</div>

<div class="row">
</br></br>
    <div class="col-md-12 text-center">
         <button type="button" class="btn-default btn btn-back" id="btnRegresar" name="btnRegresar"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12 before-footer">&nbsp;</div>
</div>
