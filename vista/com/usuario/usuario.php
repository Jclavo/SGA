<?php
require_once '../../../util/Configuraciones.php'
?>

<html lang="en">
    <head>
        <!-- DataTables -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

        <!--Select 2-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/select2/select2.css" rel="stylesheet" type="text/css"/>

    </head>
    <body>
        <section class="panel">
            <header class="panel-heading">
                Registro
            </header>
            <div class="panel-body">
                <form class="form-horizontal" role="form">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">DNI</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="txtDni" maxlength="8">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Perfil</label>
                                <div class="col-lg-10">
                                    <select id="cboPerfilesUsuario" class="select2">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Contraseña</label>
                                                        <div class="col-lg-10">
                                                            <input type="password" class="form-control" id="txtClave" placeholder="Password">
                                                        </div>
                                                    </div>
                                                </div>-->
                    </div>
                    <br>
                </form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-info" onclick="validarDNIUsuario()">Validar datos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datatable</h3>
                </div>
                <div class="panel panel-body" >
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style='text-align:center;'>Código de identificacion</th>
                                    <th style='text-align:center;'>Perfil</th>
                                    <th style='text-align:center;'>Nombre</th>
                                    <th style='text-align:center;'>Edad</th>
                                    <th style='text-align:center;'>Sexo</th>
                                    <th style='text-align:center;'>Celular</th>
                                    <th style='text-align:center;'>Fecha Nacimiento</th>
                                    <th style='text-align:center;'>Carrera</th>
                                    <th style='text-align:center;'>Estado</th>
                                    <th style='text-align:center;'>Acciones</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
                <div style="clear:left">
                    <p><b>Leyenda:</b>&nbsp;&nbsp;
                        <i class="fa fa-check-circle" style="color:#5cb85c;"></i> Activo &nbsp;&nbsp;
                        <i class="fa fa-check-circle" style="color:#cb2a2a;"></i> Inactivo &nbsp;&nbsp;
                        <i class="fa fa-edit" style="color:#E8BA2F;"></i> Editar &nbsp;&nbsp;
                        <i class="fa fa-trash-o" style="color:#cb2a2a;"></i> Eliminar &nbsp;&nbsp;
                    </p>
                </div>

            </div>
        </section>

        <div class="modal fade" id="modalDatosUsuario" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Información usuario</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">DNI</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="txtDNIValidado" maxlength="50" readonly="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="inputPassword1" class="col-lg-2 control-label">Perfil</label>
                                    <div class="col-lg-10">
                                        <select id="cboPerfilValidado" class="select2">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nombres</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="txtNombre" maxlength="50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Apellido paterno</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="txtApellidoPaterno" maxlength="50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Apellido materno</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="txtApellidoMaterno" maxlength="50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Edad</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="txtEdad" maxlength="2">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword1" class="col-lg-2 control-label">Sexo</label>
                                    <div class="col-lg-10">
                                        <select class="select2" id="cboSexo">
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Celular</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="txtCelular" maxlength="50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Fecha nacimiento</label>
                                    <div class="col-lg-10">
                                        <input type="date" class="form-control" id="txtFechaNacimiento">
                                        <!--<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword1" class="col-lg-2 control-label">Estado</label>
                                    <div class="col-lg-10">
                                        <select class="select2" id="cboEstado">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="inputPassword1" class="col-lg-2 control-label">Carrera</label>
                                <div class="col-lg-10">
                                    <select id="cboCarrera" class="select2">
                                    </select>
                                </div>

                            </div>
                        </div>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-danger" type="button">Cerrar</button>
                        <button class="btn btn-info" type="button" onclick="agregarDatosUsuario()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ponemos nuestros scripts -->

        <!--datatables-->
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/dataTables.bootstrap.js"></script><!--
        -->
        <!--select 2-->
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/select2/select2.min.js"></script>

        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/com/usuario/usuario.js"></script>

    </body>

</html>
