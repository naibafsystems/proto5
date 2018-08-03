<div class="row">
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmUbicacionN" name="frmUbicacionN" role="form" method="post" action="<?php echo base_url('hogar/guardarHogar') ?>">
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1>HOGAR NUMERO <?php echo $respuestas[0]["H_NROHOG"]; ?></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>21. N&uacute;mero de orden del hogar dentro de la vivienda</b></h4>
                    <div class="col-xs-2 col-sm-2 col-md-2">                       
                        <label>N&uacute;mero de orden</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">                       
                        <input type="number" name="hg21_numero_orden" id="hg21_numero_orden" value="<?php echo $respuestas[0]["H_NROHOG"]; ?>" readonly>
                    </div>   
                    <div class="col-xs-1 col-sm-1 col-md-1"> 
                    <label>De</label>
                    </div>                   
                    <div class="col-xs-2 col-sm-2 col-md-2">                       
                        <label>Total de hogares</label>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">                       
                        <input type="number" name="hg21_numero_ordenT" id="hg21_numero_ordenT" value="<?php echo $total_hogares ?>" readonly>
                    </div> 
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <h6>(Corresponde a la respuesta de la pregunta 16)</h6>                      
                    </div>                      
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>22. De cu&aacute;ntos cuartos en total dispone este hogar?</b></h4>
                    <h6>(Incluya la sala y el comedor. No incluya cocina, ba&ntilde;os ni los cuartos utilizados solo para garaje o negocio)</h6>
                    <div class="col-xs-6 col-sm-6 col-md-6">                       
                        <label>Total de cuartos</label>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                       
                        <input type="number" name="hg22_total_cuartos" max="99" id="hg22_total_cuartos" value="<?php echo $respuestas[0]["H_NRO_CUARTOS"]; ?>">
                    </div>                                        
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>23. ¿Cu&aacute;ntos de esos cuartos usan las personas de este hogar para dormir?</b></h4>
                    
                    <div class="col-xs-6 col-sm-6 col-md-6">                       
                        <label>Total de cuartos para dormir</label>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                       
                        <input type="number" name="hg23_total_cuartos_dormir" max="99" id="hg23_total_cuartos_dormir" value="<?php echo $respuestas[0]["H_NRO_DORMIT"]; ?>">
                    </div>                                        
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>24. ¿En d&oacute;nde preparan los alimentos las personas de este hogar:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="1" <?php if( $respuestas[0]["H_DONDE_PREPALIM"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">En un cuarto usado solo para cocinar?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="2" <?php if( $respuestas[0]["H_DONDE_PREPALIM"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">En un cuarto usado tambi&eacute;n para dormir?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="3" <?php if( $respuestas[0]["H_DONDE_PREPALIM"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">En una sala-comedor con lavaplatos?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="4" <?php if( $respuestas[0]["H_DONDE_PREPALIM"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">En una sala-comedor sin lavaplatos?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="5" <?php if( $respuestas[0]["H_DONDE_PREPALIM"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">En un patio, corredor, enramada o al aire libre?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="6" <?php if( $respuestas[0]["H_DONDE_PREPALIM"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">No preparan alimentos en la vivienda?</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>25. ¿De d&oacute;nde obtiene principalmente este hogar el agua para preparar los alimentos:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="1" <?php if( $respuestas[0]["H_AGUA_COCIN"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Acueducto p&uacute;blico?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="2" <?php if( $respuestas[0]["H_AGUA_COCIN"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Acueducto veredal?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="3" <?php if( $respuestas[0]["H_AGUA_COCIN"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Red de distribuci&oacute;n comunitaria?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="4" <?php if( $respuestas[0]["H_AGUA_COCIN"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">Pozo con bomba?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="5" <?php if( $respuestas[0]["H_AGUA_COCIN"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">Pozo sin bomba, aljibe, jagüey o barreno?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="6" <?php if( $respuestas[0]["H_AGUA_COCIN"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Agua lluvia?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="7" <?php if( $respuestas[0]["H_AGUA_COCIN"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">R&iacute;o, quebrada, manantial o nacimiento?</label>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="8" <?php if( $respuestas[0]["H_AGUA_COCIN"]==8 ) { ?>checked="checked"<?php } ?>>
                            <label for="8">Pila p&uacute;blica?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="9" <?php if( $respuestas[0]["H_AGUA_COCIN"]==9 ) { ?>checked="checked"<?php } ?>>
                            <label for="9">Carrotanque?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="10" <?php if( $respuestas[0]["H_AGUA_COCIN"]==10 ) { ?>checked="checked"<?php } ?>>
                            <label for="10">Aguatero?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="11" <?php if( $respuestas[0]["H_AGUA_COCIN"]==11 ) { ?>checked="checked"<?php } ?>>
                            <label for="11">Agua embotellada o en bolsa?</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>26. ¿Cu&aacute;ntas personas que eran miembros de este hogar fallecieron en el 2017?</b></h4>
                    
                    <div class="col-xs-3 col-sm-3 col-md-3">                       
                        <label>Total</label>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5">                       
                        <input type="number" name="hg26_total_fallecieron" max="99" id="hg26_total_fallecieron" value="<?php echo $respuestas[0]["HA_NRO_FALL"]; ?>">
                    </div>   
                    <div class="col-xs-4 col-sm-4 col-md-4">                       
                        <h6>Si es 0, continúe con la pregunta 27)</h6>
                        <h6>(Si es 1 o más, relaciónelos en la siguiente tabla)</h6>
                    </div>                                       
                </div>
                <div class="form-group">
                    <table border="2">
                        <tr>
                            <td rowspan="2">N&uacute;mero de orden</td>
                            <td colspan="2">Sexo</td>
                            <td rowspan="2">Edad al morir (para menores de 1 a&ntilde;o escriba 0)</td>
                            <td colspan="3">¿Se expidi&oacute; certificado de defunci&oacute;n?</td>
                        </tr>
                        <tr colspan="2">
                            <td>Hombre</td>
                            <td>Mujer</td>                            
                            <td>S&iacute;</td>
                            <td>No</td>
                            <td>No sabe</td>
                        </tr>
                        <?php
                        for($i=1;$i<=15;$i++){
                            $ll=$i-1;
                            ?>
                            <tr>
                                <td>
                                    <input type="number" name="hg26_numero_orden_<?php echo $i; ?>" id="hg26_numero_orden" value="<?php echo $respuestasPersonasFallecidas[$ll]["FA1_NRO_FALL"]; ?>">
                                </td>
                                <td>
                                    <input type="radio" name="hg26_sexo_<?php echo $i; ?>" value="1" <?php if( $respuestasPersonasFallecidas[$ll]["FA2_SEXO_FALL"]==1 ) { ?>checked="checked"<?php } ?>>
                                </td>
                                <td>
                                    <input type="radio" name="hg26_sexo_<?php echo $i; ?>" value="2" <?php if( $respuestasPersonasFallecidas[$ll]["FA2_SEXO_FALL"]==2 ) { ?>checked="checked"<?php } ?>>
                                </td>
                                <td>
                                    <input type="number" name="hg26_edad_<?php echo $i; ?>" id="hg26_edad" max="999" value="<?php echo $respuestasPersonasFallecidas[$ll]["FA3_EDAD_FALL"]; ?>">
                                </td> 
                                <td>
                                    <input type="radio" name="hg26_certificado_defuncion_<?php echo $i; ?>" value="1" <?php if( $respuestasPersonasFallecidas[$ll]["FA4_CERT_DEFUN"]==1 ) { ?>checked="checked"<?php } ?>>
                                </td>       
                                <td>
                                    <input type="radio" name="hg26_certificado_defuncion_<?php echo $i; ?>" value="2" <?php if( $respuestasPersonasFallecidas[$ll]["FA4_CERT_DEFUN"]==2 ) { ?>checked="checked"<?php } ?>>
                                </td>       
                                <td>
                                    <input type="radio" name="hg26_certificado_defuncion_<?php echo $i; ?>" value="3" <?php if( $respuestasPersonasFallecidas[$ll]["FA4_CERT_DEFUN"]==3 ) { ?>checked="checked"<?php } ?>>
                                </td>       
                            </tr>
                            <?php
                        }
                        ?>
                    </table>                                    
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>27. ¿Cu&aacute;les son los nombres y apellidos de las personas que conforman este hogar, residentes habituales, presentes o no?</b></h4>
                    <h6>(Comience por el[la] jefe[a] de hogar)</h6>                                       
                </div>
                <div class="form-group">
                    <table border="2" WIDTH="100%">
                        <tr>
                            <th rowspan="2">N&uacute;mero de orden de la persona</th>
                            <th colspan="2">Nombres Completos</th>
                            <th colspan="2">Apellidos Completos</th>
                            <th rowspan="2">Edad</th>
                            <th rowspan="2">Tipo Documento Identidad</th>
                            <th rowspan="2">N&uacute;mero Del Documento</th>
                        </tr>
                        <tr colspan="2">
                            <td>Primer Nombre</td>
                            <td>Segundo Nombre</td>                            
                            <td>Primer Apellido</td>
                            <td>Segundo Apellido</td>
                        </tr>
                        <?php
                        for($i=1;$i<=15;$i++){
                            $kk=$i-1;
                            ?>
                            <tr>
                                <td>
                                    <input style="width: 100px;" type="number" name="hg27_numero_orden_<?php echo $i; ?>" id="hg27_numero_orden_<?php echo $i; ?>" max="99" value="<?php echo $respuestasPersonas[$kk]["P_NRO_PER"]; ?>" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td>
                                <td>
                                    <input style="width: 120px;" type="text" name="hg27_primer_nombre_<?php echo $i; ?>" id="hg27_primer_nombre_<?php echo $i; ?>" value="<?php echo $respuestasPersonas[$kk]["RA2_1NOMBRE"]; ?>" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td>
                                <td>
                                    <input style="width: 120px;" type="text" name="hg27_segundo_nombre_<?php echo $i; ?>" id="hg27_segundo_nombre_<?php echo $i; ?>" value="<?php echo $respuestasPersonas[$kk]["RA3_2NOMBRE"]; ?>">
                                </td>
                                <td>
                                    <input style="width: 120px;" type="text" name="hg27_primer_apellido_<?php echo $i; ?>" id="hg27_primer_apellido_<?php echo $i; ?>" value="<?php echo $respuestasPersonas[$kk]["RA4_1APELLIDO"]; ?>" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td> 
                                <td>
                                    <input style="width: 120px;" type="text" name="hg27_segundo_apellido_<?php echo $i; ?>" id="hg27_segundo_apellido_<?php echo $i; ?>" value="<?php echo $respuestasPersonas[$kk]["RA5_2APELLIDO"]; ?>">
                                </td>
                                <td>
                                    <input style="width: 50px;" type="number" name="hg27_edad_<?php echo $i; ?>" max="999" id="hg27_edad_<?php echo $i; ?>" value="<?php echo $respuestasPersonas[$kk]["P_EDAD"]; ?>" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td>
                                <td>
                                  <div class="doc-group">
                                    <input type="radio" name="hg27_tipoD_<?php echo $i; ?>" value="1" <?php if( $respuestasPersonas[$kk]["PA_TIPO_DOC"]==1 ) { ?>checked="checked"<?php } ?>>
                                    <label for="1">Registro civil de nacimiento</label>
                                    </div>
                                    <div class="doc-group">
                                    <input type="radio" name="hg27_tipoD_<?php echo $i; ?>" value="2" <?php if( $respuestasPersonas[$kk]["PA_TIPO_DOC"]==2 ) { ?>checked="checked"<?php } ?>>
                                    <label for="2">Tarjeta de identidad</label>
                                    </div>
                                    <div class="doc-group">
                                    <input type="radio" name="hg27_tipoD_<?php echo $i; ?>" value="3" <?php if( $respuestasPersonas[$kk]["PA_TIPO_DOC"]==3 ) { ?>checked="checked"<?php } ?>>
                                    <label for="3">C&eacute;dula de ciudadan&iacute;a</label>
                                    </div>
                                    <div class="doc-group">
                                    <input type="radio" name="hg27_tipoD_<?php echo $i; ?>" value="4" <?php if( $respuestasPersonas[$kk]["PA_TIPO_DOC"]==4 ) { ?>checked="checked"<?php } ?>>
                                    <label for="4">C&eacute;dula de extranjer&iacute;a</label>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" name="hg27_documento_<?php echo $i; ?>" id="hg27_documento_<?php echo $i; ?>" value="<?php echo $respuestasPersonas[$kk]["PA1_NRO_DOC"]; ?>" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td>

                            </tr>
                            <?php
                        }
                        ?>
                    </table>                                    
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