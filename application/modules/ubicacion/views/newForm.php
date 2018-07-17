<div class="row">
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmUbicacionN" name="frmUbicacionN" role="form" method="post" action="<?php echo base_url('ubicacion/guardarUbicacion') ?>">
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1>UBICACI&Oacute;N</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>1. Departamento y municipio o &aacute;rea no municipalizada</b></h4>
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <label>Nombre del departamento</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <input type="text" name="ub1_nombre_depto" id="ub1_nombre_depto">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <label>C&oacute;digo</label>
                        <input type="number" name="ub1_codigo_depto" id="ub1_codigo_depto" size="10">
                    </div>
                    
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <label>Nombre del  municipio o &aacute;rea no municipalizada</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <input type="text" name="ub1_nombre_mun" id="ub1_nombre_mun">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <label>C&oacute;digo </label>
                        <input type="number" name="ub1_codigo_mun" id="ub1_codigo_mun" size="10">
                    </div>                    
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>2. Clase</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub2_clase" value="1">
                            <label for="1">Cabecera municipal (Clase 1)</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-7 col-sm-7 col-md-7">                        
                                    <label>Nombre de la localidad o comuna</label>
                                    <input type="text" name="ub2_nombre_clase" id="ub2_nombre_clase">                      
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">                        
                                    <label>C&oacute;digo</label>
                                    <input type="number" name="ub2_codigo_clase_localidad" id="ub2_codigo_clase_localidad" size="10">                      
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub2_clase" value="2">
                            <label for="2">Centro poblado (Clase 2)</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-7 col-sm-7 col-md-7">                        
                                    <label>Nombre de centro poblado</label>
                                    <input type="text" name="ub2_nombre_clase" id="ub2_nombre_clase">                      
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">                        
                                    <label>C&oacute;digo</label>
                                    <input type="number" name="ub2_codigo_clase_centro_poblado" id="ub2_codigo_clase_centro_poblado" size="10">                      
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub2_clase" value="3">
                            <label for="3">Rural disperso (Clase 3)</label>
                        </div>
                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>3. Territorios &eacute;tnicos</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub3_territorio" value="1">
                            <label for="1">S&iacute;</label>
                            <div class="form-group">
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <input type="radio" name="ub3_tipo_territorio" value="1">
                                <label for="1">Resguardo ind&iacute;gena</label>
                                <fieldset>
                                    <div class="col-xs-8 col-sm-8 col-md-8">                        
                                        <label>Nombre del resguardo ind&iacute;gena</label>
                                        <input type="text" name="ub3_nombre_tipo_territorio" id="nombreClase">            
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                                        <label>C&oacute;digo</label>
                                        <input type="number" name="ub3_codigo_tipo_territorio" id="codigo_tipo_territorio" size="10">                      
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                                <input type="radio" name="ub3_tipo_territorio" value="2">
                                <label for="2">Territorio colectivo de comunidad negra</label>
                                <fieldset>
                                    <div class="col-xs-8 col-sm-8 col-md-8">                        
                                        <label>Nombre del territorio colectivo</label> 
                                        <input type="text" name="ub3_nombre_tipo_territorio" id="nombreClase">                      
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                                        <label>C&oacute;digo</label>
                                        <input type="number" name="ub3_codigo_tipo_territorio" id="codigo_tipo_territorio" size="10">                      
                                    </div>
                                </fieldset>
                            </div>
                            </fieldset>
                        </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub3_territorio" value="2">
                            <label for="1">No</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>4. &Aacute;rea protegida</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub4_area_protegida" value="1">
                            <label for="1">Si</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-7 col-sm-7 col-md-7">                        
                                    <label>Nombre del &aacute;rea protegida</label>
                                    <input type="text" name="ub4_nombre_area_protegida" id="ub4_nombre_area_protegida">                      
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">                        
                                    <label>C&oacute;digo</label>
                                    <input type="number" name="ub4_codigo_area_protegida" id="ub4_codigo_area_protegida" size="10">                      
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub4_area_protegida" value="2">
                            <label for="2">No</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>5. &Aacute;rea de coordinaci&oacute;n operativa y &aacute;rea operativa</b></h4>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <label>&Aacute;rea de coordinaci&oacute;n operativa</label>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <input type="text" name="ub5_area_coordinacion_operativa" id="ub5_area_coordinacion_operativa">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <label>&Aacute;rea operativa</label>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <input type="text" name="ub5_area_operativa" id="ub5_area_operativa">
                        <h6>(En el caso de las rutas operativas el c&oacute;digo de &aacute;rea operativa corresponde al c&oacute;digo de la ruta)</h6> 
                    </div>                                       
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>6. Unidad de cobertura</b></h4>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <label>Urbana (Solo para clases 1 o 2)</label>
                        <label>C&oacute;digo</label>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <input type="number" name="ub6_codigo_unidad_cobertura" id="ub6_codigo_unidad_cobertura_urbana">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <label>Rural (Solo para clase 3)</label>
                        <label>C&oacute;digo</label>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <input type="number" name="ub6_codigo_unidad_cobertura" id="ub6_codigo_unidad_cobertura_rural"> 
                    </div>                                       
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>7. N&uacute;mero de orden de la edificaci&oacute;n en la unidad de cobertura</b></h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">                        
                        <input type="number" name="ub7_numero_edificacion" id="ub7_numero_edificacion">
                    </div>                                      
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>8. Direcci&oacute;n</b></h4>
                    <div class="col-xs-3 col-sm-3 col-md-3">                        
                        <input type="text" name="ub8_direccion" id="ub8_direccion" size="90">
                    </div>  
                    <div class="col-xs-12 col-sm-12 col-md-12">                        
                        <label>Seleccione la opci&oacute;n</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="ub8_opcion" value="1">
                        <label for="1">Barrio</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="ub8_opcion" value="2">
                        <label for="2">Corregimiento</label>
                    </div>  
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="ub8_opcion" value="3">
                        <label for="3">Vereda</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="ub8_opcion" value="4">
                        <label for="4">Rancher&iacute;a</label>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="ub8_opcion" value="5">
                        <label for="5">Comunidad</label>
                    </div>                     
                </div>                                   
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>9. Uso de la unidad (Espacio independiente y separado)</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub9_unidad" value="1">
                            <label for="1">Vivienda</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub9_unidad" value="2">
                            <label for="2">Mixto</label>
                        
                            <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-md-1">                        
                            </div>
                                <fieldset>
                                    <div class="col-xs-12 col-sm-12 col-md-12">                        
                            
            	                    	<label>Marque el uso no residencial que predomina en la unidad mixta:</label>
            	                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                                        <input type="radio" name="ub9_opc_mixta" value="1">
                                        <label for="1">Industria</label>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                                        <input type="radio" name="ub9_opc_mixta" value="2">
                                        <label for="2">Comercio</label>
                                    </div>  
                                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                                        <input type="radio" name="ub9_opc_mixta" value="3">
                                        <label for="3">Servicios</label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                                        <input type="radio" name="ub9_opc_mixta" value="4">
                                        <label for="4">Agropecuario, agroindustrial, forestal</label>
                                    </div> 
                                </fieldset>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub9_unidad" value="3">
                            <label for="3">Unidad no residencial</label>
                            
                            <div class="form-group">
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <fieldset>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <label>Seleccione:</label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                                        <input type="radio" name="ub9_opc_no_residencial" value="1">
                                        <label for="1">Industria</label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                                        <input type="radio" name="ub9_opc_no_residencial" value="2">
                                        <label for="2">Comercio</label>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                                        <input type="radio" name="ub9_opc_no_residencial" value="3">
                                        <label for="3">Servicios</label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="radio" name="ub9_opc_no_residencial" value="4">
                                        <label for="4">Agropecuario, agroindustrial, forestal</label>
                                    </div> 
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="radio" name="ub9_opc_no_residencial" value="5">
                                        <label for="5">Institucional</label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="radio" name="ub9_opc_no_residencial" value="6">
                                        <label for="6">Lote (Unidad sin construcci&oacute;n)</label>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="radio" name="ub9_opc_no_residencial" value="7">
                                        <label for="7">Parque o zona verde</label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="radio" name="ub9_opc_no_residencial" value="8">
                                        <label for="8">Minero - energ&eacute;tico</label>
                                    </div>     
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="radio" name="ub9_opc_no_residencial" value="9">
                                        <label for="9">Protecci&oacute;n o conservaci&oacute;n ambiental</label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="radio" name="ub9_opc_no_residencial" value="10">
                                        <label for="10">En construcci&oacute;n</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>10. N&uacute;mero de orden de la vivienda en la edificaci&oacute;n</b></h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">                        
                        <input type="number" name="ub10_numero_orden" id="ub10_numero_orden">
                    </div>                                      
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>11. ¿Usted o alg&uacute;n miembro de este hogar diligenci&oacute; recientemente el cuestionario del Censo Nacional de Poblaci&oacute;n y Vivienda 2018, por internet (el eCenso)?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub11_realizo" value="1">
                            <label for="1">S&iacute;</label>
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <label>¿Cu&aacute;l es el n&uacute;mero del documento de identidad del Jefe(a) de hogar?</label>
                                <input type="number" name="ub11_documento_jefe" id="ub11_documento_jefe">
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub11_realizo" value="2">
                            <label for="2">No</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub11_realizo" value="3">
                            <label for="3">No Sabe</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>11.1 ¿Este hogar cambi&oacute; de lugar de residencia entre el registrado en el eCenso y el d&iacute;a de hoy?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub11_1_cambio" value="1">
                            <label for="1">S&iacute;</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub11_1_cambio" value="2">
                            <label for="2">No</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>11.2 Teniendo en cuenta que hogar censal se refiere a “una persona o grupo de personas, parientes o no, que ocupan la totalidad o parte de una vivienda; atienden necesidades básicas con cargo a un presupuesto común y generalmente comparten las comidas”, ¿Dígame si hay más hogares en esta vivienda?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub11_2_mas_hogar" value="1">
                            <label for="1">S&iacute; hay m&aacute;s hogares</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub11_2_mas_hogar" value="2">
                            <label for="2">No hay m&aacute;s hogares, y este hogar S&iacute; cambi&oacute; de residencia (Pregunta 11.1 = 1)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub11_2_mas_hogar" value="3">
                            <label for="3">No hay m&aacute;s hogares, y este hogar No cambi&oacute; de residencia (Pregunta 11.1 = 2)</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>12. Usted o alg&uacute;n miembro de este hogar,en este a&ntilde;o, ha sido entrevistado por un censista del DANE en su vivienda para responder el Censo Nacional de Población y Vivienda 2018?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub12_visitado" value="1">
                            <label for="1">S&iacute;</label>
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <label>¿Cu&aacute;l es el n&uacute;mero del certificado censal que le entregaron?</label>
                                <input type="number" name="ub12_numero_certificado" id="ub12_numero_certificado">
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub12_visitado" value="2">
                            <label for="2">No</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub12_visitado" value="3">
                            <label for="3">No Sabe</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>Diligencie la siguiente pregunta &uacute;nicamente si en la pregunta 2 quedaron marcadas las opciones 2 o 3, y si en la pregunta 3 qued&oacute; marcada la opci&oacute;n 2</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>12.1 Teniendo en cuenta que hogar censal se refiere a “una persona o grupo de personas, parientes o no, que ocupan la totalidad o parte de una vivienda; atienden necesidades b&aacute;sicas con cargo a un presupuesto com&uacute;n y generalmente comparten las comidas”, ¿D&iacute;game si hay m&aacute;s hogares en esta vivienda?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub12_1_mas_hogares" value="1">
                            <label for="1">S&iacute;</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="ub12_1_mas_hogares" value="2">
                            <label for="2">No</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>13. ¿La vivienda se encuentra en el interior de un territorio &eacute;tnico?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub13_vivienda_etnico" value="1">
                            <label for="1">S&iacute;</label>
                            <div class="form-group">
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <input type="radio" name="ub13_territorio" value="1">
                                <label for="1">¿Est&aacute; en un territorio ancestral o tradicional ind&iacute;gena?</label>
                                <fieldset>
                                    <div class="col-xs-8 col-sm-8 col-md-8">                        
                                        <label>Nombre del territorio</label>
                                        <input type="text" name="ub13_nombre_territorio_ancestral_indigena" id="ub13_nombre_territorio_ancestral_indigena">            
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                                <input type="radio" name="ub13_territorio" value="1">
                                <label for="1">¿Est&aacute; en una parcialidad o asentamiento ind&iacute;gena fuera de resguardo</label>
                                <fieldset>
                                    <div class="col-xs-8 col-sm-8 col-md-8">                        
                                        <label>Nombre de la parcialidad o asentamiento</label> 
                                        <input type="text" name="ub13_nombre_territorio_asentamiento" id="ub13_nombre_territorio_asentamiento">                      
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                                <input type="radio" name="ub13_territorio" value="1">
                                <label for="1">¿Est&aacute; en una reserva ind&iacute;gena?</label>
                                <fieldset>
                                    <div class="col-xs-8 col-sm-8 col-md-8">                        
                                        <label>Nombre de la reserva ind&iacute;gena</label> 
                                        <input type="text" name="ub13_nombre_territorio_reserva" id="ub13_nombre_territorio_reserva">                      
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                                <input type="radio" name="ub13_territorio" value="2">
                                <label for="2">¿Est&aacute; en un territorio ancestral o tradicional de comunidades negras no?</label>
                                <fieldset>
                                    <div class="col-xs-8 col-sm-8 col-md-8">                        
                                        <label>Nombre del territorio</label> 
                                        <input type="text" name="ub13_nombre_territorio_ancestral_negros" id="ub13_nombre_territorio_ancestral_negros">                      
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                                <input type="radio" name="ub13_territorio" value="3">
                                <label for="3">¿Est&aacute; en un territorio ancestral raizal del Archipi&eacute;lago de San Andr&eacute;s, Providencia y Santa Catalina?</label>
                                <fieldset>
                                    <div class="col-xs-8 col-sm-8 col-md-8">                        
                                        <label>Nombre del territorio</label> 
                                        <input type="text" name="ub13_nombre_territorio_sanandres" id="ub13_nombre_territorio_sanandres">                      
                                    </div>
                                </fieldset>
                            </div>
                            </fieldset>
                        </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="ub13_territorio" value="2">
                            <label for="2">No</label>
                        </div>
                    </fieldset>
                </div>
            </div>

            <!-- ************************* FORMUARIO PARA LA VIVIENDA *********************** -->
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1>VIVIENDA</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>14. Tipo de vivienda</b></h4>
                    <h6>(Diligencie por observaci&oacute;n teniendo en cuenta los conceptos de tipolog&iacute;a de vivienda. Si tiene dudas, indague con el entrevistado)</h6>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv14_tipo_vivienda" value="1">
                            <label for="1">Casa</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv14_tipo_vivienda" value="2">
                            <label for="2">Apartamento</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv14_tipo_vivienda" value="3">
                            <label for="3">Tipo Cuarto</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv14_tipo_vivienda" value="4">
                            <label for="4">Vivienda tradicional ind&iacute;gena</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv14_tipo_vivienda" value="5">
                            <label for="5">Vivienda tradicional &eacute;tnica (afrocolombiana, isle&ntilde;a, Rrom)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv14_tipo_vivienda" value="6">
                            <label for="6">Otro (contenedor, carpa, embarcaci&oacute;n, vag&oacute;n, cueva, refugio natural, etc.)</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>15. Condici&oacute;n de ocupaci&oacute;n de la vivienda</b></h4>
                    <h6>(Diligencie por observaci&oacute;n teniendo en cuenta los conceptos de tipolog&iacute;a de vivienda. Si tiene dudas, indague con el entrevistado)</h6>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv15_ocupacion_vivienda" value="1">
                            <label for="1">Ocupada con personas presentes</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv15_ocupacion_vivienda" value="2">
                            <label for="2">Ocupada con todas las personas ausentes</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv15_ocupacion_vivienda" value="3">
                            <label for="3">Vivienda temporal (para vacaciones, trabajo, etc.)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv15_ocupacion_vivienda" value="4">
                            <label for="4">Desocupada</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>16. Teniendo en cuenta que hogar censal se refiere a “una persona o grupo de personas, parientes o no, que ocupan la totalidad o parte de una vivienda, atienden necesidades b&aacute;sicas con cargo a un presupuesto com&uacute;n y generalmente comparten las comidas”, ¿Cu&aacute;ntos hogares hay en esta vivienda?</b></h4>
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <label>Total de hogares</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <input type="number" name="vv16_total_hogares" id="vv16_total_hogares">
                    </div>                   
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>17. ¿Cu&aacute;l es el material predominante de las paredes exteriores de esta vivienda</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="1">
                            <label for="1">Bloque, ladrillo, piedra, madera pulida</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="2">
                            <label for="2">Concreto vaciado</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="3">
                            <label for="3">Material prefabricado</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="4">
                            <label for="4">Guadua</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="5">
                            <label for="5">Tapia pisada, bahareque, adobe</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="6">
                            <label for="6">Madera burda, tabla, tabl&oacute;n</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="7">
                            <label for="7">Ca&ntilde;a, esterilla, otros vegetales</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="8">
                            <label for="8">Materiales de desecho (zinc, tela, cart&oacute;n, latas, pl&aacute;sticos, otros)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv17_material_vivienda" value="9">
                            <label for="9">No tiene paredes</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>18. Cu&aacute;l es el material predominante de los pisos de esta vivienda</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv18_material_vivienda" value="1">
                            <label for="1">M&aacute;rmol, parqu&eacute;, madera pulida y lacada</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv18_material_vivienda" value="2">
                            <label for="2">Baldosa, vinilo, tableta, ladrillo, laminado</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv18_material_vivienda" value="3">
                            <label for="3">Alfombra</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv18_material_vivienda" value="4">
                            <label for="4">Cemento, gravilla</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv18_material_vivienda" value="5">
                            <label for="5">Madera burda, tabla, tabl&oacute;n, otro vegetal</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv18_material_vivienda" value="6">
                            <label for="6">Tierra, arena, barro</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>19. ¿La vivienda cuenta con servicios de: </b></h4>
                    
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="1">Energ&iacute;a el&eacute;ctrica?</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_energia_electrica" value="1">
                        <label for="1">S&iacute;</label> 
                        <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <label>Estrato</label>
                                <input type="text" name="vv19_estrato_energia_electrica" id="vv19_estrato_energia_electrica">
                            </div>
                        </fieldset>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_energia_electrica" value="2">
                        <label for="2">No</label>                            
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="1">Acueducto?</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_acueducto" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_acueducto" value="2">
                        <label for="2">No</label>                            
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="1">Alcantarillado?</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_alcantarillado" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_alcantarillado" value="2">
                        <label for="2">No</label>                            
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="1">Gas natural conectado a red p&uacute;blica?</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_gas" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_gas" value="2">
                        <label for="2">No</label>                            
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="1">Recolecci&oacute;n de basura</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_basura" value="1">
                        <label for="1">S&iacute;</label>
                        <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <label>Estrato</label>
                                <input type="text" name="vv19_basura_veces" id="vv19_basura_veces">
                            </div>
                        </fieldset>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_basura" value="2">
                        <label for="2">No</label>                            
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="1">Internet? (Fijo o m&oacute;vil</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_internet" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv19_internet" value="2">
                        <label for="2">No</label>                            
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>20. ¿Qu&eacute; tipo de servicio sanitario (inodoro) tiene esta vivienda:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv20_sanitario" value="1">
                            <label for="1">Inodoro conectado al alcantarillado?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv20_sanitario" value="2">
                            <label for="2">Inodoro conectado a pozo s&eacute;ptico?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv20_sanitario" value="3">
                            <label for="3">Inodoro sin conexi&oacute;n?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv20_sanitario" value="4">
                            <label for="4">Letrina?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv20_sanitario" value="5">
                            <label for="5">Inodoro con descarga directa a fuentes de agua? (bajamar)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv20_sanitario" value="6">
                            <label for="6">Esta vivienda no tiene servicio sanitario?</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <button type="submit" class="btn btn-dane-success">Guardar<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>   
                </div>
            </div>
        </form>
    </div>
</div>