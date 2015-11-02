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

        <section class="panel" id="titulo">
            <header class="panel-heading">
                Registro
            </header>
            <div class="panel-body" >

                <div class="row" >

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

                        <button class="btn btn-success" onclick="agregarCursoHorario()">Agregar</button>

                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-success" onclick="aceptarMatricula()">Matricular</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel" id="resultado">
            <div class="row">
                <div class="col-lg-4">
                    <button class="btn btn-info" onclick="obtenerReporteMatricula()">Ver Matricula</button>
                </div> 
                <div class="col-lg-8">
                    <h2><p style="color: red;">TIENE 48 HORAS PARA PAGAR SU MATRICULA</p></h2>
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
                                    <th style='text-align:center;'>Curso</th>
                                    <th style='text-align:center;'>Ciclo</th>
                                    <th style='text-align:center;'>Creditos</th>
                                    <th style='text-align:center;'>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTabla">
                            </tbody>
                        </table>

                    </div>
                </div>
                <div style="clear:left">
                    <p><b>Leyenda:</b>&nbsp;&nbsp;
                        <i class="fa fa-trash-o" style="color:#cb2a2a;"></i> Eliminar &nbsp;&nbsp;
                    </p>
                </div>

            </div>
        </section>

        <!--modal para ver matricula-->
        <div class="modal fade" id="modalVerMatricula" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="parteAImprimir">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Información de Matricula</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <p>codigo</p>
                            </div>
                            <div class="col-sm-6">
                                <p id="codigo"></p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Alumno</p>
                            </div>
                            <div class="col-sm-6">
                                <p id="nombre"></p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Carrera</p>
                            </div>
                            <div class="col-sm-6">
                                <p id="carrera"></p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Anio Academico</p>
                            </div>
                            <div class="col-sm-6">
                                <p id="anio_academico"></p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Precio</p>
                            </div>
                            <div class="col-sm-6">
                                <p id="precio"></p>
                            </div>
                        </div>
                        <br>
                    </div>
                    <section class="panel">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Cursos Matriculados</h3>
                            </div>
                            <div class="panel panel-body" >
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatableReporteMatricula" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style='text-align:center;'>Curso</th>
                                                <th style='text-align:center;'>Creditos</th>
                                                <th style='text-align:center;'>Ciclo</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>



                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" onclick="imprimirMatricula()">Imprimir</button>
                        <button data-dismiss="modal" class="btn btn-danger" type="button">Cerrar</button>
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

        <!--datapicker-->
        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/timepicker/bootstrap-datepicker.js"></script>
        <!--<script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/timepicker/locales/bootstrap-datepicker.es.js"></script>-->

        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/com/matricula/matricula.js"></script>

    </body>

</html>
