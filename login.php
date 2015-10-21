<?php
require_once 'util/Configuraciones.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Login Sistema de Gestion Academica</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">

        <!-- font icon -->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/elegant-icons-style.css" rel="stylesheet" />
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/font-awesome.min.css" rel="stylesheet" />    

        <!--jquery-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/css/jquery-ui-1.10.4.min.css" rel="stylesheet">

        <!--notificaciones-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/notifications/notification.css" rel="stylesheet" />

        <!--Select 2-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/assets/select2/select2.css" rel="stylesheet" type="text/css"/>

        <!--estilos del login-->
        <link href="<?php echo Configuraciones::URL_BASE ?>vista/css/estilosLogin.css" rel="stylesheet">

    </head>
     
    <!--<body style="background-image: url(vista/imagenes/fondo_manuel_banda.jpg);" >-->
<body style="background-image: url(vista/imagenes/cole.png);" >
        <!--login modal-->
        <div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                        <h1 class="text-center">Inicio de sesión</h1>
                    </div>
                    <div class="modal-body">
                        <form class="form col-md-12 center-block">
                            <div class="form-group">
                                <label class="control-label">Codigo</label>
                                <input type="text" class="form-control input-lg" id="codigo" placeholder="Código" maxlength="8">
                            </div>
                            <div class="form-group">
                                <!--<label class="col-lg-2 control-label">Perfil</label>-->
                                <label class="control-label">Perfil</label>
                                <select id="cboPerfilesUsuario" class="form-control input-lg select2">
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="control-label">Contrasenha</label>
                                <input type="password" class="form-control input-lg" id="clave" placeholder="Contraseña">
                            </div>
                        </form>
                        <div class="form-group">
                            <button class="btn btn-primary btn-lg btn-block" onclick="iniciarSesion()">Ingresar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- script references -->
        <script src="vista/librerias/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
        <!--<script src="vista/librerias/bootstrap-3.3.5/js/bootstrap.min.js"></script>-->

        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/jquery.js"></script>
        <script src="<?php echo Configuraciones::URL_BASE ?>vista/librerias/plantilla/js/jquery-ui-1.10.4.min.js"></script>


        <!-- script para las notificaciones-->
        <script src="vista/librerias/plantilla/assets/notifications/notify.min.js"></script>
        <script src="vista/librerias/plantilla/assets/notifications/notify-metro.js"></script>
        <script src="vista/librerias/plantilla/assets/notifications/notifications.js"></script>

        <!--select 2-->
        <script type="text/javascript" src="vista/librerias/plantilla/assets/select2/select2.min.js"></script>


        <script>
                                var URL_BASE = "<?php echo Configuraciones::URL_BASE ?>";
        </script>

        <!--script personalizados-->
        <script type="text/javascript"  src="vista/js/ajaxPost.js"></script>
        <script type="text/javascript"  src="vista/js/mensajes.js"></script>
        <script type="text/javascript"  src="vista/js/util.js"></script>

        <script src="vista/login.js"></script>
        
    </body>
</html>