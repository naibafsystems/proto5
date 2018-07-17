<div class="row">
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmUbicacionN" name="frmUbicacionN" role="form" method="post" action="<?php echo base_url('vivienda/guardarVivienda') ?>">
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1>VIVIENDA</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>1. Tipo de vivienda</b></h4>
                    <h6>(Diligencie por observaci&oacute;n teniendo en cuenta los conceptos de tipolog&iacute;a de vivienda. Si tiene dudas, indague con el entrevistado)</h6>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv1_tipo_vivienda" value="1">
                            <label for="1">Casa</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv1_tipo_vivienda" value="2">
                            <label for="2">Apartamento</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv1_tipo_vivienda" value="3">
                            <label for="3">Tipo Cuarto</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv1_tipo_vivienda" value="4">
                            <label for="4">Vivienda tradicional ind&iacute;gena</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv1_tipo_vivienda" value="5">
                            <label for="5">Vivienda tradicional &eacute;tnica (afrocolombiana, isle&ntilde;a, Rrom)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv1_tipo_vivienda" value="6">
                            <label for="6">Otro (contenedor, carpa, embarcaci&oacute;n, vag&oacute;n, cueva, refugio natural, etc.)</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>2. Condici&oacute;n de ocupaci&oacute;n de la vivienda</b></h4>
                    <h6>(Diligencie por observaci&oacute;n teniendo en cuenta los conceptos de tipolog&iacute;a de vivienda. Si tiene dudas, indague con el entrevistado)</h6>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv2_ocupacion_vivienda" value="1">
                            <label for="1">Ocupada con personas presentes</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv2_ocupacion_vivienda" value="2">
                            <label for="2">Ocupada con todas las personas ausentes</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv2_ocupacion_vivienda" value="3">
                            <label for="3">Vivienda temporal (para vacaciones, trabajo, etc.)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv2_ocupacion_vivienda" value="4">
                            <label for="4">Desocupada</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>3. Teniendo en cuenta que hogar censal se refiere a “una persona o grupo de personas, parientes o no, que ocupan la totalidad o parte de una vivienda, atienden necesidades b&aacute;sicas con cargo a un presupuesto com&uacute;n y generalmente comparten las comidas”, ¿Cu&aacute;ntos hogares hay en esta vivienda?</b></h4>
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <label>Total de hogares</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <input type="number" name="vv3_total_hogares" id="vv3_total_hogares">
                    </div>                   
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>4. ¿Cu&aacute;l es el material predominante de las paredes exteriores de esta vivienda</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="1">
                            <label for="1">Bloque, ladrillo, piedra, madera pulida</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="2">
                            <label for="2">Concreto vaciado</label>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="3">
                            <label for="3">Material prefabricado</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="4">
                            <label for="4">Guadua</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="5">
                            <label for="5">Tapia pisada, bahareque, adobe</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="6">
                            <label for="6">Madera burda, tabla, tabl&oacute;n</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="7">
                            <label for="7">Ca&ntilde;a, esterilla, otros vegetales</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="8">
                            <label for="8">Materiales de desecho (zinc, tela, cart&oacute;n, latas, pl&aacute;sticos, otros)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv4_material_vivienda" value="9">
                            <label for="9">No tiene paredes</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>5. Cu&aacute;l es el material predominante de los pisos de esta vivienda</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv5_material_vivienda" value="1">
                            <label for="1">M&aacute;rmol, parqu&eacute;, madera pulida y lacada</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv5_material_vivienda" value="2">
                            <label for="2">Baldosa, vinilo, tableta, ladrillo, laminado</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv5_material_vivienda" value="3">
                            <label for="3">Alfombra</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv5_material_vivienda" value="4">
                            <label for="4">Cemento, gravilla</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv5_material_vivienda" value="5">
                            <label for="5">Madera burda, tabla, tabl&oacute;n, otro vegetal</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv5_material_vivienda" value="6">
                            <label for="6">Tierra, arena, barro</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>6. ¿La vivienda cuenta con servicios de: </b></h4>
                    
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="1">Energ&iacute;a el&eacute;ctrica?</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv6_energia_electrica" value="1">
                        <label for="1">S&iacute;</label> 
                        <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <label>Estrato</label>
                                <input type="text" name="vv6_estrato_energia_electrica" id="vv6_estrato_energia_electrica">
                            </div>
                        </fieldset>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv6_energia_electrica" value="2">
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
                        <input type="radio" name="vv6_acueducto" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv6_acueducto" value="2">
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
                        <input type="radio" name="vv6_alcantarillado" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv6_alcantarillado" value="2">
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
                        <input type="radio" name="vv6_gas" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv6_gas" value="2">
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
                        <input type="radio" name="vv6_basura" value="1">
                        <label for="1">S&iacute;</label>
                        <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">                        
                                <label>Estrato</label>
                                <input type="text" name="vv6_basura_veces" id="vv6_basura_veces">
                            </div>
                        </fieldset>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv6_basura" value="2">
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
                        <input type="radio" name="vv6_internet" value="1">
                        <label for="1">S&iacute;</label>                          
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">                        
                        <input type="radio" name="vv6_internet" value="2">
                        <label for="2">No</label>                            
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>7. ¿Qu&eacute; tipo de servicio sanitario (inodoro) tiene esta vivienda:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv7_sanitario" value="1">
                            <label for="1">Inodoro conectado al alcantarillado?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv7_sanitario" value="2">
                            <label for="2">Inodoro conectado a pozo s&eacute;ptico?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv7_sanitario" value="3">
                            <label for="3">Inodoro sin conexi&oacute;n?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv7_sanitario" value="4">
                            <label for="4">Letrina?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv7_sanitario" value="5">
                            <label for="5">Inodoro con descarga directa a fuentes de agua? (bajamar)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="vv7_sanitario" value="6">
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