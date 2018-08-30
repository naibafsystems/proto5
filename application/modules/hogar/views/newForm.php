<script>
function limpiar(cual, accion){
// Action: 0=Deseleccionar todos 1=Seleccionar todos -1=Invertir seleccion
    var f = document.frmUbicacionN
    for (var i=0; i<f.elements.length; i++){
        var obj = f.elements[i]
        var name = obj.name
        if (name==cual){
            obj.checked = ((accion==1)? true : ((accion==0)? false : !obj.checked) );
        }
    }
}
</script>
<div class="row">
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmUbicacionN" name="frmUbicacionN" role="form" method="post" action="<?php echo base_url('hogar/guardarHogar') ?>">
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1>HOGAR NUMERO <?php echo $total_hogares_insertados ?></h1>
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
                        <input type="number" name="hg21_numero_orden" id="hg21_numero_orden"  >
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
                        <input type="number" name="hg22_total_cuartos" max="99" id="hg22_total_cuartos">
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
                        <input type="number" name="hg23_total_cuartos_dormir" max="99" id="hg23_total_cuartos_dormir">
                    </div>                                        
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>24. ¿En d&oacute;nde preparan los alimentos las personas de este hogar:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="1">
                            <label for="1">En un cuarto usado solo para cocinar?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="2">
                            <label for="2">En un cuarto usado tambi&eacute;n para dormir?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="3">
                            <label for="3">En una sala-comedor con lavaplatos?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="4">
                            <label for="4">En una sala-comedor sin lavaplatos?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="5">
                            <label for="5">En un patio, corredor, enramada o al aire libre?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg24_prepara_alimentos" value="6">
                            <label for="6">No preparan alimentos en la vivienda?</label>
                        </div>
                         <a href="javascript:limpiar('hg24_prepara_alimentos',0)">limpiar</a> 
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>25. ¿De d&oacute;nde obtiene principalmente este hogar el agua para preparar los alimentos:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="1">
                            <label for="1">Acueducto p&uacute;blico?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="2">
                            <label for="2">Acueducto veredal?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="3">
                            <label for="3">Red de distribuci&oacute;n comunitaria?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="4">
                            <label for="4">Pozo con bomba?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="5">
                            <label for="5">Pozo sin bomba, aljibe, jagüey o barreno?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="6">
                            <label for="6">Agua lluvia?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="7">
                            <label for="7">R&iacute;o, quebrada, manantial o nacimiento?</label>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="8">
                            <label for="8">Pila p&uacute;blica?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="9">
                            <label for="9">Carrotanque?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="10">
                            <label for="10">Aguatero?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="hg25_obtiene_agua" value="11">
                            <label for="11">Agua embotellada o en bolsa?</label>
                        </div>
                         <a href="javascript:limpiar('hg25_obtiene_agua',0)">limpiar</a> 
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
                        <input type="number" name="hg26_total_fallecieron" max="99" id="hg26_total_fallecieron">
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
                            <td colspan="3">Sexo</td>
                            <td rowspan="2">Edad al morir (para menores de 1 a&ntilde;o escriba 0)</td>
                            <td colspan="4">¿Se expidi&oacute; certificado de defunci&oacute;n?</td>
                        </tr>
                        <tr colspan="2">
                            <td>Hombre</td>
                            <td>Mujer</td>
                            <td>Limpiar</td>                            
                            <td>S&iacute;</td>
                            <td>No</td>
                            <td>No sabe</td>
                            <td>limpiar</td>
                        </tr>
                        <?php
                        for($i=1;$i<=15;$i++){
                            ?>
                            <tr>
                                <td>
                                    <input type="number" name="hg26_numero_orden_<?php echo $i; ?>" id="hg26_numero_orden">
                                </td>
                                <td>
                                    <input type="radio" name="hg26_sexo_<?php echo $i; ?>" value="1">
                                </td>
                                <td>
                                    <input type="radio" name="hg26_sexo_<?php echo $i; ?>" value="2">
                                </td>
                                <td>
                                    <a href="javascript:limpiar('hg26_sexo_<?php echo $i; ?>',0)">limpiar</a> 
                                </td>     
                                <td>
                                    <input type="number" name="hg26_edad_<?php echo $i; ?>" id="hg26_edad" max="999">
                                </td> 
                                <td>
                                    <input type="radio" name="hg26_certificado_defuncion_<?php echo $i; ?>" value="1">
                                </td>       
                                <td>
                                    <input type="radio" name="hg26_certificado_defuncion_<?php echo $i; ?>" value="2">
                                </td>       
                                <td>
                                    <input type="radio" name="hg26_certificado_defuncion_<?php echo $i; ?>" value="3">
                                </td>  
                                <td>
                                     <a href="javascript:limpiar('hg26_certificado_defuncion_<?php echo $i; ?>',0)">limpiar</a> 
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
                        </tr>
                        <tr colspan="2">
                            <td>Primer Nombre</td>
                            <td>Segundo Nombre</td>                            
                            <td>Primer Apellido</td>
                            <td>Segundo Apellido</td>
                        </tr>
                        <?php
                        for($i=1;$i<=15;$i++){
                            ?>
                            <tr>
                                <td>
                                    <input style="width: 100px;" type="number" name="hg27_numero_orden_<?php echo $i; ?>" id="hg27_numero_orden_<?php echo $i; ?>" max="99" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td>
                                <td>
                                   <input style="width: 120px;" type="text" name="hg27_primer_nombre_<?php echo $i; ?>" id="hg27_primer_nombre_<?php echo $i; ?>" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td>
                                <td>
                                    <input style="width: 120px;" type="text" name="hg27_segundo_nombre_<?php echo $i; ?>" id="hg27_segundo_nombre_<?php echo $i; ?>">
                                </td>
                                <td>
                                    <input style="width: 120px;" type="text" name="hg27_primer_apellido_<?php echo $i; ?>" id="hg27_primer_apellido_<?php echo $i; ?>" <?php if( $i==1 ) { ?>required="required"<?php } ?>>
                                </td> 
                                <td>
                                    <input style="width: 120px;" type="text" name="hg27_segundo_apellido_<?php echo $i; ?>" id="hg27_segundo_apellido_<?php echo $i; ?>">
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