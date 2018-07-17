<html>
    <head>
        <style type="text/css">
            body {
                font-family: Verdana, Arial, Helvetica, “Trebuchet MS”, Tahoma, Geneva, “Lucida Sans Unicode”, “Lucida Grande”, “MS Sans Serif”, sans-serif;
                font-size: 12px;
                font-weight: normal;
                line-height:16px;
            }
            p {
                line-height:16px;
                margin:0 0 10px;
            }
            #body{
                font-family: Verdana, Arial, Helvetica, “Trebuchet MS”, Tahoma, Geneva, “Lucida Sans Unicode”, “Lucida Grande”, “MS Sans Serif”, sans-serif;
                font-size: 12px;
                font-weight: normal;
                line-height:16px;
            }
        </style>
        <title><?php echo $nombreEntidad ?></title>
    </head>
    <body>
        <p><?php echo $fecha; ?></p>
        <p>
            Se&ntilde;or(a):<br/>
            <?php echo $nombreUsuario; ?><br/>
            Usuario - <?php echo $nombreSistema ?><br/>
        </p>


        <p><strong>¡Usted se ha eCensado!</strong></p>

        <p>El diligenciamiento del eCenso ha sido completado exitosamente.</p>

        <p>Recuerde que el código de diligenciamiento de su hogar es: <strogn><?php echo $codiEncuesta ?></strogn>. Esta información será requerida por el censista que visitará su vivienda para realizar la verificación y expedir su certificado censal.</p>

        <p>El DANE agradece su participación en la operación estadística más grande e innovadora en nuestra historia y valora inmensamente su contribución en la recolección de información estratégica que servirá para el progreso de todos.</p>

    </body>
</html>