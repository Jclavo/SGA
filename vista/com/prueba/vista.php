<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>claculadora en mvc </title>
        <link  href="vista/css/estilos.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script type="text/javascript"  src="vista/js/ajaxPost.js"></script>
        <script type="text/javascript"  src="vista/com/prueba/prueba.js"></script>

    </head>
    <body>
        <form action=" "  method="post" id="formulario" >   
            <label>nombre</label>
            <input name="nombre" type="text" value="" id="nombre"/><br>

            <label class="apellido">
                apellido</label><br> 
            <input name="apellido" type="text" value=""  id="apellidos"/><br><br>
            <!--los  botones  onclick    que me  llevan al  javascrip  al  ajax-->
            <input name="guardar" type="button"  onClick="grabar();" value="guadar" class="guardar" />
            <input name="guardar" type="button"  onClick="grabar2();" value="modificar" class="guardar" />		<!-- NO DEBO USAR 2 ID CON EL MISMO NOMBRE.... --->
            <input name="guardar" type="button"  onClick="grabar3();" value="eliminar" class="guardar" />
            <input name="modificar" id="modificar" type="hidden" value="modificar"/>
            <!--  gracias  a este campo oculto     que teine el id   de  modificar   logro     pasrale  parmetris  mejerjents de javascrip  aphp 
            -->
        </form>   
        <div id="carga"  align="center"> </div> 
        <div id="respuesta">      </div>
    </body>
</html>
