<?php if(isset($title1)) { ?>
<div class="row text-center">
    <div class="col-md-12">
        <h3><label><?=$title?></label></h3>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-12 text-center video-pb">
        <video width="700" controls preload="auto" poster="<?= base_url_images("videoFooter.png"); ?>">
            <source src="<?= base_url("assets/videos/tutorial.mp4"); ?>" type="video/mp4" />
            <source src="<?= base_url("assets/videos/tutorial.ogv"); ?>" type="video/ogv" />
            <source src="<?= base_url("assets/videos/tutorial.webm"); ?>" type="video/webm" />
        </video>
        <!--[if lt IE 9]>
            <OBJECT ID="MediaPlayer" CLASSID="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" STANDBY="Loading Windows Media Player components..." TYPE="application/x-oleobject">
                <PARAM NAME="FileName" VALUE="videos/video_plan-de-bienestar.mp4">
                <PARAM name="ShowControls" VALUE="true">
                <param name="ShowStatusBar" value="false">
                <PARAM name="ShowDisplay" VALUE="false">
                <PARAM name="autostart" VALUE="false">
                <PARAM name="poster" value="img/imagen-objetivos_video.png" src="img/imagen-objetivos_video.png" >

                <EMBED TYPE="application/x-mplayer2" SRC="videos/video_plan-de-bienestar.mp4" NAME="MediaPlayer" ShowControls="1" ShowStatusBar="0" ShowDisplay="0" autostart="0"> </EMBED>

            </OBJECT>
            <![endif] -->
    </div>
</div>
<?php if(isset($title1)) { ?>
<div class="row">
    <div class="col-md-12 text-center">
        <p><a href="<?=base_url("registro"); ?>">Regresar al registro de nuevo usuario</a></p>
    </div>
</div>
<?php } ?>