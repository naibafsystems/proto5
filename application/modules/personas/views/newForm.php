<div class="row">
    <div id="divForm" class="col-xs-12 col-sm-12 col-md-12">
        <form id="frmUbicacionN" name="frmUbicacionN" role="form" method="post" action="<?php echo base_url('personas/guardarPersona') ?>">
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1>PERSONAS</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>30. N&uacute;mero de orden de la persona</b></h4>
                    <h6>(Copie el n&uacute;mero de orden seg&uacute;n la lista de la pregunta 27)</h6>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="number" name="p30_orden_persona" id="p30_orden_persona" value="<?php echo $respuestas[0]["P_NRO_PER"]; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>31. Primer nombre y primer apellido de la persona</b></h4>
                    <h6>(Copie el primer nombre y el primer apellido seg&uacute;n la lista de la pregunta 27)</h6>
                    <div class="col-xs-6 col-sm-6 col-md-6">                       
                        <label>Primer nombre</label>
                        <input type="text" name="p31_primer_nombre" id="p31_primer_nombre" value="<?php echo $respuestas[0]["PA_1ER_NOMBRE"]; ?>" readonly>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                        
                        <label>Primer apellido</label>
                        <input type="text" name="p31_primer_apellido" id="p31_primer_apellido" value="<?php echo $respuestas[0]["PB_1ER_APELLIDO"]; ?>" readonly>
                    </div>                    
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>32. ... Es hombre o mujer</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p32_sexo" value="1" <?php if( $respuestas[0]["P_SEXO"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Hombre</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p32_sexo" value="2" <?php if( $respuestas[0]["P_SEXO"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Mujer</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>33. Sabe cu&aacute;l es la fecha de nacimiento de ... </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p33_sabe_fecha" value="1" <?php if( $respuestas[0]["PA_SABE_FECHA"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;</label>
                            <fieldset>
                                <?php 
                                ?>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11">                        
                                    <label>D&iacute;a</label>
                                    <input type="number" name="p33_dia" id="p33_dia" max=31 value="<?php echo $respuestas[0]["PA1_FECHA_NAC"]; ?>" >                      
                                    <label>Mes</label>
                                    <input type="number" name="p33_mes" id="p33_mes" max=12 value="<?php echo $respuestas[0]["PA1_FECHA_NAC"]; ?>" >                      
                                    <label>A&ntilde;o</label>
                                    <input type="number" name="p33_anio" id="p33_anio" max=2020 value="<?php echo $respuestas[0]["PA1_FECHA_NAC"]; ?>" >
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p33_sabe_fecha" value="2" <?php if( $respuestas[0]["PA_SABE_FECHA"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No sabe</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>34. Cu&aacute;ntos a&ntilde;os cumplidos tiene ... ?</b></h4>
                    <div class="col-xs-6 col-sm-6 col-md-6">                       
                        <label>A&ntilde;os cumplidos</label>
                        <input type="number" name="p34_anios_cumplidos" id="p34_anios_cumplidos" value="<?php echo $respuestas[0]["P_EDAD"]; ?>">
                    </div>                 
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>35. ¿Cu&aacute;l es el tipo y el n&uacute;mero del documento de identidad colombiano de ... ? </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p35_tipo_documento" value="1" <?php if( $respuestas[0]["PA_TIPO_DOC"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Registro civil de nacimiento</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p35_tipo_documento" value="2" <?php if( $respuestas[0]["PA_TIPO_DOC"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Tarjeta de identidad</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p35_tipo_documento" value="3" <?php if( $respuestas[0]["PA_TIPO_DOC"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Tarjeta de identidad</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p35_tipo_documento" value="4" <?php if( $respuestas[0]["PA_TIPO_DOC"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">C&eacute;dula de extranjer&iacute;a</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11">                        
                                    <label>N&uacute;mero del documento</label>
                                    <input type="number" name="p35_nro_doc" id="p35_nro_doc" max=99999999999999999999999999 value="<?php echo $respuestas[0]["PA1_NRO_DOC"]; ?>">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p35_tipo_documento" value="5" <?php if( $respuestas[0]["PA_TIPO_DOC"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">No tiene documento de identidad</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p35_tipo_documento" value="6" <?php if( $respuestas[0]["PA_TIPO_DOC"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">No sabe</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p35_tipo_documento" value="7" <?php if( $respuestas[0]["PA_TIPO_DOC"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">No responde</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>36. ¿Cu&aacute;l es la relaci&oacute;n o el parentesco de ... con el jefe(a) de hogar? </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="1" <?php if( $respuestas[0]["P_PARENTESCO"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Jefe(a) de hogar</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="2" <?php if( $respuestas[0]["P_PARENTESCO"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Pareja (c&oacute;nyuge,compa&ntilde;ero[a], esposo[a])</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="3" <?php if( $respuestas[0]["P_PARENTESCO"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Hijo(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="4" <?php if( $respuestas[0]["P_PARENTESCO"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">Hijastro(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="5" <?php if( $respuestas[0]["P_PARENTESCO"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">Yerno o nuera</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="6" <?php if( $respuestas[0]["P_PARENTESCO"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Padre o madre</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="7" <?php if( $respuestas[0]["P_PARENTESCO"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">Padrastro o madrastra</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="8" <?php if( $respuestas[0]["P_PARENTESCO"]==8 ) { ?>checked="checked"<?php } ?>>
                            <label for="8">Suegro(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="9" <?php if( $respuestas[0]["P_PARENTESCO"]==9 ) { ?>checked="checked"<?php } ?>>
                            <label for="9">Hermano(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="10" <?php if( $respuestas[0]["P_PARENTESCO"]==10 ) { ?>checked="checked"<?php } ?>>
                            <label for="10">Hermanastro(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="11" <?php if( $respuestas[0]["P_PARENTESCO"]==11 ) { ?>checked="checked"<?php } ?>>
                            <label for="11">Cu&ntilde;ado(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="12" <?php if( $respuestas[0]["P_PARENTESCO"]==12 ) { ?>checked="checked"<?php } ?>>
                            <label for="12">Nieto(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="13" <?php if( $respuestas[0]["P_PARENTESCO"]==13 ) { ?>checked="checked"<?php } ?>>
                            <label for="13">Abuelo(a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="14" <?php if( $respuestas[0]["P_PARENTESCO"]==14 ) { ?>checked="checked"<?php } ?>>
                            <label for="14">Otro pariente</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="15" <?php if( $respuestas[0]["P_PARENTESCO"]==15 ) { ?>checked="checked"<?php } ?>>
                            <label for="15">Empleado(a) del servicio dom&eacute;stico</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p36_parentesco_jefe" value="16" <?php if( $respuestas[0]["P_PARENTESCO"]==16 ) { ?>checked="checked"<?php } ?>>
                            <label for="16">No pariente</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>37. ¿De acuerdo con su cultura, pueblo o rasgos f&iacute;sicos ... es o se reconoce como:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p37_reconoce_como" value="1" <?php if( $respuestas[0]["PA1_GRP_ETNIC"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Ind&iacute;gena?</label>
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                            <label>1.1. ¿A cu&aacute;l pueblo ind&iacute;gena pertenece . . . ?</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">                        
                                <label>C&oacute;digo</label>
                                <input type="number" name="p37_codigo_pueblo_indigena" id="p37_codigo_pueblo_indigena" max=999 value="<?php echo $respuestas[0]["PA11_COD_ETNIA"]; ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">                        
                                <label>Nombre del pueblo</label>
                                <input type="text" name="p37_nombre_pueblo_indigena" id="p37_nombre_pueblo_indigena">
                            </div>
                            </fieldset>
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                            <label>1.2. ¿A cu&aacute;l clan pertenece . . . ?</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">                        
                                <label>C&oacute;digo</label>
                                <input type="number" max=99 name="p37_codigo_clan_indigena" id="p37_codigo_clan_indigena" value="<?php echo $respuestas[0]["PA12_CLAN"]; ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">                        
                                <label>Nombre del clan</label>
                                <input type="text" name="p37_nombre_clan_indigena" id="p37_nombre_clan_indigena">
                                <h6>Contin&uacute;e con la pregunta 38</h6>
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p37_reconoce_como" value="2" <?php if( $respuestas[0]["PA1_GRP_ETNIC"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Gitano(a) o Rrom?</label>
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                            <label>2.1. ¿A cu&aacute;l vitsa pertenece . . . ?</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">                        
                                <label>C&oacute;digo</label>
                                <input type="number" name="p37_codigo_vitsa" id="p37_codigo_vitsa" max=9 value="<?php echo $respuestas[0]["PA21_COD_VITSA"]; ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">                        
                                <label>Nombre de la vitsa</label>
                                <input type="text" name="p37_nombre_vitsa" id="p37_nombre_vitsa">
                            </div>
                            </fieldset>
                            <fieldset>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11">
                            <label>2.2. ¿A cu&aacute;l kumpania pertenece . . . ?</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">                        
                                <label>C&oacute;digo</label>
                                <input type="number" max=99 name="p37_codigo_kumpania" id="p37_codigo_kumpania" value="<?php echo $respuestas[0]["PA22_COD_KUMPA"]; ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">                        
                                <label>Nombre de la kumpania</label>
                                <input type="text" name="p37_nombre_kumpania" id="p37_nombre_kumpania">
                                <h6>Contin&uacute;e con la pregunta 38</h6>
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="p37_reconoce_como" value="3" <?php if( $respuestas[0]["PA1_GRP_ETNIC"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Raizal del Archipi&eacute;lago de San Andr&eacute;s, Providencia y Santa Catalina?</label><h6>Contin&uacute;e con la pregunta 38</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="p37_reconoce_como" value="4" <?php if( $respuestas[0]["PA1_GRP_ETNIC"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">Palenquero(a) de San Basilio?</label><h6>Contin&uacute;e con la pregunta 38</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="p37_reconoce_como" value="5" <?php if( $respuestas[0]["PA1_GRP_ETNIC"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">Negro(a), mulato(a), afrodescendiente,afrocolombiano(a)?</label><h6>Contin&uacute;e con la pregunta 39</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="radio" name="p37_reconoce_como" value="6" <?php if( $respuestas[0]["PA1_GRP_ETNIC"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Ning&uacute;n grupo &eacute;tnico</label><h6>Contin&uacute;e con la pregunta 39</h6>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>38. ¿ . . . habla la lengua nativa de su pueblo?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p38_lengua_nativa" value="1" <?php if( $respuestas[0]["PA_HABLA_LENG"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;</label>
                            <h6>Contin&uacute;e con la pregunta 38.1</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p38_lengua_nativa" value="2" <?php if( $respuestas[0]["PA_HABLA_LENG"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No</label>
                            <div class="form-group">
	                            <fieldset>
	                            <div class="col-xs-1 col-sm-1 col-md-1">
	                            </div>
	                            <div class="col-xs-11 col-sm-11 col-md-11">
	                            <label>2.1. ¿La entiende ?</label>
	                            </div>
	                            <div class="col-xs-2 col-sm-2 col-md-2">
	                            </div>
	                            <div class="col-xs-10 col-sm-10 col-md-10">                        
	                                <input type="radio" name="p38_entiende" value="1" <?php if( $respuestas[0]["PA1_ENTIENDE"]==1 ) { ?>checked="checked"<?php } ?>>
	                                <label for="2">S&iacute;</label>
	                            </div>
	                            <div class="col-xs-2 col-sm-2 col-md-2">
	                            </div>
	                            <div class="col-xs-10 col-sm-10 col-md-10">                        
	                                <input type="radio" name="p38_entiende" value="2" <?php if( $respuestas[0]["PA1_ENTIENDE"]==2 ) { ?>checked="checked"<?php } ?>>
	                                <label for="2">No</label>
	                            </div>
	                            </fieldset>
	                        </div>
                        </div>                      
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>38.1. ¿ . . . habla otra(s) lengua(s) nativa(s)?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p38-1_habla_lengua_nativa" value="1" <?php if( $respuestas[0]["PB_OTRAS_LENG"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11">
                                <label>¿Cu&aacute;ntas?</label>
                                <input type="number" max=99 name="p38-1_cuantas" id="1_cuantas" value="<?php echo $respuestas[0]["PB1_QOTRAS_LENG"]; ?>">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p38-1_habla_lengua_nativa" value="2" <?php if( $respuestas[0]["PB_OTRAS_LENG"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No</label>
                        </div>                      
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>39. ¿D&oacute;nde naci&oacute; . . . :</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p39_donde_nacio" value="1" <?php if( $respuestas[0]["PA_LUG_NAC"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">En este municipio?</label>
                            <h6>Contin&uacute;e con la pregunta 40</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p39_donde_nacio" value="2" <?php if( $respuestas[0]["PA_LUG_NAC"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">En otro municipio colombiano?</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo departamento</label>
                                    <input type="number" name="p39_codigo_departamento" id="p39_codigo_departamento" max=99 value="<?php echo $respuestas[0]["PA1_DPTO_NAC"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del departamento</label>
                                    <input type="text" name="p39_nombre_departamento" id="p39_nombre_departamento">
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo municipio</label>
                                    <input type="number" name="p39_codigo_municipio" id="p39_codigo_municipio" max=999 value="<?php echo $respuestas[0]["PA2_MPIO_NAC"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del municipio</label>
                                    <input type="text" name="p39_nombre_municipio" id="p39_nombre_municipio">
                                </div>                                
                            </fieldset>
                        </div>      
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p39_donde_nacio" value="3" <?php if( $respuestas[0]["PA_LUG_NAC"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">En otro pa&iacute;s?</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo pais</label>
                                    <input type="number" name="p39_codigo_pais" id="p39_codigo_pais" max=999 value="<?php echo $respuestas[0]["PA3_PAIS_NAC"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del pais</label>
                                    <input type="text" name="p39_nombre_pais" id="p39_nombre_pais">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h4><b>39.1 ¿En qu&eacute; a&ntilde;o lleg&oacute; a Colombia?</b></h4>
                                    <input type="number" name="p39-1_llego_colombia" id="p39-1_llego_colombia" max=2018 value="<?php echo $respuestas[0]["PA31_ANO_LLEGO"]; ?>">
                                </div>                                                        
                            </fieldset>
                        </div>                
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>40. ¿En d&oacute;nde viv&iacute;a . . . hace 5 a&ntilde;os:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p40_hace5_anios" value="1" <?php if( $respuestas[0]["PA_VIVIA_5ANOS"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">No hab&iacute;a nacido</label>
                            <h6>Contin&uacute;e con la pregunta 41</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p40_hace5_anios" value="2" <?php if( $respuestas[0]["PA_VIVIA_5ANOS"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">En este municipio?</label>
                            <h6>Contin&uacute;e con la pregunta 40.1</h6>
                        </div>      
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p40_hace5_anios" value="3" <?php if( $respuestas[0]["PA_VIVIA_5ANOS"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">En otro municipio colombiano?</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo departamento</label>
                                    <input type="number" name="p40_codigo_departamento" id="p40_codigo_departamento" max=99 value="<?php echo $respuestas[0]["PA1_DPTO_5ANOS"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del departamento</label>
                                    <input type="text" name="p40_nombre_departamento" id="p40_nombre_departamento">
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo municipio</label>
                                    <input type="number" name="p40_codigo_municipio" id="p40_codigo_municipio" max=999 value="<?php echo $respuestas[0]["PA2_MPIO_5ANOS"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del municipio</label>
                                    <input type="text" name="p40_nombre_municipio" id="p40_nombre_municipio">
                                    <h6>Contin&uacute;e con la pregunta 40.1</h6>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11">
                                    <h4><b>40.1 ¿Viv&iacute;a en:</b></h4>
                                </div>  
                                <div class="form-group">                                 
	                                <div class="col-xs-2 col-sm-2 col-md-2"> 
	                                </div>                    
	                                <div class="col-xs-10 col-sm-10 col-md-10"> 
	                                    <input type="radio" name="p40-1_vivia" value="1" <?php if( $respuestas[0]["PA21_CLASE_5ANOS"]==1 ) { ?>checked="checked"<?php } ?>>
	                                    <label for="1">La cabecera municipal? (donde est&aacute; la alcald&iacute;a)</label>
	                                    <h6>Contin&uacute;e con la pregunta 41</h6>
	                                </div>
	                                <div class="col-xs-2 col-sm-2 col-md-2"> 
	                                </div>                    
	                                <div class="col-xs-10 col-sm-10 col-md-10"> 
	                                    <input type="radio" name="p40-1_vivia" value="2" <?php if( $respuestas[0]["PA21_CLASE_5ANOS"]==2 ) { ?>checked="checked"<?php } ?>>
	                                    <label for="2">Un centro poblado? (corregimiento municipal, inspecci&oacute;n de polic&iacute;a, caser&iacute;o)</label>
	                                    <h6>Contin&uacute;e con la pregunta 41</h6>
	                                </div>
	                                <div class="col-xs-2 col-sm-2 col-md-2"> 
	                                </div>                    
	                                <div class="col-xs-10 col-sm-10 col-md-10"> 
	                                    <input type="radio" name="p40-1_vivia" value="3" <?php if( $respuestas[0]["PA21_CLASE_5ANOS"]==3 ) { ?>checked="checked"<?php } ?>>
	                                    <label for="3">El rural disperso? (vereda, campo, resguardo, territorio colectivo</label>
	                                    <h6>Contin&uacute;e con la pregunta 41</h6>
	                                </div>
                                </div>
                            </fieldset>
                        </div>      
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p40_hace5_anios" value="4" <?php if( $respuestas[0]["PA_VIVIA_5ANOS"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">En otro pa&iacute;s?</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo pais</label>
                                    <input type="number" name="p40_codigo_pais" id="p40_codigo_pais" max=999 value="<?php echo $respuestas[0]["PA3_PAIS_5ANO"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del pais</label>
                                    <input type="text" name="p40_nombre_pais" id="p40_nombre_pais">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h4><b>40.2 ¿En qu&eacute; a&ntilde;o lleg&oacute; a Colombia?</b></h4>
                                    <input type="number" name="p40-2_llego_colombia" id="p40-2_llego_colombia" max=2018 value="<?php echo $respuestas[0]["PA31_ANO_LLEGA5"]; ?>">
                                </div>                                                        
                            </fieldset>
                        </div>          
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>41. ¿En d&oacute;nde viv&iacute;a . . . hace 12 meses:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p41_hace12_meses" value="1" <?php if( $respuestas[0]["PA_VIVIA_1ANO"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">No hab&iacute;a nacido</label>
                            <h6>Contin&uacute;e con la pregunta 42</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p41_hace12_meses" value="2" <?php if( $respuestas[0]["PA_VIVIA_1ANO"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">En este municipio?</label>
                            <h6>Contin&uacute;e con la pregunta 41.1</h6>
                        </div>      
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p41_hace12_meses" value="3" <?php if( $respuestas[0]["PA_VIVIA_1ANO"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">En otro municipio colombiano?</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo departamento</label>
                                    <input type="number" name="p41_codigo_departamento" id="p41_codigo_departamento" max=99 value="<?php echo $respuestas[0]["PA1_DPTO_1ANO"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del departamento</label>
                                    <input type="text" name="p41_nombre_departamento" id="p41_nombre_departamento">
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo municipio</label>
                                    <input type="number" name="p41_codigo_municipio" id="p41_codigo_municipio" max=999 value="<?php echo $respuestas[0]["PA2_MPIO_1ANO"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del municipio</label>
                                    <input type="text" name="p41_nombre_municipio" id="p41_nombre_municipio">
                                    <h6>Contin&uacute;e con la pregunta 41.1</h6>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11">
                                    <h4><b>41.1 ¿Viv&iacute;a en:</b></h4>
                                </div>                                   
                                <div class="form-group">
	                                <div class="col-xs-2 col-sm-2 col-md-2"> 
	                                </div>                    
	                                <div class="col-xs-10 col-sm-10 col-md-10"> 
	                                    <input type="radio" name="p41-1_vivia" value="1" <?php if( $respuestas[0]["PA21_CLASE_1ANO"]==1 ) { ?>checked="checked"<?php } ?>>
	                                    <label for="1">La cabecera municipal? (donde est&aacute; la alcald&iacute;a)</label>
	                                    <h6>Contin&uacute;e con la pregunta 41</h6>
	                                </div>
	                                <div class="col-xs-2 col-sm-2 col-md-2"> 
	                                </div>                    
	                                <div class="col-xs-10 col-sm-10 col-md-10"> 
	                                    <input type="radio" name="p41-1_vivia" value="2" <?php if( $respuestas[0]["PA21_CLASE_1ANO"]==2 ) { ?>checked="checked"<?php } ?>>
	                                    <label for="2">Un centro poblado? (corregimiento municipal, inspecci&oacute;n de polic&iacute;a, caser&iacute;o)</label>
	                                    <h6>Contin&uacute;e con la pregunta 41</h6>
	                                </div>
	                                <div class="col-xs-2 col-sm-2 col-md-2"> 
	                                </div>                    
	                                <div class="col-xs-10 col-sm-10 col-md-10"> 
	                                    <input type="radio" name="p41-1_vivia" value="3" <?php if( $respuestas[0]["PA21_CLASE_1ANO"]==3 ) { ?>checked="checked"<?php } ?>>
	                                    <label for="3">El rural disperso? (vereda, campo, resguardo, territorio colectivo</label>
	                                    <h6>Contin&uacute;e con la pregunta 41</h6>
	                                </div>
                                </div>
                            </fieldset>
                        </div>      
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p41_hace12_meses" value="4" <?php if( $respuestas[0]["PA_VIVIA_1ANO"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">En otro pa&iacute;s?</label>
                            <fieldset>
                                <div class="col-xs-1 col-sm-1 col-md-1">                        
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">                        
                                    <label>C&oacute;digo pais</label>
                                    <input type="number" name="p41_codigo_pais" id="p41_codigo_pais" max=999 value="<?php echo $respuestas[0]["PA3_PAIS_1ANO"]; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">                        
                                    <label>Nombre del pais</label>
                                    <input type="text" name="p41_nombre_pais" id="p41_nombre_pais">
                                </div>                                                       
                            </fieldset>
                        </div>          
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>42. ¿En los &uacute;ltimos 30 d&iacute;as, tuvo . . . alguna enfermedad, accidente, problema odontol&oacute;gico o alg&uacute;n otro problema de salud que no haya implicado hospitalizaci&oacute;n?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p42_enfermedad" value="1" <?php if( $respuestas[0]["P_ENFERMO"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p42_enfermedad" value="2" <?php if( $respuestas[0]["P_ENFERMO"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No</label>
                            <h6>Contin&uacute;e con la pregunta 44</h6>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>43. Para tratar ese problema de salud, ¿... qu&eacute; hizo principalmente:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="1" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Acudi&oacute; a la entidad de seguridad social en salud a la cual est&aacute; afiliado(a)?</label>
                            <div class="form-group">
	                            <fieldset>
	                                <div class="col-xs-1 col-sm-1 col-md-1">   
	                                </div>
	                                <div class="col-xs-11 col-sm-11 col-md-11">
	                                	<h4><b>43.1 ¿Lo atendieron?</b></h4>                        
	                                </div>
	                                <div class="col-xs-2 col-sm-2 col-md-2">  
	                                </div>
	                                <div class="col-xs-10 col-sm-10 col-md-10">   
	                                	<input type="radio" name="p43-1_atendieron" value="1" <?php if( $respuestas[0]["PA_LO_ATENDIERON"]==1 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="1">S&iacute;</label>  
	                            		<div class="form-group">                   
		                            		<fieldset>
		                            			<div class="col-xs-3 col-sm-3 col-md-3">  
				                                </div>
				                                <div class="col-xs-9 col-sm-9 col-md-9">   
				                              		<h4><b>43.2 En general considera que la calidad de la prestaci&oacute;n del servicio de salud recibido fue: </b></h4>
				                                </div>
				                                <div class="col-xs-4 col-sm-4 col-md-4">  
				                                </div>
				                                <div class="col-xs-8 col-sm-8 col-md-8">   
				                              		<input type="radio" name="p43-2_calidad_servicio" value="1" <?php if( $respuestas[0]["PA1_CALIDAD_SERV"]==1 ) { ?>checked="checked"<?php } ?>>
		                            				<label for="1">Muy bueno</label>                     
				                                </div>	
				                                <div class="col-xs-4 col-sm-4 col-md-4">  
				                                </div>
				                                <div class="col-xs-8 col-sm-8 col-md-8">   
				                              		<input type="radio" name="p43-2_calidad_servicio" value="2" <?php if( $respuestas[0]["PA1_CALIDAD_SERV"]==2 ) { ?>checked="checked"<?php } ?>>
		                            				<label for="2">Bueno</label>                     
				                                </div>	
				                                <div class="col-xs-4 col-sm-4 col-md-4">  
				                                </div>
				                                <div class="col-xs-8 col-sm-8 col-md-8">   
				                              		<input type="radio" name="p43-2_calidad_servicio" value="3" <?php if( $respuestas[0]["PA1_CALIDAD_SERV"]==3 ) { ?>checked="checked"<?php } ?>>
		                            				<label for="3">Malo</label>                     
				                                </div>
				                                <div class="col-xs-4 col-sm-4 col-md-4">  
				                                </div>
				                                <div class="col-xs-8 col-sm-8 col-md-8">   
				                              		<input type="radio" name="p43-2_calidad_servicio" value="4" <?php if( $respuestas[0]["PA1_CALIDAD_SERV"]==4 ) { ?>checked="checked"<?php } ?>>
		                            				<label for="4">Muy Malo</label>                     
				                                </div>	
		                            		</fieldset>
		                            	</div>
	                                </div>
	                                <div class="col-xs-2 col-sm-2 col-md-2">  
	                                </div>
	                                <div class="col-xs-10 col-sm-10 col-md-10">   
	                                	<input type="radio" name="p43-1_atendieron" value="2" <?php if( $respuestas[0]["PA_LO_ATENDIERON"]==2 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="2">No</label>                     
	                                </div>
	                            </fieldset>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="2" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Acudi&oacute; a un m&eacute;dico particular? (general, especialista, odont&oacute;logo, terapeuta u otro)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="3" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Acudi&oacute; a un boticario, farmac&eacute;uta, droguista?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="4" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">Asisti&oacute; a terapias alternativas? (acupuntura, esencias florales, musicoterapias, home&oacute;pata, etc.)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="5" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">Acudi&oacute; a una autoridad ind&iacute;gena espiritual?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="6" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Acudi&oacute; a otro m&eacute;dico de un grupo &eacute;tnico? (curandero, yerbatero, etc.)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="7" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">Us&oacute; remedios caseros?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="8" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==8 ) { ?>checked="checked"<?php } ?>>
                            <label for="8">Se autorrecet&oacute;?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p43_tratar_enfermedad" value="9" <?php if( $respuestas[0]["P_QUEHIZO_PPAL"]==9 ) { ?>checked="checked"<?php } ?>>
                            <label for="9">No hizo nada</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>44. Dada su condici&oacute;n f&iacute;sica y mental, y sin ning&uacute;n tipo de ayuda, ¿ . . . En su vida diaria tiene dificultades para realizar actividades como: O&iacute;r, hablar, ver, mover su cuerpo, caminar, agarrar objetos con sus manos, entender, aprender o recordar, comer o vestirse por s&iacute; mismo e interactuar con los dem&aacute;s?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p44_tiene_dificultades" value="1" <?php if( $respuestas[0]["CONDICION_FISICA"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;</label>
                            <div class="form-group">
                            	<fieldset>
                            		<div class="col-xs-1 col-sm-1 col-md-1">                        
                            		</div>
                            		<div class="col-xs-11 col-sm-11 col-md-11">                        
                            			<h4><b>44.1 ¿Que actividades no puede o presenta dificultades para realizarlas:</b></h4>
                        			</div>
                        			<div class="col-xs-1 col-sm-1 col-md-1">                        
                            		</div>
                            		<div class="col-xs-11 col-sm-11 col-md-11">                        
                            			<table border="2" align="center">
                            				<th>Actividad</th>
                            				<th>No puede hacerlo</th>
                            				<th>S&iacute;, con mucha dificultad</th>
                            				<th>S&iacute;, con alguna dificultad</th>
                            				<th>Puede hacerlo sin dificultad</th>
                            				<tr>
                            					<td>1.O&iacute;r la voz o los sonidos?</td>
                            					<td><input type="radio" name="p44-1-1_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PA_OIR"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-1_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PA_OIR"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-1_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PA_OIR"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-1_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PA_OIR"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>2.Hablar o conversar?</td>
                            					<td><input type="radio" name="p44-1-2_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PB_HABLAR"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-2_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PB_HABLAR"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-2_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PB_HABLAR"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-2_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PB_HABLAR"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>3.Ver de cerca, de lejos o alrededor?</td>
                            					<td><input type="radio" name="p44-1-3_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PC_VER"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-3_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PC_VER"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-3_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PC_VER"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-3_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PC_VER"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>4.Mover el cuerpo, caminar o subir y bajar escaleras?</td>
                            					<td><input type="radio" name="p44-1-4_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PD_CAMINAR"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-4_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PD_CAMINAR"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-4_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PD_CAMINAR"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-4_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PD_CAMINAR"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>5.Agarrar o mover objetos con las manos?</td>
                            					<td><input type="radio" name="p44-1-5_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PE_COGER"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-5_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PE_COGER"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-5_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PE_COGER"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-5_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PE_COGER"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>6.Entender, aprender, recordar o tomar decisiones por s&iacute; mismo(a)?</td>
                            					<td><input type="radio" name="p44-1-6_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PF_DECIDIR"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-6_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PF_DECIDIR"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-6_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PF_DECIDIR"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-6_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PF_DECIDIR"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>7.Comer, vestirse o ba&ntilde;arse por s&iacute; mismo(a)?</td>
                            					<td><input type="radio" name="p44-1-7_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PG_COMER"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-7_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PG_COMER"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-7_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PG_COMER"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-7_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PG_COMER"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>8.Relacionarse o interactuar con las dem&aacute;s personas?</td>
                            					<td><input type="radio" name="p44-1-8_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PH_RELACION"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-8_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PH_RELACION"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-8_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PH_RELACION"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-8_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PH_RELACION"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            				<tr>
                            					<td>9.Hacer las actividades diarias sin presentar problemas cardiacos, respiratorios?</td>
                            					<td><input type="radio" name="p44-1-9_tiene_dificultades" value="1" 	<?php if( $respuestas[0]["PI_TAREAS"]==1 ) { ?> checked="checked"<?php } ?>>
                            					</td>
                            					<td><input type="radio" name="p44-1-9_tiene_dificultades" value="2" 	<?php if( $respuestas[0]["PI_TAREAS"]==2 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-9_tiene_dificultades" value="3" 	<?php if( $respuestas[0]["PI_TAREAS"]==3 ) { ?> checked="checked"<?php } ?>></td>
                            					<td><input type="radio" name="p44-1-9_tiene_dificultades" value="4" 	<?php if( $respuestas[0]["PI_TAREAS"]==4 ) { ?> checked="checked"<?php } ?>></td>
                            				</tr>
                            			</table>
                        			</div>
                            	</fieldset>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p44_tiene_dificultades" value="2" <?php if( $respuestas[0]["CONDICION_FISICA"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No</label>
                            <h6>- Si la persona es menor de 5 a&ntilde;os, contin&uacute;e con la pregunta 48</h6>
							<h6>- Si la persona tiene 5 a&ntilde;os o m&aacute;s, contin&uacute;e con la pregunta 49</h6>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>45. De las dificultades anteriores, ¿cu&aacute;l es la que m&aacute;s afecta el desempe&ntilde;o diario de . . . ?</b></h4>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="number" name="p45_mas_dificultad" id="p45_mas_dificultad" max=9 value="<?php echo $respuestas[0]["P_LIM_PPAL"]; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>46. ¿Esta dificultad de . . . fue ocasionada:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="1" <?php if( $respuestas[0]["P_CAUSA_LIM"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Porque naci&oacute; as&iacute;?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="2" <?php if( $respuestas[0]["P_CAUSA_LIM"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Por enfermedad?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="3" <?php if( $respuestas[0]["P_CAUSA_LIM"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Por accidente laboral o enfermedad profesional?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="4" <?php if( $respuestas[0]["P_CAUSA_LIM"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">Por otro tipo de accidente?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="5" <?php if( $respuestas[0]["P_CAUSA_LIM"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">Por edad avanzada?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="6" <?php if( $respuestas[0]["P_CAUSA_LIM"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Por el conflicto armado?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="7" <?php if( $respuestas[0]["P_CAUSA_LIM"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">Por violencia NO asociada al conflicto armado?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="8" <?php if( $respuestas[0]["P_CAUSA_LIM"]==8 ) { ?>checked="checked"<?php } ?>>
                            <label for="8">Por otra causa?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p46_ocasionada" value="9" <?php if( $respuestas[0]["P_CAUSA_LIM"]==9 ) { ?>checked="checked"<?php } ?>>
                            <label for="9">No sabe</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>47. ¿Para esta dificultad . . . utiliza de manera permanente:</b></h4>
                    <fieldset>
                    	<div class="form-group">
	                    	<div class="col-xs-6 col-sm-6 col-md-6">                        
	                    		Gafas, lentes, lupas, bastones, silla de ruedas, implantes cocleares, entre otras?
	                    	</div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-1_utiliza" value="1" <?php if( $respuestas[0]["PA_AYUDA_TEC"]==1 ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">Si&acute;</label>
	                        </div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-1_utiliza" value="2" <?php if( $respuestas[0]["PA_AYUDA_TEC"]==2 ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">No</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                    	<div class="col-xs-6 col-sm-6 col-md-6">                        
	                    		Ayuda de otras personas?
	                    	</div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-2_utiliza" value="1" <?php if( $respuestas[0]["PB_AYUDA_PERS"]==1 ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">Si&acute;</label>
	                        </div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-2_utiliza" value="2" <?php if( $respuestas[0]["PB_AYUDA_PERS"]==2 ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">No</label>
	                        </div>
	                    </div> 
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                    	<div class="col-xs-6 col-sm-6 col-md-6">                        
	                    		Medicamentos o terapias?
	                    	</div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-3_utiliza" value="1" <?php if( $respuestas[0]["PC_AYUDA_MED"]==1 ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">Si&acute;</label>
	                        </div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-3_utiliza" value="2" <?php if( $respuestas[0]["PC_AYUDA_MED"]==2 ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">No</label>
	                        </div>
	                    </div>  
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                    	<div class="col-xs-6 col-sm-6 col-md-6">                        
	                    		Pr&aacute;cticas de medicina ancestral?
	                    	</div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-4_utiliza" value="1" <?php if( $respuestas[0]["PD_AYUDA_ANCES"]==1 ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">Si&acute;</label>
	                        </div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p47-4_utiliza" value="2" <?php if( $respuestas[0]["PD_AYUDA_ANCES"]==2 ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">No</label>
	                        </div>
	                    </div>                                             
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                	<h3><b>Para menores de 5 a&ntilde;os</b></h3>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>48. ¿D&oacute;nde o con qui&eacute;n permanece . . . durante la mayor parte del tiempo entre semana:</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p48_permanece" value="1" <?php if( $respuestas[0]["P_CUIDA"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Asiste a un hogar comunitario, jard&iacute;n, centro de desarrollo infantil o colegio? (por lo menos 3 d&iacute;as a la semana, y m&iacute;nimo 2 horas al d&iacute;a)</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p48_permanece" value="2" <?php if( $respuestas[0]["P_CUIDA"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Con su padre o madre en la vivienda?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p48_permanece" value="3" <?php if( $respuestas[0]["P_CUIDA"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Con su padre o madre en el trabajo?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p48_permanece" value="4" <?php if( $respuestas[0]["P_CUIDA"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">En la vivienda donde vive el ni&ntilde;o(a), al cuidado de un pariente o persona de 18 a&ntilde;os o m&aacute;s?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p48_permanece" value="5" <?php if( $respuestas[0]["P_CUIDA"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">En la vivienda donde vive el ni&ntilde;o(a), al cuidado de un pariente o persona menor de 18 a&ntilde;os?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p48_permanece" value="6" <?php if( $respuestas[0]["P_CUIDA"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Al cuidado de un pariente o de otra persona en otro lugar?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p48_permanece" value="7" <?php if( $respuestas[0]["P_CUIDA"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">En la vivienda, solo?</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                	<h3><b>Para personas de 5 a&ntilde;os o m&aacute;s</b></h3>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>49. ¿ . . . sabe leer y escribir?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p49_sabe" value="1" <?php if( $respuestas[0]["P_ALFABETA"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p49_sabe" value="2" <?php if( $respuestas[0]["P_ALFABETA"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>50. ¿Actualmente . . . asiste a alg&uacute;n preescolar, escuela, colegio o universidad, de forma presencial o virtual?</b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p50_asiste" value="1" <?php if( $respuestas[0]["PA_ASISTENCIA"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p50_asiste" value="2" <?php if( $respuestas[0]["PA_ASISTENCIA"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>51. ¿Cu&aacute;l es el nivel educativo m&aacute;s alto alcanzado por . . . y el &uacute;ltimo a&ntilde;o o grado aprobado en ese nivel?</b></h4>
                    <fieldset>
                    	<div class="form-group">
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>1.Preescolar</h4>
	                        </div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p51_nivel" value="prejardin" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="prejardin" ) { ?>checked="checked"<?php } ?>>
	                            <label for="prejardin">Prejardin</label>
	                        </div>
	                        <div class="col-xs-2 col-sm-2 col-md-2">                        
	                            <input type="radio" name="p51_nivel" value="jardin" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="jardin" ) { ?>checked="checked"<?php } ?>>
	                            <label for="jardin">Jardin</label>
	                        </div>
	                        <div class="col-xs-3 col-sm-3 col-md-3">                        
	                            <input type="radio" name="p51_nivel" value="Transicion" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="transicion" ) { ?>checked="checked"<?php } ?>>
	                            <label for="transicion">Transicion</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>2.B&aacute;sica primaria</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="1" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="1" ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">1</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="2" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="2" ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">2</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="3" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="3" ) { ?>checked="checked"<?php } ?>>
	                            <label for="3">3</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="4" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="4" ) { ?>checked="checked"<?php } ?>>
	                            <label for="4">4</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="5" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="5" ) { ?>checked="checked"<?php } ?>>
	                            <label for="5">5</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>3.B&aacute;sica secundaria (Bachillerato b&aacute;sico)</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="6" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="6" ) { ?>checked="checked"<?php } ?>>
	                            <label for="6">6</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="7" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="7" ) { ?>checked="checked"<?php } ?>>
	                            <label for="7">7</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="8" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="8" ) { ?>checked="checked"<?php } ?>>
	                            <label for="8">8</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="9" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="9" ) { ?>checked="checked"<?php } ?>>
	                            <label for="9">9</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>4.Media acad&eacute;mica o cl&aacute;sica (Bachillerato cl&aacute;sico)</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="10" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="10" ) { ?>checked="checked"<?php } ?>>
	                            <label for="10">10</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="11" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="11" ) { ?>checked="checked"<?php } ?>>
	                            <label for="11">11</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>5.Media t&eacute;cnica (Bachillerato t&eacute;cnico)</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="10" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="10" ) { ?>checked="checked"<?php } ?>>
	                            <label for="10">10</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="11" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="11" ) { ?>checked="checked"<?php } ?>>
	                            <label for="11">11</label>
	                        </div>
	                    </div>
	                    <div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	<h3><b>SUPERIOR</b></h3>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>7.T&eacute;cnica Profesional</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="1" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="1" ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">1</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="2" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="2" ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">2</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="3" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="3" ) { ?>checked="checked"<?php } ?>>
	                            <label for="3">3</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>8.Tecnol&oacute;gica</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="1" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="1" ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">1</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="2" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="2" ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">2</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="3" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="3" ) { ?>checked="checked"<?php } ?>>
	                            <label for="3">3</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>9.Universitario</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="1" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="1" ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">1</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="2" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="2" ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">2</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="3" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="3" ) { ?>checked="checked"<?php } ?>>
	                            <label for="3">3</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="4" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="4" ) { ?>checked="checked"<?php } ?>>
	                            <label for="4">4</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="5" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="5" ) { ?>checked="checked"<?php } ?>>
	                            <label for="5">5</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="6" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="6" ) { ?>checked="checked"<?php } ?>>
	                            <label for="6">6</label>
	                        </div>
	                    </div>
	                    <div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	<h3><b>POSGRADO</b></h3>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>10.Especializaci&oacute;n</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="1" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="1" ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">1</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="2" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="2" ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">2</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>11.Maestr&iacute;a</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="1" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="1" ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">1</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="2" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="2" ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">2</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="3" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="3" ) { ?>checked="checked"<?php } ?>>
	                            <label for="3">3</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>12.Doctorado</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="1" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="1" ) { ?>checked="checked"<?php } ?>>
	                            <label for="1">1</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="2" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="2" ) { ?>checked="checked"<?php } ?>>
	                            <label for="2">2</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="3" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="3" ) { ?>checked="checked"<?php } ?>>
	                            <label for="3">3</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="4" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="4" ) { ?>checked="checked"<?php } ?>>
	                            <label for="4">4</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="5" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="5" ) { ?>checked="checked"<?php } ?>>
	                            <label for="5">5</label>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="6" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="6" ) { ?>checked="checked"<?php } ?>>
	                            <label for="6">6</label>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	<div class="col-xs-12 col-sm-12 col-md-12">                        
	                    	</div>
	                        <div class="col-xs-4 col-sm-4 col-md-4">                        
	                        	<h4>13.Ninguno</h4>
	                        </div>
	                        <div class="col-xs-1 col-sm-1 col-md-1">                        
	                            <input type="radio" name="p51_nivel" value="0" <?php if( $respuestas[0]["P_NIVEL_ANOS"]=="0" ) { ?>checked="checked"<?php } ?>>
	                            <label for="0">0</label>
	                        </div>
	                    </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                	<h3><b>Para personas de 10 a&ntilde;os o m&aacute;s</b></h3>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>52. ¿Durante la semana pasada . . . : </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="1" <?php if( $respuestas[0]["P_TRABAJO"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Trabaj&oacute; por lo menos una hora en una actividad que le gener&oacute; alg&uacute;n ingreso?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="2" <?php if( $respuestas[0]["P_TRABAJO"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Trabaj&oacute; o ayud&oacute; en un negocio por lo menos una hora sin que le pagaran?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="3" <?php if( $respuestas[0]["P_TRABAJO"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">No trabaj&oacute;, pero ten&iacute;a un empleo, trabajo o negocio por el que recibe ingresos?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="4" <?php if( $respuestas[0]["P_TRABAJO"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">Busc&oacute; trabajo?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="5" <?php if( $respuestas[0]["P_TRABAJO"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">Vivi&oacute; de jubilaci&oacute;n, pensi&oacute;n o renta?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="6" <?php if( $respuestas[0]["P_TRABAJO"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Estudi&oacute;?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="7" <?php if( $respuestas[0]["P_TRABAJO"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">Realiz&oacute; oficios del hogar?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="8" <?php if( $respuestas[0]["P_TRABAJO"]==8 ) { ?>checked="checked"<?php } ?>>
                            <label for="8">Es incapacitado(a) permanentemente para trabajar?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p52_semana" value="9" <?php if( $respuestas[0]["P_TRABAJO"]==9 ) { ?>checked="checked"<?php } ?>>
                            <label for="9">Estuvo en otra situaci&oacute;n?</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>53. ¿Actualmente el estado civil de . . . es: </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p53_estado_civil" value="1" <?php if( $respuestas[0]["P_EST_CIVIL"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">Uni&oacute;n libre?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p53_estado_civil" value="2" <?php if( $respuestas[0]["P_EST_CIVIL"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">Casado(a)?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p53_estado_civil" value="3" <?php if( $respuestas[0]["P_EST_CIVIL"]==3 ) { ?>checked="checked"<?php } ?>>
                            <label for="3">Divorciado(a)?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p53_estado_civil" value="4" <?php if( $respuestas[0]["P_EST_CIVIL"]==4 ) { ?>checked="checked"<?php } ?>>
                            <label for="4">Separado(a) de uni&oacute;n libre?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p53_estado_civil" value="5" <?php if( $respuestas[0]["P_EST_CIVIL"]==5 ) { ?>checked="checked"<?php } ?>>
                            <label for="5">Separado(a) de matrimonio?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p53_estado_civil" value="6" <?php if( $respuestas[0]["P_EST_CIVIL"]==6 ) { ?>checked="checked"<?php } ?>>
                            <label for="6">Viudo(a)?</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p53_estado_civil" value="7" <?php if( $respuestas[0]["P_EST_CIVIL"]==7 ) { ?>checked="checked"<?php } ?>>
                            <label for="7">Soltero(a)?</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
      				<h3><b>Para mujeres de 10 a&ntilde;os o m&aacute;s</b></h3>          
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>54. ¿ . . . ha tenido alg&uacute;n hijo o hija que haya nacido vivo(a)? </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p54_hijos" value="1" <?php if( $respuestas[0]["PA_HNV"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;?</label>
                            <fieldset>
                            	<div class="col-xs-1 col-sm-1 col-md-1">                        
                            	</div>
                            	<div class="col-xs-3 col-sm-3 col-md-3">                      
                            		<label>¿Cu&aacute;ntos?</label>  
                            		 <input type="number" name="p54_cuantos" id="p54_cuantos" max="99" value="<?php echo $respuestas[0]["PA1_THNV"]; ?>">
                            	</div>
                            	<div class="col-xs-4 col-sm-4 col-md-4">                        
                            		<label>¿Cu&aacute;ntos hombres?</label>
                            		 <input type="number" name="p54_cuantosH" id="p54_cuantosH" max="99" value="<?php echo $respuestas[0]["PA2_HNVH"]; ?>">
                            	</div>
                            	<div class="col-xs-4 col-sm-4 col-md-4">   
                            		<label>¿Cu&aacute;ntas mujeres?</label>                     
                            		 <input type="number" name="p54_cuantosM" id="p54_cuantosM" max="99" value="<?php echo $respuestas[0]["PA3_HNVM"]; ?>">
                            	</div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p54_hijos" value="2" <?php if( $respuestas[0]["PA_HNV"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>55. De los hijos e hijas, que nacieron vivos(as), de . . . ¿cu&aacute;ntos est&aacute;n vivos actualmente? </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p55_hijos_vivos" value="1" <?php if( $respuestas[0]["PA_HNVS"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;?</label>
                            <fieldset>
                            	<div class="col-xs-1 col-sm-1 col-md-1">                        
                            	</div>
                            	<div class="col-xs-3 col-sm-3 col-md-3">                      
                            		<label>¿Cu&aacute;ntos?</label>  
                            		 <input type="number" name="p55_cuantos" id="p55_cuantos" max="99" value="<?php echo $respuestas[0]["PA1_THSV"]; ?>">
                            	</div>
                            	<div class="col-xs-4 col-sm-4 col-md-4">                        
                            		<label>¿Cu&aacute;ntos hombres?</label>
                            		 <input type="number" name="p55_cuantosH" id="p55_cuantosH" max="99" value="<?php echo $respuestas[0]["PA2_HSVH"]; ?>">
                            	</div>
                            	<div class="col-xs-4 col-sm-4 col-md-4">   
                            		<label>¿Cu&aacute;ntas mujeres?</label>                     
                            		 <input type="number" name="p55_cuantosM" id="p55_cuantosM" max="99" value="<?php echo $respuestas[0]["PA3_HSVM"]; ?>">
                            	</div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p55_hijos_vivos" value="2" <?php if( $respuestas[0]["PA_HNVS"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No sabe</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>56. ¿Cu&aacute;ntos de los hijos e hijas de . . . viven actualmente fuera de colombia? </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p56_hijos_fuera" value="1" <?php if( $respuestas[0]["PA_HFC"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;?</label>
                            <fieldset>
                            	<div class="col-xs-1 col-sm-1 col-md-1">                        
                            	</div>
                            	<div class="col-xs-3 col-sm-3 col-md-3">                      
                            		<label>¿Cu&aacute;ntos?</label>  
                            		 <input type="number" name="p56_cuantos" id="p56_cuantos" max="99" value="<?php echo $respuestas[0]["PA1_THFC"]; ?>">
                            	</div>
                            	<div class="col-xs-4 col-sm-4 col-md-4">                        
                            		<label>¿Cu&aacute;ntos hombres?</label>
                            		 <input type="number" name="p56_cuantosH" id="p56_cuantosH" max="99" value="<?php echo $respuestas[0]["PA2_HFCH"]; ?>">
                            	</div>
                            	<div class="col-xs-4 col-sm-4 col-md-4">   
                            		<label>¿Cu&aacute;ntas mujeres?</label>                     
                            		 <input type="number" name="p56_cuantosM" id="p56_cuantosM" max="99" value="<?php echo $respuestas[0]["PA3_HFCM"]; ?>">
                            	</div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p56_hijos_fuera" value="2" <?php if( $respuestas[0]["PA_HFC"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No sabe</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <h4><b>57. ¿Cu&aacute;l es el mes y el a&ntilde;o de nacimiento del &uacute;ltimo hijo o hija nacido(a) vivo(a) de . . . ? </b></h4>
                    <fieldset>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p57_sabe_mes" value="1" <?php if( $respuestas[0]["PA_UHNV"]==1 ) { ?>checked="checked"<?php } ?>>
                            <label for="1">S&iacute;?</label>
                            <div class="form-group">
	                            <fieldset>
	                            	<div class="col-xs-1 col-sm-1 col-md-1">  
	                            	</div>
	                            	<div class="col-xs-5 col-sm-5 col-md-5">  
	                            		<input type="radio" name="p57_mes" value="1" <?php if( $respuestas[0]["PA1_MES_UHNV"]==1 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="1">Enero</label>                      
	                            	</div>
	                            	<div class="col-xs-6 col-sm-6 col-md-6">              
	                            		<input type="radio" name="p57_mes" value="2" <?php if( $respuestas[0]["PA1_MES_UHNV"]==2 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="2">Febrero</label>
	                            	</div>
	                            
	                            
	                            	<div class="col-xs-1 col-sm-1 col-md-1">  
	                            	</div>
	                            	<div class="col-xs-5 col-sm-5 col-md-5">  
	                            		<input type="radio" name="p57_mes" value="3" <?php if( $respuestas[0]["PA1_MES_UHNV"]==3 ) { ?>checked="checked"<?php } ?>>
	                        			<label for="3">Marzo</label>                                           
	                            	</div>
	                            	<div class="col-xs-6 col-sm-6 col-md-6">              
	                            		<input type="radio" name="p57_mes" value="4" <?php if( $respuestas[0]["PA1_MES_UHNV"]==4 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="4">Abril</label>
	                            	</div>
	                            
	                            	<div class="col-xs-1 col-sm-1 col-md-1">  
	                            	</div>
	                            	<div class="col-xs-5 col-sm-5 col-md-5">  
	                            		<input type="radio" name="p57_mes" value="5" <?php if( $respuestas[0]["PA1_MES_UHNV"]==5 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="5">Mayo</label>                      
	                            	</div>
	                            	<div class="col-xs-6 col-sm-6 col-md-6">              
	                            		<input type="radio" name="p57_mes" value="6" <?php if( $respuestas[0]["PA1_MES_UHNV"]==6 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="6">Junio</label>
	                            	</div>
	                            
	                            	<div class="col-xs-1 col-sm-1 col-md-1">  
	                            	</div>
	                            	<div class="col-xs-5 col-sm-5 col-md-5">  
	                            		<input type="radio" name="p57_mes" value="7" <?php if( $respuestas[0]["PA1_MES_UHNV"]==7 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="7">Julio</label>                      
	                            	</div>
	                            	<div class="col-xs-6 col-sm-6 col-md-6">              
	                            		<input type="radio" name="p57_mes" value="8" <?php if( $respuestas[0]["PA1_MES_UHNV"]==8 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="8">Agosto</label>
	                            	</div>
	                            
	                            	<div class="col-xs-1 col-sm-1 col-md-1">  
	                            	</div>
	                            	<div class="col-xs-5 col-sm-5 col-md-5">  
	                            		<input type="radio" name="p57_mes" value="9" <?php if( $respuestas[0]["PA1_MES_UHNV"]==9 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="9">Septiembre</label>                      
	                            	</div>
	                            	<div class="col-xs-6 col-sm-6 col-md-6">              
	                            		<input type="radio" name="p57_mes" value="10" <?php if( $respuestas[0]["PA1_MES_UHNV"]==10 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="10">Octubre</label>
	                            	</div>
	                            
	                            	<div class="col-xs-1 col-sm-1 col-md-1">  
	                            	</div>
	                            	<div class="col-xs-5 col-sm-5 col-md-5">  
	                            		<input type="radio" name="p57_mes" value="11" <?php if( $respuestas[0]["PA1_MES_UHNV"]==11 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="11">Noviembre</label>                      
	                            	</div>
	                            	<div class="col-xs-6 col-sm-6 col-md-6">              
	                            		<input type="radio" name="p57_mes" value="12" <?php if( $respuestas[0]["PA1_MES_UHNV"]==12 ) { ?>checked="checked"<?php } ?>>
	                            		<label for="12">Diciembre</label>
	                            	</div>
	                            	
	                            	<div class="col-xs-1 col-sm-1 col-md-1">  
	                            	</div>
	                            	<div class="col-xs-11 col-sm-11 col-md-11">  
	                            		<label>A&ntilde;o</label>
	                            		<input type="number" name="p57_anio" id="p57_anio" max="2018" value="<?php echo $respuestas[0]["PA2_ANO_UHNV"]; ?>">                     
	                            	</div>
	                            </fieldset>
	                        </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">                        
                            <input type="radio" name="p57_sabe_mes" value="2" <?php if( $respuestas[0]["PA_UHNV"]==2 ) { ?>checked="checked"<?php } ?>>
                            <label for="2">No sabe</label>
                        </div>                        
                    </fieldset>
                </div>
            </div>




            <div class="row">
                <div class="form-group">
                    <input type="hidden" name="id_persona" value="<?php echo $id_persona; ?>" readonly>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <button type="submit" class="btn btn-dane-success">Guardar<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>   
                </div>
            </div>
        </form>
    </div>
</div>