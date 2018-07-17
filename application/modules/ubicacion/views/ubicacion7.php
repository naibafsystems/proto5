<div class="row" id="divContent">
    <div id="divVideo" class="col-xs-12 col-sm-12 col-md-6 hidden">
        <div class="embed-responsive embed-responsive-16by9">
            <?php if(!empty($URLVideo)) { ?>
                <iframe src="<?=$URLVideo?>?rel=0&fs=0&showinfo=0&modestbranding=1" class="youtube-video" frameborder="0" scrolling="no" height="100%" width="100%" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div>
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmUbicacion" name="frmUbicacion" role="form" method="post">
          
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Área de coordinación operativa</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-text">
                            <input id="U_CO" name="U_CO" size="40" maxlength="100" placeholder="Área de coordinación operativa" value="<?= $U_CO; ?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                        </div>
                    </div>
                </div>
           
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Área operativa</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-text">
                            <input id="U_AO" name="U_AO" size="40" maxlength="100" placeholder="Área operativa" value="<?= $U_AO; ?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                     <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Unidad de cobertura</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-text">
                            <input id="U_UC" name="U_UC" size="40" maxlength="100" placeholder="Unidad de cobertura" value="<?= $U_UC; ?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Número de orden de la edificación en la unidad de cobertura</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-text">
                            <input id="U_EDIFICA" name="U_EDIFICA" size="40" maxlength="100" placeholder="Número de la orden de la edificación" value="<?= $U_EDIFICA; ?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php if($tipo_ubicacion != 3){ ?>
                            <label class="control-label">Diligencie la dirección de la vivienda en la que reside habitualmente. (Utilice los botones como ayuda para su construcción)</label>
                        <?php }else{?>
                            <label class="control-label">Diligencie la dirección de la vivienda en la que reside habitualmente</label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>

            <?php if($tipo_ubicacion != 3){ ?>

                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-md-3">
                        <div class="form-group">
                            <select name="tipo_via" id="tipo_via" class="form-control" autocomplete="off">
                                <option value="">Ej.: Calle</option>
                                <?php
                                foreach ($arrTiposVia as $data):
                                    $tag = ($data['ID_VALOR'] == $tipo_via) ? 'selected' : '';
                                    echo "<option value='" . $data['ID_VALOR'] . "' " . $tag . ">" . $data['ETIQUETA'] . "</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3">
                        <div class="form-group">
                            <div class="input-text">
                                <input id="numero_via" name="numero_via" size="20" maxlength="20" placeholder="Ej.: 26" value="<?=$numero_via?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3">
                        <div class="form-group">
                        	<div class="input-group">
                        		<span class="input-group-addon input-group-symbol">&#35;</span>
                        		<input id="numero_via2" name="numero_via2" size="20" maxlength="20" placeholder="Ej.: 22C" value="<?=$numero_via2?>"" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
    						</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3">
                        <div class="form-group">
                        	<div class="input-group">
                        		<span class="input-group-addon input-group-symbol">-</span>
                        		<input id="numero_placa" name="numero_placa" size="100" maxlength="100" placeholder="Ej.: 45" value="<?=$numero_placa?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
    						</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Desea agregar otros elementos a la dirección de la vivienda:&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="material_pared-ayuda" data-tooltip="Manzana (MZ), Unidad(UN), Apartamento (AP), Bloque (BL), Interior (IN), Conjunto (CJ), Edificio (ED), Urbanización (URB), Supermanzana (SM), Etapa (ET)" aria-describedby="qtip-86" aria-hidden="true" data-hasqtip="86"></span><div id="acc_ayuda_complementos" class="acc-offscreen">Manzana (MZ), Unidad(UN), Apartamento (AP), Bloque (BL), Interior (IN), Conjunto (CJ), Edificio (ED), Urbanización (URB), Supermanzana (SM), Etapa (ET)</div></label>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="input-text">
                            <input id="complementos" name="complementos" size="40" maxlength="100" placeholder="Ej.: Manzana 2 Casa 10" value="<?=$complementos?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <label class="control-label">Uso de la unidad</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA_USO_UNIDAD" id="unidad1" value="1" <?= ($UVA_USO_UNIDAD==1)?'checked':''; ?>>
                            <label class="form-check-label" for="unidad1">
                                Vivienda
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA_USO_UNIDAD" id="unidad2" value="2" <?= ($UVA_USO_UNIDAD==2)?'checked':''; ?>>
                            <label class="form-check-label" for="unidad2">
                                Mixto
                            </label>       

                            <div class="form-group" style="margin: 20px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="UVA1_COD_OTROUSO" id="unidad2_industria" value="1" <?= ($UVA1_COD_OTROUSO==1)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad2_industria">
                                        Industria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="UVA1_COD_OTROUSO" id="unidad2_comercio" value="2" <?= ($UVA1_COD_OTROUSO==2)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad2_comercio">
                                        Comercio
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="UVA1_COD_OTROUSO" id="unidad2_servicios" value="3" <?= ($UVA1_COD_OTROUSO==3)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad2_servicios">
                                        Servicios
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="UVA1_COD_OTROUSO" id="unidad2_agropecuario" value="4" <?= ($UVA1_COD_OTROUSO==4)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad2_agropecuario">
                                        Agropecuario, agroindustrial, forestal
                                    </label>
                                </div>
                            </div>
        
                         </div>
                
                        <div class="form-check disabled">
                            <input class="radio" type="radio" name="UVA_USO_UNIDAD" id="unidad3" value="3" <?= ($UVA_USO_UNIDAD==3)?'checked':''; ?>>
                            <label class="form-check-label" for="unidad3">
                                Unidad no residencial
                            </label>

                            <div class="form-group" style="margin: 20px;">

                                <div class="form-check">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_industria" value="1" <?= ($UVA2_UNDNORESI==1)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_industria">
                                        Industria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_comercio" value="2" <?= ($UVA2_UNDNORESI==2)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_comercio">
                                        Comercio
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_servicios" value="3" <?= ($UVA2_UNDNORESI==3)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_servicios">
                                        Servicios
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_agropecuario" value="4" <?= ($UVA2_UNDNORESI==4)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_agropecuario">
                                        Agropecuario, agroindustrial, forestal
                                    </label>
                                </div>

                                <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_institucional" value="5" <?= ($UVA2_UNDNORESI==5)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_institucional">
                                        Institucional
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_lote" value="6" <?= ($UVA2_UNDNORESI==6)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_lote">
                                        Lote (Unidad sin construcción)   
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_parque" value="7" <?= ($UVA2_UNDNORESI==7)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_parque">
                                        Parque o zona verde
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_minero" value="8" <?= ($UVA2_UNDNORESI==8)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_minero">
                                        Minero - energético
                                    </label>
                                </div>
                                 <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_proteccion" value="9" <?= ($UVA2_UNDNORESI==9)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_proteccion">
                                        Protección o conservación ambiental
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="radio" type="radio" name="UVA2_UNDNORESI" id="unidad3_construccion" value="10" <?= ($UVA2_UNDNORESI==10)?'checked':''; ?>>
                                    <label class="form-check-label" for="unidad3_construccion">
                                        En construcción
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>
                       
                </div>

            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Número de orden de la vivienda en la edificación</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-text">
                            <input id="U_VIVIENDA" name="U_VIVIENDA" size="40" maxlength="100" placeholder="Número orden vivienda" value="<?= $U_VIVIENDA; ?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                        </div>
                    </div>
                </div>
           
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">¿usted o algún miembro de este hogar diligenció recientemente el cuestionario del Censo Nacional de Población y vivienda 2018, por internet (el eCenso)?</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin: 20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA_ECENSO" id="diligencio_si" value="1" <?= ($UVA_ECENSO==1)?'checked':''; ?>>
                            <label class="form-check-label" for="diligencio_si">
                                Si
                            </label>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label class="control-label">¿Cuál es el número del documento de identidad del jefe(a) de hogar?</label>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                <div class="input-text">
                                    <input id="UVA_COMPLEUND_JSON" name="UVA_COMPLEUND_JSON" size="40" maxlength="100" placeholder="Número de documento" value="<?= $UVA_COMPLEUND_JSON; ?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA_ECENSO" id="diligencio_no" value="2" <?= ($UVA_ECENSO==2)?'checked':''; ?>>
                            <label class="form-check-label" for="diligencio_no">
                                No
                            </label>
                        </div>
                        <div class="form-check disabled">
                            <input class="form-check-input" type="radio" name="UVA_ECENSO" id="diligencio_nosabe" value="3" <?= ($UVA_ECENSO==3)?'checked':''; ?>>
                            <label class="form-check-label" for="diligencio_nosabe">
                                No sabe
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">¿Este hogar cambió de lugar de residensia entre en el eCenso y el día de hoy?</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin: 20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="H_CAMBIO_DIR" id="cambiores_si" value="1" <?= ($H_CAMBIO_DIR==1)?'checked':''; ?>>
                            <label class="form-check-label" for="cambiores_si">
                                Si
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="H_CAMBIO_DIR" id="cambiores_no" value="2" <?= ($H_CAMBIO_DIR==2)?'checked':''; ?>>
                            <label class="form-check-label" for="cambiores_no">
                                No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Teniendo en cuenta que hogar censal se refiere a "una persona o grupo de personas, parientes o no, que ocupan la totalidad o parte de una vivienda; atienden necesidades básicas con cargo a un presupuesto común y generalmente comparten las comidas" ¿Dígame si hay más hogares en esta vivienda?</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin: 20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA1_MASHOG" id="mashog_si" value="1" <?= ($UVA1_MASHOG==1)?'checked':''; ?>>
                            <label class="form-check-label" for="mashog_si">
                                Sí hay más hogares
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA1_MASHOG" id="mashog_no" value="2" <?= ($UVA1_MASHOG==2)?'checked':''; ?>>
                            <label class="form-check-label" for="mashog_no">
                                No hay más hogares, y este hogar Sí cambió de residencia
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA1_MASHOG" id="mashog_nore" value="3" <?= ($UVA1_MASHOG==3)?'checked':''; ?>>
                            <label class="form-check-label" for="mashog_nore">
                                No hay más hogares, y este hogar No cambió de residencia
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">¿usted o algún miembro de este hogar, en este año, ha sido entrevistado por un censista del DANE en su vivienda para responder el Censo Nacional de Población y Vivienda 2018?</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin: 20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA_ECENSO6" id="entrevistado_si" value="1" <?= ($UVA_ECENSO6==1)?'checked':''; ?>>
                            <label class="form-check-label" for="entrevistado_si">
                                Si
                            </label>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label class="control-label">¿Cuál es el número del certificado censal que le entregaron?</label>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                <div class="input-text">
                                    <input id="H_CERT_CENSAL" name="H_CERT_CENSAL" size="40" maxlength="100" placeholder="Número del certificado censal" value="<?= $H_CERT_CENSAL; ?>" data-toggle="popover" data-trigger="focus hover" class="form-control" type="text" />
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA_ECENSO6" id="entrevistado_no" value="2" <?= ($UVA_ECENSO6==2)?'checked':''; ?>>
                            <label class="form-check-label" for="entrevistado_no">
                                No
                            </label>
                        </div>
                        <div class="form-check disabled">
                            <input class="form-check-input" type="radio" name="UVA_ECENSO6" id="entrevistado_nosabe" value="3" <?= ($UVA_ECENSO6==3)?'checked':''; ?>>
                            <label class="form-check-label" for="entrevistado_nosabe">
                                No sabe
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="control-label">Teniendo en cuenta que hogar censal se refiere a "una persona o grupo de personas, parientes o no, que ocupan la totalidad o parte de una vivienda; atienden necesidades básicas con cargo a un presupuesto común y generalmente comparten las comidas" ¿Dígame si hay más hogares en esta vivienda?</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin: 20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA1_MASHOG6" id="mashog_si" value="1" <?= ($UVA1_MASHOG6==1)?'checked':''; ?>>
                            <label class="form-check-label" for="mashog_si">
                                Sí
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="UVA1_MASHOG6" id="mashog_no" value="2" <?= ($UVA1_MASHOG6==2)?'checked':''; ?>>
                            <label class="form-check-label" for="mashog_no">
                                No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php if($mostrarAnterior == 'SI') { ?>
                            <button type="button" id="btnAnterior" name="btnAnterior" class="btn btn-back"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Anterior</button>
                        <?php } ?>
                        <button type="button" id="btnSiguiente" name="btnSiguiente" class="btn btn-dane-success">Guardar y continuar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
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
        </form>
    </div>
</div>
<?php if(!empty($mensajeConfirmacion)) {?>
<div id="mensajeConfirmacion" class="hidden">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p><?=$mensajeConfirmacion?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <div class="row <?php echo (strlen($msgSuccess) == 0 || strlen($msgError) == 0) ? 'hidden' : ''; ?>" id="divMsgConfirm">
        <div class="form-group">
            <div class="col-md-12">
                <div id="divMsgSuccessConfirm" class="alert alert-success <?php echo (strlen($msgSuccess) == 0) ? 'hidden' : ''; ?>">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong id="msgSuccessConfirm"><?= $msgSuccess ?></strong>
                </div>
                <div id="divMsgAlertConfirm" class="alert alert-danger <?php echo (strlen($msgError) == 0) ? 'hidden' : ''; ?>">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong id="msgErrorConfirm"><?= $msgError ?></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="button" id="btnAnteriorConfirmacion" class="btn btn-back"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Anterior</button>
            <button type="button" id="btnSiguienteConfirmacion" class="btn btn-dane-success">Guardar y continuar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
        </div>
    </div>
</div>
<?php } ?>