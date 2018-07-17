<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $title . ' - ' . $this->config->item("nombreSistema"); ?></title>
        <style type="text/css">
            body {
                background-color: #FFFFFF;
                height:100%; 
                margin:0;
                font-family:Helvetica, Arial, sans-serif;
                font-size:14pt;
            }
            table {
                border-collapse: collapse;
            }
            h3 {
                color: #268CA6;
                text-align:center;
            }
            #container{
                min-height:100%;
            }
            #content {
                margin:0 auto;
                position: relative;
                margin-bottom:702px;
            }
            #persona {
                font-weight: bold;
                position: absolute;
                text-align: center;
                top: 150pt;
                width: 100%;
            }
            /* estilos para el footer y el numero de pagina */
            @page { margin: 4mm 8mm 122mm 8mm; }
            #header {
                left: 0px;
                position: fixed;
                right: 0px;
                text-align: center;
                top: -2mm;
            }
            #footer {
                bottom: -2mm;
                /*height: 150px;*/
                left: 0px;
                position: fixed;
                right: 0px;
                text-align: center;
            }
            #footer .page:after {
                content: counter(page);
                text-align: center;
            }
        </style>
    </head>
    <body bgcolor="#ffffff">
        <!--header para cada pagina-->
        <div id="header">
            <?= $ecensoHeader; ?>
        </div>
        <!--footer para cada pagina-->
        <div id="footer">
            <?= $ecensoFooter; ?>
        </div>
        <div>
            <div id="persona">
                <h3><?=$nombrePersona?></h3>
                <h4>C&eacute;dula de Ciudadan&iacute;a No. <?=$cedula;?></h4>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <h4>Fecha de Expedici&oacute;n: <?=$expedicion;?></h4>
            <div>
        </div>
    </body>
</html>
