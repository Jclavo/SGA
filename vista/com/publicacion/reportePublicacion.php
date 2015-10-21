<?php
require_once '../../../util/Configuraciones.php'
?>

<html lang="en">
    <head>
        <!-- DataTables -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body >

        <div id="contenedorPublicaciones">

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

        <script type="text/javascript" src="<?php echo Configuraciones::URL_BASE ?>vista/com/publicacion/reportePublicacion.js"></script>

    </body>

</html>
