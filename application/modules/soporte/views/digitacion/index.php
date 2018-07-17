<?php
$msgSuccessFD = $this->session->flashdata('msgSuccess');
$msgErrorFD = $this->session->flashdata('msgError');
if(!empty($msgSuccessFD)) {
    $msgSuccess = $msgSuccessFD;
}
if(!empty($msgErrorFD)) {
    $msgError = $msgErrorFD;
}
?>

<div class="row" style="min-height: 460px">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading">
                Digitacion
            </div> -->
            <div class="panel-body">

                
                    <div class="container-btn-salir">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <a class="btn-salir" href="<?php echo base_url("login/salir"); ?>">SALIR</a>
                        </div>
                    </div>
                    <br><br><br>

                <div class="row">
                    <div class="col-xs-12" >
                        <button type="button" class="btn btn-success" aria-label="Left Align" data-toggle="modal" data-target="#modalAgregarEncuesta">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar encuesta
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div id="encuestas">
                        <table id="tbEncuestas" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Codigo Encuesta</th>
                                    <th>Número Formulario</th>
                                    <th>Estado Encuesta</th>
                                    <th>Ubicacion</th>
                                    <th>Vivienda</th>
                                    <th>Hogar</th>
                                    <th>Personas</th>
                                    <th>Diligenciar</th>
                                </tr>
                            </thead>

                        </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalAgregarEncuesta" tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" 
                                   data-dismiss="modal">
                                       <span aria-hidden="true">&times;</span>
                                       <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    AGREGAR ENCUESTA
                                </h4>
                            </div>
                            
                            <div class="modal-body">
                                <form role="form">
                                    <div class="form-group">
                                       <p>Por favor ingrese el número del formulario.</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="textNumformulario">Número de formulario</label>
                                        <div id="divNumformulario" class="input-group date">
                                            <input type="text" id="textNumformulario" name="textNumformulario" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div align="right">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                                        <button type="button" class="btn btn-primary" id="addEncuesta">AGREGAR</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- <div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                    </ul>

                    <div class="tab-content">
                        <br>
                        <div role="tabpanel" class="tab-pane active" id="home">home</div>
                        <div role="tabpanel" class="tab-pane" id="profile">profile</div>
                        <div role="tabpanel" class="tab-pane" id="messages">message</div>
                        <div role="tabpanel" class="tab-pane" id="settings">settings</div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

