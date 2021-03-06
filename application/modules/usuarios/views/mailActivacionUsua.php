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
        <title>Departamento Administrativo Nacional de Estad&iacute;stica - DANE</title>
    </head>
    <body>
        <p><?php echo $fecha; ?></p>
        <p>
            Se&ntilde;or(a):<br/>
            <?php echo $nombreUsuario; ?><br/>
            Usuario - Sistema de Control Interno Disciplinario<br/>
            La ciudad.
        </p>
        <p>Nos permitimos enviarle su usuario y contraseña de acceso a la aplicaci&oacute;n:
        </p>
        <p>
            <strong>Usuario:</strong> <?php echo $usuario; ?><br />
            <strong>Contrase&ntilde;a:</strong> <?php echo $password; ?>
        </p>
        <p>Para ingresar a la aplicación por favor haga clic en el siguiente enlace: <?php echo $baseURL; ?>.</p>
        <p>Muchas gracias por utilizar el Sistema de Control Interno Disciplinario.</p>
        <p>Este mensaje de correo electrónico ha sido enviado a <?php echo $email; ?>.</p>
        <p>Si tiene preguntas, inconvenientes o comentarios por favor escríbanos a <?php echo $correoContacto; ?>. Gracias!</p>
        <p>Este mensaje fue enviado de forma automática a través de nuestro sistema. Por favor, no responda este correo.</p>
        <br />
        <p><h6 style="color: gray;">Este mensaje de correo electrónico es propiedad del DANE, puede contener información privilegiada o confidencial. Por tanto, usar esta información y sus anexos para propósitos ajenos al DANE, divulgarla a personas a las cuales no se encuentre destinado este correo o reproducirla total o parcialmente, se encuentra prohibido en virtud de la legislación vigente. La Entidad no asumirá responsabilidad sobre información, opiniones o criterios contenidos en este correo que no estén directamente relacionados con el DANE. Si usted no es el destinatario autorizado o por error recibe este mensaje, por favor, borrarlo inmediatamente y notificar al remitente.</h6>
        <h6 style="color: gray;">This document is property of DANE; it may contain privileged confidential information. Therefore using this information and its annexes for purposes different from those of DANE, distributing said information to people who are not among those for which this email was intended, or reproducing it partially or totally is prohibited in accordance with the law available. The organization will not assume the responsibility around the information, opinions or criteria contained in this email, if not directly related to DANE. If you are not the authorized recipient, or you receive this message by mistake, please delete it immediately and notify to sender.</h6>
        <h6 style="color: gray;"><strong>No imprima este e-mail a menos que sea absolutamente necesario.</strong></h6></p>
    </body>
</html>