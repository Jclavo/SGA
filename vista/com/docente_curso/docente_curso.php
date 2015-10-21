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
                <form id="formCurso" class="form-horizontal" role="form">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Docente</label>
                                <div class="col-lg-10">
                                    <select id="cboDocente" class="select2">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Carrera</label>
                                <div class="col-lg-10">
                                    <select id="cboCarrera" class="select2" onchange="onChangeCboCarrera()">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Curso</label>
                                <div class="col-lg-10">
                                    <select id="cboCurso" class="select2">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Año - Academico</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="txtAnioAcademico" maxlength="50" readonly="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Estado</label>
                                <div class="col-lg-10">
                                    <select id="cboEstado" class="select2">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                </form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-info" onclick="agregarDocenteCurso()">Guardar</button>
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
                                    <th style='text-align:center;'>Docente</th>
                                    <th style='text-align:center;'>Carrera</th>
                                    <th style='text-align:center;'>Curso</th>
                                    <th style='text-align:center;'>Año Academico</th>
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

        <!-- ponemos nuestros scripts -->

        <!--datatables-->
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/dataTables.bootstrap.js"></script><!--
        -->
        <!--select 2-->
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/select2/select2.min.js"></script>

        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/com/docente_curso/docente_curso.js"></script>

    </body>

</html>
