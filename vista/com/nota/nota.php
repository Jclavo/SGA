<?php
require_once '../../../util/Configuraciones.php'
?>

<html lang="en">
    <head>
        <!-- DataTables -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
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
                                    <th style='text-align:center;'>Creditos</th>
                                    <th style='text-align:center;'>Ciclo</th>
                                    <th style='text-align:center;'>Promedio</th>
                                </tr>
                            </thead>
                        </table>

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

        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/com/nota/nota.js"></script>

    </body>

</html>
