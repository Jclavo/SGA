<?php
require_once '../../../util/Configuraciones.php'
?>

<html lang="en">
    <head>
        <!-- DataTables -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

        <!--Select 2-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/select2/select2.css" rel="stylesheet" type="text/css"/>

        <!--datapicker-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>

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
                                <label  class="col-lg-2 control-label">Carrera</label>
                                <div class="col-lg-10">
                                    <select id="cboCarrera" class="select2" onchange="onChangeCboCarrera()">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Curso</label>
                                <div class="col-lg-10">
                                    <select id="cboCurso" class="select2" onchange="onChangeCboCurso()">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </form>   
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
                                    <th style='text-align:center;'>Alumno</th>
                                    <th style='text-align:center;'>Nota 1</th>
                                    <th style='text-align:center;'>Nota 2</th>
                                    <th style='text-align:center;'>Nota 2</th>
                                    <th style='text-align:center;'>Promedio</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTabla">
                            </tbody>
                        </table>

                    </div>
                </div>
                <div style="clear:right">
                    <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-info" onclick="guardarNotas()">Guardar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-success" onclick="obtenerPromedio()">Obtener Promedio</button>
                                </div>
                            </div>
                        </div>
                    </div>
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

        <!--datapicker-->
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/timepicker/bootstrap-datepicker.js"></script>
        <!--<script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/timepicker/locales/bootstrap-datepicker.es.js"></script>-->

        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/com/nota/IngresarNota.js"></script>

    </body>

</html>
